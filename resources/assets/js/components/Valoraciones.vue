<template>
    <div class="container blanco">
        <div class="row" style="height:200px;">
            <div class="col-md-4 center-content">
              <h2>Áreas de expertise</h2>
            </div>
            <div class="col-md-8 center-content">
              <ul class="valoracion-list">
                <li>
                  Liderazgo
                  <div class="valoracion-stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                  </div>
                </li>
                <li>
                  Coaching Ejecutivo
                  <div class="valoracion-stars">
                    <i class="fas fa-star"></i>
                  </div>
                </li>
                <li>
                  Coaching de Ventas
                  <div class="valoracion-stars">
                    <i class="fas fa-star"></i>
                  </div>
                </li>
                <li>
                  Capacitacion Empresarial
                  <div class="valoracion-stars">
                    <i class="fas fa-star"></i>
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
            console.log('Component mounted.')
        }
    }
</script>
