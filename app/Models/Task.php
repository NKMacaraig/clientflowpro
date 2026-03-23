<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'project_id',
        'assigned_to',
        'task_name',
        'description',
        'status',
        'due_date'
    ];

    // A Task belongs to a Project
    public function project()
    {
        return $this->belongsTo(\App\Models\Project::class);
    }

    // Optional: If you want to get the assigned User
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}