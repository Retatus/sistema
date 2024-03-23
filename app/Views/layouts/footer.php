  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.0.2
    </div>
    <strong>Copyright &copy; 2014-2024 <a href="https://www.facebook.com/Tatope-1629268083750486">Tatope.com</a>.</strong> All rights
    reserved.
  </footer>
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<!-- Page script -->
<script>
  // inicio modulo personas
    var NuevoCliente;
	var base_url= '<?php echo base_url();?>';

	function NumeroFilasTabla(){
		TamanioTabla = $('#tabla_Habitaciones tr').length - 1;
		$('#minmax').val(TamanioTabla)
	}


	// function load(pag){
	// 	RecolectarDatosCliente();
	// 	EnviarInformacionCliente('leer', NuevoCliente, false, pag);
	// }

	function EliminarFila(val){
		debugger
        var i = $('#tablaDetalleServicio tr').length; 
        if (i > 1) {
            $("#Fila_" + val).remove();
			ImporteTotal();
            //NumeroFilasTabla();
        } 
    }	

	function addDatepicker(i){
		var mindate = $("#fechainicio").val().split('-')[0].trim();
		var maxdate = $("#fechainicio").val().split('-')[1].trim();
		$('.datepicker' + i).datepicker({        
			autoclose: true,
			minViewMode: "months",
			minDate: mindate,
			maxDate: maxdate
			//dateFormat: 'dd-mm-yy' 		
		});
		$('.datepicker' + i).datepicker("setDate", new Date());
	}

	function ImporteTotalDetalle(i){
		debugger
		var cantidad = parseFloat($('#detallecantidad_' + i).val() == '' ? 0 : $('#detallecantidad_' + i).val());
		var precio = parseFloat($('#detalleprecio_' + i).val() == '' ? 0 : $('#detalleprecio_' + i).val());
		var total = cantidad * precio;
		$('#detalletotal_' + i).val(total.toFixed(2));
		ImporteTotal();
	}

	function ImporteTotal(){
		debugger
		var total = 0;
		var nroservicios = $('#tablaDetalleServicio tr').length;
		for (var j = 1 ; j < nroservicios; j++) {
			var i = parseInt($('#tablaDetalleServicio').find('tr').eq(j).find('td').eq(0).html());
			total += parseFloat($('#detalletotal_' + i).val());
		}	
		$('#pagado').val(total.toFixed(2));
		$('#montototal').val(total.toFixed(2));
	}
	
	$('#fecha').datepicker({
		language: 'es',
		todayBtn: 'linked',
		clearBtn: true,
		format: 'mm/dd/yyyy',
		multidate: false,
		todayHighlight: true
	});

	$('#clientefechanacimiento').datepicker({
		language: 'es',
		todayBtn: 'linked',
		clearBtn: true,
		format: 'mm/dd/yyyy',
		multidate: false,
		todayHighlight: true
	});

	$('#idreserva').autocomplete({ 
		source: function(request, response) {
			$.ajax({
				type: 'POST',
				url: base_url + '/reservadetallecliente/autocompletereservas',
				dataType: 'json',
				data: { keyword: request.term },
				success: function(data){
				console.log(data);
					response($.map(data, function(item) {
						return {
							label: item.concatenado,
							concatenado: item.concatenado,
							idtour: item.idreserva,
							nombre: item.reservanombre
						}
					}))
				}
			});
		},
		minLength: 2,
		select: function( event, ui ) {
			console.log(ui.item);
			$('#idreserva').val('');
			var j = $('#tablaDetalleServicio tr').length;
			var i = parseInt((j == 1 ? 0 : $('#tablaDetalleServicio').find('tr').eq(j - 1).find('td').eq(0).html()));
			var rows = "<tr id=Fila_" + (i + 1) + ">"+
				"<td hidden>" + (i + 1) + "</td>"+
				"<td hidden><input type='text' class='form-control form-control-sm text-uppercase' id='reservadetalle_" + (i + 1) + "' value=''></td>"+
				"<td>"+
					"<div class='row'>"+
						"<div style='margin: auto;'>"+
							"<a href='javascript:void(0)' style='color: #ef5350;' onClick='EliminarFila(" + (i + 1) + ")'><i class='fa fa-times'></i></a>"+
						"</div>"+
						"<div style='margin: auto;'>"+
							"<a href='javascript:void(0)' style='color: #007bff;' onClick='AgregarDatos(" + (i + 1) + ")'><i class='fa fa-pencil'></i></a>"+
						"</div>"+
					"</div>"+
				"</td>"+
				"<td>"+
					"<select class='form-control form-control-sm select2' id='catHabitacion_" + (i + 1) + "' style='width: 100%;'>"+
						"<option value='0'>GRAVADO</option>"+
						"<option value='0'>EXONERADO</option>"+
						"<option value='0'>INAFECTO</option>"+
						"<option value='0'>EXPORTACION</option>"+
					"</select>"+
				"</td>"+
				"<td>" + ui.item.idtour + "</td>"+
				"<td>" + ui.item.nombre + "</td>"+
				"<td> 2021/09/07 </td>"+
				"<td><input type='text' class='form-control form-control-sm text-uppercase' id='apellidos_" + (i + 1) + "' placeholder='apellidos' value='1'></td>"+
				"<td><input type='text' class='form-control form-control-sm text-uppercase' id='precio_" + (i + 1) + "' placeholder='nombre' value='" + 0.00 + "'></td>"+
				"<td><input type='text' class='form-control form-control-sm text-uppercase' id='telefono_" + (i + 1) + "' placeholder='telefono' value='' disabled></td>"+
				"<td>"+
					"<select class='form-control form-control-sm select2' id='catHabitacion_" + (i + 1) + "' style='width: 100%;'>"+
						"<option value='0'>CONFIRMADO</option>"+
						"<option value='0'>PENDIENTE</option>"+
						"<option value='0'>ANULADO</option>"+
					"</select>"+
				"</td>"+
				"<td>"+
					"<select class='form-control form-control-sm select2' id='catHabitacion_" + (i + 1) + "' style='width: 100%;'>"+
						"<option value='0'>PAGADO</option>"+
						"<option value='0'>PENDIENTE</option>"+
					"</select>"+
				"</td>"+
				"<td>"+
					"<select class='form-control form-control-sm select2' id='catHabitacion_" + (i + 1) + "' style='width: 100%;'>"+
						"<option value='0'>ACTIVO</option>"+
						"<option value='0'>DESACTIVO</option>"+
					"</select>"+
				"</td>"+
			"</tr>";
			$('#tablaDetalleServicio').append(rows);
		}
	});



	$('#btnAgregarCliente').click(function(){
		LimpiarModalDatosCliente();
		$('#categoria').val(1);
		$('#id').prop('readonly', false);  
		$('#IdModalGrupoCodigoHotel').prop('hidden', false);
		$('#btnModalAgregarCliente').toggle(true);
		$('#btnModalEditarCliente').toggle(false);
		$('#btnModalEliminarCliente').toggle(false);
		$('#modalAgregarCliente').modal();
	});


	function btnEditarCliente(Val0, Val1){
		$.ajax({
			type: 'POST',
			url: base_url + '/cliente/edit',
			data: { idcliente: Val0, idtipodoc: Val1},
			success: function(msg){
		debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosCliente();
				$('#idcliente').val(temp.idcliente);
				$('#idtipodoc').select2().val(temp.idtipodoc).select2('destroy').select2();
				$('#clientenombre').val(temp.clientenombre);
				$('#clienteapellidos').val(temp.clienteapellidos);
				$('#clientetelefono').val(temp.clientetelefono);
				$('#clientecorreo').val(temp.clientecorreo);
				$('#clientedireccion').val(temp.clientedireccion);
				$('#clientepais').val(temp.clientepais);
				$('#clientefechanacimiento').val(temp.clientefechanacimiento);
				$('#clienteedad').val(temp.clienteedad);
				$('#clientesexo').val(temp.clientesexo);
				$('#clienteestado').val(temp.clienteestado);



				$('#tabla_Habitaciones tr').not($('#tabla_Habitaciones tr:first')).remove();
				var nrohabitaciones = 0;
				console.log(temp.habitacion);
				$.each(temp.habitacion, function(i, value) { 
					nrohabitaciones++;
					var rows = "<tr>" +
					"<td hidden>" + (i + 1) + "</td>" +
					"<td class='numero'>"+
						"<a href='#' style='color: #ef5350;' class='delete'><i class='fa fa-times' style='padding-top: 10px;'></i></a>" +
					"</td>" + 
					"<td hidden><input type='text' class='form-control text-uppercase' id='codhabitacion_" +(i + 1)+ "' value="+value.idhabitacion+"></td>" +
					"<td>" +
						"<select class='form-control select2' id='catHabitacion_"+(i + 1)+"' style='width: 100%;'>" +
							"<option value='0'>-- SELECCIONAR --</option>" +
						"</select>" +
					"</td>" +
					"<td><input type='text' class='form-control solo_numero' id='precio_" +(i + 1)+"' value="+value.precio+"></td>" +
					"<td>" +
						"<select class='form-control' id='estado_" +(i + 1)+ "' style='padding: 6px 2px;'>" +
						"</select>" +
					"</td>" +
					"</tr>";
					$('#tabla_Habitaciones').append(rows);


					$('.delete').off().click(function (e) {
						var i = $('#tabla_Habitaciones tr').length - 1; 
						if (i > 1) {
							$(this).parent('td').parent('tr').remove();
							NumeroFilasTabla();
						} 
					});


					addCatHabitacion((i + 1));
					$('#catHabitacion_'+(i + 1)).select2().val(value.idcathabitacion).select2('destroy').select2();
					addEstado((i + 1)); 
					$('#estado_'+(i + 1)).val(value.estado);            
				});
				$('#minmax').val(nrohabitaciones);


				$('#btnModalAgregarCliente').toggle(false);
				$('#btnModalEditarCliente').toggle(true);
				$('#btnModalEliminarCliente').toggle(true);
				$('#modalAgregarCliente').modal('toggle');
			},
			error: function(){
				alert('Hay un error...');
			}
		});
	}


	$('#btnModalAgregarCliente').click(function(){
		if (ValidarCamposVaciosCliente() != 0) {
			alert('Completar campos obligatorios');
		}else{
			$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
			RecolectarDatosCliente();
			EnviarInformacionCliente('agregar', NuevoCliente, true);
		}
	});


	$('#btnModalEditarCliente').click(function(){
		if (ValidarCamposVaciosCliente() != 0) {
			alert('Completar campos obligatorios');
		}else{
			RecolectarDatosCliente();
			EnviarInformacionCliente('modificar', NuevoCliente, true);
		}
	});


	$('#btnModalEliminarCliente').click(function(){
		var bool=confirm('ESTA SEGURO DE ELIMINAR EL DATO?');
		if(bool){
			RecolectarDatosCliente();
			EnviarInformacionCliente('eliminar', NuevoCliente, true);
		}
	});


	$('#btnModalCerrarHotel').click(function(){
		$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
		LimpiarModalDatosCliente();
	});


	// $('#btnFiltroCliente').click(function(){
	// 	debugger
	// 	RecolectarDatosCliente();
	// 	EnviarInformacionCliente('leer', NuevoCliente, false);
	// });


	// function Paginado(pag) {
	// 	RecolectarDatosCliente();
	// 	EnviarInformacionCliente('leer', NuevoCliente, false, pag);
	// }


	function RecolectarDatosCliente(){
		NuevoCliente = {
			idcliente: $('#idcliente').val().toUpperCase(),
			idtipodoc: $('#idtipodoc').val().toUpperCase(),
			clientenombre: $('#clientenombre').val().toUpperCase(),
			clienteapellidos: $('#clienteapellidos').val().toUpperCase(),
			clientetelefono: $('#clientetelefono').val().toUpperCase(),
			clientecorreo: $('#clientecorreo').val().toUpperCase(),
			clientedireccion: $('#clientedireccion').val().toUpperCase(),
			clientepais: $('#clientepais').val().toUpperCase(),
			clientefechanacimiento: $('#clientefechanacimiento').val().toUpperCase(),
			clienteedad: $('#clienteedad').val().toUpperCase(),
			clientesexo: $('#clientesexo').val().toUpperCase(),
			clienteestado: $('#clienteestado').val().toUpperCase(),

			todos: $('#idFTodos').val(),
			texto: $('#idFTexto').val()
		};
	}


	function EnviarInformacionCliente(accion, objEvento, modal, pag=1) { 
		$.ajax({
			type: 'POST',
			url: base_url+'/cliente/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				var resp = JSON.parse(msg);
				$('#PaginadoCliente').empty();
				$('#PaginadoCliente').append(resp.pag);
				if (modal) {
					$('#modalAgregarCliente').modal('toggle');	
					if (accion == 'agregar') { // de momento
						AgregarPasajeros();
					}	
					LimpiarModalDatosCliente();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								CargartablaCliente(resp.datos)
							}
						})
					} else {
						Swal.fire({
							title: resp.mensaje,
							icon: 'error'
						})
					}
				}else{
					CargartablaCliente(resp.datos)
				}
			},
			error: function(){
				Swal.fire(
					'Oops...',
					'Something went wrong!',
					'error'
				)
			}
		});
	}


	function LimpiarModalDatosCliente(){
		$('#idcliente').val('0');
		$('#idtipodoc').select2().val(0).select2('destroy').select2();
		$('#clientenombre').val('');
		$('#clienteapellidos').val('');
		$('#clientetelefono').val('');
		$('#clientecorreo').val('');
		$('#clientedireccion').val('');
		$('#clientepais').val('');
		$('#clientefechanacimiento').val('');
		$('#clienteedad').val('');

	}


	function ValidarCamposVaciosCliente(){
		var error = 0;
		if ($('#idcliente').val() == ''){
			Resaltado('idcliente');
			error++;
		}
		if ($('#idtipodoc').val() == ''){
			Resaltado('idtipodoc');
			error++;
		}
		if ($('#clientenombre').val() == ''){
			Resaltado('clientenombre');
			error++;
		}
		if ($('#clienteapellidos').val() == ''){
			Resaltado('clienteapellidos');
			error++;
		}
		if ($('#clientetelefono').val() == ''){
			Resaltado('clientetelefono');
			error++;
		}
		if ($('#clientecorreo').val() == ''){
			Resaltado('clientecorreo');
			error++;
		}
		if ($('#clientedireccion').val() == ''){
			Resaltado('clientedireccion');
			error++;
		}
		if ($('#clientepais').val() == ''){
			Resaltado('clientepais');
			error++;
		}
		if ($('#clientefechanacimiento').val() == ''){
			Resaltado('clientefechanacimiento');
			error++;
		}
		if ($('#clienteedad').val() == ''){
			Resaltado('clienteedad');
			error++;
		}
		if ($('#clientesexo').val() == ''){
			Resaltado('clientesexo');
			error++;
		}
		if ($('#clienteestado').val() == ''){
			Resaltado('clienteestado');
			error++;
		}

		return error;
	}


	function Resaltado(id){
		$('#'+id).css('border-color', '#ef5350');
		$('#'+id).focus();
	}


	function CargartablaCliente(objeto){   
		$('#TablaCliente tr').not($('#TablaCliente tr:first')).remove();
		$.each(objeto, function(i, value) {
		var fila = '<tr>'+
			'<td >'+value.idcliente+'</td>'+
			'<td>'+value.nombre+'</td>'+
			'<td >'+value.idtipodoc+'</td>'+
			'<td >'+value.clientenombre+'</td>'+
			'<td >'+value.clienteapellidos+'</td>'+
			'<td >'+value.clientetelefono+'</td>'+
			'<td >'+value.clientecorreo+'</td>'+
			'<td >'+value.clientedireccion+'</td>'+
			'<td >'+value.clientepais+'</td>'+
			'<td >'+value.clientefechanacimiento+'</td>'+
			'<td >'+value.clienteedad+'</td>'+
			'<td class = "hidden -xs">' + ((value.clientesexo == '1') ? 'M' : 'F') + '</td>'+
			'<td class = "hidden -xs">' + ((value.clienteestado == '1') ? 'ACTIVO' : 'DESACTIVO') + '</td>'+

			'<td>'+
				'<button type="button" onclick="btnEditarCliente(\''+value.idcliente+'\', \''+value.idtipodoc+'\')" class="btn btn-info btn-xs">'+
					'<span class="fa fa-search fa-sm"></span>'+
				'</button>'+
			'</td>'+
		'</tr>';
		$('#TablaCliente tbody').append(fila);
		});
	}


	function addEstado(i){
		$('#estado_'+i).append($('<option>').val('1').text('ACTIVO'));
		$('#estado_'+i).append($('<option>').val('0').text('DESACTIVO'));
	}


	function addCatHabitacion(i) {
		var sel = document.getElementById('habitacion');
		var Length = sel.length;
		for (var j = 0; j < Length; j++) {
		var opt = sel[j];
		$('#catHabitacion_'+i).append($('<option>').val(opt.value).text(opt.label));            
		}
	}


	function addEstado(i){
		$('#estado_'+i).append($('<option>').val('1').text('ACTIVO'));
		$('#estado_'+i).append($('<option>').val('0').text('DESACTIVO'));
	}


	function addCatHabitacion(i) {
		var sel = document.getElementById('habitacion');
		var Length = sel.length;
		for (var j = 0; j < Length; j++) {
		var opt = sel[j];
		$('#catHabitacion_'+i).append($('<option>').val(opt.value).text(opt.label));            
		}
	}

    addPais(0);
    $('#tipodoc').on('change', function() {
        if($(this).find(":selected").val() == 1)
            $("#btnReniec").prop("disabled", false)
        else
            $("#btnReniec").prop("disabled", true)
    });
    
    $("#nombres").autocomplete({
        source: function(request, response) {
            $.ajax({
                type: 'POST',
                url: base_url + "/cliente/getClientesSelectNombre",
                dataType: "json",
                data: { term: request.term },
                success: function(data){
                    response(data);
                }
            });
        },
        minLength: 2,
        select: function( event, ui ) {
            $('#tipodoc').val(ui.item.tipodoc);
            $('#idcliente').val(ui.item.id);
            $('#nombres').val(ui.item.value);
            $('#apellidos').val(ui.item.apellidos);
            $('#telefono').val(ui.item.telefono);
            $('#correo').val(ui.item.correo);
            $('#pais_0').select2().val(ui.item.pais).select2('destroy').select2();
            $('#direccion').val(ui.item.direccion);
            $('#edad').val(ui.item.edad);
        }
    });

    $('#btnReniec').click(function(){
        idcliente = $("#idcliente").val();
        if (idcliente == '') {
            $("#idcliente").css("border-color", "#ef5350");
            $("#idcliente").focus();
            alert('Completar campos obligatorios');
        }else{
            if (idcliente.length < 8) {
                $("#idcliente").css("border-color", "#ef5350");
                $("#idcliente").focus();
                alert('DNI debe de tener 8 digitos');
            }else{
                $.ajax({
                    type: 'POST',
                    url: base_url + "mantenimiento/clientes/ConsultaReniec/" + idcliente,
                    beforeSend: function(){
                        $("#btnReniec").prop("disabled", true);
                        $("#modal-overlay").modal().modal({ backdrop: "static" });
                    },
                    success: function(msg){
                        $("#btnReniec").prop("disabled", false);
                        $('#modal-overlay').modal('hide');
                        var resp = JSON.parse(msg);
                        if (resp.nombres.length > 0) {
                            $('#nombres').val(resp.nombres);
                            $('#apellidos').val(resp.apellidos);
                            $('#telefono').val('999999999');
                            $('#correo').val(resp.nombres.split(' ')[0]+'@GMAIL.COM');
                            $('#direccion').val('AV. LA CULTURA 124');
                            $('#modaldeltallepersona').text('Detalle persona');
                        }else{
                            $('#modaldeltallepersona').text('DNI no valido para Reniec');
                            LimpiarModalCliente();
                        }
                    },
                    error: function(){
                        Swal.fire(                            
                            'Oops...',
                            'Something went wrong!',
                            'error'
                        )
                    }
                });
            }
        }
    });

    
  // fin modulo personas

  function alerta(msj){
    $("#labelalerta").text(msj);
    $("#modal-default-alerta").modal("show");
  }



  $(function () {    
    //Initialize Select2 Elements
    $('.select2').select2()
    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()
    //Date range picker
    $('#fechainicio').daterangepicker({
      format: 'dd/mm/yyyy'
    })
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )
    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()
    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()
    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    });
    // $("input[data-bootstrap-switch]").each(function(){
    //   $(this).bootstrapSwitch('state', $(this).prop('checked'));
    // });
  })
  $(function() {
    $('#midestado').bootstrapToggle({
        on: 'Enabled',
        off: 'Disabled'
    });
  })


