<?php namespace App\Controllers;

use App\Controllers\BaseController;
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


	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->ticketbus = new TicketbusModel();

	}

	public function index($bestado = 1)
	{
		$ticketbus = $this->ticketbus->getTicketbuss(1, '', 20, 1);
		$total = $this->ticketbus->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'ticketbus', 'pag' => $pag, 'datos' => $ticketbus];

		echo view('layouts/header');
		echo view('layouts/aside');
		echo view('ticketbus/list', $data);
		echo view('layouts/footer');

	}
	public function agregar(){
	
		$total = $this->ticketbus->getCount('', '');
		$pag = $this->paginado->pagina(1, $total, 1);
		print_r($pag);
	}

	public function opciones(){
		$accion = (isset($_GET['accion'])) ? $_GET['accion']:'leer';
		$pag = (int)(isset($_GET['pag'])) ? $_GET['pag']:1;

		$todos = $this->request->getPost('todos');
		$texto = strtoupper(trim($this->request->getPost('texto')));

		$nidticketbus = strtoupper(trim($this->request->getPost('idticketbus')));
		$snombre = strtoupper(trim($this->request->getPost('nombre')));
		$sdescripcion = strtoupper(trim($this->request->getPost('descripcion')));
		$dprecio = strtoupper(trim($this->request->getPost('precio')));
		$bestado = strtoupper(trim($this->request->getPost('estado')));


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion) {
			case 'agregar':
				$data  = array(
					'nidticketbus' => $nidticketbus,
					'snombre' => $snombre,
					'sdescripcion' => $sdescripcion,
					'dprecio' => doubleval($dprecio),
					'bestado' => intval($bestado),

				);
				if ($this->ticketbus->existe($nidticketbus) == 1) {
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
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->ticketbus->getticketbuss($todos, $texto, 20, $pag)];
		echo json_encode($respt);
	}

	public function edit(){ 
		$nidticketbus = strtoupper(trim($this->request->getPost('idticketbus')));

		$data = $this->ticketbus->getTicketbus($nidticketbus);
		echo json_encode($data);
	}


	public function getticketbussSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->ticketbus->getticketbussSelectNombre($searchTerm);
		echo json_encode($response);
	}


	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de ticketbus', 0, 1, 'C');
		$pdf->Output('ticketbus.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

	public function excel()
	{
		$total = $this->ticketbus->getCount();

		$ticketbus = $this->ticketbus->getTicketbuss(1, '', $total, 1);
		require_once ROOTPATH . 'vendor/autoload.php';
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->setActiveSheetIndex(0);
		$sheet->getColumnDimension('A')->setAutoSize(true);
		$sheet->getColumnDimension('B')->setAutoSize(true);
		$sheet->getColumnDimension('C')->setAutoSize(true);
		$sheet->getColumnDimension('D')->setAutoSize(true);
		$sheet->getStyle('A1:D1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF92C5FC');
		$border = ['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000'], ], ], ];
		$sheet->setCellValue('A1', 'NOMBRE');
		$sheet->setCellValue('B1', 'DESCRIPCION');
		$sheet->setCellValue('C1', 'PRECIO');
		$sheet->setCellValue('D1', 'ESTADO');
		$i=2;
		foreach ($ticketbus as $row) {
			$sheet->setCellValue('A'.$i, $row['nombre']);
			$sheet->setCellValue('B'.$i, $row['descripcion']);
			$sheet->setCellValue('C'.$i, $row['precio']);
			$sheet->setCellValue('D'.$i, $row['estado']);
			$i++;
		}
		$sheet->getStyle('A1:D1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++) {
			$sheet->getStyle('A'.$j.':D'.$j)->applyFromArray($border);
		}

		$writer = new Xls($spreadsheet);
		$filename = 'Lista_ticketbus.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit;
	}

}
