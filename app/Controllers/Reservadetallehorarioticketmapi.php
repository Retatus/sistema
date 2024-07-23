<?php namespace App\Controllers;
use App\Controllers\BaseController;
use DateTime;
use App\Models\PaginadoModel;
use App\Models\ReservadetallehorarioticketmapiModel;
use App\Models\HorarioticketmapiModel;
use App\Models\ClientetipoModel;
use App\Models\HoraticketmapiModel;
use App\Models\TicketmapiModel;
use App\Models\ReservaModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;


class Reservadetallehorarioticketmapi extends BaseController
{
	protected $paginado;
	protected $reservadetallehorarioticketmapi;
	protected $horarioticketmapi;
	protected $clientetipo;
	protected $horaticketmapi;
	protected $ticketmapi;
	protected $reserva;


//   SECCION ====== CONSTRUCT ======
	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->reservadetallehorarioticketmapi = new ReservadetallehorarioticketmapiModel();
		$this->horarioticketmapi = new HorarioticketmapiModel();
		$this->clientetipo = new ClientetipoModel();
		$this->horaticketmapi = new HoraticketmapiModel();
		$this->ticketmapi = new TicketmapiModel();
		$this->reserva = new ReservaModel();

	}

//   SECCION ====== INDEX ======
	public function index($bestado = 1)
	{
		$reservadetallehorarioticketmapi = $this->reservadetallehorarioticketmapi->getReservadetallehorarioticketmapis(20, 1, 1, '');
		$total = $this->reservadetallehorarioticketmapi->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'reservadetallehorarioticketmapi', 'pag' => $pag, 'datos' => $reservadetallehorarioticketmapi];
		$reservadetallehorarioticketmapi = $this->reservadetallehorarioticketmapi->getReservadetallehorarioticketmapis(10, 1, 1, '');
		$horarioticketmapi = $this->horarioticketmapi->getHorarioticketmapis(10, 1, 1, '');
		$clientetipo = $this->clientetipo->getClientetipos(10, 1, 1, '');
		$horaticketmapi = $this->horaticketmapi->getHoraticketmapis(10, 1, 1, '');
		$ticketmapi = $this->ticketmapi->getTicketmapis(10, 1, 1, '');
		$reserva = $this->reserva->getReservas(10, 1, 1, '');

		echo view('layouts/header', ['horarioticketmapis' => $horarioticketmapi, 'clientetipos' => $clientetipo, 'horaticketmapis' => $horaticketmapi, 'ticketmapis' => $ticketmapi, 'reservas' => $reserva]);
		echo view('layouts/aside');
		echo view('reservadetallehorarioticketmapi/list', $data);
		echo view('layouts/footer');

	}
//   SECCION ====== AGREGAR ======
	public function agregar(){

		$total = $this->reservadetallehorarioticketmapi->getCount('', '');
		$pag = $this->paginado->pagina(1, $total, 1);
		print_r($pag);
	}

