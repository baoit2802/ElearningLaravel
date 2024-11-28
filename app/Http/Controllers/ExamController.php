<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Question;
use App\Models\Answer;
use App\Models\ExamResult;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    /**
     * Hiển thị danh sách bài thi cho admin.
     */
    public function index()
    {
        $exams = Exam::with('course')->get();
        return view('admin.exams.index', compact('exams'));
    }

    /**
     * Hiển thị form tạo bài thi.
     */
    public function create()
    {
        $courses = Course::all(); // Lấy danh sách khóa học
        return view('admin.exams.create', compact('courses'));
    }

    /**
     * Lưu bài thi mới.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'description' => 'nullable|string',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
            'duration' => 'required|integer|min:1',
        ]);

        Exam::create($request->all());

        return redirect()->route('admin.exams.index')->with('success', 'Bài thi đã được tạo thành công!');
    }

    /**
     * Hiển thị form chỉnh sửa bài thi.
     */
    public function edit($id)
    {
        $exam = Exam::findOrFail($id);
        $courses = Course::all();
        return view('admin.exams.edit', compact('exam', 'courses'));
    }

    /**
     * Cập nhật bài thi.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'description' => 'nullable|string',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
            'duration' => 'required|integer|min:1',
        ]);

        $exam = Exam::findOrFail($id);
        $exam->update($request->only(['title', 'course_id', 'description', 'start_time', 'end_time', 'duration']));

        return redirect()->route('admin.exams.index')->with('success', 'Bài thi đã được cập nhật thành công!');
    }

    /**
     * Xóa bài thi.
     */
    public function destroy($id)
    {
        $exam = Exam::findOrFail($id);
        $exam->delete();

        return redirect()->route('admin.exams.index')->with('success', 'Bài thi đã được xóa!');
    }

    /**
     * Quản lý câu hỏi của bài thi.
     */
    public function manageQuestions($id)
    {
        $exam = Exam::with('questions.answers')->findOrFail($id);
        return view('admin.exams.questions.index', compact('exam'));
    }

    /**
     * Thêm câu hỏi vào bài thi.
     */
    public function addQuestion(Request $request, $examId)
    {
        $exam = Exam::findOrFail($examId);

        $request->validate([
            'question_text' => 'required|string|max:255',
            'answers' => 'required|array|min:2|max:4',
            'answers.*' => 'required|string|max:255',
            'correct_answer' => 'required|integer|min:1|max:4',
        ]);

        $question = Question::create([
            'exam_id' => $exam->id,
            'question_text' => $request->input('question_text'),
        ]);

        foreach ($request->answers as $index => $answer) {
            Answer::create([
                'question_id' => $question->id,
                'answer_text' => $answer,
                'is_correct' => $index + 1 == $request->input('correct_answer'),
            ]);
        }

        return redirect()->back()->with('success', 'Câu hỏi đã được thêm!');
    }

    /**
     * Cập nhật câu hỏi.
     */
    public function updateQuestion(Request $request, $questionId)
    {
        $question = Question::findOrFail($questionId);
        $question->update([
            'question_text' => $request->input('question_text'),
        ]);

        foreach ($request->input('answers', []) as $answerId => $answerData) {
            $answer = Answer::findOrFail($answerId);
            $answer->update([
                'answer_text' => $answerData['answer_text'],
                'is_correct' => isset($answerData['is_correct']),
            ]);
        }

        return redirect()->back()->with('success', 'Cập nhật câu hỏi thành công!');
    }

    /**
     * Xóa câu hỏi.
     */
    public function deleteQuestion($id)
    {
        $question = Question::findOrFail($id);
        $question->answers()->delete();
        $question->delete();

        return redirect()->back()->with('success', 'Câu hỏi đã được xóa thành công!');
    }

    /**
     * Hiển thị danh sách bài thi cho người dùng đã đăng ký khóa học.
     */
    public function listExams()
    {
        $user = Auth::user();

        $registeredCourseIds = $user->courseRegistrations()
            ->where('status', 'paid')
            ->pluck('course_id');

        $exams = Exam::whereIn('course_id', $registeredCourseIds)->with('course')->get();

        return view('client.exams.list', compact('exams'));
    }

    /**
     * Hiển thị trang làm bài thi.
     */
    public function startExam(Request $request, Exam $exam)
    {
        $user = Auth::user();

        // Kiểm tra xem người dùng đã làm bài thi chưa
        $existingResult = ExamResult::where('exam_id', $exam->id)->where('user_id', $user->id)->first();

        if ($existingResult) {
            return view('client.exams.result', [
                'exam' => $exam,
                'score' => $existingResult->score,
                'totalQuestions' => $existingResult->total_questions,
                'message' => 'Bạn đã tham gia bài thi này trước đó.',
            ]);
        }

        // Lấy câu trả lời từ session
        $storedAnswers = $request->session()->get('exam_answers', []);

        // Lấy danh sách câu hỏi và phân trang
        $questions = $exam->questions()->paginate(5);

        return view('client.exams.start', compact('exam', 'questions', 'storedAnswers'));
    }

    public function saveProgress(Request $request, Exam $exam)
    {
        $storedAnswers = json_decode($request->input('answers'), true) ?: [];
        session(["exam_{$exam->id}_answers" => $storedAnswers]);
    }


    public function submitExam(Request $request, Exam $exam)
{
    $user = Auth::user();

    // Lấy câu trả lời từ form
    $storedAnswers = $request->input('answers', []);

    // Tính điểm
    $totalQuestions = $exam->questions->count();
    $correctAnswers = 0;

    // Tạo kết quả bài thi
    $examResult = ExamResult::create([
        'user_id' => $user->id,
        'exam_id' => $exam->id,
        'score' => 0, // Sẽ cập nhật sau
        'total_questions' => $totalQuestions,
        'created_at' => now(),
    ]);

    // Lưu câu trả lời của người dùng và tính điểm
    foreach ($exam->questions as $question) {
        $selectedAnswerId = $storedAnswers[$question->id] ?? null;

        if ($selectedAnswerId) {
            $isCorrect = $question->answers()
                ->where('id', $selectedAnswerId)
                ->where('is_correct', true)
                ->exists();

            if ($isCorrect) {
                $correctAnswers++;
            }

            // Lưu câu trả lời vào bảng user_answers
            $examResult->userAnswers()->create([
                'question_id' => $question->id,
                'answer_id' => $selectedAnswerId,
            ]);
        }
    }

    // Cập nhật điểm
    $examResult->update([
        'score' => $correctAnswers,
    ]);

    return view('client.exams.result', [
        'exam' => $exam,
        'score' => $examResult->score,
        'totalQuestions' => $examResult->total_questions,
        'message' => 'Chúc mừng bạn đã hoàn thành bài thi!',
    ]);
}


    public function results()
    {
        $results = ExamResult::with(['user', 'exam'])->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.exams.results.index', compact('results'));
    }

    // Xem chi tiết kết quả của một bài thi
    public function showResult($id)
{
    $result = ExamResult::with(['user', 'exam', 'userAnswers.question.answers'])->findOrFail($id);

    return view('admin.exams.results.show', compact('result'));
}

    // Xóa kết quả thi
    public function deleteResult($id)
    {
        $result = ExamResult::findOrFail($id);
        $result->delete();

        return redirect()->route('admin.exams.results.index')->with('success', 'Kết quả thi đã được xóa thành công.');
    }

}
