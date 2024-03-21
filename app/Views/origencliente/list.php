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
								<button type='button' class='btn btn-info btn-sm' id='btnAgregarOrigencliente'>
									<span class='fa fa-plus'></span> Agregar Origencliente
								</button>
								<button type='button' class='btn btn-success btn-sm' id='btnAgregarOrigencliente1'>
									<span class='fa fa-file-excel'></span> Exportar
								</button>
								<button type='button' class='btn btn-danger btn-sm' id='btnAgregarOrigencliente2'>
									<span class='fa fa-file-pdf-o'></span> Exportar
								</button>
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
												<button type='button' class='btn btn-info btn-sm' id='btnFiltroOrigencliente'>
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
						<div class='demo-content'>
							<table id='TablaOrigencliente' class='table table-sm table-bordered table-striped'>
								<thead>
									<tr>
										<th>Idorigencliente</th>
										<th>Nombre</th>
										<th>Estado</th>
										<th>Acciones</th>

									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $origencliente):?>
											<tr>
												<td><?php echo $origencliente['idorigencliente'];?></td>
												<td><?php echo $origencliente['nombre'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($origencliente['estado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>

												<td>
													<button type='button' onclick="btnEditarOrigencliente('<?php echo $origencliente['idorigencliente'];?>')" class='btn btn-info btn-xs'>
														<span class='fa fa-search fa-xs'></span>
													</button>
												</td>
											</tr>
										<?php endforeach;?>
									<?php endif;?>
								</tbody>
							</table>
							<div id='PaginadoOrigencliente'>
								<?php echo $pag;?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

</div>
<div class='modal fade' id='modalAgregarOrigencliente' tabindex='-1'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title' id='modaldeltalletour'>Detalle Origencliente</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row' id='IdModalGrupoCodigoTour' hidden>
				<label class='col-sm-3' for='id'>idorigencliente:</label>
				<div class = 'col-sm-9'>
					<input type='text' class='form-control form-control-sm text-uppercase    123' id='idorigencliente' name='idorigencliente' placeholder='T001' autocomplete = 'off'>
				</div>
			</div>
			<div class='form-group row' id='IdModalGrupoCodigoTour' >
				<label class='col-sm-3' for='id'>nombre:</label>
				<div class = 'col-sm-9'>
					<input type='text' class='form-control form-control-sm text-uppercase    123' id='nombre' name='nombre' placeholder='T001' autocomplete = 'off'>
				</div>
			</div>
			<div class='form-group row'>
				<label class='col-sm-3' for='rol'>estado:</label>
				<div class='col-sm-9'>
					<select class='form-control form-control-sm' id='estado' name='estado'>
						<option value = '1' selected >ACTIVO</option>
						<option value = '0' >DESACTIVO</option>
					</select>
				</div>
			</div>

		</div>
		<div class='modal-footer'>
			<button type='button' class='btn btn-success btn-sm' id='btnModalAgregarOrigencliente'>Agregar</button>
			<button type='button' class='btn btn-warning btn-sm' id='btnModalEditarOrigencliente'>Modificar</button>
			<button type='button' class='btn btn-danger btn-sm' id='btnModalEliminarOrigencliente'>Eliminar</button>
			<button type='button' class='btn btn-primary btn-sm' id='btnModalCerrarOrigencliente' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>

<script>
	var NuevoOrigencliente;
	var base_url= '<?php echo base_url();?>';


	function NumeroFilasTabla(){
		TamanioTabla = $('#tabla_Habitaciones tr').length - 1;
		$('#minmax').val(TamanioTabla)
	}


	function load(pag){
		RecolectarDatosOrigencliente();
		EnviarInformacionOrigencliente('leer', NuevoOrigencliente, false, pag);
	}





	$('#btnAgregarOrigencliente').click(function(){
		LimpiarModalDatosOrigencliente();
		$('#categoria').val(1);
		$('#id').prop('readonly', false);  
		$('#IdModalGrupoCodigoHotel').prop('hidden', false);
		$('#btnModalAgregarOrigencliente').toggle(true);
		$('#btnModalEditarOrigencliente').toggle(false);
		$('#btnModalEliminarOrigencliente').toggle(false);
		$('#modalAgregarOrigencliente').modal();
	});


	function btnEditarOrigencliente(Val0){
		$.ajax({
			type: 'POST',
			url: base_url + '/origencliente/edit',
			data: { idorigencliente: Val0},
			success: function(msg){
		debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosOrigencliente();
				$('#idorigencliente').val(temp.idorigencliente);
				$('#nombre').val(temp.nombre);
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


				$('#btnModalAgregarOrigencliente').toggle(false);
				$('#btnModalEditarOrigencliente').toggle(true);
				$('#btnModalEliminarOrigencliente').toggle(true);
				$('#modalAgregarOrigencliente').modal('toggle');
			},
			error: function(){
				alert('Hay un error...');
			}
		});
	}


	$('#btnModalAgregarOrigencliente').click(function(){
debugger

		if (ValidarCamposVaciosOrigencliente() != 0) {
			alert('Completar campos obligatorios');
		}else{
			$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
			RecolectarDatosOrigencliente();
			EnviarInformacionOrigencliente('agregar', NuevoOrigencliente, true);
		}
	});


	$('#btnModalEditarOrigencliente').click(function(){
		if (ValidarCamposVaciosOrigencliente() != 0) {
			alert('Completar campos obligatorios');
		}else{
			RecolectarDatosOrigencliente();
			EnviarInformacionOrigencliente('modificar', NuevoOrigencliente, true);
		}
	});


	$('#btnModalEliminarOrigencliente').click(function(){
		var bool=confirm('ESTA SEGURO DE ELIMINAR EL DATO?');
		if(bool){
			RecolectarDatosOrigencliente();
			EnviarInformacionOrigencliente('eliminar', NuevoOrigencliente, true);
		}
	});


	$('#btnModalCerrarHotel').click(function(){
		$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
		LimpiarModalDatosOrigencliente();
	});


	$('#btnFiltroOrigencliente').click(function(){
		RecolectarDatosOrigencliente();
		EnviarInformacionOrigencliente('leer', NuevoOrigencliente, false);
	});


	function Paginado(pag) {
		RecolectarDatosOrigencliente();
		EnviarInformacionOrigencliente('leer', NuevoOrigencliente, false, pag);
	}


	function RecolectarDatosOrigencliente(){
		NuevoOrigencliente = {
			idorigencliente: $('#idorigencliente').val().toUpperCase(),
			nombre: $('#nombre').val().toUpperCase(),
			estado: $('#estado').val().toUpperCase(),

			todos: $('#idFTodos').val(),
			texto: $('#idFTexto').val()
		};
	}


	function EnviarInformacionOrigencliente(accion, objEvento, modal, pag=1) { 
		$.ajax({
			type: 'POST',
			url: base_url+'/origencliente/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				var resp = JSON.parse(msg);
				$('#PaginadoOrigencliente').empty();
				$('#PaginadoOrigencliente').append(resp.pag);
				if (modal) {
					$('#modalAgregarOrigencliente').modal('toggle');
					LimpiarModalDatosOrigencliente();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								CargartablaOrigencliente(resp.datos)
							}
						})
					} else {
						Swal.fire({
							title: resp.mensaje,
							icon: 'error'
						})
					}
				}else{
					CargartablaOrigencliente(resp.datos)
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


	function LimpiarModalDatosOrigencliente(){
		$('#idorigencliente').val('0');
		$('#nombre').val('');

	}


	function ValidarCamposVaciosOrigencliente(){
		var error = 0;
		if ($('#idorigencliente').val() == ''){
			Resaltado('idorigencliente');
			error++;
		}
		if ($('#nombre').val() == ''){
			Resaltado('nombre');
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


	function CargartablaOrigencliente(objeto){   
		$('#TablaOrigencliente tr').not($('#TablaOrigencliente tr:first')).remove();
		$.each(objeto, function(i, value) {
		var fila = '<tr>'+
			'<td>'+value.idorigencliente+'</td>'+
			'<td>'+value.nombre+'</td>'+
			'<td class = "hidden -xs">' + ((value.estado == '1') ? 'ACTIVO' : 'DESACTIVO') + '</td>'+

			'<td>'+
				'<button type="button" onclick="btnEditarOrigencliente(\''+value.idorigencliente+'\')" class="btn btn-info btn-xs">'+
					'<span class="fa fa-search fa-sm"></span>'+
				'</button>'+
			'</td>'+
		'</tr>';
		$('#TablaOrigencliente tbody').append(fila);
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
