<?php namespace App\Controllers;
use App\Controllers\BaseController;
use DateTime;
use App\Models\PaginadoModel;
use App\Models\HorarioticketmapiModel;
use App\Models\ClientetipoModel;
use App\Models\HoraticketmapiModel;
use App\Models\TicketmapiModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;


class Horarioticketmapi extends BaseController
{
	protected $paginado;
	protected $horarioticketmapi;
	protected $clientetipo;
	protected $horaticketmapi;
	protected $ticketmapi;


//   SECCION ====== CONSTRUCT ======
	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->horarioticketmapi = new HorarioticketmapiModel();
		$this->clientetipo = new ClientetipoModel();
		$this->horaticketmapi = new HoraticketmapiModel();
		$this->ticketmapi = new TicketmapiModel();

	}

//   SECCION ====== INDEX ======
	public function index($bestado = 1)
	{
		$horarioticketmapi = $this->horarioticketmapi->getHorarioticketmapis(20, 1, 1, '');
		$total = $this->horarioticketmapi->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'horarioticketmapi', 'pag' => $pag, 'datos' => $horarioticketmapi];
		$horarioticketmapi = $this->horarioticketmapi->getHorarioticketmapis(10, 1, 1, '');
		$clientetipo = $this->clientetipo->getClientetipos(10, 1, 1, '');
		$horaticketmapi = $this->horaticketmapi->getHoraticketmapis(10, 1, 1, '');
		$ticketmapi = $this->ticketmapi->getTicketmapis(10, 1, 1, '');

		echo view('layouts/header', ['clientetipos' => $clientetipo, 'horaticketmapis' => $horaticketmapi, 'ticketmapis' => $ticketmapi]);
		echo view('layouts/aside');
		echo view('horarioticketmapi/list', $data);
		echo view('layouts/footer');

	}
//   SECCION ====== AGREGAR ======
	public function agregar(){

		$total = $this->horarioticketmapi->getCount('', '');
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
			$nidhorarioticketmapi = strtoupper(trim($this->request->getPost('idhorarioticketmapi')));
			$nidhoraticketmapi = strtoupper(trim($this->request->getPost('idhoraticketmapi')));
			$nidticketmapi = strtoupper(trim($this->request->getPost('idticketmapi')));
			$nidclientetipo = strtoupper(trim($this->request->getPost('idclientetipo')));
			$dprecio = strtoupper(trim($this->request->getPost('precio')));
			$bestado = strtoupper(trim($this->request->getPost('estado')));
		}


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion){
			case 'agregar':
				$data  = array(
					'nidhorarioticketmapi' => $nidhorarioticketmapi,
					'nidhoraticketmapi' => $nidhoraticketmapi,
					'nidticketmapi' => $nidticketmapi,
					'nidclientetipo' => intval($nidclientetipo),
					'dprecio' => doubleval($dprecio),
					'bestado' => intval($bestado),

				);
				if ($this->horarioticketmapi->existe($nidhorarioticketmapi, $nidhoraticketmapi, $nidticketmapi, $nidclientetipo) == 1){
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->horarioticketmapi->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'nidhoraticketmapi' => $nidhoraticketmapi,
					'nidticketmapi' => $nidticketmapi,
					'nidclientetipo' => intval($nidclientetipo),
					'dprecio' => doubleval($dprecio),
					'bestado' => intval($bestado),

				);
				$this->horarioticketmapi->UpdateHorarioticketmapi($nidhorarioticketmapi, $nidhoraticketmapi, $nidticketmapi, $nidclientetipo, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->horarioticketmapi->UpdateHorarioticketmapi($nidhorarioticketmapi, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->horarioticketmapi->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->horarioticketmapi->getHorarioticketmapis(20, $pag, $todos, $texto)];
		echo json_encode($respt);
	}

//   SECCION ====== EDIT ======
	public function edit(){
		$nidhorarioticketmapi = strtoupper(trim($this->request->getPost('idhorarioticketmapi')));
		$nidhoraticketmapi = strtoupper(trim($this->request->getPost('idhoraticketmapi')));
		$nidticketmapi = strtoupper(trim($this->request->getPost('idticketmapi')));
		$nidclientetipo = strtoupper(trim($this->request->getPost('idclientetipo')));

		$data = $this->horarioticketmapi->getHorarioticketmapi($nidhorarioticketmapi, $nidhoraticketmapi, $nidticketmapi, $nidclientetipo);
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
//   SECCION ====== Horarioticketmapi SELECT NOMBRE ======
	public function getHorarioticketmapisSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->horarioticketmapi->getHorarioticketmapisSelectNombre($searchTerm);
		echo json_encode($response);
	}


//   SECCION ====== PDF ======
	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de horarioticketmapi', 0, 1, 'C');
		$pdf->Output('horarioticketmapi.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

//   SECCION ====== EXCEL ======
	public function excel()
	{
		$total = $this->horarioticketmapi->getCount();

		$horarioticketmapi = $this->horarioticketmapi->getHorarioticketmapis($total, 1, 1, '');
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
		$sheet->getStyle('A1:K1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF92C5FC');
		$border = ['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000'], ], ], ];
		$sheet->setCellValue('A1', 'IDHORARIOTICKETMAPI');
		$sheet->setCellValue('B1', 'PRECIO');
		$sheet->setCellValue('C1', 'ESTADO');
		$sheet->setCellValue('D1', 'IDCLIENTETIPO');
		$sheet->setCellValue('E1', 'NOMBRE');
		$sheet->setCellValue('F1', 'IDHORATICKETMAPI');
		$sheet->setCellValue('G1', 'NOMBRE');
		$sheet->setCellValue('H1', 'IDTICKETMAPI');
		$sheet->setCellValue('I1', 'NOMBRE');
		$sheet->setCellValue('J1', 'CONCATENADO');
		$sheet->setCellValue('K1', 'CONCATENADODETALLE');
		$i=2;
		foreach ($horarioticketmapi as $row){
			$sheet->setCellValue('A'.$i, $row['idhorarioticketmapi']);
			$sheet->setCellValue('B'.$i, $row['precio']);
			$sheet->setCellValue('C'.$i, $row['estado']);
			$sheet->setCellValue('D'.$i, $row['idclientetipo']);
			$sheet->setCellValue('E'.$i, $row['nombre']);
			$sheet->setCellValue('F'.$i, $row['idhoraticketmapi']);
			$sheet->setCellValue('G'.$i, $row['nombre']);
			$sheet->setCellValue('H'.$i, $row['idticketmapi']);
			$sheet->setCellValue('I'.$i, $row['nombre']);
			$sheet->setCellValue('J'.$i, $row['concatenado']);
			$sheet->setCellValue('K'.$i, $row['concatenadodetalle']);
			$i++;
		}
		$sheet->getStyle('A1:K1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++){
			$sheet->getStyle('A'.$j.':K'.$j)->applyFromArray($border);
		}

		$writer = new Xls($spreadsheet);
		$filename = 'Lista_Horarioticketmapi.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit;
	}

}
