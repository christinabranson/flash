<?php

namespace App\Http\Controllers;

use App\Models\Courses\Course;
use App\Models\Quizzes\QuizSession;
use App\User;

class HistoryController extends Controller
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

        /** @var User $user */
        $user = auth()->user();

        $sessions = $user->sessions;

        $inProgressSessions = $sessions->filter(function ($session) {
            if ($session->status == QuizSession::STATUS_IN_PROGRESS) {
                return true;
            }
            return false;
        });

        $completedSessions = $sessions->filter(function ($session) {
            if ($session->status == QuizSession::STATUS_COMPLETED) {
                return true;
            }
            return false;
        });

        return view('history.index', compact("inProgressSessions", "completedSessions"));
    }
}
