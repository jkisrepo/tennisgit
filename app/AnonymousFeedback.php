<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnonymousFeedback extends Model {
    protected $table= 'anonymous_feedback';
    public $timestamps = false;
}
