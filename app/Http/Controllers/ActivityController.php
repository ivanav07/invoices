<?php

namespace App\Http\Controllers;

use App\Activity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    /**
     * ActivityController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @author Ivana Vasic <kontakt@ivanavasic.rs>
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if($date = $request->date){
            $start_time = Carbon::parse($date)->startOfDay();
            $end_time = Carbon::parse($date)->endOfDay();
        } else {
            $start_time = Carbon::now()->startOfDay();
            $end_time = Carbon::now()->endOfDay();
        }
        $activities = Activity::whereBetween('created_at',[$start_time,$end_time])->get();

        return view('admin.activities',compact('activities'));
    }

    /**
     * @author Ivana Vasic <kontakt@ivanavasic.rs>
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function activities()
    {
        $activities = Auth::user()->activities()->whereNull('invoice_id')->where('accepted',true)->get();
        $unaccepted = Auth::user()->activities()->whereNull('invoice_id')->where('accepted',false)->get();
        $total_earned = 0;
        foreach ($activities as $activity){
            $total_earned += $activity->earned;
        }
        return view('activities',compact('activities','total_earned','unaccepted'));
    }

    /**
     * @author Ivana Vasic <kontakt@ivanavasic.rs>
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Request $request){
        $user = Auth::user();
        $activity              = new Activity();
        $activity->project_id  = $request->project;
        $activity->user_id  = $user->id;
        $activity->operating_hours  = $request->hours;
        $activity->description  = $request->description;
        $activity->earned  = $user->projects()->where('id',$request->project)->first()->pivot->pay_rate * $request->hours;
        $activity->save();

        return back();
    }

    /**
     * @author Ivana Vasic <kontakt@ivanavasic.rs>
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function decline($id){
        $activity = Activity::find($id);
        $activity->accepted = false;
        $activity->save();
        return back();
    }

    /**
     * @author Ivana Vasic <kontakt@ivanavasic.rs>
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function accept($id){
        $activity = Activity::find($id);
        $activity->accepted = true;
        $activity->save();
        return back();
    }

    /**
     * @author Ivana Vasic <kontakt@ivanavasic.rs>
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id){
        Activity::find($id)->delete();
        return back();
    }

    /**
     * @author Ivana Vasic <kontakt@ivanavasic.rs>
     *
     * @param Request $request
     * @param         $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request,$id){
        $activity = Activity::find($id);
        $activity->project_id  = $request->project;
        $activity->operating_hours  = $request->hours;
        $activity->description  = $request->description;
        $activity->earned  = Auth::user()->projects()->where('id',$request->project)->first()->pivot->pay_rate * $request->hours;
        $activity->save();
        return back();
    }
}
