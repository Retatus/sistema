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
								<button type='button' class='btn btn-info btn-sm' id='btnAgregarReservadetalleservicio'>
									<span class='fa fa-plus'></span> Agregar Reservadetalleservicio
								</button>
								<a href='<?php echo base_url();?>reservadetalleservicio/excel' class='btn btn-success btn-sm'>
									<span class='fa fa-file-excel'></span> Exportar
								</a>
								<a href='<?php echo base_url();?>reservadetalleservicio/pdf' target='_blank' class='btn btn-danger btn-sm'>
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
												<button type='button' class='btn btn-info btn-sm' id='btnFiltroReservadetalleservicio'>
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
							<table id='TablaReservadetalleservicio' class='table table-sm table-bordered table-striped'>
								<thead>
									<tr>
										<th >Idreserva</th>
										<th >Id</th>
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
										<?php foreach($datos as $reservadetalleservicio):?>
											<tr>
												<td ><?php echo $reservadetalleservicio['idreserva'];?></td>
												<td ><?php echo $reservadetalleservicio['idreservadetalleservicio'];?></td>
												<td ><?php echo $reservadetalleservicio['descripcion'];?></td>
												<td ><?php echo $reservadetalleservicio['fecha'];?></td>
												<td ><?php echo $reservadetalleservicio['cantidad'];?></td>
												<td ><?php echo $reservadetalleservicio['precio'];?></td>
												<td ><?php echo $reservadetalleservicio['total'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($reservadetalleservicio['confirmado']== 1) ? 'CONFIRMADO' : 'PENDIENTE';?></td>
												<td class = 'hidden-xs'><?php echo $est = ($reservadetalleservicio['estado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>

												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarReservadetalleservicio('<?php echo $reservadetalleservicio['idreservadetalleservicio'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-search fa-xs'></span>
															</button>
														</div>
														<div style='margin: auto;'>
															<a class='btn btn-success btn-xs' href='<?php echo base_url();?>reserva/add/<?php echo $reservadetalleservicio['idreservadetalleservicio'];?>'><i class='fa fa-pencil'></i></a>
														</div>
													</div>
												</td>
											</tr>
										<?php endforeach;?>
									<?php endif;?>
								</tbody>
							</table>
						</div>
						<div id='PaginadoReservadetalleservicio'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<div class='modal fade' id='modalAgregarReservadetalleservicio' tabindex='-1'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title' id='modaldeltalletour'>Detalle Reservadetalleservicio</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>idreserva:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='idreserva' name='idreserva' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>id:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='idreservadetalleservicio' name='idreservadetalleservicio' placeholder='T001' autocomplete = 'off'>
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
			<button type='button' class='btn btn-success btn-sm' id='btnModalAgregarReservadetalleservicio'>Agregar</button>
			<button type='button' class='btn btn-warning btn-sm' id='btnModalEditarReservadetalleservicio'>Modificar</button>
			<button type='button' class='btn btn-danger btn-sm' id='btnModalEliminarReservadetalleservicio'>Eliminar</button>
			<button type='button' class='btn btn-primary btn-sm' id='btnModalCerrarReservadetalleservicio' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>

<script>
	var NuevoReservadetalleservicio;
	var base_url= '<?php echo base_url();?>';


	function NumeroFilasTabla(){
		TamanioTabla = $('#tabla_Habitaciones tr').length - 1;
		$('#minmax').val(TamanioTabla)
	}


	function load(pag){
		RecolectarDatosReservadetalleservicio();
		EnviarInformacionReservadetalleservicio('leer', NuevoReservadetalleservicio, false, pag);
	}


	$('#fecha').datepicker({
		language: 'es',
		todayBtn: 'linked',
		clearBtn: true,
		format: 'mm/dd/yyyy',
		multidate: false,
		todayHighlight: true
	});




	$('#btnAgregarReservadetalleservicio').click(function(){
		LimpiarModalDatosReservadetalleservicio();
		$('#categoria').val(1);
		$('#id').prop('readonly', false);  
		$('#IdModalGrupoCodigoHotel').prop('hidden', false);
		$('#btnModalAgregarReservadetalleservicio').toggle(true);
		$('#btnModalEditarReservadetalleservicio').toggle(false);
		$('#btnModalEliminarReservadetalleservicio').toggle(false);
		$('#modalAgregarReservadetalleservicio').modal();
	});


	function btnEditarReservadetalleservicio(Val0){
		$.ajax({
			type: 'POST',
			url: base_url + '/reservadetalleservicio/edit',
			data: { idreservadetalleservicio: Val0},
			success: function(msg){
		debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosReservadetalleservicio();
				$('#idreserva').val(temp.idreserva);
				$('#idreservadetalleservicio').val(temp.idreservadetalleservicio);
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


				$('#btnModalAgregarReservadetalleservicio').toggle(false);
				$('#btnModalEditarReservadetalleservicio').toggle(true);
				$('#btnModalEliminarReservadetalleservicio').toggle(true);
				$('#modalAgregarReservadetalleservicio').modal('toggle');
			},
			error: function(){
				alert('Hay un error...');
			}
		});
	}


	$('#btnModalAgregarReservadetalleservicio').click(function(){
debugger

		if (ValidarCamposVaciosReservadetalleservicio() != 0) {
			alert('Completar campos obligatorios');
		}else{
			$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
			RecolectarDatosReservadetalleservicio();
			EnviarInformacionReservadetalleservicio('agregar', NuevoReservadetalleservicio, true);
		}
	});


	$('#btnModalEditarReservadetalleservicio').click(function(){
		if (ValidarCamposVaciosReservadetalleservicio() != 0) {
			alert('Completar campos obligatorios');
		}else{
			RecolectarDatosReservadetalleservicio();
			EnviarInformacionReservadetalleservicio('modificar', NuevoReservadetalleservicio, true);
		}
	});


	$('#btnModalEliminarReservadetalleservicio').click(function(){
		var bool=confirm('ESTA SEGURO DE ELIMINAR EL DATO?');
		if(bool){
			RecolectarDatosReservadetalleservicio();
			EnviarInformacionReservadetalleservicio('eliminar', NuevoReservadetalleservicio, true);
		}
	});


	$('#btnModalCerrarHotel').click(function(){
		$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
		LimpiarModalDatosReservadetalleservicio();
	});


	$('#btnFiltroReservadetalleservicio').click(function(){
		RecolectarDatosReservadetalleservicio();
		EnviarInformacionReservadetalleservicio('leer', NuevoReservadetalleservicio, false);
	});


	function Paginado(pag) {
		RecolectarDatosReservadetalleservicio();
		EnviarInformacionReservadetalleservicio('leer', NuevoReservadetalleservicio, false, pag);
	}


	function RecolectarDatosReservadetalleservicio(){
		NuevoReservadetalleservicio = {
			idreserva: $('#idreserva').val().toUpperCase(),
			idreservadetalleservicio: $('#idreservadetalleservicio').val().toUpperCase(),
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


	function EnviarInformacionReservadetalleservicio(accion, objEvento, modal, pag=1) { 
		$.ajax({
			type: 'POST',
			url: base_url+'/reservadetalleservicio/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				var resp = JSON.parse(msg);
				$('#PaginadoReservadetalleservicio').empty();
				$('#PaginadoReservadetalleservicio').append(resp.pag);
				if (modal) {
					$('#modalAgregarReservadetalleservicio').modal('toggle');
					LimpiarModalDatosReservadetalleservicio();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								CargartablaReservadetalleservicio(resp.datos)
							}
						})
					} else {
						Swal.fire({
							title: resp.mensaje,
							icon: 'error'
						})
					}
				}else{
					CargartablaReservadetalleservicio(resp.datos)
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


	function LimpiarModalDatosReservadetalleservicio(){
		$('#idreserva').val('');
		$('#idreservadetalleservicio').val('0');
		$('#descripcion').val('');
		$('#fecha').val('');
		$('#cantidad').val('');
		$('#precio').val('');
		$('#total').val('');

	}


	function ValidarCamposVaciosReservadetalleservicio(){
		var error = 0;
		if ($('#idreserva').val() == ''){
			Resaltado('idreserva');
			error++;
		}
		if ($('#idreservadetalleservicio').val() == ''){
			Resaltado('idreservadetalleservicio');
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


	function CargartablaReservadetalleservicio(objeto){   
		$('#TablaReservadetalleservicio tr').not($('#TablaReservadetalleservicio tr:first')).remove();
		$.each(objeto, function(i, value) {
		var fila = '<tr>'+
			'<td >'+value.idreserva+'</td>'+
			'<td >'+value.idreservadetalleservicio+'</td>'+
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
						'<button type="button" onclick="btnEditarReservadetalleservicio(\''+value.idreservadetalleservicio+'\')" class="btn btn-info btn-xs">'+
							'<span class="fa fa-search fa-sm"></span>'+
						'</button>'+
					'</div>'+
						'<div style="margin: auto;">'+
							'<a class="btn btn-success btn-xs" href="<?php echo base_url();?>/reserva/add"><i class="fa fa-pencil"></i></a>'+
					'</div>'+
				'</div>'+
			'</td>'+
		'</tr>';
		$('#TablaReservadetalleservicio tbody').append(fila);
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