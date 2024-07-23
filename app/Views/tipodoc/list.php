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
								<button type='button' class='btn btn-info btn-sm' id='btnAgregarTipodoc'>
									<span class='fa fa-plus'></span> Agregar Tipodoc
								</button>
								<a href='<?php echo base_url();?>tipodoc/excel' class='btn btn-success btn-sm'>
									<span class='fa fa-file-excel'></span> Exportar
								</a>
								<a href='<?php echo base_url();?>tipodoc/pdf' target='_blank' class='btn btn-danger btn-sm'>
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
												<button type='button' class='btn btn-info btn-sm' id='btnFiltroTipodoc'>
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
							<table id='TablaTipodoc' class='table table-sm table-bordered table-striped'>
								<thead>
									<tr>
										<th hidden>Idtipodoc</th>
										<th>Nombre</th>
										<th>Estado</th>
										<th>Concatenado</th>
										<th>Concatenadodetalle</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $tipodoc):?>
											<tr>
												<td hidden><?php echo $tipodoc['idtipodoc'];?></td>
												<td><?php echo $tipodoc['nombre'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($tipodoc['estado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>
												<td><?php echo $tipodoc['concatenado'];?></td>
												<td><?php echo $tipodoc['concatenadodetalle'];?></td>
												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarTipodoc('<?php echo $tipodoc['idtipodoc'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-search fa-xs'></span>
															</button>
														</div>
														<div style='margin: auto;'>
															<a class='btn btn-success btn-xs' href="<?php echo base_url();?>reserva/add/<?php echo $tipodoc['idtipodoc'];?>"><i class='fa fa-pencil'></i></a>
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
						<div id='PaginadoTipodoc'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<!--  SECCION ====== MODAL ====== -->
<div class='modal fade' id='modalAgregarTipodoc' tabindex='-1'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title' id='modaldeltalletour'>Detalle Tipodoc</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<div class='col-6 form-group row'>
					<label class='col-sm-4'>Idtipodoc:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='idtipodoc' name='idtipodoc' placeholder='T001' autocomplete = 'off'>
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
			<button type='button' class='btn btn-success btn-sm' id='btnModalAgregarTipodoc'>Agregar</button>
			<button type='button' class='btn btn-warning btn-sm' id='btnModalEditarTipodoc'>Modificar</button>
			<button type='button' class='btn btn-danger btn-sm' id='btnModalEliminarTipodoc'>Eliminar</button>
			<button type='button' class='btn btn-primary btn-sm' id='btnModalCerrarTipodoc' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<!--  SECCION ====== SCRIPT ====== -->
<script>
	var NuevoTipodoc;
	var base_url= '<?php echo base_url();?>';
	function load(pag){
		RecolectarDatosTipodoc();
		EnviarInformacionTipodoc('leer', NuevoTipodoc, false, pag);
	}
	$('#btnAgregarTipodoc').click(function(){
		LimpiarModalDatosTipodoc();
		$('#categoria').val(1);
		$('#id').prop('readonly', false);  
		$('#IdModalGrupoCodigoHotel').prop('hidden', false);
		$('#btnModalAgregarTipodoc').toggle(true);
		$('#btnModalEditarTipodoc').toggle(false);
		$('#btnModalEliminarTipodoc').toggle(false);
		$('#modalAgregarTipodoc').modal();
	});
//   SECCION ====== btn Editar ======
	function btnEditarTipodoc(Val0){
		$.ajax({
			type: 'POST',
			url: base_url + '/tipodoc/edit',
			data: {idtipodoc: Val0},
			success: function(msg){
				debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosTipodoc();
				$('#idtipodoc').val(temp.idtipodoc);
				$('#nombre').val(temp.nombre);
				$('#estado').val(temp.estado);
				$('#btnModalAgregarTipodoc').toggle(false);
				$('#btnModalEditarTipodoc').toggle(true);
				$('#btnModalEliminarTipodoc').toggle(true);
				$('#modalAgregarTipodoc').modal('toggle');
			},
			error: function(){
				alert('Hay un error...');
			}
		});
	}
	$('#btnModalAgregarTipodoc').click(function(){
		debugger
		if (ValidarCamposVaciosTipodoc() != 0) {
			alert('Completar campos obligatorios');
		}else{
			$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
			RecolectarDatosTipodoc();
			EnviarInformacionTipodoc('agregar', NuevoTipodoc, true);
		}
	});
	$('#btnModalEditarTipodoc').click(function(){
		if (ValidarCamposVaciosTipodoc() != 0) {
			alert('Completar campos obligatorios');
		}else{
			RecolectarDatosTipodoc();
			EnviarInformacionTipodoc('modificar', NuevoTipodoc, true);
		}
	});
	$('#btnModalEliminarTipodoc').click(function(){
		var bool=confirm('ESTA SEGURO DE ELIMINAR EL DATO?');
		if(bool){
			RecolectarDatosTipodoc();
			EnviarInformacionTipodoc('eliminar', NuevoTipodoc, true);
		}
	});
	$('#btnModalCerrarHotel').click(function(){
		$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
		LimpiarModalDatosTipodoc();
	});
	$('#btnFiltroTipodoc').click(function(){
		RecolectarDatosTipodoc();
		EnviarInformacionTipodoc('leer', NuevoTipodoc, false);
	});
	function Paginado(pag) {
		RecolectarDatosTipodoc();
		EnviarInformacionTipodoc('leer', NuevoTipodoc, false, pag);
	}
	function RecolectarDatosTipodoc(){
		NuevoTipodoc = {
			idtipodoc: $('#idtipodoc').val().toUpperCase(),
			nombre: $('#nombre').val().toUpperCase(),
			estado: $('#estado').val().toUpperCase(),
			todos: $('#idFTodos').val(),
			texto: $('#idFTexto').val()
		};
	}
	function EnviarInformacionTipodoc(accion, objEvento, modal, pag=1) { 
		$.ajax({
			type: 'POST',
			url: base_url+'/tipodoc/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				var resp = JSON.parse(msg);
				$('#PaginadoTipodoc').empty();
				$('#PaginadoTipodoc').append(resp.pag);
				if (modal) {
					$('#modalAgregarTipodoc').modal('toggle');
					LimpiarModalDatosTipodoc();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								CargartablaTipodoc(resp.datos)
							}
						})
					} else {
						Swal.fire({
							title: resp.mensaje,
							icon: 'error'
						})
					}
				}else{
					CargartablaTipodoc(resp.datos)
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
	function LimpiarModalDatosTipodoc(){
		$('#idtipodoc').val('0');
		$('#nombre').val('');
	}
	function ValidarCamposVaciosTipodoc(){
		var error = 0;
		var value = $('#idtipodoc').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idtipodoc');
			error++;
		}else{
			NoResaltado('idtipodoc');
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
	function CargartablaTipodoc(objeto){
		$('#TablaTipodoc tr').not($('#TablaTipodoc tr:first')).remove();
		$.each(objeto, function(i, value) {
				var fila = `<tr>
				<td hidden>${value.idtipodoc}</td>
				<td>${value.nombre}</td>
				<td class = 'hidden-xs'>${value.estado == '1' ? 'ACTIVO' : 'DESACTIVO'}</td>
				<td>${value.concatenado}</td>
				<td>${value.concatenadodetalle}</td>
				<td>
				<div class='row'>
					<div style='margin: auto;'>
						<button type='button' onclick="btnEditarTipodoc('${value.idtipodoc}')" class='btn btn-info btn-xs'>
							<span class='fa fa-search fa-xs'></span>
						</button>
					</div>
						<div style='margin: auto;'>
							<a class='btn btn-success btn-xs' href='<?php echo base_url();?>/reserva/add/$tipodoc['idtipodoc']'><i class='fa fa-pencil'></i></a>
					</div>
				</div>
				</td>
				</tr>`
			$('#TablaTipodoc tbody').append(fila);
		});
	}
</script>
