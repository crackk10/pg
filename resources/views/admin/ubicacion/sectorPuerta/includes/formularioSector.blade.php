<form id="formularioSector" method="post" autocomplete="off" class="form-inline">
  <div class="row col-lg-12">
    <div class="form-group col-lg-7">
      <label for="nombre" class="control-label col-lg-3">Nombre Sector</label>
      <input type="text" name="nombre" id="nombre" class="form-control col-lg-9">
    </div>

    <div class="form-group col-lg-3">
      <label for="color" class="control-label col-lg-5">color</label>
      <input type="color" name="color" id="color" class="form-control col-lg-7">
    </div>

    <div class="form-group col-lg-2">
      <button type="submit" class="btn btn-info" id="crear">Crear</button>
    </div>
  </div>

  @csrf
</form>
