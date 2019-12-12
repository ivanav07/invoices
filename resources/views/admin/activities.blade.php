@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <!-- Page Header-->
        <header>
            <h1 class="text-center">Aktivnosti</h1>
        </header>
        <div class="card">
            <div class="card-body">
                <div class="va">
                    <form class="form-inline" method="get">
                        <div class="form-group">
                            <label>Logovane aktivnosti za dan:</label>
                            <input data-provide="datepicker" class="datepicker form-control form-control-sm col-md-4 mr-3" name="date">
                            <input type="submit" value="Pogledaj" class="btn btn-primary btn-sm mb-2">
                        </div>
                    </form>
                </div>
                <script>
                    let searchParams = new URLSearchParams(window.location.search);
                    let d = 'now';
                    if (searchParams.has('date')) {
                        d = searchParams.get('date');
                    }
                    $('.datepicker').datepicker({
                        format: "dd.mm.yyyy.",
                        autoclose: true,
                        endDate: new Date(),
                        weekStart: 1,
                    }).datepicker("setDate", d);
                </script>
                <div class="table-responsive text-center">
                    <table class="table table-striped table-sm">
                        <thead>
                        <tr>
                            <th>Zaposleni</th>
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
                                <td>{{$activity->user->fullName()}}</td>
                                <td>{{$activity->project->name}}</td>
                                <td>{{$activity->description}}</td>
                                <td>{{$activity->operating_hours}}</td>
                                <td>{{$activity->earned}}</td>
                                <td>
                                    @if($activity->invoice_id !== null)
                                        <button class="btn btn-primary btn-sm" disabled>Fakturisano</button>
                                    @elseif($activity->accepted)
                                        <a class="btn btn-primary btn-sm" href="{{route('activity.decline', $activity->id)}}">Odbij</a>
                                    @else
                                        <a class="btn btn-primary btn-sm" href="{{route('activity.accept', $activity->id)}}">Prihvati</a>
                                    @endif
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
