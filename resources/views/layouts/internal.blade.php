@extends('layouts.layout-client')

@section('main-content')
  @include('layouts.navbar-client')
    @yield('home')          
  @include('layouts.footer-client')              
@endsection