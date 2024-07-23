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
								<button type='button' class='btn btn-info btn-sm' id='btnAgregarReservadetalletour'>
									<span class='fa fa-plus'></span> Agregar Reservadetalletour
								</button>
								<a href='<?php echo base_url();?>reservadetalletour/excel' class='btn btn-success btn-sm'>
									<span class='fa fa-file-excel'></span> Exportar
								</a>
								<a href='<?php echo base_url();?>reservadetalletour/pdf' target='_blank' class='btn btn-danger btn-sm'>
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
												<button type='button' class='btn btn-info btn-sm' id='btnFiltroReservadetalletour'>
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
							<table id='TablaReservadetalletour' class='table table-sm table-bordered table-striped'>
								<thead>
									<tr>
										<th hidden>Idreservatour</th>
										<th>Descripcion</th>
										<th>Fecha</th>
										<th>Cantidad</th>
										<th>Precio</th>
										<th>Total</th>
										<th>Confirmado</th>
										<th>Estado</th>
										<th hidden>Idreserva</th>
										<th>Reservanombre</th>
										<th>Idtour</th>
										<th>Tournombre</th>
										<th hidden>Idcattour</th>
										<th>Nombre</th>
										<th>Concatenado</th>
										<th>Concatenadodetalle</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $reservadetalletour):?>
											<tr>
												<td hidden><?php echo $reservadetalletour['idreservatour'];?></td>
												<td><?php echo $reservadetalletour['descripcion'];?></td>
												<td><?php echo $reservadetalletour['fecha'];?></td>
												<td><?php echo $reservadetalletour['cantidad'];?></td>
												<td><?php echo $reservadetalletour['precio'];?></td>
												<td><?php echo $reservadetalletour['total'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($reservadetalletour['confirmado']== 1) ? 'CONFIRMADO' : 'PENDIENTE';?></td>
												<td class = 'hidden-xs'><?php echo $est = ($reservadetalletour['estado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>
												<td hidden><?php echo $reservadetalletour['idreserva'];?></td>
												<td><?php echo $reservadetalletour['reservanombre'];?></td>
												<td><?php echo $reservadetalletour['idtour'];?></td>
												<td><?php echo $reservadetalletour['tournombre'];?></td>
												<td hidden><?php echo $reservadetalletour['idcattour'];?></td>
												<td><?php echo $reservadetalletour['nombre'];?></td>
												<td><?php echo $reservadetalletour['concatenado'];?></td>
												<td><?php echo $reservadetalletour['concatenadodetalle'];?></td>
												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarReservadetalletour('<?php echo $reservadetalletour['idreserva'].'\',\''.$reservadetalletour['idreservatour'].'\',\''.$reservadetalletour['idtour'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-search fa-xs'></span>
															</button>
														</div>
														<div style='margin: auto;'>
															<a class='btn btn-success btn-xs' href="<?php echo base_url();?>reserva/add/<?php echo $reservadetalletour['idreserva'].'\',\''.$reservadetalletour['idreservatour'].'\',\''.$reservadetalletour['idtour'];?>"><i class='fa fa-pencil'></i></a>
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
						<div id='PaginadoReservadetalletour'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<!--  SECCION ====== MODAL ====== -->
<div class='modal fade' id='modalAgregarReservadetalletour' tabindex='-1'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title' id='modaldeltalletour'>Detalle Reservadetalletour</h4>
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
					<label class='col-sm-4'>Idreservatour:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='idreservatour' name='idreservatour' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4'>Tour:</label>
					<div class = 'col-sm-8'>
						<select class='form-control form-control-sm select2' id='idtour'>
							<option value='0'>-- SELECCIONAR1 --</option>
							<?php if (!empty($tours)):?>
								<?php foreach($tours as $tour):?>
									<option value= '<?php echo $tour['idtour'];?>'><?php echo $tour['concatenado'];?></option>
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
			<button type='button' class='btn btn-success btn-sm' id='btnModalAgregarReservadetalletour'>Agregar</button>
			<button type='button' class='btn btn-warning btn-sm' id='btnModalEditarReservadetalletour'>Modificar</button>
			<button type='button' class='btn btn-danger btn-sm' id='btnModalEliminarReservadetalletour'>Eliminar</button>
			<button type='button' class='btn btn-primary btn-sm' id='btnModalCerrarReservadetalletour' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<!--  SECCION ====== SCRIPT ====== -->
<script>
	var NuevoReservadetalletour;
	var base_url= '<?php echo base_url();?>';
	function load(pag){
		RecolectarDatosReservadetalletour();
		EnviarInformacionReservadetalletour('leer', NuevoReservadetalletour, false, pag);
	}
	$('#fecha').datepicker({
		language: 'es',
		todayBtn: 'linked',
		clearBtn: true,
		format: 'mm/dd/yyyy',
		multidate: false,
		todayHighlight: true
	});
	
	$('#btnAgregarReservadetalletour').click(function(){
		LimpiarModalDatosReservadetalletour();
		$('#categoria').val(1);
		$('#id').prop('readonly', false);  
		$('#IdModalGrupoCodigoHotel').prop('hidden', false);
		$('#btnModalAgregarReservadetalletour').toggle(true);
		$('#btnModalEditarReservadetalletour').toggle(false);
		$('#btnModalEliminarReservadetalletour').toggle(false);
		$('#modalAgregarReservadetalletour').modal();
	});
//   SECCION ====== btn Editar ======
	function btnEditarReservadetalletour(Val0, Val1, Val2){
		$.ajax({
			type: 'POST',
			url: base_url + '/reservadetalletour/edit',
			data: {idreserva: Val0, idreservatour: Val1, idtour: Val2},
			success: function(msg){
				debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosReservadetalletour();
				$('#idreserva').select2().val(temp.idreserva).select2('destroy').select2();
				$('#idreservatour').val(temp.idreservatour);
				$('#idtour').select2().val(temp.idtour).select2('destroy').select2();
				$('#descripcion').val(temp.descripcion);
				$('#fecha').val(temp.fecha);
				$('#cantidad').val(temp.cantidad);
				$('#precio').val(temp.precio);
				$('#total').val(temp.total);
				$('#confirmado').val(temp.confirmado);
				$('#estado').val(temp.estado);
				$('#btnModalAgregarReservadetalletour').toggle(false);
				$('#btnModalEditarReservadetalletour').toggle(true);
				$('#btnModalEliminarReservadetalletour').toggle(true);
				$('#modalAgregarReservadetalletour').modal('toggle');
			},
			error: function(){
				alert('Hay un error...');
			}
		});
	}
	$('#btnModalAgregarReservadetalletour').click(function(){
		debugger
		if (ValidarCamposVaciosReservadetalletour() != 0) {
			alert('Completar campos obligatorios');
		}else{
			$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
			RecolectarDatosReservadetalletour();
			EnviarInformacionReservadetalletour('agregar', NuevoReservadetalletour, true);
		}
	});
	$('#btnModalEditarReservadetalletour').click(function(){
		if (ValidarCamposVaciosReservadetalletour() != 0) {
			alert('Completar campos obligatorios');
		}else{
			RecolectarDatosReservadetalletour();
			EnviarInformacionReservadetalletour('modificar', NuevoReservadetalletour, true);
		}
	});
	$('#btnModalEliminarReservadetalletour').click(function(){
		var bool=confirm('ESTA SEGURO DE ELIMINAR EL DATO?');
		if(bool){
			RecolectarDatosReservadetalletour();
			EnviarInformacionReservadetalletour('eliminar', NuevoReservadetalletour, true);
		}
	});
	$('#btnModalCerrarHotel').click(function(){
		$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
		LimpiarModalDatosReservadetalletour();
	});
	$('#btnFiltroReservadetalletour').click(function(){
		RecolectarDatosReservadetalletour();
		EnviarInformacionReservadetalletour('leer', NuevoReservadetalletour, false);
	});
	function Paginado(pag) {
		RecolectarDatosReservadetalletour();
		EnviarInformacionReservadetalletour('leer', NuevoReservadetalletour, false, pag);
	}
	function RecolectarDatosReservadetalletour(){
		NuevoReservadetalletour = {
			idreserva: $('#idreserva').val().toUpperCase(),
			idreservatour: $('#idreservatour').val().toUpperCase(),
			idtour: $('#idtour').val().toUpperCase(),
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
	function EnviarInformacionReservadetalletour(accion, objEvento, modal, pag=1) { 
		$.ajax({
			type: 'POST',
			url: base_url+'/reservadetalletour/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				var resp = JSON.parse(msg);
				$('#PaginadoReservadetalletour').empty();
				$('#PaginadoReservadetalletour').append(resp.pag);
				if (modal) {
					$('#modalAgregarReservadetalletour').modal('toggle');
					LimpiarModalDatosReservadetalletour();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								CargartablaReservadetalletour(resp.datos)
							}
						})
					} else {
						Swal.fire({
							title: resp.mensaje,
							icon: 'error'
						})
					}
				}else{
					CargartablaReservadetalletour(resp.datos)
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
	function LimpiarModalDatosReservadetalletour(){
		$('#idreserva').select2().val(0).select2('destroy').select2();
		$('#idreservatour').val('0');
		$('#idtour').select2().val(0).select2('destroy').select2();
		$('#descripcion').val('');
		$('#fecha').val('');
		$('#cantidad').val('0');
		$('#precio').val('');
		$('#total').val('');
	}
	function ValidarCamposVaciosReservadetalletour(){
		var error = 0;
		var value = $('#idreserva').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idreserva');
			error++;
		}else{
			NoResaltado('idreserva');
		}
		var value = $('#idreservatour').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idreservatour');
			error++;
		}else{
			NoResaltado('idreservatour');
		}
		if ($('#idtour').val() == ''){
			Resaltado('idtour');
			error++;
		}else{
			NoResaltado('idtour');
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
	function CargartablaReservadetalletour(objeto){
		$('#TablaReservadetalletour tr').not($('#TablaReservadetalletour tr:first')).remove();
		$.each(objeto, function(i, value) {
				var fila = `<tr>
				<td hidden>${value.idreservatour}</td>
				<td>${value.descripcion}</td>
				<td>${value.fecha}</td>
				<td>${value.cantidad}</td>
				<td>${value.precio}</td>
				<td>${value.total}</td>
				<td class = 'hidden-xs'>${value.confirmado == '1' ? 'CONFIRMADO' : 'PENDIENTE'}</td>
				<td class = 'hidden-xs'>${value.estado == '1' ? 'ACTIVO' : 'DESACTIVO'}</td>
				<td hidden>${value.idreserva}</td>
				<td>${value.reservanombre}</td>
				<td>${value.idtour}</td>
				<td>${value.tournombre}</td>
				<td hidden>${value.idcattour}</td>
				<td>${value.nombre}</td>
				<td>${value.concatenado}</td>
				<td>${value.concatenadodetalle}</td>
				<td>
				<div class='row'>
					<div style='margin: auto;'>
						<button type='button' onclick="btnEditarReservadetalletour('${value.idreserva}', '${value.idreservatour}', '${value.idtour}')" class='btn btn-info btn-xs'>
							<span class='fa fa-search fa-xs'></span>
						</button>
					</div>
						<div style='margin: auto;'>
							<a class='btn btn-success btn-xs' href='<?php echo base_url();?>/reserva/add/$reservadetalletour['idreserva'].'\',\''.$reservadetalletour['idreservatour'].'\',\''.$reservadetalletour['idtour']'><i class='fa fa-pencil'></i></a>
					</div>
				</div>
				</td>
				</tr>`
			$('#TablaReservadetalletour tbody').append(fila);
		});
	}
</script>
