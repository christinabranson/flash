<?php

namespace App\Models\Quizzes;

use App\Models\Base\BaseModel;

class QuizSessionQuestions extends BaseModel
{

    /**
     * PROPERTIES
     */

    protected $table = "quiz_session_questions";

    protected $fillable = [
        'session_id',
        'question_id',
    ];

    /**
     * VALIDATION
     */

    /**
     * RELATIONSHIPS
     */

    public function session() {
        return $this->belongsTo('App\Models\Quizzes\QuizSession', 'id', 'session_id');
    }


    /**
     * METHODS
     */

    /**
     * STATIC METHODS
     */

}
