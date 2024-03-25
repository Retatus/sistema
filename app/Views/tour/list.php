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
								<button type='button' class='btn btn-info btn-sm' id='btnAgregarTour'>
									<span class='fa fa-plus'></span> Agregar Tour
								</button>
								<a href='<?php echo base_url();?>tour/excel' class='btn btn-success btn-sm'>
									<span class='fa fa-file-excel'></span> Exportar
								</a>
								<a href='<?php echo base_url();?>tour/pdf' target='_blank' class='btn btn-danger btn-sm'>
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
												<button type='button' class='btn btn-info btn-sm' id='btnFiltroTour'>
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
							<table id='TablaTour' class='table table-sm table-bordered table-striped'>
								<thead>
									<tr>
										<th >Id</th>
										<th >Nombre</th>
										<th >Descripcion</th>
										<th >Precio</th>
										<th >Color</th>
										<th >Diashabiles</th>
										<th >Estado</th>
										<th>Cattour</th>
										<th hidden>Idcat</th>
										<th>Acciones</th>

									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $tour):?>
											<tr>
												<td ><?php echo $tour['idtour'];?></td>
												<td ><?php echo $tour['tournombre'];?></td>
												<td ><?php echo $tour['tourdescripcion'];?></td>
												<td ><?php echo $tour['tourprecio'];?></td>
												<td><i class='fa fa-circle' style='color:<?php echo $tour['color'];?>'></i> <?php echo $tour['idtour'];?></td>
												<td ><?php echo $tour['tourdiashabiles'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($tour['tourestado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>
												<td><?php echo $tour['nombre'];?></td>
												<td hidden><?php echo $tour['idcattour'];?></td>

												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarTour('<?php echo $tour['idtour'].'\',\''. $tour['idcattour'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-search fa-xs'></span>
															</button>
														</div>
														<div style='margin: auto;'>
															<a class='btn btn-success btn-xs' href='<?php echo base_url();?>reserva/add/<?php echo $tour['idtour'].'\',\''. $tour['idcattour'];?>'><i class='fa fa-pencil'></i></a>
														</div>
													</div>
												</td>
											</tr>
										<?php endforeach;?>
									<?php endif;?>
								</tbody>
							</table>
						</div>
						<div id='PaginadoTour'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<div class='modal fade' id='modalAgregarTour' tabindex='-1'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title' id='modaldeltalletour'>Detalle Tour</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>id:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='idtour' name='idtour' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>nombre:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='tournombre' name='tournombre' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-12 form-group row'>
					<label class='col-sm-2' for='id'>descripcion:</label>
					<div class = 'col-sm-10'>
						<textarea type='text' class='form-control form-control-sm text-uppercase    123' id='tourdescripcion' name='tourdescripcion' placeholder='T001' autocomplete = 'off'></textarea>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>precio:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='tourprecio' name='tourprecio' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>color:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='color' name='color' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>diashabiles:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='tourdiashabiles' name='tourdiashabiles' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='rol'>estado:</label>
					<div class='col-sm-8'>
						<select class='form-control form-control-sm' id='tourestado' name='tourestado'>
							<option value = '1' selected >ACTIVO</option>
							<option value = '0' >DESACTIVO</option>
						</select>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4'>Cattour:</label>
					<div class = 'col-sm-8'>
						<select class='form-control form-control-sm select2' id='idcattour'>
							<option value='0'>-- SELECCIONAR1 --</option>
							<?php if (!empty($cattours)):?>
								<?php foreach($cattours as $cattour):?>
									<option value= '<?php echo $cattour['idcattour'];?>'><?php echo $cattour['concatenado'];?></option>
								<?php endforeach;?>
							<?php endif;?>
						</select>
					</div>
				</div>

			</div>
		</div>
		<div class='modal-footer'>
			<button type='button' class='btn btn-success btn-sm' id='btnModalAgregarTour'>Agregar</button>
			<button type='button' class='btn btn-warning btn-sm' id='btnModalEditarTour'>Modificar</button>
			<button type='button' class='btn btn-danger btn-sm' id='btnModalEliminarTour'>Eliminar</button>
			<button type='button' class='btn btn-primary btn-sm' id='btnModalCerrarTour' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<div class='modal fade show' id='modal_agregar_tcattour' aria-modal='true' style='padding-right: 17px;z-index: 2500;'>
	<div class='modal-dialog modal-sm'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title'>Agregar Cattour</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
			<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<label class='col-sm-3'>Cattour:</label>
				<div class = 'col-sm-9'>
					<input type='text' class='form-control form-control-sm' id='IdNuevaCattour'>
				</div>
			</div>
		</div>
		<div class='modal-footer'>
			<button type='button' class='btn btn-success btn-sm' id='IdBtnNuevaCattour'>Agregar</button>
			<button type='button' class='btn btn-primary btn-sm' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>

<script>
	var NuevoTour;
	var base_url= '<?php echo base_url();?>';


	function NumeroFilasTabla(){
		TamanioTabla = $('#tabla_Habitaciones tr').length - 1;
		$('#minmax').val(TamanioTabla)
	}


	function load(pag){
		RecolectarDatosTour();
		EnviarInformacionTour('leer', NuevoTour, false, pag);
	}



	$('#idreserva').autocomplete({ 
		source: function(request, response) {
			$.ajax({
				type: 'POST',
				url: base_url + '/reservadetalletour/autocompletereservas',
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
				"<td hidden><input type='text' class='form-control form-control-sm' id='detalleTipoServicio_" + (i + 1) + "' value='treservadetalletour'></td>"+
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



	$('#btnAgregarTour').click(function(){
		LimpiarModalDatosTour();
		$('#categoria').val(1);
		$('#id').prop('readonly', false);  
		$('#IdModalGrupoCodigoHotel').prop('hidden', false);
		$('#btnModalAgregarTour').toggle(true);
		$('#btnModalEditarTour').toggle(false);
		$('#btnModalEliminarTour').toggle(false);
		$('#modalAgregarTour').modal();
	});


	function btnEditarTour(Val0, Val1){
		$.ajax({
			type: 'POST',
			url: base_url + '/tour/edit',
			data: { idtour: Val0, idcattour: Val1},
			success: function(msg){
		debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosTour();
				$('#idtour').val(temp.idtour);
				$('#tournombre').val(temp.tournombre);
				$('#tourdescripcion').val(temp.tourdescripcion);
				$('#tourprecio').val(temp.tourprecio);
				$('#color').val(temp.color);
				$('#tourdiashabiles').val(temp.tourdiashabiles);
				$('#tourestado').val(temp.tourestado);
				$('#idcattour').select2().val(temp.idcattour).select2('destroy').select2();



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


				$('#btnModalAgregarTour').toggle(false);
				$('#btnModalEditarTour').toggle(true);
				$('#btnModalEliminarTour').toggle(true);
				$('#modalAgregarTour').modal('toggle');
			},
			error: function(){
				alert('Hay un error...');
			}
		});
	}


	$('#btnModalAgregarTour').click(function(){
debugger

		if (ValidarCamposVaciosTour() != 0) {
			alert('Completar campos obligatorios');
		}else{
			$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
			RecolectarDatosTour();
			EnviarInformacionTour('agregar', NuevoTour, true);
		}
	});


	$('#btnModalEditarTour').click(function(){
		if (ValidarCamposVaciosTour() != 0) {
			alert('Completar campos obligatorios');
		}else{
			RecolectarDatosTour();
			EnviarInformacionTour('modificar', NuevoTour, true);
		}
	});


	$('#btnModalEliminarTour').click(function(){
		var bool=confirm('ESTA SEGURO DE ELIMINAR EL DATO?');
		if(bool){
			RecolectarDatosTour();
			EnviarInformacionTour('eliminar', NuevoTour, true);
		}
	});


	$('#btnModalCerrarHotel').click(function(){
		$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
		LimpiarModalDatosTour();
	});


	$('#btnFiltroTour').click(function(){
		RecolectarDatosTour();
		EnviarInformacionTour('leer', NuevoTour, false);
	});


	function Paginado(pag) {
		RecolectarDatosTour();
		EnviarInformacionTour('leer', NuevoTour, false, pag);
	}


	function RecolectarDatosTour(){
		NuevoTour = {
			idtour: $('#idtour').val().toUpperCase(),
			tournombre: $('#tournombre').val().toUpperCase(),
			tourdescripcion: $('#tourdescripcion').val().toUpperCase(),
			tourprecio: $('#tourprecio').val().toUpperCase(),
			color: $('#color').val().toUpperCase(),
			tourdiashabiles: $('#tourdiashabiles').val().toUpperCase(),
			tourestado: $('#tourestado').val().toUpperCase(),
			idcattour: $('#idcattour').val().toUpperCase(),

			todos: $('#idFTodos').val(),
			texto: $('#idFTexto').val()
		};
	}


	function EnviarInformacionTour(accion, objEvento, modal, pag=1) { 
		$.ajax({
			type: 'POST',
			url: base_url+'/tour/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				var resp = JSON.parse(msg);
				$('#PaginadoTour').empty();
				$('#PaginadoTour').append(resp.pag);
				if (modal) {
					$('#modalAgregarTour').modal('toggle');
					LimpiarModalDatosTour();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								CargartablaTour(resp.datos)
							}
						})
					} else {
						Swal.fire({
							title: resp.mensaje,
							icon: 'error'
						})
					}
				}else{
					CargartablaTour(resp.datos)
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


	function LimpiarModalDatosTour(){
		$('#idtour').val('0');
		$('#tournombre').val('');
		$('#tourdescripcion').val('');
		$('#tourprecio').val('');
		$('#color').val('');
		$('#tourdiashabiles').val('');
		$('#idcattour').select2().val(0).select2('destroy').select2();

	}


	function ValidarCamposVaciosTour(){
		var error = 0;
		if ($('#idtour').val() == ''){
			Resaltado('idtour');
			error++;
		}
		if ($('#tournombre').val() == ''){
			Resaltado('tournombre');
			error++;
		}
		if ($('#tourdescripcion').val() == ''){
			Resaltado('tourdescripcion');
			error++;
		}
		if ($('#tourprecio').val() == ''){
			Resaltado('tourprecio');
			error++;
		}
		if ($('#color').val() == ''){
			Resaltado('color');
			error++;
		}
		if ($('#tourdiashabiles').val() == ''){
			Resaltado('tourdiashabiles');
			error++;
		}
		if ($('#tourestado').val() == ''){
			Resaltado('tourestado');
			error++;
		}
		if ($('#idcattour').val() == ''){
			Resaltado('idcattour');
			error++;
		}

		return error;
	}


	function Resaltado(id){
		$('#'+id).css('border-color', '#ef5350');
		$('#'+id).focus();
	}


	function CargartablaTour(objeto){   
		$('#TablaTour tr').not($('#TablaTour tr:first')).remove();
		$.each(objeto, function(i, value) {
		var fila = '<tr>'+
			'<td >'+value.idtour+'</td>'+
			'<td >'+value.tournombre+'</td>'+
			'<td >'+value.tourdescripcion+'</td>'+
			'<td >'+value.tourprecio+'</td>'+
			'<td><i class="fa fa-circle" style="color:'+value.color+'"></i> '+value.idtour+'</td>'+
			'<td >'+value.tourdiashabiles+'</td>'+
			'<td class = "hidden -xs">' + ((value.tourestado == '1') ? 'ACTIVO' : 'DESACTIVO') + '</td>'+
			'<td>'+value.nombre+'</td>'+
			'<td hidden>'+value.idcattour+'</td>'+

			'<td>'+
				'<div class="row">'+
					'<div style="margin: auto;">'+
						'<button type="button" onclick="btnEditarTour(\''+value.idtour+'\', \''+value.idcattour+'\')" class="btn btn-info btn-xs">'+
							'<span class="fa fa-search fa-sm"></span>'+
						'</button>'+
					'</div>'+
						'<div style="margin: auto;">'+
							'<a class="btn btn-success btn-xs" href="<?php echo base_url();?>/reserva/add"><i class="fa fa-pencil"></i></a>'+
					'</div>'+
				'</div>'+
			'</td>'+
		'</tr>';
		$('#TablaTour tbody').append(fila);
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
