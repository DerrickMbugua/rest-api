<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    public function status(): HasOne
    {
        return $this->hasOne(Status::class);
    }

    public function user_tasks(): HasMany
    {
        return $this->hasMany(UserTask::class);
    }
}
