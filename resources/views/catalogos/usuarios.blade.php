@extends('master_template')
@section('title')
  Usuarios
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                <h3 class="card-title">Usuarios</h3>
                <a class="btn btn-app bg-success float-sm-right" onclick="alta()" >
                    <i class="fas fa-plus"></i>
                    ALTAS
                </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tbllistado" class="tbllistado table table-bordered table-striped table-hover" style=" width:100% !important;">
                            <thead>
                                <tr>
                                    <th><div style="width:100px !important;">Operaciones</div></th>
                                    <th>nombre_usuario</th>
                                    <th>correo_usuario</th>
                                    <th>rol_usuario</th>
                                    <th>status</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                </div>
                <!-- /.card-footer-->
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <!-- Modal Alta/Modificacion-->
    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="ModalFormulario" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div id="formulario">
                    <div class="modal-header">
                        <h5 class="modal-title" id="titulomodal"></h5>
                    </div>
                    <form id="formparsley" action="#">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Número</label>
                                    <input type="text" class="form-control" name="numero" id="numero" required readonly>
                                </div>   
                                <div class="col-md-9">
                                    <label>Nombre <b style="color:#F44336 !important;">*</b></label>
                                    <input type="text" class="form-control" name="nombre" id="nombre" placeholder="1er Apellido, 2do Apellido, Nombre(s)" required data-parsley-length="[1, 255]">
                                </div>
                            </div>
                            <div class="col-md-12" id="tabsform">
                                <!-- aqui van los formularios de alta o modificacion y se agregan automaticamente con jquery -->
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-sm" onclick="limpiar();limpiarmodales();" data-dismiss="modal">Salir</button>
                            <button type="button" class="btn btn-success btn-sm" id="btnGuardar">Guardar</button>
                            <button type="button" class="btn btn-success btn-sm" id="btnGuardarModificacion">Confirmar Cambios</button>
                        </div>
                    </form> 
                </div>
                <div id="contenidomodaltablas">
                    <!-- aqui van las tablas de seleccion y se agregan automaticamente con jquery -->
                </div> 
            </div>
        </div>
    </div>
    <!-- Modal Baja o Alta-->
    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="estatusregistro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Aviso</h5>
                </div>
                <div class="modal-body">
                    <form id="formdesactivar" action="#">
                        <h5 id="textobaja"></h5>
                        <input type="hidden" id="numerousuario" name="numerousuario">
                    </form>	
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Salir</button>
                    <button type="button" class="btn btn-success btn-sm" id="aceptar">Confirmar Baja</button>
                </div>
            </div>
        </div>
    </div>   
@endsection
@section('additionals_js')
    <script>
        /*urls y variables renderizadas con blade*/
        var obtener_usuarios = '{!!URL::to('obtener_usuarios')!!}';
        var obtener_ultimo_id_usuario = '{!!URL::to('obtener_ultimo_id_usuario')!!}';
        var obtener_roles = '{!!URL::to('obtener_roles')!!}';
        var guardar_usuario = '{!!URL::to('guardar_usuario')!!}';
        var verificar_baja_usuario = '{!!URL::to('verificar_baja_usuario')!!}';
        var baja_usuario = '{!!URL::to('baja_usuario')!!}';
        var obtener_usuario = '{!!URL::to('obtener_usuario')!!}';
        var guardar_modificacion_usuario = '{!!URL::to('guardar_modificacion_usuario')!!}';
    </script>
    <script src="scripts/catalogos/usuarios.js"></script>
@endsection