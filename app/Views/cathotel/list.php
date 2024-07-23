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
								<button type='button' class='btn btn-info btn-sm' id='btnAgregarCathotel'>
									<span class='fa fa-plus'></span> Agregar Cathotel
								</button>
								<a href='<?php echo base_url();?>cathotel/excel' class='btn btn-success btn-sm'>
									<span class='fa fa-file-excel'></span> Exportar
								</a>
								<a href='<?php echo base_url();?>cathotel/pdf' target='_blank' class='btn btn-danger btn-sm'>
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
												<button type='button' class='btn btn-info btn-sm' id='btnFiltroCathotel'>
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
							<table id='TablaCathotel' class='table table-sm table-bordered table-striped'>
								<thead>
									<tr>
										<th hidden>Idcathotel</th>
										<th>Nombre</th>
										<th>Estado</th>
										<th>Concatenado</th>
										<th>Concatenadodetalle</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $cathotel):?>
											<tr>
												<td hidden><?php echo $cathotel['idcathotel'];?></td>
												<td><?php echo $cathotel['nombre'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($cathotel['estado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>
												<td><?php echo $cathotel['concatenado'];?></td>
												<td><?php echo $cathotel['concatenadodetalle'];?></td>
												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarCathotel('<?php echo $cathotel['idcathotel'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-search fa-xs'></span>
															</button>
														</div>
														<div style='margin: auto;'>
															<a class='btn btn-success btn-xs' href="<?php echo base_url();?>reserva/add/<?php echo $cathotel['idcathotel'];?>"><i class='fa fa-pencil'></i></a>
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
						<div id='PaginadoCathotel'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<!--  SECCION ====== MODAL ====== -->
<div class='modal fade' id='modalAgregarCathotel' tabindex='-1'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title' id='modaldeltalletour'>Detalle Cathotel</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<div class='col-6 form-group row'>
					<label class='col-sm-4'>Idcathotel:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='idcathotel' name='idcathotel' placeholder='T001' autocomplete = 'off'>
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
			<button type='button' class='btn btn-success btn-sm' id='btnModalAgregarCathotel'>Agregar</button>
			<button type='button' class='btn btn-warning btn-sm' id='btnModalEditarCathotel'>Modificar</button>
			<button type='button' class='btn btn-danger btn-sm' id='btnModalEliminarCathotel'>Eliminar</button>
			<button type='button' class='btn btn-primary btn-sm' id='btnModalCerrarCathotel' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<!--  SECCION ====== SCRIPT ====== -->
<script>
	var NuevoCathotel;
	var base_url= '<?php echo base_url();?>';
	function load(pag){
		RecolectarDatosCathotel();
		EnviarInformacionCathotel('leer', NuevoCathotel, false, pag);
	}
	$('#btnAgregarCathotel').click(function(){
		LimpiarModalDatosCathotel();
		$('#categoria').val(1);
		$('#id').prop('readonly', false);  
		$('#IdModalGrupoCodigoHotel').prop('hidden', false);
		$('#btnModalAgregarCathotel').toggle(true);
		$('#btnModalEditarCathotel').toggle(false);
		$('#btnModalEliminarCathotel').toggle(false);
		$('#modalAgregarCathotel').modal();
	});
//   SECCION ====== btn Editar ======
	function btnEditarCathotel(Val0){
		$.ajax({
			type: 'POST',
			url: base_url + '/cathotel/edit',
			data: {idcathotel: Val0},
			success: function(msg){
				debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosCathotel();
				$('#idcathotel').val(temp.idcathotel);
				$('#nombre').val(temp.nombre);
				$('#estado').val(temp.estado);
				$('#btnModalAgregarCathotel').toggle(false);
				$('#btnModalEditarCathotel').toggle(true);
				$('#btnModalEliminarCathotel').toggle(true);
				$('#modalAgregarCathotel').modal('toggle');
			},
			error: function(){
				alert('Hay un error...');
			}
		});
	}
	$('#btnModalAgregarCathotel').click(function(){
		debugger
		if (ValidarCamposVaciosCathotel() != 0) {
			alert('Completar campos obligatorios');
		}else{
			$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
			RecolectarDatosCathotel();
			EnviarInformacionCathotel('agregar', NuevoCathotel, true);
		}
	});
	$('#btnModalEditarCathotel').click(function(){
		if (ValidarCamposVaciosCathotel() != 0) {
			alert('Completar campos obligatorios');
		}else{
			RecolectarDatosCathotel();
			EnviarInformacionCathotel('modificar', NuevoCathotel, true);
		}
	});
	$('#btnModalEliminarCathotel').click(function(){
		var bool=confirm('ESTA SEGURO DE ELIMINAR EL DATO?');
		if(bool){
			RecolectarDatosCathotel();
			EnviarInformacionCathotel('eliminar', NuevoCathotel, true);
		}
	});
	$('#btnModalCerrarHotel').click(function(){
		$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
		LimpiarModalDatosCathotel();
	});
	$('#btnFiltroCathotel').click(function(){
		RecolectarDatosCathotel();
		EnviarInformacionCathotel('leer', NuevoCathotel, false);
	});
	function Paginado(pag) {
		RecolectarDatosCathotel();
		EnviarInformacionCathotel('leer', NuevoCathotel, false, pag);
	}
	function RecolectarDatosCathotel(){
		NuevoCathotel = {
			idcathotel: $('#idcathotel').val().toUpperCase(),
			nombre: $('#nombre').val().toUpperCase(),
			estado: $('#estado').val().toUpperCase(),
			todos: $('#idFTodos').val(),
			texto: $('#idFTexto').val()
		};
	}
	function EnviarInformacionCathotel(accion, objEvento, modal, pag=1) { 
		$.ajax({
			type: 'POST',
			url: base_url+'/cathotel/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				var resp = JSON.parse(msg);
				$('#PaginadoCathotel').empty();
				$('#PaginadoCathotel').append(resp.pag);
				if (modal) {
					$('#modalAgregarCathotel').modal('toggle');
					LimpiarModalDatosCathotel();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								CargartablaCathotel(resp.datos)
							}
						})
					} else {
						Swal.fire({
							title: resp.mensaje,
							icon: 'error'
						})
					}
				}else{
					CargartablaCathotel(resp.datos)
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
	function LimpiarModalDatosCathotel(){
		$('#idcathotel').val('0');
		$('#nombre').val('');
	}
	function ValidarCamposVaciosCathotel(){
		var error = 0;
		var value = $('#idcathotel').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idcathotel');
			error++;
		}else{
			NoResaltado('idcathotel');
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
	function CargartablaCathotel(objeto){
		$('#TablaCathotel tr').not($('#TablaCathotel tr:first')).remove();
		$.each(objeto, function(i, value) {
				var fila = `<tr>
				<td hidden>${value.idcathotel}</td>
				<td>${value.nombre}</td>
				<td class = 'hidden-xs'>${value.estado == '1' ? 'ACTIVO' : 'DESACTIVO'}</td>
				<td>${value.concatenado}</td>
				<td>${value.concatenadodetalle}</td>
				<td>
				<div class='row'>
					<div style='margin: auto;'>
						<button type='button' onclick="btnEditarCathotel('${value.idcathotel}')" class='btn btn-info btn-xs'>
							<span class='fa fa-search fa-xs'></span>
						</button>
					</div>
						<div style='margin: auto;'>
							<a class='btn btn-success btn-xs' href='<?php echo base_url();?>/reserva/add/$cathotel['idcathotel']'><i class='fa fa-pencil'></i></a>
					</div>
				</div>
				</td>
				</tr>`
			$('#TablaCathotel tbody').append(fila);
		});
	}
</script>
