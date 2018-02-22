<template>
  <div class="modal fade" id="empresaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
          Registrar empresa <br>
          <small>(Recuerda que tu perfil estará en línea hasta realizar el pago de tu membresía.)</small>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h5>Los campos marcados con * son obligatorios</h5>
        <hr>
        <form>
          <div class="row">
            <div class="col">
              <input type="text" class="form-control" placeholder="Nombre comercial">
            </div>
            <div class="col">
              <input type="email" class="form-control" placeholder="E-mail">
            </div>
            <div class="col">
              <input type="text" class="form-control" placeholder="Teléfono">
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col">
              <select class="form-control">
                <option value="">Membresia*</option>
              </select>
            </div>
            <div class="col">
              <select class="form-control">
                <option value="">Pais*</option>
              </select>
            </div>
            <div class="col">
              <input type="text" class="form-control" placeholder="Ciudad">
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col">
              <input type="text" class="form-control" placeholder="Idiomas">
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col">
              <input type="text" class="form-control" placeholder="Facebook url">
            </div>
            <div class="col">
              <input type="text" class="form-control" placeholder="Twitter url">
            </div>
            <div class="col">
              <input type="text" class="form-control" placeholder="Linkedin url">
            </div>
          </div>
        </form>
        <hr>
        <div class="row">
          <div class="col text-center">
            <br>
            <h4>Principales servicios</h4>
          </div>
          <div class="col text-center">
            <input style="margin-bottom: 10px" type="text" class="form-control" placeholder="Área 1">
            <span class="reg-stars">
              <span  :id="'star1_'+index" @mouseover="setlevel(1, index, 1)"  @mouseout="setlevel(1, index, 0)" v-for="(star, index) in 10"><i class="fas fa-star"></i>&nbsp;&nbsp;</span>
            </span>
          </div>
          <div class="col">
            <input style="margin-bottom: 10px" type="twxt" class="form-control" placeholder="Área 2">
            <span class="reg-stars">
              <span  :id="'star2_'+index"  @mouseover="setlevel(2, index, 1)"  @mouseout="setlevel(2, index, 0)" v-for="(star, index) in 10"><i class="fas fa-star"></i>&nbsp;&nbsp;</span>
            </span>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col">
            <input style="margin-bottom: 10px" type="text" class="form-control" placeholder="Área 3">
            <span class="reg-stars">
              <span  :id="'star3_'+index" @mouseover="setlevel(3, index, 1)"  @mouseout="setlevel(3, index, 0)" v-for="(star, index) in 10"><i class="fas fa-star"></i>&nbsp;&nbsp;</span>
            </span>
          </div>
          <div class="col">
            <input style="margin-bottom: 10px" type="text" class="form-control" placeholder="Área 4">
            <span class="reg-stars">
              <span  :id="'star4_'+index"  @mouseover="setlevel(4, index, 1)"  @mouseout="setlevel(4, index, 0)" v-for="(star, index) in 10"><i class="fas fa-star"></i>&nbsp;&nbsp;</span>
            </span>
          </div>
          <div class="col">
            <input style="margin-bottom: 10px" type="text" class="form-control" placeholder="Área 5">
            <span class="reg-stars">
              <span  :id="'star5_'+index" @mouseover="setlevel(5, index, 1)"  @mouseout="setlevel(5, index, 0)" v-for="(star, index) in 10"><i class="fas fa-star"></i>&nbsp;&nbsp;</span>
            </span>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col">
            <label>Curriculum de la empresa</label>
            <textarea cols="30" rows="10" class="form-control"></textarea>
          </div>
          <div class="col">
            <label>Descripcion de la empresa</label>
            <textarea cols="30" rows="10" class="form-control"></textarea>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-8">
            <div class="row">
              <div class="col">
                <input type="text" class="form-control" placeholder="Website">
              </div>
            </div><br>
            <div class="row">
              <div class="col">
                <input type="text" class="form-control" placeholder="Password*">
              </div>
            </div><br>
            <div class="row">
              <div class="col">
                <input type="text" class="form-control" placeholder="Confirm Password*">
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="row">
              <div class="col text-center">
                <img width="88" src="/media/img/defaults/profile_1.png" alt="default picture"><br><br>
                <input type="file" class="form-control">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
</template>

<script>
    export default {
        mounted() {
            this.csrf = $('meta[name="csrf-token"]').attr('content')

        },
        data(){
          return {
            csrf: '',
            levelsetted: false,
          }
        },
        methods: {
          setlevel(key, index, sw){
            if (sw === 1) {
              this.levelsetted = false
              for (var i = 0; i < index+1 ; i++) {
                $('#star'+key+'_'+i).addClass('active')
              }
            }else{
              if (this.levelsetted === false) {
                for (var i = 0; i < index+1 ; i++) {
                  $('#star'+key+'_'+i).removeClass('active')
                }
              }
            }
          },
          level(key, index){
            this.levelsetted = true
            for (var i = 0; i < index+1 ; i++) {
              $('#star'+key+'_'+i).addClass('active')
            }
          }
        }
    }
</script>
