<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComplaintDetail extends Model
{
    use SoftDeletes;

    protected $table = 'complaint_detail';
    public $primaryKey = 'complaint_detail_id';
    public $timestamps = true;
    protected $fillable = [
        'complaint_id', 'picture_of_evidence'
    ];
}
