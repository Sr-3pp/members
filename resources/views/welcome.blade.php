    <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
@extends('layouts.app')
@section('content')
<div class="container-fluid" style="background:#FFF;">
    <div class="container" style="padding:80px 0;">
        <div style="width:100%; text-align:center; margin-bottom:90px;">
            <h1 style="font-style:normal!important; font-weight:100!important;">
            Conoce a nuestros miembros ICCN
            </h1>
            <h3 style="font-style:normal!important; font-weight:100!important;">
                Selecciona el área de tu interés
            </h3>
        </div>
        <div class="row members-table">

                <ul class="title-cat">
                     <a href="{{url('/categoria/4')}}"><img src="https://static.wixstatic.com/media/b258fc_1e941d88a3f5443d950e8ffb021a57ce~mv2.png/v1/fill/w_193,h_194,al_c,usm_0.66_1.00_0.01/b258fc_1e941d88a3f5443d950e8ffb021a57ce~mv2.png" alt=""></a><br>
                    Consultores
                </ul>
                <ul class="title-cat">
                    <a href="{{url('/categoria/3')}}"><img src="https://static.wixstatic.com/media/b258fc_b89eff9762724f27b984d5e7d05fba9c~mv2.png/v1/fill/w_194,h_194,al_c,usm_0.66_1.00_0.01/b258fc_b89eff9762724f27b984d5e7d05fba9c~mv2.png" alt=""></a><br>
                    Coaches
                </ul>
                <ul class="title-cat">
                    <a href="{{url('/categoria/2')}}"><img src="https://static.wixstatic.com/media/b258fc_de1df6cab452499f8e580c5c8e5566d8~mv2.png/v1/fill/w_193,h_194,al_c,usm_0.66_1.00_0.01/b258fc_de1df6cab452499f8e580c5c8e5566d8~mv2.png" alt=""></a><br>
                    Capacitadores
                </ul>
                <ul class="title-cat">
                    <a href="{{url('/categoria/empresa')}}"><img src="https://static.wixstatic.com/media/b258fc_47ba838be1824758b6341bf1fc8e7866~mv2.png/v1/fill/w_193,h_194,al_c,usm_0.66_1.00_0.01/b258fc_47ba838be1824758b6341bf1fc8e7866~mv2.png" alt=""></a><br>
                    Empresas
                </ul>
                <ul class="title-cat">
                    <a href="{{url('categorias/programas')}}"><img src="https://static.wixstatic.com/media/b258fc_725bb99624a7417ab85e6a47958321ea~mv2.png/v1/fill/w_193,h_194,al_c,usm_0.66_1.00_0.01/b258fc_725bb99624a7417ab85e6a47958321ea~mv2.png" alt=""></a>
                <br>
                Programas
                </ul>

        </div>
    </div>
</div>
@endsection
