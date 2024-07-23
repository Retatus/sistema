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
								<button type='button' class='btn btn-info btn-sm' id='btnAgregarHoraticketmapi'>
									<span class='fa fa-plus'></span> Agregar Horaticketmapi
								</button>
								<a href='<?php echo base_url();?>horaticketmapi/excel' class='btn btn-success btn-sm'>
									<span class='fa fa-file-excel'></span> Exportar
								</a>
								<a href='<?php echo base_url();?>horaticketmapi/pdf' target='_blank' class='btn btn-danger btn-sm'>
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
												<button type='button' class='btn btn-info btn-sm' id='btnFiltroHoraticketmapi'>
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
							<table id='TablaHoraticketmapi' class='table table-sm table-bordered table-striped'>
								<thead>
									<tr>
										<th hidden>Idhoraticketmapi</th>
										<th>Nombre</th>
										<th>Estado</th>
										<th>Concatenado</th>
										<th>Concatenadodetalle</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $horaticketmapi):?>
											<tr>
												<td hidden><?php echo $horaticketmapi['idhoraticketmapi'];?></td>
												<td><?php echo $horaticketmapi['nombre'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($horaticketmapi['estado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>
												<td><?php echo $horaticketmapi['concatenado'];?></td>
												<td><?php echo $horaticketmapi['concatenadodetalle'];?></td>
												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarHoraticketmapi('<?php echo $horaticketmapi['idhoraticketmapi'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-search fa-xs'></span>
															</button>
														</div>
														<div style='margin: auto;'>
															<a class='btn btn-success btn-xs' href="<?php echo base_url();?>reserva/add/<?php echo $horaticketmapi['idhoraticketmapi'];?>"><i class='fa fa-pencil'></i></a>
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
						<div id='PaginadoHoraticketmapi'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<!--  SECCION ====== MODAL ====== -->
<div class='modal fade' id='modalAgregarHoraticketmapi' tabindex='-1'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title' id='modaldeltalletour'>Detalle Horaticketmapi</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<div class='col-6 form-group row'>
					<label class='col-sm-4'>Idhoraticketmapi:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='idhoraticketmapi' name='idhoraticketmapi' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>Nombre:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='nombre' name='nombre' placeholder='T001' autocomplete = 'off'>
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
			<button type='button' class='btn btn-success btn-sm' id='btnModalAgregarHoraticketmapi'>Agregar</button>
			<button type='button' class='btn btn-warning btn-sm' id='btnModalEditarHoraticketmapi'>Modificar</button>
			<button type='button' class='btn btn-danger btn-sm' id='btnModalEliminarHoraticketmapi'>Eliminar</button>
			<button type='button' class='btn btn-primary btn-sm' id='btnModalCerrarHoraticketmapi' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<!--  SECCION ====== SCRIPT ====== -->
<script>
	var NuevoHoraticketmapi;
	var base_url= '<?php echo base_url();?>';
	function load(pag){
		RecolectarDatosHoraticketmapi();
		EnviarInformacionHoraticketmapi('leer', NuevoHoraticketmapi, false, pag);
	}
	$('#btnAgregarHoraticketmapi').click(function(){
		LimpiarModalDatosHoraticketmapi();
		$('#categoria').val(1);
		$('#id').prop('readonly', false);  
		$('#IdModalGrupoCodigoHotel').prop('hidden', false);
		$('#btnModalAgregarHoraticketmapi').toggle(true);
		$('#btnModalEditarHoraticketmapi').toggle(false);
		$('#btnModalEliminarHoraticketmapi').toggle(false);
		$('#modalAgregarHoraticketmapi').modal();
	});
//   SECCION ====== btn Editar ======
	function btnEditarHoraticketmapi(Val0){
		$.ajax({
			type: 'POST',
			url: base_url + '/horaticketmapi/edit',
			data: {idhoraticketmapi: Val0},
			success: function(msg){
				debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosHoraticketmapi();
				$('#idhoraticketmapi').val(temp.idhoraticketmapi);
				$('#nombre').val(temp.nombre);
				$('#estado').val(temp.estado);
				$('#btnModalAgregarHoraticketmapi').toggle(false);
				$('#btnModalEditarHoraticketmapi').toggle(true);
				$('#btnModalEliminarHoraticketmapi').toggle(true);
				$('#modalAgregarHoraticketmapi').modal('toggle');
			},
			error: function(){
				alert('Hay un error...');
			}
		});
	}
	$('#btnModalAgregarHoraticketmapi').click(function(){
		debugger
		if (ValidarCamposVaciosHoraticketmapi() != 0) {
			alert('Completar campos obligatorios');
		}else{
			$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
			RecolectarDatosHoraticketmapi();
			EnviarInformacionHoraticketmapi('agregar', NuevoHoraticketmapi, true);
		}
	});
	$('#btnModalEditarHoraticketmapi').click(function(){
		if (ValidarCamposVaciosHoraticketmapi() != 0) {
			alert('Completar campos obligatorios');
		}else{
			RecolectarDatosHoraticketmapi();
			EnviarInformacionHoraticketmapi('modificar', NuevoHoraticketmapi, true);
		}
	});
	$('#btnModalEliminarHoraticketmapi').click(function(){
		var bool=confirm('ESTA SEGURO DE ELIMINAR EL DATO?');
		if(bool){
			RecolectarDatosHoraticketmapi();
			EnviarInformacionHoraticketmapi('eliminar', NuevoHoraticketmapi, true);
		}
	});
	$('#btnModalCerrarHotel').click(function(){
		$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
		LimpiarModalDatosHoraticketmapi();
	});
	$('#btnFiltroHoraticketmapi').click(function(){
		RecolectarDatosHoraticketmapi();
		EnviarInformacionHoraticketmapi('leer', NuevoHoraticketmapi, false);
	});
	function Paginado(pag) {
		RecolectarDatosHoraticketmapi();
		EnviarInformacionHoraticketmapi('leer', NuevoHoraticketmapi, false, pag);
	}
	function RecolectarDatosHoraticketmapi(){
		NuevoHoraticketmapi = {
			idhoraticketmapi: $('#idhoraticketmapi').val().toUpperCase(),
			nombre: $('#nombre').val().toUpperCase(),
			estado: $('#estado').val().toUpperCase(),
			todos: $('#idFTodos').val(),
			texto: $('#idFTexto').val()
		};
	}
	function EnviarInformacionHoraticketmapi(accion, objEvento, modal, pag=1) { 
		$.ajax({
			type: 'POST',
			url: base_url+'/horaticketmapi/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				var resp = JSON.parse(msg);
				$('#PaginadoHoraticketmapi').empty();
				$('#PaginadoHoraticketmapi').append(resp.pag);
				if (modal) {
					$('#modalAgregarHoraticketmapi').modal('toggle');
					LimpiarModalDatosHoraticketmapi();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								CargartablaHoraticketmapi(resp.datos)
							}
						})
					} else {
						Swal.fire({
							title: resp.mensaje,
							icon: 'error'
						})
					}
				}else{
					CargartablaHoraticketmapi(resp.datos)
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
	function LimpiarModalDatosHoraticketmapi(){
		$('#idhoraticketmapi').val('0');
		$('#nombre').val('');
	}
	function ValidarCamposVaciosHoraticketmapi(){
		var error = 0;
		var value = $('#idhoraticketmapi').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idhoraticketmapi');
			error++;
		}else{
			NoResaltado('idhoraticketmapi');
		}
		if ($('#nombre').val() == ''){
			Resaltado('nombre');
			error++;
		}else{
			NoResaltado('nombre');
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
	function CargartablaHoraticketmapi(objeto){
		$('#TablaHoraticketmapi tr').not($('#TablaHoraticketmapi tr:first')).remove();
		$.each(objeto, function(i, value) {
				var fila = `<tr>
				<td hidden>${value.idhoraticketmapi}</td>
				<td>${value.nombre}</td>
				<td class = 'hidden-xs'>${value.estado == '1' ? 'ACTIVO' : 'DESACTIVO'}</td>
				<td>${value.concatenado}</td>
				<td>${value.concatenadodetalle}</td>
				<td>
				<div class='row'>
					<div style='margin: auto;'>
						<button type='button' onclick="btnEditarHoraticketmapi('${value.idhoraticketmapi}')" class='btn btn-info btn-xs'>
							<span class='fa fa-search fa-xs'></span>
						</button>
					</div>
						<div style='margin: auto;'>
							<a class='btn btn-success btn-xs' href='<?php echo base_url();?>/reserva/add/$horaticketmapi['idhoraticketmapi']'><i class='fa fa-pencil'></i></a>
					</div>
				</div>
				</td>
				</tr>`
			$('#TablaHoraticketmapi tbody').append(fila);
		});
	}
</script>
