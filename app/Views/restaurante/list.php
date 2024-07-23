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
								<button type='button' class='btn btn-info btn-sm' id='btnAgregarRestaurante'>
									<span class='fa fa-plus'></span> Agregar Restaurante
								</button>
								<a href='<?php echo base_url();?>restaurante/excel' class='btn btn-success btn-sm'>
									<span class='fa fa-file-excel'></span> Exportar
								</a>
								<a href='<?php echo base_url();?>restaurante/pdf' target='_blank' class='btn btn-danger btn-sm'>
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
												<button type='button' class='btn btn-info btn-sm' id='btnFiltroRestaurante'>
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
							<table id='TablaRestaurante' class='table table-sm table-bordered table-striped'>
								<thead>
									<tr>
										<th>Idtrestaurante</th>
										<th>Restaurantenombre</th>
										<th>Idrestaurantecategoria</th>
										<th>Restaurantedireccion</th>
										<th>Restaurantetelefono</th>
										<th>Restaurantecorreo</th>
										<th>Restauranteruc</th>
										<th>Restauranterazon</th>
										<th>Restaurantenrocuenta</th>
										<th>Restauranteubigeo</th>
										<th>Restaurantelatitud</th>
										<th>Restaurantelongitud</th>
										<th>Restauranteestado</th>
										<th>Concatenado</th>
										<th>Concatenadodetalle</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $restaurante):?>
											<tr>
												<td><?php echo $restaurante['idtrestaurante'];?></td>
												<td><?php echo $restaurante['restaurantenombre'];?></td>
												<td><?php echo $restaurante['idrestaurantecategoria'];?></td>
												<td><?php echo $restaurante['restaurantedireccion'];?></td>
												<td><?php echo $restaurante['restaurantetelefono'];?></td>
												<td><?php echo $restaurante['restaurantecorreo'];?></td>
												<td><?php echo $restaurante['restauranteruc'];?></td>
												<td><?php echo $restaurante['restauranterazon'];?></td>
												<td><?php echo $restaurante['restaurantenrocuenta'];?></td>
												<td><?php echo $restaurante['restauranteubigeo'];?></td>
												<td><?php echo $restaurante['restaurantelatitud'];?></td>
												<td><?php echo $restaurante['restaurantelongitud'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($restaurante['restauranteestado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>
												<td><?php echo $restaurante['concatenado'];?></td>
												<td><?php echo $restaurante['concatenadodetalle'];?></td>
												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarRestaurante('<?php echo $restaurante['idtrestaurante'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-search fa-xs'></span>
															</button>
														</div>
														<div style='margin: auto;'>
															<a class='btn btn-success btn-xs' href="<?php echo base_url();?>reserva/add/<?php echo $restaurante['idtrestaurante'];?>"><i class='fa fa-pencil'></i></a>
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
						<div id='PaginadoRestaurante'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<!--  SECCION ====== MODAL ====== -->
<div class='modal fade' id='modalAgregarRestaurante' tabindex='-1'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title' id='modaldeltalletour'>Detalle Restaurante</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<div class='col-6 form-group row'>
					<label class='col-sm-4'>Idtrestaurante:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='idtrestaurante' name='idtrestaurante' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>Restaurantenombre:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='restaurantenombre' name='restaurantenombre' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>Idrestaurantecategoria:</label>
					<div class = 'col-sm-8'>
						<input type='number' class='form-control form-control-sm' id='idrestaurantecategoria' name='idrestaurantecategoria' placeholder='0.00' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>Restaurantedireccion:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='restaurantedireccion' name='restaurantedireccion' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>Restaurantetelefono:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='restaurantetelefono' name='restaurantetelefono' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>Restaurantecorreo:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='restaurantecorreo' name='restaurantecorreo' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>Restauranteruc:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='restauranteruc' name='restauranteruc' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>Restauranterazon:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='restauranterazon' name='restauranterazon' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>Restaurantenrocuenta:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='restaurantenrocuenta' name='restaurantenrocuenta' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>Restauranteubigeo:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='restauranteubigeo' name='restauranteubigeo' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>Restaurantelatitud:</label>
					<div class = 'col-sm-8'>
						<input type='number' class='form-control form-control-sm' id='restaurantelatitud' name='restaurantelatitud' placeholder='0.00' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>Restaurantelongitud:</label>
					<div class = 'col-sm-8'>
						<input type='number' class='form-control form-control-sm' id='restaurantelongitud' name='restaurantelongitud' placeholder='0.00' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='rol'>Restauranteestado:</label>
					<div class='col-sm-8'>
						<select class='form-control form-control-sm' id='restauranteestado' name='restauranteestado'>
							<option value = '1' selected >ACTIVO</option>
							<option value = '0' >DESACTIVO</option>
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class='modal-footer'>
			<button type='button' class='btn btn-success btn-sm' id='btnModalAgregarRestaurante'>Agregar</button>
			<button type='button' class='btn btn-warning btn-sm' id='btnModalEditarRestaurante'>Modificar</button>
			<button type='button' class='btn btn-danger btn-sm' id='btnModalEliminarRestaurante'>Eliminar</button>
			<button type='button' class='btn btn-primary btn-sm' id='btnModalCerrarRestaurante' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<!--  SECCION ====== SCRIPT ====== -->
<script>
	var NuevoRestaurante;
	var base_url= '<?php echo base_url();?>';
	function load(pag){
		RecolectarDatosRestaurante();
		EnviarInformacionRestaurante('leer', NuevoRestaurante, false, pag);
	}
	$('#btnAgregarRestaurante').click(function(){
		LimpiarModalDatosRestaurante();
		$('#categoria').val(1);
		$('#id').prop('readonly', false);  
		$('#IdModalGrupoCodigoHotel').prop('hidden', false);
		$('#btnModalAgregarRestaurante').toggle(true);
		$('#btnModalEditarRestaurante').toggle(false);
		$('#btnModalEliminarRestaurante').toggle(false);
		$('#modalAgregarRestaurante').modal();
	});
//   SECCION ====== btn Editar ======
	function btnEditarRestaurante(Val0){
		$.ajax({
			type: 'POST',
			url: base_url + '/restaurante/edit',
			data: {idtrestaurante: Val0},
			success: function(msg){
				debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosRestaurante();
				$('#idtrestaurante').val(temp.idtrestaurante);
				$('#restaurantenombre').val(temp.restaurantenombre);
				$('#idrestaurantecategoria').val(temp.idrestaurantecategoria);
				$('#restaurantedireccion').val(temp.restaurantedireccion);
				$('#restaurantetelefono').val(temp.restaurantetelefono);
				$('#restaurantecorreo').val(temp.restaurantecorreo);
				$('#restauranteruc').val(temp.restauranteruc);
				$('#restauranterazon').val(temp.restauranterazon);
				$('#restaurantenrocuenta').val(temp.restaurantenrocuenta);
				$('#restauranteubigeo').val(temp.restauranteubigeo);
				$('#restaurantelatitud').val(temp.restaurantelatitud);
				$('#restaurantelongitud').val(temp.restaurantelongitud);
				$('#restauranteestado').val(temp.restauranteestado);
				$('#btnModalAgregarRestaurante').toggle(false);
				$('#btnModalEditarRestaurante').toggle(true);
				$('#btnModalEliminarRestaurante').toggle(true);
				$('#modalAgregarRestaurante').modal('toggle');
			},
			error: function(){
				alert('Hay un error...');
			}
		});
	}
	$('#btnModalAgregarRestaurante').click(function(){
		debugger
		if (ValidarCamposVaciosRestaurante() != 0) {
			alert('Completar campos obligatorios');
		}else{
			$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
			RecolectarDatosRestaurante();
			EnviarInformacionRestaurante('agregar', NuevoRestaurante, true);
		}
	});
	$('#btnModalEditarRestaurante').click(function(){
		if (ValidarCamposVaciosRestaurante() != 0) {
			alert('Completar campos obligatorios');
		}else{
			RecolectarDatosRestaurante();
			EnviarInformacionRestaurante('modificar', NuevoRestaurante, true);
		}
	});
	$('#btnModalEliminarRestaurante').click(function(){
		var bool=confirm('ESTA SEGURO DE ELIMINAR EL DATO?');
		if(bool){
			RecolectarDatosRestaurante();
			EnviarInformacionRestaurante('eliminar', NuevoRestaurante, true);
		}
	});
	$('#btnModalCerrarHotel').click(function(){
		$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
		LimpiarModalDatosRestaurante();
	});
	$('#btnFiltroRestaurante').click(function(){
		RecolectarDatosRestaurante();
		EnviarInformacionRestaurante('leer', NuevoRestaurante, false);
	});
	function Paginado(pag) {
		RecolectarDatosRestaurante();
		EnviarInformacionRestaurante('leer', NuevoRestaurante, false, pag);
	}
	function RecolectarDatosRestaurante(){
		NuevoRestaurante = {
			idtrestaurante: $('#idtrestaurante').val().toUpperCase(),
			restaurantenombre: $('#restaurantenombre').val().toUpperCase(),
			idrestaurantecategoria: $('#idrestaurantecategoria').val().toUpperCase(),
			restaurantedireccion: $('#restaurantedireccion').val().toUpperCase(),
			restaurantetelefono: $('#restaurantetelefono').val().toUpperCase(),
			restaurantecorreo: $('#restaurantecorreo').val().toUpperCase(),
			restauranteruc: $('#restauranteruc').val().toUpperCase(),
			restauranterazon: $('#restauranterazon').val().toUpperCase(),
			restaurantenrocuenta: $('#restaurantenrocuenta').val().toUpperCase(),
			restauranteubigeo: $('#restauranteubigeo').val().toUpperCase(),
			restaurantelatitud: $('#restaurantelatitud').val().toUpperCase(),
			restaurantelongitud: $('#restaurantelongitud').val().toUpperCase(),
			restauranteestado: $('#restauranteestado').val().toUpperCase(),
			todos: $('#idFTodos').val(),
			texto: $('#idFTexto').val()
		};
	}
	function EnviarInformacionRestaurante(accion, objEvento, modal, pag=1) { 
		$.ajax({
			type: 'POST',
			url: base_url+'/restaurante/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				var resp = JSON.parse(msg);
				$('#PaginadoRestaurante').empty();
				$('#PaginadoRestaurante').append(resp.pag);
				if (modal) {
					$('#modalAgregarRestaurante').modal('toggle');
					LimpiarModalDatosRestaurante();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								CargartablaRestaurante(resp.datos)
							}
						})
					} else {
						Swal.fire({
							title: resp.mensaje,
							icon: 'error'
						})
					}
				}else{
					CargartablaRestaurante(resp.datos)
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
	function LimpiarModalDatosRestaurante(){
		$('#idtrestaurante').val('');
		$('#restaurantenombre').val('');
		$('#idrestaurantecategoria').val('0');
		$('#restaurantedireccion').val('');
		$('#restaurantetelefono').val('');
		$('#restaurantecorreo').val('');
		$('#restauranteruc').val('');
		$('#restauranterazon').val('');
		$('#restaurantenrocuenta').val('');
		$('#restauranteubigeo').val('');
		$('#restaurantelatitud').val('');
		$('#restaurantelongitud').val('');
	}
	function ValidarCamposVaciosRestaurante(){
		var error = 0;
		if ($('#idtrestaurante').val() == ''){
			Resaltado('idtrestaurante');
			error++;
		}else{
			NoResaltado('idtrestaurante');
		}
		if ($('#restaurantenombre').val() == ''){
			Resaltado('restaurantenombre');
			error++;
		}else{
			NoResaltado('restaurantenombre');
		}
		var value = $('#idrestaurantecategoria').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idrestaurantecategoria');
			error++;
		}else{
			NoResaltado('idrestaurantecategoria');
		}
		if ($('#restaurantedireccion').val() == ''){
			Resaltado('restaurantedireccion');
			error++;
		}else{
			NoResaltado('restaurantedireccion');
		}
		if ($('#restaurantetelefono').val() == ''){
			Resaltado('restaurantetelefono');
			error++;
		}else{
			NoResaltado('restaurantetelefono');
		}
		var email = $('#restaurantecorreo').val();
		var emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
		if (!emailRegex.test(email)){
			Resaltado('restaurantecorreo');
			error++;
		}else{
			NoResaltado('restaurantecorreo');
		}
		if ($('#restauranteruc').val() == ''){
			Resaltado('restauranteruc');
			error++;
		}else{
			NoResaltado('restauranteruc');
		}
		if ($('#restauranterazon').val() == ''){
			Resaltado('restauranterazon');
			error++;
		}else{
			NoResaltado('restauranterazon');
		}
		if ($('#restaurantenrocuenta').val() == ''){
			Resaltado('restaurantenrocuenta');
			error++;
		}else{
			NoResaltado('restaurantenrocuenta');
		}
		if ($('#restauranteubigeo').val() == ''){
			Resaltado('restauranteubigeo');
			error++;
		}else{
			NoResaltado('restauranteubigeo');
		}
		if ($('#restaurantelatitud').val() == ''){
			Resaltado('restaurantelatitud');
			error++;
		}else{
			NoResaltado('restaurantelatitud');
		}
		if ($('#restaurantelongitud').val() == ''){
			Resaltado('restaurantelongitud');
			error++;
		}else{
			NoResaltado('restaurantelongitud');
		}
		if ($('#restauranteestado').val() == ''){
			Resaltado('restauranteestado');
			error++;
		}else{
			NoResaltado('restauranteestado');
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
	function CargartablaRestaurante(objeto){
		$('#TablaRestaurante tr').not($('#TablaRestaurante tr:first')).remove();
		$.each(objeto, function(i, value) {
				var fila = `<tr>
				<td>${value.idtrestaurante}</td>
				<td>${value.restaurantenombre}</td>
				<td>${value.idrestaurantecategoria}</td>
				<td>${value.restaurantedireccion}</td>
				<td>${value.restaurantetelefono}</td>
				<td>${value.restaurantecorreo}</td>
				<td>${value.restauranteruc}</td>
				<td>${value.restauranterazon}</td>
				<td>${value.restaurantenrocuenta}</td>
				<td>${value.restauranteubigeo}</td>
				<td>${value.restaurantelatitud}</td>
				<td>${value.restaurantelongitud}</td>
				<td class = 'hidden-xs'>${value.restauranteestado == '1' ? 'ACTIVO' : 'DESACTIVO'}</td>
				<td>${value.concatenado}</td>
				<td>${value.concatenadodetalle}</td>
				<td>
				<div class='row'>
					<div style='margin: auto;'>
						<button type='button' onclick="btnEditarRestaurante('${value.idtrestaurante}')" class='btn btn-info btn-xs'>
							<span class='fa fa-search fa-xs'></span>
						</button>
					</div>
						<div style='margin: auto;'>
							<a class='btn btn-success btn-xs' href='<?php echo base_url();?>/reserva/add/$restaurante['idtrestaurante']'><i class='fa fa-pencil'></i></a>
					</div>
				</div>
				</td>
				</tr>`
			$('#TablaRestaurante tbody').append(fila);
		});
	}
</script>
