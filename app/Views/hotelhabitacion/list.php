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
								<button type='button' class='btn btn-info btn-sm' id='btnAgregarHotelhabitacion'>
									<span class='fa fa-plus'></span> Agregar Hotelhabitacion
								</button>
								<a href='<?php echo base_url();?>hotelhabitacion/excel' class='btn btn-success btn-sm'>
									<span class='fa fa-file-excel'></span> Exportar
								</a>
								<a href='<?php echo base_url();?>hotelhabitacion/pdf' target='_blank' class='btn btn-danger btn-sm'>
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
												<button type='button' class='btn btn-info btn-sm' id='btnFiltroHotelhabitacion'>
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
							<table id='TablaHotelhabitacion' class='table table-sm table-bordered table-striped'>
								<thead>
									<tr>
										<th hidden>Idhotelhabitacion</th>
										<th>Precio</th>
										<th>Fecha</th>
										<th>Estado</th>
										<th>Confirmado</th>
										<th hidden>Idcathabitacion</th>
										<th>Nombre</th>
										<th>Idhotel</th>
										<th>Nombre</th>
										<th hidden>Idbanco</th>
										<th>Nombre</th>
										<th hidden>Idcathotel</th>
										<th>Nombre</th>
										<th>Concatenado</th>
										<th>Concatenadodetalle</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $hotelhabitacion):?>
											<tr>
												<td hidden><?php echo $hotelhabitacion['idhotelhabitacion'];?></td>
												<td><?php echo $hotelhabitacion['precio'];?></td>
												<td><?php echo $hotelhabitacion['fecha'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($hotelhabitacion['estado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>
												<td class = 'hidden-xs'><?php echo $est = ($hotelhabitacion['confirmado']== 1) ? 'CONFIRMADO' : 'PENDIENTE';?></td>
												<td hidden><?php echo $hotelhabitacion['idcathabitacion'];?></td>
												<td><?php echo $hotelhabitacion['nombre'];?></td>
												<td><?php echo $hotelhabitacion['idhotel'];?></td>
												<td><?php echo $hotelhabitacion['nombre'];?></td>
												<td hidden><?php echo $hotelhabitacion['idbanco'];?></td>
												<td><?php echo $hotelhabitacion['nombre'];?></td>
												<td hidden><?php echo $hotelhabitacion['idcathotel'];?></td>
												<td><?php echo $hotelhabitacion['nombre'];?></td>
												<td><?php echo $hotelhabitacion['concatenado'];?></td>
												<td><?php echo $hotelhabitacion['concatenadodetalle'];?></td>
												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarHotelhabitacion('<?php echo $hotelhabitacion['idhotelhabitacion'].'\',\''.$hotelhabitacion['idhotel'].'\',\''.$hotelhabitacion['idcathabitacion'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-search fa-xs'></span>
															</button>
														</div>
														<div style='margin: auto;'>
															<a class='btn btn-success btn-xs' href="<?php echo base_url();?>reserva/add/<?php echo $hotelhabitacion['idhotelhabitacion'].'\',\''.$hotelhabitacion['idhotel'].'\',\''.$hotelhabitacion['idcathabitacion'];?>"><i class='fa fa-pencil'></i></a>
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
						<div id='PaginadoHotelhabitacion'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<!--  SECCION ====== MODAL ====== -->
<div class='modal fade' id='modalAgregarHotelhabitacion' tabindex='-1'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title' id='modaldeltalletour'>Detalle Hotelhabitacion</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<div class='col-6 form-group row'>
					<label class='col-sm-4'>Idhotelhabitacion:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='idhotelhabitacion' name='idhotelhabitacion' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4'>Hotel:</label>
					<div class = 'col-sm-8'>
						<select class='form-control form-control-sm select2' id='idhotel'>
							<option value='0'>-- SELECCIONAR1 --</option>
							<?php if (!empty($hotels)):?>
								<?php foreach($hotels as $hotel):?>
									<option value= '<?php echo $hotel['idhotel'];?>'><?php echo $hotel['concatenado'];?></option>
								<?php endforeach;?>
							<?php endif;?>
						</select>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4'>Cathabitacion:</label>
					<div class = 'col-sm-8'>
						<select class='form-control form-control-sm select2' id='idcathabitacion'>
							<option value='0'>-- SELECCIONAR1 --</option>
							<?php if (!empty($cathabitacions)):?>
								<?php foreach($cathabitacions as $cathabitacion):?>
									<option value= '<?php echo $cathabitacion['idcathabitacion'];?>'><?php echo $cathabitacion['concatenado'];?></option>
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
					<label class='col-sm-4'>Fecha:</label>
					<div class='col-sm-8'>
						<div class='input-group'>
							<div class='input-group-prepend'>
								<span class='input-group-text'>
									<i class='far fa-calendar-alt'></i>
								</span>
							</div>
							<input type='text' class='form-control form-control-sm' id='fecha' name='fecha' placeholder='dd/mm/yyyy' readonly>
						</div>
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
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='rol'>Confirmado:</label>
					<div class='col-sm-8'>
						<select class='form-control form-control-sm' id='confirmado' name='confirmado'>
							<option value = '1' selected >CONFIRMADO</option>
							<option value = '0' >CANCELADO</option>
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class='modal-footer'>
			<button type='button' class='btn btn-success btn-sm' id='btnModalAgregarHotelhabitacion'>Agregar</button>
			<button type='button' class='btn btn-warning btn-sm' id='btnModalEditarHotelhabitacion'>Modificar</button>
			<button type='button' class='btn btn-danger btn-sm' id='btnModalEliminarHotelhabitacion'>Eliminar</button>
			<button type='button' class='btn btn-primary btn-sm' id='btnModalCerrarHotelhabitacion' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<!--  SECCION ====== SCRIPT ====== -->
<script>
	var NuevoHotelhabitacion;
	var base_url= '<?php echo base_url();?>';
	function load(pag){
		RecolectarDatosHotelhabitacion();
		EnviarInformacionHotelhabitacion('leer', NuevoHotelhabitacion, false, pag);
	}
	$('#fecha').datepicker({
		language: 'es',
		todayBtn: 'linked',
		clearBtn: true,
		format: 'mm/dd/yyyy',
		multidate: false,
		todayHighlight: true
	});
	
	$('#btnAgregarHotelhabitacion').click(function(){
		LimpiarModalDatosHotelhabitacion();
		$('#categoria').val(1);
		$('#id').prop('readonly', false);  
		$('#IdModalGrupoCodigoHotel').prop('hidden', false);
		$('#btnModalAgregarHotelhabitacion').toggle(true);
		$('#btnModalEditarHotelhabitacion').toggle(false);
		$('#btnModalEliminarHotelhabitacion').toggle(false);
		$('#modalAgregarHotelhabitacion').modal();
	});
//   SECCION ====== btn Editar ======
	function btnEditarHotelhabitacion(Val0, Val1, Val2){
		$.ajax({
			type: 'POST',
			url: base_url + '/hotelhabitacion/edit',
			data: {idhotelhabitacion: Val0, idhotel: Val1, idcathabitacion: Val2},
			success: function(msg){
				debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosHotelhabitacion();
				$('#idhotelhabitacion').val(temp.idhotelhabitacion);
				$('#idhotel').select2().val(temp.idhotel).select2('destroy').select2();
				$('#idcathabitacion').select2().val(temp.idcathabitacion).select2('destroy').select2();
				$('#precio').val(temp.precio);
				$('#fecha').val(temp.fecha);
				$('#estado').val(temp.estado);
				$('#confirmado').val(temp.confirmado);
				$('#btnModalAgregarHotelhabitacion').toggle(false);
				$('#btnModalEditarHotelhabitacion').toggle(true);
				$('#btnModalEliminarHotelhabitacion').toggle(true);
				$('#modalAgregarHotelhabitacion').modal('toggle');
			},
			error: function(){
				alert('Hay un error...');
			}
		});
	}
	$('#btnModalAgregarHotelhabitacion').click(function(){
		debugger
		if (ValidarCamposVaciosHotelhabitacion() != 0) {
			alert('Completar campos obligatorios');
		}else{
			$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
			RecolectarDatosHotelhabitacion();
			EnviarInformacionHotelhabitacion('agregar', NuevoHotelhabitacion, true);
		}
	});
	$('#btnModalEditarHotelhabitacion').click(function(){
		if (ValidarCamposVaciosHotelhabitacion() != 0) {
			alert('Completar campos obligatorios');
		}else{
			RecolectarDatosHotelhabitacion();
			EnviarInformacionHotelhabitacion('modificar', NuevoHotelhabitacion, true);
		}
	});
	$('#btnModalEliminarHotelhabitacion').click(function(){
		var bool=confirm('ESTA SEGURO DE ELIMINAR EL DATO?');
		if(bool){
			RecolectarDatosHotelhabitacion();
			EnviarInformacionHotelhabitacion('eliminar', NuevoHotelhabitacion, true);
		}
	});
	$('#btnModalCerrarHotel').click(function(){
		$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
		LimpiarModalDatosHotelhabitacion();
	});
	$('#btnFiltroHotelhabitacion').click(function(){
		RecolectarDatosHotelhabitacion();
		EnviarInformacionHotelhabitacion('leer', NuevoHotelhabitacion, false);
	});
	function Paginado(pag) {
		RecolectarDatosHotelhabitacion();
		EnviarInformacionHotelhabitacion('leer', NuevoHotelhabitacion, false, pag);
	}
	function RecolectarDatosHotelhabitacion(){
		NuevoHotelhabitacion = {
			idhotelhabitacion: $('#idhotelhabitacion').val().toUpperCase(),
			idhotel: $('#idhotel').val().toUpperCase(),
			idcathabitacion: $('#idcathabitacion').val().toUpperCase(),
			precio: $('#precio').val().toUpperCase(),
			fecha: $('#fecha').val().toUpperCase(),
			estado: $('#estado').val().toUpperCase(),
			confirmado: $('#confirmado').val().toUpperCase(),
			todos: $('#idFTodos').val(),
			texto: $('#idFTexto').val()
		};
	}
	function EnviarInformacionHotelhabitacion(accion, objEvento, modal, pag=1) { 
		$.ajax({
			type: 'POST',
			url: base_url+'/hotelhabitacion/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				var resp = JSON.parse(msg);
				$('#PaginadoHotelhabitacion').empty();
				$('#PaginadoHotelhabitacion').append(resp.pag);
				if (modal) {
					$('#modalAgregarHotelhabitacion').modal('toggle');
					LimpiarModalDatosHotelhabitacion();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								CargartablaHotelhabitacion(resp.datos)
							}
						})
					} else {
						Swal.fire({
							title: resp.mensaje,
							icon: 'error'
						})
					}
				}else{
					CargartablaHotelhabitacion(resp.datos)
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
	function LimpiarModalDatosHotelhabitacion(){
		$('#idhotelhabitacion').val('0');
		$('#idhotel').select2().val(0).select2('destroy').select2();
		$('#idcathabitacion').select2().val(0).select2('destroy').select2();
		$('#precio').val('');
		$('#fecha').val('');
	}
	function ValidarCamposVaciosHotelhabitacion(){
		var error = 0;
		var value = $('#idhotelhabitacion').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idhotelhabitacion');
			error++;
		}else{
			NoResaltado('idhotelhabitacion');
		}
		if ($('#idhotel').val() == ''){
			Resaltado('idhotel');
			error++;
		}else{
			NoResaltado('idhotel');
		}
		var value = $('#idcathabitacion').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idcathabitacion');
			error++;
		}else{
			NoResaltado('idcathabitacion');
		}
		if ($('#precio').val() == ''){
			Resaltado('precio');
			error++;
		}else{
			NoResaltado('precio');
		}
		if ($('#fecha').val() == ''){
			Resaltado('fecha');
			error++;
		}else{
			NoResaltado('fecha');
		}
		if ($('#estado').val() == ''){
			Resaltado('estado');
			error++;
		}else{
			NoResaltado('estado');
		}
		if ($('#confirmado').val() == ''){
			Resaltado('confirmado');
			error++;
		}else{
			NoResaltado('confirmado');
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
	function CargartablaHotelhabitacion(objeto){
		$('#TablaHotelhabitacion tr').not($('#TablaHotelhabitacion tr:first')).remove();
		$.each(objeto, function(i, value) {
				var fila = `<tr>
				<td hidden>${value.idhotelhabitacion}</td>
				<td>${value.precio}</td>
				<td>${value.fecha}</td>
				<td class = 'hidden-xs'>${value.estado == '1' ? 'ACTIVO' : 'DESACTIVO'}</td>
				<td class = 'hidden-xs'>${value.confirmado == '1' ? 'CONFIRMADO' : 'PENDIENTE'}</td>
				<td hidden>${value.idcathabitacion}</td>
				<td>${value.nombre}</td>
				<td>${value.idhotel}</td>
				<td>${value.nombre}</td>
				<td hidden>${value.idbanco}</td>
				<td>${value.nombre}</td>
				<td hidden>${value.idcathotel}</td>
				<td>${value.nombre}</td>
				<td>${value.concatenado}</td>
				<td>${value.concatenadodetalle}</td>
				<td>
				<div class='row'>
					<div style='margin: auto;'>
						<button type='button' onclick="btnEditarHotelhabitacion('${value.idhotelhabitacion}', '${value.idhotel}', '${value.idcathabitacion}')" class='btn btn-info btn-xs'>
							<span class='fa fa-search fa-xs'></span>
						</button>
					</div>
						<div style='margin: auto;'>
							<a class='btn btn-success btn-xs' href='<?php echo base_url();?>/reserva/add/$hotelhabitacion['idhotelhabitacion'].'\',\''.$hotelhabitacion['idhotel'].'\',\''.$hotelhabitacion['idcathabitacion']'><i class='fa fa-pencil'></i></a>
					</div>
				</div>
				</td>
				</tr>`
			$('#TablaHotelhabitacion tbody').append(fila);
		});
	}
</script>
