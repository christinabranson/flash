<?php

namespace App\Models\Quizzes;

use App\Models\Base\BaseModel;

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
        return $this->belongsTo('App\User', 'id', 'user_id');
    }

    public function course() {
        return $this->belongsTo('App\Models\Courses\Course', 'course_id');
    }

    public function section() {
        return $this->belongsTo('App\Models\Courses\CourseSection', 'id', 'section_id');
    }


    public function logs() {
        return $this->belongsTo('App\Models\Quizzes\Log', 'id', 'session_id');
    }

    /** @deprecated  */
    public function questions() {
        return $this->belongsTo('App\Models\Quizzes\QuizSessionQuestions', 'id', 'session_id');
    }

    /**
     * METHODS
     */

    /**
     * STATIC METHODS
     */

}
