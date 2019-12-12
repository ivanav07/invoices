@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <!-- Page Header-->
        <header>
            <h1 class="text-center">Projekti</h1>
        </header>
        <div class="card">
            <div class="card-body">
                <button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-primary">Dodajte novi projekat</button>
                <!-- Modal-->
                <div id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
                     class="modal fade text-left">
                    <div role="document" class="modal-dialog">
                        <div class="modal-content" style="padding: 5%;">
                            <div class="modal-header">
                                <h5 id="exampleModalLabel" class="modal-title">Novi projekat</h5>
                                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                                            aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Jedan od način da efikasno pratite aktivnosti svojih zaposlenih je da redovno ažurirate i dodajete
                                    projekte na
                                    kojima rade.
                                </p>
                                <form action="{{ route('project.store') }}" method="post">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-sm-4 form-control-label">Ime projekta:</label>
                                        <input type="text" class="col-sm-8 form-control" name="name">
                                    </div>
                                    <div class="form-group">
                                        <label>Opis projekta:</label>
                                        <textarea class="form-control" name="description"></textarea>
                                    </div>
                                    <div class="form-group text-right">
                                        <input type="submit" value="Kreiraj projekat" class="btn btn-primary">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <h5>Projekti</h5>
                <div class="table-responsive text-center">
                    <table class="table table-striped table-sm">
                        <thead>
                        <tr>
                            <th>Ime projekta</th>
                            <th>Kreiran</th>
                            <th>Status</th>
                            <th>Zaposlenih na projektu</th>
                            <th>Akcija</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($projects as $project)
                            <tr>
                                <td>{{$project->name}}</td>
                                <td>{{$project->created_at->format('d.m.Y')}}</td>
                                <td>{{array_search ($project->status, config('project.status'))}}</td>
                                <td>{{$project->users->count()}}</td>
                                <td>
                                    <a href="{{ route('project', $project->id) }}" class="btn btn-primary btn-sm">Izmeni</a>
                                    <a href="{{ route('project.destroy', $project->id) }}" class="btn btn-primary btn-sm"
                                       onclick="return confirm('Da li ste sigurni da želite da obrišete ovaj projekat');">Obriši</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection