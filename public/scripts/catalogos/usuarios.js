'use strict'
var tabla;
var form;
//funcion que se ejecuta al inicio
function init(){
   listar();
}
//obtener el ultimo id de la tabla
function obtenultimoid(){
  $.get(obtener_ultimo_id_usuario, function(numero){
    $("#numero").val(numero);
  })  
}
//cerrar modales
function limpiarmodales(){
  $("#tabsform").empty();
}
//limpiar todos los inputs del formulario alta
function limpiar(){
  $("#formparsley")[0].reset();
  //Resetear las validaciones del formulario alta
  form = $("#formparsley");
  form.parsley().reset();
}
//mostrar modal formulario
function mostrarmodalformulario(tipo, permitirmodificacion){
    $("#ModalFormulario").modal('show');
    if(tipo == 'ALTA'){
        $("#btnGuardar").show();
        $("#btnGuardarModificacion").hide();
    }else if(tipo == 'MODIFICACION'){
        if(permitirmodificacion == 1){
            $("#btnGuardar").hide();
            $("#btnGuardarModificacion").show();
        }else{
            $("#btnGuardar").hide();
            $("#btnGuardarModificacion").hide();
        }
    }   
}
//ocultar modal formulario
function ocultarmodalformulario(){
  $("#ModalFormulario").modal('hide');
}
//mostrar formulario en modal y ocultar tabla de seleccion
function mostrarformulario(){
  $("#formulario").show();
  $("#contenidomodaltablas").hide();
}
//mostrar tabla de seleccion y ocultar formulario en modal
function ocultarformulario(){
  $("#formulario").hide();
  $("#contenidomodaltablas").show();
}
//listar todos los registros de la tabla
function listar(){
    tabla=$('#tbllistado').DataTable({
        "lengthMenu": [ 100, 250, 500 ],
        "pageLength": 100,
        "sScrollX": "110%",
        "sScrollY": "350px", 
        processing: true,
        'language': {
            "url": "//cdn.datatables.net/plug-ins/1.11.0/i18n/es_es.json",
            'loadingRecords': '&nbsp;',
            'processing': '<div class="spinner"></div>'
        },
        serverSide: true,
        ajax: obtener_usuarios,
        "createdRow": function( row, data, dataIndex){
            if( data.status ==  `BAJA`){ $(row).addClass('table-danger');}
        },
        columns: [
            { data: 'operaciones', name: 'operaciones', orderable: false, searchable: false },
            { data: 'nombre_usuario', name: 'nombre_usuario', orderable: false, searchable: true },
            { data: 'correo_usuario', name: 'correo_usuario', orderable: false, searchable: true  },
            { data: 'rol_usuario', name: 'rol_usuario', orderable: false, searchable: true  },
            { data: 'status', name: 'status', orderable: false, searchable: true  }   
        ],
        "initComplete": function() {
            var $buscar = $('div.dataTables_filter input');
            $buscar.unbind();
            $buscar.bind('keyup change', function(e) {
                if(e.keyCode == 13 || this.value == "") {
                    $('#tbllistado').DataTable().search( this.value ).draw();
                }
            });
        }
    });  
}
//obtener roles
function obtenerroles(){
    $.get(obtener_roles, function(roles){
        $("#roles").html(roles);
    })      
}
//alta clientes
function alta(){
    $("#titulomodal").html('Alta Usuario');
    mostrarmodalformulario('ALTA');
    mostrarformulario();
    //formulario alta
    var tabs =  '<div class="card-header d-flex p-0">'+
                    '<h3 class="card-title p-3"></h3>'+
                    '<ul class="nav nav-pills ml-auto p-2" role="tablist">'+
                        '<li class="nav-item">'+
                            '<a class="nav-link active" href="#datosgenerales" data-toggle="tab">Datos Generales</a>'+
                        '</li>'+
                    '</ul>'+
                '</div>'+
                '<div class="card-body">'+
                    '<div class="tab-content">'+
                        '<div class="tab-pane active" id="datosgenerales">'+
                            '<div class="row">'+
                               
                                '<div class="col-md-4">'+
                                    '<label>Correo Electrónico <b style="color:#F44336 !important;">*</b></label>'+
                                    '<input type="text" class="form-control" name="email" id="email" required autocomplete="email" data-parsley-type="email"	>'+
                                '</div>'+
                                '<div class="col-md-4">'+
                                    '<label>Contraseña <b style="color:#F44336 !important;">*</b></label>'+
                                    '<input type="password" class="form-control" name="pass" id="pass" required autocomplete="new-password">'+
                                '</div>'+
                                '<div class="col-md-4">'+
                                    '<label>Confirmar Contraseña <b style="color:#F44336 !important;">*</b></label>'+
                                    '<input type="password" class="form-control" name="confirmarpass" id="confirmasrpass" required autocomplete="new-password" data-parsley-equalto="#pass">'+
                                '</div>'+
                                
                                '<div class="col-md-4">'+
                                    '<label>Rol <b style="color:#F44336 !important;">*</b></label>'+
                                    '<div class="col-md-12 form-check" id="roles"></div>'+
                                '</div>'+

                            '</div>'+ 
                        '</div>'+
                    '</div>'+
                '</div>';
    $("#tabsform").html(tabs);
    obtenultimoid(); 
    obtenerroles();
}
//guardar el registro
$("#btnGuardar").on('click', function (e) {
    e.preventDefault();
    var formData = new FormData($("#formparsley")[0]);
    var form = $("#formparsley");
    if (form.parsley().isValid()){
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url:guardar_usuario,
            type: "post",
            dataType: "html",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success:function(data){
                if(data == 1){
                    toastr.error( "Aviso, el Correo Electrónico ya existe", "Mensaje", {
                        "timeOut": "6000",
                        "progressBar": true,
                        "extendedTImeout": "6000"
                    });
                }else{
                    toastr.success( "Datos guardados correctamente", "Mensaje", {
                        "timeOut": "6000",
                        "progressBar": true,
                        "extendedTImeout": "6000"
                    });
                    var tabla = $('.tbllistado').DataTable();
                    tabla.ajax.reload();
                    limpiar();
                    ocultarmodalformulario();
                    limpiarmodales();
                }
            },
            error:function(data){
                if(data.status == 403){
                    toastr.error( "No tiene permisos para realizar esta acción, contacta al administrador del sistema", "Mensaje", {
                        "timeOut": "6000",
                        "progressBar": true,
                        "extendedTImeout": "6000" 
                    });
                }else{
                    toastr.error( "Aviso, estamos experimentando problemas, contacta al administrador del sistema", "Mensaje", {
                        "timeOut": "6000",
                        "progressBar": true,
                        "extendedTImeout": "6000"
                    });
                }
            }
        })
    }else{
        form.parsley().validate();
    }
});
//dar de baja o alta registro
function desactivar(numerousuario){
    $.get(verificar_baja_usuario,{numerousuario:numerousuario}, function(data){
        if(data.status == 'BAJA'){
            $("#numerousuario").val();
            $("#textobaja").html("Este usuario ya fue dado de baja..!!!");
            $("#aceptar").hide();
            $('#estatusregistro').modal('show');
        }else{
            $("#numerousuario").val(numerousuario);
            $("#textobaja").html("Esta seguro de dar de baja este usuario?");
            $("#aceptar").show();
            $('#estatusregistro').modal('show');
        }
    })  
}
$("#aceptar").on('click', function(e){
    e.preventDefault();
    var formData = new FormData($("#formdesactivar")[0]);
    var form = $("#formdesactivar");
    if (form.parsley().isValid()){
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url:baja_usuario,
            type: "post",
            dataType: "html",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success:function(data){
                $('#estatusregistro').modal('hide');
                toastr.success( "Usuario dado de baja correctamente", "Mensaje", {
                    "timeOut": "6000",
                    "progressBar": true,
                    "extendedTImeout": "6000"
                });
                var tabla = $('.tbllistado').DataTable();
                tabla.ajax.reload();
            },
            error:function(data){
                if(data.status == 403){
                    toastr.error( "No tiene permisos para realizar esta acción, contacta al administrador del sistema", "Mensaje", {
                        "timeOut": "6000",
                        "progressBar": true,
                        "extendedTImeout": "6000" 
                    });
                }else{
                    toastr.error( "Aviso, estamos experimentando problemas, contacta al administrador del sistema", "Mensaje", {
                        "timeOut": "6000",
                        "progressBar": true,
                        "extendedTImeout": "6000"
                    });
                }
                $('#estatusregistro').modal('hide');
            }
        })
    }else{
        form.parsley().validate();
    }
});
function obtenerdatos(numerousuario){
    $("#titulomodal").html('Modificación Usuario');
    $.get(obtener_usuario,{numerousuario:numerousuario },function(data){
        //formulario alta
        var tabs =  '<div class="card-header d-flex p-0">'+
                        '<h3 class="card-title p-3"></h3>'+
                        '<ul class="nav nav-pills ml-auto p-2" role="tablist">'+
                            '<li class="nav-item">'+
                                '<a class="nav-link active" href="#datosgenerales" data-toggle="tab">Datos Generales</a>'+
                            '</li>'+
                        '</ul>'+
                    '</div>'+
                    '<div class="card-body">'+
                        '<div class="tab-content">'+
                            '<div class="tab-pane active" id="datosgenerales">'+
                                '<div class="row">'+
                                    '<div class="col-md-4">'+
                                        '<label>Correo Electrónico <b style="color:#F44336 !important;">*</b></label>'+
                                        '<input type="text" class="form-control" name="email" id="email" required autocomplete="email" data-parsley-type="email"	>'+
                                    '</div>'+
                                    '<div class="col-md-4">'+
                                        '<label>Rol <b style="color:#F44336 !important;">*</b></label>'+
                                        '<div class="col-md-12 form-check" id="roles"></div>'+
                                    '</div>'+
                                '</div>'+ 
                            '</div>'+
                        '</div>'+
                    '</div>';
        $("#tabsform").html(tabs);
        //boton formulario 
        $("#numero").val(numerousuario);
        $("#nombre").val(data.usuario.name);
        $("#email").val(data.usuario.email);
        $("#roles").html(data.roles);
        mostrarmodalformulario('MODIFICACION', data.permitirmodificacion);
    }).fail( function() {
        toastr.error( "Aviso, estamos experimentando problemas, contacta al administrador del sistema", "Mensaje", {
            "timeOut": "6000",
            "progressBar": true,
            "extendedTImeout": "6000"
        });
    })
}
//guardar el registro
$("#btnGuardarModificacion").on('click', function (e) {
    e.preventDefault();
    var formData = new FormData($("#formparsley")[0]);
    var form = $("#formparsley");
    if (form.parsley().isValid()){
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url:guardar_modificacion_usuario,
            type: "post",
            dataType: "html",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success:function(data){
                toastr.success( "Datos guardados correctamente", "Mensaje", {
                    "timeOut": "6000",
                    "progressBar": true,
                    "extendedTImeout": "6000"
                });
                var tabla = $('.tbllistado').DataTable();
                tabla.ajax.reload();
                limpiar();
                ocultarmodalformulario();
                limpiarmodales();
            },
            error:function(data){
                if(data.status == 403){
                    toastr.error( "No tiene permisos para realizar esta acción, contacta al administrador del sistema", "Mensaje", {
                        "timeOut": "6000",
                        "progressBar": true,
                        "extendedTImeout": "6000" 
                    });
                }else{
                    toastr.error( "Aviso, estamos experimentando problemas, contacta al administrador del sistema", "Mensaje", {
                        "timeOut": "6000",
                        "progressBar": true,
                        "extendedTImeout": "6000"
                    });
                }
            }
        })
    }else{
        form.parsley().validate();
    }
});
init();