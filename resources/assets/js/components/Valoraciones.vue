<template>
    <div class="container blanco">
        <div class="row">
            <div class="col-md-4 center-content">
              <h2>Áreas de expertise</h2>
            </div>
            <div class="col-md-8 center-content">
              <ul class="valoracion-list">
                <li v-for="valoracion in vals">
                  {{valoracion.area}}
                  <div class="valoracion-stars">
                    <span v-for="val in valoracion.porcentaje"><i class="fas fa-star"></i></span>
                  </div>
                </li>
              </ul>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
          var este = this
            axios.get('/get-vals/'+this.userid).then(function(valorations){
              este.vals = valorations.data
              console.log(este.vals);
            });
        },
        props: ['userid'],
        data(){
          return {
            vals: []
          }
        },
        methods: {

        }
    }
</script>
