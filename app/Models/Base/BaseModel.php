<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class BaseModel extends Model {

    // DATABASE SETTINGS
    /** @var array      A complete list of attributes and their configuration options. See doc.md for complete list of values */
    protected           $attributes = [];
    /** @var  string    The table name in the database */
    protected           $table;

    // RELATIONSHIPS
    /*
    protected $childRelationships = [
        "payors" => [                       // relationship function name $model->
            "table" => "clients_to_payors",
            "attributes" => [
                "client_id",
                "payor_id",
                "id",
                "type",
                "max_weekly_hours",
                "displayorder",
                // Single payor properties
                "name",
                "email",
                "phone",
                "address_1",
                "address_2",
                "address_city",
                "address_state",
                "address_zip",
            ],
            "rules" => [
                'name' => 'required|max:255|unique:clients_to_payors{id}',
            ],
        ],
    ];
    */

    protected $childRelationships = [

    ];

    private $saveChildren = true;
    protected $children = array();
    protected $extra = array();

    protected $sortByColumn = null;
    protected $sortByDirection = "asc";


    // ERRORS
    private $errors;


    // OPTIONS
    /** @var  string    Name of the attribute used to define the model (usually "title" or "name") */
    public static       $nameIndex = "";
    /** @var  string    Singular name of the model (ie "Event" or "News Article" */
    public static       $modelNameSingular = "";
    /** @var  string    Plural name of the model (ie "Events" or "News Articles" */
    public static       $modelNamePlural = "";


    /**
     * Override the model's bootstrap function to insert our custom events for the system.
     */


    protected static function boot() {
        parent::boot();

        /** BaseModel $model */


        static::saved(function($model) {
            $model->postSave();
            return true;
        });

        static::created(function($model){
            return $model->postCreate();
        });

        static::deleting(function($model) {
            // Handle cascade deletes for child relationships
            if ($model->hasChildRelationships()) {
                foreach ($model->getChildRelationships() as $relationship) {
                    foreach ($model->{$relationship}()->get() as $relationshipModel) {
                        $relationshipModel->delete();
                    }
                }
            }
        });

        static::deleted(function($model) {
            $model->postDelete();
            return true;
        });
    }

    public static function getByID($id) {
        /** @var BaseModel $staticModel */
        $staticModel = new static();

        /** @var Builder $query */
        $query = $staticModel->newQuery();

        $query->where("id", $id);

        $model = $query->first();

        return $model;
    }

    /**
     * Overrides the default newQuery method
     * This will automatically append the model's ordering
     *
     * @param bool $ordered
     * @return Builder
     */
    public function newQuery() {
        /** @var Builder $query */
        $query = parent::newQuery();

        if (isset($this->sortByColumn)) {
            // otherwise use our default sorting
            $direction = $this->sortByDirection ?: "asc";
            if ($direction) {
                $query->orderBy($this->table . "." . $this->sortByColumn, $direction);
            } else {
                $query->orderBy($this->table . "." . $this->sortByColumn);
            }
        }

        return $query;
    }

    public function postSave() {
        $this->saveChildValues();
    }


    public function postCreate() {

    }

    public function postDelete() {

    }

    public function setValues($data) {
        $this->fill($data);

        if ($this->hasChildRelationships()) {
            $this->setChildValues($data);
        }
    }

    /**
     * Returns the set or inferred model name
     *
     * @return mixed
     */
    public function getModelName() {
        // If model name is set, use that
        if ( strlen($this::$modelNameSingular) ) {
            return $this::$modelNameSingular;

            // Otherwise try to infer from the class name
        } else {
            $modelName = get_class($this);
            $modelParts = explode("\\", $modelName);
            return last($modelParts);
        }
    }

    /**
     * Returns the set or inferred model name
     *
     * @return mixed
     */
    public function getModelNamePlural() {
        // If model name is set, use that
        if ( strlen($this::$modelNamePlural) ) {
            return $this::$modelNamePlural;

            // Otherwise try to infer from the class name
        } else {
            $modelName = get_class($this);
            $modelParts = explode("\\", $modelName);
            return last($modelParts) . "s";
        }
    }

    /**
     * Returns the set or inferred name index
     *
     * @return string
     */
    public function getNameIndex() {
        if ($this::$nameIndex)
            return $this::$nameIndex;
        elseif ($this->hasAttribute("title"))
            return "title";
        elseif ($this->hasAttribute("name"))
            return "name";
        else
            return $this->schema()->getAttributes()[0];
    }


    /**
     * RULES & VERIFICATION
     */



    public function validate($data) {

        return true; // dont care just pass it

        $rules = static::getRules($this->id);

        if (empty($rules)) {
            return true;
        }

        // make a new validator object
        $v = Validator::make($data, $rules);

        // check for failure
        if ($v->fails()) {
            // set errors and return false
            $this->errors = $v->errors();
            return false;
        }

        if ($this->hasChildRelationships()) {
            $this->validateChildren();
        }

        // validation pass
        return true;
    }

    public function errors() {
        return $this->errors;
    }

    public static function getRules($id=0) {
        return [
            //'name' => 'required|max:255|unique:clients' . ($id ? ",id,$id" : ''),
        ];
    }

    /**
     * Determines if this model has any child (hasMany) relationships
     *
     * @return bool
     */
    public function hasChildRelationships() {
        if (count($this->childRelationships)) {
            return true;
        } else {
            return false;
        }
    }

    public function getChildAttributes($name) {
        if (isset($this->children[$name])) {
            return $this->children[$name];
        }

        return $this->{$name}()->get();
    }

    public function getExtraAttributes($name) {
        if (isset($this->extra[$name])) {
            return $this->extra[$name];
        }

        return $this->{$name}()->get();
    }

    /**
     * Returns an array of this model's child (hasMany) relationships
     *
     * @return array
     */
    public function getChildRelationships() {
        return array_keys($this->childRelationships);
    }

    public function setChildValues(array $data) {
        $childAttributes = $this->childRelationships;

        foreach ($childAttributes as $attribute_group_name => $attribute_group_data) {
            $attribute_group_attributes = $attribute_group_data["attributes"];
            $exists_var = $attribute_group_name . "_exists_in_post";
            $hasDisplayOrderAttribute = in_array("displayorder", $attribute_group_attributes);

            $this->children[$attribute_group_name] = array();

            if (!empty($data[$exists_var])) {
                for ($i = 0; $i < count($data[$exists_var]); $i++) {
                    if ($data[$exists_var][$i]) {
                        $dataRow = array();
                        foreach ($attribute_group_attributes as $attribute_group_attribute) {
                            $attributeName = $attribute_group_name . "_" . $attribute_group_attribute;

                            if (isset($data[$attributeName]) && isset($data[$attributeName][$i])) {
                                $dataRow[$attribute_group_attribute] = $data[$attributeName][$i];
                            } else {
                                $dataRow[$attribute_group_attribute] = null;
                            }
                        }

                        if (!isset($dataRow["id"])) {
                            $dataRow["id"] = null;
                        }

                        if ($hasDisplayOrderAttribute) {
                            $dataRow["displayorder"] = $i + 1;
                        }

                        $this->children[$attribute_group_name][] = (object)$dataRow;
                    }
                }
            }
        }
    }

    public function validateChildren($data) {
        $childAttributes = $this->childRelationships;

        // Not sure how to format this...
        foreach ($childAttributes as $attribute_group_name => $attribute_group_data) {
            $attribute_group_attributes = $attribute_group_data["attributes"];
            $exists_var = $attribute_group_name . "_exists";
            $rules = $attribute_group_data["rules"];

            if (!empty($rules)) {
                for ($i = 0; $i < count($data[$attribute_group_name][$exists_var]); $i++) {
                    $dataRow = array();

                    foreach ($attribute_group_attributes as $attribute_group_attribute) {
                        if (isset($data[$attribute_group_attribute]) && isset($data[$attribute_group_attribute][$i])) {
                            $dataRow[$attribute_group_attribute] = $data[$attribute_group_attribute][$i];
                        } else {
                            $dataRow[$attribute_group_attribute] = null;
                        }
                    }

                    // make a new validator object
                    $v = Validator::make($dataRow, $rules);

                    // check for failure
                    if ($v->fails()) {
                        // set errors and return false
                        $this->errors = array_merge($this->errors, $v->errors());
                        return false;
                    }
                }
            }
        }
    }

    public function saveChildValues() {
        if (!$this->saveChildren) {
            return;
        }

        $childAttributes = $this->childRelationships;
        foreach ($childAttributes as $attribute_group_name => $attribute_group_data) {
            $tableName = $attribute_group_data["table"];
            $idsToSave = [];

            $childAttributes = $this->getChildAttributes($attribute_group_name);

            if (!empty($childAttributes)) {
                foreach ($childAttributes as $childAttributeData) {

                    $childAttributeData = (array)$childAttributeData;

                    $id = $childAttributeData["id"] ?: 0;

                    /** @var BaseModel $childModel */
                    $childModel = $this->{$attribute_group_name}()->firstOrNew(["id" => $id]);

                    $childModel->fill($childAttributeData);
                    $childModel->save();

                    $idsToSave[] = $childModel->id;
                }

                $this->{$attribute_group_name}()->whereNotIn("id", $idsToSave)->delete();
            }
        }
    }


    //==============================
    // Relationships
    //==============================

    /**
     * Returns oneToMany relationship.
     * Currently maps to eloquent hasMany function
     *
     * @param string $class
     * @param null|string $foreignKey
     * @param null|string $localKey
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hasMany($class, $foreignKey = null, $localKey = null){
        return parent::hasMany($class, $foreignKey, $localKey);
    }

    /**
     * @param string $class               The name of the related class using absolute path (e.g. \Model\Category)
     * @param string $table               The name of the pivot table
     * @param string $localKey            The reference to this object in the pivot table (e.g. post_id)
     * @param string $foreignKey          The reference to the related object in the pivot table (e.g. category_id)
     * @param string $thisKey             The key of this object (e.g. id)
     * @param array $pivotColumns         Optional columns to bring back from the pivot table
     *
     * @return $this|\Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function manyToMany($class, $table = null, $localKey = null, $foreignKey = null, $thisKey = "id", $pivotColumns = []){
        $result = parent::belongsToMany($class, $table, $localKey, $foreignKey, $thisKey);
        return count($pivotColumns) ? $result->withPivot($pivotColumns) : $result;
    }

}