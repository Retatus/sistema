
<div class='content-wrapper'>
	<section class='content-header'>
	</section>
	<section class='content'>
		<div class='row'>
			<div class='col-12'>
				<div class='card'>
					<div class='card-header'>
					</div>
					<div class='card-body'>
						<div class='form-group row'>								
							<div class='col-4' hidden>
								<div class='form-group row'>
									<label class='col-sm-4' for='id'>id</label>
									<div class = 'col-sm-8'>
										<input type='text' class='form-control form-control-sm text-uppercase' id='idreserva' name='idreserva' value="<?php echo $reserva['idreserva'];?>" autocomplete = 'off'>
									</div>
								</div>
							</div>
							<div class='col-4'>
								<div class='form-group row'>
									<label class='col-sm-4' for='id'>nombre reserva </label>
									<div class = 'col-sm-8'>
										<input type='text' class='form-control form-control-sm text-uppercase' id='reservanombre' name='reservanombre' value="<?php echo $reserva['reservanombre'];?>" autocomplete = 'off'>
									</div>
								</div>
							</div>
							<div class='col-4'>
								<div class='form-group row'>
									<label class='col-sm-4'>fechainicio</label>
									<div class='col-sm-8'>											
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text">
													<i class="far fa-calendar-alt"></i>
												</span>
											</div>
												<input type='text' class='form-control form-control-sm' id='fechainicio' name='fechainicio' placeholder='dd/mm/yyyy' readonly>
										</div>
									</div>
								</div>									
							</div>
							<div class='col-4'>
								<div class='form-group row'>
									<!-- <label class='col-sm-4'>Cliente</label> -->
									<div class = 'col-sm-12'>
										<button type='button' class='btn btn-info btn-block btn-sm' id='btnAgregarCliente'>PASAJERO</button>
									</div>
								</div>
							</div>
							<div class='col-4' hidden>
								<div class='form-group row'>
									<label class='col-sm-4' for='id'>tipodoc</label>
									<div class = 'col-sm-8'>
										<input type='text' class='form-control form-control-sm text-uppercase' id='tipodoc' name='tipodoc' placeholder='T001' autocomplete = 'off'>
									</div>
								</div>
							</div>
							<div class='col-4' hidden>
								<div class='form-group row'>
									<label class='col-sm-4' for='id'>idpersona</label>
									<div class = 'col-sm-8'>
										<input type='text' class='form-control form-control-sm text-uppercase' id='idpersona' name='idpersona' placeholder='T001' autocomplete = 'off'>
									</div>
								</div>
							</div>								
							<div class='col-4' hidden>
								<div class='form-group row'>
									<label class='col-sm-4' for='id'>telefono</label>
									<div class = 'col-sm-8'>
										<input type='text' class='form-control form-control-sm text-uppercase' id='reservatelefono' name='reservatelefono' placeholder='T001' autocomplete = 'off'>
									</div>
								</div>
							</div>								
							<div class='col-4'hidden>
								<div class='form-group row'>
									<label class='col-sm-4' for='id'>correo</label>
									<div class = 'col-sm-8'>
										<input type='text' class='form-control form-control-sm text-uppercase' id='reservacorreo' name='reservacorreo' value='no-send@tato.pe' autocomplete = 'off'>
									</div>
								</div>
							</div>						
						</div>
						<hr>
						<div class='form-group row'>
							<div class='col-4'>
								<div class='form-group row'>
									<label class='col-sm-4'>Ticketbus</label>
									<div class = 'col-sm-8'>
										<input type = 'text' class='form-control form-control-sm text-uppercase  123' id='idticketbus' placeholder='T001' autocomplete = 'off'>
									</div>
								</div>
							</div>								
							<div class='col-4'>
								<div class='form-group row'>
									<label class='col-sm-4'>Horarioticketmapi</label>
									<div class = 'col-sm-8'>
										<input type = 'text' class='form-control form-control-sm text-uppercase  123' id='idhorarioticketmapi' placeholder='T001' autocomplete = 'off'>
									</div>
								</div>
							</div>
							<div class='col-4'>
								<div class='form-group row'>
									<label class='col-sm-4'>Horariotren</label>
									<div class = 'col-sm-8'>
										<input type = 'text' class='form-control form-control-sm text-uppercase  123' id='idhorariotren' placeholder='T001' autocomplete = 'off'>
									</div>
								</div>
							</div>
							<div class='col-4'>
								<div class='form-group row'>
									<label class='col-sm-4'>Hotelhabitacion</label>
									<div class = 'col-sm-8'>
										<input type = 'text' class='form-control form-control-sm text-uppercase  123' id='idhotelhabitacion' placeholder='T001' autocomplete = 'off'>
									</div>
								</div>
							</div>
							<div class='col-4'>
								<div class='form-group row'>
									<label class='col-sm-4'>Otroservicio</label>
									<div class = 'col-sm-8'>
										<input type = 'text' class='form-control form-control-sm text-uppercase  123' id='idotroservicio' placeholder='T001' autocomplete = 'off'>
									</div>
								</div>
							</div>
							<div class='col-4'>
								<div class='form-group row'>
									<label class='col-sm-4'>Tour</label>
									<div class = 'col-sm-8'>
										<input type = 'text' class='form-control form-control-sm text-uppercase  123' id='idtour' placeholder='T001' autocomplete = 'off'>
									</div>
								</div>
							</div>
						</div>
						<!-- <hr> -->
						<div class='demo-content scroll' style='margin-right: 0px; margin-left: 0px;'>
							<table class='table table-sm table-bordered table-striped' id ='tablaPasajeros'>
								<thead>
									<tr>																					
										<th width='6%'>Tipodoc</th>
										<th width='6%'>Idcliente</th>
										<th hidden>Idtipodoc</th>
										<th width='10%'>Nombre</th>
										<th width='23%'>Apellidos</th>
										<th width='10%'>Telefono</th>
										<th hidden>Correo</th>
										<th hidden>Direccion</th>
										<th width='4%'>Pais</th>
										<th width='6%'>Fechanacimiento</th>
										<th width='6%'>Edad</th>
										<th width='5%'>Sexo</th>
										<th width='6%'>Estado</th>
										<th width='8%'>Acciones</th>
									</tr>
								</thead>
								<tbody>
									
								</tbody>
							</table>
						</div>
						<!-- <hr> -->
						<div class='demo-content scroll' style='margin-right: 0px; margin-left: 0px;'>
							<table class='table table-sm table-bordered table-striped' id ='tablaDetalleServicio'>
								<thead>
									<tr>										
										<th width='6%'>Afectacion</th>
										<th width='5%'>Categoria</th>
										<th width='5%'>Codigo</th>
										<th width='28%'>Nombre</th>
										<th width='8%'>Fecha</th>
										<th width='5%'>Cantidad</th>
										<th width='6%'>Precio</th>
										<th width='6%'>Total</th>
										<th width='10%'>Confirmado</th>
										<th width='8%'>Pagado</th>
										<th width='7%'>Estado</th>
										<th width='6%'>Acciones</th>
									</tr>
								</thead>
								<tbody>
									
								</tbody>
							</table>
						</div>
						<div class='form-group row' >
							<div class='col-4'>
								<div class='form-group row'>
									<label class='col-sm-4' for='rol'>estado</label>
									<div class='col-sm-8'>
										<select class='form-control form-control-sm' id='estado' name='estado'>
											<option value = '1' selected >ACTIVO</option>
											<option value = '0' >DESACTIVO</option>
										</select>
									</div>
								</div>
							</div>						
							<div class='col-4'>
								<div class='form-group row'>
									<label class='col-sm-4' for='id'>pagado</label>
									<div class = 'col-sm-8'>
										<input type='text' class='form-control form-control-sm' style="text-align: right;" id='pagado' name='pagado' value="0" readonly>									
									</div>
								</div>
							</div>	
							<div class='col-4'>
								<div class='form-group row'>
									<label class='col-sm-4' for='id'>montototal</label>
									<div class = 'col-sm-8'>
										<input type='text' class='form-control form-control-sm' style="text-align: right;" id='montototal' name='montototal' value="0" readonly>
									</div>
								</div>
							</div>						
						</div>
					</div>
					<div class='card-footer'>
						<button type='button' class='btn btn-success btn-sm' id='btnModalAgregarReserva' style="padding: .25rem 5.5rem;">Agregar</button>
						<!-- <button type='button' class='btn btn-warning btn-sm' id='btnModalEditarReserva' style="padding: .25rem 5.5rem;">Modificar</button>
						<button type='button' class='btn btn-danger btn-sm' id='btnModalEliminarReserva' style="padding: .25rem 5.5rem;">Eliminar</button> -->
						<a href='<?php echo base_url();?>/reserva' class='btn btn-primary btn-sm' style="padding: .25rem 5.5rem;"> Cerrar</a>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<script>
	$('#idticketbus').autocomplete({ 
		source: function(request, response) {
			$.ajax({
				type: 'POST',
				url: base_url + '/reservadetallebus/autocompleteticketbuss',
				dataType: 'json',
				data: { keyword: request.term },
				success: function(data){
					response($.map(data, function(item) {
						return {
							label: item.concatenado,
							concatenado: item.concatenado,
							idtour: item.idticketbus,
							nombre: item.nombre,
							precio: item.precio,
							concatenadodetalle: item.concatenadodetalle,
						}
					}))
				}
			});
		},
		minLength: 2,
		select: function( event, ui ) {
			$('#idticketbus').val('');
			var j = $('#tablaDetalleServicio tr').length;
			var i = parseInt((j == 1 ? 0 : $('#tablaDetalleServicio').find('tr').eq(j - 1).find('td').eq(0).html()));
			var rows = "<tr id=Fila_" + (i + 1) + ">"+
				"<td hidden>" + (i + 1) + "</td>"+
				"<td hidden><input type='text' class='form-control form-control-sm' id='detalleTipoServicio_" + (i + 1) + "' value='BUS'></td>"+
				"<td hidden><input type='text' class='form-control form-control-sm' id='detalleIdReserva_" + (i + 1) + "' value=''></td>"+
				"<td>"+
					"<select class='form-control form-control-sm select2' id='detalleGravado_" + (i + 1) + "' style='width: 100%;'>"+
						"<option value='10'>GRAV</option>"+
						"<option value='20'>EXON</option>"+
						"<option value='30'>INAF</option>"+
						"<option value='40'>EXPO</option>"+
					"</select>"+
				"</td>"+
				"<td>BUS</td>"+
				"<td>" + ui.item.idtour + "</td>"+
				"<td>" + ui.item.concatenadodetalle + "</td>"+
				"<td><input type='text' class='form-control form-control-sm text-uppercase datepicker" + (i + 1) + "' id='detalleFecha_" + (i + 1) + "' readonly></td>"+
				"<td><input type='text' class='form-control form-control-sm text-uppercase' id='detallecantidad_" + (i + 1) + "' onkeyup='ImporteTotalDetalle(" + (i + 1) + ")' value='1'></td>"+
				"<td><input type='text' class='form-control form-control-sm text-uppercase' id='detalleprecio_" + (i + 1) + "' onkeyup='ImporteTotalDetalle(" + (i + 1) + ")' value='" + ui.item.precio + "'></td>"+
				"<td><input type='text' class='form-control form-control-sm text-uppercase' id='detalletotal_" + (i + 1) + "' placeholder='total' value='' disabled></td>"+
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
				"<td>"+
					"<div class='row'>"+
						"<div style='margin: auto;'>"+
							"<a class='btn btn-danger btn-xs' href='javascript:void(0)' onClick='EliminarFila(" + (i + 1) + ")'><i class='fa fa-times'></i></a>"+
						"</div>"+
						"<div style='margin: auto;'>"+
							"<a class='btn btn-info btn-xs' href='javascript:void(0)' onClick='AgregarDatos(" + (i + 1) + ")'><i class='fa fa-pencil'></i></a>"+
						"</div>"+
					"</div>"+
				"</td>"+
			"</tr>";
			$('#tablaDetalleServicio').append(rows);
			addDatepicker(i + 1);
			ImporteTotalDetalle(i + 1);
			return false;
		}
	});
	$('#clientenombre').autocomplete({ 
		source: function(request, response) {
			$.ajax({
				type: 'POST',
				url: base_url + '/reservadetallecliente/autocompleteclientes',
				dataType: 'json',
				data: { keyword: request.term },
				success: function(data){
					response($.map(data, function(item) {
						return {
							label: item.concatenado,
							value: item.clientenombre,
							tipodoc: item.idtipodoc,
							idcliente: item.idcliente,
							nombre: item.clientenombre,
							apellidos: item.clienteapellidos,
							telefono: item.clientetelefono,
							correo: item.clientecorreo,
							direccion: item.clientedireccion,
							pais: item.clientepais,
							fechanacimiento: item.clientefechanacimiento,
							edad: item.clienteedad,
							sexo: item.clientesexo,
							estado: item.clienteestado
						}
					}))
				}
			});
		},
		minLength: 2,
		select: function( event, ui ) {
			$('#idtipodoc').select2().val(ui.item.tipodoc).select2('destroy').select2();
			$('#idcliente').val(ui.item.idcliente);
			$('#clientenombre').val(ui.item.nombre);
			$('#clienteapellidos').val(ui.item.apellidos);
			$('#clientetelefono').val(ui.item.telefono);
			$('#clientecorreo').val(ui.item.correo);
			$('#clientedireccion').val(ui.item.direccion);
			$('#clientepais').val(ui.item.pais);
			$('#clientefechanacimiento').val(ui.item.fechanacimiento);
			$('#clienteedad').val(ui.item.edad);
			$('#clientesexo').val(ui.item.sexo);
			$('#clienteestado').val(ui.item.estado);
		}
	});
	
	function AgregarPasajeros(){
    	debugger // tato 
        var j = $('#tablaPasajeros tr').length;
        var i = parseInt((j == 1 ? 0: $('#tablaPasajeros').find('tr').eq(j - 1).find('td').eq(0).html()))        
        var rows = "<tr id=Fila_"+ (i + 1) +">" +
        "<td hidden>"+(i + 1)+"</td>" +
        "<td hidden><input type='text' class='form-control form-control-sm text-uppercase' id='reservadetalle_" + (i + 1) + "' value=''></td>" +
        "<td>" +
            '<div class="row">' +
                '<div style="margin: auto;">' +   
                    "<a href='javascript:void(0)' style='color: #ef5350;' onClick='EliminarFila("+ (i + 1) +")'><i class='fa fa-times'></i></a>" +                                  
                '</div>' +
                '<div style="margin: auto;">' +
                    "<a href='javascript:void(0)' style='color: #007bff;' onClick='AgregarDatos("+ (i + 1) +")'><i class='fa fa-pencil'></i></a>" +                                
                '</div>' +
                '<div class="icheck-primary">' +
                    '<input type="radio" class="custom-control-input" id="radioPrimary'+ (i + 1) +'" onClick="ContactoPrincipal('+ (i + 1) +')" name="r1" data-title-tato="Contacto principal">' +
                    '<label for="radioPrimary'+ (i + 1) +'"></label>' +                                        
                '</div>' +
            '</div>' +
        "</td>" +        
        "<td><input type='text' class='form-control form-control-sm' id='tipodoc_"+ (i + 1) +"' value='" + $('#idtipodoc option:selected').text().toUpperCase() + "' disabled></td>" +
		"<td hidden><input type='text' class='form-control form-control-sm' id='idtipodoc_"+ (i + 1) +"' value='" + $('#idtipodoc').val() + "' disabled></td>" +
		"<td><input type='text' class='form-control form-control-sm' id='idcliente_" + (i + 1) + "' value='" + $('#idcliente').val().toUpperCase() + "' disabled></td>" +
		"<td><input type='text' class='form-control form-control-sm' id='nombre_" + (i + 1) + "' value='" + $('#clientenombre').val().toUpperCase() + "' disabled></td>" +
        "<td><input type='text' class='form-control form-control-sm' id='apellidos_"+ (i + 1) +"' value='" + $('#clienteapellidos').val().toUpperCase() + "' disabled></td>" +       
        "<td><input type='text' class='form-control form-control-sm' id='telefono_" + (i + 1) + "' value='" + $('#clientetelefono').val().toUpperCase() + "' disabled></td>" +
		"<td hidden><input type='text' class='form-control form-control-sm' id='correo_"+ (i + 1) +"' value='" + $('#clientecorreo').val().toUpperCase() + "' disabled></td>" +       
        "<td hidden><input type='text' class='form-control form-control-sm' id='direccion_" + (i + 1) + "' value='" + $('#clientedireccion').val().toUpperCase() + "' disabled></td>" +
		"<td><input type='text' class='form-control form-control-sm' id='paiss_" + (i + 1) + "' value='" + $('#clientepais').val().toUpperCase() + "' disabled></td>" +
		"<td><input type='text' class='form-control form-control-sm' id='fechanacimiento_" + (i + 1) + "' value='" + $('#clientefechanacimiento').val().toUpperCase() + "' disabled></td>" +
		"<td><input type='text' class='form-control form-control-sm' id='edad_" + (i + 1) + "' value='" + $('#clienteedad').val().toUpperCase() + "' disabled></td>" +
		"<td>"+
			"<select class='form-control form-control-sm select2' id='sexo_" + (i + 1) + "' style='width: 100%;'>"+
				"<option value='1'>M</option>"+
				"<option value='0'>F</option>"+
			"</select>"+
		"</td>" +
		"<td>"+
			"<select class='form-control form-control-sm select2' id='estado_" + (i + 1) + "' style='width: 100%;'>"+
				"<option value='1'>ACTIVO</option>"+
				"<option value='0'>DESACTIVO</option>"+
			"</select>"+
		"</td>" +
        "</tr>";
        $('#tablaPasajeros').append(rows);
        addSex(i + 1);
        addPais(i + 1);
        $('#pais_'+(i + 1)).select2().val(0).select2('destroy').select2();
        addTipoDoc(i + 1);
        $("#idPais_" + (i + 1)).val("KR");         
        var k = $('#tablaPasajeros').find('tr').eq(1).find('td').eq(0).html();
        $("#radioPrimary"+ k).prop( "checked", true );  
        debugger
        // if(j>=1){
        //     AgregarDatos(i + 1); 
        // }
    }
	$('#idhorarioticketmapi').autocomplete({ 
		source: function(request, response) {
			$.ajax({
				type: 'POST',
				url: base_url + '/reservadetallehorarioticketmapi/autocompletehorarioticketmapis',
				dataType: 'json',
				data: { keyword: request.term },
				success: function(data){
					response($.map(data, function(item) {
						return {
							label: item.concatenado,
							concatenado: item.concatenado,
							idtour: item.idhorarioticketmapi,							
							precio: item.precio,
							concatenadodetalle: item.concatenadodetalle,
						}
					}))
				}
			});
		},
		minLength: 2,
		select: function( event, ui ) {
			$('#idhorarioticketmapi').val('');
			var j = $('#tablaDetalleServicio tr').length;
			var i = parseInt((j == 1 ? 0 : $('#tablaDetalleServicio').find('tr').eq(j - 1).find('td').eq(0).html()));
			var rows = "<tr id=Fila_" + (i + 1) + ">"+
				"<td hidden>" + (i + 1) + "</td>"+
				"<td hidden><input type='text' class='form-control form-control-sm' id='detalleTipoServicio_" + (i + 1) + "' value='MAPI'></td>"+
				"<td hidden><input type='text' class='form-control form-control-sm' id='detalleIdReserva_" + (i + 1) + "' value=''></td>"+				
				"<td>"+
					"<select class='form-control form-control-sm select2' id='detalleGravado_" + (i + 1) + "' style='width: 100%;'>"+
						"<option value='10'>GRAV</option>"+
						"<option value='20'>EXON</option>"+
						"<option value='30'>INAF</option>"+
						"<option value='40'>EXPO</option>"+
					"</select>"+
				"</td>"+
				"<td>MAPI</td>"+
				"<td>" + ui.item.idtour + "</td>"+
				"<td>" + ui.item.concatenadodetalle + "</td>"+
				"<td><input type='text' class='form-control form-control-sm text-uppercase datepicker" + (i + 1) + "' id='detalleFecha_" + (i + 1) + "' readonly></td>"+
				"<td><input type='text' class='form-control form-control-sm text-uppercase' id='detallecantidad_" + (i + 1) + "' onkeyup='ImporteTotalDetalle(" + (i + 1) + ")' value='1'></td>"+
				"<td><input type='text' class='form-control form-control-sm text-uppercase' id='detalleprecio_" + (i + 1) + "' onkeyup='ImporteTotalDetalle(" + (i + 1) + ")' value='" + ui.item.precio + "'></td>"+
				"<td><input type='text' class='form-control form-control-sm text-uppercase' id='detalletotal_" + (i + 1) + "' placeholder='total' value='' disabled></td>"+
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
				"<td>"+
					"<div class='row'>"+
						"<div style='margin: auto;'>"+
							"<a class='btn btn-danger btn-xs' href='javascript:void(0)' onClick='EliminarFila(" + (i + 1) + ")'><i class='fa fa-times'></i></a>"+
						"</div>"+
						"<div style='margin: auto;'>"+
							"<a class='btn btn-info btn-xs' href='javascript:void(0)' onClick='AgregarDatos(" + (i + 1) + ")'><i class='fa fa-pencil'></i></a>"+
						"</div>"+
					"</div>"+
				"</td>"+
			"</tr>";
			$('#tablaDetalleServicio').append(rows);
			addDatepicker(i + 1);
			ImporteTotalDetalle(i + 1);
			return false;
		}
	});
	$('#idhorariotren').autocomplete({ 
		source: function(request, response) {
			$.ajax({
				type: 'POST',
				url: base_url + '/reservadetallehorariotren/autocompletehorariotrens',
				dataType: 'json',
				data: { keyword: request.term },
				success: function(data){
					response($.map(data, function(item) {
						return {
							label: item.concatenado,
							concatenado: item.concatenado,
							idtour: item.idhorariotren,							
							precio: item.precio,
							concatenadodetalle: item.concatenadodetalle,
						}
					}))
				}
			});
		},
		minLength: 2,
		select: function( event, ui ) {
			$('#idhorariotren').val('');
			var j = $('#tablaDetalleServicio tr').length;
			var i = parseInt((j == 1 ? 0 : $('#tablaDetalleServicio').find('tr').eq(j - 1).find('td').eq(0).html()));
			var rows = "<tr id=Fila_" + (i + 1) + ">"+
				"<td hidden>" + (i + 1) + "</td>"+
				"<td hidden><input type='text' class='form-control form-control-sm' id='detalleTipoServicio_" + (i + 1) + "' value='TREN'></td>"+
				"<td hidden><input type='text' class='form-control form-control-sm' id='detalleIdReserva_" + (i + 1) + "' value=''></td>"+				
				"<td>"+
					"<select class='form-control form-control-sm select2' id='detalleGravado_" + (i + 1) + "' style='width: 100%;'>"+
						"<option value='10'>GRAV</option>"+
						"<option value='20'>EXON</option>"+
						"<option value='30'>INAF</option>"+
						"<option value='40'>EXPO</option>"+
					"</select>"+
				"</td>"+
				"<td>TREN</td>"+
				"<td>" + ui.item.idtour + "</td>"+
				"<td>" + ui.item.concatenadodetalle + "</td>"+
				"<td><input type='text' class='form-control form-control-sm text-uppercase datepicker" + (i + 1) + "' id='detalleFecha_" + (i + 1) + "' readonly></td>"+
				"<td><input type='text' class='form-control form-control-sm text-uppercase' id='detallecantidad_" + (i + 1) + "' onkeyup='ImporteTotalDetalle(" + (i + 1) + ")' value='1'></td>"+
				"<td><input type='text' class='form-control form-control-sm text-uppercase' id='detalleprecio_" + (i + 1) + "' onkeyup='ImporteTotalDetalle(" + (i + 1) + ")' value='" + ui.item.precio + "'></td>"+
				"<td><input type='text' class='form-control form-control-sm text-uppercase' id='detalletotal_" + (i + 1) + "' placeholder='total' value='' disabled></td>"+
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
				"<td>"+
					"<div class='row'>"+
						"<div style='margin: auto;'>"+
							"<a class='btn btn-danger btn-xs' href='javascript:void(0)' onClick='EliminarFila(" + (i + 1) + ")'><i class='fa fa-times'></i></a>"+
						"</div>"+
						"<div style='margin: auto;'>"+
							"<a class='btn btn-info btn-xs' href='javascript:void(0)' onClick='AgregarDatos(" + (i + 1) + ")'><i class='fa fa-pencil'></i></a>"+
						"</div>"+
					"</div>"+
				"</td>"+
			"</tr>";
			$('#tablaDetalleServicio').append(rows);
			addDatepicker(i + 1);
			ImporteTotalDetalle(i + 1);
			return false;
		}
	});
	$('#idhotelhabitacion').autocomplete({ 
		source: function(request, response) {
			$.ajax({
				type: 'POST',
				url: base_url + '/reservadetallehotelhabitacion/autocompletehotelhabitacions',
				dataType: 'json',
				data: { keyword: request.term },
				success: function(data){
					response($.map(data, function(item) {
						return {
							label: item.concatenado,
							concatenado: item.concatenado,
							idtour: item.idhotelhabitacion,
							
							precio: item.precio,

							concatenadodetalle: item.concatenadodetalle,

						}
					}))
				}
			});
		},
		minLength: 2,
		select: function( event, ui ) {
			$('#idhotelhabitacion').val('');
			var j = $('#tablaDetalleServicio tr').length;
			var i = parseInt((j == 1 ? 0 : $('#tablaDetalleServicio').find('tr').eq(j - 1).find('td').eq(0).html()));
			var rows = "<tr id=Fila_" + (i + 1) + ">"+
				"<td hidden>" + (i + 1) + "</td>"+
				"<td hidden><input type='text' class='form-control form-control-sm' id='detalleTipoServicio_" + (i + 1) + "' value='HOTEL'></td>"+
				"<td hidden><input type='text' class='form-control form-control-sm' id='detalleIdReserva_" + (i + 1) + "' value=''></td>"+				
				"<td>"+
					"<select class='form-control form-control-sm select2' id='detalleGravado_" + (i + 1) + "' style='width: 100%;'>"+
						"<option value='10'>GRAV</option>"+
						"<option value='20'>EXON</option>"+
						"<option value='30'>INAF</option>"+
						"<option value='40'>EXPO</option>"+
					"</select>"+
				"</td>"+
				"<td>HOTEL</td>"+
				"<td>" + ui.item.idtour + "</td>"+
				"<td>" + ui.item.concatenadodetalle + "</td>"+
				"<td><input type='text' class='form-control form-control-sm text-uppercase datepicker" + (i + 1) + "' id='detalleFecha_" + (i + 1) + "' readonly></td>"+
				"<td><input type='text' class='form-control form-control-sm text-uppercase' id='detallecantidad_" + (i + 1) + "' onkeyup='ImporteTotalDetalle(" + (i + 1) + ")' value='1'></td>"+
				"<td><input type='text' class='form-control form-control-sm text-uppercase' id='detalleprecio_" + (i + 1) + "' onkeyup='ImporteTotalDetalle(" + (i + 1) + ")' value='" + ui.item.precio + "'></td>"+
				"<td><input type='text' class='form-control form-control-sm text-uppercase' id='detalletotal_" + (i + 1) + "' placeholder='total' value='' disabled></td>"+
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
				"<td>"+
					"<div class='row'>"+
						"<div style='margin: auto;'>"+
							"<a class='btn btn-danger btn-xs' href='javascript:void(0)' onClick='EliminarFila(" + (i + 1) + ")'><i class='fa fa-times'></i></a>"+
						"</div>"+
						"<div style='margin: auto;'>"+
							"<a class='btn btn-info btn-xs' href='javascript:void(0)' onClick='AgregarDatos(" + (i + 1) + ")'><i class='fa fa-pencil'></i></a>"+
						"</div>"+
					"</div>"+
				"</td>"+
			"</tr>";
			$('#tablaDetalleServicio').append(rows);
			addDatepicker(i + 1);
			ImporteTotalDetalle(i + 1);
			return false;
		}
	});
	$('#idotroservicio').autocomplete({ 
		source: function(request, response) {
			$.ajax({
				type: 'POST',
				url: base_url + '/reservadetalleotroservicio/autocompleteotroservicios',
				dataType: 'json',
				data: { keyword: request.term },
				success: function(data){
					response($.map(data, function(item) {
						return {
							label: item.concatenado,
							concatenado: item.concatenado,
							idtour: item.idotroservicio,
							nombre: item.otroservicionombre,
							precio: item.otroservicioprecio,
							concatenadodetalle: item.concatenadodetalle,							
						}
					}))
				}
			});
		},
		minLength: 2,
		select: function( event, ui ) {
			$('#idotroservicio').val('');
			var j = $('#tablaDetalleServicio tr').length;
			var i = parseInt((j == 1 ? 0 : $('#tablaDetalleServicio').find('tr').eq(j - 1).find('td').eq(0).html()));
			var rows = "<tr id=Fila_" + (i + 1) + ">"+
				"<td hidden>" + (i + 1) + "</td>"+
				"<td hidden><input type='text' class='form-control form-control-sm' id='detalleTipoServicio_" + (i + 1) + "' value='OTROS'></td>"+
				"<td hidden><input type='text' class='form-control form-control-sm' id='detalleIdReserva_" + (i + 1) + "' value=''></td>"+				
				"<td>"+
					"<select class='form-control form-control-sm select2' id='detalleGravado_" + (i + 1) + "' style='width: 100%;'>"+
						"<option value='10'>GRAV</option>"+
						"<option value='20'>EXON</option>"+
						"<option value='30'>INAF</option>"+
						"<option value='40'>EXPO</option>"+
					"</select>"+
				"</td>"+
				"<td>OTROS</td>"+
				"<td>" + ui.item.idtour + "</td>"+
				"<td>" + ui.item.nombre + "</td>"+
				"<td><input type='text' class='form-control form-control-sm text-uppercase datepicker" + (i + 1) + "' id='detalleFecha_" + (i + 1) + "' readonly></td>"+
				"<td><input type='text' class='form-control form-control-sm text-uppercase' id='detallecantidad_" + (i + 1) + "' onkeyup='ImporteTotalDetalle(" + (i + 1) + ")' value='1'></td>"+
				"<td><input type='text' class='form-control form-control-sm text-uppercase' id='detalleprecio_" + (i + 1) + "' onkeyup='ImporteTotalDetalle(" + (i + 1) + ")' value='" + ui.item.precio + "'></td>"+
				"<td><input type='text' class='form-control form-control-sm text-uppercase' id='detalletotal_" + (i + 1) + "' placeholder='total' value='' disabled></td>"+
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
				"<td>"+
					"<div class='row'>"+
						"<div style='margin: auto;'>"+
							"<a class='btn btn-danger btn-xs' href='javascript:void(0)' onClick='EliminarFila(" + (i + 1) + ")'><i class='fa fa-times'></i></a>"+
						"</div>"+
						"<div style='margin: auto;'>"+
							"<a class='btn btn-info btn-xs' href='javascript:void(0)' onClick='AgregarDatos(" + (i + 1) + ")'><i class='fa fa-pencil'></i></a>"+
						"</div>"+
					"</div>"+
				"</td>"+
			"</tr>";
			$('#tablaDetalleServicio').append(rows);
			addDatepicker(i + 1);
			ImporteTotalDetalle(i + 1);
			return false;
		}
	});
	$('#idtour').autocomplete({ 
		source: function(request, response) {
			$.ajax({
				type: 'POST',
				url: base_url + '/reservadetalletour/autocompletetours',
				dataType: 'json',
				data: { keyword: request.term },
				success: function(data){
					response($.map(data, function(item) {
						return {
							label: item.concatenado,
							concatenado: item.concatenado,
							idtour: item.idtour,
							nombre: item.tournombre,
							precio: item.tourprecio,
							concatenadodetalle: item.concatenadodetalle,
						}
					}))
				}
			});
		},
		minLength: 2,
		select: function( event, ui ) {
			$('#idtour').val('');
			var j = $('#tablaDetalleServicio tr').length;
			var i = parseInt((j == 1 ? 0 : $('#tablaDetalleServicio').find('tr').eq(j - 1).find('td').eq(0).html()));
			var rows = "<tr id=Fila_" + (i + 1) + ">"+
				"<td hidden>" + (i + 1) + "</td>"+
				"<td hidden><input type='text' class='form-control form-control-sm' id='detalleTipoServicio_" + (i + 1) + "' value='TOUR'></td>"+
				"<td hidden><input type='text' class='form-control form-control-sm' id='detalleIdReserva_" + (i + 1) + "' value=''></td>"+				
				"<td>"+
					"<select class='form-control form-control-sm select2' id='detalleGravado_" + (i + 1) + "' style='width: 100%;'>"+
						"<option value='10'>GRAV</option>"+
						"<option value='20'>EXON</option>"+
						"<option value='30'>INAF</option>"+
						"<option value='40'>EXPO</option>"+
					"</select>"+
				"</td>"+
				"<td>TOUR</td>"+
				"<td>" + ui.item.idtour + "</td>"+
				"<td>" + ui.item.concatenadodetalle + "</td>"+
				"<td><input type='text' class='form-control form-control-sm text-uppercase datepicker" + (i + 1) + "' id='detalleFecha_" + (i + 1) + "' readonly></td>"+
				"<td><input type='text' class='form-control form-control-sm text-uppercase' id='detallecantidad_" + (i + 1) + "' onkeyup='ImporteTotalDetalle(" + (i + 1) + ")' value='1'></td>"+
				"<td><input type='text' class='form-control form-control-sm text-uppercase' id='detalleprecio_" + (i + 1) + "' onkeyup='ImporteTotalDetalle(" + (i + 1) + ")' value='" + ui.item.precio + "'></td>"+
				"<td><input type='text' class='form-control form-control-sm text-uppercase' id='detalletotal_" + (i + 1) + "' placeholder='total' value='' disabled></td>"+
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
				"<td>"+
					"<div class='row'>"+
						"<div style='margin: auto;'>"+
							"<a class='btn btn-danger btn-xs' href='javascript:void(0)' onClick='EliminarFila(" + (i + 1) + ")'><i class='fa fa-times'></i></a>"+
						"</div>"+
						"<div style='margin: auto;'>"+
							"<a class='btn btn-info btn-xs' href='javascript:void(0)' onClick='AgregarDatos(" + (i + 1) + ")'><i class='fa fa-pencil'></i></a>"+
						"</div>"+
					"</div>"+
				"</td>"+
			"</tr>";
			$('#tablaDetalleServicio').append(rows);
			addDatepicker(i + 1);
			ImporteTotalDetalle(i + 1);
			return false;
		}
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


	function btnEditarReserva(Val0){
		$.ajax({
			type: 'POST',
			url: base_url + '/reserva/edit',
			data: { idreserva: Val0},
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
			fechainicio: $('#fechainicio').val().split('-')[0].trim().toUpperCase(),
			fechafin: $('#fechainicio').val().split('-')[1].trim().toUpperCase(),
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

		RecolectarPasajeros();
		RecolectarServicios();
	}


	function EnviarInformacionReserva(accion, objEvento, modal, pag=1) { 
		Reserva = {
			reserva: objEvento,
			pasajeros: ListaPasajeros,
			servicios: ListaServicios
		};
		console.log(Reserva);
		$.ajax({
			type: 'POST',
			url: base_url+'/reserva/reservaadd',
			data: Reserva,
			success: function(msg){
				var resp = JSON.parse(msg);
				console.log(resp);
				if (resp.id == 1) {
					Swal.fire({
						title: resp.mensaje,
						icon: 'success'
						}).then((result) => {
						if (result.value) {
							window.location.href = base_url + '/reserva';
						}
					})
				} else {
					Swal.fire({
						title: resp.mensaje,
						icon: 'error'
					})
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
		$('#tipodoc').val('');
		$('#idpersona').val('');
		$('#reservatelefono').val('');
		$('#reservacorreo').val('');
		$('#montototal').val('');
		$('#pagado').val('');

	}


	function ValidarCamposVaciosReserva(){
		ContactoReserva();
		var error = 0;
		// if ($('#idreserva').val() == ''){
		// 	Resaltado('idreserva');
		// 	error++;
		// }
		if ($('#reservanombre').val() == ''){
			Resaltado('reservanombre');
			error++;
		}
		if ($('#fechainicio').val() == ''){
			Resaltado('fechainicio');
			error++;
		}
		if ($('#fechafin').val() == ''){
			Resaltado('fechafin');
			error++;
		}
		if ($('#tipodoc').val() == ''){
			Resaltado('tipodoc');
			error++;
		}
		if ($('#idpersona').val() == ''){
			Resaltado('idpersona');
			error++;
		}
		if ($('#reservatelefono').val() == ''){
			Resaltado('reservatelefono');
			error++;
		}
		if ($('#reservacorreo').val() == ''){
			Resaltado('reservacorreo');
			error++;
		}
		if ($('#montototal').val() == ''){
			Resaltado('montototal');
			error++;
		}
		if ($('#pagado').val() == ''){
			Resaltado('pagado');
			error++;
		}
		if ($('#estado').val() == ''){
			Resaltado('estado');
			error++;
		}
		debugger
		error += ValidarTablasDetalleReserva();
		return error;
	}

	function ContactoReserva(){
		var nropasajeros = $('#tablaPasajeros tr').length;
		for (var j = 1 ; j <= nropasajeros; j++) {
			if($("#radioPrimary"+ j).is(':checked')) {
				$('#tipodoc').val($('#idtipodoc_'+ j).val()); 
				$('#idpersona').val($('#idcliente_'+ j).val());
				$('#reservatelefono').val($('#telefono_'+ j).val());
				$('#reservacorreo').val($('#correo_'+ j).val())
			}
		}		
	}

	function ValidarTablasDetalleReserva(){
		debugger
		var error = 0;
		var nropasajeros = $('#tablaPasajeros tr').length;
		if (nropasajeros == 1) {
			document.getElementById('tablaPasajeros').style.border = "2px solid red";
			error++;
		}
		var nroservicios = $('#tablaDetalleServicio tr').length;
		if (nropasajeros == 1) {
			document.getElementById('tablaDetalleServicio').style.border = "2px solid red";
			error++;
		}
		return error;
	}

	var Reserva;
	var ListaPasajeros = [];
	var ListaServicios = [];

	function RecolectarPasajeros(){
		var nropasajeros = $('#tablaPasajeros tr').length;
		for (var i = 1 ; i <= nropasajeros - 1; i++) {
			m = $('#tablaDetalleServicio').find('tr').eq(i).find('td').eq(0).html();
			var Pasajero = {				
				idreserva: $('#idreserva').val().toUpperCase(),
				idcliente: $('#idcliente_' + m).val(),
				precio: 1500,
				confirmado: 1,
				estado: 1,
			};	
			ListaPasajeros.push(Pasajero)		
		}	
	}

	function RecolectarServicios(){
		var nroservicios = $('#tablaDetalleServicio tr').length;
		for (var j = 1 ; j <= nroservicios - 1; j++) {
			n = $('#tablaDetalleServicio').find('tr').eq(j).find('td').eq(0).html();
			var Servicio = {
				idreserva: $('#detalleIdReserva_' + n).val(),
				tiposervicio: $('#detalleTipoServicio_' + n).val(),
				idservicio: $('#tablaDetalleServicio').find('tr').eq(n).find('td').eq(5).html(),
				descripcion: $('#tablaDetalleServicio').find('tr').eq(n).find('td').eq(6).html(),
				fecha: $('#detalleFecha_' + n).val(),
				cantidad: $('#detallecantidad_' + n).val(),
				precio: $('#detalleprecio_' + n).val(),
				total: $('#detalletotal_' + n).val(),
				confirmado: $('#detalleConfirmado_' + n).val(),
				estado: $('#detalleEstado_' + n).val(),
			};	
			ListaServicios.push(Servicio)	
		}
	}

	function Resaltado(id){
		$('#'+id).css('border-color', '#ef5350');
		$('#'+id).focus();
	}


	function CargartablaReserva(objeto){   
		$('#TablaReserva tr').not($('#TablaReserva tr:first')).remove();
		$.each(objeto, function(i, value) {
		var fila = '<tr>'+
			'<td hidden>'+value.idreserva+'</td>'+
			'<td >'+value.reservanombre+'</td>'+
			'<td >'+value.fechainicio+'</td>'+
			'<td >'+value.fechafin+'</td>'+
			'<td >'+value.tipodoc+'</td>'+
			'<td >'+value.idpersona+'</td>'+
			'<td >'+value.reservatelefono+'</td>'+
			'<td >'+value.reservacorreo+'</td>'+
			'<td >'+value.montototal+'</td>'+
			'<td >'+value.pagado+'</td>'+
			'<td class = "hidden -xs">' + ((value.estado == '1') ? 'ACTIVO' : 'DESACTIVO') + '</td>'+

			'<td>'+
				'<button type="button" onclick="btnEditarReserva(\''+value.idreserva+'\')" class="btn btn-info btn-xs">'+
					'<span class="fa fa-search fa-sm"></span>'+
				'</button>'+
			'</td>'+
		'</tr>';
		$('#TablaReserva tbody').append(fila);
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
