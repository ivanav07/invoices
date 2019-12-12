@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <!-- Page Header-->
        <header>
            <h1 class="text-center">Zaposleni</h1>
        </header>
        <div class="card">
            <div class="card-body">
                <button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-primary">Dodajte novog zaposlenog</button>
                <!-- Modal-->
                <div id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
                     class="modal fade text-left">
                    <div role="document" class="modal-dialog">
                        <div class="modal-content" style="padding: 5%;">
                            <div class="modal-header">
                                <h5 id="exampleModalLabel" class="modal-title">Novi zaposleni</h5>
                                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                                            aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p> Dodajte novog zaposlenog, a kasnije i na projekte na kojima će da radi, kako bi mogao/mogla da loguju i
                                    naplate svoj rad!
                                </p>
                                <form method="POST" action="{{ route( 'register') }}" name="myform">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-sm-4 form-control-label">Ime zaposlenog</label>
                                        <input type="text" class="col-sm-8 form-control" name="first_name" value="{{ old('first_name') }}" required autocomplete="name" autofocus>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 form-control-label">Prezime zaposlenog</label>
                                        <input type="text" class="col-sm-8 form-control" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 form-control-label">Email zaposlenog</label>
                                        <input type="email" class="col-sm-8 form-control " name="email" value="{{ old('email') }}" required autocomplete="email">
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 form-control-label">Lozinka</label>
                                        <input type="text" class="col-sm-8 form-control" name="password" required autocomplete="new-password">
                                    </div>
                                    <div class="form-group text-right">
                                        <input type="button" class="btn btn-primary btn-sm" value="Generiši lozinku" onClick="generate();" tabindex="2">
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 form-control-label">Cena radnog sata ($/h)</label>
                                        <input type="number" class="col-sm-8 form-control" min="3" max="200" name="pay_rate">
                                    </div>
                                    <div class="form-group">
                                        <label>Kompetencije i napomene:</label>
                                        <textarea class="form-control" name="note"></textarea>
                                    </div>
                                    <div class="form-group text-right">
                                        <input type="submit" value="Dodaj zaposlenog" class="btn btn-primary">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <h5>Vaši zaposleni:</h5>
                <div class="table-responsive text-center">
                    <table class="table table-striped table-sm">
                        <thead>
                        <tr>
                            <th>Ime i prezime</th>
                            <th>Na projektima</th>
                            <th>Aktivan od</th>
                            <th>Radnih sati h</th>
                            <th>Zarada $</th>
                            <th>Akcija</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($employees as $employee)
                        <tr>
                            <td>{{$employee->fullName()}} </td>
                            <td>{{$employee->onProjects()}}</td>
                            <td>{{$employee->created_at->format('d.m.Y')}}</td>
                            <td>{{$employee->loggedTime()}}</td>
                            <td>{{$employee->earned()}}</td>
                            <td>
                                <a href="{{ route('employee', $employee->id) }}" class="btn btn-primary btn-sm text-white">Izmeni</a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        function randomPassword(length) {
            var chars = "abcdefghijklmnopqrstuvwxyz!@#$%^&*()-+<>ABCDEFGHIJKLMNOP1234567890";
            var pass = "";
            for (var x = 0; x < length; x++) {
                var i = Math.floor(Math.random() * chars.length);
                pass += chars.charAt(i);
            }
            return pass;
        }

        function generate() {
            myform.password.value = randomPassword(10);
        }
    </script>
@endsection