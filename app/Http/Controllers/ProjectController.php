<?php

namespace App\Http\Controllers;

use App\Project;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class ProjectController
 *
 * @package App\Http\Controllers
 */
class ProjectController extends Controller
{

    /**
     * ProjectController constructor.
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
        $projects = Project::all();

        return view('admin.projects', compact('projects'));
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
        $project      = Project::find($id);
        $onProject    = $project->users;
        $notOnProject = User::where('admin', false)->whereNotIn('id', $onProject->pluck('id')->toArray())->get();

        return view('admin.single-project', compact('project', 'onProject', 'notOnProject'));
    }

    /**
     * @author Ivana Vasic <kontakt@ivanavasic.rs>
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function myProjects()
    {
        $user = Auth::user();
        $projects = $user->projects;
        foreach ($projects as $project){
            $project->logged_on_project = $user->loggedTimeOnProject($project->id);
            $project->earned_on_project = $user->earnedOnProject($project->id);
        }
        return view('projects', compact('projects'));
    }

    /**
     * @author Ivana Vasic <kontakt@ivanavasic.rs>
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Request $request)
    {
        $project              = new Project();
        $project->name        = $request->name;
        $project->description = $request->description;
        $project->status      = config('project.status.aktivan');
        $project->save();

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
    public function update(Request $request, $id)
    {
        $project              = Project::find($id);
        $project->name        = $request->name;
        $project->description = $request->description;
        $project->status      = $request->status;
        $project->save();

        return back();
    }

    /**
     * @author Ivana Vasic <kontakt@ivanavasic.rs>
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        Project::destroy($id);

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
    public function addEmpoyees(Request $request, $id)
    {
        $employees = User::whereIn('id', $request->employees)->get();
        $project   = Project::find($id);
        foreach ($employees as $employee)
        {
            $project->users()->attach($employee, ['pay_rate' => $employee->pay_rate]);
        }

        return back();
    }

    /**
     * @author Ivana Vasic <kontakt@ivanavasic.rs>
     *
     * @param $project_id
     * @param $employee_id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeEmpoyee($project_id, $employee_id)
    {
        $project = Project::find($project_id);
        $project->users()->detach($employee_id);

        return back();
    }

    /**
     * @author Ivana Vasic <kontakt@ivanavasic.rs>
     *
     * @param Request $request
     * @param         $project_id
     * @param         $employee_id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateEmpoyee(Request $request, $project_id, $employee_id){
        $project = Project::find($project_id);
        $employee = User::find($employee_id);
        $project->users()->updateExistingPivot($employee,['pay_rate'=>$request->pay_rate,'role'=>$request->role]);
        return back();

    }
}
