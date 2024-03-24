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
										<th >Idt</th>
										<th >Nombre</th>
										<th >Idcategoria</th>
										<th >Direccion</th>
										<th >Telefono</th>
										<th >Correo</th>
										<th >Ruc</th>
										<th >Razon</th>
										<th >Nrocuenta</th>
										<th >Ubigeo</th>
										<th >Latitud</th>
										<th >Longitud</th>
										<th >Estado</th>
										<th>Acciones</th>

									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $restaurante):?>
											<tr>
												<td ><?php echo $restaurante['idtrestaurante'];?></td>
												<td ><?php echo $restaurante['restaurantenombre'];?></td>
												<td ><?php echo $restaurante['idrestaurantecategoria'];?></td>
												<td ><?php echo $restaurante['restaurantedireccion'];?></td>
												<td ><?php echo $restaurante['restaurantetelefono'];?></td>
												<td ><?php echo $restaurante['restaurantecorreo'];?></td>
												<td ><?php echo $restaurante['restauranteruc'];?></td>
												<td ><?php echo $restaurante['restauranterazon'];?></td>
												<td ><?php echo $restaurante['restaurantenrocuenta'];?></td>
												<td ><?php echo $restaurante['restauranteubigeo'];?></td>
												<td ><?php echo $restaurante['restaurantelatitud'];?></td>
												<td ><?php echo $restaurante['restaurantelongitud'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($restaurante['restauranteestado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>

												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarRestaurante('<?php echo $restaurante['idtrestaurante'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-search fa-xs'></span>
															</button>
														</div>
														<div style='margin: auto;'>
															<a class='btn btn-success btn-xs' href='<?php echo base_url();?>reserva/add/<?php echo $restaurante['idtrestaurante'];?>'><i class='fa fa-pencil'></i></a>
														</div>
													</div>
												</td>
											</tr>
										<?php endforeach;?>
									<?php endif;?>
								</tbody>
							</table>
						</div>
						<div id='PaginadoRestaurante'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
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
					<label class='col-sm-4' for='id'>idt:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='idtrestaurante' name='idtrestaurante' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>nombre:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='restaurantenombre' name='restaurantenombre' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>idcategoria:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='idrestaurantecategoria' name='idrestaurantecategoria' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>direccion:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='restaurantedireccion' name='restaurantedireccion' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>telefono:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='restaurantetelefono' name='restaurantetelefono' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>correo:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='restaurantecorreo' name='restaurantecorreo' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>ruc:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='restauranteruc' name='restauranteruc' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>razon:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='restauranterazon' name='restauranterazon' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>nrocuenta:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='restaurantenrocuenta' name='restaurantenrocuenta' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>ubigeo:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='restauranteubigeo' name='restauranteubigeo' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>latitud:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='restaurantelatitud' name='restaurantelatitud' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>longitud:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='restaurantelongitud' name='restaurantelongitud' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='rol'>estado:</label>
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

<script>
	var NuevoRestaurante;
	var base_url= '<?php echo base_url();?>';


	function NumeroFilasTabla(){
		TamanioTabla = $('#tabla_Habitaciones tr').length - 1;
		$('#minmax').val(TamanioTabla)
	}


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


	function btnEditarRestaurante(Val0){
		$.ajax({
			type: 'POST',
			url: base_url + '/restaurante/edit',
			data: { idtrestaurante: Val0},
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



				$('#tabla_Habitaciones tr').not($('#tabla_Habitaciones tr:first')).remove();
				var nrohabitaciones = 0;
				console.log(temp.habitacion);
				$.each(temp.habitacion, function(i, value) { 
					nrohabitaciones++;
					var rows = "<tr>" +
					"<td hidden>" + (i + 1) + "</td>" +
					"<td class='numero'>"+
						"<a href='#' style='color: #ef5350;' class='delete'><i class='fa fa-times' style='padding-top: 10px;'></i></a>" +
					"</td>" + 
					"<td hidden><input type='text' class='form-control text-uppercase' id='codhabitacion_" +(i + 1)+ "' value="+value.idhabitacion+"></td>" +
					"<td>" +
						"<select class='form-control select2' id='catHabitacion_"+(i + 1)+"' style='width: 100%;'>" +
							"<option value='0'>-- SELECCIONAR --</option>" +
						"</select>" +
					"</td>" +
					"<td><input type='text' class='form-control solo_numero' id='precio_" +(i + 1)+"' value="+value.precio+"></td>" +
					"<td>" +
						"<select class='form-control' id='estado_" +(i + 1)+ "' style='padding: 6px 2px;'>" +
						"</select>" +
					"</td>" +
					"</tr>";
					$('#tabla_Habitaciones').append(rows);


					$('.delete').off().click(function (e) {
						var i = $('#tabla_Habitaciones tr').length - 1; 
						if (i > 1) {
							$(this).parent('td').parent('tr').remove();
							NumeroFilasTabla();
						} 
					});


					addCatHabitacion((i + 1));
					$('#catHabitacion_'+(i + 1)).select2().val(value.idcathabitacion).select2('destroy').select2();
					addEstado((i + 1)); 
					$('#estado_'+(i + 1)).val(value.estado);            
				});
				$('#minmax').val(nrohabitaciones);


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
		$('#idtrestaurante').val('0');
		$('#restaurantenombre').val('');
		$('#idrestaurantecategoria').val('');
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
		}
		if ($('#restaurantenombre').val() == ''){
			Resaltado('restaurantenombre');
			error++;
		}
		if ($('#idrestaurantecategoria').val() == ''){
			Resaltado('idrestaurantecategoria');
			error++;
		}
		if ($('#restaurantedireccion').val() == ''){
			Resaltado('restaurantedireccion');
			error++;
		}
		if ($('#restaurantetelefono').val() == ''){
			Resaltado('restaurantetelefono');
			error++;
		}
		if ($('#restaurantecorreo').val() == ''){
			Resaltado('restaurantecorreo');
			error++;
		}
		if ($('#restauranteruc').val() == ''){
			Resaltado('restauranteruc');
			error++;
		}
		if ($('#restauranterazon').val() == ''){
			Resaltado('restauranterazon');
			error++;
		}
		if ($('#restaurantenrocuenta').val() == ''){
			Resaltado('restaurantenrocuenta');
			error++;
		}
		if ($('#restauranteubigeo').val() == ''){
			Resaltado('restauranteubigeo');
			error++;
		}
		if ($('#restaurantelatitud').val() == ''){
			Resaltado('restaurantelatitud');
			error++;
		}
		if ($('#restaurantelongitud').val() == ''){
			Resaltado('restaurantelongitud');
			error++;
		}
		if ($('#restauranteestado').val() == ''){
			Resaltado('restauranteestado');
			error++;
		}

		return error;
	}


	function Resaltado(id){
		$('#'+id).css('border-color', '#ef5350');
		$('#'+id).focus();
	}


	function CargartablaRestaurante(objeto){   
		$('#TablaRestaurante tr').not($('#TablaRestaurante tr:first')).remove();
		$.each(objeto, function(i, value) {
		var fila = '<tr>'+
			'<td >'+value.idtrestaurante+'</td>'+
			'<td >'+value.restaurantenombre+'</td>'+
			'<td >'+value.idrestaurantecategoria+'</td>'+
			'<td >'+value.restaurantedireccion+'</td>'+
			'<td >'+value.restaurantetelefono+'</td>'+
			'<td >'+value.restaurantecorreo+'</td>'+
			'<td >'+value.restauranteruc+'</td>'+
			'<td >'+value.restauranterazon+'</td>'+
			'<td >'+value.restaurantenrocuenta+'</td>'+
			'<td >'+value.restauranteubigeo+'</td>'+
			'<td >'+value.restaurantelatitud+'</td>'+
			'<td >'+value.restaurantelongitud+'</td>'+
			'<td class = "hidden -xs">' + ((value.restauranteestado == '1') ? 'ACTIVO' : 'DESACTIVO') + '</td>'+

			'<td>'+
				'<div class="row">'+
					'<div style="margin: auto;">'+
						'<button type="button" onclick="btnEditarRestaurante(\''+value.idtrestaurante+'\')" class="btn btn-info btn-xs">'+
							'<span class="fa fa-search fa-sm"></span>'+
						'</button>'+
					'</div>'+
						'<div style="margin: auto;">'+
							'<a class="btn btn-success btn-xs" href="<?php echo base_url();?>/reserva/add"><i class="fa fa-pencil"></i></a>'+
					'</div>'+
				'</div>'+
			'</td>'+
		'</tr>';
		$('#TablaRestaurante tbody').append(fila);
		});
	}


	function addEstado(i){
		$('#estado_'+i).append($('<option>').val('1').text('ACTIVO'));
		$('#estado_'+i).append($('<option>').val('0').text('DESACTIVO'));
	}


	function addCatHabitacion(i) {
		var sel = document.getElementById('habitacion');
		var Length = sel.length;
		for (var j = 0; j < Length; j++) {
		var opt = sel[j];
		$('#catHabitacion_'+i).append($('<option>').val(opt.value).text(opt.label));            
		}
	}
</script>
