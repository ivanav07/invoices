<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'activities';


    /**
     * Get the invoice record associated with the activity.
     */

    public function invoice()
    {
        return $this->belongsTo('App\Invoice');
    }

    /**
     * Get the user of the activity.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the project of the activity.
     */
    public function project()
    {
        return $this->belongsTo('App\Project');
    }

}
