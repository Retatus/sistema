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
								<button type='button' class='btn btn-info btn-sm' id='btnAgregarOtroservicio'>
									<span class='fa fa-plus'></span> Agregar Otroservicio
								</button>
								<a href='<?php echo base_url();?>otroservicio/excel' class='btn btn-success btn-sm'>
									<span class='fa fa-file-excel'></span> Exportar
								</a>
								<a href='<?php echo base_url();?>otroservicio/pdf' target='_blank' class='btn btn-danger btn-sm'>
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
												<button type='button' class='btn btn-info btn-sm' id='btnFiltroOtroservicio'>
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
							<table id='TablaOtroservicio' class='table table-sm table-bordered table-striped'>
								<thead>
									<tr>
										<th hidden>Idotroservicio</th>
										<th>Otroservicionombre</th>
										<th>Otroservicioprecio</th>
										<th>Otroservicioestado</th>
										<th>Concatenado</th>
										<th>Concatenadodetalle</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $otroservicio):?>
											<tr>
												<td hidden><?php echo $otroservicio['idotroservicio'];?></td>
												<td><?php echo $otroservicio['otroservicionombre'];?></td>
												<td><?php echo $otroservicio['otroservicioprecio'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($otroservicio['otroservicioestado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>
												<td><?php echo $otroservicio['concatenado'];?></td>
												<td><?php echo $otroservicio['concatenadodetalle'];?></td>
												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarOtroservicio('<?php echo $otroservicio['idotroservicio'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-search fa-xs'></span>
															</button>
														</div>
														<div style='margin: auto;'>
															<a class='btn btn-success btn-xs' href="<?php echo base_url();?>reserva/add/<?php echo $otroservicio['idotroservicio'];?>"><i class='fa fa-pencil'></i></a>
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
						<div id='PaginadoOtroservicio'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<!--  SECCION ====== MODAL ====== -->
<div class='modal fade' id='modalAgregarOtroservicio' tabindex='-1'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title' id='modaldeltalletour'>Detalle Otroservicio</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<div class='col-6 form-group row' hidden>
					<label class='col-sm-4'>Idotroservicio:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='idotroservicio' name='idotroservicio' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>Otroservicionombre:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='otroservicionombre' name='otroservicionombre' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>Otroservicioprecio:</label>
					<div class = 'col-sm-8'>
						<input type='number' class='form-control form-control-sm' id='otroservicioprecio' name='otroservicioprecio' placeholder='0.00' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='rol'>Otroservicioestado:</label>
					<div class='col-sm-8'>
						<select class='form-control form-control-sm' id='otroservicioestado' name='otroservicioestado'>
							<option value = '1' selected >ACTIVO</option>
							<option value = '0' >DESACTIVO</option>
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class='modal-footer'>
			<button type='button' class='btn btn-success btn-sm' id='btnModalAgregarOtroservicio'>Agregar</button>
			<button type='button' class='btn btn-warning btn-sm' id='btnModalEditarOtroservicio'>Modificar</button>
			<button type='button' class='btn btn-danger btn-sm' id='btnModalEliminarOtroservicio'>Eliminar</button>
			<button type='button' class='btn btn-primary btn-sm' id='btnModalCerrarOtroservicio' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<!--  SECCION ====== SCRIPT ====== -->
<script>
	var NuevoOtroservicio;
	var base_url= '<?php echo base_url();?>';
	function load(pag){
		RecolectarDatosOtroservicio();
		EnviarInformacionOtroservicio('leer', NuevoOtroservicio, false, pag);
	}
	$('#btnAgregarOtroservicio').click(function(){
		LimpiarModalDatosOtroservicio();
		$('#categoria').val(1);
		$('#id').prop('readonly', false);  
		$('#IdModalGrupoCodigoHotel').prop('hidden', false);
		$('#btnModalAgregarOtroservicio').toggle(true);
		$('#btnModalEditarOtroservicio').toggle(false);
		$('#btnModalEliminarOtroservicio').toggle(false);
		$('#modalAgregarOtroservicio').modal();
	});
//   SECCION ====== btn Editar ======
	function btnEditarOtroservicio(Val0){
		$.ajax({
			type: 'POST',
			url: base_url + '/otroservicio/edit',
			data: {idotroservicio: Val0},
			success: function(msg){
				debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosOtroservicio();
				$('#idotroservicio').val(temp.idotroservicio);
				$('#otroservicionombre').val(temp.otroservicionombre);
				$('#otroservicioprecio').val(temp.otroservicioprecio);
				$('#otroservicioestado').val(temp.otroservicioestado);
				$('#btnModalAgregarOtroservicio').toggle(false);
				$('#btnModalEditarOtroservicio').toggle(true);
				$('#btnModalEliminarOtroservicio').toggle(true);
				$('#modalAgregarOtroservicio').modal('toggle');
			},
			error: function(){
				alert('Hay un error...');
			}
		});
	}
	$('#btnModalAgregarOtroservicio').click(function(){
		debugger
		if (ValidarCamposVaciosOtroservicio() != 0) {
			alert('Completar campos obligatorios');
		}else{
			$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
			RecolectarDatosOtroservicio();
			EnviarInformacionOtroservicio('agregar', NuevoOtroservicio, true);
		}
	});
	$('#btnModalEditarOtroservicio').click(function(){
		if (ValidarCamposVaciosOtroservicio() != 0) {
			alert('Completar campos obligatorios');
		}else{
			RecolectarDatosOtroservicio();
			EnviarInformacionOtroservicio('modificar', NuevoOtroservicio, true);
		}
	});
	$('#btnModalEliminarOtroservicio').click(function(){
		var bool=confirm('ESTA SEGURO DE ELIMINAR EL DATO?');
		if(bool){
			RecolectarDatosOtroservicio();
			EnviarInformacionOtroservicio('eliminar', NuevoOtroservicio, true);
		}
	});
	$('#btnModalCerrarHotel').click(function(){
		$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
		LimpiarModalDatosOtroservicio();
	});
	$('#btnFiltroOtroservicio').click(function(){
		RecolectarDatosOtroservicio();
		EnviarInformacionOtroservicio('leer', NuevoOtroservicio, false);
	});
	function Paginado(pag) {
		RecolectarDatosOtroservicio();
		EnviarInformacionOtroservicio('leer', NuevoOtroservicio, false, pag);
	}
	function RecolectarDatosOtroservicio(){
		NuevoOtroservicio = {
			idotroservicio: $('#idotroservicio').val().toUpperCase(),
			otroservicionombre: $('#otroservicionombre').val().toUpperCase(),
			otroservicioprecio: $('#otroservicioprecio').val().toUpperCase(),
			otroservicioestado: $('#otroservicioestado').val().toUpperCase(),
			todos: $('#idFTodos').val(),
			texto: $('#idFTexto').val()
		};
	}
	function EnviarInformacionOtroservicio(accion, objEvento, modal, pag=1) { 
		$.ajax({
			type: 'POST',
			url: base_url+'/otroservicio/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				var resp = JSON.parse(msg);
				$('#PaginadoOtroservicio').empty();
				$('#PaginadoOtroservicio').append(resp.pag);
				if (modal) {
					$('#modalAgregarOtroservicio').modal('toggle');
					LimpiarModalDatosOtroservicio();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								CargartablaOtroservicio(resp.datos)
							}
						})
					} else {
						Swal.fire({
							title: resp.mensaje,
							icon: 'error'
						})
					}
				}else{
					CargartablaOtroservicio(resp.datos)
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
	function LimpiarModalDatosOtroservicio(){
		$('#idotroservicio').val('0');
		$('#otroservicionombre').val('');
		$('#otroservicioprecio').val('');
	}
	function ValidarCamposVaciosOtroservicio(){
		var error = 0;
		var value = $('#idotroservicio').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idotroservicio');
			error++;
		}else{
			NoResaltado('idotroservicio');
		}
		if ($('#otroservicionombre').val() == ''){
			Resaltado('otroservicionombre');
			error++;
		}else{
			NoResaltado('otroservicionombre');
		}
		if ($('#otroservicioprecio').val() == ''){
			Resaltado('otroservicioprecio');
			error++;
		}else{
			NoResaltado('otroservicioprecio');
		}
		if ($('#otroservicioestado').val() == ''){
			Resaltado('otroservicioestado');
			error++;
		}else{
			NoResaltado('otroservicioestado');
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
	function CargartablaOtroservicio(objeto){
		$('#TablaOtroservicio tr').not($('#TablaOtroservicio tr:first')).remove();
		$.each(objeto, function(i, value) {
				var fila = `<tr>
				<td hidden>${value.idotroservicio}</td>
				<td>${value.otroservicionombre}</td>
				<td>${value.otroservicioprecio}</td>
				<td class = 'hidden-xs'>${value.otroservicioestado == '1' ? 'ACTIVO' : 'DESACTIVO'}</td>
				<td>${value.concatenado}</td>
				<td>${value.concatenadodetalle}</td>
				<td>
				<div class='row'>
					<div style='margin: auto;'>
						<button type='button' onclick="btnEditarOtroservicio('${value.idotroservicio}')" class='btn btn-info btn-xs'>
							<span class='fa fa-search fa-xs'></span>
						</button>
					</div>
						<div style='margin: auto;'>
							<a class='btn btn-success btn-xs' href='<?php echo base_url();?>/reserva/add/$otroservicio['idotroservicio']'><i class='fa fa-pencil'></i></a>
					</div>
				</div>
				</td>
				</tr>`
			$('#TablaOtroservicio tbody').append(fila);
		});
	}
</script>
