<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Complaint extends Model
{
    use SoftDeletes;

    protected $table = 'complaint';
    public $primaryKey = 'complaint_id';
    public $timestamps = true;
    protected $fillable = [
        'u_id', 'complain_type', 'complain_status', 'institution_id', 'description', 'longitude', 'latitude', 'from_date', 'from_time', 'to_date', 'to_time',
    ];
    protected $casts = [
        'from_time' => 'time',
        'to_date' => 'date',
        'to_time' => 'time',
    ];
}
