
<nav class="navbar navbar-default" style="height:200px!important; background:url({{asset('IMG/recursos/nav_bg.jpg')}}); border:none!important;">
              @if (Route::has('login'))
        <div class="top-right links">
           @include('partials.user-menu')
            @if (Auth::check())
                 @if(Auth::user()->tipo == 'Admin')
               <a href="{{url('adm/dashboard')}}" class="btn btn-warning"><i class="glyphicon glyphicon-list-alt"></i> &nbsp;Dashboard</a>
               @else
               
               @endif
               <a href="{{ url('/show/'.Auth::user()->id) }}">Perfil</a> 
            @else
                <a href="{{ url('/login') }}">Acceder</a>
                <a href="{{ url('/register') }}">Crear Perfil</a>
                <a href="{{ url('/register-empresa') }}">Registrar Empresa</a>
            @endif
        </div>
    @endif
            <div class="container">
                <div class="navbar-header" style="padding-top:40px;">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                       <img src="https://static.wixstatic.com/media/b258fc_1804aea6d7ff4188905eda7f86d65487.png/v1/fill/w_171,h_96,al_c,usm_0.66_1.00_0.01/b258fc_1804aea6d7ff4188905eda7f86d65487.png" alt="">
                    </a>
                </div>

                <div class="collapse navbar-collapse menu" id="app-navbar-collapse">
                    <ul>
                        <a href="https://www.internationalccn.org/formulario">Contacto</a>
                         <img src="{{asset('IMG/recursos/nav-separator.png')}}" height="85" alt="" style="visibility: hidden;">
                    </ul>
                    <ul>
                        <a href="https://www.internationalccn.org/blank-1">Blog &nbsp;</a>
                        <img src="{{asset('IMG/recursos/nav-separator.png')}}" height="85" alt="" style="">
                    </ul>
                    <ul>
                        <a href="http://miembros.internationalccn.org">Miembros &nbsp;</a>
                        <img src="{{asset('IMG/recursos/nav-separator.png')}}" height="85" alt="">
                    </ul>                    
                    <ul>
                        <a href="https://www.internationalccn.org/b">Programas &nbsp;</a>
                        <img src="{{asset('IMG/recursos/nav-separator.png')}}" height="85" alt="">
                    </ul> 
                    <ul>
                        <a href="https://www.internationalccn.org/blank-luchn">Membresías &nbsp;</a>
                        <img src="{{asset('IMG/recursos/nav-separator.png')}}" height="85" alt="">
                    </ul>
                    <ul>
                        <a href="https://www.internationalccn.org/blank-ekhzj">¿Qué es la ICCN? &nbsp;</a>
                        <img src="{{asset('IMG/recursos/nav-separator.png')}}" height="85" alt="">
                    </ul>    
                </div>
                <div class="social-icons">
                <table style="width:100%">
                    <tr>
                        <td style="text-align:center;"><a href="https://www.facebook.com/internationalccn/?fref=ts"><img src="https://static.wixstatic.com/media/f61c7a3b4b4947b28511a25034973383.png/v1/fill/w_29,h_29,al_c,usm_0.66_1.00_0.01/f61c7a3b4b4947b28511a25034973383.png" alt=""></a></td>
                        <td style="text-align:center"><a href="https://www.facebook.com/internationalccn/?fref=ts"><img src="https://static.wixstatic.com/media/e0678ef25486466ba65ef6ad47b559e1.png/v1/fill/w_29,h_29,al_c,usm_0.66_1.00_0.01/e0678ef25486466ba65ef6ad47b559e1.png" alt=""></a></td>
                    </tr>
                </table>
            </div>
            </div>
        </nav>