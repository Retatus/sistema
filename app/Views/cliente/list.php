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
								<button type='button' class='btn btn-info btn-sm' id='btnAgregarCliente'>
									<span class='fa fa-plus'></span> Agregar Cliente
								</button>
								<a href='<?php echo base_url();?>cliente/excel' class='btn btn-success btn-sm'>
									<span class='fa fa-file-excel'></span> Exportar
								</a>
								<a href='<?php echo base_url();?>cliente/pdf' target='_blank' class='btn btn-danger btn-sm'>
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
												<button type='button' class='btn btn-info btn-sm' id='btnFiltroCliente'>
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
							<table id='TablaCliente' class='table table-sm table-bordered table-striped'>
								<thead>
									<tr>
										<th >Id</th>
										<th>Tipodoc</th>
										<th hidden>Idtipodoc</th>
										<th >Nombre</th>
										<th >Apellidos</th>
										<th >Telefono</th>
										<th >Correo</th>
										<th >Direccion</th>
										<th >Pais</th>
										<th >Fechanacimiento</th>
										<th >Edad</th>
										<th >Sexo</th>
										<th >Estado</th>
										<th>Acciones</th>

									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $cliente):?>
											<tr>
												<td ><?php echo $cliente['idcliente'];?></td>
												<td><?php echo $cliente['nombre'];?></td>
												<td hidden><?php echo $cliente['idtipodoc'];?></td>
												<td ><?php echo $cliente['clientenombre'];?></td>
												<td ><?php echo $cliente['clienteapellidos'];?></td>
												<td ><?php echo $cliente['clientetelefono'];?></td>
												<td ><?php echo $cliente['clientecorreo'];?></td>
												<td ><?php echo $cliente['clientedireccion'];?></td>
												<td ><?php echo $cliente['clientepais'];?></td>
												<td ><?php echo $cliente['clientefechanacimiento'];?></td>
												<td ><?php echo $cliente['clienteedad'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($cliente['clientesexo']== 1) ? 'M' : 'F';?></td>
												<td class = 'hidden-xs'><?php echo $est = ($cliente['clienteestado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>

												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarCliente('<?php echo $cliente['idcliente'].'\',\''. $cliente['idtipodoc'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-search fa-xs'></span>
															</button>
														</div>
														<div style='margin: auto;'>
															<a class='btn btn-success btn-xs' href='<?php echo base_url();?>reserva/add/<?php echo $cliente['idcliente'].'\',\''. $cliente['idtipodoc'];?>'><i class='fa fa-pencil'></i></a>
														</div>
													</div>
												</td>
											</tr>
										<?php endforeach;?>
									<?php endif;?>
								</tbody>
							</table>
						</div>
						<div id='PaginadoCliente'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<div class='modal fade' id='modalAgregarCliente' tabindex='-1'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title' id='modaldeltalletour'>Detalle Cliente</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>id:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='idcliente' name='idcliente' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4'>Tipodoc:</label>
					<div class = 'col-sm-8'>
						<select class='form-control form-control-sm select2' id='idtipodoc'>
							<option value='0'>-- SELECCIONAR1 --</option>
							<?php if (!empty($tipodocs)):?>
								<?php foreach($tipodocs as $tipodoc):?>
									<option value= '<?php echo $tipodoc['idtipodoc'];?>'><?php echo $tipodoc['concatenado'];?></option>
								<?php endforeach;?>
							<?php endif;?>
						</select>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>nombre:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='clientenombre' name='clientenombre' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>apellidos:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='clienteapellidos' name='clienteapellidos' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>telefono:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='clientetelefono' name='clientetelefono' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>correo:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='clientecorreo' name='clientecorreo' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>direccion:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='clientedireccion' name='clientedireccion' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>pais:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='clientepais' name='clientepais' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4'>fechanacimiento:</label>
					<div class='col-sm-8'>
						<div class='input-group'>
							<div class='input-group-prepend'>
								<span class='input-group-text'>
									<i class='far fa-calendar-alt'></i>
								</span>
							</div>
							<input type='text' class='form-control form-control-sm' id='clientefechanacimiento' name='clientefechanacimiento' placeholder='dd/mm/yyyy' readonly>
						</div>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>edad:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='clienteedad' name='clienteedad' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>sexo:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='clientesexo' name='clientesexo' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='rol'>estado:</label>
					<div class='col-sm-8'>
						<select class='form-control form-control-sm' id='clienteestado' name='clienteestado'>
							<option value = '1' selected >ACTIVO</option>
							<option value = '0' >DESACTIVO</option>
						</select>
					</div>
				</div>

			</div>
		</div>
		<div class='modal-footer'>
			<button type='button' class='btn btn-success btn-sm' id='btnModalAgregarCliente'>Agregar</button>
			<button type='button' class='btn btn-warning btn-sm' id='btnModalEditarCliente'>Modificar</button>
			<button type='button' class='btn btn-danger btn-sm' id='btnModalEliminarCliente'>Eliminar</button>
			<button type='button' class='btn btn-primary btn-sm' id='btnModalCerrarCliente' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<div class='modal fade show' id='modal_agregar_ttipodoc' aria-modal='true' style='padding-right: 17px;z-index: 2500;'>
	<div class='modal-dialog modal-sm'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title'>Agregar Tipodoc</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
			<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<label class='col-sm-3'>Tipodoc:</label>
				<div class = 'col-sm-9'>
					<input type='text' class='form-control form-control-sm' id='IdNuevaTipodoc'>
				</div>
			</div>
		</div>
		<div class='modal-footer'>
			<button type='button' class='btn btn-success btn-sm' id='IdBtnNuevaTipodoc'>Agregar</button>
			<button type='button' class='btn btn-primary btn-sm' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>

<script>
	var NuevoCliente;
	var base_url= '<?php echo base_url();?>';


	function NumeroFilasTabla(){
		TamanioTabla = $('#tabla_Habitaciones tr').length - 1;
		$('#minmax').val(TamanioTabla)
	}


	function load(pag){
		RecolectarDatosCliente();
		EnviarInformacionCliente('leer', NuevoCliente, false, pag);
	}


	$('#clientefechanacimiento').datepicker({
		language: 'es',
		todayBtn: 'linked',
		clearBtn: true,
		format: 'mm/dd/yyyy',
		multidate: false,
		todayHighlight: true
	});

	$('#idreserva').autocomplete({ 
		source: function(request, response) {
			$.ajax({
				type: 'POST',
				url: base_url + '/reservadetallecliente/autocompletereservas',
				dataType: 'json',
				data: { keyword: request.term },
				success: function(data){
					response($.map(data, function(item) {
						return {
							label: item.concatenado,
							concatenado: item.concatenado,
							idtour: item.idreserva,
							nombre: item.reservanombre,

							
							concatenadodetalle: item.concatenadodetalle,

						}
					}))
				}
			});
		},
		minLength: 2,
		select: function( event, ui ) {
			$('#idreserva').val('');
			var j = $('#tablaDetalleServicio tr').length;
			var i = parseInt((j == 1 ? 0 : $('#tablaDetalleServicio').find('tr').eq(j - 1).find('td').eq(0).html()));
			var rows = "<tr id=Fila_" + (i + 1) + ">"+
				"<td hidden>" + (i + 1) + "</td>"+
				"<td hidden><input type='text' class='form-control form-control-sm' id='detalleTipoServicio_" + (i + 1) + "' value='treservadetallecliente'></td>"+
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



	$('#btnAgregarCliente').click(function(){
		LimpiarModalDatosCliente();
		$('#categoria').val(1);
		$('#id').prop('readonly', false);  
		$('#IdModalGrupoCodigoHotel').prop('hidden', false);
		$('#btnModalAgregarCliente').toggle(true);
		$('#btnModalEditarCliente').toggle(false);
		$('#btnModalEliminarCliente').toggle(false);
		$('#modalAgregarCliente').modal();
	});


	function btnEditarCliente(Val0, Val1){
		$.ajax({
			type: 'POST',
			url: base_url + '/cliente/edit',
			data: { idcliente: Val0, idtipodoc: Val1},
			success: function(msg){
		debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosCliente();
				$('#idcliente').val(temp.idcliente);
				$('#idtipodoc').select2().val(temp.idtipodoc).select2('destroy').select2();
				$('#clientenombre').val(temp.clientenombre);
				$('#clienteapellidos').val(temp.clienteapellidos);
				$('#clientetelefono').val(temp.clientetelefono);
				$('#clientecorreo').val(temp.clientecorreo);
				$('#clientedireccion').val(temp.clientedireccion);
				$('#clientepais').val(temp.clientepais);
				$('#clientefechanacimiento').val(temp.clientefechanacimiento);
				$('#clienteedad').val(temp.clienteedad);
				$('#clientesexo').val(temp.clientesexo);
				$('#clienteestado').val(temp.clienteestado);



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


				$('#btnModalAgregarCliente').toggle(false);
				$('#btnModalEditarCliente').toggle(true);
				$('#btnModalEliminarCliente').toggle(true);
				$('#modalAgregarCliente').modal('toggle');
			},
			error: function(){
				alert('Hay un error...');
			}
		});
	}


	$('#btnModalAgregarCliente').click(function(){
debugger

		if (ValidarCamposVaciosCliente() != 0) {
			alert('Completar campos obligatorios');
		}else{
			$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
			RecolectarDatosCliente();
			EnviarInformacionCliente('agregar', NuevoCliente, true);
		}
	});


	$('#btnModalEditarCliente').click(function(){
		if (ValidarCamposVaciosCliente() != 0) {
			alert('Completar campos obligatorios');
		}else{
			RecolectarDatosCliente();
			EnviarInformacionCliente('modificar', NuevoCliente, true);
		}
	});


	$('#btnModalEliminarCliente').click(function(){
		var bool=confirm('ESTA SEGURO DE ELIMINAR EL DATO?');
		if(bool){
			RecolectarDatosCliente();
			EnviarInformacionCliente('eliminar', NuevoCliente, true);
		}
	});


	$('#btnModalCerrarHotel').click(function(){
		$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
		LimpiarModalDatosCliente();
	});


	$('#btnFiltroCliente').click(function(){
		RecolectarDatosCliente();
		EnviarInformacionCliente('leer', NuevoCliente, false);
	});


	function Paginado(pag) {
		RecolectarDatosCliente();
		EnviarInformacionCliente('leer', NuevoCliente, false, pag);
	}


	function RecolectarDatosCliente(){
		NuevoCliente = {
			idcliente: $('#idcliente').val().toUpperCase(),
			idtipodoc: $('#idtipodoc').val().toUpperCase(),
			clientenombre: $('#clientenombre').val().toUpperCase(),
			clienteapellidos: $('#clienteapellidos').val().toUpperCase(),
			clientetelefono: $('#clientetelefono').val().toUpperCase(),
			clientecorreo: $('#clientecorreo').val().toUpperCase(),
			clientedireccion: $('#clientedireccion').val().toUpperCase(),
			clientepais: $('#clientepais').val().toUpperCase(),
			clientefechanacimiento: $('#clientefechanacimiento').val().toUpperCase(),
			clienteedad: $('#clienteedad').val().toUpperCase(),
			clientesexo: $('#clientesexo').val().toUpperCase(),
			clienteestado: $('#clienteestado').val().toUpperCase(),

			todos: $('#idFTodos').val(),
			texto: $('#idFTexto').val()
		};
	}


	function EnviarInformacionCliente(accion, objEvento, modal, pag=1) { 
		$.ajax({
			type: 'POST',
			url: base_url+'/cliente/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				var resp = JSON.parse(msg);
				$('#PaginadoCliente').empty();
				$('#PaginadoCliente').append(resp.pag);
				if (modal) {
					$('#modalAgregarCliente').modal('toggle');
					LimpiarModalDatosCliente();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								CargartablaCliente(resp.datos)
							}
						})
					} else {
						Swal.fire({
							title: resp.mensaje,
							icon: 'error'
						})
					}
				}else{
					CargartablaCliente(resp.datos)
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


	function LimpiarModalDatosCliente(){
		$('#idcliente').val('0');
		$('#idtipodoc').select2().val(0).select2('destroy').select2();
		$('#clientenombre').val('');
		$('#clienteapellidos').val('');
		$('#clientetelefono').val('');
		$('#clientecorreo').val('');
		$('#clientedireccion').val('');
		$('#clientepais').val('');
		$('#clientefechanacimiento').val('');
		$('#clienteedad').val('');

	}


	function ValidarCamposVaciosCliente(){
		var error = 0;
		if ($('#idcliente').val() == ''){
			Resaltado('idcliente');
			error++;
		}
		if ($('#idtipodoc').val() == ''){
			Resaltado('idtipodoc');
			error++;
		}
		if ($('#clientenombre').val() == ''){
			Resaltado('clientenombre');
			error++;
		}
		if ($('#clienteapellidos').val() == ''){
			Resaltado('clienteapellidos');
			error++;
		}
		if ($('#clientetelefono').val() == ''){
			Resaltado('clientetelefono');
			error++;
		}
		if ($('#clientecorreo').val() == ''){
			Resaltado('clientecorreo');
			error++;
		}
		if ($('#clientedireccion').val() == ''){
			Resaltado('clientedireccion');
			error++;
		}
		if ($('#clientepais').val() == ''){
			Resaltado('clientepais');
			error++;
		}
		if ($('#clientefechanacimiento').val() == ''){
			Resaltado('clientefechanacimiento');
			error++;
		}
		if ($('#clienteedad').val() == ''){
			Resaltado('clienteedad');
			error++;
		}
		if ($('#clientesexo').val() == ''){
			Resaltado('clientesexo');
			error++;
		}
		if ($('#clienteestado').val() == ''){
			Resaltado('clienteestado');
			error++;
		}

		return error;
	}


	function Resaltado(id){
		$('#'+id).css('border-color', '#ef5350');
		$('#'+id).focus();
	}


	function CargartablaCliente(objeto){   
		$('#TablaCliente tr').not($('#TablaCliente tr:first')).remove();
		$.each(objeto, function(i, value) {
		var fila = '<tr>'+
			'<td >'+value.idcliente+'</td>'+
			'<td>'+value.nombre+'</td>'+
			'<td hidden>'+value.idtipodoc+'</td>'+
			'<td >'+value.clientenombre+'</td>'+
			'<td >'+value.clienteapellidos+'</td>'+
			'<td >'+value.clientetelefono+'</td>'+
			'<td >'+value.clientecorreo+'</td>'+
			'<td >'+value.clientedireccion+'</td>'+
			'<td >'+value.clientepais+'</td>'+
			'<td >'+value.clientefechanacimiento+'</td>'+
			'<td >'+value.clienteedad+'</td>'+
			'<td class = "hidden -xs">' + ((value.clientesexo == '1') ? 'M' : 'F') + '</td>'+
			'<td class = "hidden -xs">' + ((value.clienteestado == '1') ? 'ACTIVO' : 'DESACTIVO') + '</td>'+

			'<td>'+
				'<div class="row">'+
					'<div style="margin: auto;">'+
						'<button type="button" onclick="btnEditarCliente(\''+value.idcliente+'\', \''+value.idtipodoc+'\')" class="btn btn-info btn-xs">'+
							'<span class="fa fa-search fa-sm"></span>'+
						'</button>'+
					'</div>'+
						'<div style="margin: auto;">'+
							'<a class="btn btn-success btn-xs" href="<?php echo base_url();?>/reserva/add"><i class="fa fa-pencil"></i></a>'+
					'</div>'+
				'</div>'+
			'</td>'+
		'</tr>';
		$('#TablaCliente tbody').append(fila);
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
