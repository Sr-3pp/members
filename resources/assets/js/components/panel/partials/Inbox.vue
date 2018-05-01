<template>
  <div class="row mt-5">
    <div class="col-lg-12">
      <ul class="list-group">
        <li class="list-group-item active">
          <div class="row">
            <div class="col text-center" style="max-width: 5%;">
              <i class="fas fa-eye"></i>
            </div>
            <div class="col" style="max-width: 15%">
              De:
            </div>
            <div class="col" style="max-width: 20%">
              Asunto:
            </div>
            <div class="col">
              Contenido:
            </div>
            <div class="col" style="max-width: 8%">
              Acciones:
            </div>
          </div>
        </li>
        <li class="list-group-item list-group-item-action">
          <div class="row border-separator">
            <div class="col text-center" style="max-width: 5%;">
              <i class="fas fa-check"></i>
            </div>
            <div class="col" style="max-width: 15%">
              uncorreo@mail.com
            </div>
            <div class="col" style="max-width: 20%">
              <b>Asunto</b> AYuda porfavor
            </div>
            <div class="col">
              Si que si me surgio un lorem ipsum dolor amet sit lorem amet
            </div>
            <div class="col text-center" style="max-width: 8%">
              <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
            </div>
          </div>
        </li>
      </ul>
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
