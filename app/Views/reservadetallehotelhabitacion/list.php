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
								<button type='button' class='btn btn-info btn-sm' id='btnAgregarReservadetallehotelhabitacion'>
									<span class='fa fa-plus'></span> Agregar Reservadetallehotelhabitacion
								</button>
								<a href='<?php echo base_url();?>reservadetallehotelhabitacion/excel' class='btn btn-success btn-sm'>
									<span class='fa fa-file-excel'></span> Exportar
								</a>
								<a href='<?php echo base_url();?>reservadetallehotelhabitacion/pdf' target='_blank' class='btn btn-danger btn-sm'>
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
												<button type='button' class='btn btn-info btn-sm' id='btnFiltroReservadetallehotelhabitacion'>
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
							<table id='TablaReservadetallehotelhabitacion' class='table table-sm table-bordered table-striped'>
								<thead>
									<tr>
										<th>Reserva</th>
										<th hidden>Idreserva</th>
										<th hidden>Id</th>
										<th>cathabitacion</th>
										<th>hotel</th>
										<th hidden>Idhotelhabitacion</th>
										<th >Descripcion</th>
										<th >Fechaingreso</th>
										<th >Fechasalida</th>
										<th >Adultos</th>
										<th >Ninios</th>
										<th >Cantidad</th>
										<th >Precio</th>
										<th >Total</th>
										<th >Confirmado</th>
										<th >Estado</th>
										<th>Acciones</th>

									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $reservadetallehotelhabitacion):?>
											<tr>
												<td><?php echo $reservadetallehotelhabitacion['reservanombre'];?></td>
												<td hidden><?php echo $reservadetallehotelhabitacion['idreserva'];?></td>
												<td hidden><?php echo $reservadetallehotelhabitacion['idreservadetallehotelhabitacion'];?></td>
												<td><?php echo $reservadetallehotelhabitacion['cathabitacion'];?></td>
												<td><?php echo $reservadetallehotelhabitacion['hotel'];?></td>
												<td hidden><?php echo $reservadetallehotelhabitacion['idhotelhabitacion'];?></td>
												<td ><?php echo $reservadetallehotelhabitacion['descripcion'];?></td>
												<td ><?php echo $reservadetallehotelhabitacion['fechaingreso'];?></td>
												<td ><?php echo $reservadetallehotelhabitacion['fechasalida'];?></td>
												<td ><?php echo $reservadetallehotelhabitacion['adultos'];?></td>
												<td ><?php echo $reservadetallehotelhabitacion['ninios'];?></td>
												<td ><?php echo $reservadetallehotelhabitacion['cantidad'];?></td>
												<td ><?php echo $reservadetallehotelhabitacion['precio'];?></td>
												<td ><?php echo $reservadetallehotelhabitacion['total'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($reservadetallehotelhabitacion['confirmado']== 1) ? 'CONFIRMADO' : 'PENDIENTE';?></td>
												<td class = 'hidden-xs'><?php echo $est = ($reservadetallehotelhabitacion['estado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>

												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarReservadetallehotelhabitacion('<?php echo $reservadetallehotelhabitacion['idreservadetallehotelhabitacion'].'\',\''. $reservadetallehotelhabitacion['idhotelhabitacion'].'\',\''. $reservadetallehotelhabitacion['idreserva'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-search fa-xs'></span>
															</button>
														</div>
														<div style='margin: auto;'>
															<a class='btn btn-success btn-xs' href='<?php echo base_url();?>reserva/add/<?php echo $reservadetallehotelhabitacion['idreservadetallehotelhabitacion'].'\',\''. $reservadetallehotelhabitacion['idhotelhabitacion'].'\',\''. $reservadetallehotelhabitacion['idreserva'];?>'><i class='fa fa-pencil'></i></a>
														</div>
													</div>
												</td>
											</tr>
										<?php endforeach;?>
									<?php endif;?>
								</tbody>
							</table>
						</div>
						<div id='PaginadoReservadetallehotelhabitacion'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<div class='modal fade' id='modalAgregarReservadetallehotelhabitacion' tabindex='-1'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title' id='modaldeltalletour'>Detalle Reservadetallehotelhabitacion</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<div class='col-6 form-group row'>
					<label class='col-sm-4'>Hotelhabitacion:</label>
					<div class = 'col-sm-8'>
						<select class='form-control form-control-sm select2' id='idhotelhabitacion'>
							<option value='0'>-- SELECCIONAR1 --</option>
							<?php if (!empty($hotelhabitacions)):?>
								<?php foreach($hotelhabitacions as $hotelhabitacion):?>
									<option value= '<?php echo $hotelhabitacion['idhotelhabitacion'];?>'><?php echo $hotelhabitacion['concatenado'];?></option>
								<?php endforeach;?>
							<?php endif;?>
						</select>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4'>Reserva:</label>
					<div class = 'col-sm-8'>
						<select class='form-control form-control-sm select2' id='idreserva'>
							<option value='0'>-- SELECCIONAR1 --</option>
							<?php if (!empty($reservas)):?>
								<?php foreach($reservas as $reserva):?>
									<option value= '<?php echo $reserva['idreserva'];?>'><?php echo $reserva['concatenado'];?></option>
								<?php endforeach;?>
							<?php endif;?>
						</select>
					</div>
				</div>
				<div class='col-6 form-group row'hidden>
					<label class='col-sm-4' for='id'>id:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='idreservadetallehotelhabitacion' name='idreservadetallehotelhabitacion' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-12 form-group row'>
					<label class='col-sm-2' for='id'>descripcion:</label>
					<div class = 'col-sm-10'>
						<textarea type='text' class='form-control form-control-sm text-uppercase    123' id='descripcion' name='descripcion' placeholder='T001' autocomplete = 'off'></textarea>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4'>fechaingreso:</label>
					<div class='col-sm-8'>
						<div class='input-group'>
							<div class='input-group-prepend'>
								<span class='input-group-text'>
									<i class='far fa-calendar-alt'></i>
								</span>
							</div>
							<input type='text' class='form-control form-control-sm' id='fechaingreso' name='fechaingreso' placeholder='dd/mm/yyyy' readonly>
						</div>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4'>fechasalida:</label>
					<div class='col-sm-8'>
						<div class='input-group'>
							<div class='input-group-prepend'>
								<span class='input-group-text'>
									<i class='far fa-calendar-alt'></i>
								</span>
							</div>
							<input type='text' class='form-control form-control-sm' id='fechasalida' name='fechasalida' placeholder='dd/mm/yyyy' readonly>
						</div>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>adultos:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='adultos' name='adultos' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>ninios:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='ninios' name='ninios' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>cantidad:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='cantidad' name='cantidad' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>precio:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='precio' name='precio' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>total:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='total' name='total' placeholder='T001' autocomplete = 'off'>
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
			<button type='button' class='btn btn-success btn-sm' id='btnModalAgregarReservadetallehotelhabitacion'>Agregar</button>
			<button type='button' class='btn btn-warning btn-sm' id='btnModalEditarReservadetallehotelhabitacion'>Modificar</button>
			<button type='button' class='btn btn-danger btn-sm' id='btnModalEliminarReservadetallehotelhabitacion'>Eliminar</button>
			<button type='button' class='btn btn-primary btn-sm' id='btnModalCerrarReservadetallehotelhabitacion' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<div class='modal fade show' id='modal_agregar_thotelhabitacion' aria-modal='true' style='padding-right: 17px;z-index: 2500;'>
	<div class='modal-dialog modal-sm'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title'>Agregar Hotelhabitacion</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
			<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<label class='col-sm-3'>Hotelhabitacion:</label>
				<div class = 'col-sm-9'>
					<input type='text' class='form-control form-control-sm' id='IdNuevaHotelhabitacion'>
				</div>
			</div>
		</div>
		<div class='modal-footer'>
			<button type='button' class='btn btn-success btn-sm' id='IdBtnNuevaHotelhabitacion'>Agregar</button>
			<button type='button' class='btn btn-primary btn-sm' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<div class='modal fade show' id='modal_agregar_treserva' aria-modal='true' style='padding-right: 17px;z-index: 2500;'>
	<div class='modal-dialog modal-sm'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title'>Agregar Reserva</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
			<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<label class='col-sm-3'>Reserva:</label>
				<div class = 'col-sm-9'>
					<input type='text' class='form-control form-control-sm' id='IdNuevaReserva'>
				</div>
			</div>
		</div>
		<div class='modal-footer'>
			<button type='button' class='btn btn-success btn-sm' id='IdBtnNuevaReserva'>Agregar</button>
			<button type='button' class='btn btn-primary btn-sm' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>

<script>
	var NuevoReservadetallehotelhabitacion;
	var base_url= '<?php echo base_url();?>';


	function NumeroFilasTabla(){
		TamanioTabla = $('#tabla_Habitaciones tr').length - 1;
		$('#minmax').val(TamanioTabla)
	}


	function load(pag){
		RecolectarDatosReservadetallehotelhabitacion();
		EnviarInformacionReservadetallehotelhabitacion('leer', NuevoReservadetallehotelhabitacion, false, pag);
	}


	$('#fechaingreso').datepicker({
		language: 'es',
		todayBtn: 'linked',
		clearBtn: true,
		format: 'mm/dd/yyyy',
		multidate: false,
		todayHighlight: true
	});
	$('#fechasalida').datepicker({
		language: 'es',
		todayBtn: 'linked',
		clearBtn: true,
		format: 'mm/dd/yyyy',
		multidate: false,
		todayHighlight: true
	});




	$('#btnAgregarReservadetallehotelhabitacion').click(function(){
		LimpiarModalDatosReservadetallehotelhabitacion();
		$('#categoria').val(1);
		$('#id').prop('readonly', false);  
		$('#IdModalGrupoCodigoHotel').prop('hidden', false);
		$('#btnModalAgregarReservadetallehotelhabitacion').toggle(true);
		$('#btnModalEditarReservadetallehotelhabitacion').toggle(false);
		$('#btnModalEliminarReservadetallehotelhabitacion').toggle(false);
		$('#modalAgregarReservadetallehotelhabitacion').modal();
	});


	function btnEditarReservadetallehotelhabitacion(Val0, Val1, Val2){
		$.ajax({
			type: 'POST',
			url: base_url + '/reservadetallehotelhabitacion/edit',
			data: { idreservadetallehotelhabitacion: Val0, idhotelhabitacion: Val1, idreserva: Val2},
			success: function(msg){
		debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosReservadetallehotelhabitacion();
				$('#idreserva').select2().val(temp.idreserva).select2('destroy').select2();
				$('#idreservadetallehotelhabitacion').val(temp.idreservadetallehotelhabitacion);
				$('#idhotelhabitacion').select2().val(temp.idhotelhabitacion).select2('destroy').select2();
				$('#descripcion').val(temp.descripcion);
				$('#fechaingreso').val(temp.fechaingreso);
				$('#fechasalida').val(temp.fechasalida);
				$('#adultos').val(temp.adultos);
				$('#ninios').val(temp.ninios);
				$('#cantidad').val(temp.cantidad);
				$('#precio').val(temp.precio);
				$('#total').val(temp.total);
				$('#confirmado').val(temp.confirmado);
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


				$('#btnModalAgregarReservadetallehotelhabitacion').toggle(false);
				$('#btnModalEditarReservadetallehotelhabitacion').toggle(true);
				$('#btnModalEliminarReservadetallehotelhabitacion').toggle(true);
				$('#modalAgregarReservadetallehotelhabitacion').modal('toggle');
			},
			error: function(){
				alert('Hay un error...');
			}
		});
	}


	$('#btnModalAgregarReservadetallehotelhabitacion').click(function(){
debugger

		if (ValidarCamposVaciosReservadetallehotelhabitacion() != 0) {
			alert('Completar campos obligatorios');
		}else{
			$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
			RecolectarDatosReservadetallehotelhabitacion();
			EnviarInformacionReservadetallehotelhabitacion('agregar', NuevoReservadetallehotelhabitacion, true);
		}
	});


	$('#btnModalEditarReservadetallehotelhabitacion').click(function(){
		if (ValidarCamposVaciosReservadetallehotelhabitacion() != 0) {
			alert('Completar campos obligatorios');
		}else{
			RecolectarDatosReservadetallehotelhabitacion();
			EnviarInformacionReservadetallehotelhabitacion('modificar', NuevoReservadetallehotelhabitacion, true);
		}
	});


	$('#btnModalEliminarReservadetallehotelhabitacion').click(function(){
		var bool=confirm('ESTA SEGURO DE ELIMINAR EL DATO?');
		if(bool){
			RecolectarDatosReservadetallehotelhabitacion();
			EnviarInformacionReservadetallehotelhabitacion('eliminar', NuevoReservadetallehotelhabitacion, true);
		}
	});


	$('#btnModalCerrarHotel').click(function(){
		$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
		LimpiarModalDatosReservadetallehotelhabitacion();
	});


	$('#btnFiltroReservadetallehotelhabitacion').click(function(){
		RecolectarDatosReservadetallehotelhabitacion();
		EnviarInformacionReservadetallehotelhabitacion('leer', NuevoReservadetallehotelhabitacion, false);
	});


	function Paginado(pag) {
		RecolectarDatosReservadetallehotelhabitacion();
		EnviarInformacionReservadetallehotelhabitacion('leer', NuevoReservadetallehotelhabitacion, false, pag);
	}


	function RecolectarDatosReservadetallehotelhabitacion(){
		NuevoReservadetallehotelhabitacion = {
			idreserva: $('#idreserva').val().toUpperCase(),
			idreservadetallehotelhabitacion: $('#idreservadetallehotelhabitacion').val().toUpperCase(),
			idhotelhabitacion: $('#idhotelhabitacion').val().toUpperCase(),
			descripcion: $('#descripcion').val().toUpperCase(),
			fechaingreso: $('#fechaingreso').val().toUpperCase(),
			fechasalida: $('#fechasalida').val().toUpperCase(),
			adultos: $('#adultos').val().toUpperCase(),
			ninios: $('#ninios').val().toUpperCase(),
			cantidad: $('#cantidad').val().toUpperCase(),
			precio: $('#precio').val().toUpperCase(),
			total: $('#total').val().toUpperCase(),
			confirmado: $('#confirmado').val().toUpperCase(),
			estado: $('#estado').val().toUpperCase(),

			todos: $('#idFTodos').val(),
			texto: $('#idFTexto').val()
		};
	}


	function EnviarInformacionReservadetallehotelhabitacion(accion, objEvento, modal, pag=1) { 
		$.ajax({
			type: 'POST',
			url: base_url+'/reservadetallehotelhabitacion/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				var resp = JSON.parse(msg);
				$('#PaginadoReservadetallehotelhabitacion').empty();
				$('#PaginadoReservadetallehotelhabitacion').append(resp.pag);
				if (modal) {
					$('#modalAgregarReservadetallehotelhabitacion').modal('toggle');
					LimpiarModalDatosReservadetallehotelhabitacion();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								CargartablaReservadetallehotelhabitacion(resp.datos)
							}
						})
					} else {
						Swal.fire({
							title: resp.mensaje,
							icon: 'error'
						})
					}
				}else{
					CargartablaReservadetallehotelhabitacion(resp.datos)
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


	function LimpiarModalDatosReservadetallehotelhabitacion(){
		$('#idreserva').select2().val(0).select2('destroy').select2();
		$('#idreservadetallehotelhabitacion').val('0');
		$('#idhotelhabitacion').select2().val(0).select2('destroy').select2();
		$('#descripcion').val('');
		$('#fechaingreso').val('');
		$('#fechasalida').val('');
		$('#adultos').val('');
		$('#ninios').val('');
		$('#cantidad').val('');
		$('#precio').val('');
		$('#total').val('');

	}


	function ValidarCamposVaciosReservadetallehotelhabitacion(){
		var error = 0;
		if ($('#idreserva').val() == ''){
			Resaltado('idreserva');
			error++;
		}
		if ($('#idreservadetallehotelhabitacion').val() == ''){
			Resaltado('idreservadetallehotelhabitacion');
			error++;
		}
		if ($('#idhotelhabitacion').val() == ''){
			Resaltado('idhotelhabitacion');
			error++;
		}
		if ($('#descripcion').val() == ''){
			Resaltado('descripcion');
			error++;
		}
		if ($('#fechaingreso').val() == ''){
			Resaltado('fechaingreso');
			error++;
		}
		if ($('#fechasalida').val() == ''){
			Resaltado('fechasalida');
			error++;
		}
		if ($('#adultos').val() == ''){
			Resaltado('adultos');
			error++;
		}
		if ($('#ninios').val() == ''){
			Resaltado('ninios');
			error++;
		}
		if ($('#cantidad').val() == ''){
			Resaltado('cantidad');
			error++;
		}
		if ($('#precio').val() == ''){
			Resaltado('precio');
			error++;
		}
		if ($('#total').val() == ''){
			Resaltado('total');
			error++;
		}
		if ($('#confirmado').val() == ''){
			Resaltado('confirmado');
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


	function CargartablaReservadetallehotelhabitacion(objeto){   
		$('#TablaReservadetallehotelhabitacion tr').not($('#TablaReservadetallehotelhabitacion tr:first')).remove();
		$.each(objeto, function(i, value) {
		var fila = '<tr>'+
			'<td>'+value.reservanombre+'</td>'+
			'<td hidden>'+value.idreserva+'</td>'+
			'<td hidden>'+value.idreservadetallehotelhabitacion+'</td>'+
			'<td>'+value.cathabitacion+'</td>'+
			'<td>'+value.hotel+'</td>'+
			'<td hidden>'+value.idhotelhabitacion+'</td>'+
			'<td >'+value.descripcion+'</td>'+
			'<td >'+value.fechaingreso+'</td>'+
			'<td >'+value.fechasalida+'</td>'+
			'<td >'+value.adultos+'</td>'+
			'<td >'+value.ninios+'</td>'+
			'<td >'+value.cantidad+'</td>'+
			'<td >'+value.precio+'</td>'+
			'<td >'+value.total+'</td>'+
			'<td class = "hidden -xs">' + ((value.confirmado == '1') ? 'CONFIRMADO' : 'PENDIENTE') + '</td>'+
			'<td class = "hidden -xs">' + ((value.estado == '1') ? 'ACTIVO' : 'DESACTIVO') + '</td>'+

			'<td>'+
				'<div class="row">'+
					'<div style="margin: auto;">'+
						'<button type="button" onclick="btnEditarReservadetallehotelhabitacion(\''+value.idreservadetallehotelhabitacion+'\', \''+value.idhotelhabitacion+'\', \''+value.idreserva+'\')" class="btn btn-info btn-xs">'+
							'<span class="fa fa-search fa-sm"></span>'+
						'</button>'+
					'</div>'+
						'<div style="margin: auto;">'+
							'<a class="btn btn-success btn-xs" href="<?php echo base_url();?>/reserva/add"><i class="fa fa-pencil"></i></a>'+
					'</div>'+
				'</div>'+
			'</td>'+
		'</tr>';
		$('#TablaReservadetallehotelhabitacion tbody').append(fila);
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
