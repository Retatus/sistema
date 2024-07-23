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
								<button type='button' class='btn btn-info btn-sm' id='btnAgregarClientetipo'>
									<span class='fa fa-plus'></span> Agregar Clientetipo
								</button>
								<a href='<?php echo base_url();?>clientetipo/excel' class='btn btn-success btn-sm'>
									<span class='fa fa-file-excel'></span> Exportar
								</a>
								<a href='<?php echo base_url();?>clientetipo/pdf' target='_blank' class='btn btn-danger btn-sm'>
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
												<button type='button' class='btn btn-info btn-sm' id='btnFiltroClientetipo'>
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
							<table id='TablaClientetipo' class='table table-sm table-bordered table-striped'>
								<thead>
									<tr>
										<th hidden>Idclientetipo</th>
										<th>Nombre</th>
										<th>Estado</th>
										<th>Concatenado</th>
										<th>Concatenadodetalle</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $clientetipo):?>
											<tr>
												<td hidden><?php echo $clientetipo['idclientetipo'];?></td>
												<td><?php echo $clientetipo['nombre'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($clientetipo['estado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>
												<td><?php echo $clientetipo['concatenado'];?></td>
												<td><?php echo $clientetipo['concatenadodetalle'];?></td>
												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarClientetipo('<?php echo $clientetipo['idclientetipo'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-search fa-xs'></span>
															</button>
														</div>
														<div style='margin: auto;'>
															<a class='btn btn-success btn-xs' href="<?php echo base_url();?>reserva/add/<?php echo $clientetipo['idclientetipo'];?>"><i class='fa fa-pencil'></i></a>
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
						<div id='PaginadoClientetipo'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<!--  SECCION ====== MODAL ====== -->
<div class='modal fade' id='modalAgregarClientetipo' tabindex='-1'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title' id='modaldeltalletour'>Detalle Clientetipo</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<div class='col-6 form-group row' hidden>
					<label class='col-sm-4'>Idclientetipo:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='idclientetipo' name='idclientetipo' placeholder='T001' autocomplete = 'off'>
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
			<button type='button' class='btn btn-success btn-sm' id='btnModalAgregarClientetipo'>Agregar</button>
			<button type='button' class='btn btn-warning btn-sm' id='btnModalEditarClientetipo'>Modificar</button>
			<button type='button' class='btn btn-danger btn-sm' id='btnModalEliminarClientetipo'>Eliminar</button>
			<button type='button' class='btn btn-primary btn-sm' id='btnModalCerrarClientetipo' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<!--  SECCION ====== SCRIPT ====== -->
<script>
	var NuevoClientetipo;
	var base_url= '<?php echo base_url();?>';
	function load(pag){
		RecolectarDatosClientetipo();
		EnviarInformacionClientetipo('leer', NuevoClientetipo, false, pag);
	}
	$('#btnAgregarClientetipo').click(function(){
		LimpiarModalDatosClientetipo();
		$('#categoria').val(1);
		$('#id').prop('readonly', false);  
		$('#IdModalGrupoCodigoHotel').prop('hidden', false);
		$('#btnModalAgregarClientetipo').toggle(true);
		$('#btnModalEditarClientetipo').toggle(false);
		$('#btnModalEliminarClientetipo').toggle(false);
		$('#modalAgregarClientetipo').modal();
	});
//   SECCION ====== btn Editar ======
	function btnEditarClientetipo(Val0){
		$.ajax({
			type: 'POST',
			url: base_url + '/clientetipo/edit',
			data: {idclientetipo: Val0},
			success: function(msg){
				debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosClientetipo();
				$('#idclientetipo').val(temp.idclientetipo);
				$('#nombre').val(temp.nombre);
				$('#estado').val(temp.estado);
				$('#btnModalAgregarClientetipo').toggle(false);
				$('#btnModalEditarClientetipo').toggle(true);
				$('#btnModalEliminarClientetipo').toggle(true);
				$('#modalAgregarClientetipo').modal('toggle');
			},
			error: function(){
				alert('Hay un error...');
			}
		});
	}
	$('#btnModalAgregarClientetipo').click(function(){
		debugger
		if (ValidarCamposVaciosClientetipo() != 0) {
			alert('Completar campos obligatorios');
		}else{
			$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
			RecolectarDatosClientetipo();
			EnviarInformacionClientetipo('agregar', NuevoClientetipo, true);
		}
	});
	$('#btnModalEditarClientetipo').click(function(){
		if (ValidarCamposVaciosClientetipo() != 0) {
			alert('Completar campos obligatorios');
		}else{
			RecolectarDatosClientetipo();
			EnviarInformacionClientetipo('modificar', NuevoClientetipo, true);
		}
	});
	$('#btnModalEliminarClientetipo').click(function(){
		var bool=confirm('ESTA SEGURO DE ELIMINAR EL DATO?');
		if(bool){
			RecolectarDatosClientetipo();
			EnviarInformacionClientetipo('eliminar', NuevoClientetipo, true);
		}
	});
	$('#btnModalCerrarHotel').click(function(){
		$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
		LimpiarModalDatosClientetipo();
	});
	$('#btnFiltroClientetipo').click(function(){
		RecolectarDatosClientetipo();
		EnviarInformacionClientetipo('leer', NuevoClientetipo, false);
	});
	function Paginado(pag) {
		RecolectarDatosClientetipo();
		EnviarInformacionClientetipo('leer', NuevoClientetipo, false, pag);
	}
	function RecolectarDatosClientetipo(){
		NuevoClientetipo = {
			idclientetipo: $('#idclientetipo').val().toUpperCase(),
			nombre: $('#nombre').val().toUpperCase(),
			estado: $('#estado').val().toUpperCase(),
			todos: $('#idFTodos').val(),
			texto: $('#idFTexto').val()
		};
	}
	function EnviarInformacionClientetipo(accion, objEvento, modal, pag=1) { 
		$.ajax({
			type: 'POST',
			url: base_url+'/clientetipo/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				var resp = JSON.parse(msg);
				$('#PaginadoClientetipo').empty();
				$('#PaginadoClientetipo').append(resp.pag);
				if (modal) {
					$('#modalAgregarClientetipo').modal('toggle');
					LimpiarModalDatosClientetipo();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								CargartablaClientetipo(resp.datos)
							}
						})
					} else {
						Swal.fire({
							title: resp.mensaje,
							icon: 'error'
						})
					}
				}else{
					CargartablaClientetipo(resp.datos)
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
	function LimpiarModalDatosClientetipo(){
		$('#idclientetipo').val('0');
		$('#nombre').val('');
	}
	function ValidarCamposVaciosClientetipo(){
		var error = 0;
		var value = $('#idclientetipo').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idclientetipo');
			error++;
		}else{
			NoResaltado('idclientetipo');
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
	function CargartablaClientetipo(objeto){
		$('#TablaClientetipo tr').not($('#TablaClientetipo tr:first')).remove();
		$.each(objeto, function(i, value) {
				var fila = `<tr>
				<td hidden>${value.idclientetipo}</td>
				<td>${value.nombre}</td>
				<td class = 'hidden-xs'>${value.estado == '1' ? 'ACTIVO' : 'DESACTIVO'}</td>
				<td>${value.concatenado}</td>
				<td>${value.concatenadodetalle}</td>
				<td>
				<div class='row'>
					<div style='margin: auto;'>
						<button type='button' onclick="btnEditarClientetipo('${value.idclientetipo}')" class='btn btn-info btn-xs'>
							<span class='fa fa-search fa-xs'></span>
						</button>
					</div>
						<div style='margin: auto;'>
							<a class='btn btn-success btn-xs' href='<?php echo base_url();?>/reserva/add/$clientetipo['idclientetipo']'><i class='fa fa-pencil'></i></a>
					</div>
				</div>
				</td>
				</tr>`
			$('#TablaClientetipo tbody').append(fila);
		});
	}
</script>
