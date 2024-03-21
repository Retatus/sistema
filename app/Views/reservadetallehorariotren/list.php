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
								<button type='button' class='btn btn-info btn-sm' id='btnAgregarReservadetallehorariotren'>
									<span class='fa fa-plus'></span> Agregar Reservadetallehorariotren
								</button>
								<a href='<?php echo base_url();?>/reservadetallehorariotren/excel' class='btn btn-success btn-sm'>
									<span class='fa fa-file-excel'></span> Exportar
								</a>
								<a href='<?php echo base_url();?>/reservadetallehorariotren/pdf' target='_blank' class='btn btn-danger btn-sm'>
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
												<button type='button' class='btn btn-info btn-sm' id='btnFiltroReservadetallehorariotren'>
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
							<table id='TablaReservadetallehorariotren' class='table table-sm table-bordered table-striped'>
								<thead>
									<tr>
										<th>Reserva</th>
										<th >Idreserva</th>
										<th hidden>Id</th>
										<th>horatren</th>
										<th>tren</th>
										<th >Idhorariotren</th>
										<th >Descripcion</th>
										<th >Fecha</th>
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
										<?php foreach($datos as $reservadetallehorariotren):?>
											<tr>
												<td><?php echo $reservadetallehorariotren['reservanombre'];?></td>
												<td ><?php echo $reservadetallehorariotren['idreserva'];?></td>
												<td hidden><?php echo $reservadetallehorariotren['idreservadetallehorariotren'];?></td>
												<td><?php echo $reservadetallehorariotren['horatren'];?></td>
												<td><?php echo $reservadetallehorariotren['tren'];?></td>
												<td ><?php echo $reservadetallehorariotren['idhorariotren'];?></td>
												<td ><?php echo $reservadetallehorariotren['descripcion'];?></td>
												<td ><?php echo $reservadetallehorariotren['fecha'];?></td>
												<td ><?php echo $reservadetallehorariotren['cantidad'];?></td>
												<td ><?php echo $reservadetallehorariotren['precio'];?></td>
												<td ><?php echo $reservadetallehorariotren['total'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($reservadetallehorariotren['confirmado']== 1) ? 'CONFIRMADO' : 'PENDIENTE';?></td>
												<td class = 'hidden-xs'><?php echo $est = ($reservadetallehorariotren['estado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>

												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarReservadetallehorariotren('<?php echo $reservadetallehorariotren['idreservadetallehorariotren'].'\',\''. $reservadetallehorariotren['idhorariotren'].'\',\''. $reservadetallehorariotren['idreserva'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-search fa-xs'></span>
															</button>
														</div>
														<div style='margin: auto;'>
															<a class='btn btn-success btn-xs' href='<?php echo base_url();?>/reserva/add/<?php echo $reservadetallehorariotren['idreservadetallehorariotren'].'\',\''. $reservadetallehorariotren['idhorariotren'].'\',\''. $reservadetallehorariotren['idreserva'];?>'><i class='fa fa-pencil'></i></a>
														</div>
													</div>
												</td>
											</tr>
										<?php endforeach;?>
									<?php endif;?>
								</tbody>
							</table>
						</div>
						<div id='PaginadoReservadetallehorariotren'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<div class='modal fade' id='modalAgregarReservadetallehorariotren' tabindex='-1'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title' id='modaldeltalletour'>Detalle Reservadetallehorariotren</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<div class='col-6 form-group row'>
					<label class='col-sm-4'>Horariotren:</label>
					<div class = 'col-sm-8'>
						<select class='form-control form-control-sm select2' id='idhorariotren'>
							<option value='0'>-- SELECCIONAR1 --</option>
							<?php if (!empty($horariotrens)):?>
								<?php foreach($horariotrens as $horariotren):?>
									<option value= '<?php echo $horariotren['idhorariotren'];?>'><?php echo $horariotren['concatenado'];?></option>
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
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='idreservadetallehorariotren' name='idreservadetallehorariotren' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-12 form-group row'>
					<label class='col-sm-2' for='id'>descripcion:</label>
					<div class = 'col-sm-10'>
						<textarea type='text' class='form-control form-control-sm text-uppercase    123' id='descripcion' name='descripcion' placeholder='T001' autocomplete = 'off'></textarea>
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
			<button type='button' class='btn btn-success btn-sm' id='btnModalAgregarReservadetallehorariotren'>Agregar</button>
			<button type='button' class='btn btn-warning btn-sm' id='btnModalEditarReservadetallehorariotren'>Modificar</button>
			<button type='button' class='btn btn-danger btn-sm' id='btnModalEliminarReservadetallehorariotren'>Eliminar</button>
			<button type='button' class='btn btn-primary btn-sm' id='btnModalCerrarReservadetallehorariotren' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<div class='modal fade show' id='modal_agregar_thorariotren' aria-modal='true' style='padding-right: 17px;z-index: 2500;'>
	<div class='modal-dialog modal-sm'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title'>Agregar Horariotren</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
			<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<label class='col-sm-3'>Horariotren:</label>
				<div class = 'col-sm-9'>
					<input type='text' class='form-control form-control-sm' id='IdNuevaHorariotren'>
				</div>
			</div>
		</div>
		<div class='modal-footer'>
			<button type='button' class='btn btn-success btn-sm' id='IdBtnNuevaHorariotren'>Agregar</button>
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
	var NuevoReservadetallehorariotren;
	var base_url= '<?php echo base_url();?>';


	function NumeroFilasTabla(){
		TamanioTabla = $('#tabla_Habitaciones tr').length - 1;
		$('#minmax').val(TamanioTabla)
	}


	function load(pag){
		RecolectarDatosReservadetallehorariotren();
		EnviarInformacionReservadetallehorariotren('leer', NuevoReservadetallehorariotren, false, pag);
	}


	$('#fecha').datepicker({
		language: 'es',
		todayBtn: 'linked',
		clearBtn: true,
		format: 'mm/dd/yyyy',
		multidate: false,
		todayHighlight: true
	});




	$('#btnAgregarReservadetallehorariotren').click(function(){
		LimpiarModalDatosReservadetallehorariotren();
		$('#categoria').val(1);
		$('#id').prop('readonly', false);  
		$('#IdModalGrupoCodigoHotel').prop('hidden', false);
		$('#btnModalAgregarReservadetallehorariotren').toggle(true);
		$('#btnModalEditarReservadetallehorariotren').toggle(false);
		$('#btnModalEliminarReservadetallehorariotren').toggle(false);
		$('#modalAgregarReservadetallehorariotren').modal();
	});


	function btnEditarReservadetallehorariotren(Val0, Val1, Val2){
		$.ajax({
			type: 'POST',
			url: base_url + '/reservadetallehorariotren/edit',
			data: { idreservadetallehorariotren: Val0, idhorariotren: Val1, idreserva: Val2},
			success: function(msg){
		debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosReservadetallehorariotren();
				$('#idreserva').select2().val(temp.idreserva).select2('destroy').select2();
				$('#idreservadetallehorariotren').val(temp.idreservadetallehorariotren);
				$('#idhorariotren').select2().val(temp.idhorariotren).select2('destroy').select2();
				$('#descripcion').val(temp.descripcion);
				$('#fecha').val(temp.fecha);
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


				$('#btnModalAgregarReservadetallehorariotren').toggle(false);
				$('#btnModalEditarReservadetallehorariotren').toggle(true);
				$('#btnModalEliminarReservadetallehorariotren').toggle(true);
				$('#modalAgregarReservadetallehorariotren').modal('toggle');
			},
			error: function(){
				alert('Hay un error...');
			}
		});
	}


	$('#btnModalAgregarReservadetallehorariotren').click(function(){
debugger

		if (ValidarCamposVaciosReservadetallehorariotren() != 0) {
			alert('Completar campos obligatorios');
		}else{
			$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
			RecolectarDatosReservadetallehorariotren();
			EnviarInformacionReservadetallehorariotren('agregar', NuevoReservadetallehorariotren, true);
		}
	});


	$('#btnModalEditarReservadetallehorariotren').click(function(){
		if (ValidarCamposVaciosReservadetallehorariotren() != 0) {
			alert('Completar campos obligatorios');
		}else{
			RecolectarDatosReservadetallehorariotren();
			EnviarInformacionReservadetallehorariotren('modificar', NuevoReservadetallehorariotren, true);
		}
	});


	$('#btnModalEliminarReservadetallehorariotren').click(function(){
		var bool=confirm('ESTA SEGURO DE ELIMINAR EL DATO?');
		if(bool){
			RecolectarDatosReservadetallehorariotren();
			EnviarInformacionReservadetallehorariotren('eliminar', NuevoReservadetallehorariotren, true);
		}
	});


	$('#btnModalCerrarHotel').click(function(){
		$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
		LimpiarModalDatosReservadetallehorariotren();
	});


	$('#btnFiltroReservadetallehorariotren').click(function(){
		RecolectarDatosReservadetallehorariotren();
		EnviarInformacionReservadetallehorariotren('leer', NuevoReservadetallehorariotren, false);
	});


	function Paginado(pag) {
		RecolectarDatosReservadetallehorariotren();
		EnviarInformacionReservadetallehorariotren('leer', NuevoReservadetallehorariotren, false, pag);
	}


	function RecolectarDatosReservadetallehorariotren(){
		NuevoReservadetallehorariotren = {
			idreserva: $('#idreserva').val().toUpperCase(),
			idreservadetallehorariotren: $('#idreservadetallehorariotren').val().toUpperCase(),
			idhorariotren: $('#idhorariotren').val().toUpperCase(),
			descripcion: $('#descripcion').val().toUpperCase(),
			fecha: $('#fecha').val().toUpperCase(),
			cantidad: $('#cantidad').val().toUpperCase(),
			precio: $('#precio').val().toUpperCase(),
			total: $('#total').val().toUpperCase(),
			confirmado: $('#confirmado').val().toUpperCase(),
			estado: $('#estado').val().toUpperCase(),

			todos: $('#idFTodos').val(),
			texto: $('#idFTexto').val()
		};
	}


	function EnviarInformacionReservadetallehorariotren(accion, objEvento, modal, pag=1) { 
		$.ajax({
			type: 'POST',
			url: base_url+'/reservadetallehorariotren/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				var resp = JSON.parse(msg);
				$('#PaginadoReservadetallehorariotren').empty();
				$('#PaginadoReservadetallehorariotren').append(resp.pag);
				if (modal) {
					$('#modalAgregarReservadetallehorariotren').modal('toggle');
					LimpiarModalDatosReservadetallehorariotren();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								CargartablaReservadetallehorariotren(resp.datos)
							}
						})
					} else {
						Swal.fire({
							title: resp.mensaje,
							icon: 'error'
						})
					}
				}else{
					CargartablaReservadetallehorariotren(resp.datos)
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


	function LimpiarModalDatosReservadetallehorariotren(){
		$('#idreserva').select2().val(0).select2('destroy').select2();
		$('#idreservadetallehorariotren').val('0');
		$('#idhorariotren').select2().val(0).select2('destroy').select2();
		$('#descripcion').val('');
		$('#fecha').val('');
		$('#cantidad').val('');
		$('#precio').val('');
		$('#total').val('');

	}


	function ValidarCamposVaciosReservadetallehorariotren(){
		var error = 0;
		if ($('#idreserva').val() == ''){
			Resaltado('idreserva');
			error++;
		}
		if ($('#idreservadetallehorariotren').val() == ''){
			Resaltado('idreservadetallehorariotren');
			error++;
		}
		if ($('#idhorariotren').val() == ''){
			Resaltado('idhorariotren');
			error++;
		}
		if ($('#descripcion').val() == ''){
			Resaltado('descripcion');
			error++;
		}
		if ($('#fecha').val() == ''){
			Resaltado('fecha');
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


	function CargartablaReservadetallehorariotren(objeto){   
		$('#TablaReservadetallehorariotren tr').not($('#TablaReservadetallehorariotren tr:first')).remove();
		$.each(objeto, function(i, value) {
		var fila = '<tr>'+
			'<td>'+value.reservanombre+'</td>'+
			'<td >'+value.idreserva+'</td>'+
			'<td hidden>'+value.idreservadetallehorariotren+'</td>'+
			'<td>'+value.horatren+'</td>'+
			'<td>'+value.tren+'</td>'+
			'<td >'+value.idhorariotren+'</td>'+
			'<td >'+value.descripcion+'</td>'+
			'<td >'+value.fecha+'</td>'+
			'<td >'+value.cantidad+'</td>'+
			'<td >'+value.precio+'</td>'+
			'<td >'+value.total+'</td>'+
			'<td class = "hidden -xs">' + ((value.confirmado == '1') ? 'CONFIRMADO' : 'PENDIENTE') + '</td>'+
			'<td class = "hidden -xs">' + ((value.estado == '1') ? 'ACTIVO' : 'DESACTIVO') + '</td>'+

			'<td>'+
				'<div class="row">'+
					'<div style="margin: auto;">'+
						'<button type="button" onclick="btnEditarReservadetallehorariotren(\''+value.idreservadetallehorariotren+'\', \''+value.idhorariotren+'\', \''+value.idreserva+'\')" class="btn btn-info btn-xs">'+
							'<span class="fa fa-search fa-sm"></span>'+
						'</button>'+
					'</div>'+
						'<div style="margin: auto;">'+
							'<a class="btn btn-success btn-xs" href="<?php echo base_url();?>/reserva/add"><i class="fa fa-pencil"></i></a>'+
					'</div>'+
				'</div>'+
			'</td>'+
		'</tr>';
		$('#TablaReservadetallehorariotren tbody').append(fila);
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
