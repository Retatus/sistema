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
								<button type='button' class='btn btn-info btn-sm' id='btnAgregarTicketbus'>
									<span class='fa fa-plus'></span> Agregar Ticketbus
								</button>
								<a href='<?php echo base_url();?>ticketbus/excel' class='btn btn-success btn-sm'>
									<span class='fa fa-file-excel'></span> Exportar
								</a>
								<a href='<?php echo base_url();?>ticketbus/pdf' target='_blank' class='btn btn-danger btn-sm'>
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
												<button type='button' class='btn btn-info btn-sm' id='btnFiltroTicketbus'>
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
							<table id='TablaTicketbus' class='table table-sm table-bordered table-striped'>
								<thead>
									<tr>
										<th hidden>Idticketbus</th>
										<th>Nombre</th>
										<th>Descripcion</th>
										<th>Precio</th>
										<th>Estado</th>
										<th>Concatenado</th>
										<th>Concatenadodetalle</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $ticketbus):?>
											<tr>
												<td hidden><?php echo $ticketbus['idticketbus'];?></td>
												<td><?php echo $ticketbus['nombre'];?></td>
												<td><?php echo $ticketbus['descripcion'];?></td>
												<td><?php echo $ticketbus['precio'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($ticketbus['estado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>
												<td><?php echo $ticketbus['concatenado'];?></td>
												<td><?php echo $ticketbus['concatenadodetalle'];?></td>
												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarTicketbus('<?php echo $ticketbus['idticketbus'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-search fa-xs'></span>
															</button>
														</div>
														<div style='margin: auto;'>
															<a class='btn btn-success btn-xs' href="<?php echo base_url();?>reserva/add/<?php echo $ticketbus['idticketbus'];?>"><i class='fa fa-pencil'></i></a>
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
						<div id='PaginadoTicketbus'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<!--  SECCION ====== MODAL ====== -->
<div class='modal fade' id='modalAgregarTicketbus' tabindex='-1'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title' id='modaldeltalletour'>Detalle Ticketbus</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<div class='col-6 form-group row'>
					<label class='col-sm-4'>Idticketbus:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='idticketbus' name='idticketbus' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>Nombre:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='nombre' name='nombre' placeholder='T001' autocomplete = 'off'>
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
				<div class='col-12 form-group row'>
					<label class='col-sm-4' for='id'>Descripcion:</label>
					<div class = 'col-sm-12'>
						<textarea type='text' class='form-control form-control-sm text-uppercase' id='descripcion' name='descripcion' placeholder='T001' autocomplete = 'off'></textarea>
					</div>
				</div>
			</div>
		</div>
		<div class='modal-footer'>
			<button type='button' class='btn btn-success btn-sm' id='btnModalAgregarTicketbus'>Agregar</button>
			<button type='button' class='btn btn-warning btn-sm' id='btnModalEditarTicketbus'>Modificar</button>
			<button type='button' class='btn btn-danger btn-sm' id='btnModalEliminarTicketbus'>Eliminar</button>
			<button type='button' class='btn btn-primary btn-sm' id='btnModalCerrarTicketbus' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<!--  SECCION ====== SCRIPT ====== -->
<script>
	var NuevoTicketbus;
	var base_url= '<?php echo base_url();?>';
	function load(pag){
		RecolectarDatosTicketbus();
		EnviarInformacionTicketbus('leer', NuevoTicketbus, false, pag);
	}
	$('#btnAgregarTicketbus').click(function(){
		LimpiarModalDatosTicketbus();
		$('#categoria').val(1);
		$('#id').prop('readonly', false);  
		$('#IdModalGrupoCodigoHotel').prop('hidden', false);
		$('#btnModalAgregarTicketbus').toggle(true);
		$('#btnModalEditarTicketbus').toggle(false);
		$('#btnModalEliminarTicketbus').toggle(false);
		$('#modalAgregarTicketbus').modal();
	});
//   SECCION ====== btn Editar ======
	function btnEditarTicketbus(Val0){
		$.ajax({
			type: 'POST',
			url: base_url + '/ticketbus/edit',
			data: {idticketbus: Val0},
			success: function(msg){
				debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosTicketbus();
				$('#idticketbus').val(temp.idticketbus);
				$('#nombre').val(temp.nombre);
				$('#descripcion').val(temp.descripcion);
				$('#precio').val(temp.precio);
				$('#estado').val(temp.estado);
				$('#btnModalAgregarTicketbus').toggle(false);
				$('#btnModalEditarTicketbus').toggle(true);
				$('#btnModalEliminarTicketbus').toggle(true);
				$('#modalAgregarTicketbus').modal('toggle');
			},
			error: function(){
				alert('Hay un error...');
			}
		});
	}
	$('#btnModalAgregarTicketbus').click(function(){
		debugger
		if (ValidarCamposVaciosTicketbus() != 0) {
			alert('Completar campos obligatorios');
		}else{
			$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
			RecolectarDatosTicketbus();
			EnviarInformacionTicketbus('agregar', NuevoTicketbus, true);
		}
	});
	$('#btnModalEditarTicketbus').click(function(){
		if (ValidarCamposVaciosTicketbus() != 0) {
			alert('Completar campos obligatorios');
		}else{
			RecolectarDatosTicketbus();
			EnviarInformacionTicketbus('modificar', NuevoTicketbus, true);
		}
	});
	$('#btnModalEliminarTicketbus').click(function(){
		var bool=confirm('ESTA SEGURO DE ELIMINAR EL DATO?');
		if(bool){
			RecolectarDatosTicketbus();
			EnviarInformacionTicketbus('eliminar', NuevoTicketbus, true);
		}
	});
	$('#btnModalCerrarHotel').click(function(){
		$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
		LimpiarModalDatosTicketbus();
	});
	$('#btnFiltroTicketbus').click(function(){
		RecolectarDatosTicketbus();
		EnviarInformacionTicketbus('leer', NuevoTicketbus, false);
	});
	function Paginado(pag) {
		RecolectarDatosTicketbus();
		EnviarInformacionTicketbus('leer', NuevoTicketbus, false, pag);
	}
	function RecolectarDatosTicketbus(){
		NuevoTicketbus = {
			idticketbus: $('#idticketbus').val().toUpperCase(),
			nombre: $('#nombre').val().toUpperCase(),
			descripcion: $('#descripcion').val().toUpperCase(),
			precio: $('#precio').val().toUpperCase(),
			estado: $('#estado').val().toUpperCase(),
			todos: $('#idFTodos').val(),
			texto: $('#idFTexto').val()
		};
	}
	function EnviarInformacionTicketbus(accion, objEvento, modal, pag=1) { 
		$.ajax({
			type: 'POST',
			url: base_url+'/ticketbus/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				var resp = JSON.parse(msg);
				$('#PaginadoTicketbus').empty();
				$('#PaginadoTicketbus').append(resp.pag);
				if (modal) {
					$('#modalAgregarTicketbus').modal('toggle');
					LimpiarModalDatosTicketbus();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								CargartablaTicketbus(resp.datos)
							}
						})
					} else {
						Swal.fire({
							title: resp.mensaje,
							icon: 'error'
						})
					}
				}else{
					CargartablaTicketbus(resp.datos)
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
	function LimpiarModalDatosTicketbus(){
		$('#idticketbus').val('0');
		$('#nombre').val('');
		$('#descripcion').val('');
		$('#precio').val('');
	}
	function ValidarCamposVaciosTicketbus(){
		var error = 0;
		var value = $('#idticketbus').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idticketbus');
			error++;
		}else{
			NoResaltado('idticketbus');
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
	function CargartablaTicketbus(objeto){
		$('#TablaTicketbus tr').not($('#TablaTicketbus tr:first')).remove();
		$.each(objeto, function(i, value) {
				var fila = `<tr>
				<td hidden>${value.idticketbus}</td>
				<td>${value.nombre}</td>
				<td>${value.descripcion}</td>
				<td>${value.precio}</td>
				<td class = 'hidden-xs'>${value.estado == '1' ? 'ACTIVO' : 'DESACTIVO'}</td>
				<td>${value.concatenado}</td>
				<td>${value.concatenadodetalle}</td>
				<td>
				<div class='row'>
					<div style='margin: auto;'>
						<button type='button' onclick="btnEditarTicketbus('${value.idticketbus}')" class='btn btn-info btn-xs'>
							<span class='fa fa-search fa-xs'></span>
						</button>
					</div>
						<div style='margin: auto;'>
							<a class='btn btn-success btn-xs' href='<?php echo base_url();?>/reserva/add/$ticketbus['idticketbus']'><i class='fa fa-pencil'></i></a>
					</div>
				</div>
				</td>
				</tr>`
			$('#TablaTicketbus tbody').append(fila);
		});
	}
</script>
