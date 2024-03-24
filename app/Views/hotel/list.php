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
										<th >Id</th>
										<th >Nombre</th>
										<th>Cathotel</th>
										<th >Idcat</th>
										<th >Direccion</th>
										<th >Telefono</th>
										<th >Correo</th>
										<th >Ruc</th>
										<th >Razonsocial</th>
										<th >Nrocuenta</th>
										<th>Banco</th>
										<th >Idbanco</th>
										<th >Ubigeo</th>
										<th >Latitud</th>
										<th >Longitud</th>
										<th >Estado</th>
										<th>Acciones</th>

									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $hotel):?>
											<tr>
												<td ><?php echo $hotel['idhotel'];?></td>
												<td ><?php echo $hotel['nombre'];?></td>
												<td><?php echo $hotel['nombre'];?></td>
												<td ><?php echo $hotel['idcathotel'];?></td>
												<td ><?php echo $hotel['direccion'];?></td>
												<td ><?php echo $hotel['telefono'];?></td>
												<td ><?php echo $hotel['correo'];?></td>
												<td ><?php echo $hotel['ruc'];?></td>
												<td ><?php echo $hotel['razonsocial'];?></td>
												<td ><?php echo $hotel['nrocuenta'];?></td>
												<td><?php echo $hotel['nombre'];?></td>
												<td ><?php echo $hotel['idbanco'];?></td>
												<td ><?php echo $hotel['ubigeo'];?></td>
												<td ><?php echo $hotel['latitud'];?></td>
												<td ><?php echo $hotel['longitud'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($hotel['estado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>

												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarHotel('<?php echo $hotel['idhotel'].'\',\''. $hotel['idbanco'].'\',\''. $hotel['idcathotel'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-search fa-xs'></span>
															</button>
														</div>
														<div style='margin: auto;'>
															<a class='btn btn-success btn-xs' href='<?php echo base_url();?>reserva/add/<?php echo $hotel['idhotel'].'\',\''. $hotel['idbanco'].'\',\''. $hotel['idcathotel'];?>'><i class='fa fa-pencil'></i></a>
														</div>
													</div>
												</td>
											</tr>
										<?php endforeach;?>
									<?php endif;?>
								</tbody>
							</table>
						</div>
						<div id='PaginadoHotel'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
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
					<label class='col-sm-4' for='id'>id:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='idhotel' name='idhotel' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>nombre:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='nombre' name='nombre' placeholder='T001' autocomplete = 'off'>
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
					<label class='col-sm-4' for='id'>direccion:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='direccion' name='direccion' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>telefono:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='telefono' name='telefono' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>correo:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='correo' name='correo' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>ruc:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='ruc' name='ruc' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>razonsocial:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='razonsocial' name='razonsocial' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>nrocuenta:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='nrocuenta' name='nrocuenta' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>ubigeo:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='ubigeo' name='ubigeo' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>latitud:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='latitud' name='latitud' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>longitud:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='longitud' name='longitud' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='rol'>estado:</label>
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
<div class='modal fade show' id='modal_agregar_tbanco' aria-modal='true' style='padding-right: 17px;z-index: 2500;'>
	<div class='modal-dialog modal-sm'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title'>Agregar Banco</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
			<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<label class='col-sm-3'>Banco:</label>
				<div class = 'col-sm-9'>
					<input type='text' class='form-control form-control-sm' id='IdNuevaBanco'>
				</div>
			</div>
		</div>
		<div class='modal-footer'>
			<button type='button' class='btn btn-success btn-sm' id='IdBtnNuevaBanco'>Agregar</button>
			<button type='button' class='btn btn-primary btn-sm' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<div class='modal fade show' id='modal_agregar_tcathotel' aria-modal='true' style='padding-right: 17px;z-index: 2500;'>
	<div class='modal-dialog modal-sm'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title'>Agregar Cathotel</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
			<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<label class='col-sm-3'>Cathotel:</label>
				<div class = 'col-sm-9'>
					<input type='text' class='form-control form-control-sm' id='IdNuevaCathotel'>
				</div>
			</div>
		</div>
		<div class='modal-footer'>
			<button type='button' class='btn btn-success btn-sm' id='IdBtnNuevaCathotel'>Agregar</button>
			<button type='button' class='btn btn-primary btn-sm' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>

<script>
	var NuevoHotel;
	var base_url= '<?php echo base_url();?>';


	function NumeroFilasTabla(){
		TamanioTabla = $('#tabla_Habitaciones tr').length - 1;
		$('#minmax').val(TamanioTabla)
	}


	function load(pag){
		RecolectarDatosHotel();
		EnviarInformacionHotel('leer', NuevoHotel, false, pag);
	}



	$('#idcathabitacion').autocomplete({ 
		source: function(request, response) {
			$.ajax({
				type: 'POST',
				url: base_url + '/hotelhabitacion/autocompletecathabitacions',
				dataType: 'json',
				data: { keyword: request.term },
				success: function(data){
					response($.map(data, function(item) {
						return {
							label: item.concatenado,
							concatenado: item.concatenado,
							idtour: item.idcathabitacion,
							nombre: item.nombre,

							
							concatenadodetalle: item.concatenadodetalle,

						}
					}))
				}
			});
		},
		minLength: 2,
		select: function( event, ui ) {
			$('#idcathabitacion').val('');
			var j = $('#tablaDetalleServicio tr').length;
			var i = parseInt((j == 1 ? 0 : $('#tablaDetalleServicio').find('tr').eq(j - 1).find('td').eq(0).html()));
			var rows = "<tr id=Fila_" + (i + 1) + ">"+
				"<td hidden>" + (i + 1) + "</td>"+
				"<td hidden><input type='text' class='form-control form-control-sm' id='detalleTipoServicio_" + (i + 1) + "' value='thotelhabitacion'></td>"+
				"<td hidden><input type='text' class='form-control form-control-sm' id='detalleIdReserva_" + (i + 1) + "' value=''></td>"+
				"<td>"+
					"<div class='row'>"+
						"<div style='margin: auto;'>"+
							"<a href='javascript:void(0)' style='color: #ef5350;' onClick='EliminarFila(" + (i + 1) + ")'><i class='fa fa-times'></i></a>"+
						"</div>"+
						"<div style='margin: auto;'>"+
							"<a href='javascript:void(0)' style='color: #007bff;' onClick='AgregarDatos(" + (i + 1) + ")'><i class='fa fa-pencil'></i></a>"+
						"</div>"+
					"</div>"+
				"</td>"+
				"<td>"+
					"<select class='form-control form-control-sm select2' id='detalleGravado_" + (i + 1) + "' style='width: 100%;'>"+
						"<option value='10'>GRAV</option>"+
						"<option value='20'>EXON</option>"+
						"<option value='30'>INAF</option>"+
						"<option value='40'>EXPO</option>"+
					"</select>"+
				"</td>"+
				"<td>" + ui.item.idtour + "</td>"+
				"<td>" + ui.item.concatenadodetalle + "</td>"+
				"<td><input type='text' class='form-control form-control-sm text-uppercase datepicker" + (i + 1) + "' id='detalleFecha_" + (i + 1) + "' readonly></td>"+
				"<td><input type='text' class='form-control form-control-sm text-uppercase numeroDerecha' id='detallecantidad_" + (i + 1) + "' placeholder='cantidad' value='1'></td>"+
				"<td><input type='text' class='form-control form-control-sm text-uppercase numeroDerecha' id='detalleprecio_" + (i + 1) + "' placeholder='precio' value='" + 0.00 + "'></td>"+
				"<td><input type='text' class='form-control form-control-sm text-uppercase numeroDerecha' id='detalletotal_" + (i + 1) + "' placeholder='total' value='' disabled></td>"+
				"<td>"+
					"<select class='form-control form-control-sm select2' id='detalleConfirmado_" + (i + 1) + "' style='width: 100%;'>"+
						"<option value='1'>CONFIRMADO</option>"+
						"<option value='2'>PENDIENTE</option>"+
						"<option value='3'>ANULADO</option>"+
					"</select>"+
				"</td>"+
				"<td>"+
					"<select class='form-control form-control-sm select2' id='detallePagado_" + (i + 1) + "' style='width: 100%;'>"+
						"<option value='0'>PAGADO</option>"+
						"<option value='0'>PENDIENTE</option>"+
					"</select>"+
				"</td>"+
				"<td>"+
					"<select class='form-control form-control-sm select2' id='detalleEstado_" + (i + 1) + "' style='width: 100%;'>"+
						"<option value='0'>ACTIVO</option>"+
						"<option value='0'>DESACTIVO</option>"+
					"</select>"+
				"</td>"+
			"</tr>";
			$('#tablaDetalleServicio').append(rows);
			addDatepicker(i + 1);
			ImporteTotalDetalle(i + 1);
			return false;
		}
	});



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


	function btnEditarHotel(Val0, Val1, Val2){
		$.ajax({
			type: 'POST',
			url: base_url + '/hotel/edit',
			data: { idhotel: Val0, idbanco: Val1, idcathotel: Val2},
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
		$('#idhotel').val('0');
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
		}
		if ($('#nombre').val() == ''){
			Resaltado('nombre');
			error++;
		}
		if ($('#idcathotel').val() == ''){
			Resaltado('idcathotel');
			error++;
		}
		if ($('#direccion').val() == ''){
			Resaltado('direccion');
			error++;
		}
		if ($('#telefono').val() == ''){
			Resaltado('telefono');
			error++;
		}
		if ($('#correo').val() == ''){
			Resaltado('correo');
			error++;
		}
		if ($('#ruc').val() == ''){
			Resaltado('ruc');
			error++;
		}
		if ($('#razonsocial').val() == ''){
			Resaltado('razonsocial');
			error++;
		}
		if ($('#nrocuenta').val() == ''){
			Resaltado('nrocuenta');
			error++;
		}
		if ($('#idbanco').val() == ''){
			Resaltado('idbanco');
			error++;
		}
		if ($('#ubigeo').val() == ''){
			Resaltado('ubigeo');
			error++;
		}
		if ($('#latitud').val() == ''){
			Resaltado('latitud');
			error++;
		}
		if ($('#longitud').val() == ''){
			Resaltado('longitud');
			error++;
		}
		if ($('#estado').val() == ''){
			Resaltado('estado');
			error++;
		}

		return error;
	}


	function Resaltado(id){
		$('#'+id).css('border-color', '#ef5350');
		$('#'+id).focus();
	}


	function CargartablaHotel(objeto){   
		$('#TablaHotel tr').not($('#TablaHotel tr:first')).remove();
		$.each(objeto, function(i, value) {
		var fila = '<tr>'+
			'<td >'+value.idhotel+'</td>'+
			'<td >'+value.nombre+'</td>'+
			'<td>'+value.nombre+'</td>'+
			'<td >'+value.idcathotel+'</td>'+
			'<td >'+value.direccion+'</td>'+
			'<td >'+value.telefono+'</td>'+
			'<td >'+value.correo+'</td>'+
			'<td >'+value.ruc+'</td>'+
			'<td >'+value.razonsocial+'</td>'+
			'<td >'+value.nrocuenta+'</td>'+
			'<td>'+value.nombre+'</td>'+
			'<td >'+value.idbanco+'</td>'+
			'<td >'+value.ubigeo+'</td>'+
			'<td >'+value.latitud+'</td>'+
			'<td >'+value.longitud+'</td>'+
			'<td class = "hidden -xs">' + ((value.estado == '1') ? 'ACTIVO' : 'DESACTIVO') + '</td>'+

			'<td>'+
				'<div class="row">'+
					'<div style="margin: auto;">'+
						'<button type="button" onclick="btnEditarHotel(\''+value.idhotel+'\', \''+value.idbanco+'\', \''+value.idcathotel+'\')" class="btn btn-info btn-xs">'+
							'<span class="fa fa-search fa-sm"></span>'+
						'</button>'+
					'</div>'+
						'<div style="margin: auto;">'+
							'<a class="btn btn-success btn-xs" href="<?php echo base_url();?>/reserva/add"><i class="fa fa-pencil"></i></a>'+
					'</div>'+
				'</div>'+
			'</td>'+
		'</tr>';
		$('#TablaHotel tbody').append(fila);
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
