<?php namespace App\Controllers;
use App\Controllers\BaseController;
use DateTime;
use App\Models\PaginadoModel;
use App\Models\TicketbusModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;


class Ticketbus extends BaseController
{
	protected $paginado;
	protected $ticketbus;


//   SECCION ====== CONSTRUCT ======
	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->ticketbus = new TicketbusModel();

	}

//   SECCION ====== INDEX ======
	public function index($bestado = 1)
	{
		$ticketbus = $this->ticketbus->getTicketbuss(20, 1, 1, '');
		$total = $this->ticketbus->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'ticketbus', 'pag' => $pag, 'datos' => $ticketbus];
		$ticketbus = $this->ticketbus->getTicketbuss(10, 1, 1, '');

		echo view('layouts/header', []);
		echo view('layouts/aside');
		echo view('ticketbus/list', $data);
		echo view('layouts/footer');

	}
//   SECCION ====== AGREGAR ======
	public function agregar(){

		$total = $this->ticketbus->getCount('', '');
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
			$nidticketbus = strtoupper(trim($this->request->getPost('idticketbus')));
			$snombre = strtoupper(trim($this->request->getPost('nombre')));
			$sdescripcion = strtoupper(trim($this->request->getPost('descripcion')));
			$dprecio = strtoupper(trim($this->request->getPost('precio')));
			$bestado = strtoupper(trim($this->request->getPost('estado')));
		}


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion){
			case 'agregar':
				$data  = array(
					'nidticketbus' => $nidticketbus,
					'snombre' => $snombre,
					'sdescripcion' => $sdescripcion,
					'dprecio' => doubleval($dprecio),
					'bestado' => intval($bestado),

				);
				if ($this->ticketbus->existe($nidticketbus) == 1){
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->ticketbus->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'snombre' => $snombre,
					'sdescripcion' => $sdescripcion,
					'dprecio' => doubleval($dprecio),
					'bestado' => intval($bestado),

				);
				$this->ticketbus->UpdateTicketbus($nidticketbus, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->ticketbus->UpdateTicketbus($nidticketbus, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->ticketbus->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->ticketbus->getTicketbuss(20, $pag, $todos, $texto)];
		echo json_encode($respt);
	}

//   SECCION ====== EDIT ======
	public function edit(){
		$nidticketbus = strtoupper(trim($this->request->getPost('idticketbus')));

		$data = $this->ticketbus->getTicketbus($nidticketbus);
		echo json_encode($data);
	}


	public function autocompleteticketbuss()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->ticketbus->getAutocompleteticketbuss($todos,$keyword);
		echo json_encode($data);
	}
//   SECCION ====== Ticketbus SELECT NOMBRE ======
	public function getTicketbussSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->ticketbus->getTicketbussSelectNombre($searchTerm);
		echo json_encode($response);
	}


//   SECCION ====== PDF ======
	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de ticketbus', 0, 1, 'C');
		$pdf->Output('ticketbus.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

//   SECCION ====== EXCEL ======
	public function excel()
	{
		$total = $this->ticketbus->getCount();

		$ticketbus = $this->ticketbus->getTicketbuss($total, 1, 1, '');
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
		$sheet->getStyle('A1:G1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF92C5FC');
		$border = ['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000'], ], ], ];
		$sheet->setCellValue('A1', 'IDTICKETBUS');
		$sheet->setCellValue('B1', 'NOMBRE');
		$sheet->setCellValue('C1', 'DESCRIPCION');
		$sheet->setCellValue('D1', 'PRECIO');
		$sheet->setCellValue('E1', 'ESTADO');
		$sheet->setCellValue('F1', 'CONCATENADO');
		$sheet->setCellValue('G1', 'CONCATENADODETALLE');
		$i=2;
		foreach ($ticketbus as $row){
			$sheet->setCellValue('A'.$i, $row['idticketbus']);
			$sheet->setCellValue('B'.$i, $row['nombre']);
			$sheet->setCellValue('C'.$i, $row['descripcion']);
			$sheet->setCellValue('D'.$i, $row['precio']);
			$sheet->setCellValue('E'.$i, $row['estado']);
			$sheet->setCellValue('F'.$i, $row['concatenado']);
			$sheet->setCellValue('G'.$i, $row['concatenadodetalle']);
			$i++;
		}
		$sheet->getStyle('A1:G1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++){
			$sheet->getStyle('A'.$j.':G'.$j)->applyFromArray($border);
		}

		$writer = new Xls($spreadsheet);
		$filename = 'Lista_Ticketbus.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit;
	}

}
