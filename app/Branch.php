<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use SoftDeletes;
    protected $table = 'branch';
    public $primaryKey = 'branch_id';
    public $timestamps = true;
    protected $fillable = [
        'division_id', 'name'
    ];
}