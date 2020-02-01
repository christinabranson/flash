<?php

namespace App\Models\Questions;

use App\Models\Base\BaseModel;

class QuestionAnswer extends BaseModel
{

    /**
     * PROPERTIES
     */

    protected $table = "question_answers";

    protected $fillable = [
        'question_id',

        'answer',
        'is_correct',

    ];

    /**
     * VALIDATION
     */

    /**
     * RELATIONSHIPS
     */


    public function question() {
        return $this->belongsTo('App\Models\Questions\Question');
    }

    /**
     * METHODS
     */


    /**
     * STATIC METHODS
     */

}
