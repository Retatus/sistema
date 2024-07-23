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
								<button type='button' class='btn btn-info btn-sm' id='btnAgregarTren'>
									<span class='fa fa-plus'></span> Agregar Tren
								</button>
								<a href='<?php echo base_url();?>tren/excel' class='btn btn-success btn-sm'>
									<span class='fa fa-file-excel'></span> Exportar
								</a>
								<a href='<?php echo base_url();?>tren/pdf' target='_blank' class='btn btn-danger btn-sm'>
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
												<button type='button' class='btn btn-info btn-sm' id='btnFiltroTren'>
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
							<table id='TablaTren' class='table table-sm table-bordered table-striped'>
								<thead>
									<tr>
										<th hidden>Idtren</th>
										<th>Nombre</th>
										<th>Empresa</th>
										<th>Estado</th>
										<th>Concatenado</th>
										<th>Concatenadodetalle</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $tren):?>
											<tr>
												<td hidden><?php echo $tren['idtren'];?></td>
												<td><?php echo $tren['nombre'];?></td>
												<td><?php echo $tren['empresa'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($tren['estado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>
												<td><?php echo $tren['concatenado'];?></td>
												<td><?php echo $tren['concatenadodetalle'];?></td>
												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarTren('<?php echo $tren['idtren'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-search fa-xs'></span>
															</button>
														</div>
														<div style='margin: auto;'>
															<a class='btn btn-success btn-xs' href="<?php echo base_url();?>reserva/add/<?php echo $tren['idtren'];?>"><i class='fa fa-pencil'></i></a>
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
						<div id='PaginadoTren'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<!--  SECCION ====== MODAL ====== -->
<div class='modal fade' id='modalAgregarTren' tabindex='-1'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title' id='modaldeltalletour'>Detalle Tren</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<div class='col-6 form-group row'>
					<label class='col-sm-4'>Idtren:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='idtren' name='idtren' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>Nombre:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='nombre' name='nombre' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>Empresa:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='empresa' name='empresa' placeholder='T001' autocomplete = 'off'>
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
			<button type='button' class='btn btn-success btn-sm' id='btnModalAgregarTren'>Agregar</button>
			<button type='button' class='btn btn-warning btn-sm' id='btnModalEditarTren'>Modificar</button>
			<button type='button' class='btn btn-danger btn-sm' id='btnModalEliminarTren'>Eliminar</button>
			<button type='button' class='btn btn-primary btn-sm' id='btnModalCerrarTren' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<!--  SECCION ====== SCRIPT ====== -->
<script>
	var NuevoTren;
	var base_url= '<?php echo base_url();?>';
	function load(pag){
		RecolectarDatosTren();
		EnviarInformacionTren('leer', NuevoTren, false, pag);
	}
	$('#btnAgregarTren').click(function(){
		LimpiarModalDatosTren();
		$('#categoria').val(1);
		$('#id').prop('readonly', false);  
		$('#IdModalGrupoCodigoHotel').prop('hidden', false);
		$('#btnModalAgregarTren').toggle(true);
		$('#btnModalEditarTren').toggle(false);
		$('#btnModalEliminarTren').toggle(false);
		$('#modalAgregarTren').modal();
	});
//   SECCION ====== btn Editar ======
	function btnEditarTren(Val0){
		$.ajax({
			type: 'POST',
			url: base_url + '/tren/edit',
			data: {idtren: Val0},
			success: function(msg){
				debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosTren();
				$('#idtren').val(temp.idtren);
				$('#nombre').val(temp.nombre);
				$('#empresa').val(temp.empresa);
				$('#estado').val(temp.estado);
				$('#btnModalAgregarTren').toggle(false);
				$('#btnModalEditarTren').toggle(true);
				$('#btnModalEliminarTren').toggle(true);
				$('#modalAgregarTren').modal('toggle');
			},
			error: function(){
				alert('Hay un error...');
			}
		});
	}
	$('#btnModalAgregarTren').click(function(){
		debugger
		if (ValidarCamposVaciosTren() != 0) {
			alert('Completar campos obligatorios');
		}else{
			$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
			RecolectarDatosTren();
			EnviarInformacionTren('agregar', NuevoTren, true);
		}
	});
	$('#btnModalEditarTren').click(function(){
		if (ValidarCamposVaciosTren() != 0) {
			alert('Completar campos obligatorios');
		}else{
			RecolectarDatosTren();
			EnviarInformacionTren('modificar', NuevoTren, true);
		}
	});
	$('#btnModalEliminarTren').click(function(){
		var bool=confirm('ESTA SEGURO DE ELIMINAR EL DATO?');
		if(bool){
			RecolectarDatosTren();
			EnviarInformacionTren('eliminar', NuevoTren, true);
		}
	});
	$('#btnModalCerrarHotel').click(function(){
		$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
		LimpiarModalDatosTren();
	});
	$('#btnFiltroTren').click(function(){
		RecolectarDatosTren();
		EnviarInformacionTren('leer', NuevoTren, false);
	});
	function Paginado(pag) {
		RecolectarDatosTren();
		EnviarInformacionTren('leer', NuevoTren, false, pag);
	}
	function RecolectarDatosTren(){
		NuevoTren = {
			idtren: $('#idtren').val().toUpperCase(),
			nombre: $('#nombre').val().toUpperCase(),
			empresa: $('#empresa').val().toUpperCase(),
			estado: $('#estado').val().toUpperCase(),
			todos: $('#idFTodos').val(),
			texto: $('#idFTexto').val()
		};
	}
	function EnviarInformacionTren(accion, objEvento, modal, pag=1) { 
		$.ajax({
			type: 'POST',
			url: base_url+'/tren/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				var resp = JSON.parse(msg);
				$('#PaginadoTren').empty();
				$('#PaginadoTren').append(resp.pag);
				if (modal) {
					$('#modalAgregarTren').modal('toggle');
					LimpiarModalDatosTren();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								CargartablaTren(resp.datos)
							}
						})
					} else {
						Swal.fire({
							title: resp.mensaje,
							icon: 'error'
						})
					}
				}else{
					CargartablaTren(resp.datos)
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
	function LimpiarModalDatosTren(){
		$('#idtren').val('0');
		$('#nombre').val('');
		$('#empresa').val('');
	}
	function ValidarCamposVaciosTren(){
		var error = 0;
		var value = $('#idtren').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idtren');
			error++;
		}else{
			NoResaltado('idtren');
		}
		if ($('#nombre').val() == ''){
			Resaltado('nombre');
			error++;
		}else{
			NoResaltado('nombre');
		}
		if ($('#empresa').val() == ''){
			Resaltado('empresa');
			error++;
		}else{
			NoResaltado('empresa');
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
	function CargartablaTren(objeto){
		$('#TablaTren tr').not($('#TablaTren tr:first')).remove();
		$.each(objeto, function(i, value) {
				var fila = `<tr>
				<td hidden>${value.idtren}</td>
				<td>${value.nombre}</td>
				<td>${value.empresa}</td>
				<td class = 'hidden-xs'>${value.estado == '1' ? 'ACTIVO' : 'DESACTIVO'}</td>
				<td>${value.concatenado}</td>
				<td>${value.concatenadodetalle}</td>
				<td>
				<div class='row'>
					<div style='margin: auto;'>
						<button type='button' onclick="btnEditarTren('${value.idtren}')" class='btn btn-info btn-xs'>
							<span class='fa fa-search fa-xs'></span>
						</button>
					</div>
						<div style='margin: auto;'>
							<a class='btn btn-success btn-xs' href='<?php echo base_url();?>/reserva/add/$tren['idtren']'><i class='fa fa-pencil'></i></a>
					</div>
				</div>
				</td>
				</tr>`
			$('#TablaTren tbody').append(fila);
		});
	}
</script>
