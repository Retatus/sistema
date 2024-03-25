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
								<button type='button' class='btn btn-info btn-sm' id='btnAgregarHorariotren'>
									<span class='fa fa-plus'></span> Agregar Horariotren
								</button>
								<a href='<?php echo base_url();?>horariotren/excel' class='btn btn-success btn-sm'>
									<span class='fa fa-file-excel'></span> Exportar
								</a>
								<a href='<?php echo base_url();?>horariotren/pdf' target='_blank' class='btn btn-danger btn-sm'>
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
												<button type='button' class='btn btn-info btn-sm' id='btnFiltroHorariotren'>
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
							<table id='TablaHorariotren' class='table table-sm table-bordered table-striped'>
								<thead>
									<tr>
										<th hidden>Id</th>
										<th>Tren</th>
										<th hidden>Idtren</th>
										<th>Horatren</th>
										<th hidden>Idhorario</th>
										<th >Precio</th>
										<th >Estado</th>
										<th>Acciones</th>

									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $horariotren):?>
											<tr>
												<td hidden><?php echo $horariotren['idhorariotren'];?></td>
												<td><?php echo $horariotren['nombre'];?></td>
												<td hidden><?php echo $horariotren['idtren'];?></td>
												<td><?php echo $horariotren['nombre'];?></td>
												<td hidden><?php echo $horariotren['idhorario'];?></td>
												<td ><?php echo $horariotren['precio'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($horariotren['estado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>

												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarHorariotren('<?php echo $horariotren['idhorariotren'].'\',\''. $horariotren['idhorario'].'\',\''. $horariotren['idtren'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-search fa-xs'></span>
															</button>
														</div>
														<div style='margin: auto;'>
															<a class='btn btn-success btn-xs' href='<?php echo base_url();?>reserva/add/<?php echo $horariotren['idhorariotren'].'\',\''. $horariotren['idhorario'].'\',\''. $horariotren['idtren'];?>'><i class='fa fa-pencil'></i></a>
														</div>
													</div>
												</td>
											</tr>
										<?php endforeach;?>
									<?php endif;?>
								</tbody>
							</table>
						</div>
						<div id='PaginadoHorariotren'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<div class='modal fade' id='modalAgregarHorariotren' tabindex='-1'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title' id='modaldeltalletour'>Detalle Horariotren</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<div class='col-6 form-group row'hidden>
					<label class='col-sm-4' for='id'>id:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='idhorariotren' name='idhorariotren' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4'>Horatren:</label>
					<div class = 'col-sm-8'>
						<select class='form-control form-control-sm select2' id='idhorario'>
							<option value='0'>-- SELECCIONAR1 --</option>
							<?php if (!empty($horatrens)):?>
								<?php foreach($horatrens as $horatren):?>
									<option value= '<?php echo $horatren['idhorario'];?>'><?php echo $horatren['concatenado'];?></option>
								<?php endforeach;?>
							<?php endif;?>
						</select>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4'>Tren:</label>
					<div class = 'col-sm-8'>
						<select class='form-control form-control-sm select2' id='idtren'>
							<option value='0'>-- SELECCIONAR1 --</option>
							<?php if (!empty($trens)):?>
								<?php foreach($trens as $tren):?>
									<option value= '<?php echo $tren['idtren'];?>'><?php echo $tren['concatenado'];?></option>
								<?php endforeach;?>
							<?php endif;?>
						</select>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>precio:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='precio' name='precio' placeholder='T001' autocomplete = 'off'>
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
			<button type='button' class='btn btn-success btn-sm' id='btnModalAgregarHorariotren'>Agregar</button>
			<button type='button' class='btn btn-warning btn-sm' id='btnModalEditarHorariotren'>Modificar</button>
			<button type='button' class='btn btn-danger btn-sm' id='btnModalEliminarHorariotren'>Eliminar</button>
			<button type='button' class='btn btn-primary btn-sm' id='btnModalCerrarHorariotren' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<div class='modal fade show' id='modal_agregar_thoratren' aria-modal='true' style='padding-right: 17px;z-index: 2500;'>
	<div class='modal-dialog modal-sm'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title'>Agregar Horatren</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
			<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<label class='col-sm-3'>Horatren:</label>
				<div class = 'col-sm-9'>
					<input type='text' class='form-control form-control-sm' id='IdNuevaHoratren'>
				</div>
			</div>
		</div>
		<div class='modal-footer'>
			<button type='button' class='btn btn-success btn-sm' id='IdBtnNuevaHoratren'>Agregar</button>
			<button type='button' class='btn btn-primary btn-sm' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<div class='modal fade show' id='modal_agregar_ttren' aria-modal='true' style='padding-right: 17px;z-index: 2500;'>
	<div class='modal-dialog modal-sm'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title'>Agregar Tren</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
			<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<label class='col-sm-3'>Tren:</label>
				<div class = 'col-sm-9'>
					<input type='text' class='form-control form-control-sm' id='IdNuevaTren'>
				</div>
			</div>
		</div>
		<div class='modal-footer'>
			<button type='button' class='btn btn-success btn-sm' id='IdBtnNuevaTren'>Agregar</button>
			<button type='button' class='btn btn-primary btn-sm' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>

<script>
	var NuevoHorariotren;
	var base_url= '<?php echo base_url();?>';


	function NumeroFilasTabla(){
		TamanioTabla = $('#tabla_Habitaciones tr').length - 1;
		$('#minmax').val(TamanioTabla)
	}


	function load(pag){
		RecolectarDatosHorariotren();
		EnviarInformacionHorariotren('leer', NuevoHorariotren, false, pag);
	}



	$('#idreserva').autocomplete({ 
		source: function(request, response) {
			$.ajax({
				type: 'POST',
				url: base_url + '/reservadetallehorariotren/autocompletereservas',
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
				"<td hidden><input type='text' class='form-control form-control-sm' id='detalleTipoServicio_" + (i + 1) + "' value='treservadetallehorariotren'></td>"+
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



	$('#btnAgregarHorariotren').click(function(){
		LimpiarModalDatosHorariotren();
		$('#categoria').val(1);
		$('#id').prop('readonly', false);  
		$('#IdModalGrupoCodigoHotel').prop('hidden', false);
		$('#btnModalAgregarHorariotren').toggle(true);
		$('#btnModalEditarHorariotren').toggle(false);
		$('#btnModalEliminarHorariotren').toggle(false);
		$('#modalAgregarHorariotren').modal();
	});


	function btnEditarHorariotren(Val0, Val1, Val2){
		$.ajax({
			type: 'POST',
			url: base_url + '/horariotren/edit',
			data: { idhorariotren: Val0, idhorario: Val1, idtren: Val2},
			success: function(msg){
		debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosHorariotren();
				$('#idhorariotren').val(temp.idhorariotren);
				$('#idtren').select2().val(temp.idtren).select2('destroy').select2();
				$('#idhorario').select2().val(temp.idhorario).select2('destroy').select2();
				$('#precio').val(temp.precio);
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


				$('#btnModalAgregarHorariotren').toggle(false);
				$('#btnModalEditarHorariotren').toggle(true);
				$('#btnModalEliminarHorariotren').toggle(true);
				$('#modalAgregarHorariotren').modal('toggle');
			},
			error: function(){
				alert('Hay un error...');
			}
		});
	}


	$('#btnModalAgregarHorariotren').click(function(){
debugger

		if (ValidarCamposVaciosHorariotren() != 0) {
			alert('Completar campos obligatorios');
		}else{
			$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
			RecolectarDatosHorariotren();
			EnviarInformacionHorariotren('agregar', NuevoHorariotren, true);
		}
	});


	$('#btnModalEditarHorariotren').click(function(){
		if (ValidarCamposVaciosHorariotren() != 0) {
			alert('Completar campos obligatorios');
		}else{
			RecolectarDatosHorariotren();
			EnviarInformacionHorariotren('modificar', NuevoHorariotren, true);
		}
	});


	$('#btnModalEliminarHorariotren').click(function(){
		var bool=confirm('ESTA SEGURO DE ELIMINAR EL DATO?');
		if(bool){
			RecolectarDatosHorariotren();
			EnviarInformacionHorariotren('eliminar', NuevoHorariotren, true);
		}
	});


	$('#btnModalCerrarHotel').click(function(){
		$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
		LimpiarModalDatosHorariotren();
	});


	$('#btnFiltroHorariotren').click(function(){
		RecolectarDatosHorariotren();
		EnviarInformacionHorariotren('leer', NuevoHorariotren, false);
	});


	function Paginado(pag) {
		RecolectarDatosHorariotren();
		EnviarInformacionHorariotren('leer', NuevoHorariotren, false, pag);
	}


	function RecolectarDatosHorariotren(){
		NuevoHorariotren = {
			idhorariotren: $('#idhorariotren').val().toUpperCase(),
			idtren: $('#idtren').val().toUpperCase(),
			idhorario: $('#idhorario').val().toUpperCase(),
			precio: $('#precio').val().toUpperCase(),
			estado: $('#estado').val().toUpperCase(),

			todos: $('#idFTodos').val(),
			texto: $('#idFTexto').val()
		};
	}


	function EnviarInformacionHorariotren(accion, objEvento, modal, pag=1) { 
		$.ajax({
			type: 'POST',
			url: base_url+'/horariotren/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				var resp = JSON.parse(msg);
				$('#PaginadoHorariotren').empty();
				$('#PaginadoHorariotren').append(resp.pag);
				if (modal) {
					$('#modalAgregarHorariotren').modal('toggle');
					LimpiarModalDatosHorariotren();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								CargartablaHorariotren(resp.datos)
							}
						})
					} else {
						Swal.fire({
							title: resp.mensaje,
							icon: 'error'
						})
					}
				}else{
					CargartablaHorariotren(resp.datos)
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


	function LimpiarModalDatosHorariotren(){
		$('#idhorariotren').val('0');
		$('#idtren').select2().val(0).select2('destroy').select2();
		$('#idhorario').select2().val(0).select2('destroy').select2();
		$('#precio').val('');

	}


	function ValidarCamposVaciosHorariotren(){
		var error = 0;
		if ($('#idhorariotren').val() == ''){
			Resaltado('idhorariotren');
			error++;
		}
		if ($('#idtren').val() == ''){
			Resaltado('idtren');
			error++;
		}
		if ($('#idhorario').val() == ''){
			Resaltado('idhorario');
			error++;
		}
		if ($('#precio').val() == ''){
			Resaltado('precio');
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


	function CargartablaHorariotren(objeto){   
		$('#TablaHorariotren tr').not($('#TablaHorariotren tr:first')).remove();
		$.each(objeto, function(i, value) {
		var fila = '<tr>'+
			'<td hidden>'+value.idhorariotren+'</td>'+
			'<td>'+value.nombre+'</td>'+
			'<td hidden>'+value.idtren+'</td>'+
			'<td>'+value.nombre+'</td>'+
			'<td hidden>'+value.idhorario+'</td>'+
			'<td >'+value.precio+'</td>'+
			'<td class = "hidden -xs">' + ((value.estado == '1') ? 'ACTIVO' : 'DESACTIVO') + '</td>'+

			'<td>'+
				'<div class="row">'+
					'<div style="margin: auto;">'+
						'<button type="button" onclick="btnEditarHorariotren(\''+value.idhorariotren+'\', \''+value.idhorario+'\', \''+value.idtren+'\')" class="btn btn-info btn-xs">'+
							'<span class="fa fa-search fa-sm"></span>'+
						'</button>'+
					'</div>'+
						'<div style="margin: auto;">'+
							'<a class="btn btn-success btn-xs" href="<?php echo base_url();?>/reserva/add"><i class="fa fa-pencil"></i></a>'+
					'</div>'+
				'</div>'+
			'</td>'+
		'</tr>';
		$('#TablaHorariotren tbody').append(fila);
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
