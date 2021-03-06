@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <!-- Page Header-->
        <header>
            <h1 class="text-center">Isplaćene fakture</h1>
        </header>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive text-center">
                    <table class="table table-striped table-sm">
                        <thead>
                        <tr>
                            <th>Datum kreiranja</th>
                            <th>Zaposleni</th>
                            <th>Faktura</th>
                            <th>Iznos</th>
                            <th>Datum isplate</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($invoices as $invoice)
                        <tr>
                            <td>{{$invoice->created_at->format('d.m.Y')}}</td>
                            <td>{{$invoice->user()->fullName()}}</td>
                            <td><a href="{{route('invoice', $invoice->id)}}" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a></td>
                            <td>{{$invoice->total_sum}}</td>
                            <td>{{$invoice->updated_at->format('d.m.Y')}}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection