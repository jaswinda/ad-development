@extends('layouts.app')

@section('content')
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <a class="navbar-brand" href="#">{{auth()->user()->name}}</a>
      <a class="navbar-brand" href="#"> {{auth()->user()->email}} </a>
      <a class="navbar-brand" href="{{ route('logout') }}"
        onclick="event.preventDefault();
                      document.getElementById('logout-form').submit();">
       Logout

     <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
         @csrf
     </form></a>
    </div>
  </nav>

  <div class="container">
      @livewire('user-form')
  </div>
@endsection
