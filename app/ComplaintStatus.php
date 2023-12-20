<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComplaintStatus extends Model
{
    protected $table = 'complaint_status';
    public $primaryKey = 'complaint_status_id';
    public $timestamps = true;
    protected $fillable = [
        'complaint_id', 'status', 'officer_id '
    ];
}
