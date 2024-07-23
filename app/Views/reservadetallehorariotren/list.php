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
								<a href='<?php echo base_url();?>reservadetallehorariotren/excel' class='btn btn-success btn-sm'>
									<span class='fa fa-file-excel'></span> Exportar
								</a>
								<a href='<?php echo base_url();?>reservadetallehorariotren/pdf' target='_blank' class='btn btn-danger btn-sm'>
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
										<th hidden>Idreservadetallehorariotren</th>
										<th>Descripcion</th>
										<th>Fecha</th>
										<th>Cantidad</th>
										<th>Precio</th>
										<th>Total</th>
										<th>Confirmado</th>
										<th>Estado</th>
										<th hidden>Idhorariotren</th>
										<th hidden>Idhorario</th>
										<th>Nombre</th>
										<th hidden>Idtren</th>
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
										<?php foreach($datos as $reservadetallehorariotren):?>
											<tr>
												<td hidden><?php echo $reservadetallehorariotren['idreservadetallehorariotren'];?></td>
												<td><?php echo $reservadetallehorariotren['descripcion'];?></td>
												<td><?php echo $reservadetallehorariotren['fecha'];?></td>
												<td><?php echo $reservadetallehorariotren['cantidad'];?></td>
												<td><?php echo $reservadetallehorariotren['precio'];?></td>
												<td><?php echo $reservadetallehorariotren['total'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($reservadetallehorariotren['confirmado']== 1) ? 'CONFIRMADO' : 'PENDIENTE';?></td>
												<td class = 'hidden-xs'><?php echo $est = ($reservadetallehorariotren['estado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>
												<td hidden><?php echo $reservadetallehorariotren['idhorariotren'];?></td>
												<td hidden><?php echo $reservadetallehorariotren['idhorario'];?></td>
												<td><?php echo $reservadetallehorariotren['nombre'];?></td>
												<td hidden><?php echo $reservadetallehorariotren['idtren'];?></td>
												<td><?php echo $reservadetallehorariotren['nombre'];?></td>
												<td hidden><?php echo $reservadetallehorariotren['idreserva'];?></td>
												<td><?php echo $reservadetallehorariotren['reservanombre'];?></td>
												<td><?php echo $reservadetallehorariotren['concatenado'];?></td>
												<td><?php echo $reservadetallehorariotren['concatenadodetalle'];?></td>
												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarReservadetallehorariotren('<?php echo $reservadetallehorariotren['idreserva'].'\',\''.$reservadetallehorariotren['idreservadetallehorariotren'].'\',\''.$reservadetallehorariotren['idhorariotren'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-search fa-xs'></span>
															</button>
														</div>
														<div style='margin: auto;'>
															<a class='btn btn-success btn-xs' href="<?php echo base_url();?>reserva/add/<?php echo $reservadetallehorariotren['idreserva'].'\',\''.$reservadetallehorariotren['idreservadetallehorariotren'].'\',\''.$reservadetallehorariotren['idhorariotren'];?>"><i class='fa fa-pencil'></i></a>
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
						<div id='PaginadoReservadetallehorariotren'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<!--  SECCION ====== MODAL ====== -->
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
					<label class='col-sm-4'>Idreservadetallehorariotren:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='idreservadetallehorariotren' name='idreservadetallehorariotren' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
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
			<button type='button' class='btn btn-success btn-sm' id='btnModalAgregarReservadetallehorariotren'>Agregar</button>
			<button type='button' class='btn btn-warning btn-sm' id='btnModalEditarReservadetallehorariotren'>Modificar</button>
			<button type='button' class='btn btn-danger btn-sm' id='btnModalEliminarReservadetallehorariotren'>Eliminar</button>
			<button type='button' class='btn btn-primary btn-sm' id='btnModalCerrarReservadetallehorariotren' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<!--  SECCION ====== SCRIPT ====== -->
<script>
	var NuevoReservadetallehorariotren;
	var base_url= '<?php echo base_url();?>';
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
//   SECCION ====== btn Editar ======
	function btnEditarReservadetallehorariotren(Val0, Val1, Val2){
		$.ajax({
			type: 'POST',
			url: base_url + '/reservadetallehorariotren/edit',
			data: {idreserva: Val0, idreservadetallehorariotren: Val1, idhorariotren: Val2},
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
		$('#cantidad').val('0');
		$('#precio').val('');
		$('#total').val('');
	}
	function ValidarCamposVaciosReservadetallehorariotren(){
		var error = 0;
		var value = $('#idreserva').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idreserva');
			error++;
		}else{
			NoResaltado('idreserva');
		}
		var value = $('#idreservadetallehorariotren').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idreservadetallehorariotren');
			error++;
		}else{
			NoResaltado('idreservadetallehorariotren');
		}
		var value = $('#idhorariotren').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idhorariotren');
			error++;
		}else{
			NoResaltado('idhorariotren');
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
	function CargartablaReservadetallehorariotren(objeto){
		$('#TablaReservadetallehorariotren tr').not($('#TablaReservadetallehorariotren tr:first')).remove();
		$.each(objeto, function(i, value) {
				var fila = `<tr>
				<td hidden>${value.idreservadetallehorariotren}</td>
				<td>${value.descripcion}</td>
				<td>${value.fecha}</td>
				<td>${value.cantidad}</td>
				<td>${value.precio}</td>
				<td>${value.total}</td>
				<td class = 'hidden-xs'>${value.confirmado == '1' ? 'CONFIRMADO' : 'PENDIENTE'}</td>
				<td class = 'hidden-xs'>${value.estado == '1' ? 'ACTIVO' : 'DESACTIVO'}</td>
				<td hidden>${value.idhorariotren}</td>
				<td hidden>${value.idhorario}</td>
				<td>${value.nombre}</td>
				<td hidden>${value.idtren}</td>
				<td>${value.nombre}</td>
				<td hidden>${value.idreserva}</td>
				<td>${value.reservanombre}</td>
				<td>${value.concatenado}</td>
				<td>${value.concatenadodetalle}</td>
				<td>
				<div class='row'>
					<div style='margin: auto;'>
						<button type='button' onclick="btnEditarReservadetallehorariotren('${value.idreserva}', '${value.idreservadetallehorariotren}', '${value.idhorariotren}')" class='btn btn-info btn-xs'>
							<span class='fa fa-search fa-xs'></span>
						</button>
					</div>
						<div style='margin: auto;'>
							<a class='btn btn-success btn-xs' href='<?php echo base_url();?>/reserva/add/$reservadetallehorariotren['idreserva'].'\',\''.$reservadetallehorariotren['idreservadetallehorariotren'].'\',\''.$reservadetallehorariotren['idhorariotren']'><i class='fa fa-pencil'></i></a>
					</div>
				</div>
				</td>
				</tr>`
			$('#TablaReservadetallehorariotren tbody').append(fila);
		});
	}
</script>
