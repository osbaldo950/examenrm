'use strict'
var tabla;
var form;
//funcion que se ejecuta al inicio
function init(){
   listar();
}
//obtener el ultimo id de la tabla
function obtenultimoid(){
  $.get(obtener_ultimo_id_empleado, function(numero){
    $("#numero").val(numero);
  })  
}
//obtener fecha actual
function asignarfechaactual(){
    $.get(obtener_fecha_actual_datetimelocal, function(fechadatetimelocal){
      $("#fecha_ingreso").val(fechadatetimelocal);
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
//cambiar url para exportar excel
function cambiarurlexportarexcel(){
    //colocar el periodo seleccionado como parametro para exportar a excel
    var filtroempresa = $("#filtroempresa").val();
    var filtrodepartamento = $("#filtrodepartamento").val();
    $("#btnGenerarFormatoExcel").attr("href", urlgenerarformatoexcel+'?filtroempresa='+filtroempresa+'&filtrodepartamento='+filtrodepartamento);
}
function relistar(){
    cambiarurlexportarexcel();
    var tabla = $('.tbllistado').DataTable();
    tabla.ajax.reload();
}
//listar todos los registros de la tabla
function listar(){
    cambiarurlexportarexcel();
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
        ajax: {
            url: obtener_empleados,
            data: function (d) {
                d.filtroempresa = $("#filtroempresa").val();
                d.filtrodepartamento = $("#filtrodepartamento").val();
            }
        },
        "createdRow": function( row, data, dataIndex){
            if( data.status ==  `BAJA`){ $(row).addClass('table-danger');}
        },
        columns: [
            { data: 'operaciones', name: 'operaciones', orderable: false, searchable: false },
            { data: 'nombre_empresa', name: 'nombre_empresa', orderable: false, searchable: false },
            { data: 'numero_departamento', name: 'numero_departamento', orderable: false, searchable: false  },
            { data: 'nombre_departamento', name: 'nombre_departamento', orderable: false, searchable: false  },
            { data: 'numero_empleado', name: 'numero_empleado', orderable: false, searchable: false  },
            { data: 'nombre_empleado', name: 'nombre_empleado', orderable: false, searchable: true  },
            { data: 'fecha_nacimiento', name: 'fecha_nacimiento', orderable: false, searchable: false  },
            { data: 'correo', name: 'correo', orderable: false, searchable: false  },
            { data: 'genero', name: 'genero', orderable: false, searchable: false  },
            { data: 'telefono', name: 'telefono', orderable: false, searchable: false  },
            { data: 'celular', name: 'celular', orderable: false, searchable: false  },
            { data: 'fecha_ingreso', name: 'fecha_ingreso', orderable: false, searchable: false  },
            { data: 'status', name: 'status', orderable: false, searchable: false  }            
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
function obtenerempresas(){
    $.get(obtener_empresas, function(select_empresas){
        $("#empresa").html(select_empresas);
    })  
}
function obtenerdepartamentos(){
    var empresa = $("#empresa").val();
    $.get(obtener_departamentos,{empresa:empresa}, function(select_departamentos){
        $("#departamento").html(select_departamentos);
        $("#departamento").removeAttr('disabled');
    })  
}
function obtenerdepartamentosfiltro(){
    var filtroempresa = $("#filtroempresa").val();
    $.get(obtener_departamentos_filtro,{filtroempresa:filtroempresa}, function(select_departamentos){
        $("#filtrodepartamento").html(select_departamentos);
        $("#filtrodepartamento").removeAttr('disabled');
        relistar();
    }) 
}
//alta clientes
function alta(){
    $("#titulomodal").html('Alta Empleado');
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
                                    '<label>Empresa <b style="color:#F44336 !important;">*</b></label>'+
                                    '<select class="form-control" name="empresa" id="empresa" required onchange="obtenerdepartamentos()">'+
                                    '</select>'+
                                '</div>'+
                                '<div class="col-md-4">'+
                                    '<label>Departamento <b style="color:#F44336 !important;">*</b></label>'+
                                    '<select class="form-control" name="departamento" id="departamento" required disabled>'+
                                    '</select>'+
                                '</div>'+
                                '<div class="col-md-4">'+
                                    '<label>Fecha Nacimiento <b style="color:#F44336 !important;">*</b></label>'+
                                    '<input type="datetime-local" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento" required>'+
                                '</div>'+
                                '<div class="col-md-4">'+
                                    '<label>Correo <b style="color:#F44336 !important;">*</b></label>'+
                                    '<input type="text" class="form-control" name="correo" id="correo"  required data-parsley-type="email" data-parsley-length="[1, 255]" >'+
                                '</div>'+
                                '<div class="col-md-4">'+
                                    '<label>Genero</label>'+
                                    '<select class="form-control" name="genero" id="genero" data-parsley-length="[1, 25]">'+
                                        '<option selected disabled hidden>Selecciona</option>'+
                                        '<option value="Mujer">Mujer</option>'+
                                        '<option value="Hombre">Hombre</option>'+
                                    '</select>'+
                                '</div>'+
                                '<div class="col-md-4">'+
                                    '<label>Telefono</label>'+
                                    '<input type="text" class="form-control" name="telefono" id="telefono"  data-parsley-length="[1, 255]" >'+
                                '</div>'+
                                '<div class="col-md-4">'+
                                    '<label>Celular</label>'+
                                    '<input type="text" class="form-control" name="celular" id="celular" data-parsley-length="[1, 255]" onkeyup="mayusculas(this);">'+
                                '</div>'+
                                '<div class="col-md-4">'+
                                    '<label>Fecha Ingreso <b style="color:#F44336 !important;">*</b></label>'+
                                    '<input type="datetime-local" class="form-control" name="fecha_ingreso" id="fecha_ingreso" required readonly>'+
                                '</div>'+ 
                            '</div>'+ 
                        '</div>'+
                    '</div>'+
                '</div>';
    $("#tabsform").html(tabs);
    obtenultimoid();
    asignarfechaactual();
    obtenerempresas();
}
//guardar el registro
$("#btnGuardar").on('click', function (e) {
    e.preventDefault();
    var formData = new FormData($("#formparsley")[0]);
    var form = $("#formparsley");
    if (form.parsley().isValid()){
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url:guardar_empleado,
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
//dar de baja o alta registro
function desactivar(numeroempleado){
    $.get(verificar_baja_empleado,{numeroempleado:numeroempleado}, function(data){
        if(data.status == 'BAJA'){
            $("#numeroempleado").val();
            $("#textobaja").html("Este empleado ya fue dado de baja..!!!");
            $("#aceptar").hide();
            $('#estatusregistro').modal('show');
        }else{
            $("#numeroempleado").val(numeroempleado);
            $("#textobaja").html("Esta seguro de dar de baja este empleado?");
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
            url:baja_empleado,
            type: "post",
            dataType: "html",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success:function(data){
                $('#estatusregistro').modal('hide');
                toastr.success( "Empleado dado de baja correctamente", "Mensaje", {
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
function obtenerdatos(numeroempleado){
    $("#titulomodal").html('Modificación Empleado');
    $.get(obtener_empleado,{numeroempleado:numeroempleado },function(data){
        //formulario modificacion
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
                                        '<label>Empresa <b style="color:#F44336 !important;">*</b></label>'+
                                        '<select class="form-control" name="empresa" id="empresa" required onchange="obtenerdepartamentos()">'+
                                        '</select>'+
                                    '</div>'+
                                    '<div class="col-md-4">'+
                                        '<label>Departamento <b style="color:#F44336 !important;">*</b></label>'+
                                        '<select class="form-control" name="departamento" id="departamento" required disabled>'+
                                        '</select>'+
                                    '</div>'+
                                    '<div class="col-md-4">'+
                                        '<label>Fecha Nacimiento <b style="color:#F44336 !important;">*</b></label>'+
                                        '<input type="datetime-local" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento" required>'+
                                    '</div>'+
                                    '<div class="col-md-4">'+
                                        '<label>Correo <b style="color:#F44336 !important;">*</b></label>'+
                                        '<input type="text" class="form-control" name="correo" id="correo"  required data-parsley-type="email" data-parsley-length="[1, 255]" >'+
                                    '</div>'+
                                    '<div class="col-md-4">'+
                                        '<label>Genero</label>'+
                                        '<select class="form-control" name="genero" id="genero" data-parsley-length="[1, 25]">'+
                                            '<option selected disabled hidden>Selecciona</option>'+
                                            '<option value="Mujer">Mujer</option>'+
                                            '<option value="Hombre">Hombre</option>'+
                                        '</select>'+
                                    '</div>'+
                                    '<div class="col-md-4">'+
                                        '<label>Telefono</label>'+
                                        '<input type="text" class="form-control" name="telefono" id="telefono"  data-parsley-length="[1, 255]" >'+
                                    '</div>'+
                                    '<div class="col-md-4">'+
                                        '<label>Celular</label>'+
                                        '<input type="text" class="form-control" name="celular" id="celular" data-parsley-length="[1, 255]" onkeyup="mayusculas(this);">'+
                                    '</div>'+
                                    '<div class="col-md-4">'+
                                        '<label>Fecha Ingreso <b style="color:#F44336 !important;">*</b></label>'+
                                        '<input type="datetime-local" class="form-control" name="fecha_ingreso" id="fecha_ingreso" required readonly>'+
                                    '</div>'+ 
                                '</div>'+ 
                            '</div>'+
                        '</div>'+
                    '</div>';
        $("#tabsform").html(tabs);
        //boton formulario 
        $("#numero").val(numeroempleado);
        $("#nombre").val(data.empleado.nombre);
        $("#empresa").html(data.select_empresas);
        $("#departamento").html(data.select_departamentos).removeAttr('disabled');
        $("#fecha_nacimiento").val(data.fecha_nacimiento);
        $("#correo").val(data.empleado.correo);
        $("#genero").val(data.empleado.genero);
        $("#telefono").val(data.empleado.telefono);
        $("#celular").val(data.empleado.celular);
        $("#fecha_ingreso").val(data.fecha_ingreso);
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
            url:guardar_modificacion_empleado,
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