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
								<button type='button' class='btn btn-info btn-sm' id='btnAgregarReserva'>
									<span class='fa fa-plus'></span> Agregar Reserva
								</button>
								<a href='<?php echo base_url();?>reserva/excel' class='btn btn-success btn-sm'>
									<span class='fa fa-file-excel'></span> Exportar
								</a>
								<a href='<?php echo base_url();?>reserva/pdf' target='_blank' class='btn btn-danger btn-sm'>
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
												<button type='button' class='btn btn-info btn-sm' id='btnFiltroReserva'>
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
							<table id='TablaReserva' class='table table-sm table-bordered table-striped'>
								<thead>
									<tr>
										<th hidden>Idreserva</th>
										<th>Reservanombre</th>
										<th>Fechainicio</th>
										<th>Fechafin</th>
										<th>Tipodoc</th>
										<th>Idpersona</th>
										<th>Reservatelefono</th>
										<th>Reservacorreo</th>
										<th>Montototal</th>
										<th>Pagado</th>
										<th>Estado</th>
										<th>Concatenado</th>
										<th>Concatenadodetalle</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $reserva):?>
											<tr>
												<td hidden><?php echo $reserva['idreserva'];?></td>
												<td><?php echo $reserva['reservanombre'];?></td>
												<td><?php echo $reserva['fechainicio'];?></td>
												<td><?php echo $reserva['fechafin'];?></td>
												<td><?php echo $reserva['tipodoc'];?></td>
												<td><?php echo $reserva['idpersona'];?></td>
												<td><?php echo $reserva['reservatelefono'];?></td>
												<td><?php echo $reserva['reservacorreo'];?></td>
												<td><?php echo $reserva['montototal'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($reserva['pagado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>
												<td><?php echo $reserva['estado'];?></td>
												<td><?php echo $reserva['concatenado'];?></td>
												<td><?php echo $reserva['concatenadodetalle'];?></td>
												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarReserva('<?php echo $reserva['idreserva'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-search fa-xs'></span>
															</button>
														</div>
														<div style='margin: auto;'>
															<a class='btn btn-success btn-xs' href="<?php echo base_url();?>reserva/add/<?php echo $reserva['idreserva'];?>"><i class='fa fa-pencil'></i></a>
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
						<div id='PaginadoReserva'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<!--  SECCION ====== MODAL ====== -->
<div class='modal fade' id='modalAgregarReserva' tabindex='-1'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title' id='modaldeltalletour'>Detalle Reserva</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<div class='col-6 form-group row' hidden>
					<label class='col-sm-4'>Idreserva:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='idreserva' name='idreserva' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>Reservanombre:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='reservanombre' name='reservanombre' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4'>Fechainicio:</label>
					<div class='col-sm-8'>
						<div class='input-group'>
							<div class='input-group-prepend'>
								<span class='input-group-text'>
									<i class='far fa-calendar-alt'></i>
								</span>
							</div>
							<input type='text' class='form-control form-control-sm' id='fechainicio' name='fechainicio' placeholder='dd/mm/yyyy' readonly>
						</div>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4'>Fechafin:</label>
					<div class='col-sm-8'>
						<div class='input-group'>
							<div class='input-group-prepend'>
								<span class='input-group-text'>
									<i class='far fa-calendar-alt'></i>
								</span>
							</div>
							<input type='text' class='form-control form-control-sm' id='fechafin' name='fechafin' placeholder='dd/mm/yyyy' readonly>
						</div>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>Tipodoc:</label>
					<div class = 'col-sm-8'>
						<input type='number' class='form-control form-control-sm' id='tipodoc' name='tipodoc' placeholder='0.00' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>Idpersona:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='idpersona' name='idpersona' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>Reservatelefono:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='reservatelefono' name='reservatelefono' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>Reservacorreo:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='reservacorreo' name='reservacorreo' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>Montototal:</label>
					<div class = 'col-sm-8'>
						<input type='number' class='form-control form-control-sm' id='montototal' name='montototal' placeholder='0.00' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>Pagado:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='pagado' name='pagado' placeholder='T001' autocomplete = 'off'>
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
			<button type='button' class='btn btn-success btn-sm' id='btnModalAgregarReserva'>Agregar</button>
			<button type='button' class='btn btn-warning btn-sm' id='btnModalEditarReserva'>Modificar</button>
			<button type='button' class='btn btn-danger btn-sm' id='btnModalEliminarReserva'>Eliminar</button>
			<button type='button' class='btn btn-primary btn-sm' id='btnModalCerrarReserva' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<!--  SECCION ====== SCRIPT ====== -->
<script>
	var NuevoReserva;
	var base_url= '<?php echo base_url();?>';
	function load(pag){
		RecolectarDatosReserva();
		EnviarInformacionReserva('leer', NuevoReserva, false, pag);
	}
	$('#fechainicio').datepicker({
		language: 'es',
		todayBtn: 'linked',
		clearBtn: true,
		format: 'mm/dd/yyyy',
		multidate: false,
		todayHighlight: true
	});
	
	$('#fechafin').datepicker({
		language: 'es',
		todayBtn: 'linked',
		clearBtn: true,
		format: 'mm/dd/yyyy',
		multidate: false,
		todayHighlight: true
	});
	
	$('#btnAgregarReserva').click(function(){
		LimpiarModalDatosReserva();
		$('#categoria').val(1);
		$('#id').prop('readonly', false);  
		$('#IdModalGrupoCodigoHotel').prop('hidden', false);
		$('#btnModalAgregarReserva').toggle(true);
		$('#btnModalEditarReserva').toggle(false);
		$('#btnModalEliminarReserva').toggle(false);
		$('#modalAgregarReserva').modal();
	});
//   SECCION ====== btn Editar ======
	function btnEditarReserva(Val0){
		$.ajax({
			type: 'POST',
			url: base_url + '/reserva/edit',
			data: {idreserva: Val0},
			success: function(msg){
				debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosReserva();
				$('#idreserva').val(temp.idreserva);
				$('#reservanombre').val(temp.reservanombre);
				$('#fechainicio').val(temp.fechainicio);
				$('#fechafin').val(temp.fechafin);
				$('#tipodoc').val(temp.tipodoc);
				$('#idpersona').val(temp.idpersona);
				$('#reservatelefono').val(temp.reservatelefono);
				$('#reservacorreo').val(temp.reservacorreo);
				$('#montototal').val(temp.montototal);
				$('#pagado').val(temp.pagado);
				$('#estado').val(temp.estado);
				$('#btnModalAgregarReserva').toggle(false);
				$('#btnModalEditarReserva').toggle(true);
				$('#btnModalEliminarReserva').toggle(true);
				$('#modalAgregarReserva').modal('toggle');
			},
			error: function(){
				alert('Hay un error...');
			}
		});
	}
	$('#btnModalAgregarReserva').click(function(){
		debugger
		if (ValidarCamposVaciosReserva() != 0) {
			alert('Completar campos obligatorios');
		}else{
			$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
			RecolectarDatosReserva();
			EnviarInformacionReserva('agregar', NuevoReserva, true);
		}
	});
	$('#btnModalEditarReserva').click(function(){
		if (ValidarCamposVaciosReserva() != 0) {
			alert('Completar campos obligatorios');
		}else{
			RecolectarDatosReserva();
			EnviarInformacionReserva('modificar', NuevoReserva, true);
		}
	});
	$('#btnModalEliminarReserva').click(function(){
		var bool=confirm('ESTA SEGURO DE ELIMINAR EL DATO?');
		if(bool){
			RecolectarDatosReserva();
			EnviarInformacionReserva('eliminar', NuevoReserva, true);
		}
	});
	$('#btnModalCerrarHotel').click(function(){
		$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
		LimpiarModalDatosReserva();
	});
	$('#btnFiltroReserva').click(function(){
		RecolectarDatosReserva();
		EnviarInformacionReserva('leer', NuevoReserva, false);
	});
	function Paginado(pag) {
		RecolectarDatosReserva();
		EnviarInformacionReserva('leer', NuevoReserva, false, pag);
	}
	function RecolectarDatosReserva(){
		NuevoReserva = {
			idreserva: $('#idreserva').val().toUpperCase(),
			reservanombre: $('#reservanombre').val().toUpperCase(),
			fechainicio: $('#fechainicio').val().toUpperCase(),
			fechafin: $('#fechafin').val().toUpperCase(),
			tipodoc: $('#tipodoc').val().toUpperCase(),
			idpersona: $('#idpersona').val().toUpperCase(),
			reservatelefono: $('#reservatelefono').val().toUpperCase(),
			reservacorreo: $('#reservacorreo').val().toUpperCase(),
			montototal: $('#montototal').val().toUpperCase(),
			pagado: $('#pagado').val().toUpperCase(),
			estado: $('#estado').val().toUpperCase(),
			todos: $('#idFTodos').val(),
			texto: $('#idFTexto').val()
		};
	}
	function EnviarInformacionReserva(accion, objEvento, modal, pag=1) { 
		$.ajax({
			type: 'POST',
			url: base_url+'/reserva/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				var resp = JSON.parse(msg);
				$('#PaginadoReserva').empty();
				$('#PaginadoReserva').append(resp.pag);
				if (modal) {
					$('#modalAgregarReserva').modal('toggle');
					LimpiarModalDatosReserva();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								CargartablaReserva(resp.datos)
							}
						})
					} else {
						Swal.fire({
							title: resp.mensaje,
							icon: 'error'
						})
					}
				}else{
					CargartablaReserva(resp.datos)
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
	function LimpiarModalDatosReserva(){
		$('#idreserva').val('0');
		$('#reservanombre').val('');
		$('#fechainicio').val('');
		$('#fechafin').val('');
		$('#tipodoc').val('0');
		$('#idpersona').val('');
		$('#reservatelefono').val('');
		$('#reservacorreo').val('');
		$('#montototal').val('');
		$('#estado').val('0');
	}
	function ValidarCamposVaciosReserva(){
		var error = 0;
		var value = $('#idreserva').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idreserva');
			error++;
		}else{
			NoResaltado('idreserva');
		}
		if ($('#reservanombre').val() == ''){
			Resaltado('reservanombre');
			error++;
		}else{
			NoResaltado('reservanombre');
		}
		if ($('#fechainicio').val() == ''){
			Resaltado('fechainicio');
			error++;
		}else{
			NoResaltado('fechainicio');
		}
		if ($('#fechafin').val() == ''){
			Resaltado('fechafin');
			error++;
		}else{
			NoResaltado('fechafin');
		}
		var value = $('#tipodoc').val();
		if (!/^\d*$/.test(value)){
			Resaltado('tipodoc');
			error++;
		}else{
			NoResaltado('tipodoc');
		}
		if ($('#idpersona').val() == ''){
			Resaltado('idpersona');
			error++;
		}else{
			NoResaltado('idpersona');
		}
		if ($('#reservatelefono').val() == ''){
			Resaltado('reservatelefono');
			error++;
		}else{
			NoResaltado('reservatelefono');
		}
		var email = $('#reservacorreo').val();
		var emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
		if (!emailRegex.test(email)){
			Resaltado('reservacorreo');
			error++;
		}else{
			NoResaltado('reservacorreo');
		}
		if ($('#montototal').val() == ''){
			Resaltado('montototal');
			error++;
		}else{
			NoResaltado('montototal');
		}
		if ($('#pagado').val() == ''){
			Resaltado('pagado');
			error++;
		}else{
			NoResaltado('pagado');
		}
		var value = $('#estado').val();
		if (!/^\d*$/.test(value)){
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
	function CargartablaReserva(objeto){
		$('#TablaReserva tr').not($('#TablaReserva tr:first')).remove();
		$.each(objeto, function(i, value) {
				var fila = `<tr>
				<td hidden>${value.idreserva}</td>
				<td>${value.reservanombre}</td>
				<td>${value.fechainicio}</td>
				<td>${value.fechafin}</td>
				<td>${value.tipodoc}</td>
				<td>${value.idpersona}</td>
				<td>${value.reservatelefono}</td>
				<td>${value.reservacorreo}</td>
				<td>${value.montototal}</td>
				<td class = 'hidden-xs'>${value.pagado == '1' ? 'ACTIVO' : 'DESACTIVO'}</td>
				<td>${value.estado}</td>
				<td>${value.concatenado}</td>
				<td>${value.concatenadodetalle}</td>
				<td>
				<div class='row'>
					<div style='margin: auto;'>
						<button type='button' onclick="btnEditarReserva('${value.idreserva}')" class='btn btn-info btn-xs'>
							<span class='fa fa-search fa-xs'></span>
						</button>
					</div>
						<div style='margin: auto;'>
							<a class='btn btn-success btn-xs' href='<?php echo base_url();?>/reserva/add/$reserva['idreserva']'><i class='fa fa-pencil'></i></a>
					</div>
				</div>
				</td>
				</tr>`
			$('#TablaReserva tbody').append(fila);
		});
	}
</script>