//   SECCION ====== OPCIONES ======
	public function opciones(){
		$accion = (isset($_GET['accion'])) ? $_GET['accion']:'leer';
		$pag = (int)(isset($_GET['pag'])) ? $_GET['pag']:1;
		
		$todos = $this->request->getPost('todos');
		$texto = strtoupper(trim($this->request->getPost('texto')));

		if($accion !== 'leer'){
			$nidreservadetallehorarioticketmapi = strtoupper(trim($this->request->getPost('idreservadetallehorarioticketmapi')));
			$nidreserva = strtoupper(trim($this->request->getPost('idreserva')));
			$tempdate = trim($this->request->getPost('fecha'));
			$tempdate = explode('/', $tempdate);
			$tfecha = date('Y-m-d', strtotime($tempdate[1].'/'.$tempdate[0].'/'.$tempdate[2]));
			$sdescripcion = strtoupper(trim($this->request->getPost('descripcion')));
			$ncantidad = strtoupper(trim($this->request->getPost('cantidad')));
			$dprecio = strtoupper(trim($this->request->getPost('precio')));
			$dtotal = strtoupper(trim($this->request->getPost('total')));
			$nidhorarioticketmapi = strtoupper(trim($this->request->getPost('idhorarioticketmapi')));
			$bconfirmado = strtoupper(trim($this->request->getPost('confirmado')));
			$bestado = strtoupper(trim($this->request->getPost('estado')));
		}


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion){
			case 'agregar':
				$data  = array(
					'nidreservadetallehorarioticketmapi' => intval($nidreservadetallehorarioticketmapi),
					'nidreserva' => intval($nidreserva),
					'tfecha' => $tfecha,
					'sdescripcion' => $sdescripcion,
					'ncantidad' => intval($ncantidad),
					'dprecio' => doubleval($dprecio),
					'dtotal' => doubleval($dtotal),
					'nidhorarioticketmapi' => $nidhorarioticketmapi,
					'bconfirmado' => intval($bconfirmado),
					'bestado' => intval($bestado),

				);
				if ($this->reservadetallehorarioticketmapi->existe($nidreservadetallehorarioticketmapi, $nidreserva, $nidhorarioticketmapi) == 1){
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->reservadetallehorarioticketmapi->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'nidreserva' => intval($nidreserva),
					'tfecha' => $tfecha,
					'sdescripcion' => $sdescripcion,
					'ncantidad' => intval($ncantidad),
					'dprecio' => doubleval($dprecio),
					'dtotal' => doubleval($dtotal),
					'nidhorarioticketmapi' => $nidhorarioticketmapi,
					'bconfirmado' => intval($bconfirmado),
					'bestado' => intval($bestado),

				);
				$this->reservadetallehorarioticketmapi->UpdateReservadetallehorarioticketmapi($nidreservadetallehorarioticketmapi, $nidreserva, $nidhorarioticketmapi, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->reservadetallehorarioticketmapi->UpdateReservadetallehorarioticketmapi($nidreservadetallehorarioticketmapi, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->reservadetallehorarioticketmapi->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->reservadetallehorarioticketmapi->getReservadetallehorarioticketmapis(20, $pag, $todos, $texto)];
		echo json_encode($respt);
	}

//   SECCION ====== EDIT ======
	public function edit(){
		$nidreservadetallehorarioticketmapi = strtoupper(trim($this->request->getPost('idreservadetallehorarioticketmapi')));
		$nidreserva = strtoupper(trim($this->request->getPost('idreserva')));
		$nidhorarioticketmapi = strtoupper(trim($this->request->getPost('idhorarioticketmapi')));

		$data = $this->reservadetallehorarioticketmapi->getReservadetallehorarioticketmapi($nidreservadetallehorarioticketmapi, $nidreserva, $nidhorarioticketmapi);
		echo json_encode($data);
	}


	public function autocompletereservadetallehorarioticketmapis()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->reservadetallehorarioticketmapi->getAutocompletereservadetallehorarioticketmapis($todos,$keyword);
		echo json_encode($data);
	}
	public function autocompletehorarioticketmapis()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->horarioticketmapi->getAutocompletehorarioticketmapis($todos,$keyword);
		echo json_encode($data);
	}
	public function autocompleteclientetipos()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->clientetipo->getAutocompleteclientetipos($todos,$keyword);
		echo json_encode($data);
	}
	public function autocompletehoraticketmapis()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->horaticketmapi->getAutocompletehoraticketmapis($todos,$keyword);
		echo json_encode($data);
	}
	public function autocompleteticketmapis()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->ticketmapi->getAutocompleteticketmapis($todos,$keyword);
		echo json_encode($data);
	}
	public function autocompletereservas()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->reserva->getAutocompletereservas($todos,$keyword);
		echo json_encode($data);
	}
//   SECCION ====== Reservadetallehorarioticketmapi SELECT NOMBRE ======
	public function getReservadetallehorarioticketmapisSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->reservadetallehorarioticketmapi->getReservadetallehorarioticketmapisSelectNombre($searchTerm);
		echo json_encode($response);
	}


