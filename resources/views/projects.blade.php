@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <!-- Page Header-->
        <header>
            <h1 class="text-center">Vaši projekti</h1>
        </header>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive text-center">
                    <table class="table table-striped table-sm">
                        <thead>
                        <tr>
                            <th>Ime projekta</th>
                            <th>Na projektu od</th>
                            <th>Uloga</th>
                            <th>Status projekta</th>
                            <th>Satnica $/h</th>
                            <th>Radnih sati</th>
                            <th>Zarada $</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($projects as $project)
                        <tr>
                            <th>{{$project->name}}</th>
                            <td>{{$project->pivot->created_at->format('d.m.Y')}}</td>
                            <td>{{$project->pivot->role}}</td>
                            <td>{{array_search ($project->status, config('project.status'))}}</td>
                            <td>{{$project->pivot->pay_rate}}</td>
                            <td>{{$project->logged_on_project}}</td>
                            <td>{{$project->earned_on_project}}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection