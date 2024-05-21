<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PaginadoModel;
use App\Models\ReservadetallehorarioticketmapiModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use App\Models\HorarioticketmapiModel;
use App\Models\ReservaModel;


class Reservadetallehorarioticketmapi extends BaseController
{
	protected $paginado;
	protected $reservadetallehorarioticketmapi;
	protected $horarioticketmapi;
	protected $reserva;


	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->reservadetallehorarioticketmapi = new ReservadetallehorarioticketmapiModel();
		$this->horarioticketmapi = new HorarioticketmapiModel();
		$this->reserva = new ReservaModel();

	}

	public function index($bestado = 1)
	{
		$reservadetallehorarioticketmapi = $this->reservadetallehorarioticketmapi->getReservadetallehorarioticketmapis(1, '', 20, 1);
		$total = $this->reservadetallehorarioticketmapi->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'reservadetallehorarioticketmapi', 'pag' => $pag, 'datos' => $reservadetallehorarioticketmapi];
		$horarioticketmapi = $this->horarioticketmapi->getHorarioticketmapis(1, '', 10, 1);
		$reserva = $this->reserva->getReservas(1, '', 10, 1);

		echo view('layouts/header', ['horarioticketmapis' => $horarioticketmapi, 'reservas' => $reserva]);
		echo view('layouts/aside');
		echo view('reservadetallehorarioticketmapi/list', $data);
		echo view('layouts/footer');

	}
	public function agregar(){
	
		$total = $this->reservadetallehorarioticketmapi->getCount('', '');
		$pag = $this->paginado->pagina(1, $total, 1);
		print_r($pag);
	}

	public function opciones(){
		$accion = (isset($_GET['accion'])) ? $_GET['accion']:'leer';
		$pag = (int)(isset($_GET['pag'])) ? $_GET['pag']:1;

		$todos = $this->request->getPost('todos');
		$texto = strtoupper(trim($this->request->getPost('texto')));

		$nidreserva = strtoupper(trim($this->request->getPost('idreserva')));
		$nidreservadetallehorarioticketmapi = strtoupper(trim($this->request->getPost('idreservadetallehorarioticketmapi')));
		$nidhorarioticketmapi = strtoupper(trim($this->request->getPost('idhorarioticketmapi')));
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
					'nidreservadetallehorarioticketmapi' => intval($nidreservadetallehorarioticketmapi),
					'nidhorarioticketmapi' => $nidhorarioticketmapi,
					'sdescripcion' => $sdescripcion,
					'tfecha' => $tfecha,
					'ncantidad' => intval($ncantidad),
					'dprecio' => doubleval($dprecio),
					'dtotal' => doubleval($dtotal),
					'bconfirmado' => intval($bconfirmado),
					'bestado' => intval($bestado),

				);
				if ($this->reservadetallehorarioticketmapi->existe($nidreservadetallehorarioticketmapi,$nidhorarioticketmapi,$nidreserva) == 1) {
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->reservadetallehorarioticketmapi->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'nidreserva' => intval($nidreserva),
					'nidhorarioticketmapi' => $nidhorarioticketmapi,
					'sdescripcion' => $sdescripcion,
					'tfecha' => $tfecha,
					'ncantidad' => intval($ncantidad),
					'dprecio' => doubleval($dprecio),
					'dtotal' => doubleval($dtotal),
					'bconfirmado' => intval($bconfirmado),
					'bestado' => intval($bestado),

				);
				$this->reservadetallehorarioticketmapi->UpdateReservadetallehorarioticketmapi($nidreservadetallehorarioticketmapi,$nidhorarioticketmapi,$nidreserva, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->reservadetallehorarioticketmapi->UpdateReservadetallehorarioticketmapi($nidreserva, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->reservadetallehorarioticketmapi->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->reservadetallehorarioticketmapi->getreservadetallehorarioticketmapis($todos, $texto, 20, $pag)];
		echo json_encode($respt);
	}

	public function edit(){ 
		$nidreserva = strtoupper(trim($this->request->getPost('idreserva')));
		$nidreservadetallehorarioticketmapi = strtoupper(trim($this->request->getPost('idreservadetallehorarioticketmapi')));
		$nidhorarioticketmapi = strtoupper(trim($this->request->getPost('idhorarioticketmapi')));

		$data = $this->reservadetallehorarioticketmapi->getReservadetallehorarioticketmapi($nidreservadetallehorarioticketmapi,$nidhorarioticketmapi,$nidreserva);
		echo json_encode($data);
	}

	public function autocompletehorarioticketmapis()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->horarioticketmapi->getAutocompletehorarioticketmapis($todos,$keyword);
		echo json_encode($data);
	}
	public function autocompletereservas()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->reserva->getAutocompletereservas($todos,$keyword);
		echo json_encode($data);
	}

	public function getreservadetallehorarioticketmapisSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->reservadetallehorarioticketmapi->getreservadetallehorarioticketmapisSelectNombre($searchTerm);
		echo json_encode($response);
	}


	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de reservadetallehorarioticketmapi', 0, 1, 'C');
		$pdf->Output('reservadetallehorarioticketmapi.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

	public function excel()
	{
		$total = $this->reservadetallehorarioticketmapi->getCount();

		$reservadetallehorarioticketmapi = $this->reservadetallehorarioticketmapi->getReservadetallehorarioticketmapis(1, '', $total, 1);
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
		$sheet->getStyle('A1:M1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF92C5FC');
		$border = ['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000'], ], ], ];
		$sheet->setCellValue('A1', 'RESERVANOMBRE');
		$sheet->setCellValue('B1', 'IDRESERVA');
		$sheet->setCellValue('C1', 'CLIENTETIPO');
		$sheet->setCellValue('D1', 'HORATICKETMAPI');
		$sheet->setCellValue('E1', 'TICKETMAPI');
		$sheet->setCellValue('F1', 'IDHORARIOTICKETMAPI');
		$sheet->setCellValue('G1', 'DESCRIPCION');
		$sheet->setCellValue('H1', 'FECHA');
		$sheet->setCellValue('I1', 'CANTIDAD');
		$sheet->setCellValue('J1', 'PRECIO');
		$sheet->setCellValue('K1', 'TOTAL');
		$sheet->setCellValue('L1', 'CONFIRMADO');
		$sheet->setCellValue('M1', 'ESTADO');
		$i=2;
		foreach ($reservadetallehorarioticketmapi as $row) {
			$sheet->setCellValue('A'.$i, $row['reservanombre']);
			$sheet->setCellValue('B'.$i, $row['idreserva']);
			$sheet->setCellValue('C'.$i, $row['clientetipo']);
			$sheet->setCellValue('D'.$i, $row['horaticketmapi']);
			$sheet->setCellValue('E'.$i, $row['ticketmapi']);
			$sheet->setCellValue('F'.$i, $row['idhorarioticketmapi']);
			$sheet->setCellValue('G'.$i, $row['descripcion']);
			$sheet->setCellValue('H'.$i, $row['fecha']);
			$sheet->setCellValue('I'.$i, $row['cantidad']);
			$sheet->setCellValue('J'.$i, $row['precio']);
			$sheet->setCellValue('K'.$i, $row['total']);
			$sheet->setCellValue('L'.$i, $row['confirmado']);
			$sheet->setCellValue('M'.$i, $row['estado']);
			$i++;
		}
		$sheet->getStyle('A1:M1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++) {
			$sheet->getStyle('A'.$j.':M'.$j)->applyFromArray($border);
		}

		$writer = new Xls($spreadsheet);
		$filename = 'Lista_reservadetallehorarioticketmapi.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit;
	}

}
