<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComplaintStatus extends Model
{
    use SoftDeletes;
    protected $table = 'complaint_status';
    public $primaryKey = 'complaint_status_id';
    public $timestamps = true;
    protected $fillable = [
        'complaint_id', 'status', 'officer_id', 'comment'
    ];
}
