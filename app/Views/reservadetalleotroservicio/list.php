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
								<button type='button' class='btn btn-info btn-sm' id='btnAgregarReservadetalleotroservicio'>
									<span class='fa fa-plus'></span> Agregar Reservadetalleotroservicio
								</button>
								<a href='<?php echo base_url();?>reservadetalleotroservicio/excel' class='btn btn-success btn-sm'>
									<span class='fa fa-file-excel'></span> Exportar
								</a>
								<a href='<?php echo base_url();?>reservadetalleotroservicio/pdf' target='_blank' class='btn btn-danger btn-sm'>
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
												<button type='button' class='btn btn-info btn-sm' id='btnFiltroReservadetalleotroservicio'>
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
							<table id='TablaReservadetalleotroservicio' class='table table-sm table-bordered table-striped'>
								<thead>
									<tr>
										<th>Reserva</th>
										<th hidden>Idreserva</th>
										<th hidden>Id</th>
										<th>Otroservicio</th>
										<th hidden>Idotroservicio</th>
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
										<?php foreach($datos as $reservadetalleotroservicio):?>
											<tr>
												<td><?php echo $reservadetalleotroservicio['reservanombre'];?></td>
												<td hidden><?php echo $reservadetalleotroservicio['idreserva'];?></td>
												<td hidden><?php echo $reservadetalleotroservicio['idreservadetalleotroservicio'];?></td>
												<td><?php echo $reservadetalleotroservicio['otroservicionombre'];?></td>
												<td hidden><?php echo $reservadetalleotroservicio['idotroservicio'];?></td>
												<td ><?php echo $reservadetalleotroservicio['descripcion'];?></td>
												<td ><?php echo $reservadetalleotroservicio['fecha'];?></td>
												<td ><?php echo $reservadetalleotroservicio['cantidad'];?></td>
												<td ><?php echo $reservadetalleotroservicio['precio'];?></td>
												<td ><?php echo $reservadetalleotroservicio['total'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($reservadetalleotroservicio['confirmado']== 1) ? 'CONFIRMADO' : 'PENDIENTE';?></td>
												<td class = 'hidden-xs'><?php echo $est = ($reservadetalleotroservicio['estado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>

												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarReservadetalleotroservicio('<?php echo $reservadetalleotroservicio['idreservadetalleotroservicio'].'\',\''. $reservadetalleotroservicio['idotroservicio'].'\',\''. $reservadetalleotroservicio['idreserva'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-search fa-xs'></span>
															</button>
														</div>
														<div style='margin: auto;'>
															<a class='btn btn-success btn-xs' href='<?php echo base_url();?>reserva/add/<?php echo $reservadetalleotroservicio['idreservadetalleotroservicio'].'\',\''. $reservadetalleotroservicio['idotroservicio'].'\',\''. $reservadetalleotroservicio['idreserva'];?>'><i class='fa fa-pencil'></i></a>
														</div>
													</div>
												</td>
											</tr>
										<?php endforeach;?>
									<?php endif;?>
								</tbody>
							</table>
						</div>
						<div id='PaginadoReservadetalleotroservicio'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<div class='modal fade' id='modalAgregarReservadetalleotroservicio' tabindex='-1'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title' id='modaldeltalletour'>Detalle Reservadetalleotroservicio</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<div class='col-6 form-group row'>
					<label class='col-sm-4'>Otroservicio:</label>
					<div class = 'col-sm-8'>
						<select class='form-control form-control-sm select2' id='idotroservicio'>
							<option value='0'>-- SELECCIONAR1 --</option>
							<?php if (!empty($otroservicios)):?>
								<?php foreach($otroservicios as $otroservicio):?>
									<option value= '<?php echo $otroservicio['idotroservicio'];?>'><?php echo $otroservicio['concatenado'];?></option>
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
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='idreservadetalleotroservicio' name='idreservadetalleotroservicio' placeholder='T001' autocomplete = 'off'>
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
			<button type='button' class='btn btn-success btn-sm' id='btnModalAgregarReservadetalleotroservicio'>Agregar</button>
			<button type='button' class='btn btn-warning btn-sm' id='btnModalEditarReservadetalleotroservicio'>Modificar</button>
			<button type='button' class='btn btn-danger btn-sm' id='btnModalEliminarReservadetalleotroservicio'>Eliminar</button>
			<button type='button' class='btn btn-primary btn-sm' id='btnModalCerrarReservadetalleotroservicio' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<div class='modal fade show' id='modal_agregar_totroservicio' aria-modal='true' style='padding-right: 17px;z-index: 2500;'>
	<div class='modal-dialog modal-sm'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title'>Agregar Otroservicio</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
			<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<label class='col-sm-3'>Otroservicio:</label>
				<div class = 'col-sm-9'>
					<input type='text' class='form-control form-control-sm' id='IdNuevaOtroservicio'>
				</div>
			</div>
		</div>
		<div class='modal-footer'>
			<button type='button' class='btn btn-success btn-sm' id='IdBtnNuevaOtroservicio'>Agregar</button>
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
	var NuevoReservadetalleotroservicio;
	var base_url= '<?php echo base_url();?>';


	function NumeroFilasTabla(){
		TamanioTabla = $('#tabla_Habitaciones tr').length - 1;
		$('#minmax').val(TamanioTabla)
	}


	function load(pag){
		RecolectarDatosReservadetalleotroservicio();
		EnviarInformacionReservadetalleotroservicio('leer', NuevoReservadetalleotroservicio, false, pag);
	}


	$('#fecha').datepicker({
		language: 'es',
		todayBtn: 'linked',
		clearBtn: true,
		format: 'mm/dd/yyyy',
		multidate: false,
		todayHighlight: true
	});




	$('#btnAgregarReservadetalleotroservicio').click(function(){
		LimpiarModalDatosReservadetalleotroservicio();
		$('#categoria').val(1);
		$('#id').prop('readonly', false);  
		$('#IdModalGrupoCodigoHotel').prop('hidden', false);
		$('#btnModalAgregarReservadetalleotroservicio').toggle(true);
		$('#btnModalEditarReservadetalleotroservicio').toggle(false);
		$('#btnModalEliminarReservadetalleotroservicio').toggle(false);
		$('#modalAgregarReservadetalleotroservicio').modal();
	});


	function btnEditarReservadetalleotroservicio(Val0, Val1, Val2){
		$.ajax({
			type: 'POST',
			url: base_url + '/reservadetalleotroservicio/edit',
			data: { idreservadetalleotroservicio: Val0, idotroservicio: Val1, idreserva: Val2},
			success: function(msg){
		debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosReservadetalleotroservicio();
				$('#idreserva').select2().val(temp.idreserva).select2('destroy').select2();
				$('#idreservadetalleotroservicio').val(temp.idreservadetalleotroservicio);
				$('#idotroservicio').select2().val(temp.idotroservicio).select2('destroy').select2();
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


				$('#btnModalAgregarReservadetalleotroservicio').toggle(false);
				$('#btnModalEditarReservadetalleotroservicio').toggle(true);
				$('#btnModalEliminarReservadetalleotroservicio').toggle(true);
				$('#modalAgregarReservadetalleotroservicio').modal('toggle');
			},
			error: function(){
				alert('Hay un error...');
			}
		});
	}


	$('#btnModalAgregarReservadetalleotroservicio').click(function(){
debugger

		if (ValidarCamposVaciosReservadetalleotroservicio() != 0) {
			alert('Completar campos obligatorios');
		}else{
			$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
			RecolectarDatosReservadetalleotroservicio();
			EnviarInformacionReservadetalleotroservicio('agregar', NuevoReservadetalleotroservicio, true);
		}
	});


	$('#btnModalEditarReservadetalleotroservicio').click(function(){
		if (ValidarCamposVaciosReservadetalleotroservicio() != 0) {
			alert('Completar campos obligatorios');
		}else{
			RecolectarDatosReservadetalleotroservicio();
			EnviarInformacionReservadetalleotroservicio('modificar', NuevoReservadetalleotroservicio, true);
		}
	});


	$('#btnModalEliminarReservadetalleotroservicio').click(function(){
		var bool=confirm('ESTA SEGURO DE ELIMINAR EL DATO?');
		if(bool){
			RecolectarDatosReservadetalleotroservicio();
			EnviarInformacionReservadetalleotroservicio('eliminar', NuevoReservadetalleotroservicio, true);
		}
	});


	$('#btnModalCerrarHotel').click(function(){
		$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
		LimpiarModalDatosReservadetalleotroservicio();
	});


	$('#btnFiltroReservadetalleotroservicio').click(function(){
		RecolectarDatosReservadetalleotroservicio();
		EnviarInformacionReservadetalleotroservicio('leer', NuevoReservadetalleotroservicio, false);
	});


	function Paginado(pag) {
		RecolectarDatosReservadetalleotroservicio();
		EnviarInformacionReservadetalleotroservicio('leer', NuevoReservadetalleotroservicio, false, pag);
	}


	function RecolectarDatosReservadetalleotroservicio(){
		NuevoReservadetalleotroservicio = {
			idreserva: $('#idreserva').val().toUpperCase(),
			idreservadetalleotroservicio: $('#idreservadetalleotroservicio').val().toUpperCase(),
			idotroservicio: $('#idotroservicio').val().toUpperCase(),
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


	function EnviarInformacionReservadetalleotroservicio(accion, objEvento, modal, pag=1) { 
		$.ajax({
			type: 'POST',
			url: base_url+'/reservadetalleotroservicio/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				var resp = JSON.parse(msg);
				$('#PaginadoReservadetalleotroservicio').empty();
				$('#PaginadoReservadetalleotroservicio').append(resp.pag);
				if (modal) {
					$('#modalAgregarReservadetalleotroservicio').modal('toggle');
					LimpiarModalDatosReservadetalleotroservicio();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								CargartablaReservadetalleotroservicio(resp.datos)
							}
						})
					} else {
						Swal.fire({
							title: resp.mensaje,
							icon: 'error'
						})
					}
				}else{
					CargartablaReservadetalleotroservicio(resp.datos)
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


	function LimpiarModalDatosReservadetalleotroservicio(){
		$('#idreserva').select2().val(0).select2('destroy').select2();
		$('#idreservadetalleotroservicio').val('0');
		$('#idotroservicio').select2().val(0).select2('destroy').select2();
		$('#descripcion').val('');
		$('#fecha').val('');
		$('#cantidad').val('');
		$('#precio').val('');
		$('#total').val('');

	}


	function ValidarCamposVaciosReservadetalleotroservicio(){
		var error = 0;
		if ($('#idreserva').val() == ''){
			Resaltado('idreserva');
			error++;
		}
		if ($('#idreservadetalleotroservicio').val() == ''){
			Resaltado('idreservadetalleotroservicio');
			error++;
		}
		if ($('#idotroservicio').val() == ''){
			Resaltado('idotroservicio');
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


	function CargartablaReservadetalleotroservicio(objeto){   
		$('#TablaReservadetalleotroservicio tr').not($('#TablaReservadetalleotroservicio tr:first')).remove();
		$.each(objeto, function(i, value) {
		var fila = '<tr>'+
			'<td>'+value.reservanombre+'</td>'+
			'<td hidden>'+value.idreserva+'</td>'+
			'<td hidden>'+value.idreservadetalleotroservicio+'</td>'+
			'<td>'+value.otroservicionombre+'</td>'+
			'<td hidden>'+value.idotroservicio+'</td>'+
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
						'<button type="button" onclick="btnEditarReservadetalleotroservicio(\''+value.idreservadetalleotroservicio+'\', \''+value.idotroservicio+'\', \''+value.idreserva+'\')" class="btn btn-info btn-xs">'+
							'<span class="fa fa-search fa-sm"></span>'+
						'</button>'+
					'</div>'+
						'<div style="margin: auto;">'+
							'<a class="btn btn-success btn-xs" href="<?php echo base_url();?>/reserva/add"><i class="fa fa-pencil"></i></a>'+
					'</div>'+
				'</div>'+
			'</td>'+
		'</tr>';
		$('#TablaReservadetalleotroservicio tbody').append(fila);
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
