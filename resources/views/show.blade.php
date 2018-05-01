@extends('layouts.cvs')
@section('content')
<div class="container-fluid">
    <div class="container" style="margin-top:50px;">
        <div class="col-md-4">
           <div style="border:solid 10px {{$color}}; height:272.5px; width:272.5px; border-radius:300px; padding:2px">
              <!-- de aqui a arriba, todo bien ------------------->
               <div style="background:url('{{asset('IMG/agentes/'.$usuario->foto)}}') center; background-size:cover;" class="show-pic"></div>
           </div>
           <br>
            <div class="skills">
                <div class="row">
                  <table>
                      <tr>
                          <td style="padding:10px;">
                              <div  style="border:solid 4px #FFF; border-radius:50px; text-align:center;">
                                  @if($continente == 'africa')
                                  <img class="" src="{{asset('IMG/banderas/'.$continente.'/'.$pais)}}.png" width="45" alt="" style="width:45px; margin:3px 3px;">
                                  @else
                                   <img class="" src="{{asset('IMG/banderas/'.$continente.'/'.$zona.'/'.$pais)}}.png" width="45" alt="" style="width:45px; margin:3px 3px;">
                                  @endif
                              </div>
                          </td>
                          <td>
                              &nbsp;
                          </td>
                          <td style="text-transform:capitalize;">
                              {{$usuario->pais}}
                              <p style="font-size:15px; margin-bottom:4px;">{{$ciudad}}</p>
                              @if($continente == 'africa')
                              <?php $mapa= 'africa' ?>
                              <p style="font-size:15px;">(África)</p>
                               @else
                                   @if($continente == 'america')
                                      @if($zona == 'norte')
                                         <?php $mapa= 'americanorte' ?>
                                          <p style="font-size:15px;">(América del norte)</p>
                                      @else
                                          @if($zona == 'sur')
                                          <?php $mapa= 'americasur' ?>
                                          <p style="font-size:15px;">(Sudámerica)</p>
                                          @else
                                              @if($zona == 'centro')
                                                 <?php $mapa= 'americacentral' ?>
                                                  <p style="font-size:15px;">(Centro Ámerica)</p>
                                              @else
                                                @if($zona == 'antillas')
                                                   <?php $mapa= 'americasur' ?>
                                                    <p style="font-size:15px;">(Antillas)</p>
                                                @else
                                                    @if($zona == 'central')
                                                       <?php $mapa= 'asia' ?>
                                                        <p style="font-size:15px;">(Asia central)</p>
                                                    @else
                                                        @if($zona == 'occidente')
                                                           <?php $mapa= 'asia' ?>
                                                            <p style="font-size:15px;">(Asia occidental)</p>
                                                        @else
                                                            @if($zona == 'oriente')
                                                               <?php $mapa= 'asia' ?>
                                                                <p style="font-size:15px;">(Asia oriental)</p>
                                                            @else
                                                                @if($zona == 'sur')
                                                                   <?php $mapa= 'asia' ?>
                                                                    <p style="font-size:15px;">(Sur de Asia)</p>
                                                                @else
                                                                    @if($zona == 'sureste')
                                                                       <?php $mapa= 'asia' ?>
                                                                        <p style="font-size:15px;">(Sureste de Asia)</p>
                                                                    @else

                                                                    @endif
                                                                @endif
                                                            @endif
                                                        @endif
                                                    @endif
                                                @endif
                                              @endif
                                          @endif
                                    @endif
                                   @else
                                        @if($continente == 'asia')
                                            <?php $mapa= 'asia' ?>
                                             @if($zona == 'central')
                                          <p style="font-size:15px;">(Asia central)</p>
                                              @else
                                                  @if($zona == 'occidental')
                                                  <p style="font-size:15px;">(Asia Occidental)</p>
                                                  @else
                                                      @if($zona == 'oriente')
                                                          <p style="font-size:15px;">(Asia Oriental)</p>
                                                      @else
                                                        @if($zona == 'sur')
                                                            <p style="font-size:15px;">(Sur de Asia)</p>
                                                        @else
                                                            @if($zona == 'sureste')
                                                                <p style="font-size:15px;">(Sureste de Asia)</p>
                                                            @else


                                                            @endif
                                                        @endif
                                                      @endif
                                                  @endif
                                            @endif
                                        @else
                                            @if($continente == 'europa')
                                                <?php $mapa= 'europa' ?>
                                                 @if($zona == 'centralE')
                                              <p style="font-size:15px;">(Europa central)</p>
                                                  @else
                                                      @if($zona == 'este')
                                                      <p style="font-size:15px;">(Europa del Este)</p>
                                                      @else
                                                          @if($zona == 'norteE')
                                                              <p style="font-size:15px;">(Europa del Norte)</p>
                                                          @else
                                                            @if($zona == 'surE')
                                                                <p style="font-size:15px;">(Sur de Europa)</p>
                                                            @else
                                                                @if($zona == 'oeste')
                                                                    <p style="font-size:15px;">(Europa del Oeste)</p>
                                                                @else

                                                                @endif
                                                            @endif
                                                          @endif
                                                      @endif
                                                @endif
                                            @else
                                                 @if($continente == 'oceania')
                                                    <?php $mapa= 'oceania' ?>
                                                     @if($zona == 'australasia')
                                                  <p style="font-size:15px;">(Australasia)</p>
                                                      @else
                                                          @if($zona == 'melanecia')
                                                          <p style="font-size:15px;">(Melanesia)</p>
                                                          @else
                                                              @if($zona == 'micronesia')
                                                                  <p style="font-size:15px;">(Micronesia)</p>
                                                              @else
                                                                @if($zona == 'polinesia')
                                                                    <p style="font-size:15px;">(Polinesia)</p>
                                                                @else

                                                                @endif
                                                              @endif
                                                          @endif
                                                    @endif
                                                @else

                                                @endif
                                            @endif
                                        @endif
                                    @endif
                                @endif
                          </td>
                      </tr>
                  </table>
                </div>
                <div class="row">
                   <table>
                      <tr>
                          <td style="padding:8px;">
                              <div  style="border:none 4px #FFF; border-radius:50px; text-align:center;"><img class="result-flag" src="{{asset('IMG/medallas/'.$usuario->rango)}}.png" width="43" alt="" style="width:65px; margin:3px -2px;"></div>
                          </td>
                          <td>
                              &nbsp;
                          </td>
                          <td style="text-transform:capitalize;">
                            {{$usuario->rango}}
                          </td>
                      </tr>
                  </table>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div style="color:#FFF; font-size:50px!important; font-weight:100!important; font-style:normal; position:relative;">
             <table style="width:100%; margin-bottom:-70px;">
                 <tr>
                     <td>
                          @if($usuario->tipo == 'empresa')
                  {{$usuario->name}}
              @else
                  {{$usuario->name}} {{$usuario->apellido_p}} {{$usuario->apellido_m}}
              @endif
                     </td>
                     <td style="text-align:right!important;">
                             @if(Auth::guest())

                              @else
                                @if($usuario->id == Auth::user()->id)
                               <a href="{{url('auth/edit-profile/'.Auth::user()->id)}}" class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i> &nbsp;Editar perfil</a>
                               @else

                               @endif
                           @endif
                     </td>
                 </tr>
             </table>


                  <br>
                  <table>
                      <tr>@if($usuario->categoria == 'empresa')
                           <td style="font-size:15px;">
                               <img src="{{asset('IMG/categorias/empresa')}}.png" style="margin:1px; width:20%; max-width:120px" alt="">
                                 Empresa
                                </td>
                            @else
                            @foreach($categorias as $tipo)
                           @if($tipo > '0')
                            @if($tipo == '2')
                                 <td style="font-size:15px;">
                                     <img src="{{asset('IMG/categorias/capacitador')}}.png" style="margin:1px; width:20%; max-width:120px" alt=""> Capacitador
                                 </td>
                            @endif
                            @if($tipo == '3')
                                <td style="font-size:15px;">
                                    <img src="{{asset('IMG/categorias/coach')}}.png"  style="margin:1px; width:20%; max-width:120px" alt="">
                                Coach
                                </td>
                            @endif
                            @if($tipo == '4')
                                <td style="font-size:15px;">
                                    <img src="{{asset('IMG/categorias/consultor')}}.png" width="50" style="margin:1px; width:20%; max-width:120px" alt="">
                                Consultor
                                </td>
                            @endif
                            @if($tipo == '5')
                                <td style="font-size:15px;">
                                    <img src="{{asset('IMG/categorias/programa')}}.png" width="50" style="margin:1px; width:20%; max-width:120px" alt="">
                                Programa
                                </td>
                            @endif
                        @else
                        @endif
                        @endforeach
                        @endif
                      </tr>
                  </table>


            </div><hr><br>
            <img src="{{asset('IMG/mapas/'.$mapa)}}.png" style="width:100%; margin-top:20px;" alt="">
        </div>
    </div>
