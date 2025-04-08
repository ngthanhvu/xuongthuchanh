<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $userMessage = $request->input('message');
        Log::info('User message: ' . $userMessage);

        try {
            $keywords = $this->getKeywordsFromGemini($userMessage);
            Log::info('Keywords received: ', $keywords);

            $courses = $this->findCoursesByKeywords($keywords);
            Log::info('Courses found: ', $courses->toArray());

            $reply = $this->formatCourseReply($courses, $userMessage);
            Log::info('Reply sent: ' . $reply);

            return response()->json([
                'success' => true,
                'reply' => $reply,
            ]);
        } catch (\Exception $e) {
            Log::error('Error in chat with Gemini: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'reply' => 'Có lỗi xảy ra khi xử lý yêu cầu. Vui lòng thử lại!',
            ], 500);
        }
    }

    private function getKeywordsFromGemini($message)
    {
        $apiKey = "";
        $apiUrl = "";

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($apiUrl . '?key=' . $apiKey, [
            'contents' => [
                [
                    'parts' => [
                        [
                            'text' => "Dựa trên đầu vào sau, hãy suy ra các từ khóa liên quan đến khóa học lập trình hoặc chủ đề học tập và trả về dưới dạng JSON: '$message'. Nếu đầu vào ngắn hoặc không rõ, hãy cung cấp các từ khóa hợp lý dựa trên ngữ cảnh. Ví dụ: Nếu đầu vào là 'HTML', trả về {\"keywords\": [\"HTML\", \"web\", \"lập trình\"]}. Đảm bảo chỉ trả về JSON, không thêm văn bản thừa."
                        ]
                    ]
                ]
            ]
        ]);

        if ($response->failed()) {
            Log::error('Gemini API failed: ' . $response->body());
            throw new \Exception('Không thể kết nối với Gemini API: ' . $response->body());
        }

        $result = $response->json();
        Log::info('Gemini API raw response: ', $result);

        $jsonText = $result['candidates'][0]['content']['parts'][0]['text'] ?? '{}';
        Log::info('Gemini parsed JSON: ' . $jsonText);

        // Loại bỏ markdown (```json và ```) nếu có
        $jsonText = preg_replace('/```json\s*|\s*```/', '', $jsonText);
        $jsonText = trim($jsonText);
        Log::info('Cleaned JSON text: ' . $jsonText);

        // Phân tích JSON
        $parsed = json_decode($jsonText, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::warning('Invalid JSON from Gemini, attempting fallback: ' . $jsonText);
            $keywords = [$message]; // Fallback về đầu vào gốc nếu JSON không hợp lệ
        } else {
            $keywords = $parsed['keywords'] ?? [];
        }

        // Đảm bảo luôn có từ khóa
        if (empty($keywords)) {
            Log::info('No keywords extracted, using fallback: ' . $message);
            $keywords = [$message];
        }

        Log::info('Extracted keywords: ', $keywords);
        return $keywords;
    }

    private function findCoursesByKeywords(array $keywords)
    {
        Log::info('Searching courses with keywords: ', $keywords);
        if (empty($keywords)) {
            Log::info('No keywords provided, returning empty collection');
            return collect([]);
        }

        $query = Course::where(function ($query) use ($keywords) {
            foreach ($keywords as $keyword) {
                $searchTerm = str_replace(' ', '%', trim($keyword));
                Log::info('Building query for keyword: ' . $keyword . ' (search term: ' . $searchTerm . ')');
                $query->orWhere('title', 'like', '%' . $searchTerm . '%')
                    ->orWhere('description', 'like', '%' . $searchTerm . '%')
                    ->orWhereHas('category', function ($q) use ($searchTerm) {
                        $q->where('name', 'like', '%' . $searchTerm . '%');
                    });
            }
        })->with('category');

        // Log truy vấn SQL để kiểm tra
        $sql = $query->toSql();
        $bindings = $query->getBindings();
        Log::info('Generated SQL query: ' . $sql, $bindings);

        $courses = $query->take(3)->get();
        Log::info('Found courses: ', $courses->toArray());

        return $courses;
    }

    private function formatCourseReply($courses, $userMessage)
    {
        if ($courses->isEmpty()) {
            return "Không tìm thấy khóa học phù hợp với yêu cầu \"$userMessage\". Bạn có muốn thử với từ khóa khác không?";
        }

        $reply = "Dựa trên yêu cầu của bạn \"$userMessage\", tôi đề xuất các khóa học sau:\n";
        foreach ($courses as $index => $course) {
            $price = $course->is_free ? 'Miễn phí' : number_format($course->price) . ' VNĐ';
            $reply .= sprintf(
                "%d. %s (%s) - %s\n   Xem chi tiết: /khoa-hoc/%d\n",
                $index + 1,
                $course->title,
                $course->category->name,
                $price,
                $course->id
            );
        }
        $reply .= "Bạn có muốn biết thêm chi tiết về khóa học nào không?";

        return $reply;
    }
}
