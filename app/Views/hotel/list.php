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
								<button type='button' class='btn btn-info btn-sm' id='btnAgregarHotel'>
									<span class='fa fa-plus'></span> Agregar Hotel
								</button>
								<a href='<?php echo base_url();?>hotel/excel' class='btn btn-success btn-sm'>
									<span class='fa fa-file-excel'></span> Exportar
								</a>
								<a href='<?php echo base_url();?>hotel/pdf' target='_blank' class='btn btn-danger btn-sm'>
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
												<button type='button' class='btn btn-info btn-sm' id='btnFiltroHotel'>
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
							<table id='TablaHotel' class='table table-sm table-bordered table-striped'>
								<thead>
									<tr>
										<th>Idhotel</th>
										<th>Nombre</th>
										<th>Direccion</th>
										<th>Telefono</th>
										<th>Correo</th>
										<th>Ruc</th>
										<th>Razonsocial</th>
										<th>Nrocuenta</th>
										<th>Ubigeo</th>
										<th>Latitud</th>
										<th>Longitud</th>
										<th>Estado</th>
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
										<?php foreach($datos as $hotel):?>
											<tr>
												<td><?php echo $hotel['idhotel'];?></td>
												<td><?php echo $hotel['nombre'];?></td>
												<td><?php echo $hotel['direccion'];?></td>
												<td><?php echo $hotel['telefono'];?></td>
												<td><?php echo $hotel['correo'];?></td>
												<td><?php echo $hotel['ruc'];?></td>
												<td><?php echo $hotel['razonsocial'];?></td>
												<td><?php echo $hotel['nrocuenta'];?></td>
												<td><?php echo $hotel['ubigeo'];?></td>
												<td><?php echo $hotel['latitud'];?></td>
												<td><?php echo $hotel['longitud'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($hotel['estado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>
												<td hidden><?php echo $hotel['idbanco'];?></td>
												<td><?php echo $hotel['nombre'];?></td>
												<td hidden><?php echo $hotel['idcathotel'];?></td>
												<td><?php echo $hotel['nombre'];?></td>
												<td><?php echo $hotel['concatenado'];?></td>
												<td><?php echo $hotel['concatenadodetalle'];?></td>
												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarHotel('<?php echo $hotel['idhotel'].'\',\''.$hotel['idcathotel'].'\',\''.$hotel['idbanco'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-search fa-xs'></span>
															</button>
														</div>
														<div style='margin: auto;'>
															<a class='btn btn-success btn-xs' href="<?php echo base_url();?>reserva/add/<?php echo $hotel['idhotel'].'\',\''.$hotel['idcathotel'].'\',\''.$hotel['idbanco'];?>"><i class='fa fa-pencil'></i></a>
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
						<div id='PaginadoHotel'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<!--  SECCION ====== MODAL ====== -->
<div class='modal fade' id='modalAgregarHotel' tabindex='-1'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title' id='modaldeltalletour'>Detalle Hotel</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<div class='col-6 form-group row'>
					<label class='col-sm-4'>Idhotel:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='idhotel' name='idhotel' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>Nombre:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='nombre' name='nombre' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4'>Cathotel:</label>
					<div class = 'col-sm-8'>
						<select class='form-control form-control-sm select2' id='idcathotel'>
							<option value='0'>-- SELECCIONAR1 --</option>
							<?php if (!empty($cathotels)):?>
								<?php foreach($cathotels as $cathotel):?>
									<option value= '<?php echo $cathotel['idcathotel'];?>'><?php echo $cathotel['concatenado'];?></option>
								<?php endforeach;?>
							<?php endif;?>
						</select>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>Direccion:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='direccion' name='direccion' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>Telefono:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='telefono' name='telefono' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>Correo:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='correo' name='correo' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>Ruc:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='ruc' name='ruc' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>Razonsocial:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='razonsocial' name='razonsocial' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>Nrocuenta:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='nrocuenta' name='nrocuenta' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4'>Banco:</label>
					<div class = 'col-sm-8'>
						<select class='form-control form-control-sm select2' id='idbanco'>
							<option value='0'>-- SELECCIONAR1 --</option>
							<?php if (!empty($bancos)):?>
								<?php foreach($bancos as $banco):?>
									<option value= '<?php echo $banco['idbanco'];?>'><?php echo $banco['concatenado'];?></option>
								<?php endforeach;?>
							<?php endif;?>
						</select>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>Ubigeo:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='ubigeo' name='ubigeo' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>Latitud:</label>
					<div class = 'col-sm-8'>
						<input type='number' class='form-control form-control-sm' id='latitud' name='latitud' placeholder='0.00' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>Longitud:</label>
					<div class = 'col-sm-8'>
						<input type='number' class='form-control form-control-sm' id='longitud' name='longitud' placeholder='0.00' autocomplete = 'off'>
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
			<button type='button' class='btn btn-success btn-sm' id='btnModalAgregarHotel'>Agregar</button>
			<button type='button' class='btn btn-warning btn-sm' id='btnModalEditarHotel'>Modificar</button>
			<button type='button' class='btn btn-danger btn-sm' id='btnModalEliminarHotel'>Eliminar</button>
			<button type='button' class='btn btn-primary btn-sm' id='btnModalCerrarHotel' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<!--  SECCION ====== SCRIPT ====== -->
<script>
	var NuevoHotel;
	var base_url= '<?php echo base_url();?>';
	function load(pag){
		RecolectarDatosHotel();
		EnviarInformacionHotel('leer', NuevoHotel, false, pag);
	}
	$('#btnAgregarHotel').click(function(){
		LimpiarModalDatosHotel();
		$('#categoria').val(1);
		$('#id').prop('readonly', false);  
		$('#IdModalGrupoCodigoHotel').prop('hidden', false);
		$('#btnModalAgregarHotel').toggle(true);
		$('#btnModalEditarHotel').toggle(false);
		$('#btnModalEliminarHotel').toggle(false);
		$('#modalAgregarHotel').modal();
	});
//   SECCION ====== btn Editar ======
	function btnEditarHotel(Val0, Val1, Val2){
		$.ajax({
			type: 'POST',
			url: base_url + '/hotel/edit',
			data: {idhotel: Val0, idcathotel: Val1, idbanco: Val2},
			success: function(msg){
				debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosHotel();
				$('#idhotel').val(temp.idhotel);
				$('#nombre').val(temp.nombre);
				$('#idcathotel').select2().val(temp.idcathotel).select2('destroy').select2();
				$('#direccion').val(temp.direccion);
				$('#telefono').val(temp.telefono);
				$('#correo').val(temp.correo);
				$('#ruc').val(temp.ruc);
				$('#razonsocial').val(temp.razonsocial);
				$('#nrocuenta').val(temp.nrocuenta);
				$('#idbanco').select2().val(temp.idbanco).select2('destroy').select2();
				$('#ubigeo').val(temp.ubigeo);
				$('#latitud').val(temp.latitud);
				$('#longitud').val(temp.longitud);
				$('#estado').val(temp.estado);
				$('#btnModalAgregarHotel').toggle(false);
				$('#btnModalEditarHotel').toggle(true);
				$('#btnModalEliminarHotel').toggle(true);
				$('#modalAgregarHotel').modal('toggle');
			},
			error: function(){
				alert('Hay un error...');
			}
		});
	}
	$('#btnModalAgregarHotel').click(function(){
		debugger
		if (ValidarCamposVaciosHotel() != 0) {
			alert('Completar campos obligatorios');
		}else{
			$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
			RecolectarDatosHotel();
			EnviarInformacionHotel('agregar', NuevoHotel, true);
		}
	});
	$('#btnModalEditarHotel').click(function(){
		if (ValidarCamposVaciosHotel() != 0) {
			alert('Completar campos obligatorios');
		}else{
			RecolectarDatosHotel();
			EnviarInformacionHotel('modificar', NuevoHotel, true);
		}
	});
	$('#btnModalEliminarHotel').click(function(){
		var bool=confirm('ESTA SEGURO DE ELIMINAR EL DATO?');
		if(bool){
			RecolectarDatosHotel();
			EnviarInformacionHotel('eliminar', NuevoHotel, true);
		}
	});
	$('#btnModalCerrarHotel').click(function(){
		$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
		LimpiarModalDatosHotel();
	});
	$('#btnFiltroHotel').click(function(){
		RecolectarDatosHotel();
		EnviarInformacionHotel('leer', NuevoHotel, false);
	});
	function Paginado(pag) {
		RecolectarDatosHotel();
		EnviarInformacionHotel('leer', NuevoHotel, false, pag);
	}
	function RecolectarDatosHotel(){
		NuevoHotel = {
			idhotel: $('#idhotel').val().toUpperCase(),
			nombre: $('#nombre').val().toUpperCase(),
			idcathotel: $('#idcathotel').val().toUpperCase(),
			direccion: $('#direccion').val().toUpperCase(),
			telefono: $('#telefono').val().toUpperCase(),
			correo: $('#correo').val().toUpperCase(),
			ruc: $('#ruc').val().toUpperCase(),
			razonsocial: $('#razonsocial').val().toUpperCase(),
			nrocuenta: $('#nrocuenta').val().toUpperCase(),
			idbanco: $('#idbanco').val().toUpperCase(),
			ubigeo: $('#ubigeo').val().toUpperCase(),
			latitud: $('#latitud').val().toUpperCase(),
			longitud: $('#longitud').val().toUpperCase(),
			estado: $('#estado').val().toUpperCase(),
			todos: $('#idFTodos').val(),
			texto: $('#idFTexto').val()
		};
	}
	function EnviarInformacionHotel(accion, objEvento, modal, pag=1) { 
		$.ajax({
			type: 'POST',
			url: base_url+'/hotel/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				var resp = JSON.parse(msg);
				$('#PaginadoHotel').empty();
				$('#PaginadoHotel').append(resp.pag);
				if (modal) {
					$('#modalAgregarHotel').modal('toggle');
					LimpiarModalDatosHotel();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								CargartablaHotel(resp.datos)
							}
						})
					} else {
						Swal.fire({
							title: resp.mensaje,
							icon: 'error'
						})
					}
				}else{
					CargartablaHotel(resp.datos)
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
	function LimpiarModalDatosHotel(){
		$('#idhotel').val('');
		$('#nombre').val('');
		$('#idcathotel').select2().val(0).select2('destroy').select2();
		$('#direccion').val('');
		$('#telefono').val('');
		$('#correo').val('');
		$('#ruc').val('');
		$('#razonsocial').val('');
		$('#nrocuenta').val('');
		$('#idbanco').select2().val(0).select2('destroy').select2();
		$('#ubigeo').val('');
		$('#latitud').val('');
		$('#longitud').val('');
	}
	function ValidarCamposVaciosHotel(){
		var error = 0;
		if ($('#idhotel').val() == ''){
			Resaltado('idhotel');
			error++;
		}else{
			NoResaltado('idhotel');
		}
		if ($('#nombre').val() == ''){
			Resaltado('nombre');
			error++;
		}else{
			NoResaltado('nombre');
		}
		var value = $('#idcathotel').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idcathotel');
			error++;
		}else{
			NoResaltado('idcathotel');
		}
		if ($('#direccion').val() == ''){
			Resaltado('direccion');
			error++;
		}else{
			NoResaltado('direccion');
		}
		if ($('#telefono').val() == ''){
			Resaltado('telefono');
			error++;
		}else{
			NoResaltado('telefono');
		}
		var email = $('#correo').val();
		var emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
		if (!emailRegex.test(email)){
			Resaltado('correo');
			error++;
		}else{
			NoResaltado('correo');
		}
		if ($('#ruc').val() == ''){
			Resaltado('ruc');
			error++;
		}else{
			NoResaltado('ruc');
		}
		if ($('#razonsocial').val() == ''){
			Resaltado('razonsocial');
			error++;
		}else{
			NoResaltado('razonsocial');
		}
		if ($('#nrocuenta').val() == ''){
			Resaltado('nrocuenta');
			error++;
		}else{
			NoResaltado('nrocuenta');
		}
		var value = $('#idbanco').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idbanco');
			error++;
		}else{
			NoResaltado('idbanco');
		}
		if ($('#ubigeo').val() == ''){
			Resaltado('ubigeo');
			error++;
		}else{
			NoResaltado('ubigeo');
		}
		if ($('#latitud').val() == ''){
			Resaltado('latitud');
			error++;
		}else{
			NoResaltado('latitud');
		}
		if ($('#longitud').val() == ''){
			Resaltado('longitud');
			error++;
		}else{
			NoResaltado('longitud');
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
	function CargartablaHotel(objeto){
		$('#TablaHotel tr').not($('#TablaHotel tr:first')).remove();
		$.each(objeto, function(i, value) {
				var fila = `<tr>
				<td>${value.idhotel}</td>
				<td>${value.nombre}</td>
				<td>${value.direccion}</td>
				<td>${value.telefono}</td>
				<td>${value.correo}</td>
				<td>${value.ruc}</td>
				<td>${value.razonsocial}</td>
				<td>${value.nrocuenta}</td>
				<td>${value.ubigeo}</td>
				<td>${value.latitud}</td>
				<td>${value.longitud}</td>
				<td class = 'hidden-xs'>${value.estado == '1' ? 'ACTIVO' : 'DESACTIVO'}</td>
				<td hidden>${value.idbanco}</td>
				<td>${value.nombre}</td>
				<td hidden>${value.idcathotel}</td>
				<td>${value.nombre}</td>
				<td>${value.concatenado}</td>
				<td>${value.concatenadodetalle}</td>
				<td>
				<div class='row'>
					<div style='margin: auto;'>
						<button type='button' onclick="btnEditarHotel('${value.idhotel}', '${value.idcathotel}', '${value.idbanco}')" class='btn btn-info btn-xs'>
							<span class='fa fa-search fa-xs'></span>
						</button>
					</div>
						<div style='margin: auto;'>
							<a class='btn btn-success btn-xs' href='<?php echo base_url();?>/reserva/add/$hotel['idhotel'].'\',\''.$hotel['idcathotel'].'\',\''.$hotel['idbanco']'><i class='fa fa-pencil'></i></a>
					</div>
				</div>
				</td>
				</tr>`
			$('#TablaHotel tbody').append(fila);
		});
	}
</script>
