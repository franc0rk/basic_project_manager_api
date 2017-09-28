<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function client()
    {
        return $this->hasOne(Client::class);
    }

    public function projectStatus()
    {
        return $this->hasOne(ProjectStatus::class);
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'client_id', 'project_status_id',
    ];
}
