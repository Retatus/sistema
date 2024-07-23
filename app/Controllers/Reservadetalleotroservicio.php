<?php namespace App\Controllers;
use App\Controllers\BaseController;
use DateTime;
use App\Models\PaginadoModel;
use App\Models\ReservadetalleotroservicioModel;
use App\Models\OtroservicioModel;
use App\Models\ReservaModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;


class Reservadetalleotroservicio extends BaseController
{
	protected $paginado;
	protected $reservadetalleotroservicio;
	protected $otroservicio;
	protected $reserva;


//   SECCION ====== CONSTRUCT ======
	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->reservadetalleotroservicio = new ReservadetalleotroservicioModel();
		$this->otroservicio = new OtroservicioModel();
		$this->reserva = new ReservaModel();

	}

//   SECCION ====== INDEX ======
	public function index($bestado = 1)
	{
		$reservadetalleotroservicio = $this->reservadetalleotroservicio->getReservadetalleotroservicios(20, 1, 1, '');
		$total = $this->reservadetalleotroservicio->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'reservadetalleotroservicio', 'pag' => $pag, 'datos' => $reservadetalleotroservicio];
		$reservadetalleotroservicio = $this->reservadetalleotroservicio->getReservadetalleotroservicios(10, 1, 1, '');
		$otroservicio = $this->otroservicio->getOtroservicios(10, 1, 1, '');
		$reserva = $this->reserva->getReservas(10, 1, 1, '');

		echo view('layouts/header', ['otroservicios' => $otroservicio, 'reservas' => $reserva]);
		echo view('layouts/aside');
		echo view('reservadetalleotroservicio/list', $data);
		echo view('layouts/footer');

	}
//   SECCION ====== AGREGAR ======
	public function agregar(){

		$total = $this->reservadetalleotroservicio->getCount('', '');
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
			$nidreserva = strtoupper(trim($this->request->getPost('idreserva')));
			$nidreservadetalleotroservicio = strtoupper(trim($this->request->getPost('idreservadetalleotroservicio')));
			$nidotroservicio = strtoupper(trim($this->request->getPost('idotroservicio')));
			$sdescripcion = strtoupper(trim($this->request->getPost('descripcion')));
			$tempdate = trim($this->request->getPost('fecha'));
			$tempdate = explode('/', $tempdate);
			$tfecha = date('Y-m-d', strtotime($tempdate[1].'/'.$tempdate[0].'/'.$tempdate[2]));
			$ncantidad = strtoupper(trim($this->request->getPost('cantidad')));
			$dprecio = strtoupper(trim($this->request->getPost('precio')));
			$dtotal = strtoupper(trim($this->request->getPost('total')));
			$bconfirmado = strtoupper(trim($this->request->getPost('confirmado')));
			$bestado = strtoupper(trim($this->request->getPost('estado')));
		}


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion){
			case 'agregar':
				$data  = array(
					'nidreserva' => intval($nidreserva),
					'nidreservadetalleotroservicio' => intval($nidreservadetalleotroservicio),
					'nidotroservicio' => intval($nidotroservicio),
					'sdescripcion' => $sdescripcion,
					'tfecha' => $tfecha,
					'ncantidad' => intval($ncantidad),
					'dprecio' => doubleval($dprecio),
					'dtotal' => doubleval($dtotal),
					'bconfirmado' => intval($bconfirmado),
					'bestado' => intval($bestado),

				);
				if ($this->reservadetalleotroservicio->existe($nidreserva, $nidreservadetalleotroservicio, $nidotroservicio) == 1){
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->reservadetalleotroservicio->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'nidreserva' => intval($nidreserva),
					'nidotroservicio' => intval($nidotroservicio),
					'sdescripcion' => $sdescripcion,
					'tfecha' => $tfecha,
					'ncantidad' => intval($ncantidad),
					'dprecio' => doubleval($dprecio),
					'dtotal' => doubleval($dtotal),
					'bconfirmado' => intval($bconfirmado),
					'bestado' => intval($bestado),

				);
				$this->reservadetalleotroservicio->UpdateReservadetalleotroservicio($nidreserva, $nidreservadetalleotroservicio, $nidotroservicio, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->reservadetalleotroservicio->UpdateReservadetalleotroservicio($nidreservadetalleotroservicio, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->reservadetalleotroservicio->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->reservadetalleotroservicio->getReservadetalleotroservicios(20, $pag, $todos, $texto)];
		echo json_encode($respt);
	}

//   SECCION ====== EDIT ======
	public function edit(){
		$nidreserva = strtoupper(trim($this->request->getPost('idreserva')));
		$nidreservadetalleotroservicio = strtoupper(trim($this->request->getPost('idreservadetalleotroservicio')));
		$nidotroservicio = strtoupper(trim($this->request->getPost('idotroservicio')));

		$data = $this->reservadetalleotroservicio->getReservadetalleotroservicio($nidreserva, $nidreservadetalleotroservicio, $nidotroservicio);
		echo json_encode($data);
	}


	public function autocompletereservadetalleotroservicios()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->reservadetalleotroservicio->getAutocompletereservadetalleotroservicios($todos,$keyword);
		echo json_encode($data);
	}
	public function autocompleteotroservicios()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->otroservicio->getAutocompleteotroservicios($todos,$keyword);
		echo json_encode($data);
	}
	public function autocompletereservas()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->reserva->getAutocompletereservas($todos,$keyword);
		echo json_encode($data);
	}
