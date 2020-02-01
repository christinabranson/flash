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

    protected $childRelationships = [

    ];

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

    public function postSave() {

        parent::postSave();

        // Now save any answers
        $this->setAnswerValues($_POST);

    }


    public function setAnswerValues(array $data) {
        $attribute_group_name = "answers";

        $this->children[$attribute_group_name] = array();

        foreach ($data["answers_question_id"] as $i => $question_id) {
            if ($question_id != $this->id) { // we only care about this question obviously
                continue;
            }

            $id = $data["answers_id"][$i] ?: null;
            $answer = $data["answers_answer"][$i];
            $is_correct = $data["answers_is_correct"][$i];

            if (strlen(trim($answer))) {
                $this->children[$attribute_group_name][] = [
                    "id" => $id,
                    "answer" => $answer,
                    "is_correct" => $is_correct,
                ];
            }
        }

        if (count($this->children[$attribute_group_name])) {
            $this->saveAnswerValues($attribute_group_name);
        }
    }

    public function saveAnswerValues($attribute_group_name) {
        if (!count($this->children[$attribute_group_name])) {
            return;
        }

        $idsToSave = [];

        $childAttributes = $this->getChildAttributes($attribute_group_name);

        if (!empty($childAttributes)) {
            foreach ($childAttributes as $childAttributeData) {

                $childAttributeData = (array)$childAttributeData;

                $id = isset($childAttributeData["id"]) && $childAttributeData["id"] > 0 ? $childAttributeData["id"] : 0;

                /** @var BaseModel $childModel */
                $childModel = $this->{$attribute_group_name}()->firstOrNew(["id" => $id]);

                $childModel->fill($childAttributeData);
                $childModel->save();

                $idsToSave[] = $childModel->id;
            }

            $this->{$attribute_group_name}()->whereNotIn("id", $idsToSave)->delete();
        }
    }


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
