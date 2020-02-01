<?php

namespace App\Models\Courses;

use App\Models\Base\BaseModel;

class Course extends BaseModel
{

    /**
     * PROPERTIES
     */

    protected $table = "courses";

    protected $fillable = [
        'name',
        'description',
        'owner_id',
    ];

    /**
     * VALIDATION
     */

    /**
     * RELATIONSHIPS
     */

    protected $childRelationships = [
        "sections" => [                       // relationship function name $model->
            "table" => "course_sections",
            "attributes" => [
                "id",
                "name",
                "description",
                "displayorder",
            ],
            "rules" => [
                'name' => 'required|max:255',
                //'description' => '',
            ],
        ],
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

    public function sections() {
        return $this->hasMany('App\Models\Courses\CourseSection', 'course_id');
    }

    public function questions(){
        return $this->hasMany('App\Models\Questions\Question', 'course_id');
    }

    /**
     * METHODS
     */

    /**
     * STATIC METHODS
     */

}
