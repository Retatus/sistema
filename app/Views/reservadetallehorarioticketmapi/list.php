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
								<button type='button' class='btn btn-info btn-sm' id='btnAgregarReservadetallehorarioticketmapi'>
									<span class='fa fa-plus'></span> Agregar Reservadetallehorarioticketmapi
								</button>
								<a href='<?php echo base_url();?>reservadetallehorarioticketmapi/excel' class='btn btn-success btn-sm'>
									<span class='fa fa-file-excel'></span> Exportar
								</a>
								<a href='<?php echo base_url();?>reservadetallehorarioticketmapi/pdf' target='_blank' class='btn btn-danger btn-sm'>
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
												<button type='button' class='btn btn-info btn-sm' id='btnFiltroReservadetallehorarioticketmapi'>
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
							<table id='TablaReservadetallehorarioticketmapi' class='table table-sm table-bordered table-striped'>
								<thead>
									<tr>
										<th hidden>Idreservadetallehorarioticketmapi</th>
										<th>Fecha</th>
										<th>Descripcion</th>
										<th>Cantidad</th>
										<th>Precio</th>
										<th>Total</th>
										<th>Confirmado</th>
										<th>Estado</th>
										<th hidden>Idhorarioticketmapi</th>
										<th hidden>Idclientetipo</th>
										<th>Nombre</th>
										<th hidden>Idhoraticketmapi</th>
										<th>Nombre</th>
										<th hidden>Idticketmapi</th>
										<th>Nombre</th>
										<th hidden>Idreserva</th>
										<th>Reservanombre</th>
										<th>Concatenado</th>
										<th>Concatenadodetalle</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $reservadetallehorarioticketmapi):?>
											<tr>
												<td hidden><?php echo $reservadetallehorarioticketmapi['idreservadetallehorarioticketmapi'];?></td>
												<td><?php echo $reservadetallehorarioticketmapi['fecha'];?></td>
												<td><?php echo $reservadetallehorarioticketmapi['descripcion'];?></td>
												<td><?php echo $reservadetallehorarioticketmapi['cantidad'];?></td>
												<td><?php echo $reservadetallehorarioticketmapi['precio'];?></td>
												<td><?php echo $reservadetallehorarioticketmapi['total'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($reservadetallehorarioticketmapi['confirmado']== 1) ? 'CONFIRMADO' : 'PENDIENTE';?></td>
												<td class = 'hidden-xs'><?php echo $est = ($reservadetallehorarioticketmapi['estado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>
												<td hidden><?php echo $reservadetallehorarioticketmapi['idhorarioticketmapi'];?></td>
												<td hidden><?php echo $reservadetallehorarioticketmapi['idclientetipo'];?></td>
												<td><?php echo $reservadetallehorarioticketmapi['nombre'];?></td>
												<td hidden><?php echo $reservadetallehorarioticketmapi['idhoraticketmapi'];?></td>
												<td><?php echo $reservadetallehorarioticketmapi['nombre'];?></td>
												<td hidden><?php echo $reservadetallehorarioticketmapi['idticketmapi'];?></td>
												<td><?php echo $reservadetallehorarioticketmapi['nombre'];?></td>
												<td hidden><?php echo $reservadetallehorarioticketmapi['idreserva'];?></td>
												<td><?php echo $reservadetallehorarioticketmapi['reservanombre'];?></td>
												<td><?php echo $reservadetallehorarioticketmapi['concatenado'];?></td>
												<td><?php echo $reservadetallehorarioticketmapi['concatenadodetalle'];?></td>
												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarReservadetallehorarioticketmapi('<?php echo $reservadetallehorarioticketmapi['idreservadetallehorarioticketmapi'].'\',\''.$reservadetallehorarioticketmapi['idreserva'].'\',\''.$reservadetallehorarioticketmapi['idhorarioticketmapi'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-search fa-xs'></span>
															</button>
														</div>
														<div style='margin: auto;'>
															<a class='btn btn-success btn-xs' href="<?php echo base_url();?>reserva/add/<?php echo $reservadetallehorarioticketmapi['idreservadetallehorarioticketmapi'].'\',\''.$reservadetallehorarioticketmapi['idreserva'].'\',\''.$reservadetallehorarioticketmapi['idhorarioticketmapi'];?>"><i class='fa fa-pencil'></i></a>
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
						<div id='PaginadoReservadetallehorarioticketmapi'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<!--  SECCION ====== MODAL ====== -->
<div class='modal fade' id='modalAgregarReservadetallehorarioticketmapi' tabindex='-1'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title' id='modaldeltalletour'>Detalle Reservadetallehorarioticketmapi</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<div class='col-6 form-group row' hidden>
					<label class='col-sm-4'>Idreservadetallehorarioticketmapi:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='idreservadetallehorarioticketmapi' name='idreservadetallehorarioticketmapi' placeholder='T001' autocomplete = 'off'>
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
					<label class='col-sm-4'>Horarioticketmapi:</label>
					<div class = 'col-sm-8'>
						<select class='form-control form-control-sm select2' id='idhorarioticketmapi'>
							<option value='0'>-- SELECCIONAR1 --</option>
							<?php if (!empty($horarioticketmapis)):?>
								<?php foreach($horarioticketmapis as $horarioticketmapi):?>
									<option value= '<?php echo $horarioticketmapi['idhorarioticketmapi'];?>'><?php echo $horarioticketmapi['concatenado'];?></option>
								<?php endforeach;?>
							<?php endif;?>
						</select>
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
			<button type='button' class='btn btn-success btn-sm' id='btnModalAgregarReservadetallehorarioticketmapi'>Agregar</button>
			<button type='button' class='btn btn-warning btn-sm' id='btnModalEditarReservadetallehorarioticketmapi'>Modificar</button>
			<button type='button' class='btn btn-danger btn-sm' id='btnModalEliminarReservadetallehorarioticketmapi'>Eliminar</button>
			<button type='button' class='btn btn-primary btn-sm' id='btnModalCerrarReservadetallehorarioticketmapi' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<!--  SECCION ====== SCRIPT ====== -->
<script>
	var NuevoReservadetallehorarioticketmapi;
	var base_url= '<?php echo base_url();?>';
	function load(pag){
		RecolectarDatosReservadetallehorarioticketmapi();
		EnviarInformacionReservadetallehorarioticketmapi('leer', NuevoReservadetallehorarioticketmapi, false, pag);
	}
	$('#fecha').datepicker({
		language: 'es',
		todayBtn: 'linked',
		clearBtn: true,
		format: 'mm/dd/yyyy',
		multidate: false,
		todayHighlight: true
	});
	
	$('#btnAgregarReservadetallehorarioticketmapi').click(function(){
		LimpiarModalDatosReservadetallehorarioticketmapi();
		$('#categoria').val(1);
		$('#id').prop('readonly', false);  
		$('#IdModalGrupoCodigoHotel').prop('hidden', false);
		$('#btnModalAgregarReservadetallehorarioticketmapi').toggle(true);
		$('#btnModalEditarReservadetallehorarioticketmapi').toggle(false);
		$('#btnModalEliminarReservadetallehorarioticketmapi').toggle(false);
		$('#modalAgregarReservadetallehorarioticketmapi').modal();
	});
//   SECCION ====== btn Editar ======
	function btnEditarReservadetallehorarioticketmapi(Val0, Val1, Val2){
		$.ajax({
			type: 'POST',
			url: base_url + '/reservadetallehorarioticketmapi/edit',
			data: {idreservadetallehorarioticketmapi: Val0, idreserva: Val1, idhorarioticketmapi: Val2},
			success: function(msg){
				debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosReservadetallehorarioticketmapi();
				$('#idreservadetallehorarioticketmapi').val(temp.idreservadetallehorarioticketmapi);
				$('#idreserva').select2().val(temp.idreserva).select2('destroy').select2();
				$('#fecha').val(temp.fecha);
				$('#descripcion').val(temp.descripcion);
				$('#cantidad').val(temp.cantidad);
				$('#precio').val(temp.precio);
				$('#total').val(temp.total);
				$('#idhorarioticketmapi').select2().val(temp.idhorarioticketmapi).select2('destroy').select2();
				$('#confirmado').val(temp.confirmado);
				$('#estado').val(temp.estado);
				$('#btnModalAgregarReservadetallehorarioticketmapi').toggle(false);
				$('#btnModalEditarReservadetallehorarioticketmapi').toggle(true);
				$('#btnModalEliminarReservadetallehorarioticketmapi').toggle(true);
				$('#modalAgregarReservadetallehorarioticketmapi').modal('toggle');
			},
			error: function(){
				alert('Hay un error...');
			}
		});
	}
	$('#btnModalAgregarReservadetallehorarioticketmapi').click(function(){
		debugger
		if (ValidarCamposVaciosReservadetallehorarioticketmapi() != 0) {
			alert('Completar campos obligatorios');
		}else{
			$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
			RecolectarDatosReservadetallehorarioticketmapi();
			EnviarInformacionReservadetallehorarioticketmapi('agregar', NuevoReservadetallehorarioticketmapi, true);
		}
	});
	$('#btnModalEditarReservadetallehorarioticketmapi').click(function(){
		if (ValidarCamposVaciosReservadetallehorarioticketmapi() != 0) {
			alert('Completar campos obligatorios');
		}else{
			RecolectarDatosReservadetallehorarioticketmapi();
			EnviarInformacionReservadetallehorarioticketmapi('modificar', NuevoReservadetallehorarioticketmapi, true);
		}
	});
	$('#btnModalEliminarReservadetallehorarioticketmapi').click(function(){
		var bool=confirm('ESTA SEGURO DE ELIMINAR EL DATO?');
		if(bool){
			RecolectarDatosReservadetallehorarioticketmapi();
			EnviarInformacionReservadetallehorarioticketmapi('eliminar', NuevoReservadetallehorarioticketmapi, true);
		}
	});
	$('#btnModalCerrarHotel').click(function(){
		$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
		LimpiarModalDatosReservadetallehorarioticketmapi();
	});
	$('#btnFiltroReservadetallehorarioticketmapi').click(function(){
		RecolectarDatosReservadetallehorarioticketmapi();
		EnviarInformacionReservadetallehorarioticketmapi('leer', NuevoReservadetallehorarioticketmapi, false);
	});
	function Paginado(pag) {
		RecolectarDatosReservadetallehorarioticketmapi();
		EnviarInformacionReservadetallehorarioticketmapi('leer', NuevoReservadetallehorarioticketmapi, false, pag);
	}
	function RecolectarDatosReservadetallehorarioticketmapi(){
		NuevoReservadetallehorarioticketmapi = {
			idreservadetallehorarioticketmapi: $('#idreservadetallehorarioticketmapi').val().toUpperCase(),
			idreserva: $('#idreserva').val().toUpperCase(),
			fecha: $('#fecha').val().toUpperCase(),
			descripcion: $('#descripcion').val().toUpperCase(),
			cantidad: $('#cantidad').val().toUpperCase(),
			precio: $('#precio').val().toUpperCase(),
			total: $('#total').val().toUpperCase(),
			idhorarioticketmapi: $('#idhorarioticketmapi').val().toUpperCase(),
			confirmado: $('#confirmado').val().toUpperCase(),
			estado: $('#estado').val().toUpperCase(),
			todos: $('#idFTodos').val(),
			texto: $('#idFTexto').val()
		};
	}
	function EnviarInformacionReservadetallehorarioticketmapi(accion, objEvento, modal, pag=1) { 
		$.ajax({
			type: 'POST',
			url: base_url+'/reservadetallehorarioticketmapi/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				var resp = JSON.parse(msg);
				$('#PaginadoReservadetallehorarioticketmapi').empty();
				$('#PaginadoReservadetallehorarioticketmapi').append(resp.pag);
				if (modal) {
					$('#modalAgregarReservadetallehorarioticketmapi').modal('toggle');
					LimpiarModalDatosReservadetallehorarioticketmapi();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								CargartablaReservadetallehorarioticketmapi(resp.datos)
							}
						})
					} else {
						Swal.fire({
							title: resp.mensaje,
							icon: 'error'
						})
					}
				}else{
					CargartablaReservadetallehorarioticketmapi(resp.datos)
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
	function LimpiarModalDatosReservadetallehorarioticketmapi(){
		$('#idreservadetallehorarioticketmapi').val('0');
		$('#idreserva').select2().val(0).select2('destroy').select2();
		$('#fecha').val('');
		$('#descripcion').val('');
		$('#cantidad').val('0');
		$('#precio').val('');
		$('#total').val('');
		$('#idhorarioticketmapi').select2().val(0).select2('destroy').select2();
	}
	function ValidarCamposVaciosReservadetallehorarioticketmapi(){
		var error = 0;
		var value = $('#idreservadetallehorarioticketmapi').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idreservadetallehorarioticketmapi');
			error++;
		}else{
			NoResaltado('idreservadetallehorarioticketmapi');
		}
		var value = $('#idreserva').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idreserva');
			error++;
		}else{
			NoResaltado('idreserva');
		}
		if ($('#fecha').val() == ''){
			Resaltado('fecha');
			error++;
		}else{
			NoResaltado('fecha');
		}
		if ($('#descripcion').val() == ''){
			Resaltado('descripcion');
			error++;
		}else{
			NoResaltado('descripcion');
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
		var value = $('#idhorarioticketmapi').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idhorarioticketmapi');
			error++;
		}else{
			NoResaltado('idhorarioticketmapi');
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
	function CargartablaReservadetallehorarioticketmapi(objeto){
		$('#TablaReservadetallehorarioticketmapi tr').not($('#TablaReservadetallehorarioticketmapi tr:first')).remove();
		$.each(objeto, function(i, value) {
				var fila = `<tr>
				<td hidden>${value.idreservadetallehorarioticketmapi}</td>
				<td>${value.fecha}</td>
				<td>${value.descripcion}</td>
				<td>${value.cantidad}</td>
				<td>${value.precio}</td>
				<td>${value.total}</td>
				<td class = 'hidden-xs'>${value.confirmado == '1' ? 'CONFIRMADO' : 'PENDIENTE'}</td>
				<td class = 'hidden-xs'>${value.estado == '1' ? 'ACTIVO' : 'DESACTIVO'}</td>
				<td hidden>${value.idhorarioticketmapi}</td>
				<td hidden>${value.idclientetipo}</td>
				<td>${value.nombre}</td>
				<td hidden>${value.idhoraticketmapi}</td>
				<td>${value.nombre}</td>
				<td hidden>${value.idticketmapi}</td>
				<td>${value.nombre}</td>
				<td hidden>${value.idreserva}</td>
				<td>${value.reservanombre}</td>
				<td>${value.concatenado}</td>
				<td>${value.concatenadodetalle}</td>
				<td>
				<div class='row'>
					<div style='margin: auto;'>
						<button type='button' onclick="btnEditarReservadetallehorarioticketmapi('${value.idreservadetallehorarioticketmapi}', '${value.idreserva}', '${value.idhorarioticketmapi}')" class='btn btn-info btn-xs'>
							<span class='fa fa-search fa-xs'></span>
						</button>
					</div>
						<div style='margin: auto;'>
							<a class='btn btn-success btn-xs' href='<?php echo base_url();?>/reserva/add/$reservadetallehorarioticketmapi['idreservadetallehorarioticketmapi'].'\',\''.$reservadetallehorarioticketmapi['idreserva'].'\',\''.$reservadetallehorarioticketmapi['idhorarioticketmapi']'><i class='fa fa-pencil'></i></a>
					</div>
				</div>
				</td>
				</tr>`
			$('#TablaReservadetallehorarioticketmapi tbody').append(fila);
		});
	}
</script>
