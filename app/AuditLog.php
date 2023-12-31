<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuditLog extends Model
{
    use SoftDeletes;
    protected $table = 'audit_log';
    public $primaryKey = 'audit_log_id';
    public $timestamps = true;
    protected $fillable = [
        'u_id', 'section_name', 'action', 'previous_records', 'new_records'
    ];
}
