<?php

namespace Aucos\Permissionview\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\Traits\LogsActivity;
class PermissionModel extends Model
{ 
    use LogsActivity;
    protected $guarded = [];
    protected static $logAttributes = ['name', 'display_name'];
}