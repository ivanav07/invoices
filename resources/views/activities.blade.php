@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <!-- Page Header-->
        <header>
            <h1 class="text-center">Vaše aktivnosti</h1>
        </header>

        <div class="card">
            <div class="card-body">
                <button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-primary">Dodajte novu aktivnost</button>
                <!-- Modal-->
                <div id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
                     class="modal fade text-left">
                    <div role="document" class="modal-dialog">
                        <div class="modal-content" style="padding: 5%;">
                            <div class="modal-header">
                                <h5 id="exampleModalLabel" class="modal-title">Nova aktivnost</h5>
                                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                                            aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p> Logujte svoju današnju aktivnost i naplatite svoj rad!
                                </p>
                                <form method="post" action="{{route('activity.store')}}">
                                    @csrf
                                    <div class="row">
                                        <label class="col-sm-4">Datum:</label>
                                        <div class="col-sm-8">{{ date('d.m.Y') }}</div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 form-control-label">Projekat:</label>
                                        <select name="project" class="col-sm-8 form-control form-control-sm">
                                            @foreach(Auth::user()->projects as $project)
                                                <option value="{{$project->id}}">{{$project->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 form-control-label">Broj radnih sati:</label>
                                        <input type="number" name="hours" class="col-sm-8 form-control form-control-sm" min="0.5" max="12"
                                               step="0.5">
                                    </div>
                                    <div class="form-group">
                                        <label>Opis aktivnosti:</label>
                                        <textarea type="text" class="form-control form-control-sm" name="description"></textarea>
                                    </div>
                                    <div class="form-group text-right">
                                        <input type="submit" value="Loguj vreme" class="btn btn-primary">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="va">Sledeće aktivnosti nisu fakturisane:</h5>
                <div class="table-responsive text-center">
                    <table class="table table-striped table-sm">
                        <thead>
                        <tr>
                            <th>Datum</th>
                            <th>Projekat</th>
                            <th>Opis aktivnosti</th>
                            <th>Radnih sati h</th>
                            <th>Zarada $</th>
                            <th>Akcija</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($activities as $activity)
                            <tr>
                                <td>{{$activity->created_at->format('d.m.Y')}}</td>
                                <td>{{$activity->project->name}}</td>
                                <td>{{$activity->description}}</td>
                                <td>{{$activity->operating_hours}}</td>
                                <td>{{$activity->earned}}</td>
                                <td>
                                    <a href="{{ route('activity.destroy', $activity->id) }}" class="btn btn-primary btn-sm"
                                       onclick="return confirm('Da li ste sigurni da želite da obrišete ovu aktivnost');">Obriši</a>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <form method="post" action="{{route('invoice.create')}}">
                                @csrf
                            <td>Uplatu izvršiti:</td>
                            <td colspan="2"> <input type="text" class="form-control form-control-sm" name="note"></td>
                            <td> Ukupno:</td>
                            <td> {{$total_earned}}</td>
                            <td>
                                <button class="btn btn-primary btn-sm" type="submit">Kreiraj fakturu</button>
                            </td>
                            </form>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @if($unaccepted->count())
            <div class="card">
                <div class="card-body">
                    <div class="va">
                        Nažalost, Vaš poslodavac je procenio da aktivnosti koje slede u nastavku nisu zadovoljile kriterijume dobrog opisa
                        same
                        aktivnosti ili vreme koja ta aktivnost zahteva nije adekvatno. Odbijene aktivnosti nećete moći da naplatite, zato
                        Vas
                        molimo da napravite izmene na ovim aktivnostima ili kontaktirajte svog poslodavca.
                    </div>

                    <div class="table-responsive text-center">
                        <table class="table table-striped table-sm">
                            <thead>
                            <tr>
                                <th>Datum</th>
                                <th>Projekat</th>
                                <th>Opis aktivnosti</th>
                                <th>Radnih sati h</th>
                                <th>Akcija</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($unaccepted as $activity)
                                <form action="{{route('activity.update',$activity->id)}}" method="post">
                                    @method('PUT')
                                    @csrf
                                    <tr>
                                        <td>{{$activity->created_at->format('d.m.Y')}}</td>
                                        <td>
                                            <select name="project" class="form-control form-control-sm">
                                                @foreach(Auth::user()->projects as $project)
                                                    <option value="{{$project->id}}"
                                                            @if($project->id==$activity->project_id) selected @endif>{{$project->name}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td><textarea class="form-control form-control-sm" name="description">{{$activity->description}}</textarea></td>
                                        <td><input type="number" class="form-control form-control-sm" min="0.5" max="12" step="0.5"
                                                   value="{{$activity->operating_hours}}" name="hours">
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-sm" type="submit">Izmeni</button>
                                            <a href="{{ route('activity.destroy', $activity->id) }}" class="btn btn-primary btn-sm"
                                               onclick="return confirm('Da li ste sigurni da želite da obrišete ovu aktivnost');">Obriši</a>
                                    </tr>
                                </form>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        @else
            <div class="card">
                <div class="card-body">
                    Nema aktivnosti koje su odbijene.
                </div>
            </div>
        @endif

    </div>
@endsection