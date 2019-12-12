<!-- Sidebar Navigation Menus-->
@php
    $unpaid = \App\Invoice::where('paid', 0)->count();
@endphp
<div class="main-menu">
    <ul id="side-main-menu" class="side-menu list-unstyled">
        <li><a href="{{ route('dashboard') }}"> <i class="icon-clock"></i>Aktivnosti</a></li>
        <li><a href="{{ route('admin-projects') }}"> <i class="icon-form"></i>Projekti</a></li>
        <li><a href="{{ route('employees') }}"> <i class="icon-user"></i>Zaposleni</a></li>
        <li><a href="#exampledropdownDropdown" aria-expanded="false" data-toggle="collapse"> <i class="icon-bill"></i>Fakture
                @if($unpaid)
                    <div class="badge badge-warning">{{$unpaid}} novih</div>
                @endif
            </a>
            <ul id="exampledropdownDropdown" class="collapse list-unstyled ">
                <li><a href="{{ route('unpaid-invoices') }}">Neplaćene</a></li>
                <li><a href="{{ route('paid-invoices') }}">Plaćene</a></li>
            </ul>
        </li>
    </ul>
</div>