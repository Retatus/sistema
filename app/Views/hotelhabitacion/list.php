<div class='content-wrapper'>
	<section class='content-header'>
	</section>
	<section class='content'>
		<div class='row'>
			<div class='col-12'>
				<div class='card'>
					<div class='card-header'>
						<div class='row'>
							<div class='col-sm-8'>
								<button type='button' class='btn btn-info btn-sm' id='btnAgregarHotelhabitacion'>
									<span class='fa fa-plus'></span> Agregar Hotelhabitacion
								</button>
								<a href='<?php echo base_url();?>hotelhabitacion/excel' class='btn btn-success btn-sm'>
									<span class='fa fa-file-excel'></span> Exportar
								</a>
								<a href='<?php echo base_url();?>hotelhabitacion/pdf' target='_blank' class='btn btn-danger btn-sm'>
									<span class='fa fa-file-pdf-o'></span> Exportar
								</a>
							</div>
							<div class='col-sm-4'>
								<div class='d-flex flex-row'>
									<div class='p-2'>
										<input id='idFTexto' type='search' class='form-control form-control-sm' placeholder='Doc. | Nombre | Apellido'>
									</div>
									<div class='p-2'>
										<div class='input-group'>
											<select id='idFTodos' class='form-control form-control-sm'>
												<option value=''>TODOS</option>
												<option value='0'>DESCATIVOS</option>
												<option value='1' selected>ACTIVOS</option>
											</select>
											<span class='input-group-btn'>
												<button type='button' class='btn btn-info btn-sm' id='btnFiltroHotelhabitacion'>
													<span class='fa fa-filter'></span> Buscar
												</button>
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class='card-body'>
						<div class='demo-content scroll'>
							<table id='TablaHotelhabitacion' class='table table-sm table-bordered table-striped'>
								<thead>
									<tr>
										<th hidden>Id</th>
										<th>Hotel</th>
										<th>banco</th>
										<th>cathotel</th>
										<th hidden>Idhotel</th>
										<th>Cathabitacion</th>
										<th hidden>Idcathabitacion</th>
										<th >Precio</th>
										<th >Fecha</th>
										<th >Estado</th>
										<th >Confirmado</th>
										<th>Acciones</th>

									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $hotelhabitacion):?>
											<tr>
												<td hidden><?php echo $hotelhabitacion['idhotelhabitacion'];?></td>
												<td><?php echo $hotelhabitacion['nombre'];?></td>
												<td><?php echo $hotelhabitacion['banco'];?></td>
												<td><?php echo $hotelhabitacion['cathotel'];?></td>
												<td hidden><?php echo $hotelhabitacion['idhotel'];?></td>
												<td><?php echo $hotelhabitacion['nombre'];?></td>
												<td hidden><?php echo $hotelhabitacion['idcathabitacion'];?></td>
												<td ><?php echo $hotelhabitacion['precio'];?></td>
												<td ><?php echo $hotelhabitacion['fecha'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($hotelhabitacion['estado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>
												<td class = 'hidden-xs'><?php echo $est = ($hotelhabitacion['confirmado']== 1) ? 'CONFIRMADO' : 'PENDIENTE';?></td>

												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarHotelhabitacion('<?php echo $hotelhabitacion['idhotelhabitacion'].'\',\''. $hotelhabitacion['idcathabitacion'].'\',\''. $hotelhabitacion['idhotel'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-search fa-xs'></span>
															</button>
														</div>
														<div style='margin: auto;'>
															<a class='btn btn-success btn-xs' href='<?php echo base_url();?>reserva/add/<?php echo $hotelhabitacion['idhotelhabitacion'].'\',\''. $hotelhabitacion['idcathabitacion'].'\',\''. $hotelhabitacion['idhotel'];?>'><i class='fa fa-pencil'></i></a>
														</div>
													</div>
												</td>
											</tr>
										<?php endforeach;?>
									<?php endif;?>
								</tbody>
							</table>
						</div>
						<div id='PaginadoHotelhabitacion'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<div class='modal fade' id='modalAgregarHotelhabitacion' tabindex='-1'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title' id='modaldeltalletour'>Detalle Hotelhabitacion</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<div class='col-6 form-group row'hidden>
					<label class='col-sm-4' for='id'>id:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='idhotelhabitacion' name='idhotelhabitacion' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4'>Cathabitacion:</label>
					<div class = 'col-sm-8'>
						<select class='form-control form-control-sm select2' id='idcathabitacion'>
							<option value='0'>-- SELECCIONAR1 --</option>
							<?php if (!empty($cathabitacions)):?>
								<?php foreach($cathabitacions as $cathabitacion):?>
									<option value= '<?php echo $cathabitacion['idcathabitacion'];?>'><?php echo $cathabitacion['concatenado'];?></option>
								<?php endforeach;?>
							<?php endif;?>
						</select>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4'>Hotel:</label>
					<div class = 'col-sm-8'>
						<select class='form-control form-control-sm select2' id='idhotel'>
							<option value='0'>-- SELECCIONAR1 --</option>
							<?php if (!empty($hotels)):?>
								<?php foreach($hotels as $hotel):?>
									<option value= '<?php echo $hotel['idhotel'];?>'><?php echo $hotel['concatenado'];?></option>
								<?php endforeach;?>
							<?php endif;?>
						</select>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>precio:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='precio' name='precio' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4'>fecha:</label>
					<div class='col-sm-8'>
						<div class='input-group'>
							<div class='input-group-prepend'>
								<span class='input-group-text'>
									<i class='far fa-calendar-alt'></i>
								</span>
							</div>
							<input type='text' class='form-control form-control-sm' id='fecha' name='fecha' placeholder='dd/mm/yyyy' readonly>
						</div>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='rol'>estado:</label>
					<div class='col-sm-8'>
						<select class='form-control form-control-sm' id='estado' name='estado'>
							<option value = '1' selected >ACTIVO</option>
							<option value = '0' >DESACTIVO</option>
						</select>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='rol'>confirmado:</label>
					<div class='col-sm-8'>
						<select class='form-control form-control-sm' id='confirmado' name='confirmado'>
							<option value = '1' selected >CONFIRMADO</option>
							<option value = '0' >CANCELADO</option>
						</select>
					</div>
				</div>

			</div>
		</div>
		<div class='modal-footer'>
			<button type='button' class='btn btn-success btn-sm' id='btnModalAgregarHotelhabitacion'>Agregar</button>
			<button type='button' class='btn btn-warning btn-sm' id='btnModalEditarHotelhabitacion'>Modificar</button>
			<button type='button' class='btn btn-danger btn-sm' id='btnModalEliminarHotelhabitacion'>Eliminar</button>
			<button type='button' class='btn btn-primary btn-sm' id='btnModalCerrarHotelhabitacion' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<div class='modal fade show' id='modal_agregar_tcathabitacion' aria-modal='true' style='padding-right: 17px;z-index: 2500;'>
	<div class='modal-dialog modal-sm'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title'>Agregar Cathabitacion</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
			<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<label class='col-sm-3'>Cathabitacion:</label>
				<div class = 'col-sm-9'>
					<input type='text' class='form-control form-control-sm' id='IdNuevaCathabitacion'>
				</div>
			</div>
		</div>
		<div class='modal-footer'>
			<button type='button' class='btn btn-success btn-sm' id='IdBtnNuevaCathabitacion'>Agregar</button>
			<button type='button' class='btn btn-primary btn-sm' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<div class='modal fade show' id='modal_agregar_thotel' aria-modal='true' style='padding-right: 17px;z-index: 2500;'>
	<div class='modal-dialog modal-sm'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title'>Agregar Hotel</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
			<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<label class='col-sm-3'>Hotel:</label>
				<div class = 'col-sm-9'>
					<input type='text' class='form-control form-control-sm' id='IdNuevaHotel'>
				</div>
			</div>
		</div>
		<div class='modal-footer'>
			<button type='button' class='btn btn-success btn-sm' id='IdBtnNuevaHotel'>Agregar</button>
			<button type='button' class='btn btn-primary btn-sm' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>

<script>
	var NuevoHotelhabitacion;
	var base_url= '<?php echo base_url();?>';


	function NumeroFilasTabla(){
		TamanioTabla = $('#tabla_Habitaciones tr').length - 1;
		$('#minmax').val(TamanioTabla)
	}


	function load(pag){
		RecolectarDatosHotelhabitacion();
		EnviarInformacionHotelhabitacion('leer', NuevoHotelhabitacion, false, pag);
	}


	$('#fecha').datepicker({
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
				url: base_url + '/reservadetallehotelhabitacion/autocompletereservas',
				dataType: 'json',
				data: { keyword: request.term },
				success: function(data){
					response($.map(data, function(item) {
						return {
							label: item.concatenado,
							concatenado: item.concatenado,
							idtour: item.idreserva,
							nombre: item.reservanombre,

							
							concatenadodetalle: item.concatenadodetalle,

						}
					}))
				}
			});
		},
		minLength: 2,
		select: function( event, ui ) {
			$('#idreserva').val('');
			var j = $('#tablaDetalleServicio tr').length;
			var i = parseInt((j == 1 ? 0 : $('#tablaDetalleServicio').find('tr').eq(j - 1).find('td').eq(0).html()));
			var rows = "<tr id=Fila_" + (i + 1) + ">"+
				"<td hidden>" + (i + 1) + "</td>"+
				"<td hidden><input type='text' class='form-control form-control-sm' id='detalleTipoServicio_" + (i + 1) + "' value='treservadetallehotelhabitacion'></td>"+
				"<td hidden><input type='text' class='form-control form-control-sm' id='detalleIdReserva_" + (i + 1) + "' value=''></td>"+
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
					"<select class='form-control form-control-sm select2' id='detalleGravado_" + (i + 1) + "' style='width: 100%;'>"+
						"<option value='10'>GRAV</option>"+
						"<option value='20'>EXON</option>"+
						"<option value='30'>INAF</option>"+
						"<option value='40'>EXPO</option>"+
					"</select>"+
				"</td>"+
				"<td>" + ui.item.idtour + "</td>"+
				"<td>" + ui.item.concatenadodetalle + "</td>"+
				"<td><input type='text' class='form-control form-control-sm text-uppercase datepicker" + (i + 1) + "' id='detalleFecha_" + (i + 1) + "' readonly></td>"+
				"<td><input type='text' class='form-control form-control-sm text-uppercase numeroDerecha' id='detallecantidad_" + (i + 1) + "' placeholder='cantidad' value='1'></td>"+
				"<td><input type='text' class='form-control form-control-sm text-uppercase numeroDerecha' id='detalleprecio_" + (i + 1) + "' placeholder='precio' value='" + 0.00 + "'></td>"+
				"<td><input type='text' class='form-control form-control-sm text-uppercase numeroDerecha' id='detalletotal_" + (i + 1) + "' placeholder='total' value='' disabled></td>"+
				"<td>"+
					"<select class='form-control form-control-sm select2' id='detalleConfirmado_" + (i + 1) + "' style='width: 100%;'>"+
						"<option value='1'>CONFIRMADO</option>"+
						"<option value='2'>PENDIENTE</option>"+
						"<option value='3'>ANULADO</option>"+
					"</select>"+
				"</td>"+
				"<td>"+
					"<select class='form-control form-control-sm select2' id='detallePagado_" + (i + 1) + "' style='width: 100%;'>"+
						"<option value='0'>PAGADO</option>"+
						"<option value='0'>PENDIENTE</option>"+
					"</select>"+
				"</td>"+
				"<td>"+
					"<select class='form-control form-control-sm select2' id='detalleEstado_" + (i + 1) + "' style='width: 100%;'>"+
						"<option value='0'>ACTIVO</option>"+
						"<option value='0'>DESACTIVO</option>"+
					"</select>"+
				"</td>"+
			"</tr>";
			$('#tablaDetalleServicio').append(rows);
			addDatepicker(i + 1);
			ImporteTotalDetalle(i + 1);
			return false;
		}
	});



	$('#btnAgregarHotelhabitacion').click(function(){
		LimpiarModalDatosHotelhabitacion();
		$('#categoria').val(1);
		$('#id').prop('readonly', false);  
		$('#IdModalGrupoCodigoHotel').prop('hidden', false);
		$('#btnModalAgregarHotelhabitacion').toggle(true);
		$('#btnModalEditarHotelhabitacion').toggle(false);
		$('#btnModalEliminarHotelhabitacion').toggle(false);
		$('#modalAgregarHotelhabitacion').modal();
	});


	function btnEditarHotelhabitacion(Val0, Val1, Val2){
		$.ajax({
			type: 'POST',
			url: base_url + '/hotelhabitacion/edit',
			data: { idhotelhabitacion: Val0, idcathabitacion: Val1, idhotel: Val2},
			success: function(msg){
		debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosHotelhabitacion();
				$('#idhotelhabitacion').val(temp.idhotelhabitacion);
				$('#idhotel').select2().val(temp.idhotel).select2('destroy').select2();
				$('#idcathabitacion').select2().val(temp.idcathabitacion).select2('destroy').select2();
				$('#precio').val(temp.precio);
				$('#fecha').val(temp.fecha);
				$('#estado').val(temp.estado);
				$('#confirmado').val(temp.confirmado);



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


				$('#btnModalAgregarHotelhabitacion').toggle(false);
				$('#btnModalEditarHotelhabitacion').toggle(true);
				$('#btnModalEliminarHotelhabitacion').toggle(true);
				$('#modalAgregarHotelhabitacion').modal('toggle');
			},
			error: function(){
				alert('Hay un error...');
			}
		});
	}


	$('#btnModalAgregarHotelhabitacion').click(function(){
debugger

		if (ValidarCamposVaciosHotelhabitacion() != 0) {
			alert('Completar campos obligatorios');
		}else{
			$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
			RecolectarDatosHotelhabitacion();
			EnviarInformacionHotelhabitacion('agregar', NuevoHotelhabitacion, true);
		}
	});


	$('#btnModalEditarHotelhabitacion').click(function(){
		if (ValidarCamposVaciosHotelhabitacion() != 0) {
			alert('Completar campos obligatorios');
		}else{
			RecolectarDatosHotelhabitacion();
			EnviarInformacionHotelhabitacion('modificar', NuevoHotelhabitacion, true);
		}
	});


	$('#btnModalEliminarHotelhabitacion').click(function(){
		var bool=confirm('ESTA SEGURO DE ELIMINAR EL DATO?');
		if(bool){
			RecolectarDatosHotelhabitacion();
			EnviarInformacionHotelhabitacion('eliminar', NuevoHotelhabitacion, true);
		}
	});


	$('#btnModalCerrarHotel').click(function(){
		$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
		LimpiarModalDatosHotelhabitacion();
	});


	$('#btnFiltroHotelhabitacion').click(function(){
		RecolectarDatosHotelhabitacion();
		EnviarInformacionHotelhabitacion('leer', NuevoHotelhabitacion, false);
	});


	function Paginado(pag) {
		RecolectarDatosHotelhabitacion();
		EnviarInformacionHotelhabitacion('leer', NuevoHotelhabitacion, false, pag);
	}


	function RecolectarDatosHotelhabitacion(){
		NuevoHotelhabitacion = {
			idhotelhabitacion: $('#idhotelhabitacion').val().toUpperCase(),
			idhotel: $('#idhotel').val().toUpperCase(),
			idcathabitacion: $('#idcathabitacion').val().toUpperCase(),
			precio: $('#precio').val().toUpperCase(),
			fecha: $('#fecha').val().toUpperCase(),
			estado: $('#estado').val().toUpperCase(),
			confirmado: $('#confirmado').val().toUpperCase(),

			todos: $('#idFTodos').val(),
			texto: $('#idFTexto').val()
		};
	}


	function EnviarInformacionHotelhabitacion(accion, objEvento, modal, pag=1) { 
		$.ajax({
			type: 'POST',
			url: base_url+'/hotelhabitacion/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				var resp = JSON.parse(msg);
				$('#PaginadoHotelhabitacion').empty();
				$('#PaginadoHotelhabitacion').append(resp.pag);
				if (modal) {
					$('#modalAgregarHotelhabitacion').modal('toggle');
					LimpiarModalDatosHotelhabitacion();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								CargartablaHotelhabitacion(resp.datos)
							}
						})
					} else {
						Swal.fire({
							title: resp.mensaje,
							icon: 'error'
						})
					}
				}else{
					CargartablaHotelhabitacion(resp.datos)
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


	function LimpiarModalDatosHotelhabitacion(){
		$('#idhotelhabitacion').val('0');
		$('#idhotel').select2().val(0).select2('destroy').select2();
		$('#idcathabitacion').select2().val(0).select2('destroy').select2();
		$('#precio').val('');
		$('#fecha').val('');

	}


	function ValidarCamposVaciosHotelhabitacion(){
		var error = 0;
		if ($('#idhotelhabitacion').val() == ''){
			Resaltado('idhotelhabitacion');
			error++;
		}
		if ($('#idhotel').val() == ''){
			Resaltado('idhotel');
			error++;
		}
		if ($('#idcathabitacion').val() == ''){
			Resaltado('idcathabitacion');
			error++;
		}
		if ($('#precio').val() == ''){
			Resaltado('precio');
			error++;
		}
		if ($('#fecha').val() == ''){
			Resaltado('fecha');
			error++;
		}
		if ($('#estado').val() == ''){
			Resaltado('estado');
			error++;
		}
		if ($('#confirmado').val() == ''){
			Resaltado('confirmado');
			error++;
		}

		return error;
	}


	function Resaltado(id){
		$('#'+id).css('border-color', '#ef5350');
		$('#'+id).focus();
	}


	function CargartablaHotelhabitacion(objeto){   
		$('#TablaHotelhabitacion tr').not($('#TablaHotelhabitacion tr:first')).remove();
		$.each(objeto, function(i, value) {
		var fila = '<tr>'+
			'<td hidden>'+value.idhotelhabitacion+'</td>'+
			'<td>'+value.nombre+'</td>'+
			'<td>'+value.banco+'</td>'+
			'<td>'+value.cathotel+'</td>'+
			'<td hidden>'+value.idhotel+'</td>'+
			'<td>'+value.nombre+'</td>'+
			'<td hidden>'+value.idcathabitacion+'</td>'+
			'<td >'+value.precio+'</td>'+
			'<td >'+value.fecha+'</td>'+
			'<td class = "hidden -xs">' + ((value.estado == '1') ? 'ACTIVO' : 'DESACTIVO') + '</td>'+
			'<td class = "hidden -xs">' + ((value.confirmado == '1') ? 'CONFIRMADO' : 'PENDIENTE') + '</td>'+

			'<td>'+
				'<div class="row">'+
					'<div style="margin: auto;">'+
						'<button type="button" onclick="btnEditarHotelhabitacion(\''+value.idhotelhabitacion+'\', \''+value.idcathabitacion+'\', \''+value.idhotel+'\')" class="btn btn-info btn-xs">'+
							'<span class="fa fa-search fa-sm"></span>'+
						'</button>'+
					'</div>'+
						'<div style="margin: auto;">'+
							'<a class="btn btn-success btn-xs" href="<?php echo base_url();?>/reserva/add"><i class="fa fa-pencil"></i></a>'+
					'</div>'+
				'</div>'+
			'</td>'+
		'</tr>';
		$('#TablaHotelhabitacion tbody').append(fila);
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
</script>
