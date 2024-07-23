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
										<th>Idcliente</th>
										<th>Clientenombre</th>
										<th>Clienteapellidos</th>
										<th>Clientetelefono</th>
										<th>Clientecorreo</th>
										<th>Clientedireccion</th>
										<th>Clientepais</th>
										<th>Clientefechanacimiento</th>
										<th>Clienteedad</th>
										<th>Clientesexo</th>
										<th>Clienteestado</th>
										<th hidden>Idtipodoc</th>
										<th>Nombre</th>
										<th>Concatenado</th>
										<th>Concatenadodetalle</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $cliente):?>
											<tr>
												<td><?php echo $cliente['idcliente'];?></td>
												<td><?php echo $cliente['clientenombre'];?></td>
												<td><?php echo $cliente['clienteapellidos'];?></td>
												<td><?php echo $cliente['clientetelefono'];?></td>
												<td><?php echo $cliente['clientecorreo'];?></td>
												<td><?php echo $cliente['clientedireccion'];?></td>
												<td><?php echo $cliente['clientepais'];?></td>
												<td><?php echo $cliente['clientefechanacimiento'];?></td>
												<td><?php echo $cliente['clienteedad'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($cliente['clientesexo']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>
												<td class = 'hidden-xs'><?php echo $est = ($cliente['clienteestado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>
												<td hidden><?php echo $cliente['idtipodoc'];?></td>
												<td><?php echo $cliente['nombre'];?></td>
												<td><?php echo $cliente['concatenado'];?></td>
												<td><?php echo $cliente['concatenadodetalle'];?></td>
												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarCliente('<?php echo $cliente['idcliente'].'\',\''.$cliente['idtipodoc'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-search fa-xs'></span>
															</button>
														</div>
														<div style='margin: auto;'>
															<a class='btn btn-success btn-xs' href="<?php echo base_url();?>reserva/add/<?php echo $cliente['idcliente'].'\',\''.$cliente['idtipodoc'];?>"><i class='fa fa-pencil'></i></a>
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
						<div id='PaginadoCliente'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<!--  SECCION ====== MODAL ====== -->
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
					<label class='col-sm-4'>Idcliente:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='idcliente' name='idcliente' placeholder='T001' autocomplete = 'off'>
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
					<label class='col-sm-4' for='id'>Clientenombre:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='clientenombre' name='clientenombre' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>Clienteapellidos:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='clienteapellidos' name='clienteapellidos' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>Clientetelefono:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='clientetelefono' name='clientetelefono' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>Clientecorreo:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='clientecorreo' name='clientecorreo' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>Clientedireccion:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='clientedireccion' name='clientedireccion' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='id'>Clientepais:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='clientepais' name='clientepais' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4'>Clientefechanacimiento:</label>
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
					<label class='col-sm-4' for='id'>Clienteedad:</label>
					<div class = 'col-sm-8'>
						<input type='number' class='form-control form-control-sm' id='clienteedad' name='clienteedad' placeholder='0.00' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='rol'>Clientesexo:</label>
					<div class='col-sm-8'>
						<select class='form-control form-control-sm' id='clientesexo' name='clientesexo'>
							<option value = '1' selected >M</option>
							<option value = '0' >F</option>
						</select>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='rol'>Clienteestado:</label>
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
<!--  SECCION ====== SCRIPT ====== -->
<script>
	var NuevoCliente;
	var base_url= '<?php echo base_url();?>';
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
//   SECCION ====== btn Editar ======
	function btnEditarCliente(Val0, Val1){
		$.ajax({
			type: 'POST',
			url: base_url + '/cliente/edit',
			data: {idcliente: Val0, idtipodoc: Val1},
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
		$('#idcliente').val('');
		$('#idtipodoc').select2().val(0).select2('destroy').select2();
		$('#clientenombre').val('');
		$('#clienteapellidos').val('');
		$('#clientetelefono').val('');
		$('#clientecorreo').val('');
		$('#clientedireccion').val('');
		$('#clientepais').val('');
		$('#clientefechanacimiento').val('');
		$('#clienteedad').val('0');
	}
	function ValidarCamposVaciosCliente(){
		var error = 0;
		if ($('#idcliente').val() == ''){
			Resaltado('idcliente');
			error++;
		}else{
			NoResaltado('idcliente');
		}
		var value = $('#idtipodoc').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idtipodoc');
			error++;
		}else{
			NoResaltado('idtipodoc');
		}
		if ($('#clientenombre').val() == ''){
			Resaltado('clientenombre');
			error++;
		}else{
			NoResaltado('clientenombre');
		}
		if ($('#clienteapellidos').val() == ''){
			Resaltado('clienteapellidos');
			error++;
		}else{
			NoResaltado('clienteapellidos');
		}
		if ($('#clientetelefono').val() == ''){
			Resaltado('clientetelefono');
			error++;
		}else{
			NoResaltado('clientetelefono');
		}
		var email = $('#clientecorreo').val();
		var emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
		if (!emailRegex.test(email)){
			Resaltado('clientecorreo');
			error++;
		}else{
			NoResaltado('clientecorreo');
		}
		if ($('#clientedireccion').val() == ''){
			Resaltado('clientedireccion');
			error++;
		}else{
			NoResaltado('clientedireccion');
		}
		if ($('#clientepais').val() == ''){
			Resaltado('clientepais');
			error++;
		}else{
			NoResaltado('clientepais');
		}
		if ($('#clientefechanacimiento').val() == ''){
			Resaltado('clientefechanacimiento');
			error++;
		}else{
			NoResaltado('clientefechanacimiento');
		}
		var value = $('#clienteedad').val();
		if (!/^\d*$/.test(value)){
			Resaltado('clienteedad');
			error++;
		}else{
			NoResaltado('clienteedad');
		}
		if ($('#clientesexo').val() == ''){
			Resaltado('clientesexo');
			error++;
		}else{
			NoResaltado('clientesexo');
		}
		if ($('#clienteestado').val() == ''){
			Resaltado('clienteestado');
			error++;
		}else{
			NoResaltado('clienteestado');
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
	function CargartablaCliente(objeto){
		$('#TablaCliente tr').not($('#TablaCliente tr:first')).remove();
		$.each(objeto, function(i, value) {
				var fila = `<tr>
				<td>${value.idcliente}</td>
				<td>${value.clientenombre}</td>
				<td>${value.clienteapellidos}</td>
				<td>${value.clientetelefono}</td>
				<td>${value.clientecorreo}</td>
				<td>${value.clientedireccion}</td>
				<td>${value.clientepais}</td>
				<td>${value.clientefechanacimiento}</td>
				<td>${value.clienteedad}</td>
				<td class = 'hidden-xs'>${value.clientesexo == '1' ? 'ACTIVO' : 'DESACTIVO'}</td>
				<td class = 'hidden-xs'>${value.clienteestado == '1' ? 'ACTIVO' : 'DESACTIVO'}</td>
				<td hidden>${value.idtipodoc}</td>
				<td>${value.nombre}</td>
				<td>${value.concatenado}</td>
				<td>${value.concatenadodetalle}</td>
				<td>
				<div class='row'>
					<div style='margin: auto;'>
						<button type='button' onclick="btnEditarCliente('${value.idcliente}', '${value.idtipodoc}')" class='btn btn-info btn-xs'>
							<span class='fa fa-search fa-xs'></span>
						</button>
					</div>
						<div style='margin: auto;'>
							<a class='btn btn-success btn-xs' href='<?php echo base_url();?>/reserva/add/$cliente['idcliente'].'\',\''.$cliente['idtipodoc']'><i class='fa fa-pencil'></i></a>
					</div>
				</div>
				</td>
				</tr>`
			$('#TablaCliente tbody').append(fila);
		});
	}
</script>
