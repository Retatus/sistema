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
										<th hidden>Idreservadetalleotroservicio</th>
										<th>Descripcion</th>
										<th>Fecha</th>
										<th>Cantidad</th>
										<th>Precio</th>
										<th>Total</th>
										<th>Confirmado</th>
										<th>Estado</th>
										<th hidden>Idotroservicio</th>
										<th>Otroservicionombre</th>
										<th hidden>Idreserva</th>
										<th>Reservanombre</th>
										<th>Concatenado</th>
										<th>Concatenadodetalle</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $reservadetalleotroservicio):?>
											<tr>
												<td hidden><?php echo $reservadetalleotroservicio['idreservadetalleotroservicio'];?></td>
												<td><?php echo $reservadetalleotroservicio['descripcion'];?></td>
												<td><?php echo $reservadetalleotroservicio['fecha'];?></td>
												<td><?php echo $reservadetalleotroservicio['cantidad'];?></td>
												<td><?php echo $reservadetalleotroservicio['precio'];?></td>
												<td><?php echo $reservadetalleotroservicio['total'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($reservadetalleotroservicio['confirmado']== 1) ? 'CONFIRMADO' : 'PENDIENTE';?></td>
												<td class = 'hidden-xs'><?php echo $est = ($reservadetalleotroservicio['estado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>
												<td hidden><?php echo $reservadetalleotroservicio['idotroservicio'];?></td>
												<td><?php echo $reservadetalleotroservicio['otroservicionombre'];?></td>
												<td hidden><?php echo $reservadetalleotroservicio['idreserva'];?></td>
												<td><?php echo $reservadetalleotroservicio['reservanombre'];?></td>
												<td><?php echo $reservadetalleotroservicio['concatenado'];?></td>
												<td><?php echo $reservadetalleotroservicio['concatenadodetalle'];?></td>
												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarReservadetalleotroservicio('<?php echo $reservadetalleotroservicio['idreserva'].'\',\''.$reservadetalleotroservicio['idreservadetalleotroservicio'].'\',\''.$reservadetalleotroservicio['idotroservicio'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-search fa-xs'></span>
															</button>
														</div>
														<div style='margin: auto;'>
															<a class='btn btn-success btn-xs' href="<?php echo base_url();?>reserva/add/<?php echo $reservadetalleotroservicio['idreserva'].'\',\''.$reservadetalleotroservicio['idreservadetalleotroservicio'].'\',\''.$reservadetalleotroservicio['idotroservicio'];?>"><i class='fa fa-pencil'></i></a>
														</div>
													</div>
												</td>
											</tr>
										<?php endforeach;?>
									<?php endif;?>
								</tbody>
							</table>
						</div>
					</div>
					<div class='card-footer'>
						<div id='PaginadoReservadetalleotroservicio'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<!--  SECCION ====== MODAL ====== -->
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
				<div class='col-6 form-group row' hidden>
					<label class='col-sm-4'>Idreservadetalleotroservicio:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='idreservadetalleotroservicio' name='idreservadetalleotroservicio' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
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
					<label class='col-sm-4'>Fecha:</label>
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
					<label class='col-sm-4' for='id'>Cantidad:</label>
					<div class = 'col-sm-8'>
						<input type='number' class='form-control form-control-sm' id='cantidad' name='cantidad' placeholder='0.00' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>Precio:</label>
					<div class = 'col-sm-8'>
						<input type='number' class='form-control form-control-sm' id='precio' name='precio' placeholder='0.00' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>Total:</label>
					<div class = 'col-sm-8'>
						<input type='number' class='form-control form-control-sm' id='total' name='total' placeholder='0.00' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='rol'>Confirmado:</label>
					<div class='col-sm-8'>
						<select class='form-control form-control-sm' id='confirmado' name='confirmado'>
							<option value = '1' selected >CONFIRMADO</option>
							<option value = '0' >CANCELADO</option>
						</select>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='rol'>Estado:</label>
					<div class='col-sm-8'>
						<select class='form-control form-control-sm' id='estado' name='estado'>
							<option value = '1' selected >ACTIVO</option>
							<option value = '0' >DESACTIVO</option>
						</select>
					</div>
				</div>
				<div class='col-12 form-group row'>
					<label class='col-sm-4' for='id'>Descripcion:</label>
					<div class = 'col-sm-12'>
						<textarea type='text' class='form-control form-control-sm text-uppercase' id='descripcion' name='descripcion' placeholder='T001' autocomplete = 'off'></textarea>
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
<!--  SECCION ====== SCRIPT ====== -->
<script>
	var NuevoReservadetalleotroservicio;
	var base_url= '<?php echo base_url();?>';
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
//   SECCION ====== btn Editar ======
	function btnEditarReservadetalleotroservicio(Val0, Val1, Val2){
		$.ajax({
			type: 'POST',
			url: base_url + '/reservadetalleotroservicio/edit',
			data: {idreserva: Val0, idreservadetalleotroservicio: Val1, idotroservicio: Val2},
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
		$('#cantidad').val('0');
		$('#precio').val('');
		$('#total').val('');
	}
	function ValidarCamposVaciosReservadetalleotroservicio(){
		var error = 0;
		var value = $('#idreserva').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idreserva');
			error++;
		}else{
			NoResaltado('idreserva');
		}
		var value = $('#idreservadetalleotroservicio').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idreservadetalleotroservicio');
			error++;
		}else{
			NoResaltado('idreservadetalleotroservicio');
		}
		var value = $('#idotroservicio').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idotroservicio');
			error++;
		}else{
			NoResaltado('idotroservicio');
		}
		if ($('#descripcion').val() == ''){
			Resaltado('descripcion');
			error++;
		}else{
			NoResaltado('descripcion');
		}
		if ($('#fecha').val() == ''){
			Resaltado('fecha');
			error++;
		}else{
			NoResaltado('fecha');
		}
		var value = $('#cantidad').val();
		if (!/^\d*$/.test(value)){
			Resaltado('cantidad');
			error++;
		}else{
			NoResaltado('cantidad');
		}
		if ($('#precio').val() == ''){
			Resaltado('precio');
			error++;
		}else{
			NoResaltado('precio');
		}
		if ($('#total').val() == ''){
			Resaltado('total');
			error++;
		}else{
			NoResaltado('total');
		}
		if ($('#confirmado').val() == ''){
			Resaltado('confirmado');
			error++;
		}else{
			NoResaltado('confirmado');
		}
		if ($('#estado').val() == ''){
			Resaltado('estado');
			error++;
		}else{
			NoResaltado('estado');
		}
		return error;
	}
	function Resaltado(id){
		$('#'+id).css('border-color', '#ef5350');
		$('#'+id).focus();
	}

	function NoResaltado(id){
		$('#'+id).css('border-color', '#ced4da');
	}
	function CargartablaReservadetalleotroservicio(objeto){
		$('#TablaReservadetalleotroservicio tr').not($('#TablaReservadetalleotroservicio tr:first')).remove();
		$.each(objeto, function(i, value) {
				var fila = `<tr>
				<td hidden>${value.idreservadetalleotroservicio}</td>
				<td>${value.descripcion}</td>
				<td>${value.fecha}</td>
				<td>${value.cantidad}</td>
				<td>${value.precio}</td>
				<td>${value.total}</td>
				<td class = 'hidden-xs'>${value.confirmado == '1' ? 'CONFIRMADO' : 'PENDIENTE'}</td>
				<td class = 'hidden-xs'>${value.estado == '1' ? 'ACTIVO' : 'DESACTIVO'}</td>
				<td hidden>${value.idotroservicio}</td>
				<td>${value.otroservicionombre}</td>
				<td hidden>${value.idreserva}</td>
				<td>${value.reservanombre}</td>
				<td>${value.concatenado}</td>
				<td>${value.concatenadodetalle}</td>
				<td>
				<div class='row'>
					<div style='margin: auto;'>
						<button type='button' onclick="btnEditarReservadetalleotroservicio('${value.idreserva}', '${value.idreservadetalleotroservicio}', '${value.idotroservicio}')" class='btn btn-info btn-xs'>
							<span class='fa fa-search fa-xs'></span>
						</button>
					</div>
						<div style='margin: auto;'>
							<a class='btn btn-success btn-xs' href='<?php echo base_url();?>/reserva/add/$reservadetalleotroservicio['idreserva'].'\',\''.$reservadetalleotroservicio['idreservadetalleotroservicio'].'\',\''.$reservadetalleotroservicio['idotroservicio']'><i class='fa fa-pencil'></i></a>
					</div>
				</div>
				</td>
				</tr>`
			$('#TablaReservadetalleotroservicio tbody').append(fila);
		});
	}
</script>
