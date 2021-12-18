@extends('layouts.app')

@section('content')
<div class="container d-flex flex-wrap justify-content-center align-items-center vh-100 vw-100">
    <div class="row col-12 col-md-8 col-lg-6 shadow rounded p-3">
        <h2 class="mb-3">Sign Up</h2>
        <hr />
        <div class="col-md-12">
            <form class="row g-3" method="POST" action="{{ route('register') }}">
                @csrf
                <div class="col-md-12">
                    <label class="form-label">First Name</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                        value="{{ old('name') }}" required autocomplete="name" autofocus>

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-12">
                    <label class="form-label">Email</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autocomplete="email">

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Password</label>
                    <input title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"
                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" id="password" type="password"
                        class="form-control @error('password') is-invalid @enderror" name="password"
                        required autocomplete="new-password">

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Confirm Password</label>
                    <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password">
                </div>
                <div class="col-12">
                    <label class="form-label">Address</label>
                    <input name="address" type="text" class="form-control" placeholder="Address">
                </div>
                <div class="col-12 mb-2">
                    <label for="inputState" class="form-label">Database</label>
                    <select name="database" id="inputState" class="form-select">
                        <option selected value="db1">Database 1</option>
                        <option value="db2">Database 2</option>
                    </select>
                </div>
                <div class="row mb-0">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Register') }}
                        </button>
                    </div>
                    <div class="col-md-8">
                        <a class="btn btn-link" href="/login">
                           Already have account? Login
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
