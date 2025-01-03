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
								<button type='button' class='btn btn-info btn-sm' id='btnAgregarHorarioticketmapi'>
									<span class='fa fa-plus'></span> Agregar Horarioticketmapi
								</button>
								<a href='<?php echo base_url();?>horarioticketmapi/excel' class='btn btn-success btn-sm'>
									<span class='fa fa-file-excel'></span> Exportar
								</a>
								<a href='<?php echo base_url();?>horarioticketmapi/pdf' target='_blank' class='btn btn-danger btn-sm'>
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
												<button type='button' class='btn btn-info btn-sm' id='btnFiltroHorarioticketmapi'>
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
							<table id='TablaHorarioticketmapi' class='table table-sm table-bordered table-striped'>
								<thead>
									<tr>
										<th hidden>Idhorarioticketmapi</th>
										<th>Precio</th>
										<th>Estado</th>
										<th hidden>Idclientetipo</th>
										<th>Nombre</th>
										<th hidden>Idhoraticketmapi</th>
										<th>Nombre</th>
										<th hidden>Idticketmapi</th>
										<th>Nombre</th>
										<th>Concatenado</th>
										<th>Concatenadodetalle</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $horarioticketmapi):?>
											<tr>
												<td hidden><?php echo $horarioticketmapi['idhorarioticketmapi'];?></td>
												<td><?php echo $horarioticketmapi['precio'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($horarioticketmapi['estado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>
												<td hidden><?php echo $horarioticketmapi['idclientetipo'];?></td>
												<td><?php echo $horarioticketmapi['nombre'];?></td>
												<td hidden><?php echo $horarioticketmapi['idhoraticketmapi'];?></td>
												<td><?php echo $horarioticketmapi['nombre'];?></td>
												<td hidden><?php echo $horarioticketmapi['idticketmapi'];?></td>
												<td><?php echo $horarioticketmapi['nombre'];?></td>
												<td><?php echo $horarioticketmapi['concatenado'];?></td>
												<td><?php echo $horarioticketmapi['concatenadodetalle'];?></td>
												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarHorarioticketmapi('<?php echo $horarioticketmapi['idhorarioticketmapi'].'\',\''.$horarioticketmapi['idhoraticketmapi'].'\',\''.$horarioticketmapi['idticketmapi'].'\',\''.$horarioticketmapi['idclientetipo'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-search fa-xs'></span>
															</button>
														</div>
														<div style='margin: auto;'>
															<a class='btn btn-success btn-xs' href="<?php echo base_url();?>reserva/add/<?php echo $horarioticketmapi['idhorarioticketmapi'].'\',\''.$horarioticketmapi['idhoraticketmapi'].'\',\''.$horarioticketmapi['idticketmapi'].'\',\''.$horarioticketmapi['idclientetipo'];?>"><i class='fa fa-pencil'></i></a>
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
						<div id='PaginadoHorarioticketmapi'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<!--  SECCION ====== MODAL ====== -->
<div class='modal fade' id='modalAgregarHorarioticketmapi' tabindex='-1'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title' id='modaldeltalletour'>Detalle Horarioticketmapi</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<div class='col-6 form-group row'>
					<label class='col-sm-4'>Idhorarioticketmapi:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='idhorarioticketmapi' name='idhorarioticketmapi' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4'>Horaticketmapi:</label>
					<div class = 'col-sm-8'>
						<select class='form-control form-control-sm select2' id='idhoraticketmapi'>
							<option value='0'>-- SELECCIONAR1 --</option>
							<?php if (!empty($horaticketmapis)):?>
								<?php foreach($horaticketmapis as $horaticketmapi):?>
									<option value= '<?php echo $horaticketmapi['idhoraticketmapi'];?>'><?php echo $horaticketmapi['concatenado'];?></option>
								<?php endforeach;?>
							<?php endif;?>
						</select>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4'>Ticketmapi:</label>
					<div class = 'col-sm-8'>
						<select class='form-control form-control-sm select2' id='idticketmapi'>
							<option value='0'>-- SELECCIONAR1 --</option>
							<?php if (!empty($ticketmapis)):?>
								<?php foreach($ticketmapis as $ticketmapi):?>
									<option value= '<?php echo $ticketmapi['idticketmapi'];?>'><?php echo $ticketmapi['concatenado'];?></option>
								<?php endforeach;?>
							<?php endif;?>
						</select>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4'>Clientetipo:</label>
					<div class = 'col-sm-8'>
						<select class='form-control form-control-sm select2' id='idclientetipo'>
							<option value='0'>-- SELECCIONAR1 --</option>
							<?php if (!empty($clientetipos)):?>
								<?php foreach($clientetipos as $clientetipo):?>
									<option value= '<?php echo $clientetipo['idclientetipo'];?>'><?php echo $clientetipo['concatenado'];?></option>
								<?php endforeach;?>
							<?php endif;?>
						</select>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>Precio:</label>
					<div class = 'col-sm-8'>
						<input type='number' class='form-control form-control-sm' id='precio' name='precio' placeholder='0.00' autocomplete = 'off'>
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
			<button type='button' class='btn btn-success btn-sm' id='btnModalAgregarHorarioticketmapi'>Agregar</button>
			<button type='button' class='btn btn-warning btn-sm' id='btnModalEditarHorarioticketmapi'>Modificar</button>
			<button type='button' class='btn btn-danger btn-sm' id='btnModalEliminarHorarioticketmapi'>Eliminar</button>
			<button type='button' class='btn btn-primary btn-sm' id='btnModalCerrarHorarioticketmapi' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<!--  SECCION ====== SCRIPT ====== -->
<script>
	var NuevoHorarioticketmapi;
	var base_url= '<?php echo base_url();?>';
	function load(pag){
		RecolectarDatosHorarioticketmapi();
		EnviarInformacionHorarioticketmapi('leer', NuevoHorarioticketmapi, false, pag);
	}
	$('#btnAgregarHorarioticketmapi').click(function(){
		LimpiarModalDatosHorarioticketmapi();
		$('#categoria').val(1);
		$('#id').prop('readonly', false);  
		$('#IdModalGrupoCodigoHotel').prop('hidden', false);
		$('#btnModalAgregarHorarioticketmapi').toggle(true);
		$('#btnModalEditarHorarioticketmapi').toggle(false);
		$('#btnModalEliminarHorarioticketmapi').toggle(false);
		$('#modalAgregarHorarioticketmapi').modal();
	});
//   SECCION ====== btn Editar ======
	function btnEditarHorarioticketmapi(Val0, Val1, Val2, Val3){
		$.ajax({
			type: 'POST',
			url: base_url + '/horarioticketmapi/edit',
			data: {idhorarioticketmapi: Val0, idhoraticketmapi: Val1, idticketmapi: Val2, idclientetipo: Val3},
			success: function(msg){
				debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosHorarioticketmapi();
				$('#idhorarioticketmapi').val(temp.idhorarioticketmapi);
				$('#idhoraticketmapi').select2().val(temp.idhoraticketmapi).select2('destroy').select2();
				$('#idticketmapi').select2().val(temp.idticketmapi).select2('destroy').select2();
				$('#idclientetipo').select2().val(temp.idclientetipo).select2('destroy').select2();
				$('#precio').val(temp.precio);
				$('#estado').val(temp.estado);
				$('#btnModalAgregarHorarioticketmapi').toggle(false);
				$('#btnModalEditarHorarioticketmapi').toggle(true);
				$('#btnModalEliminarHorarioticketmapi').toggle(true);
				$('#modalAgregarHorarioticketmapi').modal('toggle');
			},
			error: function(){
				alert('Hay un error...');
			}
		});
	}
	$('#btnModalAgregarHorarioticketmapi').click(function(){
		debugger
		if (ValidarCamposVaciosHorarioticketmapi() != 0) {
			alert('Completar campos obligatorios');
		}else{
			$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
			RecolectarDatosHorarioticketmapi();
			EnviarInformacionHorarioticketmapi('agregar', NuevoHorarioticketmapi, true);
		}
	});
	$('#btnModalEditarHorarioticketmapi').click(function(){
		if (ValidarCamposVaciosHorarioticketmapi() != 0) {
			alert('Completar campos obligatorios');
		}else{
			RecolectarDatosHorarioticketmapi();
			EnviarInformacionHorarioticketmapi('modificar', NuevoHorarioticketmapi, true);
		}
	});
	$('#btnModalEliminarHorarioticketmapi').click(function(){
		var bool=confirm('ESTA SEGURO DE ELIMINAR EL DATO?');
		if(bool){
			RecolectarDatosHorarioticketmapi();
			EnviarInformacionHorarioticketmapi('eliminar', NuevoHorarioticketmapi, true);
		}
	});
	$('#btnModalCerrarHotel').click(function(){
		$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
		LimpiarModalDatosHorarioticketmapi();
	});
	$('#btnFiltroHorarioticketmapi').click(function(){
		RecolectarDatosHorarioticketmapi();
		EnviarInformacionHorarioticketmapi('leer', NuevoHorarioticketmapi, false);
	});
	function Paginado(pag) {
		RecolectarDatosHorarioticketmapi();
		EnviarInformacionHorarioticketmapi('leer', NuevoHorarioticketmapi, false, pag);
	}
	function RecolectarDatosHorarioticketmapi(){
		NuevoHorarioticketmapi = {
			idhorarioticketmapi: $('#idhorarioticketmapi').val().toUpperCase(),
			idhoraticketmapi: $('#idhoraticketmapi').val().toUpperCase(),
			idticketmapi: $('#idticketmapi').val().toUpperCase(),
			idclientetipo: $('#idclientetipo').val().toUpperCase(),
			precio: $('#precio').val().toUpperCase(),
			estado: $('#estado').val().toUpperCase(),
			todos: $('#idFTodos').val(),
			texto: $('#idFTexto').val()
		};
	}
	function EnviarInformacionHorarioticketmapi(accion, objEvento, modal, pag=1) { 
		$.ajax({
			type: 'POST',
			url: base_url+'/horarioticketmapi/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				var resp = JSON.parse(msg);
				$('#PaginadoHorarioticketmapi').empty();
				$('#PaginadoHorarioticketmapi').append(resp.pag);
				if (modal) {
					$('#modalAgregarHorarioticketmapi').modal('toggle');
					LimpiarModalDatosHorarioticketmapi();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								CargartablaHorarioticketmapi(resp.datos)
							}
						})
					} else {
						Swal.fire({
							title: resp.mensaje,
							icon: 'error'
						})
					}
				}else{
					CargartablaHorarioticketmapi(resp.datos)
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
	function LimpiarModalDatosHorarioticketmapi(){
		$('#idhorarioticketmapi').val('0');
		$('#idhoraticketmapi').select2().val(0).select2('destroy').select2();
		$('#idticketmapi').select2().val(0).select2('destroy').select2();
		$('#idclientetipo').select2().val(0).select2('destroy').select2();
		$('#precio').val('');
	}
	function ValidarCamposVaciosHorarioticketmapi(){
		var error = 0;
		var value = $('#idhorarioticketmapi').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idhorarioticketmapi');
			error++;
		}else{
			NoResaltado('idhorarioticketmapi');
		}
		var value = $('#idhoraticketmapi').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idhoraticketmapi');
			error++;
		}else{
			NoResaltado('idhoraticketmapi');
		}
		var value = $('#idticketmapi').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idticketmapi');
			error++;
		}else{
			NoResaltado('idticketmapi');
		}
		var value = $('#idclientetipo').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idclientetipo');
			error++;
		}else{
			NoResaltado('idclientetipo');
		}
		if ($('#precio').val() == ''){
			Resaltado('precio');
			error++;
		}else{
			NoResaltado('precio');
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
	function CargartablaHorarioticketmapi(objeto){
		$('#TablaHorarioticketmapi tr').not($('#TablaHorarioticketmapi tr:first')).remove();
		$.each(objeto, function(i, value) {
				var fila = `<tr>
				<td hidden>${value.idhorarioticketmapi}</td>
				<td>${value.precio}</td>
				<td class = 'hidden-xs'>${value.estado == '1' ? 'ACTIVO' : 'DESACTIVO'}</td>
				<td hidden>${value.idclientetipo}</td>
				<td>${value.nombre}</td>
				<td hidden>${value.idhoraticketmapi}</td>
				<td>${value.nombre}</td>
				<td hidden>${value.idticketmapi}</td>
				<td>${value.nombre}</td>
				<td>${value.concatenado}</td>
				<td>${value.concatenadodetalle}</td>
				<td>
				<div class='row'>
					<div style='margin: auto;'>
						<button type='button' onclick="btnEditarHorarioticketmapi('${value.idhorarioticketmapi}', '${value.idhoraticketmapi}', '${value.idticketmapi}', '${value.idclientetipo}')" class='btn btn-info btn-xs'>
							<span class='fa fa-search fa-xs'></span>
						</button>
					</div>
						<div style='margin: auto;'>
							<a class='btn btn-success btn-xs' href='<?php echo base_url();?>/reserva/add/$horarioticketmapi['idhorarioticketmapi'].'\',\''.$horarioticketmapi['idhoraticketmapi'].'\',\''.$horarioticketmapi['idticketmapi'].'\',\''.$horarioticketmapi['idclientetipo']'><i class='fa fa-pencil'></i></a>
					</div>
				</div>
				</td>
				</tr>`
			$('#TablaHorarioticketmapi tbody').append(fila);
		});
	}
</script>
