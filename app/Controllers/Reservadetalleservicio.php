<?php namespace App\Controllers;
use App\Controllers\BaseController;
use DateTime;
use App\Models\PaginadoModel;
use App\Models\ReservadetalleservicioModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;


class Reservadetalleservicio extends BaseController
{
	protected $paginado;
	protected $reservadetalleservicio;


//   SECCION ====== CONSTRUCT ======
	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->reservadetalleservicio = new ReservadetalleservicioModel();

	}

//   SECCION ====== INDEX ======
	public function index($bestado = 1)
	{
		$reservadetalleservicio = $this->reservadetalleservicio->getReservadetalleservicios(20, 1, 1, '');
		$total = $this->reservadetalleservicio->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'reservadetalleservicio', 'pag' => $pag, 'datos' => $reservadetalleservicio];
		$reservadetalleservicio = $this->reservadetalleservicio->getReservadetalleservicios(10, 1, 1, '');

		echo view('layouts/header', []);
		echo view('layouts/aside');
		echo view('reservadetalleservicio/list', $data);
		echo view('layouts/footer');

	}
//   SECCION ====== AGREGAR ======
	public function agregar(){

		$total = $this->reservadetalleservicio->getCount('', '');
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
			$nidreservadetalleservicio = strtoupper(trim($this->request->getPost('idreservadetalleservicio')));
			$sdescripcion = strtoupper(trim($this->request->getPost('descripcion')));
			$tempdate = trim($this->request->getPost('fecha'));
			$tempdate = explode('/', $tempdate);
			$tfecha = date('Y-m-d', strtotime($tempdate[1].'/'.$tempdate[0].'/'.$tempdate[2]));
			$dcantidad = strtoupper(trim($this->request->getPost('cantidad')));
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
					'nidreservadetalleservicio' => intval($nidreservadetalleservicio),
					'sdescripcion' => $sdescripcion,
					'tfecha' => $tfecha,
					'dcantidad' => intval($dcantidad),
					'dprecio' => doubleval($dprecio),
					'dtotal' => doubleval($dtotal),
					'bconfirmado' => $bconfirmado,
					'bestado' => $bestado,

				);
				if ($this->reservadetalleservicio->existe($nidreservadetalleservicio) == 1){
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->reservadetalleservicio->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'nidreserva' => intval($nidreserva),
					'sdescripcion' => $sdescripcion,
					'tfecha' => $tfecha,
					'dcantidad' => intval($dcantidad),
					'dprecio' => doubleval($dprecio),
					'dtotal' => doubleval($dtotal),
					'bconfirmado' => $bconfirmado,
					'bestado' => $bestado,

				);
				$this->reservadetalleservicio->UpdateReservadetalleservicio($nidreservadetalleservicio, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->reservadetalleservicio->UpdateReservadetalleservicio($nidreservadetalleservicio, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->reservadetalleservicio->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->reservadetalleservicio->getReservadetalleservicios(20, $pag, $todos, $texto)];
		echo json_encode($respt);
	}

//   SECCION ====== EDIT ======
	public function edit(){
		$nidreservadetalleservicio = strtoupper(trim($this->request->getPost('idreservadetalleservicio')));

		$data = $this->reservadetalleservicio->getReservadetalleservicio($nidreservadetalleservicio);
		echo json_encode($data);
	}


	public function autocompletereservadetalleservicios()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->reservadetalleservicio->getAutocompletereservadetalleservicios($todos,$keyword);
		echo json_encode($data);
	}
//   SECCION ====== Reservadetalleservicio SELECT NOMBRE ======
	public function getReservadetalleserviciosSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->reservadetalleservicio->getReservadetalleserviciosSelectNombre($searchTerm);
		echo json_encode($response);
	}


//   SECCION ====== PDF ======
	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de reservadetalleservicio', 0, 1, 'C');
		$pdf->Output('reservadetalleservicio.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

//   SECCION ====== EXCEL ======
	public function excel()
	{
		$total = $this->reservadetalleservicio->getCount();

		$reservadetalleservicio = $this->reservadetalleservicio->getReservadetalleservicios($total, 1, 1, '');
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
		$sheet->getStyle('A1:J1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF92C5FC');
		$border = ['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000'], ], ], ];
		$sheet->setCellValue('A1', 'IDRESERVA');
		$sheet->setCellValue('B1', 'IDRESERVADETALLESERVICIO');
		$sheet->setCellValue('C1', 'DESCRIPCION');
		$sheet->setCellValue('D1', 'FECHA');
		$sheet->setCellValue('E1', 'CANTIDAD');
		$sheet->setCellValue('F1', 'PRECIO');
		$sheet->setCellValue('G1', 'TOTAL');
		$sheet->setCellValue('H1', 'CONFIRMADO');
		$sheet->setCellValue('I1', 'ESTADO');
		$sheet->setCellValue('J1', 'CONCATENADO');
		$i=2;
		foreach ($reservadetalleservicio as $row){
			$sheet->setCellValue('A'.$i, $row['idreserva']);
			$sheet->setCellValue('B'.$i, $row['idreservadetalleservicio']);
			$sheet->setCellValue('C'.$i, $row['descripcion']);
			$sheet->setCellValue('D'.$i, $row['fecha']);
			$sheet->setCellValue('E'.$i, $row['cantidad']);
			$sheet->setCellValue('F'.$i, $row['precio']);
			$sheet->setCellValue('G'.$i, $row['total']);
			$sheet->setCellValue('H'.$i, $row['confirmado']);
			$sheet->setCellValue('I'.$i, $row['estado']);
			$sheet->setCellValue('J'.$i, $row['concatenado']);
			$i++;
		}
		$sheet->getStyle('A1:J1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++){
			$sheet->getStyle('A'.$j.':J'.$j)->applyFromArray($border);
		}

		$writer = new Xls($spreadsheet);
		$filename = 'Lista_Reservadetalleservicio.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit;
	}

}
