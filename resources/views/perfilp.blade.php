@extends('layouts.app')
@section('content')
<div class="jumbotron" style="background: url('/media/img/recursos/footer-bg.png') center no-repeat; background-size: cover;">
  <programa id="{{$programa->id}}"></programa>
</div>
<div class="container" style="padding: 20px 0 50px 0;">
  <div class="row">
    <div class="col-md-8">
      <div>
        <h3>Educación</h3>
        <hr>
        <div class="text-justify">
          {{$programa->alcance}}
        </div>
      </div>
      <br><br>
      <div>
        <h3>Participantes</h3>
        <hr>
        <div class="row">
          <div class="col"><b>Nombre</b></div>
          <div class="col"><b>País</b></div>
          <div class="col"><b>Folio</b></div>
        </div>
        <hr>
        @foreach ($programa->participantes as $key => $participant)
          <div class="row">
            <div class="col">
              {{$participant->nombre}}
            </div>
            <div class="col">
              {{$participant->pais->nombre}}
            </div>
            <div class="col">
              {{$participant->folio}}
            </div>
          </div>
      @endforeach
      </div>
    </div>
    <div class="col-sm-4">
      <div>
        <h3>Contacto</h3>
        <hr>
        <div>
          <ul class="contact-list">
            <li><img width="40" src="{{asset('media/img/recursos/folio-icon.png')}}" alt="folio icon"> {{$programa->empresa->user->folio}}</li>
            @if ($programa->empresa->telefono)
              <li><a href="callto:{{$programa->empresa->telefono}}"><img width="40" src="{{asset('media/img/recursos/tel-icon.png')}}" alt="telefono icon"> {{$programa->empresa->telefono}}</a></li>
            @endif
            @if ($programa->empresa->pais)
              <li><img width="40" src="{{asset('media/img/recursos/entidad-icon.png')}}" alt="pais icon"> {{$programa->empresa->pais->nombre}}</li>
            @endif
            <li><a href="mailto:{{$programa->empresa->user->email}}"><img width="40" src="{{asset('media/img/recursos/mail-icon.png')}}" alt="mail icon"> {{$programa->empresa->user->email}}</a></li>
            @if ($programa->empresa->website)
              <li><a target="_blank" href="http://{{$programa->empresa->website}}"><img width="40" src="{{asset('media/img/recursos/web-icon.png')}}" alt="website icon"> {{$programa->empresa->website}}</a></li>
            @endif
          </ul>
        </div>
      </div>
      <div>
        <h3>Redes sociales</h3>
        <hr>
        <div>
          <ul class="social-list-float">
            @if ($programa->empresa->fb)
              <li><a target="_blank" href="https://{{$programa->empresa->fb}}"><img width="40" src="{{asset('media/img/recursos/fb-logo.png')}}" alt="fb icon"></a></li>
            @endif
            @if ($programa->empresa->tw)
              <li><a target="_blank" href="https://{{$programa->empresa->tw}}"><img width="40" src="{{asset('media/img/recursos/tw-logo.png')}}" alt="fb icon"></a></li>
            @endif
            @if ($programa->empresa->in)
              <li><a target="_blank" href="https://{{$programa->empresa->in}}"><img width="40" src="{{asset('media/img/recursos/in-logo.png')}}" alt="fb icon"></a></li>
            @endif
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="jumbotron" style="margin-bottom: 0; background: url('/media/img/recursos/footer-bg.png') center no-repeat; background-size: cover;">
  <valoraciones userid="{{$programa->id}}"></valoraciones>
</div>
@endsection
