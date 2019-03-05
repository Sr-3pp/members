@extends('layouts.app')
@section('content')
<div class="jumbotron" style="background: url('/media/img/recursos/footer-bg.png') center no-repeat; background-size: cover;">
  <perfil zona="{{$user->empresa->pais->zona}}" user="{{$user}}" profile="{{$user->empresa}}" pais="{{$user->empresa->pais->nombre}}" categorias="{{$user->categorias}}"></perfil>
</div>
<div class="container" style="padding: 20px 0 50px 0;">
  <div class="row">
    <div class="col-md-8">
      <div>
        <h3>Clientes con los que hemos trabajado</h3>
        <hr>
        <div class="text-justify">
          {{$user->empresa->cv}}
        </div>
      </div>
      <br><br>
      <div>
        <h3>Resumen</h3>
        <hr>
        <div class="text-justify">
          {{$user->empresa->descripcion}}
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
            @if ($user->empresa->telefono)
              <li><a href="callto:{{$user->empresa->telefono}}"><img width="40" src="{{asset('media/img/recursos/tel-icon.png')}}" alt="telefono icon"> {{$user->empresa->telefono}}</a></li>
            @endif
            @if ($user->empresa->celular)
              <li><a href="callto:{{$user->empresa->celular}}"><img width="40" src="{{asset('media/img/recursos/cel-icon.png')}}" alt="celular icon"> {{$user->empresa->celular}}</a></li>
            @endif
            @if ($user->empresa->pais)
              <li><img width="40" src="{{asset('media/img/recursos/entidad-icon.png')}}" alt="pais icon"> {{$user->empresa->pais->nombre}}</li>
            @endif
            <li><a href="mailto:{{$user->email}}"><img width="40" src="{{asset('media/img/recursos/mail-icon.png')}}" alt="mail icon"> {{$user->email}}</a></li>
            @if ($user->empresa->website)
              <li><a target="_blank" href="http://{{$user->empresa->website}}"><img width="40" src="{{asset('media/img/recursos/web-icon.png')}}" alt="website icon"> {{$user->empresa->website}}</a></li>
            @endif
          </ul>
        </div>
      </div>
      <div>
        <h3>Redes sociales</h3>
        <hr>
        <div>
          <ul class="social-list-float">
            @if ($user->empresa->fb)
              <li><a target="_blank" href="https://facebook.com/{{$user->empresa->fb}}"><img width="40" src="{{asset('media/img/recursos/fb-logo.png')}}" alt="fb icon"></a></li>
            @endif
            @if ($user->empresa->tw)
              <li><a target="_blank" href="https://twitter.com/{{$user->empresa->tw}}"><img width="40" src="{{asset('media/img/recursos/tw-logo.png')}}" alt="fb icon"></a></li>
            @endif
            @if ($user->empresa->in)
              <li><a target="_blank" href="https://linkedin.com/{{$user->empresa->in}}"><img width="40" src="{{asset('media/img/recursos/in-logo.png')}}" alt="fb icon"></a></li>
            @endif
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="jumbotron" style="margin-bottom: 0; background: url('/media/img/recursos/footer-bg.png') center no-repeat; background-size: cover;">
  <valoraciones userid="{{$user->id}}"></valoraciones>
</div>
@endsection
