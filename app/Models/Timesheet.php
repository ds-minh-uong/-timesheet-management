<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'difficult',
        'user_id',
        'schedule',
        'manager_id'
    ];

    public function tasks()
    {
        return $this->hasMany(Line::class);
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($timesheet) { // before delete() method call this
            $timesheet->tasks()->delete();
            // do the rest of the cleanup...
        });
    }
}
