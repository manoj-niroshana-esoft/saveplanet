<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $table = 'branch';
    public $primaryKey = 'branch_id';
    public $timestamps = true;
    protected $fillable = [
        'division_id', 'name'
    ];
}