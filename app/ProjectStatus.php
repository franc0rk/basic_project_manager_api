<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectStatus extends Model
{
    public function projects()
    {
        $this->belongsTo(Project::class);
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];
}
