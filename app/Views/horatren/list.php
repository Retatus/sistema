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
								<button type='button' class='btn btn-info btn-sm' id='btnAgregarHoratren'>
									<span class='fa fa-plus'></span> Agregar Horatren
								</button>
								<a href='<?php echo base_url();?>horatren/excel' class='btn btn-success btn-sm'>
									<span class='fa fa-file-excel'></span> Exportar
								</a>
								<a href='<?php echo base_url();?>horatren/pdf' target='_blank' class='btn btn-danger btn-sm'>
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
												<button type='button' class='btn btn-info btn-sm' id='btnFiltroHoratren'>
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
							<table id='TablaHoratren' class='table table-sm table-bordered table-striped'>
								<thead>
									<tr>
										<th hidden>Idhorario</th>
										<th>Nombre</th>
										<th>Descripcion</th>
										<th>Ida</th>
										<th>Estado</th>
										<th>Concatenado</th>
										<th>Concatenadodetalle</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $horatren):?>
											<tr>
												<td hidden><?php echo $horatren['idhorario'];?></td>
												<td><?php echo $horatren['nombre'];?></td>
												<td><?php echo $horatren['descripcion'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($horatren['ida']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>
												<td class = 'hidden-xs'><?php echo $est = ($horatren['estado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>
												<td><?php echo $horatren['concatenado'];?></td>
												<td><?php echo $horatren['concatenadodetalle'];?></td>
												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarHoratren('<?php echo $horatren['idhorario'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-search fa-xs'></span>
															</button>
														</div>
														<div style='margin: auto;'>
															<a class='btn btn-success btn-xs' href="<?php echo base_url();?>reserva/add/<?php echo $horatren['idhorario'];?>"><i class='fa fa-pencil'></i></a>
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
						<div id='PaginadoHoratren'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<!--  SECCION ====== MODAL ====== -->
<div class='modal fade' id='modalAgregarHoratren' tabindex='-1'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title' id='modaldeltalletour'>Detalle Horatren</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<div class='col-6 form-group row'>
					<label class='col-sm-4'>Idhorario:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='idhorario' name='idhorario' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>Nombre:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='nombre' name='nombre' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>Ida:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='ida' name='ida' placeholder='T001' autocomplete = 'off'>
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
			<button type='button' class='btn btn-success btn-sm' id='btnModalAgregarHoratren'>Agregar</button>
			<button type='button' class='btn btn-warning btn-sm' id='btnModalEditarHoratren'>Modificar</button>
			<button type='button' class='btn btn-danger btn-sm' id='btnModalEliminarHoratren'>Eliminar</button>
			<button type='button' class='btn btn-primary btn-sm' id='btnModalCerrarHoratren' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<!--  SECCION ====== SCRIPT ====== -->
<script>
	var NuevoHoratren;
	var base_url= '<?php echo base_url();?>';
	function load(pag){
		RecolectarDatosHoratren();
		EnviarInformacionHoratren('leer', NuevoHoratren, false, pag);
	}
	$('#btnAgregarHoratren').click(function(){
		LimpiarModalDatosHoratren();
		$('#categoria').val(1);
		$('#id').prop('readonly', false);  
		$('#IdModalGrupoCodigoHotel').prop('hidden', false);
		$('#btnModalAgregarHoratren').toggle(true);
		$('#btnModalEditarHoratren').toggle(false);
		$('#btnModalEliminarHoratren').toggle(false);
		$('#modalAgregarHoratren').modal();
	});
//   SECCION ====== btn Editar ======
	function btnEditarHoratren(Val0){
		$.ajax({
			type: 'POST',
			url: base_url + '/horatren/edit',
			data: {idhorario: Val0},
			success: function(msg){
				debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosHoratren();
				$('#idhorario').val(temp.idhorario);
				$('#nombre').val(temp.nombre);
				$('#descripcion').val(temp.descripcion);
				$('#ida').val(temp.ida);
				$('#estado').val(temp.estado);
				$('#btnModalAgregarHoratren').toggle(false);
				$('#btnModalEditarHoratren').toggle(true);
				$('#btnModalEliminarHoratren').toggle(true);
				$('#modalAgregarHoratren').modal('toggle');
			},
			error: function(){
				alert('Hay un error...');
			}
		});
	}
	$('#btnModalAgregarHoratren').click(function(){
		debugger
		if (ValidarCamposVaciosHoratren() != 0) {
			alert('Completar campos obligatorios');
		}else{
			$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
			RecolectarDatosHoratren();
			EnviarInformacionHoratren('agregar', NuevoHoratren, true);
		}
	});
	$('#btnModalEditarHoratren').click(function(){
		if (ValidarCamposVaciosHoratren() != 0) {
			alert('Completar campos obligatorios');
		}else{
			RecolectarDatosHoratren();
			EnviarInformacionHoratren('modificar', NuevoHoratren, true);
		}
	});
	$('#btnModalEliminarHoratren').click(function(){
		var bool=confirm('ESTA SEGURO DE ELIMINAR EL DATO?');
		if(bool){
			RecolectarDatosHoratren();
			EnviarInformacionHoratren('eliminar', NuevoHoratren, true);
		}
	});
	$('#btnModalCerrarHotel').click(function(){
		$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
		LimpiarModalDatosHoratren();
	});
	$('#btnFiltroHoratren').click(function(){
		RecolectarDatosHoratren();
		EnviarInformacionHoratren('leer', NuevoHoratren, false);
	});
	function Paginado(pag) {
		RecolectarDatosHoratren();
		EnviarInformacionHoratren('leer', NuevoHoratren, false, pag);
	}
	function RecolectarDatosHoratren(){
		NuevoHoratren = {
			idhorario: $('#idhorario').val().toUpperCase(),
			nombre: $('#nombre').val().toUpperCase(),
			descripcion: $('#descripcion').val().toUpperCase(),
			ida: $('#ida').val().toUpperCase(),
			estado: $('#estado').val().toUpperCase(),
			todos: $('#idFTodos').val(),
			texto: $('#idFTexto').val()
		};
	}
	function EnviarInformacionHoratren(accion, objEvento, modal, pag=1) { 
		$.ajax({
			type: 'POST',
			url: base_url+'/horatren/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				var resp = JSON.parse(msg);
				$('#PaginadoHoratren').empty();
				$('#PaginadoHoratren').append(resp.pag);
				if (modal) {
					$('#modalAgregarHoratren').modal('toggle');
					LimpiarModalDatosHoratren();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								CargartablaHoratren(resp.datos)
							}
						})
					} else {
						Swal.fire({
							title: resp.mensaje,
							icon: 'error'
						})
					}
				}else{
					CargartablaHoratren(resp.datos)
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
	function LimpiarModalDatosHoratren(){
		$('#idhorario').val('0');
		$('#nombre').val('');
		$('#descripcion').val('');
	}
	function ValidarCamposVaciosHoratren(){
		var error = 0;
		var value = $('#idhorario').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idhorario');
			error++;
		}else{
			NoResaltado('idhorario');
		}
		if ($('#nombre').val() == ''){
			Resaltado('nombre');
			error++;
		}else{
			NoResaltado('nombre');
		}
		if ($('#descripcion').val() == ''){
			Resaltado('descripcion');
			error++;
		}else{
			NoResaltado('descripcion');
		}
		if ($('#ida').val() == ''){
			Resaltado('ida');
			error++;
		}else{
			NoResaltado('ida');
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
	function CargartablaHoratren(objeto){
		$('#TablaHoratren tr').not($('#TablaHoratren tr:first')).remove();
		$.each(objeto, function(i, value) {
				var fila = `<tr>
				<td hidden>${value.idhorario}</td>
				<td>${value.nombre}</td>
				<td>${value.descripcion}</td>
				<td class = 'hidden-xs'>${value.ida == '1' ? 'ACTIVO' : 'DESACTIVO'}</td>
				<td class = 'hidden-xs'>${value.estado == '1' ? 'ACTIVO' : 'DESACTIVO'}</td>
				<td>${value.concatenado}</td>
				<td>${value.concatenadodetalle}</td>
				<td>
				<div class='row'>
					<div style='margin: auto;'>
						<button type='button' onclick="btnEditarHoratren('${value.idhorario}')" class='btn btn-info btn-xs'>
							<span class='fa fa-search fa-xs'></span>
						</button>
					</div>
						<div style='margin: auto;'>
							<a class='btn btn-success btn-xs' href='<?php echo base_url();?>/reserva/add/$horatren['idhorario']'><i class='fa fa-pencil'></i></a>
					</div>
				</div>
				</td>
				</tr>`
			$('#TablaHoratren tbody').append(fila);
		});
	}
</script>
