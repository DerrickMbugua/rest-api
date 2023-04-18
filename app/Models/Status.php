<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name'
    ];

    public function tasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class);
    }

    public function user_tasks(): BelongsToMany
    {
        return $this->belongsToMany(UserTask::class);
    }
}