</div><br>
<br>
<br>
<div class="container-fluid" style="background:#FFF;">
    <div class="container">
        <div class="row" style="padding:50px 0;">
            <div class="col-md-8">
                <div class="row text-left">
                   @if($usuario->categoria == 'empresa')
                    <h3>Descripción de la empresa</h3>
                    @else
                    <h3>Educación</h3>
                    @endif
                    <p style="width:100%; padding:20px; text-align:justify;">
                        {!! $resumen !!}
                    </p>
                </div>
                <div class="row">
                   @if($usuario->categoria == 'empresa')
                    <h3>Curricula de la empresa</h3>
                   @else
                    <h3>CV Resumen</h3>
                    @endif
                    <div style="width:100%; padding:20px; text-align:justify; clear: both">
                        {!! $texto_1 !!}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div style="margin-left:10px;">
                    <h3>
                    Contacto
                </h3>
                <hr>
                <table class="contact-info">
                   <tr>
                       <td><img  src="{{asset('IMG/recursos/folio-icon.png')}}" alt="">{{$usuario->folio}}</td>
                   </tr>
                    <tr>
                        <td><img  src="{{asset('IMG/recursos/tel-icon.png')}}" alt=""> <a style="color:#636b6f; text-decoration:none" href="callto:{{$usuario->telefono}}">{{$usuario->telefono}}</a></td>
                    </tr>
                    @if(isset($usuario->cel))
                    <tr>
                        <td><img  src="{{asset('IMG/recursos/cel-icon.png')}}" alt=""><a href="callto:{{$usuario->cel}}" style="color:#636b6f; text-decoration:none">{{$usuario->cel}}</a></td>
                    </tr>
                    @else
                    @endif
                    @if($residencia != '0')
                    <tr>
                        <td><img  src="{{asset('IMG/recursos/entidad-icon.png')}}" alt="">{{$residencia}}</td>
                    </tr>
                    @endif
                    @if($idiomas == '')

                    @else
                    <tr>
                        <td><img  src="{{asset('IMG/recursos/idiomas-icon.png')}}" alt="">{{$idiomas}}</td>
                    </tr>
                    @endif
                    <tr>
                        <td><img  src="{{asset('IMG/recursos/mail-icon.png')}}" alt=""> <a style="color:#636b6f; text-decoration:none" href="mailto:{{$usuario->email}}">{{$usuario->email}}</a></td>
                    </tr>
                    @if($usuario->www != '')
                    <tr>
                        <td><img  src="{{asset('IMG/recursos/web-icon.png')}}" alt=""> <a style="color:#636b6f; text-decoration:none" href="http://{{$usuario->www}}">{{$usuario->www}}</a></td>
                    </tr>

                    @else

                    @endif
                </table>
                <h3>Redes Sociales</h3>
                <div class="text-center social-res">
                     @if($usuario->urlTW != '')
                     <ul><a href="{{$usuario->urlTW}}"><img style="max-width:40px; width:100%;" src="{{asset('IMG/recursos/tw-logo.png')}}" alt=""></a></ul>

                    @else

                    @endif
                      @if($usuario->urlFB != '')
                     <ul><a href="{{$usuario->urlFB}}"><img style="max-width:40px; width:100%;" src="{{asset('IMG/recursos/fb-logo.png')}}" alt=""></a></ul>

                    @else

                    @endif
                    @if($usuario->urlIN != '')
                     <ul><a href="{{$usuario->urlIN}}"><img style="max-width:40px; width:100%;" src="{{asset('IMG/recursos/in-logo.png')}}" alt=""></a></ul>

                    @else

                    @endif
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- de aqui a abajo, todo bien ------------------->
<div class="container-fluid">
    <div class="container">
        <div class="row" style="padding:50px 10px; color:#FFF;">
            <div class="col-md-3" style="padding-top:80px;">
                @if($usuario->categoria == 'empresa')
                    <h3>Principales servicios</h3>
                @else
                    <h3>Áreas de expertise</h3>
                @endif
            </div>
            <div class="col-md-9">
                <table WIDTH="100%" class="valoraciones">
                    <tr>
                        <td style="width:15%">
                            <?php
                                $decode = json_decode($usuario->valoracion_1);
                                $percent = $decode->percent;
                                if($percent == 0){

                                }else{
                                    echo $decode->area;
                                }
                            ?>
                        </td>
                        <td>
                        <?php
                        $decode = json_decode($usuario->valoracion_1);
                        $percent = $decode->percent;
                        if($percent == 0){

                        }else{
                            echo str_repeat('<i class="glyphicon glyphicon-star"></i>', $percent);
                        } ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:15%">
                            <?php
                                $decode = json_decode($usuario->valoracion_2);
                                $percent = $decode->percent;
                                if($percent == 0){

                                }else{
                                    echo $decode->area;
                                }
                            ?>
                        </td>
                        <td>
                        <?php
                        $decode = json_decode($usuario->valoracion_2);
                        $percent = $decode->percent;
                        if($percent == 0){

                        }else{
                            echo str_repeat('<i class="glyphicon glyphicon-star"></i>', $percent);
                        } ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:15%">
                            <?php
                                $decode = json_decode($usuario->valoracion_3);
                                $percent = $decode->percent;
                                if($percent == 0){

                                }else{
                                    echo $decode->area;
                                }
                            ?>
                        </td>
                        <td>
                             <?php
                        $decode = json_decode($usuario->valoracion_3);
                        $percent = $decode->percent;
                        if($percent == 0){

                        }else{
                            echo str_repeat('<i class="glyphicon glyphicon-star"></i>', $percent);
                        } ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:15%">
                            <?php
                                $decode = json_decode($usuario->valoracion_4);
                                $percent = $decode->percent;
                                if($percent == 0){

                                }else{
                                    echo $decode->area;
                                }
                            ?>
                        </td>
                        <td>
                             <?php
                        $decode = json_decode($usuario->valoracion_4);
                        $percent = $decode->percent;
                        if($percent == 0){

                        }else{
                            echo str_repeat('<i class="glyphicon glyphicon-star"></i>', $percent);
                        } ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:15%"><?php
                                $decode = json_decode($usuario->valoracion_5);
                                $percent = $decode->percent;
                                if($percent == 0){

                                }else{
                                    echo $decode->area;
                                }
                            ?></td>
                        <td>
                             <?php
                        $decode = json_decode($usuario->valoracion_5);
                        $percent = $decode->percent;
                        if($percent == 0){

                        }else{
                            echo str_repeat('<i class="glyphicon glyphicon-star"></i>', $percent);
                        } ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
