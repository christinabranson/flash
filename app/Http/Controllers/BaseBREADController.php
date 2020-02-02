<?php

namespace App\Http\Controllers;

use App\Models\Base\BaseModel;
use Exception;
use Illuminate\Http\Request;

class BaseBREADController extends Controller
{
    /**
     * REQUIRED CONTROLLER/MODEL PROPERTIES
     */
    protected $controllerName;
    protected $templateDir = "general";
    protected $modelName;

    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function browse() {
        $modelName = $this->getModelName();
        $modelQuery = $modelName::query();
        /** @var BaseModel[] $model */
        $models = $modelQuery->get();

        return view($this->templateDir . '.browse', compact("models", "controllerName"));
    }

    public function read($id) {
        $modelName = $this->getModelName();

        /** @var BaseModel $model */
        $model = $modelName::getById($id);

        if (is_null($model)) {
            dump("Model cannot be found"); die;
        }


        return view($this->templateDir . '.read', compact("model", "controllerName"));
    }

    public function add() {
        $modelName = $this->getModelName();

        /** @var BaseModel $model */
        $model = new $modelName();

        return view($this->templateDir . '.modify', compact("model", "controllerName"));
    }

    public function edit($id) {
        $modelName = $this->getModelName();

        /** @var BaseModel $model */
        $model = $modelName::findOrFail($id);
        if (is_null($model)) {
            dump("Model cannot be found"); die;
        }

        return view($this->templateDir . '.modify', compact("model", "controllerName"));
    }

    public function save(Request $request) {
        $model_id = $request->model_id;

        $modelName = $this->getModelName();

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

    /**
     * PRIVATE METHODS
     */

    protected function getModelName() {
        $modelName = $this->modelName;
        if (strlen($modelName) && class_exists($modelName)) {
            return $modelName;
        }

        return null;
    }

    protected function getModel() {

        $modelName = $this->modelName;
        try {
            if (strlen($modelName) && class_exists($modelName)) {
                return new $modelName();
            } else {
                return null;
            }
        } catch (Exception $e) {
            dump($e->getMessage());
        }
    }

}
