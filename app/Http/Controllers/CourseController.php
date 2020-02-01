<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CourseController extends BaseBREADController
{
    /**
     * REQUIRED CONTROLLER/MODEL PROPERTIES
     */
    protected $controllerName = "manage/courses";
    protected $templateDir = "courses";
    protected $modelName = "App\Models\Course";

}
