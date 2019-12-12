@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <!-- Page Header-->
        <header>
            <h1 class="text-center">Vaše fakture</h1>
        </header>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive text-center">
                    <table class="table table-striped table-sm">
                        <thead>
                        <tr>
                            <th>Datum kreiranja</th>
                            <th>Faktura</th>
                            <th>Iznos</th>
                            <th>Izmireno</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $total = 0 @endphp
                        @foreach($invoices as $invoice)
                            <tr>
                                <td>{{$invoice->created_at->format('d.m.Y')}}</td>
                                <td><a href="{{route('invoice', $invoice->id)}}" target="_blank"><i class="fa fa-file-pdf-o"
                                                                                                    aria-hidden="true"></i></a></td>
                                <td>{{$invoice->total_sum}}</td>
                                <td>@if($invoice->paid){{$invoice->updated_at->format('d.m.Y')}}@else Nije plaćeno @endif</td>
                            </tr>
                            @php
                                if($invoice->paid) $total += $invoice->total_sum
                            @endphp
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-right"> Ukupno naplaćeno: <strong>{{$total}}</strong></div>
            </div>
        </div>
    </div>
@endsection