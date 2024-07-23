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
								<button type='button' class='btn btn-info btn-sm' id='btnAgregarHorariotren'>
									<span class='fa fa-plus'></span> Agregar Horariotren
								</button>
								<a href='<?php echo base_url();?>horariotren/excel' class='btn btn-success btn-sm'>
									<span class='fa fa-file-excel'></span> Exportar
								</a>
								<a href='<?php echo base_url();?>horariotren/pdf' target='_blank' class='btn btn-danger btn-sm'>
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
												<button type='button' class='btn btn-info btn-sm' id='btnFiltroHorariotren'>
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
							<table id='TablaHorariotren' class='table table-sm table-bordered table-striped'>
								<thead>
									<tr>
										<th hidden>Idhorariotren</th>
										<th>Precio</th>
										<th>Estado</th>
										<th hidden>Idhorario</th>
										<th>Nombre</th>
										<th hidden>Idtren</th>
										<th>Nombre</th>
										<th>Concatenado</th>
										<th>Concatenadodetalle</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $horariotren):?>
											<tr>
												<td hidden><?php echo $horariotren['idhorariotren'];?></td>
												<td><?php echo $horariotren['precio'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($horariotren['estado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>
												<td hidden><?php echo $horariotren['idhorario'];?></td>
												<td><?php echo $horariotren['nombre'];?></td>
												<td hidden><?php echo $horariotren['idtren'];?></td>
												<td><?php echo $horariotren['nombre'];?></td>
												<td><?php echo $horariotren['concatenado'];?></td>
												<td><?php echo $horariotren['concatenadodetalle'];?></td>
												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarHorariotren('<?php echo $horariotren['idhorariotren'].'\',\''.$horariotren['idtren'].'\',\''.$horariotren['idhorario'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-search fa-xs'></span>
															</button>
														</div>
														<div style='margin: auto;'>
															<a class='btn btn-success btn-xs' href="<?php echo base_url();?>reserva/add/<?php echo $horariotren['idhorariotren'].'\',\''.$horariotren['idtren'].'\',\''.$horariotren['idhorario'];?>"><i class='fa fa-pencil'></i></a>
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
						<div id='PaginadoHorariotren'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<!--  SECCION ====== MODAL ====== -->
<div class='modal fade' id='modalAgregarHorariotren' tabindex='-1'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title' id='modaldeltalletour'>Detalle Horariotren</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<div class='col-6 form-group row'>
					<label class='col-sm-4'>Idhorariotren:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='idhorariotren' name='idhorariotren' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4'>Tren:</label>
					<div class = 'col-sm-8'>
						<select class='form-control form-control-sm select2' id='idtren'>
							<option value='0'>-- SELECCIONAR1 --</option>
							<?php if (!empty($trens)):?>
								<?php foreach($trens as $tren):?>
									<option value= '<?php echo $tren['idtren'];?>'><?php echo $tren['concatenado'];?></option>
								<?php endforeach;?>
							<?php endif;?>
						</select>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4'>Horatren:</label>
					<div class = 'col-sm-8'>
						<select class='form-control form-control-sm select2' id='idhorario'>
							<option value='0'>-- SELECCIONAR1 --</option>
							<?php if (!empty($horatrens)):?>
								<?php foreach($horatrens as $horatren):?>
									<option value= '<?php echo $horatren['idhorario'];?>'><?php echo $horatren['concatenado'];?></option>
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
			<button type='button' class='btn btn-success btn-sm' id='btnModalAgregarHorariotren'>Agregar</button>
			<button type='button' class='btn btn-warning btn-sm' id='btnModalEditarHorariotren'>Modificar</button>
			<button type='button' class='btn btn-danger btn-sm' id='btnModalEliminarHorariotren'>Eliminar</button>
			<button type='button' class='btn btn-primary btn-sm' id='btnModalCerrarHorariotren' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<!--  SECCION ====== SCRIPT ====== -->
<script>
	var NuevoHorariotren;
	var base_url= '<?php echo base_url();?>';
	function load(pag){
		RecolectarDatosHorariotren();
		EnviarInformacionHorariotren('leer', NuevoHorariotren, false, pag);
	}
	$('#btnAgregarHorariotren').click(function(){
		LimpiarModalDatosHorariotren();
		$('#categoria').val(1);
		$('#id').prop('readonly', false);  
		$('#IdModalGrupoCodigoHotel').prop('hidden', false);
		$('#btnModalAgregarHorariotren').toggle(true);
		$('#btnModalEditarHorariotren').toggle(false);
		$('#btnModalEliminarHorariotren').toggle(false);
		$('#modalAgregarHorariotren').modal();
	});
//   SECCION ====== btn Editar ======
	function btnEditarHorariotren(Val0, Val1, Val2){
		$.ajax({
			type: 'POST',
			url: base_url + '/horariotren/edit',
			data: {idhorariotren: Val0, idtren: Val1, idhorario: Val2},
			success: function(msg){
				debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosHorariotren();
				$('#idhorariotren').val(temp.idhorariotren);
				$('#idtren').select2().val(temp.idtren).select2('destroy').select2();
				$('#idhorario').select2().val(temp.idhorario).select2('destroy').select2();
				$('#precio').val(temp.precio);
				$('#estado').val(temp.estado);
				$('#btnModalAgregarHorariotren').toggle(false);
				$('#btnModalEditarHorariotren').toggle(true);
				$('#btnModalEliminarHorariotren').toggle(true);
				$('#modalAgregarHorariotren').modal('toggle');
			},
			error: function(){
				alert('Hay un error...');
			}
		});
	}
	$('#btnModalAgregarHorariotren').click(function(){
		debugger
		if (ValidarCamposVaciosHorariotren() != 0) {
			alert('Completar campos obligatorios');
		}else{
			$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
			RecolectarDatosHorariotren();
			EnviarInformacionHorariotren('agregar', NuevoHorariotren, true);
		}
	});
	$('#btnModalEditarHorariotren').click(function(){
		if (ValidarCamposVaciosHorariotren() != 0) {
			alert('Completar campos obligatorios');
		}else{
			RecolectarDatosHorariotren();
			EnviarInformacionHorariotren('modificar', NuevoHorariotren, true);
		}
	});
	$('#btnModalEliminarHorariotren').click(function(){
		var bool=confirm('ESTA SEGURO DE ELIMINAR EL DATO?');
		if(bool){
			RecolectarDatosHorariotren();
			EnviarInformacionHorariotren('eliminar', NuevoHorariotren, true);
		}
	});
	$('#btnModalCerrarHotel').click(function(){
		$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
		LimpiarModalDatosHorariotren();
	});
	$('#btnFiltroHorariotren').click(function(){
		RecolectarDatosHorariotren();
		EnviarInformacionHorariotren('leer', NuevoHorariotren, false);
	});
	function Paginado(pag) {
		RecolectarDatosHorariotren();
		EnviarInformacionHorariotren('leer', NuevoHorariotren, false, pag);
	}
	function RecolectarDatosHorariotren(){
		NuevoHorariotren = {
			idhorariotren: $('#idhorariotren').val().toUpperCase(),
			idtren: $('#idtren').val().toUpperCase(),
			idhorario: $('#idhorario').val().toUpperCase(),
			precio: $('#precio').val().toUpperCase(),
			estado: $('#estado').val().toUpperCase(),
			todos: $('#idFTodos').val(),
			texto: $('#idFTexto').val()
		};
	}
	function EnviarInformacionHorariotren(accion, objEvento, modal, pag=1) { 
		$.ajax({
			type: 'POST',
			url: base_url+'/horariotren/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				var resp = JSON.parse(msg);
				$('#PaginadoHorariotren').empty();
				$('#PaginadoHorariotren').append(resp.pag);
				if (modal) {
					$('#modalAgregarHorariotren').modal('toggle');
					LimpiarModalDatosHorariotren();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								CargartablaHorariotren(resp.datos)
							}
						})
					} else {
						Swal.fire({
							title: resp.mensaje,
							icon: 'error'
						})
					}
				}else{
					CargartablaHorariotren(resp.datos)
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
	function LimpiarModalDatosHorariotren(){
		$('#idhorariotren').val('0');
		$('#idtren').select2().val(0).select2('destroy').select2();
		$('#idhorario').select2().val(0).select2('destroy').select2();
		$('#precio').val('');
	}
	function ValidarCamposVaciosHorariotren(){
		var error = 0;
		var value = $('#idhorariotren').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idhorariotren');
			error++;
		}else{
			NoResaltado('idhorariotren');
		}
		var value = $('#idtren').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idtren');
			error++;
		}else{
			NoResaltado('idtren');
		}
		var value = $('#idhorario').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idhorario');
			error++;
		}else{
			NoResaltado('idhorario');
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
	function CargartablaHorariotren(objeto){
		$('#TablaHorariotren tr').not($('#TablaHorariotren tr:first')).remove();
		$.each(objeto, function(i, value) {
				var fila = `<tr>
				<td hidden>${value.idhorariotren}</td>
				<td>${value.precio}</td>
				<td class = 'hidden-xs'>${value.estado == '1' ? 'ACTIVO' : 'DESACTIVO'}</td>
				<td hidden>${value.idhorario}</td>
				<td>${value.nombre}</td>
				<td hidden>${value.idtren}</td>
				<td>${value.nombre}</td>
				<td>${value.concatenado}</td>
				<td>${value.concatenadodetalle}</td>
				<td>
				<div class='row'>
					<div style='margin: auto;'>
						<button type='button' onclick="btnEditarHorariotren('${value.idhorariotren}', '${value.idtren}', '${value.idhorario}')" class='btn btn-info btn-xs'>
							<span class='fa fa-search fa-xs'></span>
						</button>
					</div>
						<div style='margin: auto;'>
							<a class='btn btn-success btn-xs' href='<?php echo base_url();?>/reserva/add/$horariotren['idhorariotren'].'\',\''.$horariotren['idtren'].'\',\''.$horariotren['idhorario']'><i class='fa fa-pencil'></i></a>
					</div>
				</div>
				</td>
				</tr>`
			$('#TablaHorariotren tbody').append(fila);
		});
	}
</script>
