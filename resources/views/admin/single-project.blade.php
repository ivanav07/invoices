@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <!-- Page Header-->
        <header>
            <h1 class="text-center">{{$project->name}}</h1>
        </header>

        <div class="card">
            <div class="card-body">
                <p>Osnovni podaci o projektu</p>
                <form class="row" action="{{ route('project.update', $project->id) }}" method="post">
                    @method('PUT')
                    @csrf
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Ime projekta</label>
                            <input type="text" value="{{$project->name}}" class="form-control form-control-sm" name="name">
                        </div>
                        <div class="form-group">
                            <label>Status projekta</label>
                            <select name="status" class="form-control form-control-sm">
                                @foreach(config('project.status') as $key=>$value)
                                    <option value="{{$value}}" @if($value == $project->status) selected @endif>{{$key}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Opis projekta</label>
                            <textarea class="form-control form-control-sm" name="description"> {{$project->description}}</textarea>
                        </div>
                        <div class="form-group text-right">
                            <input type="submit" value="Sačuvaj izmene" class="btn btn-primary">
                        </div>
                    </div>
                </form>

            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <p>Zaposleni na projektu</p>
                <div class="table-responsive text-center">
                    <table class="table table-striped table-sm">
                        <thead>
                        <tr>
                            <th>Ime i prezime</th>
                            <th>Satnica $/h</th>
                            <th>Uloga</th>
                            <th>Akcija</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($onProject as $employee)
                            <tr>
                                <form action="{{ route('project.update.employee', [$project->id,$employee->id]) }}" method="post">
                                    @method('PUT')
                                    @csrf
                                    <th>{{$employee->first_name}} {{$employee->last_name}}</th>
                                    <td><input type="number" value="{{$employee->pivot->pay_rate}}" name="pay_rate"
                                               class="form-control form-control-sm"></td>
                                    <td><input type="text" value="{{$employee->pivot->role}}" name="role"
                                               class="form-control form-control-sm"></td>
                                    <td>
                                        <input class="btn btn-primary btn-sm" type="submit" value="Izmeni">
                                        <a href="{{ route('project.remove.employee', [$project->id,$employee->id]) }}"
                                           class="btn btn-primary btn-sm"
                                           onclick="return confirm('Da li ste sigurni da želite da uklonite zaposlenog sa projekta?');">Ukloni
                                            sa projekta</a>
                                    </td>
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
                <p>Zaposleni na projektu</p>
                <form class="row" action="{{route('project.add.employees', $project->id)}}" method="post">
                    @csrf
                    <div class="form-group col-sm-8">
                        <label>Dodaj zaposlenog na projekat:</label>
                        <select multiple class="form-control" name="employees[]">
                            @foreach($notOnProject as $employee)
                                <option value="{{$employee->id}}">{{$employee->first_name}} {{$employee->last_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-sm-2">
                        <input class="btn btn-primary btn-sm" style="bottom: 0px;position: absolute;" type="submit" value="Dodaj">
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection