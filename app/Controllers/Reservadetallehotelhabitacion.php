<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PaginadoModel;
use App\Models\ReservadetallehotelhabitacionModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use App\Models\HotelhabitacionModel;
use App\Models\ReservaModel;


class Reservadetallehotelhabitacion extends BaseController
{
	protected $paginado;
	protected $reservadetallehotelhabitacion;
	protected $hotelhabitacion;
	protected $reserva;


	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->reservadetallehotelhabitacion = new ReservadetallehotelhabitacionModel();
		$this->hotelhabitacion = new HotelhabitacionModel();
		$this->reserva = new ReservaModel();

	}

	public function index($bestado = 1)
	{
		$reservadetallehotelhabitacion = $this->reservadetallehotelhabitacion->getReservadetallehotelhabitacions(1, '', 20, 1);
		$total = $this->reservadetallehotelhabitacion->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'reservadetallehotelhabitacion', 'pag' => $pag, 'datos' => $reservadetallehotelhabitacion];
		$hotelhabitacion = $this->hotelhabitacion->getHotelhabitacions(1, '', 10, 1);
		$reserva = $this->reserva->getReservas(1, '', 10, 1);

		echo view('layouts/header', ['hotelhabitacions' => $hotelhabitacion, 'reservas' => $reserva]);
		echo view('layouts/aside');
		echo view('reservadetallehotelhabitacion/list', $data);
		echo view('layouts/footer');

	}
	public function agregar(){
	
		$total = $this->reservadetallehotelhabitacion->getCount('', '');
		$pag = $this->paginado->pagina(1, $total, 1);
		print_r($pag);
	}

	public function opciones(){
		$accion = (isset($_GET['accion'])) ? $_GET['accion']:'leer';
		$pag = (int)(isset($_GET['pag'])) ? $_GET['pag']:1;

		$todos = $this->request->getPost('todos');
		$texto = strtoupper(trim($this->request->getPost('texto')));

		$nidreserva = strtoupper(trim($this->request->getPost('idreserva')));
		$nidreservadetallehotelhabitacion = strtoupper(trim($this->request->getPost('idreservadetallehotelhabitacion')));
		$nidhotelhabitacion = strtoupper(trim($this->request->getPost('idhotelhabitacion')));
		$sdescripcion = strtoupper(trim($this->request->getPost('descripcion')));
		$tempdate = trim($this->request->getPost('fechaingreso'));
		$tempdate = explode('/', $tempdate);
		$tfechaingreso = date('Y-m-d', strtotime($tempdate[1].'/'.$tempdate[0].'/'.$tempdate[2]));
		$tempdate = trim($this->request->getPost('fechasalida'));
		$tempdate = explode('/', $tempdate);
		$tfechasalida = date('Y-m-d', strtotime($tempdate[1].'/'.$tempdate[0].'/'.$tempdate[2]));
		$nadultos = strtoupper(trim($this->request->getPost('adultos')));
		$nninios = strtoupper(trim($this->request->getPost('ninios')));
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
					'nidreservadetallehotelhabitacion' => intval($nidreservadetallehotelhabitacion),
					'nidhotelhabitacion' => $nidhotelhabitacion,
					'sdescripcion' => $sdescripcion,
					'tfechaingreso' => $tfechaingreso,
					'tfechasalida' => $tfechasalida,
					'nadultos' => intval($nadultos),
					'nninios' => intval($nninios),
					'ncantidad' => intval($ncantidad),
					'dprecio' => doubleval($dprecio),
					'dtotal' => doubleval($dtotal),
					'bconfirmado' => intval($bconfirmado),
					'bestado' => intval($bestado),

				);
				if ($this->reservadetallehotelhabitacion->existe($nidreservadetallehotelhabitacion,$nidhotelhabitacion,$nidreserva) == 1) {
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->reservadetallehotelhabitacion->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'nidreserva' => intval($nidreserva),
					'nidhotelhabitacion' => $nidhotelhabitacion,
					'sdescripcion' => $sdescripcion,
					'tfechaingreso' => $tfechaingreso,
					'tfechasalida' => $tfechasalida,
					'nadultos' => intval($nadultos),
					'nninios' => intval($nninios),
					'ncantidad' => intval($ncantidad),
					'dprecio' => doubleval($dprecio),
					'dtotal' => doubleval($dtotal),
					'bconfirmado' => intval($bconfirmado),
					'bestado' => intval($bestado),

				);
				$this->reservadetallehotelhabitacion->UpdateReservadetallehotelhabitacion($nidreservadetallehotelhabitacion,$nidhotelhabitacion,$nidreserva, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->reservadetallehotelhabitacion->UpdateReservadetallehotelhabitacion($nidreserva, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->reservadetallehotelhabitacion->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->reservadetallehotelhabitacion->getreservadetallehotelhabitacions($todos, $texto, 20, $pag)];
		echo json_encode($respt);
	}

	public function edit(){ 
		$nidreserva = strtoupper(trim($this->request->getPost('idreserva')));
		$nidreservadetallehotelhabitacion = strtoupper(trim($this->request->getPost('idreservadetallehotelhabitacion')));
		$nidhotelhabitacion = strtoupper(trim($this->request->getPost('idhotelhabitacion')));

		$data = $this->reservadetallehotelhabitacion->getReservadetallehotelhabitacion($nidreservadetallehotelhabitacion,$nidhotelhabitacion,$nidreserva);
		echo json_encode($data);
	}

	public function autocompletehotelhabitacions()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->hotelhabitacion->getAutocompletehotelhabitacions($todos,$keyword);
		echo json_encode($data);
	}
	public function autocompletereservas()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->reserva->getAutocompletereservas($todos,$keyword);
		echo json_encode($data);
	}

	public function getreservadetallehotelhabitacionsSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->reservadetallehotelhabitacion->getreservadetallehotelhabitacionsSelectNombre($searchTerm);
		echo json_encode($response);
	}


	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de reservadetallehotelhabitacion', 0, 1, 'C');
		$pdf->Output('reservadetallehotelhabitacion.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

	public function excel()
	{
		$total = $this->reservadetallehotelhabitacion->getCount();

		$reservadetallehotelhabitacion = $this->reservadetallehotelhabitacion->getReservadetallehotelhabitacions(1, '', $total, 1);
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
		$sheet->getStyle('A1:O1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF92C5FC');
		$border = ['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000'], ], ], ];
		$sheet->setCellValue('A1', 'RESERVANOMBRE');
		$sheet->setCellValue('B1', 'IDRESERVA');
		$sheet->setCellValue('C1', 'CATHABITACION');
		$sheet->setCellValue('D1', 'HOTEL');
		$sheet->setCellValue('E1', 'IDHOTELHABITACION');
		$sheet->setCellValue('F1', 'DESCRIPCION');
		$sheet->setCellValue('G1', 'FECHAINGRESO');
		$sheet->setCellValue('H1', 'FECHASALIDA');
		$sheet->setCellValue('I1', 'ADULTOS');
		$sheet->setCellValue('J1', 'NINIOS');
		$sheet->setCellValue('K1', 'CANTIDAD');
		$sheet->setCellValue('L1', 'PRECIO');
		$sheet->setCellValue('M1', 'TOTAL');
		$sheet->setCellValue('N1', 'CONFIRMADO');
		$sheet->setCellValue('O1', 'ESTADO');
		$i=2;
		foreach ($reservadetallehotelhabitacion as $row) {
			$sheet->setCellValue('A'.$i, $row['reservanombre']);
			$sheet->setCellValue('B'.$i, $row['idreserva']);
			$sheet->setCellValue('C'.$i, $row['cathabitacion']);
			$sheet->setCellValue('D'.$i, $row['hotel']);
			$sheet->setCellValue('E'.$i, $row['idhotelhabitacion']);
			$sheet->setCellValue('F'.$i, $row['descripcion']);
			$sheet->setCellValue('G'.$i, $row['fechaingreso']);
			$sheet->setCellValue('H'.$i, $row['fechasalida']);
			$sheet->setCellValue('I'.$i, $row['adultos']);
			$sheet->setCellValue('J'.$i, $row['ninios']);
			$sheet->setCellValue('K'.$i, $row['cantidad']);
			$sheet->setCellValue('L'.$i, $row['precio']);
			$sheet->setCellValue('M'.$i, $row['total']);
			$sheet->setCellValue('N'.$i, $row['confirmado']);
			$sheet->setCellValue('O'.$i, $row['estado']);
			$i++;
		}
		$sheet->getStyle('A1:O1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++) {
			$sheet->getStyle('A'.$j.':O'.$j)->applyFromArray($border);
		}

		$writer = new Xls($spreadsheet);
		$filename = 'Lista_reservadetallehotelhabitacion.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit;
	}

}