//   SECCION ====== PDF ======
	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de reservadetallehorarioticketmapi', 0, 1, 'C');
		$pdf->Output('reservadetallehorarioticketmapi.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

//   SECCION ====== EXCEL ======
	public function excel()
	{
		$total = $this->reservadetallehorarioticketmapi->getCount();

		$reservadetallehorarioticketmapi = $this->reservadetallehorarioticketmapi->getReservadetallehorarioticketmapis($total, 1, 1, '');
		require_once ROOTPATH . 'vendor/autoload.php';
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->setActiveSheetIndex(0);
		$sheet->getColumnDimension('A')->setAutoSize(true);
		$sheet->getColumnDimension('B')->setAutoSize(true);
		$sheet->getColumnDimension('C')->setAutoSize(true);
		$sheet->getColumnDimension('D')->setAutoSize(true);
		$sheet->getColumnDimension('E')->setAutoSize(true);
		$sheet->getColumnDimension('F')->setAutoSize(true);
		$sheet->getColumnDimension('G')->setAutoSize(true);
		$sheet->getColumnDimension('H')->setAutoSize(true);
		$sheet->getColumnDimension('I')->setAutoSize(true);
		$sheet->getColumnDimension('J')->setAutoSize(true);
		$sheet->getColumnDimension('K')->setAutoSize(true);
		$sheet->getColumnDimension('L')->setAutoSize(true);
		$sheet->getColumnDimension('M')->setAutoSize(true);
		$sheet->getColumnDimension('N')->setAutoSize(true);
		$sheet->getColumnDimension('O')->setAutoSize(true);
		$sheet->getColumnDimension('P')->setAutoSize(true);
		$sheet->getColumnDimension('Q')->setAutoSize(true);
		$sheet->getColumnDimension('R')->setAutoSize(true);
		$sheet->getColumnDimension('S')->setAutoSize(true);
		$sheet->getStyle('A1:S1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF92C5FC');
		$border = ['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000'], ], ], ];
		$sheet->setCellValue('A1', 'IDRESERVADETALLEHORARIOTICKETMAPI');
		$sheet->setCellValue('B1', 'FECHA');
		$sheet->setCellValue('C1', 'DESCRIPCION');
		$sheet->setCellValue('D1', 'CANTIDAD');
		$sheet->setCellValue('E1', 'PRECIO');
		$sheet->setCellValue('F1', 'TOTAL');
		$sheet->setCellValue('G1', 'CONFIRMADO');
		$sheet->setCellValue('H1', 'ESTADO');
		$sheet->setCellValue('I1', 'IDHORARIOTICKETMAPI');
		$sheet->setCellValue('J1', 'IDCLIENTETIPO');
		$sheet->setCellValue('K1', 'NOMBRE');
		$sheet->setCellValue('L1', 'IDHORATICKETMAPI');
		$sheet->setCellValue('M1', 'NOMBRE');
		$sheet->setCellValue('N1', 'IDTICKETMAPI');
		$sheet->setCellValue('O1', 'NOMBRE');
		$sheet->setCellValue('P1', 'IDRESERVA');
		$sheet->setCellValue('Q1', 'RESERVANOMBRE');
		$sheet->setCellValue('R1', 'CONCATENADO');
		$sheet->setCellValue('S1', 'CONCATENADODETALLE');
		$i=2;
		foreach ($reservadetallehorarioticketmapi as $row){
			$sheet->setCellValue('A'.$i, $row['idreservadetallehorarioticketmapi']);
			$sheet->setCellValue('B'.$i, $row['fecha']);
			$sheet->setCellValue('C'.$i, $row['descripcion']);
			$sheet->setCellValue('D'.$i, $row['cantidad']);
			$sheet->setCellValue('E'.$i, $row['precio']);
			$sheet->setCellValue('F'.$i, $row['total']);
			$sheet->setCellValue('G'.$i, $row['confirmado']);
			$sheet->setCellValue('H'.$i, $row['estado']);
			$sheet->setCellValue('I'.$i, $row['idhorarioticketmapi']);
			$sheet->setCellValue('J'.$i, $row['idclientetipo']);
			$sheet->setCellValue('K'.$i, $row['nombre']);
			$sheet->setCellValue('L'.$i, $row['idhoraticketmapi']);
			$sheet->setCellValue('M'.$i, $row['nombre']);
			$sheet->setCellValue('N'.$i, $row['idticketmapi']);
			$sheet->setCellValue('O'.$i, $row['nombre']);
			$sheet->setCellValue('P'.$i, $row['idreserva']);
			$sheet->setCellValue('Q'.$i, $row['reservanombre']);
			$sheet->setCellValue('R'.$i, $row['concatenado']);
			$sheet->setCellValue('S'.$i, $row['concatenadodetalle']);
			$i++;
		}
		$sheet->getStyle('A1:S1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++){
			$sheet->getStyle('A'.$j.':S'.$j)->applyFromArray($border);
		}

		$writer = new Xls($spreadsheet);
		$filename = 'Lista_Reservadetallehorarioticketmapi.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit;
	}

}
