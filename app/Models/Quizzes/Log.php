<?php

namespace App\Models\Quizzes;

use App\Models\Base\BaseModel;

class Log extends BaseModel
{

    /**
     * PROPERTIES
     */

    protected $table = "questions_log";

    protected $fillable = [
        'user_id',
        'session_id',
        'question_id',
        'course_id',
        'section_id',
        'is_correct',
        'provided_answer',
        'correct_answer',
        'correct_answer_id',
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

    public function session() {
        return $this->belongsTo('App\Models\Quizzes\QuizSession', 'id', 'session_id');
    }

    public function question() {
        return $this->hasOne('App\Models\Questions\Question', 'id', 'question_id');
    }

    public function course() {
        return $this->belongsTo('App\Models\Courses\Course', 'id', 'course_id');
    }

    public function section() {
        return $this->belongsTo('App\Models\Courses\CourseSection', 'id', 'section_id');
    }

    /**
     * METHODS
     */

    /**
     * STATIC METHODS
     */

}
