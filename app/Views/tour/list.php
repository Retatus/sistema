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
										<th>Idtour</th>
										<th>Tournombre</th>
										<th>Tourdescripcion</th>
										<th>Tourprecio</th>
										<th>Color</th>
										<th>Tourdiashabiles</th>
										<th>Tourestado</th>
										<th hidden>Idcattour</th>
										<th>Nombre</th>
										<th>Concatenado</th>
										<th>Concatenadodetalle</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $tour):?>
											<tr>
												<td><?php echo $tour['idtour'];?></td>
												<td><?php echo $tour['tournombre'];?></td>
												<td><?php echo $tour['tourdescripcion'];?></td>
												<td><?php echo $tour['tourprecio'];?></td>
												<td><?php echo $tour['color'];?></td>
												<td><?php echo $tour['tourdiashabiles'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($tour['tourestado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>
												<td hidden><?php echo $tour['idcattour'];?></td>
												<td><?php echo $tour['nombre'];?></td>
												<td><?php echo $tour['concatenado'];?></td>
												<td><?php echo $tour['concatenadodetalle'];?></td>
												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarTour('<?php echo $tour['idtour'].'\',\''.$tour['idcattour'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-search fa-xs'></span>
															</button>
														</div>
														<div style='margin: auto;'>
															<a class='btn btn-success btn-xs' href="<?php echo base_url();?>reserva/add/<?php echo $tour['idtour'].'\',\''.$tour['idcattour'];?>"><i class='fa fa-pencil'></i></a>
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
						<div id='PaginadoTour'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<!--  SECCION ====== MODAL ====== -->
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
					<label class='col-sm-4'>Idtour:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='idtour' name='idtour' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>Tournombre:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='tournombre' name='tournombre' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>Tourprecio:</label>
					<div class = 'col-sm-8'>
						<input type='number' class='form-control form-control-sm' id='tourprecio' name='tourprecio' placeholder='0.00' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4'>Color</label>
					<div class = 'col-sm-8'>
						<div class='input-group my-colorpicker2 colorpicker-element' data-colorpicker-id='2'>
							<input type='text' class='form-control form-control-sm text-uppercase' id='color' name='color' data-original-title='' title=''>
							<div class='input-group-append'>
								<span class='input-group-text'><i class='fas fa-square'></i></span>
							</div>
						</div>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>Tourdiashabiles:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='tourdiashabiles' name='tourdiashabiles' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='rol'>Tourestado:</label>
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
				<div class='col-12 form-group row'>
					<label class='col-sm-4' for='id'>Tourdescripcion:</label>
					<div class = 'col-sm-12'>
						<textarea type='text' class='form-control form-control-sm text-uppercase' id='tourdescripcion' name='tourdescripcion' placeholder='T001' autocomplete = 'off'></textarea>
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
<!--  SECCION ====== SCRIPT ====== -->
<script>
	var NuevoTour;
	var base_url= '<?php echo base_url();?>';
	function load(pag){
		RecolectarDatosTour();
		EnviarInformacionTour('leer', NuevoTour, false, pag);
	}
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
//   SECCION ====== btn Editar ======
	function btnEditarTour(Val0, Val1){
		$.ajax({
			type: 'POST',
			url: base_url + '/tour/edit',
			data: {idtour: Val0, idcattour: Val1},
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
		$('#idtour').val('');
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
		}else{
			NoResaltado('idtour');
		}
		if ($('#tournombre').val() == ''){
			Resaltado('tournombre');
			error++;
		}else{
			NoResaltado('tournombre');
		}
		if ($('#tourdescripcion').val() == ''){
			Resaltado('tourdescripcion');
			error++;
		}else{
			NoResaltado('tourdescripcion');
		}
		if ($('#tourprecio').val() == ''){
			Resaltado('tourprecio');
			error++;
		}else{
			NoResaltado('tourprecio');
		}
		if ($('#color').val() == ''){
			Resaltado('color');
			error++;
		}else{
			NoResaltado('color');
		}
		if ($('#tourdiashabiles').val() == ''){
			Resaltado('tourdiashabiles');
			error++;
		}else{
			NoResaltado('tourdiashabiles');
		}
		if ($('#tourestado').val() == ''){
			Resaltado('tourestado');
			error++;
		}else{
			NoResaltado('tourestado');
		}
		var value = $('#idcattour').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idcattour');
			error++;
		}else{
			NoResaltado('idcattour');
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
	function CargartablaTour(objeto){
		$('#TablaTour tr').not($('#TablaTour tr:first')).remove();
		$.each(objeto, function(i, value) {
				var fila = `<tr>
				<td>${value.idtour}</td>
				<td>${value.tournombre}</td>
				<td>${value.tourdescripcion}</td>
				<td>${value.tourprecio}</td>
				<td>${value.color}</td>
				<td>${value.tourdiashabiles}</td>
				<td class = 'hidden-xs'>${value.tourestado == '1' ? 'ACTIVO' : 'DESACTIVO'}</td>
				<td hidden>${value.idcattour}</td>
				<td>${value.nombre}</td>
				<td>${value.concatenado}</td>
				<td>${value.concatenadodetalle}</td>
				<td>
				<div class='row'>
					<div style='margin: auto;'>
						<button type='button' onclick="btnEditarTour('${value.idtour}', '${value.idcattour}')" class='btn btn-info btn-xs'>
							<span class='fa fa-search fa-xs'></span>
						</button>
					</div>
						<div style='margin: auto;'>
							<a class='btn btn-success btn-xs' href='<?php echo base_url();?>/reserva/add/$tour['idtour'].'\',\''.$tour['idcattour']'><i class='fa fa-pencil'></i></a>
					</div>
				</div>
				</td>
				</tr>`
			$('#TablaTour tbody').append(fila);
		});
	}
</script>
