@extends('layouts.app')
@section('content')
<div class="jumbotron" style="background: url('/media/img/recursos/footer-bg.png') center no-repeat; background-size: cover;">
  <perfil zona="{{$user->perfil->pais->zona}}" user="{{$user}}" profile="{{$user->perfil}}" pais="{{$user->perfil->pais->nombre}}" categorias="{{$user->categorias}}"></perfil>
</div>
<div class="container">
  <div class="row">
    <div class="col-md-8">
      <div>
        <h3>Educación</h3>
        <hr>
        <div class="text-justify big-text">
          {{$user->perfil->educacion}}
        </div>
      </div>
      <br><br>
      <div>
        <h3>Resumen</h3>
        <hr>
        <div class="text-justify big-text">
          {{$user->perfil->resumen}}
        </div>
      </div>
    </div>
    <div class="col-sm-4">
      <div>
        <h3>Contacto</h3>
        <hr>
        <div>
          <ul class="contact-list">
            <li><img width="40" src="{{asset('media/img/recursos/folio-icon.png')}}" alt="folio icon"> {{$user->folio}}</li>
            @if ($user->perfil->telefono)
              <li><a href="callto:{{$user->perfil->telefono}}"><img width="40" src="{{asset('media/img/recursos/tel-icon.png')}}" alt="telefono icon"> {{$user->perfil->telefono}}</a></li>
            @endif
            @if ($user->perfil->celular)
              <li><a href="callto:{{$user->perfil->celular}}"><img width="40" src="{{asset('media/img/recursos/cel-icon.png')}}" alt="celular icon"> {{$user->perfil->celular}}</a></li>
            @endif
            @if ($user->perfil->pais)
              <li><img width="40" src="{{asset('media/img/recursos/entidad-icon.png')}}" alt="pais icon"> {{$user->perfil->pais->nombre}}</li>
            @endif
            <li><a href="mailto:{{$user->email}}"><img width="40" src="{{asset('media/img/recursos/mail-icon.png')}}" alt="mail icon"> {{$user->email}}</a></li>
            @if ($user->perfil->website)
              <li><a target="_blank" href="http://{{$user->perfil->website}}"><img width="40" src="{{asset('media/img/recursos/web-icon.png')}}" alt="website icon"> {{$user->perfil->website}}</a></li>
            @endif
          </ul>
        </div>
      </div>
      <div>
        <h3>Redes sociales</h3>
        <hr>
        <div>
          <ul class="social-list-float">
            @if ($user->perfil->fb)
              <li><a target="_blank" href="https://facebook.com/{{$user->perfil->fb}}"><img width="40" src="{{asset('media/img/recursos/fb-logo.png')}}" alt="fb icon"></a></li>
            @endif
            @if ($user->perfil->tw)
              <li><a target="_blank" href="https://twitter.com/{{$user->perfil->tw}}"><img width="40" src="{{asset('media/img/recursos/tw-logo.png')}}" alt="fb icon"></a></li>
            @endif
            @if ($user->perfil->in)
              <li><a target="_blank" href="https://linkedin.com/{{$user->perfil->in}}"><img width="40" src="{{asset('media/img/recursos/in-logo.png')}}" alt="fb icon"></a></li>
            @endif
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<hr>
<div class="jumbotron" style="margin-bottom: 0; background: url('/media/img/recursos/footer-bg.png') center no-repeat; background-size: cover;">
  <valoraciones userid="{{$user->id}}"></valoraciones>
</div>
@endsection
