<?php

namespace App\Http\Controllers;

use App\Models\Courses\Course;
use App\Models\Courses\CourseSection;
use App\Models\Questions\Question;
use App\Models\Questions\QuestionAnswer;
use App\Models\Quizzes\Log;
use App\Models\Quizzes\QuizSession;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QuizController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->redirect('home');
    }

    public function take_course_quiz($id) {

        $course = Course::getByID($id);
        if (is_null($course)) {
            return redirect('home');
        }

        $questions = $course->questions()->get();
        if (empty($questions)) {
            return redirect('home');
        }

        /**
         * Get existing quiz session or create a new one
         */

        /** @var User $user */
        $user = auth()->user();

        /** @var QuizSession $quizSession */
        $quizSession = $user->sessions()->where("course_id", "=", $id)->whereNull("section_id")->where("status", "=", QuizSession::STATUS_IN_PROGRESS)->first();
        if (is_null($quizSession)) {
            $quizSession = $user->sessions()->create([
                "course_id" => $id,
                "sessionGUID" => (string) Str::uuid(),
                "status" =>  QuizSession::STATUS_IN_PROGRESS,
            ]);
        }

        return view('quizzes.start_course', compact("course", "questions", "quizSession"));
    }

    public function take_course_section_quiz($id) {

        $course_section = CourseSection::getByID($id);
        if (is_null($course_section)) {
            return redirect('home');
        }

        $questions = $course_section->questions()->get();
        if (empty($questions)) {
            return redirect('home');
        }

        /**
         * Get existing quiz session or create a new one
         */

        /** @var User $user */
        $user = auth()->user();

        /** @var QuizSession $quizSession */
        $quizSession = $user->sessions()->where("course_id", "=", $course_section->course_id)->where("section_id", "=", $course_section->id)->where("status", "=", QuizSession::STATUS_IN_PROGRESS)->first();
        if (is_null($quizSession)) {
            $quizSession = $user->sessions()->create([
                "course_id" => $course_section->course_id,
                "section_id" => $id,
                "sessionGUID" => (string) Str::uuid(),
                "status" =>  QuizSession::STATUS_IN_PROGRESS,
            ]);
        }

        $course = $course_section->course;

        return view('quizzes.start_course_section', compact("course_section", "course", "questions", "quizSession"));
    }

    public function next_question(Request $request) {
        $session_guid = $request->quiz_session_id;
        /** @var QuizSession $quizSession */
        $quizSession = QuizSession::query()->where("sessionGUID", "=", $session_guid)->first();
        if (empty($session_guid) || is_null($quizSession)) {
            /** @var User $user */
            $user = auth()->user();

            /** @var QuizSession $quizSession */
            $quizSession = $user->sessions()->where("status", "=", QuizSession::STATUS_IN_PROGRESS)->first();
        }

        if (is_null($quizSession)) {
            return redirect('home');
        }

        $numRemaining = $quizSession->getNumberOfRemainingQuestions();
        $question = $quizSession->getNextRandomQuestion();
        if (is_null($question)) {
            $quizSession->status = QuizSession::STATUS_COMPLETED;
            $quizSession->save();
            return redirect()->route("quiz.results", ["quiz_session_id" => $quizSession->sessionGUID]);
        }

        return view('quizzes.question', compact("question", "quizSession", "numRemaining"));
    }


    public function submit(Request $request) {
        /** @var User $user */
        $user = auth()->user();

        $session_guid = $request->quiz_session_id;
        /** @var QuizSession $quizSession */
        $quizSession = QuizSession::query()->where("sessionGUID", "=", $session_guid)->first();

        $question_id = $request->question_id;
        /** @var Question $question */
        $question = Question::getByID($question_id);

        $answer = $request->answer;

        $is_correct = false;


        if ($question->type == Question::TYPE_INPUT) {
            $answer_text = $answer;
            $answer = strtolower(trim($answer));
            $correct_answer = strtolower(trim($question->correct_answer));
            $correct_answer_text = $question->correct_answer;
            $correct_answer_id = null;
            if ($answer == $correct_answer) {
                $is_correct = true;
            }
        } else {
            $your_answer = QuestionAnswer::getByID($answer);
            $answer_text = $your_answer->answer;
            $correct_answer = $question->answers()->where("is_correct", "=", true)->first();
            $correct_answer_text = $correct_answer->answer;
            $correct_answer_id = $correct_answer->id;
            if ($answer == $correct_answer->id) {
                $is_correct = true;
            }
        }

        $log = $user->logs()->create([
            "session_id" => $quizSession->id,
            "course_id" => $quizSession->course_id,
            "section_id" => $quizSession->section_id,
            "question_id" => $question_id,
            "is_correct" => $is_correct,
            "provided_answer" => $answer_text,
            "correct_answer" => $correct_answer_text,
            "correct_answer_id" => $correct_answer_id,
        ]);

        $numRemaining = $quizSession->getNumberOfRemainingQuestions();
        if ($numRemaining <= 0) {
            $quizSession->status = QuizSession::STATUS_COMPLETED;
            $quizSession->save();
            $hasMore = false;
        } else {
            $hasMore = true;
        }


        return view('quizzes.result', compact("question", "quizSession", "log", "answer", "correct_answer", "correct_answer_text", "answer_text", "hasMore", "numRemaining"));
    }

    public function results(Request $request) {
        $session_guid = $request->quiz_session_id;
        $quizSession = QuizSession::query()->where("sessionGUID", "=", $session_guid)->first();

        if (is_null($quizSession)) {
            return redirect('home');
        }

        $logs = $quizSession->logs()->get();

        $totalCorrect = $quizSession->getNumberCorrect();

        return view('quizzes.results', compact("logs", "quizSession", "totalCorrect"));

    }
}
