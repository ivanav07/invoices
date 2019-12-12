<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'total_sum', 'paid', 'notes',
    ];
    /**
     * Get the activities for the invoice.
     */

    public function activities()
    {
        return $this->hasMany('App\Activity');
    }

    public function user(){
        $activity = Activity::where('invoice_id', $this->id)->first();
        $user = User::find($activity->user_id);
        return $user;
    }
}
