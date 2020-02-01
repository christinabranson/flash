<?php

namespace App\Models\Courses;

use App\Models\Base\BaseModel;

class CourseSection extends BaseModel
{

    /**
     * PROPERTIES
     */

    protected $table = "course_sections";

    protected $fillable = [
        'course_id',

        'name',
        'description',
        'displayorder',
    ];

    protected $sortByColumn = 'displayorder';

    /**
     * VALIDATION
     */

    /**
     * RELATIONSHIPS
     */


    protected $childRelationships = [
        "questions" => [                       // relationship function name $model->
            "table" => "question",
            "attributes" => [
                "id",
                "course_id",
                "section_id",
                "question",
                "type",
                "correct_answer",
            ],
            "rules" => [
                'question' => 'required|max:255',
                //'description' => '',
            ],
        ],
    ];

    public function course() {
        return $this->belongsTo('App\Models\Courses\Course');
    }

    public function questions(){
        return $this->hasMany('App\Models\Questions\Question', 'section_id');
    }

    /**
     * METHODS
     */

    /**
     * STATIC METHODS
     */

}
