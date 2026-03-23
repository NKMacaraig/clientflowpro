<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'client_id',
        'project_name',
        'start_date',
        'end_date',
        'status'
    ];
    
    // A Project belongs to a Client
    public function client()
    {
        return $this->belongsTo(\App\Models\Client::class);
    }

    // A Project has many Tasks
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    // A Project has many Invoices
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}