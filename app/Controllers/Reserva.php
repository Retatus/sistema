<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PaginadoModel;
use App\Models\ReservaModel;
use App\Models\TicketbusModel;
use App\Models\ClienteModel;
use App\Models\TipodocModel;
use App\Models\HorarioticketmapiModel;
use App\Models\HorariotrenModel;
use App\Models\HotelhabitacionModel;
use App\Models\OtroservicioModel;
use App\Models\TourModel;

use App\Models\ReservadetallebusModel;
use App\Models\ReservadetalleclienteModel;
use App\Models\ReservadetallehorarioticketmapiModel;
use App\Models\ReservadetallehorariotrenModel;
use App\Models\ReservadetallehotelhabitacionModel;
use App\Models\ReservadetalleotroservicioModel;
use App\Models\ReservadetalletourModel;

class Reserva extends BaseController
{
	protected $paginado;
	protected $reserva;
	protected $ticketbus;
	protected $cliente;
	protected $tipodoc;
	protected $horarioticketmapi;
	protected $horariotren;
	protected $hotelhabitacion;
	protected $otroservicio;
	protected $tour;

	protected $reservadetallebus;
	protected $reservadetallecliente;
	protected $reservadetallehorarioticketmapi;
	protected $reservadetallehorariotren;
	protected $reservadetallehotelhabitacion;
	protected $reservadetalleotroservicio;
	protected $reservadetalletour;

	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->reserva = new ReservaModel();
		$this->ticketbus = new TicketbusModel();
		$this->cliente = new ClienteModel();
		$this->tipodoc = new TipodocModel();
		$this->horarioticketmapi = new HorarioticketmapiModel();
		$this->horariotren = new HorariotrenModel();
		$this->hotelhabitacion = new HotelhabitacionModel();
		$this->otroservicio = new OtroservicioModel();
		$this->tour = new TourModel();

		$this->reservadetallebus = new ReservadetallebusModel();
		$this->reservadetallecliente = new ReservadetalleclienteModel();
		$this->reservadetallehorarioticketmapi = new ReservadetallehorarioticketmapiModel();
		$this->reservadetallehorariotren = new ReservadetallehorariotrenModel();
		$this->reservadetallehotelhabitacion = new ReservadetallehotelhabitacionModel();
		$this->reservadetalleotroservicio = new ReservadetalleotroservicioModel();
		$this->reservadetalletour = new ReservadetalletourModel();
	}

	public function index($bestado = 1)
	{
		$reserva = $this->reserva->getReservas(1, '', 10, 1);
		$total = $this->reserva->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'reserva', 'pag' => $pag, 'datos' => $reserva];
		$ticketbus = $this->ticketbus->getTicketbuss(1, '', 10, 1);
		$cliente = $this->cliente->getClientes(1, '', 10, 1);
		$horarioticketmapi = $this->horarioticketmapi->getHorarioticketmapis(1, '', 10, 1);
		$horariotren = $this->horariotren->getHorariotrens(1, '', 10, 1);
		$hotelhabitacion = $this->hotelhabitacion->getHotelhabitacions(1, '', 10, 1);
		$otroservicio = $this->otroservicio->getOtroservicios(1, '', 10, 1);
		$tour = $this->tour->getTours(1, '', 10, 1);

		echo view('layouts/header', ['ticketbuss' => $ticketbus,'clientes' => $cliente,'horarioticketmapis' => $horarioticketmapi,'horariotrens' => $horariotren,'hotelhabitacions' => $hotelhabitacion,'otroservicios' => $otroservicio,'tours' => $tour]);
		echo view('layouts/aside');
		echo view('reserva/list', $data);
		echo view('layouts/footer');
	}

	public function add($id = 0)
	{
		$tipodoc = $this->tipodoc->getTipodocs(1, '', 10, 1);
		$reserva = $this->reserva->getReserva($id);
		$cliente = $this->reservadetallecliente->getReservadetallecliente2($id);
		$servicios = $this->reserva->getNewReserva($id);
		echo view('layouts/header', ['reserva'=>$reserva,'clientes' => $cliente,'servicios' => $servicios,'tipodocs' => $tipodoc]);
		echo view('layouts/aside');
		echo view('reserva/add');
		echo view('layouts/footer');
	}

	public function edit($id = 0)
	{
		$tipodoc = $this->tipodoc->getTipodocs(1, '', 10, 1);
		$reserva = $this->reserva->getReserva($id);
		$cliente = $this->reservadetallecliente->getReservadetallecliente2($id);
		$servicios = $this->reserva->getNewReserva($id);
		echo view('layouts/header', ['reserva'=>$reserva,'clientes' => $cliente,'servicios' => $servicios,'tipodocs' => $tipodoc]);
		echo view('layouts/aside');
		echo view('reserva/edit');
		echo view('layouts/footer');
	}
	
	public function reservaadd()
	{
		$respt = array();
		$maxid = 0;
		$mensaje = '';
		$entro = 'no';
		$reserva = $this->request->getPost('reserva');
		$pasajeros = $this->request->getPost('pasajeros');
		$servicios = $this->request->getPost('servicios');
		$data  = array(
			'nidreserva'=> intval($reserva["idreserva"]),
			'sreservanombre'=> $reserva["reservanombre"],
			'tfechainicio'=> date_format(date_create(str_replace("/","-", $reserva["fechainicio"])),"Y-m-d"),
			'tfechafin'=> date_format(date_create(str_replace("/","-", $reserva["fechafin"])),"Y-m-d"),
			'ntipodoc'=> $reserva["tipodoc"],
			'sidpersona'=> $reserva["idpersona"],
			'sreservatelefono'=> $reserva["reservatelefono"],
			'sreservacorreo'=> $reserva["reservacorreo"],
			'dmontototal'=> doubleval($reserva["montototal"]),
			'bpagado'=> intval($reserva["pagado"]),
			'bestado'=> $reserva["estado"],
		);
		if ($this->reserva->existe($nidreserva) == 1) {
			$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
		} else {
			$this->reserva->insert($data);		
			$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
			$maxid = $this->reserva->getMaxid();
		}
		if (!is_null($maxid)) {
			foreach($pasajeros as $pasajero){
				$data  = array(
					'nidreserva' => intval($maxid),
					'sidcliente' => $pasajero["idcliente"], 
					'dprecio' => doubleval($pasajero["precio"]),
					'bconfirmado' => intval($pasajero["confirmado"]),
					'bestado' => intval($pasajero["estado"]),
				);
				$this->reservadetallecliente->insert($data);
			}
			
			foreach($servicios as $servicio){	
				switch ($servicio["tiposervicio"]) {
					case 'BUS': // BUS
						$data  = array(
							'nidreserva' => intval($maxid),
							'nidticketbus' => $servicio["idservicio"],
							'tfecha' => date_format(date_create(str_replace("/","-", $servicio["fecha"])),"Y-m-d"),
							'ncantidad' => intval($servicio["cantidad"]),
							'dprecio' => doubleval($servicio["precio"]),
							'dtotal' => doubleval($servicio["total"]),
							'bconfirmado' => intval($servicio["confirmado"]),
							'bestado' => intval($servicio["estado"]),
						);
						$this->reservadetallebus->insert($data);
						break;
					case 'MAPI': // TICKET MAPI
						$data  = array(
							// 'nidreservadetallehorarioticketmapi' => intval($nidreservadetallehorarioticketmapi),
							'nidreserva' => intval($maxid),
							'nidhorarioticketmapi' => $servicio["idservicio"],
							'tfecha' => date_format(date_create(str_replace("/","-", $servicio["fecha"])),"Y-m-d"),
							'ncantidad' => intval($servicio["cantidad"]),
							'dprecio' => doubleval($servicio["precio"]),
							'dtotal' => doubleval($servicio["total"]),
							'bconfirmado' => intval($servicio["confirmado"]),
							'bestado' => intval($servicio["estado"]),
						);
						$this->reservadetallehorarioticketmapi->insert($data);
						break;
					case 'TREN': // TREN
						$data  = array(
							// 'nidreservadetallehorariotren' => intval($nidreservadetallehorariotren),
							'nidreserva' => intval($maxid),
							'nidhorariotren' => $servicio["idservicio"],
							'tfecha' => date_format(date_create(str_replace("/","-", $servicio["fecha"])),"Y-m-d"),
							'ncantidad' => intval($servicio["cantidad"]),
							'dprecio' => doubleval($servicio["precio"]),
							'dtotal' => doubleval($servicio["total"]),
							'bconfirmado' => intval($servicio["confirmado"]),
							'bestado' => intval($servicio["estado"]),
						);
						$this->reservadetallehorariotren->insert($data);
						break;
					case 'HOTEL': // HOTEL
						$data  = array(
							//'nidreservadetallehotelhabitacion' => intval($nidreservadetallehotelhabitacion),
							'nidreserva' => intval($maxid),
							'nidhotelhabitacion' => $servicio["idservicio"],
							'tfechaingreso' => date_format(date_create(str_replace("/","-", $servicio["fecha"])),"Y-m-d"),
							'tfechasalida' => date_format(date_create(str_replace("/","-", $servicio["fecha"])),"Y-m-d"),
							'ncantidad' => intval($servicio["cantidad"]),
							'dprecio' => doubleval($servicio["precio"]),
							'dtotal' => doubleval($servicio["total"]),
							'bconfirmado' => intval($servicio["confirmado"]),
							'bestado' => intval($servicio["estado"]),
						);
						$this->reservadetallehotelhabitacion->insert($data);
						break;
					case 'OTROS': // OTROS SERVICION
						$data  = array(
							//'nidreservadetalleotroservicio' => intval($nidreservadetalleotroservicio),
							'nidreserva' => intval($maxid),
							'nidotroservicio' => $servicio["idservicio"],
							'tfecha' => date_format(date_create(str_replace("/","-", $servicio["fecha"])),"Y-m-d"),
							'ncantidad' => intval($servicio["cantidad"]),
							'dprecio' => doubleval($servicio["precio"]),
							'dtotal' => doubleval($servicio["total"]),
							'bconfirmado' => intval($servicio["confirmado"]),
							'bestado' => intval($servicio["estado"]),
						);
						$this->reservadetalleotroservicio->insert($data);
						break;
					case 'TOUR': // TOUR
						$data  = array(
							'nidreserva' => intval($maxid),
							'sidtour' => $servicio["idservicio"],
							'tfecha' => date_format(date_create(str_replace("/","-", $servicio["fecha"])),"Y-m-d"),
							'ncantidad' => intval($servicio["cantidad"]),
							'dprecio' => doubleval($servicio["precio"]),
							'dtotal' => doubleval($servicio["total"]),
							'bconfirmado' => intval($servicio["confirmado"]),
							'bestado' => intval($servicio["estado"]),
						);
						$this->reservadetalletour->insert($data);
						break;
				}
			}
		}	
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'entro' => $entro];				
		echo json_encode($respt);
	}

	public function reservaedit()
	{
		$respt = array();
		$maxid = 0;
		$mensaje = '';
		$entro = 'no';
		$reserva = $this->request->getPost('reserva');
		$pasajeros = $this->request->getPost('pasajeros');
		$servicios = $this->request->getPost('servicios');
		$data  = array(
			'nidreserva'=> intval($reserva["idreserva"]),
			'sreservanombre'=> $reserva["reservanombre"],
			'tfechainicio'=> date_format(date_create(str_replace("/","-", $reserva["fechainicio"])),"Y-m-d"),
			'tfechafin'=> date_format(date_create(str_replace("/","-", $reserva["fechafin"])),"Y-m-d"),
			'ntipodoc'=> $reserva["tipodoc"],
			'sidpersona'=> $reserva["idpersona"],
			'sreservatelefono'=> $reserva["reservatelefono"],
			'sreservacorreo'=> $reserva["reservacorreo"],
			'dmontototal'=> doubleval($reserva["montototal"]),
			'bpagado'=> intval($reserva["pagado"]),
			'bestado'=> $reserva["estado"],
		);
		$nidreserva = intval($reserva["idreserva"]);
		$this->reserva->UpdateReserva($nidreserva, $data);
		$id = 1; $mensaje = 'ACTUALIZO CORRECTAMENTE';
		foreach($pasajeros as $pasajero){
			$data  = array(
				'nidreserva' => intval($maxid),
				'sidcliente' => $pasajero["idcliente"], 
				'dprecio' => doubleval($pasajero["precio"]),
				'bconfirmado' => intval($pasajero["confirmado"]),
				'bestado' => intval($pasajero["estado"]),
			);
			$this->reservadetallecliente->UpdateReservadetallecliente($nidreserva,$data);
		}
		foreach($servicios as $servicio){	
			switch ($servicio["tiposervicio"]) {
				case 'BUS': // BUS
					$data  = array(
						'nidreserva' => $nidreserva,
						'nidticketbus' => $servicio["idservicio"],
						'tfecha' => date_format(date_create(str_replace("/","-", $servicio["fecha"])),"Y-m-d"),
						'ncantidad' => intval($servicio["cantidad"]),
						'dprecio' => doubleval($servicio["precio"]),
						'dtotal' => doubleval($servicio["total"]),
						'bconfirmado' => intval($servicio["confirmado"]),
						'bestado' => intval($servicio["estado"]),
					);
					$this->reservadetallebus->UpdateReservadetallebus($nidreserva,$data);
					break;
				case 'MAPI': // TICKET MAPI
					$data  = array(
						// 'nidreservadetallehorarioticketmapi' => intval($nidreservadetallehorarioticketmapi),
						'nidreserva' => $nidreserva,
						'nidhorarioticketmapi' => 13, //$servicio["idservicio"],
						'tfecha' => date_format(date_create(str_replace("/","-", $servicio["fecha"])),"Y-m-d"),
						'ncantidad' => intval($servicio["cantidad"]),
						'dprecio' => doubleval($servicio["precio"]),
						'dtotal' => doubleval($servicio["total"]),
						'bconfirmado' => intval($servicio["confirmado"]),
						'bestado' => intval($servicio["estado"]),
					);
					$this->reservadetallehorarioticketmapi->UpdateReservadetallehorarioticketmapi($nidreserva,$data);
					break;
				case 'TREN': // TREN
					$data  = array(
						// 'nidreservadetallehorariotren' => intval($nidreservadetallehorariotren),
						'nidreserva' => $nidreserva,
						'nidhorariotren' => $servicio["idservicio"],
						'tfecha' => date_format(date_create(str_replace("/","-", $servicio["fecha"])),"Y-m-d"),
						'ncantidad' => intval($servicio["cantidad"]),
						'dprecio' => doubleval($servicio["precio"]),
						'dtotal' => doubleval($servicio["total"]),
						'bconfirmado' => intval($servicio["confirmado"]),
						'bestado' => intval($servicio["estado"]),
					);
					$this->reservadetallehorariotren->UpdateReservadetallehorariotren($nidreserva,$data);
					break;
				case 'HOTEL': // HOTEL
					$data  = array(
						//'nidreservadetallehotelhabitacion' => intval($nidreservadetallehotelhabitacion),
						'nidreserva' => $nidreserva,
						'nidhotelhabitacion' => $servicio["idservicio"],
						'tfechaingreso' => date_format(date_create(str_replace("/","-", $servicio["fecha"])),"Y-m-d"),
						'tfechasalida' => date_format(date_create(str_replace("/","-", $servicio["fecha"])),"Y-m-d"),
						'ncantidad' => intval($servicio["cantidad"]),
						'dprecio' => doubleval($servicio["precio"]),
						'dtotal' => doubleval($servicio["total"]),
						'bconfirmado' => intval($servicio["confirmado"]),
						'bestado' => intval($servicio["estado"]),
					);
					$this->reservadetallehotelhabitacion->UpdateReservadetallehotelhabitacion($nidreserva,$data);
					break;
				case 'OTROS': // OTROS SERVICION
					$data  = array(
						//'nidreservadetalleotroservicio' => intval($nidreservadetalleotroservicio),
						'nidreserva' => $nidreserva,
						'nidotroservicio' => $servicio["idservicio"],
						'tfecha' => date_format(date_create(str_replace("/","-", $servicio["fecha"])),"Y-m-d"),
						'ncantidad' => intval($servicio["cantidad"]),
						'dprecio' => doubleval($servicio["precio"]),
						'dtotal' => doubleval($servicio["total"]),
						'bconfirmado' => intval($servicio["confirmado"]),
						'bestado' => intval($servicio["estado"]),
					);
					$this->reservadetalleotroservicio->UpdateReservadetalleotroservicio($nidreserva,$data);
					break;
				case 'TOUR': // TOUR
					$data  = array(
						'nidreserva' => $nidreserva,
						'sidtour' => $servicio["idservicio"],
						'tfecha' => date_format(date_create(str_replace("/","-", $servicio["fecha"])),"Y-m-d"),
						'ncantidad' => intval($servicio["cantidad"]),
						'dprecio' => doubleval($servicio["precio"]),
						'dtotal' => doubleval($servicio["total"]),
						'bconfirmado' => intval($servicio["confirmado"]),
						'bestado' => intval($servicio["estado"]),
					);
					$this->reservadetalletour->UpdateReservadetalletour($nidreserva,$data);
					break;
			}
		}
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'entro' => $servicios];				
		echo json_encode($respt);
	}
	
	public function agregar(){
	
		$total = $this->reserva->getNewReserva(59);
		print_r($total);
	}
	public function opciones(){
		$accion = (isset($_GET['accion'])) ? $_GET['accion']:'leer';
		$pag = (int)(isset($_GET['pag'])) ? $_GET['pag']:1;

		$todos = $this->request->getPost('todos');
		$texto = strtoupper(trim($this->request->getPost('texto')));

		$nidreserva = strtoupper(trim($this->request->getPost('idreserva')));
		$sreservanombre = strtoupper(trim($this->request->getPost('reservanombre')));
		$tempdate = trim($this->request->getPost('fechainicio'));
		$tempdate = explode('/', $tempdate);
		$tfechainicio = date('Y-m-d', strtotime($tempdate[1].'/'.$tempdate[0].'/'.$tempdate[2]));
		$tempdate = trim($this->request->getPost('fechafin'));
		$tempdate = explode('/', $tempdate);
		$tfechafin = date('Y-m-d', strtotime($tempdate[1].'/'.$tempdate[0].'/'.$tempdate[2]));
		$ntipodoc = strtoupper(trim($this->request->getPost('tipodoc')));
		$sidpersona = strtoupper(trim($this->request->getPost('idpersona')));
		$sreservatelefono = strtoupper(trim($this->request->getPost('reservatelefono')));
		$sreservacorreo = strtoupper(trim($this->request->getPost('reservacorreo')));
		$dmontototal = strtoupper(trim($this->request->getPost('montototal')));
		$bpagado = strtoupper(trim($this->request->getPost('pagado')));
		$bestado = strtoupper(trim($this->request->getPost('estado')));


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion) {
			case 'agregar':
				$data  = array(
					'nidreserva' => intval($nidreserva),
					'sreservanombre' => $sreservanombre,
					'tfechainicio' => $tfechainicio,
					'tfechafin' => $tfechafin,
					'ntipodoc' => $ntipodoc,
					'sidpersona' => $sidpersona,
					'sreservatelefono' => $sreservatelefono,
					'sreservacorreo' => $sreservacorreo,
					'dmontototal' => doubleval($dmontototal),
					'bpagado' => intval($bpagado),
					'bestado' => $bestado,

				);
				if ($this->reserva->existe($nidreserva) == 1) {
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->reserva->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'sreservanombre' => $sreservanombre,
					'tfechainicio' => $tfechainicio,
					'tfechafin' => $tfechafin,
					'ntipodoc' => $ntipodoc,
					'sidpersona' => $sidpersona,
					'sreservatelefono' => $sreservatelefono,
					'sreservacorreo' => $sreservacorreo,
					'dmontototal' => doubleval($dmontototal),
					'bpagado' => intval($bpagado),
					'bestado' => $bestado,

				);
				$this->reserva->UpdateReserva($nidreserva, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->reserva->UpdateReserva($nidreserva, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->reserva->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->reserva->getreservas($todos, $texto, 10, $pag)];
		echo json_encode($respt);
	}

	// public function edit(){ 
	// 	$nidreserva = strtoupper(trim($this->request->getPost('idreserva')));

	// 	$data = $this->reserva->getReserva($nidreserva);
	// 	echo json_encode($data);
	// }


	public function getreservasSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->reserva->getreservasSelectNombre($searchTerm);
		echo json_encode($response);
	}


	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de reserva', 0, 1, 'C');
		$pdf->Output('reserva.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

	public function excel()
	{
		$total = $this->reserva->getCount();

		$reserva = $this->reserva->getReservas(1, '', $total, 1);
		$doc = new \PHPExcel();
		$doc->setActiveSheetIndex(0);
		$doc->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$doc->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$doc->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$doc->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$doc->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$doc->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$doc->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		$doc->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
		$doc->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
		$doc->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
		$doc->getActiveSheet()->getStyle('A1:J1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF92C5FC');
		$border = array('borders' => array('allborders' => array('style' => \PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))));
		$doc->getActiveSheet()->SetCellValue('A1', 'NOMBRE');
		$doc->getActiveSheet()->SetCellValue('B1', 'FECHAINICIO');
		$doc->getActiveSheet()->SetCellValue('C1', 'FECHAFIN');
		$doc->getActiveSheet()->SetCellValue('D1', 'TIPODOC');
		$doc->getActiveSheet()->SetCellValue('E1', 'IDPERSONA');
		$doc->getActiveSheet()->SetCellValue('F1', 'TELEFONO');
		$doc->getActiveSheet()->SetCellValue('G1', 'CORREO');
		$doc->getActiveSheet()->SetCellValue('H1', 'MONTOTOTAL');
		$doc->getActiveSheet()->SetCellValue('I1', 'PAGADO');
		$doc->getActiveSheet()->SetCellValue('J1', 'ESTADO');
		$i=2;
		foreach ($reserva as $row) {
			$doc->getActiveSheet()->SetCellValue('A'.$i, $row['reservanombre']);
			$doc->getActiveSheet()->SetCellValue('B'.$i, $row['fechainicio']);
			$doc->getActiveSheet()->SetCellValue('C'.$i, $row['fechafin']);
			$doc->getActiveSheet()->SetCellValue('D'.$i, $row['tipodoc']);
			$doc->getActiveSheet()->SetCellValue('E'.$i, $row['idpersona']);
			$doc->getActiveSheet()->SetCellValue('F'.$i, $row['reservatelefono']);
			$doc->getActiveSheet()->SetCellValue('G'.$i, $row['reservacorreo']);
			$doc->getActiveSheet()->SetCellValue('H'.$i, $row['montototal']);
			$doc->getActiveSheet()->SetCellValue('I'.$i, $row['pagado']);
			$doc->getActiveSheet()->SetCellValue('J'.$i, $row['estado']);
			$i++;
		}
		$doc->getActiveSheet()->getStyle('A1:J1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++) {
			$doc->getActiveSheet()->getStyle('A'.$j.':J'.$j)->applyFromArray($border);
		}

		$filename = 'Lista_reserva.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$objWriter = \PHPExcel_IOFactory::createWriter($doc, 'Excel5');
		$objWriter->save('php://output');
	}

}
