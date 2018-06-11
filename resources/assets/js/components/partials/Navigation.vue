<template>
    <nav style=" background:url('/media/img/recursos/nav_bg.jpg'); border:none!important;" class="sr-nav">
      <ul class="top-links">
        <li  v-if="userid !== '0'">
          <button type="button" @click="logout">Logout</button>
        </li>
        <li v-if="userid !== '0'">
          <button type="button" v-if="!empresa" @click="perfil">Perfil</button>
          <button type="button" v-else @click="perfile">Perfil</button>
        </li>
        <li v-if="userid !== '0' && user.tipo === 3">
           <button type="button" onclick="window.location.href = '/panel'"><i class="far fa-list-alt"></i> &nbsp;Dashboard</button>
        </li>
        <li v-if="userid === '0'">
          <button type="button"  data-toggle="modal" @click="$bus.$emit('registerModal', {sw: 2})">Registrar Empresa</button>
        </li>
        <li v-if="userid === '0'">
          <button type="button" data-toggle="modal" @click="$bus.$emit('registerModal', {sw: 1})">Crear Perfil</button>
        </li>
        <li v-if="userid === '0'">
          <button type="button" data-toggle="modal" data-target="#loginModal">Acceder</button>
        </li>
      </ul>
      <div class="container">
        <div class="row" id="navToggle">
          <div class="col-2">
            <ul class="nav-btns">
              <li class="desk-disp">
                <a class="navbar-brand" href="/">
                   <img width="130" src="https://static.wixstatic.com/media/b258fc_1804aea6d7ff4188905eda7f86d65487.png/v1/fill/w_171,h_96,al_c,usm_0.66_1.00_0.01/b258fc_1804aea6d7ff4188905eda7f86d65487.png" alt="">
                </a>
              </li>
              <li @click="showMenu(1)" class="mob-disp">
                <h1 class="hamburger-icon"><i class="fas fa-bars"></i></h1>
              </li>
            </ul>
          </div>
           <img class="mob-disp mob-logo" src="https://static.wixstatic.com/media/b258fc_1804aea6d7ff4188905eda7f86d65487.png/v1/fill/w_171,h_96,al_c,usm_0.66_1.00_0.01/b258fc_1804aea6d7ff4188905eda7f86d65487.png" alt="">
          <div class="col desk">
            <ul class="nav-btns">
              <li>
                <a href="https://www.internationalccn.org/formulario">Contacto</a>
                 <img src="/media/img/recursos/nav-separator.png" height="85" alt="" style="visibility: hidden;">
              </li>
              <li>
                <a href="https://www.internationalccn.org/blank-1">Blog &nbsp;</a>
                <img src="/media/img/recursos/nav-separator.png" height="85" alt="" style="">
              </li>
              <li>
                <a href="http://miembros.internationalccn.org">Miembros &nbsp;</a>
                <img src="/media/img/recursos/nav-separator.png" height="85" alt="">
              </li>
              <li>
                <a href="https://www.internationalccn.org/b">Programas &nbsp;</a>
                <img src="/media/img/recursos/nav-separator.png" height="85" alt="">
              </li>
              <li>
                <a href="https://www.internationalccn.org/blank-luchn">Membresías &nbsp;</a>
                <img src="/media/img/recursos/nav-separator.png" height="85" alt="">
              </li>
              <li>
                <a href="https://www.internationalccn.org/blank-ekhzj">¿Qué es la ICCN? &nbsp;</a>
                <img src="/media/img/recursos/nav-separator.png" height="85" alt="">
              </li>
            </ul>
          </div>
          <div @click="showMenu(0)" class="mobile-display-menu hide"></div>
          <div id="mobileMenu" class="mob-disp hide">
            <ul class="nav-btns-mobile">
              <li @click="navGo('index')" class="text-center"  style="background: rgba(0,0,0, .8)!important">
                <br>
                 <img width="80" src="https://static.wixstatic.com/media/b258fc_1804aea6d7ff4188905eda7f86d65487.png/v1/fill/w_171,h_96,al_c,usm_0.66_1.00_0.01/b258fc_1804aea6d7ff4188905eda7f86d65487.png" alt="">
              </li>
              <li @click="navGo('https://www.internationalccn.org/blank-ekhzj')">
                <a href="https://www.internationalccn.org/blank-ekhzj">¿Qué es la ICCN? &nbsp;</a>
              </li>
              <li @click="navGo('https://www.internationalccn.org/b')">
                <a href="https://www.internationalccn.org/b">Programas &nbsp;</a>
              </li>
              <li @click="navGo('http://members.internationalccn.org')">
                <a href="http://members.internationalccn.org">Miembros &nbsp;</a>
              </li>
              <li @click="navGo('https://www.internationalccn.org/blank-1')">
                <a href="https://www.internationalccn.org/blank-1">Blog &nbsp;</a>
              </li>
              <li @click="navGo('https://www.internationalccn.org/formulario')">
                <a href="https://www.internationalccn.org/formulario">Contacto</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>
</template>

<script>
    export default {
      mounted() {
          var este = this;
          axios.get('/get-user/'+this.userid).then(function(user){
            este.user = user.data
            if (!user.data.perfil) {
              este.empresa = true
            }
          });

          this.$bus.$on('login', $event => {
            este.email = $event.email,
            este.password = $event.password,
            este.login();
          });
      },
      props: ['userid'],
      data(){
        return {
          user: [],
          empresa: false
        }
      },
      methods: {
        logout(){
          axios.post('/user-logout', {email: this.user.email, password: this.user.password}).then(function(){
            window.location.href = '/'
          });
        },
        login(){
          var este = this;
          axios.post('/login-member', {email: this.email, password: this.password}).then(function(response){
            window.location.href = '/'
          }).catch(error => {
              console.log(error.response)
              este.$bus.$emit('loginattempt')
          });
        },
        perfil(){
          window.location.href= '/perfil/'+this.user.folio
        },
        perfile(){
          window.location.href= '/empresa/'+this.user.folio
        },
        showMenu(sw){
          if (sw === 0) {
            $('.mobile-display-menu').css('display', 'none')
            $('.mobile-display-menu').addClass('hide')
            setTimeout(function(){
              $('#mobileMenu').addClass('hide')
            },200)
            $('.nav-btns-mobile').css('left', '-200px')
          }else{
            $('#mobileMenu').removeClass('hide')

            setTimeout(function(){
              $('.mobile-display-menu').css('display', 'block')
              $('.mobile-display-menu').removeClass('hide')
              $('.nav-btns-mobile').css('left', '0')
            },200)
          }
        },
        navGo(url){
          if (url === 'index') {
            window.location.href = '/'
          }else{
            window.location.href = url
          }
        }
      }
    }
</script>
