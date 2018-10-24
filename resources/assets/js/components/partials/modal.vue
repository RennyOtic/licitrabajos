<template>
  <div class="modal fade" :id="id" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog" :class="'modal-'+w" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" aria-label="Close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title card-title">
            <slot name="modal-title">Modal title.</slot>
          </h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-10 col-md-offset-1">
              <slot name="modal-body">
                ...
              </slot>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <slot name="modal-btn">
            <button type="button" class="btn btn-default" data-dismiss="modal">
              <span class="fa fa-close"></span> Cerrar
            </button>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
          </slot>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'modal',
    props: ['id', 'w']
  }
</script>