$(document).ready(function () {
    var base_url= "<?php echo base_url();?>";
    var NuevoCliente;
    
    
    

    $(".btn-remove").on("click", function(e){
        e.preventDefault();
        var ruta = $(this).attr("href");
        //alert(ruta);
        $.ajax({
            url: ruta,
            type:"POST",
            success:function(resp){
                //http://localhost/ventas_ci/mantenimiento/productos
                window.location.href = base_url + resp;
            }
        });
    });
    $(".btn-view-producto").on("click", function(){
        var producto = $(this).val(); 
        //alert(cliente);
        var infoproducto = producto.split("*");
        html = "<p><strong>Codigo:</strong>"+infoproducto[1]+"</p>"
        html += "<p><strong>Nombre:</strong>"+infoproducto[2]+"</p>"
        html += "<p><strong>Descripcion:</strong>"+infoproducto[3]+"</p>"
        html += "<p><strong>Precio:</strong>"+infoproducto[4]+"</p>"
        html += "<p><strong>Stock:</strong>"+infoproducto[5]+"</p>"
        html += "<p><strong>Categoria:</strong>"+infoproducto[6]+"</p>";
        $("#modal-default .modal-body").html(html);
    });
    $(".btn-view-cliente").on("click", function(){
        var cliente = $(this).val(); 
        //alert(cliente);
        var infocliente = cliente.split("*");
        html = "<p><strong>Nombres:</strong>"+infocliente[1]+"</p>"
        html += "<p><strong>Apellidos:</strong>"+infocliente[2]+"</p>"
        html += "<p><strong>Telefono:</strong>"+infocliente[3]+"</p>"
        html += "<p><strong>Direccion:</strong>"+infocliente[4]+"</p>"
        html += "<p><strong>RUC:</strong>"+infocliente[5]+"</p>"
        html += "<p><strong>Empresa:</strong>"+infocliente[6]+"</p>";
        $("#modal-default .modal-body").html(html);
    });
    $(".btn-view").on("click", function(){
        var id = $(this).val();
        $.ajax({
            url: base_url + "mantenimiento/categorias/view/" + id,
            type:"POST",
            success:function(resp){
                $("#modal-default .modal-body").html(resp);
                //alert(resp);
            }
        });
    });
    $(".btn-view-tour").on("click", function(){
        var id = $(this).val();
        $.ajax({
            url: base_url + "tours/view/" + id,
            type:"POST",
            success:function(resp){
                $("#modal-default .modal-body").html(resp);
                //alert(resp);
            }
        });
    });
    // $('#tabla-saldo').DataTable({
    //     "order": [[ 0, "desc" ]],
    //     responsive: true,
    //     "language": {
    //         "lengthMenu": "Mostrar _MENU_ registros por pagina",
    //         "zeroRecords": "No se encontraron resultados en su busqueda",
    //         "searchPlaceholder": "Buscar registros",
    //         "info": "Mostrando registros de _START_ al _END_ de un total de  _TOTAL_ registros",
    //         "infoEmpty": "No existen registros",
    //         "infoFiltered": "(filtrado de un total de _MAX_ registros)",
    //         "search": "Buscar:",
    //         "paginate": {
    //             "first": "Primero",
    //             "last": "Último",
    //             "next": "Siguiente",
    //             "previous": "Anterior"
    //         },
    //     }
    // });
	// $('.sidebar-menu').tree();    
})
$(".solo_numero").keypress(function (event) {
    key = event.keyCode ? event.keyCode : event.which;
    if (key == 46) return false;
    if (key == 8 || key == 9) return true;
    if ((key > 47 && key < 58) || key == 46) {
        if ($(this).val() == "") return true;
        var regexp = new RegExp('[0-9]{0,8}');
        return regexp.test($(this).val());
    }
    return false;
});
</script>
</body>
</html>

