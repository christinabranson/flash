<?php

namespace App\Models\Questions;

use App\Models\Base\BaseModel;

class Log extends BaseModel
{

    /**
     * PROPERTIES
     */

    protected $table = "questions_log";

    protected $fillable = [
        'user_id',
        'question_id',
        'course_id',
        'section_id',
        'is_correct',
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

    public function question() {
        return $this->belongsTo('App\Models\Questions\Question', 'id', 'question_id');
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
