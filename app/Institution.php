<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Institution extends Model
{
    use SoftDeletes;
    protected $table = 'institution';
    public $primaryKey = 'institution_id';
    public $timestamps = true;
    protected $fillable = [
        'name'
    ];
}
