<?php

namespace App\Models\Quizzes;

use App\Models\Base\BaseModel;
use App\Models\Courses\Course;
use App\Models\Courses\CourseSection;

class QuizSession extends BaseModel
{

    const STATUS_IN_PROGRESS = 1;
    const STATUS_COMPLETED = 2;

    public static $QUESTION_TYPES = array(
        QuizSession::STATUS_IN_PROGRESS => "In Progress",
        QuizSession::STATUS_COMPLETED => "Completed",
    );

    /**
     * PROPERTIES
     */

    protected $table = "quiz_sessions";

    protected $fillable = [
        'user_id',
        'course_id',
        'section_id',
        'sessionGUID',
        'status',
    ];

    /**
     * VALIDATION
     */

    /**
     * RELATIONSHIPS
     */

    public function user() {
        return $this->hasOne('App\User', 'user_id');
    }

    public function course() {
        return $this->hasOne('App\Models\Courses\Course', 'id', 'course_id');
    }

    public function section() {
        return $this->hasOne('App\Models\Courses\CourseSection', 'id', 'section_id');
    }


    public function logs() {
        return $this->hasMany('App\Models\Quizzes\Log', 'session_id');
    }

    /** @deprecated  */
    public function questions() {
        return $this->hasOne('App\Models\Quizzes\QuizSessionQuestions', 'id', 'session_id');
    }

    /**
     * METHODS
     */

    public function getNumberCorrect() {
        $logs = $this->logs;
        $totalCorrect = $logs->filter(function($log) {
            return $log->is_correct;
        })->count();
        return $totalCorrect;
    }

    public function getPercentageCorrect() {
        $logs = $this->logs;
        $totalCorrect = $logs->filter(function($log) {
            return $log->is_correct;
        })->count();
        return round( $totalCorrect / count($logs) * 100, 2);
    }

    public function getNumberOfRemainingQuestions() {
        $completedQuestions = $this->logs()->get()->pluck("question_id")->toArray();
        if ($this->section_id) {
            /** @var CourseSection $section */
            $section = $this->section;
            $allQuestions = $section->questions()->get()->pluck("id")->toArray();

            $questionsAvailable = array_diff($allQuestions, $completedQuestions);

            return count($questionsAvailable);
        } else {
            /** @var Course $course */
            $course = $this->course;
            $allQuestions = $course->questions()->get()->pluck("id")->toArray();

            $questionsAvailable = array_diff($allQuestions, $completedQuestions);

            return count($questionsAvailable);
        }

        return 0;
    }

    public function getNextRandomQuestion() {
        $completedQuestions = $this->logs()->get()->pluck("question_id")->toArray();
        if ($this->section_id) {
            /** @var CourseSection $section */
            $section = $this->section;
            $allQuestions = $section->questions()->get()->pluck("id")->toArray();

            $questionsAvailable = array_diff($allQuestions, $completedQuestions);

            return $section->questions()->whereIn("id", $questionsAvailable)->inRandomOrder()->first();
        } else {
            /** @var Course $course */
            $course = $this->course;
            $allQuestions = $course->questions()->get()->pluck("id")->toArray();

            $questionsAvailable = array_diff($allQuestions, $completedQuestions);

            return $course->questions()->whereIn("id", $questionsAvailable)->inRandomOrder()->first();
        }

        return null;
    }


    /**
     * STATIC METHODS
     */

}
