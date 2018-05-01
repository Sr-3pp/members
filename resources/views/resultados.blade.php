@extends('layouts.cvs')


@section('content')
   <section class="container-fluid text-center" id="bg" data-type="parallax_section" data-speed="10">
     <div class="container">
    <div class="row">
        <div class="col-md-12 ">
            <div class="panel panel-default">
                <div class="panel-heading" >
                <table style="width:100%">
                    <tr>
                        <td style="text-align:left">
                            Resultados:
                        </td>
                        <td>
                            <a href="/" class="btn btn-primary pull-right">Regresar</a>
                        </td>
                    </tr>
                </table>
                
                
                </div>
                <div class="panel-heading" style="height:auto; min-height:50px;">
                  
                                 {{ Form::open(array('url' => 'resultados', 'method' => 'GET', 'role' => 'search')) }}
                                <div class="col-md-3">{{Form::text('name',null,['class' => 'form-control', 'placeholder' => 'Nombre'])}}</div>
                                <div class="col-md-3">@include('partials.country-form')</div>
                                <div class="col-md-3">@include('partials.category-form')</div>
                                <div class="col-md-3">
                                    {{Form::submit('Buscar', ['class' => 'form-control'])}}
                                </div>
                                {{ Form::close() }}
                           
                </div>
               @if($search == '' && $categoria == '')
               <div class="panel-body">
                   <div style="padding:20px;">
                       <h2>
                           Captura un nombre, selecciona un país o categoría para iniciar tu búsqueda.
                       </h2>
                   </div>
               </div>
               @else
                <div class="panel-body text-center row">
                   @foreach($usuarios as $usuario)
                     <?php 
                           
                        $categoria = json_decode($usuario->categoria);
                        $decodeP = json_decode($usuario->info);
                        $flag = $usuario->pais;
                         $flag = utf8_decode($flag);
                            $flag = strtr($flag, utf8_decode($originales), $modificadas);
                    
                    ?>
                      @if($usuario->categoria == 'empresa')
                           <?php $color= '#30bdff'; ?>
                          @else
                          
                         
                          @if($categoria->coach == '3')
                          <?php $color= '#f5821d'; ?>
                          @else
                          
                          @endif
                          @if($categoria->capacitador == '2')
                          <?php $color= '#92c860'; ?>
                          @else
                          
                          @endif
                          @if($categoria->consultor == '4')
                          
                          <?php $color= '#01b1af'; ?>
                          @else
                          
                          @endif
                        @endif
                        @if($usuario->activo == '1')
                       <div style="padding:10px;" class="col-md-6">
                          
                          
                          <div class="panel-agent">
                               <div class="header-result" style="background:{{$color}};">
                                  <div style="width:100%;">

                                             <div class="container" style="width:100%; margin-top:0px; height:100%;">
                                                  
                                                     <div class="row">
                                                        <div class="col-md-3 member-pic">
                                                            <div class="profile-pic-result">
                                               <p style="border-radius:120px; overflow:hidden; width:120px; height:120px; background: url('{{asset('IMG/agentes/'.$usuario->foto)}}') center; background-size:cover; " >

                                               </p>
                                                <div class="circle-flag-result">
                                                    <img class="result-flag" src="{{asset('IMG/flags/'.$flag)}}.png" width="60" alt="">
                                                </div>
                                            </div> 
                                                        </div>
                                                         <div class="col-md-9" style="vertical-align:middle; height:70%!important;">
                                                         <table class="pull-right">
                                                             <tr>
                                                                 <td style="vertical-align:middle">
                                                                     <p class="user-name-results text-right"  style="line-height:30px;">
                                                                       @if($usuario->tipo == 'empresa')
                                                                        {{$usuario->name}} 
                                                                       @else
                                                                       {{$usuario->name}} 
                                                                       {{$usuario->apellido_p}} {{$usuario->apellido_m}}
                                                                       @endif
                                                                    </p>
                                                                 </td>
                                                                 <td style="padding:5px;">
                                                                   
                                                                       @if($usuario->categoria == 'empresa')
                                                                       <img class="cat-icon" src="{{asset('IMG/categorias/empresa.png')}}" alt="">
                                                                     
                                                                        @else
                                                                        
                                                                        
                                                                        @if($categoria->coach == '3')
                                                                        <img class="cat-icon" src="{{asset('IMG/categorias/coach.png')}}" alt="">
                                                                     
                                                                        @else
                                                                        
                                                                        @endif
                                                                        @if($categoria->capacitador == '2')
                                                                        <img class="cat-icon" src="{{asset('IMG/categorias/capacitador.png')}}" alt="">
                                                                      
                                                                        @else
                                                                        
                                                                        @endif
                                                                        @if($categoria->consultor == '4')
                                                                        <img class="cat-icon" src="{{asset('IMG/categorias/consultor.png')}}" alt="">
                                                                        
                                                                        @else
                                                                        
                                                                        @endif
                                                                        @endif
                                                                    
                                                               
                                                                 </td>
                                                             </tr>
                                                         </table>
                                                          
                                                            
                                                 </div>  
                                                     </div>  
                                                <div class="row">     
                                                           <div class="col-sm-12">
                                                                <div class="text-right" style="padding-top:5px;">
                                                                       @if($usuario->categoria == 'empresa')
                                                                      
                                                                        Empresa | 
                                                                        @else
                                                                        @if($categoria->coach == '3')
                                                                       
                                                                        Coach | 
                                                                        @else
                                                                        
                                                                        @endif
                                                                        @if($categoria->capacitador == '2')
                                                                       
                                                                        Capacitador | 
                                                                        @else
                                                                        
                                                                        @endif
                                                                        @if($categoria->consultor == '4')
                                                                       
                                                                        Consultor 
                                                                        @else
                                                                        
                                                                        @endif
                                                                        @endif
                                                                        
                                                                  </div>
                                                                   <div class="pull-right" style="margin-top:0px;">
                                                     
                                                             @if($usuario->urlFB != '')
                                                                 <a href="http://{{$usuario->urlFB}}">
                                                                     <img class="social-icon" src="{{asset('IMG/recursos/fb-icon.png')}}" alt="">
                                                                 </a>
                                                             @else
                                                             @endif
                                                              
                                                            @if($usuario->urlTW != '')
                                                                 <a href="http://{{$usuario->urlTW}}">
                                                                     <img class="social-icon" src="{{asset('IMG/recursos/tw-icon.png')}}" alt="">
                                                                 </a>
                                                             @else
                                                             @endif
                                                                     
                                                            @if($usuario->urlIN != '')
                                                                 <a href="http://{{$usuario->urlIN}}">
                                                                     <img class="social-icon" src="{{asset('IMG/recursos/in-icon.png')}}" alt="">
                                                                 </a>
                                                             @else
                                                             @endif
                                                            
                                                            @if($usuario->urlwww != '')
                                                                 <a href="http://{{$usuario->www}}">
                                                                     <img class="social-icon" src="{{asset('IMG/recursos/www-icon.png')}}" alt="">
                                                                 </a>
                                                             @else
                                                             @endif      
                                                          
                                                 </div>
                                                           </div>
                                                     </div>
                                                
                                                 
                                                
                                             </div>

                                      </div>
                               </div>
                               <div>
                                   <table style="width:80%; margin:30px auto 30px auto;">
                                       <tr>
                                           <td class="text-rigthrigth info-result">
                                               <strong>Folio</strong>
                                           </td>
                                           <td style="text-align:left">
                                               {{$usuario->folio}}
                                           </td>
                                       </tr>
                                       <tr>
                                           <td class="text-rigth info-result">
                                               <strong>Tipo de Miembro</strong>
                                           </td>
                                           <td style="text-align:left">
                                               {{$usuario->rango}}
                                           </td>
                                       </tr>
                                       <tr>
                                           <td class="text-rigth info-result">
                                               <strong>Correo electónico</strong>
                                           </td>
                                           <td style="text-align:left">
                                               {{$usuario->email}}
                                           </td>
                                       </tr>
                                      @if($usuario->www != '')
                                         <tr>
                                           <td class="text-rigth info-result" >
                                               <strong>Sitio Web</strong>                                           </td>
                                           <td style="text-align:left">
                                               {{$usuario->www}}
                                           </td>
                                       </tr>  
                                      @else
                                      
                                      @endif
                                   </table>
                               </div>
                                <a href="{{url('/show' ,$usuario->id)}}" class="btn btn-warning" style="background:{{$color}}; margin:0 auto; border-color:transparent; box-shadow: 1px 2px 4px #d4d4d4">
                                    Mas información
                                </a>
                            </div>
                          
                          
                          
                       </div>
                       @else
                       
                       @endif
                   @endforeach
                </div>
               @endif
            </div>
        </div>
    </div>
</div>
</section>
@endsection