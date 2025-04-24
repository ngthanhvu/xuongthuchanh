<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

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
            // Lấy ngữ cảnh cuộc trò chuyện từ session (nếu có)
            $conversationContext = Session::get('conversation_context', []);
            $conversationContext[] = ['role' => 'user', 'content' => $userMessage];
            Log::info('Current conversation context: ', $conversationContext);

            // Gọi Gemini để tạo phản hồi tư vấn
            $aiResponse = $this->getAIResponseFromGemini($conversationContext);
            Log::info('AI response: ' . $aiResponse);

            // Kiểm tra xem AI có yêu cầu đề xuất khóa học không
            if (stripos($aiResponse, '[PROPOSE_COURSES]') !== false) {
                $criteria = $this->extractCriteriaFromContext($conversationContext);
                $courses = $this->findCoursesByCriteria($criteria);
                $reply = str_replace('[PROPOSE_COURSES]', $this->formatCourseList($courses), $aiResponse);
            } else {
                $reply = $aiResponse;
            }

            // Cập nhật ngữ cảnh với phản hồi của AI
            $conversationContext[] = ['role' => 'assistant', 'content' => $reply];
            Session::put('conversation_context', $conversationContext);

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

    private function getAIResponseFromGemini($conversationContext)
    {
        $apiKey = env('GEMINI_API_KEY');
        $apiUrl = env('GEMINI_API_URL');

        $prompt = "Bạn là một trợ lý AI tư vấn học tập thân thiện, giao tiếp tự nhiên bằng tiếng Việt. Dựa trên cuộc trò chuyện sau:\n";
        foreach ($conversationContext as $entry) {
            $prompt .= ($entry['role'] === 'user' ? 'Người dùng: ' : 'Trợ lý: ') . $entry['content'] . "\n";
        }
        $prompt .= "Hãy đưa ra phản hồi tư vấn phù hợp. Nếu chưa đủ thông tin để đề xuất khóa học, hãy đặt câu hỏi để làm rõ (ví dụ: trình độ, mục tiêu, ngân sách). Khi đã đủ thông tin, kết thúc phản hồi bằng '[PROPOSE_COURSES]' để yêu cầu đề xuất khóa học. Không trả về JSON, chỉ trả về văn bản.";

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($apiUrl . '?key=' . $apiKey, [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ]
        ]);

        if ($response->failed()) {
            Log::error('Gemini API failed: ' . $response->body());
            throw new \Exception('Không thể kết nối với Gemini API: ' . $response->body());
        }

        $result = $response->json();
        $text = $result['candidates'][0]['content']['parts'][0]['text'] ?? 'Tôi không hiểu ý bạn, bạn có thể nói rõ hơn không?';
        return trim($text);
    }

    private function extractCriteriaFromContext($conversationContext)
    {
        $criteria = [
            'keywords' => [],
            'level' => null, // beginner, intermediate, advanced
            'goal' => null,  // web, app, data, etc.
            'budget' => null // free, paid, specific amount
        ];

        foreach ($conversationContext as $entry) {
            if ($entry['role'] === 'user') {
                $message = strtolower($entry['content']);
                // Trích xuất từ khóa
                $words = preg_split('/\s+/', $message);
                $keywords = array_filter($words, function ($word) {
                    return strlen($word) > 2 && !in_array($word, ['tôi', 'muốn', 'học', 'về', 'có', 'làm']);
                });
                $criteria['keywords'] = array_merge($criteria['keywords'], $keywords);

                // Trình độ
                if (preg_match('/(mới bắt đầu|cơ bản|beginner)/i', $message)) {
                    $criteria['level'] = 'beginner';
                } elseif (preg_match('/(nâng cao|advanced)/i', $message)) {
                    $criteria['level'] = 'advanced';
                } elseif (preg_match('/(trung cấp|intermediate)/i', $message)) {
                    $criteria['level'] = 'intermediate';
                }

                // Mục tiêu
                if (preg_match('/(web|trang web)/i', $message)) {
                    $criteria['goal'] = 'web';
                } elseif (preg_match('/(app|ứng dụng)/i', $message)) {
                    $criteria['goal'] = 'app';
                } elseif (preg_match('/(dữ liệu|data)/i', $message)) {
                    $criteria['goal'] = 'data';
                }

                // Ngân sách
                if (preg_match('/(miễn phí|free)/i', $message)) {
                    $criteria['budget'] = 'free';
                } elseif (preg_match('/(trả phí|paid)/i', $message)) {
                    $criteria['budget'] = 'paid';
                } elseif (preg_match('/(\d+)(k|vnd|đ)/i', $message, $matches)) {
                    $criteria['budget'] = (int)$matches[1] * ($matches[2] === 'k' ? 1000 : 1);
                }
            }
        }

        $criteria['keywords'] = array_unique($criteria['keywords']);
        Log::info('Extracted criteria from context: ', $criteria);
        return $criteria;
    }

    private function findCoursesByCriteria($criteria)
    {
        Log::info('Searching courses with criteria: ', $criteria);
        $query = Course::query();

        // Từ khóa
        if (!empty($criteria['keywords'])) {
            $query->where(function ($q) use ($criteria) {
                foreach ($criteria['keywords'] as $keyword) {
                    $searchTerm = str_replace(' ', '%', trim($keyword));
                    $q->orWhereRaw('LOWER(title) LIKE ?', ['%' . strtolower($searchTerm) . '%'])
                        ->orWhereRaw('LOWER(description) LIKE ?', ['%' . strtolower($searchTerm) . '%'])
                        ->orWhereHas('category', function ($q2) use ($searchTerm) {
                            $q2->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($searchTerm) . '%']);
                        });
                }
            });
        }

        // Trình độ (giả sử có cột 'level' trong bảng courses, nếu không thì bỏ qua hoặc điều chỉnh)
        if ($criteria['level']) {
            // Nếu bảng courses có cột 'level', thêm điều kiện
            // $query->where('level', $criteria['level']);
            // Hiện tại, giả sử tìm trong description
            $query->where('description', 'like', '%' . $criteria['level'] . '%');
        }

        // Mục tiêu (giả sử tìm trong description hoặc category)
        if ($criteria['goal']) {
            $query->where(function ($q) use ($criteria) {
                $q->where('description', 'like', '%' . $criteria['goal'] . '%')
                    ->orWhereHas('category', function ($q2) use ($criteria) {
                        $q2->where('name', 'like', '%' . $criteria['goal'] . '%');
                    });
            });
        }

        // Ngân sách
        if ($criteria['budget'] === 'free') {
            $query->where('is_free', 1);
        } elseif ($criteria['budget'] === 'paid') {
            $query->where('is_free', 0);
        } elseif (is_numeric($criteria['budget'])) {
            $query->where('price', '<=', $criteria['budget']);
        }

        $query->with('category');
        $sql = $query->toSql();
        $bindings = $query->getBindings();
        Log::info('Generated SQL query: ' . $sql, $bindings);

        $courses = $query->take(3)->get();
        Log::info('Found courses: ', $courses->toArray());
        return $courses;
    }

    private function formatCourseList($courses)
    {
        if ($courses->isEmpty()) {
            return "\nHiện tại tôi chưa tìm thấy khóa học nào phù hợp. Bạn có thể cung cấp thêm thông tin không?";
        }

        $list = "\nDưới đây là các khóa học phù hợp:\n";
        foreach ($courses as $index => $course) {
            $price = $course->is_free ? 'Miễn phí' : number_format($course->price) . ' VNĐ';
            $list .= sprintf(
                "%d. %s (%s) - %s\n   Xem chi tiết: /khoa-hoc/%d\n",
                $index + 1,
                $course->title,
                $course->category->name,
                $price,
                $course->id
            );
        }
        $list .= "Bạn muốn biết thêm về khóa học nào không?";
        return $list;
    }

    // Xóa ngữ cảnh khi cần (tùy chọn)
    public function resetChat()
    {
        Session::forget('conversation_context');
        return response()->json(['success' => true, 'reply' => 'Cuộc trò chuyện đã được làm mới!']);
    }
}