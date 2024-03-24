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
								<button type='button' class='btn btn-info btn-sm' id='btnAgregarHorarioticketmapi'>
									<span class='fa fa-plus'></span> Agregar Horarioticketmapi
								</button>
								<a href='<?php echo base_url();?>horarioticketmapi/excel' class='btn btn-success btn-sm'>
									<span class='fa fa-file-excel'></span> Exportar
								</a>
								<a href='<?php echo base_url();?>horarioticketmapi/pdf' target='_blank' class='btn btn-danger btn-sm'>
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
												<button type='button' class='btn btn-info btn-sm' id='btnFiltroHorarioticketmapi'>
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
							<table id='TablaHorarioticketmapi' class='table table-sm table-bordered table-striped'>
								<thead>
									<tr>
										<th hidden>Id</th>
										<th>Horaticketmapi</th>
										<th >Idhoraticketmapi</th>
										<th>Ticketmapi</th>
										<th >Idticketmapi</th>
										<th>Clientetipo</th>
										<th >Idclientetipo</th>
										<th >Precio</th>
										<th >Estado</th>
										<th>Acciones</th>

									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $horarioticketmapi):?>
											<tr>
												<td hidden><?php echo $horarioticketmapi['idhorarioticketmapi'];?></td>
												<td><?php echo $horarioticketmapi['nombre'];?></td>
												<td ><?php echo $horarioticketmapi['idhoraticketmapi'];?></td>
												<td><?php echo $horarioticketmapi['nombre'];?></td>
												<td ><?php echo $horarioticketmapi['idticketmapi'];?></td>
												<td><?php echo $horarioticketmapi['nombre'];?></td>
												<td ><?php echo $horarioticketmapi['idclientetipo'];?></td>
												<td ><?php echo $horarioticketmapi['precio'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($horarioticketmapi['estado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>

												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarHorarioticketmapi('<?php echo $horarioticketmapi['idhorarioticketmapi'].'\',\''. $horarioticketmapi['idclientetipo'].'\',\''. $horarioticketmapi['idhoraticketmapi'].'\',\''. $horarioticketmapi['idticketmapi'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-search fa-xs'></span>
															</button>
														</div>
														<div style='margin: auto;'>
															<a class='btn btn-success btn-xs' href='<?php echo base_url();?>reserva/add/<?php echo $horarioticketmapi['idhorarioticketmapi'].'\',\''. $horarioticketmapi['idclientetipo'].'\',\''. $horarioticketmapi['idhoraticketmapi'].'\',\''. $horarioticketmapi['idticketmapi'];?>'><i class='fa fa-pencil'></i></a>
														</div>
													</div>
												</td>
											</tr>
										<?php endforeach;?>
									<?php endif;?>
								</tbody>
							</table>
						</div>
						<div id='PaginadoHorarioticketmapi'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<div class='modal fade' id='modalAgregarHorarioticketmapi' tabindex='-1'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title' id='modaldeltalletour'>Detalle Horarioticketmapi</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<div class='col-6 form-group row'hidden>
					<label class='col-sm-4' for='id'>id:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='idhorarioticketmapi' name='idhorarioticketmapi' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4'>Clientetipo:</label>
					<div class = 'col-sm-8'>
						<select class='form-control form-control-sm select2' id='idclientetipo'>
							<option value='0'>-- SELECCIONAR1 --</option>
							<?php if (!empty($clientetipos)):?>
								<?php foreach($clientetipos as $clientetipo):?>
									<option value= '<?php echo $clientetipo['idclientetipo'];?>'><?php echo $clientetipo['concatenado'];?></option>
								<?php endforeach;?>
							<?php endif;?>
						</select>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4'>Horaticketmapi:</label>
					<div class = 'col-sm-8'>
						<select class='form-control form-control-sm select2' id='idhoraticketmapi'>
							<option value='0'>-- SELECCIONAR1 --</option>
							<?php if (!empty($horaticketmapis)):?>
								<?php foreach($horaticketmapis as $horaticketmapi):?>
									<option value= '<?php echo $horaticketmapi['idhoraticketmapi'];?>'><?php echo $horaticketmapi['concatenado'];?></option>
								<?php endforeach;?>
							<?php endif;?>
						</select>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4'>Ticketmapi:</label>
					<div class = 'col-sm-8'>
						<select class='form-control form-control-sm select2' id='idticketmapi'>
							<option value='0'>-- SELECCIONAR1 --</option>
							<?php if (!empty($ticketmapis)):?>
								<?php foreach($ticketmapis as $ticketmapi):?>
									<option value= '<?php echo $ticketmapi['idticketmapi'];?>'><?php echo $ticketmapi['concatenado'];?></option>
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
					<label class='col-sm-4' for='rol'>estado:</label>
					<div class='col-sm-8'>
						<select class='form-control form-control-sm' id='estado' name='estado'>
							<option value = '1' selected >ACTIVO</option>
							<option value = '0' >DESACTIVO</option>
						</select>
					</div>
				</div>

			</div>
		</div>
		<div class='modal-footer'>
			<button type='button' class='btn btn-success btn-sm' id='btnModalAgregarHorarioticketmapi'>Agregar</button>
			<button type='button' class='btn btn-warning btn-sm' id='btnModalEditarHorarioticketmapi'>Modificar</button>
			<button type='button' class='btn btn-danger btn-sm' id='btnModalEliminarHorarioticketmapi'>Eliminar</button>
			<button type='button' class='btn btn-primary btn-sm' id='btnModalCerrarHorarioticketmapi' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<div class='modal fade show' id='modal_agregar_tclientetipo' aria-modal='true' style='padding-right: 17px;z-index: 2500;'>
	<div class='modal-dialog modal-sm'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title'>Agregar Clientetipo</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
			<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<label class='col-sm-3'>Clientetipo:</label>
				<div class = 'col-sm-9'>
					<input type='text' class='form-control form-control-sm' id='IdNuevaClientetipo'>
				</div>
			</div>
		</div>
		<div class='modal-footer'>
			<button type='button' class='btn btn-success btn-sm' id='IdBtnNuevaClientetipo'>Agregar</button>
			<button type='button' class='btn btn-primary btn-sm' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<div class='modal fade show' id='modal_agregar_thoraticketmapi' aria-modal='true' style='padding-right: 17px;z-index: 2500;'>
	<div class='modal-dialog modal-sm'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title'>Agregar Horaticketmapi</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
			<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<label class='col-sm-3'>Horaticketmapi:</label>
				<div class = 'col-sm-9'>
					<input type='text' class='form-control form-control-sm' id='IdNuevaHoraticketmapi'>
				</div>
			</div>
		</div>
		<div class='modal-footer'>
			<button type='button' class='btn btn-success btn-sm' id='IdBtnNuevaHoraticketmapi'>Agregar</button>
			<button type='button' class='btn btn-primary btn-sm' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<div class='modal fade show' id='modal_agregar_tticketmapi' aria-modal='true' style='padding-right: 17px;z-index: 2500;'>
	<div class='modal-dialog modal-sm'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title'>Agregar Ticketmapi</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
			<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<label class='col-sm-3'>Ticketmapi:</label>
				<div class = 'col-sm-9'>
					<input type='text' class='form-control form-control-sm' id='IdNuevaTicketmapi'>
				</div>
			</div>
		</div>
		<div class='modal-footer'>
			<button type='button' class='btn btn-success btn-sm' id='IdBtnNuevaTicketmapi'>Agregar</button>
			<button type='button' class='btn btn-primary btn-sm' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>

<script>
	var NuevoHorarioticketmapi;
	var base_url= '<?php echo base_url();?>';


	function NumeroFilasTabla(){
		TamanioTabla = $('#tabla_Habitaciones tr').length - 1;
		$('#minmax').val(TamanioTabla)
	}


	function load(pag){
		RecolectarDatosHorarioticketmapi();
		EnviarInformacionHorarioticketmapi('leer', NuevoHorarioticketmapi, false, pag);
	}



	$('#idreserva').autocomplete({ 
		source: function(request, response) {
			$.ajax({
				type: 'POST',
				url: base_url + '/reservadetallehorarioticketmapi/autocompletereservas',
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
				"<td hidden><input type='text' class='form-control form-control-sm' id='detalleTipoServicio_" + (i + 1) + "' value='treservadetallehorarioticketmapi'></td>"+
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



	$('#btnAgregarHorarioticketmapi').click(function(){
		LimpiarModalDatosHorarioticketmapi();
		$('#categoria').val(1);
		$('#id').prop('readonly', false);  
		$('#IdModalGrupoCodigoHotel').prop('hidden', false);
		$('#btnModalAgregarHorarioticketmapi').toggle(true);
		$('#btnModalEditarHorarioticketmapi').toggle(false);
		$('#btnModalEliminarHorarioticketmapi').toggle(false);
		$('#modalAgregarHorarioticketmapi').modal();
	});


	function btnEditarHorarioticketmapi(Val0, Val1, Val2, Val3){
		$.ajax({
			type: 'POST',
			url: base_url + '/horarioticketmapi/edit',
			data: { idhorarioticketmapi: Val0, idclientetipo: Val1, idhoraticketmapi: Val2, idticketmapi: Val3},
			success: function(msg){
		debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosHorarioticketmapi();
				$('#idhorarioticketmapi').val(temp.idhorarioticketmapi);
				$('#idhoraticketmapi').select2().val(temp.idhoraticketmapi).select2('destroy').select2();
				$('#idticketmapi').select2().val(temp.idticketmapi).select2('destroy').select2();
				$('#idclientetipo').select2().val(temp.idclientetipo).select2('destroy').select2();
				$('#precio').val(temp.precio);
				$('#estado').val(temp.estado);



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


				$('#btnModalAgregarHorarioticketmapi').toggle(false);
				$('#btnModalEditarHorarioticketmapi').toggle(true);
				$('#btnModalEliminarHorarioticketmapi').toggle(true);
				$('#modalAgregarHorarioticketmapi').modal('toggle');
			},
			error: function(){
				alert('Hay un error...');
			}
		});
	}


	$('#btnModalAgregarHorarioticketmapi').click(function(){
debugger

		if (ValidarCamposVaciosHorarioticketmapi() != 0) {
			alert('Completar campos obligatorios');
		}else{
			$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
			RecolectarDatosHorarioticketmapi();
			EnviarInformacionHorarioticketmapi('agregar', NuevoHorarioticketmapi, true);
		}
	});


	$('#btnModalEditarHorarioticketmapi').click(function(){
		if (ValidarCamposVaciosHorarioticketmapi() != 0) {
			alert('Completar campos obligatorios');
		}else{
			RecolectarDatosHorarioticketmapi();
			EnviarInformacionHorarioticketmapi('modificar', NuevoHorarioticketmapi, true);
		}
	});


	$('#btnModalEliminarHorarioticketmapi').click(function(){
		var bool=confirm('ESTA SEGURO DE ELIMINAR EL DATO?');
		if(bool){
			RecolectarDatosHorarioticketmapi();
			EnviarInformacionHorarioticketmapi('eliminar', NuevoHorarioticketmapi, true);
		}
	});


	$('#btnModalCerrarHotel').click(function(){
		$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
		LimpiarModalDatosHorarioticketmapi();
	});


	$('#btnFiltroHorarioticketmapi').click(function(){
		RecolectarDatosHorarioticketmapi();
		EnviarInformacionHorarioticketmapi('leer', NuevoHorarioticketmapi, false);
	});


	function Paginado(pag) {
		RecolectarDatosHorarioticketmapi();
		EnviarInformacionHorarioticketmapi('leer', NuevoHorarioticketmapi, false, pag);
	}


	function RecolectarDatosHorarioticketmapi(){
		NuevoHorarioticketmapi = {
			idhorarioticketmapi: $('#idhorarioticketmapi').val().toUpperCase(),
			idhoraticketmapi: $('#idhoraticketmapi').val().toUpperCase(),
			idticketmapi: $('#idticketmapi').val().toUpperCase(),
			idclientetipo: $('#idclientetipo').val().toUpperCase(),
			precio: $('#precio').val().toUpperCase(),
			estado: $('#estado').val().toUpperCase(),

			todos: $('#idFTodos').val(),
			texto: $('#idFTexto').val()
		};
	}


	function EnviarInformacionHorarioticketmapi(accion, objEvento, modal, pag=1) { 
		$.ajax({
			type: 'POST',
			url: base_url+'/horarioticketmapi/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				var resp = JSON.parse(msg);
				$('#PaginadoHorarioticketmapi').empty();
				$('#PaginadoHorarioticketmapi').append(resp.pag);
				if (modal) {
					$('#modalAgregarHorarioticketmapi').modal('toggle');
					LimpiarModalDatosHorarioticketmapi();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								CargartablaHorarioticketmapi(resp.datos)
							}
						})
					} else {
						Swal.fire({
							title: resp.mensaje,
							icon: 'error'
						})
					}
				}else{
					CargartablaHorarioticketmapi(resp.datos)
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


	function LimpiarModalDatosHorarioticketmapi(){
		$('#idhorarioticketmapi').val('0');
		$('#idhoraticketmapi').select2().val(0).select2('destroy').select2();
		$('#idticketmapi').select2().val(0).select2('destroy').select2();
		$('#idclientetipo').select2().val(0).select2('destroy').select2();
		$('#precio').val('');

	}


	function ValidarCamposVaciosHorarioticketmapi(){
		var error = 0;
		if ($('#idhorarioticketmapi').val() == ''){
			Resaltado('idhorarioticketmapi');
			error++;
		}
		if ($('#idhoraticketmapi').val() == ''){
			Resaltado('idhoraticketmapi');
			error++;
		}
		if ($('#idticketmapi').val() == ''){
			Resaltado('idticketmapi');
			error++;
		}
		if ($('#idclientetipo').val() == ''){
			Resaltado('idclientetipo');
			error++;
		}
		if ($('#precio').val() == ''){
			Resaltado('precio');
			error++;
		}
		if ($('#estado').val() == ''){
			Resaltado('estado');
			error++;
		}

		return error;
	}


	function Resaltado(id){
		$('#'+id).css('border-color', '#ef5350');
		$('#'+id).focus();
	}


	function CargartablaHorarioticketmapi(objeto){   
		$('#TablaHorarioticketmapi tr').not($('#TablaHorarioticketmapi tr:first')).remove();
		$.each(objeto, function(i, value) {
		var fila = '<tr>'+
			'<td hidden>'+value.idhorarioticketmapi+'</td>'+
			'<td>'+value.nombre+'</td>'+
			'<td >'+value.idhoraticketmapi+'</td>'+
			'<td>'+value.nombre+'</td>'+
			'<td >'+value.idticketmapi+'</td>'+
			'<td>'+value.nombre+'</td>'+
			'<td >'+value.idclientetipo+'</td>'+
			'<td >'+value.precio+'</td>'+
			'<td class = "hidden -xs">' + ((value.estado == '1') ? 'ACTIVO' : 'DESACTIVO') + '</td>'+

			'<td>'+
				'<div class="row">'+
					'<div style="margin: auto;">'+
						'<button type="button" onclick="btnEditarHorarioticketmapi(\''+value.idhorarioticketmapi+'\', \''+value.idclientetipo+'\', \''+value.idhoraticketmapi+'\', \''+value.idticketmapi+'\')" class="btn btn-info btn-xs">'+
							'<span class="fa fa-search fa-sm"></span>'+
						'</button>'+
					'</div>'+
						'<div style="margin: auto;">'+
							'<a class="btn btn-success btn-xs" href="<?php echo base_url();?>/reserva/add"><i class="fa fa-pencil"></i></a>'+
					'</div>'+
				'</div>'+
			'</td>'+
		'</tr>';
		$('#TablaHorarioticketmapi tbody').append(fila);
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
