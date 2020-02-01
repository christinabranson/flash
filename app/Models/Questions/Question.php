<?php

namespace App\Models\Questions;

use App\Models\Base\BaseModel;

class Question extends BaseModel
{

    const TYPE_INPUT = 1;
    const TYPE_MULTIPLE_CHOICE = 2;

    public static $QUESTION_TYPES = array(
        Question::TYPE_INPUT => "Text Input",
        Question::TYPE_MULTIPLE_CHOICE => "Multiple Choice",
    );

    /**
     * PROPERTIES
     */

    protected $table = "questions";

    protected $fillable = [
        'course_id',
        'section_id',

        'type',
        'question',
        'correct_answer'
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

    public function course_section() {
        return $this->belongsTo('App\Models\Courses\CourseSection');
    }

    public function answers(){
        return $this->hasMany('App\Models\Questions\QuestionAnswer', 'question_id');
    }

    /**
     * METHODS
     */

    public function getThisTypeString() {
        return static::getTypeString($this->type);
    }


    /**
     * STATIC METHODS
     */

    public static function getTypesForDropdown() {
        $output = array();
        foreach (static::$QUESTION_TYPES as $type_id => $type_name) {
            $output[$type_id] = $type_name;
        }

        return $output;
    }

    public static function getTypeString($type_id) {
        if (isset(static::$QUESTION_TYPES[$type_id])) {
            return static::$QUESTION_TYPES[$type_id];
        }
        return "N/A";
    }
}