//   SECCION ====== Reservadetalleotroservicio SELECT NOMBRE ======
	public function getReservadetalleotroserviciosSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->reservadetalleotroservicio->getReservadetalleotroserviciosSelectNombre($searchTerm);
		echo json_encode($response);
	}


//   SECCION ====== PDF ======
	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de reservadetalleotroservicio', 0, 1, 'C');
		$pdf->Output('reservadetalleotroservicio.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

//   SECCION ====== EXCEL ======
	public function excel()
	{
		$total = $this->reservadetalleotroservicio->getCount();

		$reservadetalleotroservicio = $this->reservadetalleotroservicio->getReservadetalleotroservicios($total, 1, 1, '');
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
		$sheet->getStyle('A1:N1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF92C5FC');
		$border = ['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000'], ], ], ];
		$sheet->setCellValue('A1', 'IDRESERVADETALLEOTROSERVICIO');
		$sheet->setCellValue('B1', 'DESCRIPCION');
		$sheet->setCellValue('C1', 'FECHA');
		$sheet->setCellValue('D1', 'CANTIDAD');
		$sheet->setCellValue('E1', 'PRECIO');
		$sheet->setCellValue('F1', 'TOTAL');
		$sheet->setCellValue('G1', 'CONFIRMADO');
		$sheet->setCellValue('H1', 'ESTADO');
		$sheet->setCellValue('I1', 'IDOTROSERVICIO');
		$sheet->setCellValue('J1', 'OTROSERVICIONOMBRE');
		$sheet->setCellValue('K1', 'IDRESERVA');
		$sheet->setCellValue('L1', 'RESERVANOMBRE');
		$sheet->setCellValue('M1', 'CONCATENADO');
		$sheet->setCellValue('N1', 'CONCATENADODETALLE');
		$i=2;
		foreach ($reservadetalleotroservicio as $row){
			$sheet->setCellValue('A'.$i, $row['idreservadetalleotroservicio']);
			$sheet->setCellValue('B'.$i, $row['descripcion']);
			$sheet->setCellValue('C'.$i, $row['fecha']);
			$sheet->setCellValue('D'.$i, $row['cantidad']);
			$sheet->setCellValue('E'.$i, $row['precio']);
			$sheet->setCellValue('F'.$i, $row['total']);
			$sheet->setCellValue('G'.$i, $row['confirmado']);
			$sheet->setCellValue('H'.$i, $row['estado']);
			$sheet->setCellValue('I'.$i, $row['idotroservicio']);
			$sheet->setCellValue('J'.$i, $row['otroservicionombre']);
			$sheet->setCellValue('K'.$i, $row['idreserva']);
			$sheet->setCellValue('L'.$i, $row['reservanombre']);
			$sheet->setCellValue('M'.$i, $row['concatenado']);
			$sheet->setCellValue('N'.$i, $row['concatenadodetalle']);
			$i++;
		}
		$sheet->getStyle('A1:N1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++){
			$sheet->getStyle('A'.$j.':N'.$j)->applyFromArray($border);
		}

		$writer = new Xls($spreadsheet);
		$filename = 'Lista_Reservadetalleotroservicio.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit;
	}

}
