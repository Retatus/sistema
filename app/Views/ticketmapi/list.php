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
								<button type='button' class='btn btn-info btn-sm' id='btnAgregarTicketmapi'>
									<span class='fa fa-plus'></span> Agregar Ticketmapi
								</button>
								<a href='<?php echo base_url();?>ticketmapi/excel' class='btn btn-success btn-sm'>
									<span class='fa fa-file-excel'></span> Exportar
								</a>
								<a href='<?php echo base_url();?>ticketmapi/pdf' target='_blank' class='btn btn-danger btn-sm'>
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
												<button type='button' class='btn btn-info btn-sm' id='btnFiltroTicketmapi'>
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
							<table id='TablaTicketmapi' class='table table-sm table-bordered table-striped'>
								<thead>
									<tr>
										<th hidden>Idticketmapi</th>
										<th>Nombre</th>
										<th>Estado</th>
										<th>Concatenado</th>
										<th>Concatenadodetalle</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $ticketmapi):?>
											<tr>
												<td hidden><?php echo $ticketmapi['idticketmapi'];?></td>
												<td><?php echo $ticketmapi['nombre'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($ticketmapi['estado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>
												<td><?php echo $ticketmapi['concatenado'];?></td>
												<td><?php echo $ticketmapi['concatenadodetalle'];?></td>
												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarTicketmapi('<?php echo $ticketmapi['idticketmapi'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-search fa-xs'></span>
															</button>
														</div>
														<div style='margin: auto;'>
															<a class='btn btn-success btn-xs' href="<?php echo base_url();?>reserva/add/<?php echo $ticketmapi['idticketmapi'];?>"><i class='fa fa-pencil'></i></a>
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
						<div id='PaginadoTicketmapi'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<!--  SECCION ====== MODAL ====== -->
<div class='modal fade' id='modalAgregarTicketmapi' tabindex='-1'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title' id='modaldeltalletour'>Detalle Ticketmapi</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<div class='col-6 form-group row'>
					<label class='col-sm-4'>Idticketmapi:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='idticketmapi' name='idticketmapi' placeholder='T001' autocomplete = 'off'>
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
			<button type='button' class='btn btn-success btn-sm' id='btnModalAgregarTicketmapi'>Agregar</button>
			<button type='button' class='btn btn-warning btn-sm' id='btnModalEditarTicketmapi'>Modificar</button>
			<button type='button' class='btn btn-danger btn-sm' id='btnModalEliminarTicketmapi'>Eliminar</button>
			<button type='button' class='btn btn-primary btn-sm' id='btnModalCerrarTicketmapi' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<!--  SECCION ====== SCRIPT ====== -->
<script>
	var NuevoTicketmapi;
	var base_url= '<?php echo base_url();?>';
	function load(pag){
		RecolectarDatosTicketmapi();
		EnviarInformacionTicketmapi('leer', NuevoTicketmapi, false, pag);
	}
	$('#btnAgregarTicketmapi').click(function(){
		LimpiarModalDatosTicketmapi();
		$('#categoria').val(1);
		$('#id').prop('readonly', false);  
		$('#IdModalGrupoCodigoHotel').prop('hidden', false);
		$('#btnModalAgregarTicketmapi').toggle(true);
		$('#btnModalEditarTicketmapi').toggle(false);
		$('#btnModalEliminarTicketmapi').toggle(false);
		$('#modalAgregarTicketmapi').modal();
	});
//   SECCION ====== btn Editar ======
	function btnEditarTicketmapi(Val0){
		$.ajax({
			type: 'POST',
			url: base_url + '/ticketmapi/edit',
			data: {idticketmapi: Val0},
			success: function(msg){
				debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosTicketmapi();
				$('#idticketmapi').val(temp.idticketmapi);
				$('#nombre').val(temp.nombre);
				$('#estado').val(temp.estado);
				$('#btnModalAgregarTicketmapi').toggle(false);
				$('#btnModalEditarTicketmapi').toggle(true);
				$('#btnModalEliminarTicketmapi').toggle(true);
				$('#modalAgregarTicketmapi').modal('toggle');
			},
			error: function(){
				alert('Hay un error...');
			}
		});
	}
	$('#btnModalAgregarTicketmapi').click(function(){
		debugger
		if (ValidarCamposVaciosTicketmapi() != 0) {
			alert('Completar campos obligatorios');
		}else{
			$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
			RecolectarDatosTicketmapi();
			EnviarInformacionTicketmapi('agregar', NuevoTicketmapi, true);
		}
	});
	$('#btnModalEditarTicketmapi').click(function(){
		if (ValidarCamposVaciosTicketmapi() != 0) {
			alert('Completar campos obligatorios');
		}else{
			RecolectarDatosTicketmapi();
			EnviarInformacionTicketmapi('modificar', NuevoTicketmapi, true);
		}
	});
	$('#btnModalEliminarTicketmapi').click(function(){
		var bool=confirm('ESTA SEGURO DE ELIMINAR EL DATO?');
		if(bool){
			RecolectarDatosTicketmapi();
			EnviarInformacionTicketmapi('eliminar', NuevoTicketmapi, true);
		}
	});
	$('#btnModalCerrarHotel').click(function(){
		$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
		LimpiarModalDatosTicketmapi();
	});
	$('#btnFiltroTicketmapi').click(function(){
		RecolectarDatosTicketmapi();
		EnviarInformacionTicketmapi('leer', NuevoTicketmapi, false);
	});
	function Paginado(pag) {
		RecolectarDatosTicketmapi();
		EnviarInformacionTicketmapi('leer', NuevoTicketmapi, false, pag);
	}
	function RecolectarDatosTicketmapi(){
		NuevoTicketmapi = {
			idticketmapi: $('#idticketmapi').val().toUpperCase(),
			nombre: $('#nombre').val().toUpperCase(),
			estado: $('#estado').val().toUpperCase(),
			todos: $('#idFTodos').val(),
			texto: $('#idFTexto').val()
		};
	}
	function EnviarInformacionTicketmapi(accion, objEvento, modal, pag=1) { 
		$.ajax({
			type: 'POST',
			url: base_url+'/ticketmapi/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				var resp = JSON.parse(msg);
				$('#PaginadoTicketmapi').empty();
				$('#PaginadoTicketmapi').append(resp.pag);
				if (modal) {
					$('#modalAgregarTicketmapi').modal('toggle');
					LimpiarModalDatosTicketmapi();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								CargartablaTicketmapi(resp.datos)
							}
						})
					} else {
						Swal.fire({
							title: resp.mensaje,
							icon: 'error'
						})
					}
				}else{
					CargartablaTicketmapi(resp.datos)
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
	function LimpiarModalDatosTicketmapi(){
		$('#idticketmapi').val('0');
		$('#nombre').val('');
	}
	function ValidarCamposVaciosTicketmapi(){
		var error = 0;
		var value = $('#idticketmapi').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idticketmapi');
			error++;
		}else{
			NoResaltado('idticketmapi');
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
	function CargartablaTicketmapi(objeto){
		$('#TablaTicketmapi tr').not($('#TablaTicketmapi tr:first')).remove();
		$.each(objeto, function(i, value) {
				var fila = `<tr>
				<td hidden>${value.idticketmapi}</td>
				<td>${value.nombre}</td>
				<td class = 'hidden-xs'>${value.estado == '1' ? 'ACTIVO' : 'DESACTIVO'}</td>
				<td>${value.concatenado}</td>
				<td>${value.concatenadodetalle}</td>
				<td>
				<div class='row'>
					<div style='margin: auto;'>
						<button type='button' onclick="btnEditarTicketmapi('${value.idticketmapi}')" class='btn btn-info btn-xs'>
							<span class='fa fa-search fa-xs'></span>
						</button>
					</div>
						<div style='margin: auto;'>
							<a class='btn btn-success btn-xs' href='<?php echo base_url();?>/reserva/add/$ticketmapi['idticketmapi']'><i class='fa fa-pencil'></i></a>
					</div>
				</div>
				</td>
				</tr>`
			$('#TablaTicketmapi tbody').append(fila);
		});
	}
</script>
