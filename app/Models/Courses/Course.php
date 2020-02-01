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
        'split_into_sections',
    ];

    /**
     * VALIDATION
     */

    /**
     * RELATIONSHIPS
     */

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
