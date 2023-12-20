<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Division extends Model
{
    use SoftDeletes;
    protected $table = 'division';
    public $primaryKey = 'division_id';
    public $timestamps = true;
    protected $fillable = [
        'institution_id', 'name'
    ];
}
