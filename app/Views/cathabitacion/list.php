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
								<button type='button' class='btn btn-info btn-sm' id='btnAgregarCathabitacion'>
									<span class='fa fa-plus'></span> Agregar Cathabitacion
								</button>
								<a href='<?php echo base_url();?>cathabitacion/excel' class='btn btn-success btn-sm'>
									<span class='fa fa-file-excel'></span> Exportar
								</a>
								<a href='<?php echo base_url();?>cathabitacion/pdf' target='_blank' class='btn btn-danger btn-sm'>
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
												<button type='button' class='btn btn-info btn-sm' id='btnFiltroCathabitacion'>
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
							<table id='TablaCathabitacion' class='table table-sm table-bordered table-striped'>
								<thead>
									<tr>
										<th hidden>Idcathabitacion</th>
										<th>Nombre</th>
										<th>Estado</th>
										<th>Concatenado</th>
										<th>Concatenadodetalle</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $cathabitacion):?>
											<tr>
												<td hidden><?php echo $cathabitacion['idcathabitacion'];?></td>
												<td><?php echo $cathabitacion['nombre'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($cathabitacion['estado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>
												<td><?php echo $cathabitacion['concatenado'];?></td>
												<td><?php echo $cathabitacion['concatenadodetalle'];?></td>
												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarCathabitacion('<?php echo $cathabitacion['idcathabitacion'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-search fa-xs'></span>
															</button>
														</div>
														<div style='margin: auto;'>
															<a class='btn btn-success btn-xs' href="<?php echo base_url();?>reserva/add/<?php echo $cathabitacion['idcathabitacion'];?>"><i class='fa fa-pencil'></i></a>
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
						<div id='PaginadoCathabitacion'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<!--  SECCION ====== MODAL ====== -->
<div class='modal fade' id='modalAgregarCathabitacion' tabindex='-1'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title' id='modaldeltalletour'>Detalle Cathabitacion</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<div class='col-6 form-group row'>
					<label class='col-sm-4'>Idcathabitacion:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='idcathabitacion' name='idcathabitacion' placeholder='T001' autocomplete = 'off'>
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
			<button type='button' class='btn btn-success btn-sm' id='btnModalAgregarCathabitacion'>Agregar</button>
			<button type='button' class='btn btn-warning btn-sm' id='btnModalEditarCathabitacion'>Modificar</button>
			<button type='button' class='btn btn-danger btn-sm' id='btnModalEliminarCathabitacion'>Eliminar</button>
			<button type='button' class='btn btn-primary btn-sm' id='btnModalCerrarCathabitacion' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<!--  SECCION ====== SCRIPT ====== -->
<script>
	var NuevoCathabitacion;
	var base_url= '<?php echo base_url();?>';
	function load(pag){
		RecolectarDatosCathabitacion();
		EnviarInformacionCathabitacion('leer', NuevoCathabitacion, false, pag);
	}
	$('#btnAgregarCathabitacion').click(function(){
		LimpiarModalDatosCathabitacion();
		$('#categoria').val(1);
		$('#id').prop('readonly', false);  
		$('#IdModalGrupoCodigoHotel').prop('hidden', false);
		$('#btnModalAgregarCathabitacion').toggle(true);
		$('#btnModalEditarCathabitacion').toggle(false);
		$('#btnModalEliminarCathabitacion').toggle(false);
		$('#modalAgregarCathabitacion').modal();
	});
//   SECCION ====== btn Editar ======
	function btnEditarCathabitacion(Val0){
		$.ajax({
			type: 'POST',
			url: base_url + '/cathabitacion/edit',
			data: {idcathabitacion: Val0},
			success: function(msg){
				debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosCathabitacion();
				$('#idcathabitacion').val(temp.idcathabitacion);
				$('#nombre').val(temp.nombre);
				$('#estado').val(temp.estado);
				$('#btnModalAgregarCathabitacion').toggle(false);
				$('#btnModalEditarCathabitacion').toggle(true);
				$('#btnModalEliminarCathabitacion').toggle(true);
				$('#modalAgregarCathabitacion').modal('toggle');
			},
			error: function(){
				alert('Hay un error...');
			}
		});
	}
	$('#btnModalAgregarCathabitacion').click(function(){
		debugger
		if (ValidarCamposVaciosCathabitacion() != 0) {
			alert('Completar campos obligatorios');
		}else{
			$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
			RecolectarDatosCathabitacion();
			EnviarInformacionCathabitacion('agregar', NuevoCathabitacion, true);
		}
	});
	$('#btnModalEditarCathabitacion').click(function(){
		if (ValidarCamposVaciosCathabitacion() != 0) {
			alert('Completar campos obligatorios');
		}else{
			RecolectarDatosCathabitacion();
			EnviarInformacionCathabitacion('modificar', NuevoCathabitacion, true);
		}
	});
	$('#btnModalEliminarCathabitacion').click(function(){
		var bool=confirm('ESTA SEGURO DE ELIMINAR EL DATO?');
		if(bool){
			RecolectarDatosCathabitacion();
			EnviarInformacionCathabitacion('eliminar', NuevoCathabitacion, true);
		}
	});
	$('#btnModalCerrarHotel').click(function(){
		$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
		LimpiarModalDatosCathabitacion();
	});
	$('#btnFiltroCathabitacion').click(function(){
		RecolectarDatosCathabitacion();
		EnviarInformacionCathabitacion('leer', NuevoCathabitacion, false);
	});
	function Paginado(pag) {
		RecolectarDatosCathabitacion();
		EnviarInformacionCathabitacion('leer', NuevoCathabitacion, false, pag);
	}
	function RecolectarDatosCathabitacion(){
		NuevoCathabitacion = {
			idcathabitacion: $('#idcathabitacion').val().toUpperCase(),
			nombre: $('#nombre').val().toUpperCase(),
			estado: $('#estado').val().toUpperCase(),
			todos: $('#idFTodos').val(),
			texto: $('#idFTexto').val()
		};
	}
	function EnviarInformacionCathabitacion(accion, objEvento, modal, pag=1) { 
		$.ajax({
			type: 'POST',
			url: base_url+'/cathabitacion/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				var resp = JSON.parse(msg);
				$('#PaginadoCathabitacion').empty();
				$('#PaginadoCathabitacion').append(resp.pag);
				if (modal) {
					$('#modalAgregarCathabitacion').modal('toggle');
					LimpiarModalDatosCathabitacion();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								CargartablaCathabitacion(resp.datos)
							}
						})
					} else {
						Swal.fire({
							title: resp.mensaje,
							icon: 'error'
						})
					}
				}else{
					CargartablaCathabitacion(resp.datos)
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
	function LimpiarModalDatosCathabitacion(){
		$('#idcathabitacion').val('0');
		$('#nombre').val('');
	}
	function ValidarCamposVaciosCathabitacion(){
		var error = 0;
		var value = $('#idcathabitacion').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idcathabitacion');
			error++;
		}else{
			NoResaltado('idcathabitacion');
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
	function CargartablaCathabitacion(objeto){
		$('#TablaCathabitacion tr').not($('#TablaCathabitacion tr:first')).remove();
		$.each(objeto, function(i, value) {
				var fila = `<tr>
				<td hidden>${value.idcathabitacion}</td>
				<td>${value.nombre}</td>
				<td class = 'hidden-xs'>${value.estado == '1' ? 'ACTIVO' : 'DESACTIVO'}</td>
				<td>${value.concatenado}</td>
				<td>${value.concatenadodetalle}</td>
				<td>
				<div class='row'>
					<div style='margin: auto;'>
						<button type='button' onclick="btnEditarCathabitacion('${value.idcathabitacion}')" class='btn btn-info btn-xs'>
							<span class='fa fa-search fa-xs'></span>
						</button>
					</div>
						<div style='margin: auto;'>
							<a class='btn btn-success btn-xs' href='<?php echo base_url();?>/reserva/add/$cathabitacion['idcathabitacion']'><i class='fa fa-pencil'></i></a>
					</div>
				</div>
				</td>
				</tr>`
			$('#TablaCathabitacion tbody').append(fila);
		});
	}
</script>
