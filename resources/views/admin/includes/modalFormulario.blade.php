<div class="modal fade" id="modal-lg" style="display: none;" aria-hidden="true">
  <div class="{{ $class }}">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">{{ $titulo }}</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        @include($formulario)
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal" id="cerrarModal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Guardar</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
