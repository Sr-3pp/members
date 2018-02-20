<template>
  <div class="card">
    <div class="card-body">
      <div class="card-title">Martini Ruiz</div>
    </div>
  </div>
</template>

<script>
    export default {
        mounted() {
          var este = this;
            axios.get('/get-categoria/'+this.categoriaid).then(function(categoria){
              este.categoria = categoria.data
            });
            axios.get('/get-user/'+this.miembroid).then(function(miembro){
              este.miembro = miembro.data
            });
        },
        props:['categoriaid', 'miembroid'],
        data(){
          return {
            categoria: [],
            miembro: []
          }
        },

    }
</script>
