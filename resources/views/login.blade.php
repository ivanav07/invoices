@extends('layouts.main')

@section('content')
    <div class="page login-page">
        <div class="container">
            <div class="form-outer text-center d-flex align-items-center">
                <div class="form-inner">
                    <div class="logo text-uppercase"><span>Radi i </span><strong class="text-primary"> Naplati</strong></div>
                    <p>Ova aplikacija Vam omogućava da pratite Vaše aktivnosti ili aktivnosti Vaših zaposlenih na projektu i da taj rad
                        naplatite.</p>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group-material">
                            <input id="login-username" type="email" name="email" class="input-material"
                                   name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            <label for="email" class="label-material">Email</label>
                        </div>
                        <div class="form-group-material">
                            <input id="login-password" type="password" name="password" class="input-material"
                                   name="password" value="{{ old('password') }}" required autocomplete="password" autofocus >
                            <label for="password" class="label-material">Password</label>
                        </div>
                        <div class="form-group text-center">
                            @error('email')
                            <span class="text-danger">{{ $message }} </span>
                            @enderror
                            <button type="submit" class="btn btn-primary">Login</button>
                            <!-- This should be submit button but I replaced it with <a> for demo purposes-->
                        </div>
                    </form>
                    <a href="{{ route('password.request') }}" class="forgot-pass">Forgot Password?</a>
                </div>
                <div class="copyrights text-center">
                    <p>Design by <a href="https://bootstrapious.com/p/bootstrap-4-dashboard" class="external">Bootstrapious</a></p>
                    <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
                </div>
            </div>
        </div>
    </div>
@endsection
