<?php

namespace App\Http\Controllers;

use App\Models\Base\BaseModel;
use App\Models\Courses\Course;
use App\Models\Questions\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CourseController extends BaseBREADController
{
    /**
     * REQUIRED CONTROLLER/MODEL PROPERTIES
     */
    protected $controllerName = "manage/courses";
    protected $templateDir = "courses";
    protected $modelName = "App\Models\Courses\Course";

    public function manage_questions($id) {
        $modelName = $this->getModelName(); // course

        /** @var BaseModel $model */
        $model = $modelName::findOrFail($id);
        if (is_null($model)) {
            dump("Model cannot be found"); die;
        }

        $classType = $model instanceof Course ? "course" : "course_section";
        if ($model instanceof Course) {
            $course_id = $model->id;
            $section_id = null;
        } else {
            $course_id = $model->course_id;
            $section_id = $model->id;
        }

        $return_url = route('courses.view', $model);

        return view($this->templateDir . '.manage_questions', compact("model", "controllerName", "classType", "course_id", "section_id", "return_url"));
    }

    public function manage_section_questions($id) {
        $modelName = "App\Models\Courses\CourseSection"; // course section

        /** @var BaseModel $model */
        $model = $modelName::findOrFail($id);
        if (is_null($model)) {
            dump("Model cannot be found"); die;
        }

        $classType = $model instanceof Course ? "course" : "course_section";
        if ($model instanceof Course) {
            $course_id = $model->id;
            $section_id = null;
        } else {
            $course_id = $model->course_id;
            $section_id = $model->id;
        }

        $return_url = route('courses.view', $model->course);


        return view($this->templateDir . '.manage_questions', compact("model", "controllerName", "classType", "course_id", "section_id", "return_url"));
    }

    public function save_questions(Request $request) {
        $model_id = $request->model_id;

        $model_type = $request->model_type;

        if ($model_type == "course") {
            $modelName = $this->getModelName();
        } else {
            $modelName = "App\Models\Courses\CourseSection"; // course section
        }

        if ($model_id && $model_id > 0) {
            /** @var BaseModel $model */
            $model = $modelName::getByID($model_id);
            if (is_null($model)) {
                dump("Model cannot be found");
                die;
            }
        } else {
            /** @var BaseModel $model */
            $model = new $modelName();
        }

        // Fill properties
        $model->setValues($request->all());

        // Then verify
        //if ( !$model->validate($request->all()) ) {
        //    $errors = $model->errors();
        //    return view($this->templateDir . '.modify', compact("model", "controllerName", "errors"));
        //}

        // We've passed validation.. continue...
        $model->save();

        if ($request->return_url) {
            return redirect($request->return_url);
        }

        return redirect($this->controllerName);
    }

    public function ajax_submit_question_for_id(Request $request) {

        $course_id = (int) $request->course_id;
        $section_id = (int) $request->section_id;
        $question = $request->question;
        $type = $request->type;
        $correctAnswer = $request->correctAnswer ?: "";

        if ($course_id > 0 && strlen(trim($question))) {

            $model = Question::firstOrNew([
                "course_id" => $course_id,
                "question" => $question,
            ]);

            $model->correct_answer = $correctAnswer;
            $model->type = $type;

            if ($section_id > 0) {
                $model->section_id = $section_id;
            }

            if ($model->save()) {
                return response()->json(["was_created" => true, "id" => $model->id]);
            }
        }

        return response()->json(["was_created" => false, "id" => null]);
    }
}
