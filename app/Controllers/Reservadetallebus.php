<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PaginadoModel;
use App\Models\ReservadetallebusModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use App\Models\ReservaModel;
use App\Models\TicketbusModel;


class Reservadetallebus extends BaseController
{
	protected $paginado;
	protected $reservadetallebus;
	protected $reserva;
	protected $ticketbus;


	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->reservadetallebus = new ReservadetallebusModel();
		$this->reserva = new ReservaModel();
		$this->ticketbus = new TicketbusModel();

	}

	public function index($bestado = 1)
	{
		$reservadetallebus = $this->reservadetallebus->getReservadetallebuss(1, '', 20, 1);
		$total = $this->reservadetallebus->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'reservadetallebus', 'pag' => $pag, 'datos' => $reservadetallebus];
		$reserva = $this->reserva->getReservas(1, '', 10, 1);
		$ticketbus = $this->ticketbus->getTicketbuss(1, '', 10, 1);

		echo view('layouts/header', ['reservas' => $reserva, 'ticketbuss' => $ticketbus]);
		echo view('layouts/aside');
		echo view('reservadetallebus/list', $data);
		echo view('layouts/footer');

	}
	public function agregar(){
	
		$total = $this->reservadetallebus->getCount('', '');
		$pag = $this->paginado->pagina(1, $total, 1);
		print_r($pag);
	}

	public function opciones(){
		$accion = (isset($_GET['accion'])) ? $_GET['accion']:'leer';
		$pag = (int)(isset($_GET['pag'])) ? $_GET['pag']:1;

		$todos = $this->request->getPost('todos');
		$texto = strtoupper(trim($this->request->getPost('texto')));

		$nidreserva = strtoupper(trim($this->request->getPost('idreserva')));
		$nidreservadetalleticketbus = strtoupper(trim($this->request->getPost('idreservadetalleticketbus')));
		$nidticketbus = strtoupper(trim($this->request->getPost('idticketbus')));
		$sdescripcion = strtoupper(trim($this->request->getPost('descripcion')));
		$tempdate = trim($this->request->getPost('fecha'));
		$tempdate = explode('/', $tempdate);
		$tfecha = date('Y-m-d', strtotime($tempdate[1].'/'.$tempdate[0].'/'.$tempdate[2]));
		$ncantidad = strtoupper(trim($this->request->getPost('cantidad')));
		$dprecio = strtoupper(trim($this->request->getPost('precio')));
		$dtotal = strtoupper(trim($this->request->getPost('total')));
		$bconfirmado = strtoupper(trim($this->request->getPost('confirmado')));
		$bestado = strtoupper(trim($this->request->getPost('estado')));


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion) {
			case 'agregar':
				$data  = array(
					'nidreserva' => intval($nidreserva),
					'nidreservadetalleticketbus' => intval($nidreservadetalleticketbus),
					'nidticketbus' => $nidticketbus,
					'sdescripcion' => $sdescripcion,
					'tfecha' => $tfecha,
					'ncantidad' => intval($ncantidad),
					'dprecio' => doubleval($dprecio),
					'dtotal' => doubleval($dtotal),
					'bconfirmado' => intval($bconfirmado),
					'bestado' => intval($bestado),

				);
				if ($this->reservadetallebus->existe($nidreservadetalleticketbus,$nidreserva,$nidticketbus) == 1) {
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->reservadetallebus->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'nidreserva' => intval($nidreserva),
					'nidticketbus' => $nidticketbus,
					'sdescripcion' => $sdescripcion,
					'tfecha' => $tfecha,
					'ncantidad' => intval($ncantidad),
					'dprecio' => doubleval($dprecio),
					'dtotal' => doubleval($dtotal),
					'bconfirmado' => intval($bconfirmado),
					'bestado' => intval($bestado),

				);
				$this->reservadetallebus->UpdateReservadetallebus($nidreservadetalleticketbus,$nidreserva,$nidticketbus, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->reservadetallebus->UpdateReservadetallebus($nidreserva, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->reservadetallebus->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->reservadetallebus->getreservadetallebuss($todos, $texto, 20, $pag)];
		echo json_encode($respt);
	}

	public function edit(){ 
		$nidreserva = strtoupper(trim($this->request->getPost('idreserva')));
		$nidreservadetalleticketbus = strtoupper(trim($this->request->getPost('idreservadetalleticketbus')));
		$nidticketbus = strtoupper(trim($this->request->getPost('idticketbus')));

		$data = $this->reservadetallebus->getReservadetallebus($nidreservadetalleticketbus,$nidreserva,$nidticketbus);
		echo json_encode($data);
	}

	public function autocompletereservas()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->reserva->getAutocompletereservas($todos,$keyword);
		echo json_encode($data);
	}
	public function autocompleteticketbuss()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->ticketbus->getAutocompleteticketbuss($todos,$keyword);
		echo json_encode($data);
	}

	public function getreservadetallebussSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->reservadetallebus->getreservadetallebussSelectNombre($searchTerm);
		echo json_encode($response);
	}


	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de reservadetallebus', 0, 1, 'C');
		$pdf->Output('reservadetallebus.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

	public function excel()
	{
		$total = $this->reservadetallebus->getCount();

		$reservadetallebus = $this->reservadetallebus->getReservadetallebuss(1, '', $total, 1);
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
		$sheet->setCellValue('A1', 'RESERVANOMBRE');
		$sheet->setCellValue('B1', 'IDRESERVA');
		$sheet->setCellValue('C1', 'NOMBRE');
		$sheet->setCellValue('D1', 'IDTICKETBUS');
		$sheet->setCellValue('E1', 'DESCRIPCION');
		$sheet->setCellValue('F1', 'FECHA');
		$sheet->setCellValue('G1', 'CANTIDAD');
		$sheet->setCellValue('H1', 'PRECIO');
		$sheet->setCellValue('I1', 'TOTAL');
		$sheet->setCellValue('J1', 'CONFIRMADO');
		$sheet->setCellValue('K1', 'ESTADO');
		$i=2;
		foreach ($reservadetallebus as $row) {
			$sheet->setCellValue('A'.$i, $row['reservanombre']);
			$sheet->setCellValue('B'.$i, $row['idreserva']);
			$sheet->setCellValue('C'.$i, $row['nombre']);
			$sheet->setCellValue('D'.$i, $row['idticketbus']);
			$sheet->setCellValue('E'.$i, $row['descripcion']);
			$sheet->setCellValue('F'.$i, $row['fecha']);
			$sheet->setCellValue('G'.$i, $row['cantidad']);
			$sheet->setCellValue('H'.$i, $row['precio']);
			$sheet->setCellValue('I'.$i, $row['total']);
			$sheet->setCellValue('J'.$i, $row['confirmado']);
			$sheet->setCellValue('K'.$i, $row['estado']);
			$i++;
		}
		$sheet->getStyle('A1:K1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++) {
			$sheet->getStyle('A'.$j.':K'.$j)->applyFromArray($border);
		}

		$writer = new Xls($spreadsheet);
		$filename = 'Lista_reservadetallebus.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit;
	}

}
