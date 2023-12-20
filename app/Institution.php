<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    protected $table = 'institution';
    public $primaryKey = 'institution_id';
    public $timestamps = true;
    protected $fillable = [
        'name'
    ];
}
