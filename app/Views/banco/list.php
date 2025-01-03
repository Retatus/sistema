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
								<button type='button' class='btn btn-info btn-sm' id='btnAgregarBanco'>
									<span class='fa fa-plus'></span> Agregar Banco
								</button>
								<a href='<?php echo base_url();?>banco/excel' class='btn btn-success btn-sm'>
									<span class='fa fa-file-excel'></span> Exportar
								</a>
								<a href='<?php echo base_url();?>banco/pdf' target='_blank' class='btn btn-danger btn-sm'>
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
												<button type='button' class='btn btn-info btn-sm' id='btnFiltroBanco'>
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
							<table id='TablaBanco' class='table table-sm table-bordered table-striped'>
								<thead>
									<tr>
										<th hidden>Idbanco</th>
										<th>Nombre</th>
										<th>Estado</th>
										<th>Concatenado</th>
										<th>Concatenadodetalle</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $banco):?>
											<tr>
												<td hidden><?php echo $banco['idbanco'];?></td>
												<td><?php echo $banco['nombre'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($banco['estado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>
												<td><?php echo $banco['concatenado'];?></td>
												<td><?php echo $banco['concatenadodetalle'];?></td>
												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarBanco('<?php echo $banco['idbanco'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-search fa-xs'></span>
															</button>
														</div>
														<div style='margin: auto;'>
															<a class='btn btn-success btn-xs' href="<?php echo base_url();?>reserva/add/<?php echo $banco['idbanco'];?>"><i class='fa fa-pencil'></i></a>
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
						<div id='PaginadoBanco'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<!--  SECCION ====== MODAL ====== -->
<div class='modal fade' id='modalAgregarBanco' tabindex='-1'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title' id='modaldeltalletour'>Detalle Banco</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<div class='col-6 form-group row' hidden>
					<label class='col-sm-4'>Idbanco:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='idbanco' name='idbanco' placeholder='T001' autocomplete = 'off'>
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
			<button type='button' class='btn btn-success btn-sm' id='btnModalAgregarBanco'>Agregar</button>
			<button type='button' class='btn btn-warning btn-sm' id='btnModalEditarBanco'>Modificar</button>
			<button type='button' class='btn btn-danger btn-sm' id='btnModalEliminarBanco'>Eliminar</button>
			<button type='button' class='btn btn-primary btn-sm' id='btnModalCerrarBanco' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<!--  SECCION ====== SCRIPT ====== -->
<script>
	var NuevoBanco;
	var base_url= '<?php echo base_url();?>';
	function load(pag){
		RecolectarDatosBanco();
		EnviarInformacionBanco('leer', NuevoBanco, false, pag);
	}
	$('#btnAgregarBanco').click(function(){
		LimpiarModalDatosBanco();
		$('#categoria').val(1);
		$('#id').prop('readonly', false);  
		$('#IdModalGrupoCodigoHotel').prop('hidden', false);
		$('#btnModalAgregarBanco').toggle(true);
		$('#btnModalEditarBanco').toggle(false);
		$('#btnModalEliminarBanco').toggle(false);
		$('#modalAgregarBanco').modal();
	});
//   SECCION ====== btn Editar ======
	function btnEditarBanco(Val0){
		$.ajax({
			type: 'POST',
			url: base_url + '/banco/edit',
			data: {idbanco: Val0},
			success: function(msg){
				debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosBanco();
				$('#idbanco').val(temp.idbanco);
				$('#nombre').val(temp.nombre);
				$('#estado').val(temp.estado);
				$('#btnModalAgregarBanco').toggle(false);
				$('#btnModalEditarBanco').toggle(true);
				$('#btnModalEliminarBanco').toggle(true);
				$('#modalAgregarBanco').modal('toggle');
			},
			error: function(){
				alert('Hay un error...');
			}
		});
	}
	$('#btnModalAgregarBanco').click(function(){
		debugger
		if (ValidarCamposVaciosBanco() != 0) {
			alert('Completar campos obligatorios');
		}else{
			$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
			RecolectarDatosBanco();
			EnviarInformacionBanco('agregar', NuevoBanco, true);
		}
	});
	$('#btnModalEditarBanco').click(function(){
		if (ValidarCamposVaciosBanco() != 0) {
			alert('Completar campos obligatorios');
		}else{
			RecolectarDatosBanco();
			EnviarInformacionBanco('modificar', NuevoBanco, true);
		}
	});
	$('#btnModalEliminarBanco').click(function(){
		var bool=confirm('ESTA SEGURO DE ELIMINAR EL DATO?');
		if(bool){
			RecolectarDatosBanco();
			EnviarInformacionBanco('eliminar', NuevoBanco, true);
		}
	});
	$('#btnModalCerrarHotel').click(function(){
		$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
		LimpiarModalDatosBanco();
	});
	$('#btnFiltroBanco').click(function(){
		RecolectarDatosBanco();
		EnviarInformacionBanco('leer', NuevoBanco, false);
	});
	function Paginado(pag) {
		RecolectarDatosBanco();
		EnviarInformacionBanco('leer', NuevoBanco, false, pag);
	}
	function RecolectarDatosBanco(){
		NuevoBanco = {
			idbanco: $('#idbanco').val().toUpperCase(),
			nombre: $('#nombre').val().toUpperCase(),
			estado: $('#estado').val().toUpperCase(),
			todos: $('#idFTodos').val(),
			texto: $('#idFTexto').val()
		};
	}
	function EnviarInformacionBanco(accion, objEvento, modal, pag=1) { 
		$.ajax({
			type: 'POST',
			url: base_url+'/banco/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				var resp = JSON.parse(msg);
				$('#PaginadoBanco').empty();
				$('#PaginadoBanco').append(resp.pag);
				if (modal) {
					$('#modalAgregarBanco').modal('toggle');
					LimpiarModalDatosBanco();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								CargartablaBanco(resp.datos)
							}
						})
					} else {
						Swal.fire({
							title: resp.mensaje,
							icon: 'error'
						})
					}
				}else{
					CargartablaBanco(resp.datos)
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
	function LimpiarModalDatosBanco(){
		$('#idbanco').val('0');
		$('#nombre').val('');
	}
	function ValidarCamposVaciosBanco(){
		var error = 0;
		var value = $('#idbanco').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idbanco');
			error++;
		}else{
			NoResaltado('idbanco');
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
	function CargartablaBanco(objeto){
		$('#TablaBanco tr').not($('#TablaBanco tr:first')).remove();
		$.each(objeto, function(i, value) {
				var fila = `<tr>
				<td hidden>${value.idbanco}</td>
				<td>${value.nombre}</td>
				<td class = 'hidden-xs'>${value.estado == '1' ? 'ACTIVO' : 'DESACTIVO'}</td>
				<td>${value.concatenado}</td>
				<td>${value.concatenadodetalle}</td>
				<td>
				<div class='row'>
					<div style='margin: auto;'>
						<button type='button' onclick="btnEditarBanco('${value.idbanco}')" class='btn btn-info btn-xs'>
							<span class='fa fa-search fa-xs'></span>
						</button>
					</div>
						<div style='margin: auto;'>
							<a class='btn btn-success btn-xs' href='<?php echo base_url();?>/reserva/add/$banco['idbanco']'><i class='fa fa-pencil'></i></a>
					</div>
				</div>
				</td>
				</tr>`
			$('#TablaBanco tbody').append(fila);
		});
	}
</script>
