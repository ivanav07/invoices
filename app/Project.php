<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'status',
    ];

    /**
     * Get the activities for the project.
     */
    public function activities()
    {
        return $this->hasMany('App\Activity');
    }

    /**
     * The users that  work on the projects.
     */
    public function users()
    {
        return $this->belongsToMany('App\User')->withPivot('pay_rate', 'role', 'created_at');
    }
}
