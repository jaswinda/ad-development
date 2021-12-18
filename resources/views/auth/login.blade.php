@extends('layouts.app')

@section('content')
<div class="container d-flex flex-wrap justify-content-center align-items-center vh-100 vw-100">
    <div class="row col-12 col-md-8 col-lg-6 shadow rounded p-3">
        <h2 class="mb-3">Login</h2>

        <hr />
        <div class="col-md-12">
            <form class="row g-3" method="POST" action="{{ route('auth.singin') }}">
                @csrf
                <div class="col-12">
                    <label class="form-label">Email</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-md-12">
                    <label class="form-label">Password: </label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" required autocomplete="current-password"
                        {{-- title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" --}}
                        {{-- pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" --}}
                        >

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="inputState" class="form-label">Database</label>
                    <select name="database" required id="inputState" class="form-select">
                        <option selected value="db1">Database 1</option>
                        <option value="db2">Database 2</option>
                    </select>
                </div>
                <div class="row my-3">
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{
                                old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row mb-0">
                    <div class="col-md-8 ">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Login') }}
                        </button>


                    </div>
                </div>
                <div class="row mb-0">
                    <div class="col-md-8 ">
                        @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <a class="btn btn-link" href="/register">
                            Don't have an account? Sign up
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Login') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{
                                            old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Login') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    @endsection
