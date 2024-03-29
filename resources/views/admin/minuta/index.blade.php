@extends("theme.$theme.layout")
@section('titulo')
  Minuta
@endsection
@section('metadata')
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/DataTables/datatables.min.css') }}" />
  <script type="text/javascript" src="{{ asset('assets/DataTables/datatables.min.js') }}"></script>
  <style>
    .texto{
      word-break: break-all !important;
      white-space: normal !important;
    }
    .extraDelgado{ width : 40px !important; }
    .delgado{ width : 70px !important; }
    .normal{ width : 110px !important; }
    .medio{ width : 130px !important; }
  </style>
@endsection
@section('contenido')
  <div class="card card-info card-tabs">
    <div class="card-header p-0 pt-1">
      <ul class="nav nav-tabs" id="custom-tabs-five-tab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="formMinuta-tab" data-toggle="pill" href="#formMinuta" role="tab"
            aria-controls="formMinuta" aria-selected="true">Formulario </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="tabla-tab" data-toggle="pill" href="#tabla" role="tab" aria-controls="tabla"
            aria-selected="false">tabla</a>
        </li>
      </ul>
    </div>
    <div class="card-body">
      <div class="tab-content" id="custom-tabs-five-tabContent">
        <div class="tab-pane fade show active" id="formMinuta" role="tabpanel" aria-labelledby="formMinuta-tab">
          <div class="overlay-wrapper">
            <form id="formulario" autocomplete="off" enctype="multipart/form-data">
              @include('admin.minuta.includes.formularioRegistro')
            </form>
          </div>
        </div>
        <div class="tab-pane fade" id="tabla" role="tabpanel" aria-labelledby="tabla-tab">
          <div class="overlay-wrapper">
            @include('admin.minuta.includes.tabla')
          </div>
        </div>
      </div>
      <!-- /.card -->
    </div>
  @endsection

  @section('scripts')
    <script>
      const url = {
        "registros": "{{ route('minuta.registros') }}",
        "guardarNovedad": "{{ route('minuta.guardar') }}",
      }
    </script>

    <script src="{{ asset('assets/scripts/admin/minuta/acciones.js') }}"></script>
    <script src="{{ asset('assets/scripts/admin/minuta/listeners.js') }}"></script>
  @endsection
