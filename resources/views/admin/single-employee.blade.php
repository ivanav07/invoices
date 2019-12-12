@extends('layouts.main')

@section('content')

    <div class="container-fluid">
        <!-- Page Header-->
        <header>
            <h1 class="text-center">{{ $employee->fullName() }}</h1>
        </header>

        <div class="card">
            <div class="card-body">
                <p>Osnovni podaci o zaposlenom</p>
                <form class="form-horizontal" method="post" action="{{ route('employee.update', $employee->id) }}">
                    @method('PUT')
                    @csrf
                    <div class="form-group row">
                        <label class="col-md-1">Ime:</label>
                        <div class="col-md-2">
                            <input type="text" value="{{ $employee->first_name }}" class="form-control form-control-sm" name="first_name">
                        </div>
                        <label class="col-md-2">Prezime:</label>
                        <div class="col-md-2">
                            <input type="text" value="{{ $employee->last_name }}" class="form-control form-control-sm" name="last_name">
                        </div>
                        <label class="col-md-1">Email:</label>
                        <div class="col-md-4">
                            <input type="email" value="{{ $employee->email }}" class="form-controlform-control-sm" name="email">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">Satnica:</label>
                        <div class="col-md-2 va">
                            <input type="number" value="{{ $employee->pay_rate }}" class="form-control form-control-sm" name="pay_rate">
                        </div>
                        <label class="col-md-2">Kompetencije i napomene:</label>
                        <div class="col-md-6">
                            <textarea type="text" class="form-control form-control-sm" name="note">{{ $employee->note }}</textarea>
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <input type="submit" value="Sačuvaj izmene" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <p>Projekti zaposlenog</p>
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
                            <th>Zaradio</th>
                            <th>Akcija</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($projects as $project)
                        <tr>
                            <form action="{{ route('project.update.employee', [$project->id,$employee->id]) }}" method="post">
                                @method('PUT')
                                @csrf
                                <th>{{$project->name}}</th>
                                <td>{{$project->pivot->created_at->format('d.m.Y')}}</td>
                                <td><input type="text" value="{{$project->pivot->role}}" name="role" class="form-control form-control-sm"></td>
                                <td>{{array_search ($project->status, config('project.status'))}}</td>
                                <td><input type="number" value="{{$project->pivot->pay_rate}}" name="pay_rate" class="form-control form-control-sm"></td>
                                <td>{{$project->logged_on_project}}</td>
                                <td>{{$project->earned_on_project}}</td>
                                <td><input class="btn btn-primary btn-sm" type="submit" value="Izmeni"></td>
                            </form>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <p>Fakture zaposlenog</p>
                <div class="table-responsive text-center">
                    <table class="table table-striped table-sm">
                        <thead>
                        <tr>
                            <th>Datum kreiranja</th>
                            <th>Faktura</th>
                            <th>Iznos</th>
                            <th>Plaćanje</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($invoices as $invoice)
                        <tr>
                            <td>{{$invoice->created_at->format('d.m.Y')}}</td>
                            <td><a href="{{route('invoice', $invoice->id)}}"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a></td>
                            <td>{{$invoice->total_sum}}</td>
                            @if($invoice->paid)
                                <td>Plaćeno {{$invoice->updated_at->format('d.m.Y')}}</td>
                            @else
                                <td><a href="{{route('pay', $invoice->id)}}" class="btn btn-primary btn-sm">Plati</a></td>
                            @endif
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection