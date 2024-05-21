<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PaginadoModel;
use App\Models\ReservadetallehorariotrenModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use App\Models\HorariotrenModel;
use App\Models\ReservaModel;


class Reservadetallehorariotren extends BaseController
{
	protected $paginado;
	protected $reservadetallehorariotren;
	protected $horariotren;
	protected $reserva;


	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->reservadetallehorariotren = new ReservadetallehorariotrenModel();
		$this->horariotren = new HorariotrenModel();
		$this->reserva = new ReservaModel();

	}

	public function index($bestado = 1)
	{
		$reservadetallehorariotren = $this->reservadetallehorariotren->getReservadetallehorariotrens(1, '', 20, 1);
		$total = $this->reservadetallehorariotren->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'reservadetallehorariotren', 'pag' => $pag, 'datos' => $reservadetallehorariotren];
		$horariotren = $this->horariotren->getHorariotrens(1, '', 10, 1);
		$reserva = $this->reserva->getReservas(1, '', 10, 1);

		echo view('layouts/header', ['horariotrens' => $horariotren, 'reservas' => $reserva]);
		echo view('layouts/aside');
		echo view('reservadetallehorariotren/list', $data);
		echo view('layouts/footer');

	}
	public function agregar(){
	
		$total = $this->reservadetallehorariotren->getCount('', '');
		$pag = $this->paginado->pagina(1, $total, 1);
		print_r($pag);
	}

	public function opciones(){
		$accion = (isset($_GET['accion'])) ? $_GET['accion']:'leer';
		$pag = (int)(isset($_GET['pag'])) ? $_GET['pag']:1;

		$todos = $this->request->getPost('todos');
		$texto = strtoupper(trim($this->request->getPost('texto')));

		$nidreserva = strtoupper(trim($this->request->getPost('idreserva')));
		$nidreservadetallehorariotren = strtoupper(trim($this->request->getPost('idreservadetallehorariotren')));
		$nidhorariotren = strtoupper(trim($this->request->getPost('idhorariotren')));
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
					'nidreservadetallehorariotren' => intval($nidreservadetallehorariotren),
					'nidhorariotren' => $nidhorariotren,
					'sdescripcion' => $sdescripcion,
					'tfecha' => $tfecha,
					'ncantidad' => intval($ncantidad),
					'dprecio' => doubleval($dprecio),
					'dtotal' => doubleval($dtotal),
					'bconfirmado' => intval($bconfirmado),
					'bestado' => intval($bestado),

				);
				if ($this->reservadetallehorariotren->existe($nidreservadetallehorariotren,$nidhorariotren,$nidreserva) == 1) {
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->reservadetallehorariotren->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'nidreserva' => intval($nidreserva),
					'nidhorariotren' => $nidhorariotren,
					'sdescripcion' => $sdescripcion,
					'tfecha' => $tfecha,
					'ncantidad' => intval($ncantidad),
					'dprecio' => doubleval($dprecio),
					'dtotal' => doubleval($dtotal),
					'bconfirmado' => intval($bconfirmado),
					'bestado' => intval($bestado),

				);
				$this->reservadetallehorariotren->UpdateReservadetallehorariotren($nidreservadetallehorariotren,$nidhorariotren,$nidreserva, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->reservadetallehorariotren->UpdateReservadetallehorariotren($nidreserva, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->reservadetallehorariotren->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->reservadetallehorariotren->getreservadetallehorariotrens($todos, $texto, 20, $pag)];
		echo json_encode($respt);
	}

	public function edit(){ 
		$nidreserva = strtoupper(trim($this->request->getPost('idreserva')));
		$nidreservadetallehorariotren = strtoupper(trim($this->request->getPost('idreservadetallehorariotren')));
		$nidhorariotren = strtoupper(trim($this->request->getPost('idhorariotren')));

		$data = $this->reservadetallehorariotren->getReservadetallehorariotren($nidreservadetallehorariotren,$nidhorariotren,$nidreserva);
		echo json_encode($data);
	}

	public function autocompletehorariotrens()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->horariotren->getAutocompletehorariotrens($todos,$keyword);
		echo json_encode($data);
	}
	public function autocompletereservas()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->reserva->getAutocompletereservas($todos,$keyword);
		echo json_encode($data);
	}

	public function getreservadetallehorariotrensSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->reservadetallehorariotren->getreservadetallehorariotrensSelectNombre($searchTerm);
		echo json_encode($response);
	}


	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de reservadetallehorariotren', 0, 1, 'C');
		$pdf->Output('reservadetallehorariotren.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

	public function excel()
	{
		$total = $this->reservadetallehorariotren->getCount();

		$reservadetallehorariotren = $this->reservadetallehorariotren->getReservadetallehorariotrens(1, '', $total, 1);
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
		$sheet->getStyle('A1:L1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF92C5FC');
		$border = ['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000'], ], ], ];
		$sheet->setCellValue('A1', 'RESERVANOMBRE');
		$sheet->setCellValue('B1', 'IDRESERVA');
		$sheet->setCellValue('C1', 'HORATREN');
		$sheet->setCellValue('D1', 'TREN');
		$sheet->setCellValue('E1', 'IDHORARIOTREN');
		$sheet->setCellValue('F1', 'DESCRIPCION');
		$sheet->setCellValue('G1', 'FECHA');
		$sheet->setCellValue('H1', 'CANTIDAD');
		$sheet->setCellValue('I1', 'PRECIO');
		$sheet->setCellValue('J1', 'TOTAL');
		$sheet->setCellValue('K1', 'CONFIRMADO');
		$sheet->setCellValue('L1', 'ESTADO');
		$i=2;
		foreach ($reservadetallehorariotren as $row) {
			$sheet->setCellValue('A'.$i, $row['reservanombre']);
			$sheet->setCellValue('B'.$i, $row['idreserva']);
			$sheet->setCellValue('C'.$i, $row['horatren']);
			$sheet->setCellValue('D'.$i, $row['tren']);
			$sheet->setCellValue('E'.$i, $row['idhorariotren']);
			$sheet->setCellValue('F'.$i, $row['descripcion']);
			$sheet->setCellValue('G'.$i, $row['fecha']);
			$sheet->setCellValue('H'.$i, $row['cantidad']);
			$sheet->setCellValue('I'.$i, $row['precio']);
			$sheet->setCellValue('J'.$i, $row['total']);
			$sheet->setCellValue('K'.$i, $row['confirmado']);
			$sheet->setCellValue('L'.$i, $row['estado']);
			$i++;
		}
		$sheet->getStyle('A1:L1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++) {
			$sheet->getStyle('A'.$j.':L'.$j)->applyFromArray($border);
		}

		$writer = new Xls($spreadsheet);
		$filename = 'Lista_reservadetallehorariotren.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit;
	}

}
