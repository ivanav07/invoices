<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'pay_rate',
        'note',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the activities for the user.
     */
    public function activities()
    {
        return $this->hasMany('App\Activity');
    }

    /**
     * The projects that are assigned to the user.
     */
    public function projects()
    {
        return $this->belongsToMany('App\Project')->withPivot('pay_rate', 'role', 'created_at');
    }

    public function fullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function invoices()
    {

        $invoices_ids = $this->activities()->where('invoice_id', '!=', 0)->distinct('invoice_id')->pluck('invoice_id')->toArray();

        return Invoice::whereIn('id', $invoices_ids)->get();
    }

    public function onProjects()
    {
        return $this->projects->implode('name', ', ');
    }

    public function loggedTime()
    {
        return $this->activities->sum('operating_hours');
    }

    public function earned(){
        return $this->invoices()->sum('total_sum');
    }

    public function loggedTimeOnProject($project_id)
    {
        return $this->activities->where('project_id',$project_id)->sum('operating_hours');
    }

    public function earnedOnProject($project_id){
        return $this->activities->where('project_id',$project_id)->where('invoice_id','!=', null)->sum('earned');
    }
}
