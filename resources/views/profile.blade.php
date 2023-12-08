@extends('layouts.app')
@section('content')
<div class="jumbotron" style="background: url('/media/img/recursos/footer-bg.png') center no-repeat; background-size: cover;">
        @if (!$profile->empresa)            
            <perfil zona="{{$profile->pais->zona}}" empresa="{{json_encode($empresa)}}" profile="{{$profile}}" pais="{{$profile->pais->nombre}}" categorias="{{$categories}}"></perfil>
        @else
            <programa id="{{$profile->id}}"></programa>
        @endif
        </div>
        <div class="container">
        <div class="row">
            <div class="col-md-8">
            @if ($profile->educacion)
                <div>
                    <h3>Educación</h3>
                    <hr>
                    <div class="big-text">
                        {{$profile->educacion}}
                    </div>
                </div>
                <br><br>
                <div>
                    <h3>Resumen</h3>
                    <hr>
                    <div class="big-text">
                        {{$profile->resumen}}
                    </div>
                </div>
            @endif
            @if($profile->descripcion)
                    <div>
                        <h3>Descripción de la empresa</h3>
                        <hr>
                        <div class="big-text">
                        {{$profile->descripcion}}
                        </div>
                    </div>
                    <br><br>
                    <div>
                        <h3>Currícula de la empresa</h3>
                        <hr>
                        <div class="big-text">
                        {{$profile->cv}}
                        </div>
                    </div>
            @endif
            @if($profile->alcance)
                <div>
                    <h3>Objetivo</h3>
                    <hr>
                    <div class="big-text">
                    {{$profile->alcance}}
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
                    @foreach ($profile->participantes as $key => $participant)
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
            @endif
            </div>
            <div class="col-sm-4">
            <div>
                <h3>Contacto</h3>
                <hr>
                <div>
                <ul class="contact-list">
                    <li><img width="40" src="{{asset('media/img/recursos/folio-icon.png')}}" alt="folio icon"> {{$user_folio}}</li>
                    @if ($contact['telefono'])
                    <li><a href="callto:{{$contact['telefono']}}"><img width="40" src="{{asset('media/img/recursos/tel-icon.png')}}" alt="telefono icon"> {{$contact['telefono']}}</a></li>
                    @endif
                    @if ($contact['celular'])
                    <li><a href="callto:{{$contact['celular']}}"><img width="40" src="{{asset('media/img/recursos/cel-icon.png')}}" alt="celular icon"> {{$contact['celular']}}</a></li>
                    @endif
                    @if ($profile->pais)
                    <li><img width="40" src="{{asset('media/img/recursos/entidad-icon.png')}}" alt="pais icon"> {{$profile->pais->nombre}}</li>
                    @endif
                    <li><a href="mailto:{{$contact['email']}}"><img width="40" src="{{asset('media/img/recursos/mail-icon.png')}}" alt="mail icon"> {{$contact['email']}}</a></li>
                    @if ($contact['website'] && $contact['website'] !== null)
                    <li><a target="_blank" href="http://{{$contact['website']}}"><img width="40" src="{{asset('media/img/recursos/web-icon.png')}}" alt="website icon"> {{$contact['website']}}</a></li>
                    @endif
                </ul>
                </div>
            </div>
            <div>
                <h3>Redes sociales</h3>
                <hr>
                <div>
                <ul class="social-list-float">
                    @if ($contact['social']['fb'] && $contact['social']['fb'] !== null)
                    <li><a target="_blank" href="https://facebook.com/{{$contact['social']['fb']}}"><img width="40" src="{{asset('media/img/recursos/fb-logo.png')}}" alt="facebook icon"></a></li>
                    @endif
                    @if ($contact['social']['tw'] && $contact['social']['tw'] !== null)
                    <li><a target="_blank" href="https://twitter.com/{{$contact['social']['tw']}}"><img width="40" src="{{asset('media/img/recursos/tw-logo.png')}}" alt="twitter icon"></a></li>
                    @endif
                    @if ($contact['social']['in'] && $contact['social']['in'] !== null)
                    <li><a target="_blank" href="https://linkedin.com/{{$contact['social']['in']}}"><img width="40" src="{{asset('media/img/recursos/in-logo.png')}}" alt="linkedin icon"></a></li>
                    @endif
                    @if ($contact['social']['insta'] && $contact['social']['insta'] !== null)
                    <li><a target="_blank" href="https://instagram.com/{{$contact['social']['insta']}}"><img width="40" src="{{asset('media/img/recursos/in-logo.png')}}" alt="instagram icon"></a></li>
                    @endif
                </ul>
                </div>
            </div>
            </div>
        </div>
        </div>
        <hr>
        <div class="jumbotron" style="margin-bottom: 0; background: url('/media/img/recursos/footer-bg.png') center no-repeat; background-size: cover;">
        <valoraciones {{ $profile->participantes ? 'program='.$profile->id : 'userid='.$user_id }}></valoraciones>
        </div>
@endsection
