<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

use Session;

class BaseModel extends Model
{


    public $sessionUserId;
    public $sessionUserType;

    public function __construct()
    {

        if (auth()->user()) {
            $session = auth()->user();
            $this->sessionUserId = $session->id;

            $this->sessionUserType = $session->getType();
        }
    }

    public function existsByColumn($columns, $values)
    {

        $model = new static;
        foreach ($columns as $index => $column) {
            $model = $model->where($column, $values[$index]);
        }
        return $model->count() > 0;
    }

    public function getByColumns($columns, $values)
    {
        $model = new static;
        foreach ($columns as $index => $column) {
            $model = $model->where($column, $values[$index]);
        }
        return $model->get();
    }
}
