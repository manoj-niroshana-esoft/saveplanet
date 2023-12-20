<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $table = 'division';
    public $primaryKey = 'division_id';
    public $timestamps = true;
    protected $fillable = [
        'institution_id', 'name'
    ];
}
