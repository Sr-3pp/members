@extends('layouts.cvs')

@section('content')
<div class="container-fluid">
    <div class="container">
       @if (Route::has('login'))
        <div class="top-right links">
           @include('partials.user-menu')
            @if (Auth::check())
                <a href="{{ url('/show') }}" style="margin-top:-90px!important;">Perfil</a>
            @else
                <a href="{{ url('/login') }}">Acceder</a>
                <a href="{{ url('/register') }}">Crear Perfil</a>
            @endif
        </div>
    @endif
        <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
               
                <div class="panel-body">
                    <a href="{{url('/')}}" class="btn btn-warning">Regresar</a>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

@endsection