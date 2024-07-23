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
								<button type='button' class='btn btn-info btn-sm' id='btnAgregarReservadetallecliente'>
									<span class='fa fa-plus'></span> Agregar Reservadetallecliente
								</button>
								<a href='<?php echo base_url();?>reservadetallecliente/excel' class='btn btn-success btn-sm'>
									<span class='fa fa-file-excel'></span> Exportar
								</a>
								<a href='<?php echo base_url();?>reservadetallecliente/pdf' target='_blank' class='btn btn-danger btn-sm'>
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
												<button type='button' class='btn btn-info btn-sm' id='btnFiltroReservadetallecliente'>
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
							<table id='TablaReservadetallecliente' class='table table-sm table-bordered table-striped'>
								<thead>
									<tr>
										<th hidden>Idreservadetallecliente</th>
										<th>Cantidad</th>
										<th>Precio</th>
										<th>Total</th>
										<th>Confirmado</th>
										<th>Estado</th>
										<th hidden>Idreserva</th>
										<th>Reservanombre</th>
										<th>Idcliente</th>
										<th>Clientenombre</th>
										<th hidden>Idtipodoc</th>
										<th>Nombre</th>
										<th>Concatenado</th>
										<th>Concatenadodetalle</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $reservadetallecliente):?>
											<tr>
												<td hidden><?php echo $reservadetallecliente['idreservadetallecliente'];?></td>
												<td><?php echo $reservadetallecliente['cantidad'];?></td>
												<td><?php echo $reservadetallecliente['precio'];?></td>
												<td><?php echo $reservadetallecliente['total'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($reservadetallecliente['confirmado']== 1) ? 'CONFIRMADO' : 'PENDIENTE';?></td>
												<td class = 'hidden-xs'><?php echo $est = ($reservadetallecliente['estado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>
												<td hidden><?php echo $reservadetallecliente['idreserva'];?></td>
												<td><?php echo $reservadetallecliente['reservanombre'];?></td>
												<td><?php echo $reservadetallecliente['idcliente'];?></td>
												<td><?php echo $reservadetallecliente['clientenombre'];?></td>
												<td hidden><?php echo $reservadetallecliente['idtipodoc'];?></td>
												<td><?php echo $reservadetallecliente['nombre'];?></td>
												<td><?php echo $reservadetallecliente['concatenado'];?></td>
												<td><?php echo $reservadetallecliente['concatenadodetalle'];?></td>
												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarReservadetallecliente('<?php echo $reservadetallecliente['idreservadetallecliente'].'\',\''.$reservadetallecliente['idreserva'].'\',\''.$reservadetallecliente['idcliente'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-search fa-xs'></span>
															</button>
														</div>
														<div style='margin: auto;'>
															<a class='btn btn-success btn-xs' href="<?php echo base_url();?>reserva/add/<?php echo $reservadetallecliente['idreservadetallecliente'].'\',\''.$reservadetallecliente['idreserva'].'\',\''.$reservadetallecliente['idcliente'];?>"><i class='fa fa-pencil'></i></a>
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
						<div id='PaginadoReservadetallecliente'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<!--  SECCION ====== MODAL ====== -->
<div class='modal fade' id='modalAgregarReservadetallecliente' tabindex='-1'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title' id='modaldeltalletour'>Detalle Reservadetallecliente</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<div class='col-6 form-group row' hidden>
					<label class='col-sm-4'>Idreservadetallecliente:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='idreservadetallecliente' name='idreservadetallecliente' placeholder='T001' autocomplete = 'off'>
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
					<label class='col-sm-4'>Cliente:</label>
					<div class = 'col-sm-8'>
						<select class='form-control form-control-sm select2' id='idcliente'>
							<option value='0'>-- SELECCIONAR1 --</option>
							<?php if (!empty($clientes)):?>
								<?php foreach($clientes as $cliente):?>
									<option value= '<?php echo $cliente['idcliente'];?>'><?php echo $cliente['concatenado'];?></option>
								<?php endforeach;?>
							<?php endif;?>
						</select>
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
			</div>
		</div>
		<div class='modal-footer'>
			<button type='button' class='btn btn-success btn-sm' id='btnModalAgregarReservadetallecliente'>Agregar</button>
			<button type='button' class='btn btn-warning btn-sm' id='btnModalEditarReservadetallecliente'>Modificar</button>
			<button type='button' class='btn btn-danger btn-sm' id='btnModalEliminarReservadetallecliente'>Eliminar</button>
			<button type='button' class='btn btn-primary btn-sm' id='btnModalCerrarReservadetallecliente' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<!--  SECCION ====== SCRIPT ====== -->
<script>
	var NuevoReservadetallecliente;
	var base_url= '<?php echo base_url();?>';
	function load(pag){
		RecolectarDatosReservadetallecliente();
		EnviarInformacionReservadetallecliente('leer', NuevoReservadetallecliente, false, pag);
	}
	$('#btnAgregarReservadetallecliente').click(function(){
		LimpiarModalDatosReservadetallecliente();
		$('#categoria').val(1);
		$('#id').prop('readonly', false);  
		$('#IdModalGrupoCodigoHotel').prop('hidden', false);
		$('#btnModalAgregarReservadetallecliente').toggle(true);
		$('#btnModalEditarReservadetallecliente').toggle(false);
		$('#btnModalEliminarReservadetallecliente').toggle(false);
		$('#modalAgregarReservadetallecliente').modal();
	});
//   SECCION ====== btn Editar ======
	function btnEditarReservadetallecliente(Val0, Val1, Val2){
		$.ajax({
			type: 'POST',
			url: base_url + '/reservadetallecliente/edit',
			data: {idreservadetallecliente: Val0, idreserva: Val1, idcliente: Val2},
			success: function(msg){
				debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosReservadetallecliente();
				$('#idreservadetallecliente').val(temp.idreservadetallecliente);
				$('#idreserva').select2().val(temp.idreserva).select2('destroy').select2();
				$('#idcliente').select2().val(temp.idcliente).select2('destroy').select2();
				$('#cantidad').val(temp.cantidad);
				$('#precio').val(temp.precio);
				$('#total').val(temp.total);
				$('#confirmado').val(temp.confirmado);
				$('#estado').val(temp.estado);
				$('#btnModalAgregarReservadetallecliente').toggle(false);
				$('#btnModalEditarReservadetallecliente').toggle(true);
				$('#btnModalEliminarReservadetallecliente').toggle(true);
				$('#modalAgregarReservadetallecliente').modal('toggle');
			},
			error: function(){
				alert('Hay un error...');
			}
		});
	}
	$('#btnModalAgregarReservadetallecliente').click(function(){
		debugger
		if (ValidarCamposVaciosReservadetallecliente() != 0) {
			alert('Completar campos obligatorios');
		}else{
			$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
			RecolectarDatosReservadetallecliente();
			EnviarInformacionReservadetallecliente('agregar', NuevoReservadetallecliente, true);
		}
	});
	$('#btnModalEditarReservadetallecliente').click(function(){
		if (ValidarCamposVaciosReservadetallecliente() != 0) {
			alert('Completar campos obligatorios');
		}else{
			RecolectarDatosReservadetallecliente();
			EnviarInformacionReservadetallecliente('modificar', NuevoReservadetallecliente, true);
		}
	});
	$('#btnModalEliminarReservadetallecliente').click(function(){
		var bool=confirm('ESTA SEGURO DE ELIMINAR EL DATO?');
		if(bool){
			RecolectarDatosReservadetallecliente();
			EnviarInformacionReservadetallecliente('eliminar', NuevoReservadetallecliente, true);
		}
	});
	$('#btnModalCerrarHotel').click(function(){
		$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
		LimpiarModalDatosReservadetallecliente();
	});
	$('#btnFiltroReservadetallecliente').click(function(){
		RecolectarDatosReservadetallecliente();
		EnviarInformacionReservadetallecliente('leer', NuevoReservadetallecliente, false);
	});
	function Paginado(pag) {
		RecolectarDatosReservadetallecliente();
		EnviarInformacionReservadetallecliente('leer', NuevoReservadetallecliente, false, pag);
	}
	function RecolectarDatosReservadetallecliente(){
		NuevoReservadetallecliente = {
			idreservadetallecliente: $('#idreservadetallecliente').val().toUpperCase(),
			idreserva: $('#idreserva').val().toUpperCase(),
			idcliente: $('#idcliente').val().toUpperCase(),
			cantidad: $('#cantidad').val().toUpperCase(),
			precio: $('#precio').val().toUpperCase(),
			total: $('#total').val().toUpperCase(),
			confirmado: $('#confirmado').val().toUpperCase(),
			estado: $('#estado').val().toUpperCase(),
			todos: $('#idFTodos').val(),
			texto: $('#idFTexto').val()
		};
	}
	function EnviarInformacionReservadetallecliente(accion, objEvento, modal, pag=1) { 
		$.ajax({
			type: 'POST',
			url: base_url+'/reservadetallecliente/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				var resp = JSON.parse(msg);
				$('#PaginadoReservadetallecliente').empty();
				$('#PaginadoReservadetallecliente').append(resp.pag);
				if (modal) {
					$('#modalAgregarReservadetallecliente').modal('toggle');
					LimpiarModalDatosReservadetallecliente();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								CargartablaReservadetallecliente(resp.datos)
							}
						})
					} else {
						Swal.fire({
							title: resp.mensaje,
							icon: 'error'
						})
					}
				}else{
					CargartablaReservadetallecliente(resp.datos)
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
	function LimpiarModalDatosReservadetallecliente(){
		$('#idreservadetallecliente').val('0');
		$('#idreserva').select2().val(0).select2('destroy').select2();
		$('#idcliente').select2().val(0).select2('destroy').select2();
		$('#cantidad').val('0');
		$('#precio').val('');
		$('#total').val('');
	}
	function ValidarCamposVaciosReservadetallecliente(){
		var error = 0;
		var value = $('#idreservadetallecliente').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idreservadetallecliente');
			error++;
		}else{
			NoResaltado('idreservadetallecliente');
		}
		var value = $('#idreserva').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idreserva');
			error++;
		}else{
			NoResaltado('idreserva');
		}
		if ($('#idcliente').val() == ''){
			Resaltado('idcliente');
			error++;
		}else{
			NoResaltado('idcliente');
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
	function CargartablaReservadetallecliente(objeto){
		$('#TablaReservadetallecliente tr').not($('#TablaReservadetallecliente tr:first')).remove();
		$.each(objeto, function(i, value) {
				var fila = `<tr>
				<td hidden>${value.idreservadetallecliente}</td>
				<td>${value.cantidad}</td>
				<td>${value.precio}</td>
				<td>${value.total}</td>
				<td class = 'hidden-xs'>${value.confirmado == '1' ? 'CONFIRMADO' : 'PENDIENTE'}</td>
				<td class = 'hidden-xs'>${value.estado == '1' ? 'ACTIVO' : 'DESACTIVO'}</td>
				<td hidden>${value.idreserva}</td>
				<td>${value.reservanombre}</td>
				<td>${value.idcliente}</td>
				<td>${value.clientenombre}</td>
				<td hidden>${value.idtipodoc}</td>
				<td>${value.nombre}</td>
				<td>${value.concatenado}</td>
				<td>${value.concatenadodetalle}</td>
				<td>
				<div class='row'>
					<div style='margin: auto;'>
						<button type='button' onclick="btnEditarReservadetallecliente('${value.idreservadetallecliente}', '${value.idreserva}', '${value.idcliente}')" class='btn btn-info btn-xs'>
							<span class='fa fa-search fa-xs'></span>
						</button>
					</div>
						<div style='margin: auto;'>
							<a class='btn btn-success btn-xs' href='<?php echo base_url();?>/reserva/add/$reservadetallecliente['idreservadetallecliente'].'\',\''.$reservadetallecliente['idreserva'].'\',\''.$reservadetallecliente['idcliente']'><i class='fa fa-pencil'></i></a>
					</div>
				</div>
				</td>
				</tr>`
			$('#TablaReservadetallecliente tbody').append(fila);
		});
	}
</script>
