<?php

namespace App\Http\Controllers;

use App\Models\Base\BaseModel;
use App\Models\Courses\Course;
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

        return view($this->templateDir . '.manage_questions', compact("model", "controllerName", "classType", "course_id", "section_id"));
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


        return view($this->templateDir . '.manage_questions', compact("model", "controllerName", "classType", "course_id", "section_id"));
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

        return redirect($this->controllerName);
    }

}
