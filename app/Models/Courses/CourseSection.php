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
    ];

    /**
     * VALIDATION
     */

    /**
     * RELATIONSHIPS
     */

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
