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
								<button type='button' class='btn btn-info btn-sm' id='btnAgregarReservadetallebus'>
									<span class='fa fa-plus'></span> Agregar Reservadetallebus
								</button>
								<a href='<?php echo base_url();?>reservadetallebus/excel' class='btn btn-success btn-sm'>
									<span class='fa fa-file-excel'></span> Exportar
								</a>
								<a href='<?php echo base_url();?>reservadetallebus/pdf' target='_blank' class='btn btn-danger btn-sm'>
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
												<button type='button' class='btn btn-info btn-sm' id='btnFiltroReservadetallebus'>
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
							<table id='TablaReservadetallebus' class='table table-sm table-bordered table-striped'>
								<thead>
									<tr>
										<th hidden>Idreservadetalleticketbus</th>
										<th>Descripcion</th>
										<th>Fecha</th>
										<th>Cantidad</th>
										<th>Precio</th>
										<th>Total</th>
										<th>Confirmado</th>
										<th>Estado</th>
										<th hidden>Idreserva</th>
										<th>Reservanombre</th>
										<th hidden>Idticketbus</th>
										<th>Nombre</th>
										<th>Concatenado</th>
										<th>Concatenadodetalle</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $reservadetallebus):?>
											<tr>
												<td hidden><?php echo $reservadetallebus['idreservadetalleticketbus'];?></td>
												<td><?php echo $reservadetallebus['descripcion'];?></td>
												<td><?php echo $reservadetallebus['fecha'];?></td>
												<td><?php echo $reservadetallebus['cantidad'];?></td>
												<td><?php echo $reservadetallebus['precio'];?></td>
												<td><?php echo $reservadetallebus['total'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($reservadetallebus['confirmado']== 1) ? 'CONFIRMADO' : 'PENDIENTE';?></td>
												<td class = 'hidden-xs'><?php echo $est = ($reservadetallebus['estado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>
												<td hidden><?php echo $reservadetallebus['idreserva'];?></td>
												<td><?php echo $reservadetallebus['reservanombre'];?></td>
												<td hidden><?php echo $reservadetallebus['idticketbus'];?></td>
												<td><?php echo $reservadetallebus['nombre'];?></td>
												<td><?php echo $reservadetallebus['concatenado'];?></td>
												<td><?php echo $reservadetallebus['concatenadodetalle'];?></td>
												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarReservadetallebus('<?php echo $reservadetallebus['idreserva'].'\',\''.$reservadetallebus['idreservadetalleticketbus'].'\',\''.$reservadetallebus['idticketbus'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-search fa-xs'></span>
															</button>
														</div>
														<div style='margin: auto;'>
															<a class='btn btn-success btn-xs' href="<?php echo base_url();?>reserva/add/<?php echo $reservadetallebus['idreserva'].'\',\''.$reservadetallebus['idreservadetalleticketbus'].'\',\''.$reservadetallebus['idticketbus'];?>"><i class='fa fa-pencil'></i></a>
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
						<div id='PaginadoReservadetallebus'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<!--  SECCION ====== MODAL ====== -->
<div class='modal fade' id='modalAgregarReservadetallebus' tabindex='-1'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title' id='modaldeltalletour'>Detalle Reservadetallebus</h4>
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
					<label class='col-sm-4'>Idreservadetalleticketbus:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='idreservadetalleticketbus' name='idreservadetalleticketbus' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4'>Ticketbus:</label>
					<div class = 'col-sm-8'>
						<select class='form-control form-control-sm select2' id='idticketbus'>
							<option value='0'>-- SELECCIONAR1 --</option>
							<?php if (!empty($ticketbuss)):?>
								<?php foreach($ticketbuss as $ticketbus):?>
									<option value= '<?php echo $ticketbus['idticketbus'];?>'><?php echo $ticketbus['concatenado'];?></option>
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
			<button type='button' class='btn btn-success btn-sm' id='btnModalAgregarReservadetallebus'>Agregar</button>
			<button type='button' class='btn btn-warning btn-sm' id='btnModalEditarReservadetallebus'>Modificar</button>
			<button type='button' class='btn btn-danger btn-sm' id='btnModalEliminarReservadetallebus'>Eliminar</button>
			<button type='button' class='btn btn-primary btn-sm' id='btnModalCerrarReservadetallebus' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<!--  SECCION ====== SCRIPT ====== -->
<script>
	var NuevoReservadetallebus;
	var base_url= '<?php echo base_url();?>';
	function load(pag){
		RecolectarDatosReservadetallebus();
		EnviarInformacionReservadetallebus('leer', NuevoReservadetallebus, false, pag);
	}
	$('#fecha').datepicker({
		language: 'es',
		todayBtn: 'linked',
		clearBtn: true,
		format: 'mm/dd/yyyy',
		multidate: false,
		todayHighlight: true
	});
	
	$('#btnAgregarReservadetallebus').click(function(){
		LimpiarModalDatosReservadetallebus();
		$('#categoria').val(1);
		$('#id').prop('readonly', false);  
		$('#IdModalGrupoCodigoHotel').prop('hidden', false);
		$('#btnModalAgregarReservadetallebus').toggle(true);
		$('#btnModalEditarReservadetallebus').toggle(false);
		$('#btnModalEliminarReservadetallebus').toggle(false);
		$('#modalAgregarReservadetallebus').modal();
	});
//   SECCION ====== btn Editar ======
	function btnEditarReservadetallebus(Val0, Val1, Val2){
		$.ajax({
			type: 'POST',
			url: base_url + '/reservadetallebus/edit',
			data: {idreserva: Val0, idreservadetalleticketbus: Val1, idticketbus: Val2},
			success: function(msg){
				debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosReservadetallebus();
				$('#idreserva').select2().val(temp.idreserva).select2('destroy').select2();
				$('#idreservadetalleticketbus').val(temp.idreservadetalleticketbus);
				$('#idticketbus').select2().val(temp.idticketbus).select2('destroy').select2();
				$('#descripcion').val(temp.descripcion);
				$('#fecha').val(temp.fecha);
				$('#cantidad').val(temp.cantidad);
				$('#precio').val(temp.precio);
				$('#total').val(temp.total);
				$('#confirmado').val(temp.confirmado);
				$('#estado').val(temp.estado);
				$('#btnModalAgregarReservadetallebus').toggle(false);
				$('#btnModalEditarReservadetallebus').toggle(true);
				$('#btnModalEliminarReservadetallebus').toggle(true);
				$('#modalAgregarReservadetallebus').modal('toggle');
			},
			error: function(){
				alert('Hay un error...');
			}
		});
	}
	$('#btnModalAgregarReservadetallebus').click(function(){
		debugger
		if (ValidarCamposVaciosReservadetallebus() != 0) {
			alert('Completar campos obligatorios');
		}else{
			$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
			RecolectarDatosReservadetallebus();
			EnviarInformacionReservadetallebus('agregar', NuevoReservadetallebus, true);
		}
	});
	$('#btnModalEditarReservadetallebus').click(function(){
		if (ValidarCamposVaciosReservadetallebus() != 0) {
			alert('Completar campos obligatorios');
		}else{
			RecolectarDatosReservadetallebus();
			EnviarInformacionReservadetallebus('modificar', NuevoReservadetallebus, true);
		}
	});
	$('#btnModalEliminarReservadetallebus').click(function(){
		var bool=confirm('ESTA SEGURO DE ELIMINAR EL DATO?');
		if(bool){
			RecolectarDatosReservadetallebus();
			EnviarInformacionReservadetallebus('eliminar', NuevoReservadetallebus, true);
		}
	});
	$('#btnModalCerrarHotel').click(function(){
		$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
		LimpiarModalDatosReservadetallebus();
	});
	$('#btnFiltroReservadetallebus').click(function(){
		RecolectarDatosReservadetallebus();
		EnviarInformacionReservadetallebus('leer', NuevoReservadetallebus, false);
	});
	function Paginado(pag) {
		RecolectarDatosReservadetallebus();
		EnviarInformacionReservadetallebus('leer', NuevoReservadetallebus, false, pag);
	}
	function RecolectarDatosReservadetallebus(){
		NuevoReservadetallebus = {
			idreserva: $('#idreserva').val().toUpperCase(),
			idreservadetalleticketbus: $('#idreservadetalleticketbus').val().toUpperCase(),
			idticketbus: $('#idticketbus').val().toUpperCase(),
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
	function EnviarInformacionReservadetallebus(accion, objEvento, modal, pag=1) { 
		$.ajax({
			type: 'POST',
			url: base_url+'/reservadetallebus/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				var resp = JSON.parse(msg);
				$('#PaginadoReservadetallebus').empty();
				$('#PaginadoReservadetallebus').append(resp.pag);
				if (modal) {
					$('#modalAgregarReservadetallebus').modal('toggle');
					LimpiarModalDatosReservadetallebus();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								CargartablaReservadetallebus(resp.datos)
							}
						})
					} else {
						Swal.fire({
							title: resp.mensaje,
							icon: 'error'
						})
					}
				}else{
					CargartablaReservadetallebus(resp.datos)
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
	function LimpiarModalDatosReservadetallebus(){
		$('#idreserva').select2().val(0).select2('destroy').select2();
		$('#idreservadetalleticketbus').val('0');
		$('#idticketbus').select2().val(0).select2('destroy').select2();
		$('#descripcion').val('');
		$('#fecha').val('');
		$('#cantidad').val('0');
		$('#precio').val('');
		$('#total').val('');
	}
	function ValidarCamposVaciosReservadetallebus(){
		var error = 0;
		var value = $('#idreserva').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idreserva');
			error++;
		}else{
			NoResaltado('idreserva');
		}
		var value = $('#idreservadetalleticketbus').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idreservadetalleticketbus');
			error++;
		}else{
			NoResaltado('idreservadetalleticketbus');
		}
		var value = $('#idticketbus').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idticketbus');
			error++;
		}else{
			NoResaltado('idticketbus');
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
	function CargartablaReservadetallebus(objeto){
		$('#TablaReservadetallebus tr').not($('#TablaReservadetallebus tr:first')).remove();
		$.each(objeto, function(i, value) {
				var fila = `<tr>
				<td hidden>${value.idreservadetalleticketbus}</td>
				<td>${value.descripcion}</td>
				<td>${value.fecha}</td>
				<td>${value.cantidad}</td>
				<td>${value.precio}</td>
				<td>${value.total}</td>
				<td class = 'hidden-xs'>${value.confirmado == '1' ? 'CONFIRMADO' : 'PENDIENTE'}</td>
				<td class = 'hidden-xs'>${value.estado == '1' ? 'ACTIVO' : 'DESACTIVO'}</td>
				<td hidden>${value.idreserva}</td>
				<td>${value.reservanombre}</td>
				<td hidden>${value.idticketbus}</td>
				<td>${value.nombre}</td>
				<td>${value.concatenado}</td>
				<td>${value.concatenadodetalle}</td>
				<td>
				<div class='row'>
					<div style='margin: auto;'>
						<button type='button' onclick="btnEditarReservadetallebus('${value.idreserva}', '${value.idreservadetalleticketbus}', '${value.idticketbus}')" class='btn btn-info btn-xs'>
							<span class='fa fa-search fa-xs'></span>
						</button>
					</div>
						<div style='margin: auto;'>
							<a class='btn btn-success btn-xs' href='<?php echo base_url();?>/reserva/add/$reservadetallebus['idreserva'].'\',\''.$reservadetallebus['idreservadetalleticketbus'].'\',\''.$reservadetallebus['idticketbus']'><i class='fa fa-pencil'></i></a>
					</div>
				</div>
				</td>
				</tr>`
			$('#TablaReservadetallebus tbody').append(fila);
		});
	}
</script>
