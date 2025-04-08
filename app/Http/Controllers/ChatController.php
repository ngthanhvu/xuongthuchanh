<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Category;
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

        try {
            // Gửi tin nhắn đến Gemini API để lấy từ khóa
            $keywords = $this->getKeywordsFromGemini($userMessage);

            // Tìm khóa học dựa trên từ khóa
            $courses = $this->findCoursesByKeywords($keywords);

            // Tạo phản hồi với danh sách khóa học
            $reply = $this->formatCourseReply($courses, $userMessage);

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
        $apiKey = " ";
        $apiUrl = " ";

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($apiUrl . '?key=' . $apiKey, [
            'contents' => [
                [
                    'parts' => [
                        [
                            'text' => "Phân tích câu sau và trích xuất các từ khóa liên quan đến khóa học hoặc chủ đề học tập: '$message'. Trả về danh sách từ khóa dạng JSON: {\"keywords\": [\"keyword1\", \"keyword2\", ...]}"
                        ]
                    ]
                ]
            ]
        ]);

        if ($response->failed()) {
            throw new \Exception('Không thể kết nối với Gemini API: ' . $response->body());
        }

        $result = $response->json();
        $jsonText = $result['candidates'][0]['content']['parts'][0]['text'] ?? '{}';

        // Phân tích JSON từ phản hồi
        $parsed = json_decode($jsonText, true);
        return $parsed['keywords'] ?? [];
    }

    private function findCoursesByKeywords(array $keywords)
    {
        if (empty($keywords)) {
            return collect([]);
        }

        return Course::where(function ($query) use ($keywords) {
            foreach ($keywords as $keyword) {
                $query->orWhere('title', 'like', '%' . $keyword . '%')
                    ->orWhere('description', 'like', '%' . $keyword . '%')
                    ->orWhereHas('category', function ($q) use ($keyword) {
                        $q->where('name', 'like', '%' . $keyword . '%');
                    });
            }
        })->with('category')->take(3)->get();
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
                "%d. %s (%s) - %s\n   Xem chi tiết: /courses/%d\n",
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