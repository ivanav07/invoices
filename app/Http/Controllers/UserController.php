<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

/**
 * Class UserController
 *
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @author Ivana Vasic <kontakt@ivanavasic.rs>
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $employees = User::where('admin', false)->get();
        return view('admin.employees', compact('employees'));
    }

    /**
     * @author Ivana Vasic <kontakt@ivanavasic.rs>
     *
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $employee = User::find($id);
        $projects = $employee->projects;
        $invoices = $employee->invoices();
        foreach ($projects as $project){
            $project->logged_on_project = $employee->loggedTimeOnProject($project->id);
            $project->earned_on_project = $employee->earnedOnProject($project->id);
        }
        return view('admin.single-employee', compact('employee','projects','invoices'));
    }

    /**
     * @author Ivana Vasic <kontakt@ivanavasic.rs>
     *
     * @param Request $request
     * @param         $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $employee = User::find($id);
        $employee->first_name = $request->first_name;
        $employee->last_name = $request->last_name;
        $employee->email = $request->email;
        $employee->pay_rate = $request->pay_rate;
        $employee->note = $request->note;
        $employee->save();

        return back();
    }

}
