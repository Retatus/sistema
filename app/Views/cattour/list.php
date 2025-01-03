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
								<button type='button' class='btn btn-info btn-sm' id='btnAgregarCattour'>
									<span class='fa fa-plus'></span> Agregar Cattour
								</button>
								<a href='<?php echo base_url();?>cattour/excel' class='btn btn-success btn-sm'>
									<span class='fa fa-file-excel'></span> Exportar
								</a>
								<a href='<?php echo base_url();?>cattour/pdf' target='_blank' class='btn btn-danger btn-sm'>
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
												<button type='button' class='btn btn-info btn-sm' id='btnFiltroCattour'>
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
							<table id='TablaCattour' class='table table-sm table-bordered table-striped'>
								<thead>
									<tr>
										<th hidden>Idcattour</th>
										<th>Nombre</th>
										<th>Estado</th>
										<th>Concatenado</th>
										<th>Concatenadodetalle</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $cattour):?>
											<tr>
												<td hidden><?php echo $cattour['idcattour'];?></td>
												<td><?php echo $cattour['nombre'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($cattour['estado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>
												<td><?php echo $cattour['concatenado'];?></td>
												<td><?php echo $cattour['concatenadodetalle'];?></td>
												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarCattour('<?php echo $cattour['idcattour'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-search fa-xs'></span>
															</button>
														</div>
														<div style='margin: auto;'>
															<a class='btn btn-success btn-xs' href="<?php echo base_url();?>reserva/add/<?php echo $cattour['idcattour'];?>"><i class='fa fa-pencil'></i></a>
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
						<div id='PaginadoCattour'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<!--  SECCION ====== MODAL ====== -->
<div class='modal fade' id='modalAgregarCattour' tabindex='-1'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title' id='modaldeltalletour'>Detalle Cattour</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<div class='col-6 form-group row'>
					<label class='col-sm-4'>Idcattour:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='idcattour' name='idcattour' placeholder='T001' autocomplete = 'off'>
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
			<button type='button' class='btn btn-success btn-sm' id='btnModalAgregarCattour'>Agregar</button>
			<button type='button' class='btn btn-warning btn-sm' id='btnModalEditarCattour'>Modificar</button>
			<button type='button' class='btn btn-danger btn-sm' id='btnModalEliminarCattour'>Eliminar</button>
			<button type='button' class='btn btn-primary btn-sm' id='btnModalCerrarCattour' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<!--  SECCION ====== SCRIPT ====== -->
<script>
	var NuevoCattour;
	var base_url= '<?php echo base_url();?>';
	function load(pag){
		RecolectarDatosCattour();
		EnviarInformacionCattour('leer', NuevoCattour, false, pag);
	}
	$('#btnAgregarCattour').click(function(){
		LimpiarModalDatosCattour();
		$('#categoria').val(1);
		$('#id').prop('readonly', false);  
		$('#IdModalGrupoCodigoHotel').prop('hidden', false);
		$('#btnModalAgregarCattour').toggle(true);
		$('#btnModalEditarCattour').toggle(false);
		$('#btnModalEliminarCattour').toggle(false);
		$('#modalAgregarCattour').modal();
	});
//   SECCION ====== btn Editar ======
	function btnEditarCattour(Val0){
		$.ajax({
			type: 'POST',
			url: base_url + '/cattour/edit',
			data: {idcattour: Val0},
			success: function(msg){
				debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosCattour();
				$('#idcattour').val(temp.idcattour);
				$('#nombre').val(temp.nombre);
				$('#estado').val(temp.estado);
				$('#btnModalAgregarCattour').toggle(false);
				$('#btnModalEditarCattour').toggle(true);
				$('#btnModalEliminarCattour').toggle(true);
				$('#modalAgregarCattour').modal('toggle');
			},
			error: function(){
				alert('Hay un error...');
			}
		});
	}
	$('#btnModalAgregarCattour').click(function(){
		debugger
		if (ValidarCamposVaciosCattour() != 0) {
			alert('Completar campos obligatorios');
		}else{
			$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
			RecolectarDatosCattour();
			EnviarInformacionCattour('agregar', NuevoCattour, true);
		}
	});
	$('#btnModalEditarCattour').click(function(){
		if (ValidarCamposVaciosCattour() != 0) {
			alert('Completar campos obligatorios');
		}else{
			RecolectarDatosCattour();
			EnviarInformacionCattour('modificar', NuevoCattour, true);
		}
	});
	$('#btnModalEliminarCattour').click(function(){
		var bool=confirm('ESTA SEGURO DE ELIMINAR EL DATO?');
		if(bool){
			RecolectarDatosCattour();
			EnviarInformacionCattour('eliminar', NuevoCattour, true);
		}
	});
	$('#btnModalCerrarHotel').click(function(){
		$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
		LimpiarModalDatosCattour();
	});
	$('#btnFiltroCattour').click(function(){
		RecolectarDatosCattour();
		EnviarInformacionCattour('leer', NuevoCattour, false);
	});
	function Paginado(pag) {
		RecolectarDatosCattour();
		EnviarInformacionCattour('leer', NuevoCattour, false, pag);
	}
	function RecolectarDatosCattour(){
		NuevoCattour = {
			idcattour: $('#idcattour').val().toUpperCase(),
			nombre: $('#nombre').val().toUpperCase(),
			estado: $('#estado').val().toUpperCase(),
			todos: $('#idFTodos').val(),
			texto: $('#idFTexto').val()
		};
	}
	function EnviarInformacionCattour(accion, objEvento, modal, pag=1) { 
		$.ajax({
			type: 'POST',
			url: base_url+'/cattour/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				var resp = JSON.parse(msg);
				$('#PaginadoCattour').empty();
				$('#PaginadoCattour').append(resp.pag);
				if (modal) {
					$('#modalAgregarCattour').modal('toggle');
					LimpiarModalDatosCattour();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								CargartablaCattour(resp.datos)
							}
						})
					} else {
						Swal.fire({
							title: resp.mensaje,
							icon: 'error'
						})
					}
				}else{
					CargartablaCattour(resp.datos)
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
	function LimpiarModalDatosCattour(){
		$('#idcattour').val('0');
		$('#nombre').val('');
	}
	function ValidarCamposVaciosCattour(){
		var error = 0;
		var value = $('#idcattour').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idcattour');
			error++;
		}else{
			NoResaltado('idcattour');
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
	function CargartablaCattour(objeto){
		$('#TablaCattour tr').not($('#TablaCattour tr:first')).remove();
		$.each(objeto, function(i, value) {
				var fila = `<tr>
				<td hidden>${value.idcattour}</td>
				<td>${value.nombre}</td>
				<td class = 'hidden-xs'>${value.estado == '1' ? 'ACTIVO' : 'DESACTIVO'}</td>
				<td>${value.concatenado}</td>
				<td>${value.concatenadodetalle}</td>
				<td>
				<div class='row'>
					<div style='margin: auto;'>
						<button type='button' onclick="btnEditarCattour('${value.idcattour}')" class='btn btn-info btn-xs'>
							<span class='fa fa-search fa-xs'></span>
						</button>
					</div>
						<div style='margin: auto;'>
							<a class='btn btn-success btn-xs' href='<?php echo base_url();?>/reserva/add/$cattour['idcattour']'><i class='fa fa-pencil'></i></a>
					</div>
				</div>
				</td>
				</tr>`
			$('#TablaCattour tbody').append(fila);
		});
	}
</script>
