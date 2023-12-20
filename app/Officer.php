<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Officer extends Model
{
    use SoftDeletes;

    protected $table = 'officer';
    public $primaryKey = 'officer_id';
    public $timestamps = true;
    protected $fillable = [
        'level_id', 'branch_id', 'created_by', 'name', 'availability', 'current_complaint_id', 'nic', 'address'
    ];
}
