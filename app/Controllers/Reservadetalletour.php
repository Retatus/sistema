<?php namespace App\Controllers;
use App\Controllers\BaseController;
use DateTime;
use App\Models\PaginadoModel;
use App\Models\ReservadetalletourModel;
use App\Models\ReservaModel;
use App\Models\TourModel;
use App\Models\CattourModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;


class Reservadetalletour extends BaseController
{
	protected $paginado;
	protected $reservadetalletour;
	protected $reserva;
	protected $tour;
	protected $cattour;


//   SECCION ====== CONSTRUCT ======
	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->reservadetalletour = new ReservadetalletourModel();
		$this->reserva = new ReservaModel();
		$this->tour = new TourModel();
		$this->cattour = new CattourModel();

	}

//   SECCION ====== INDEX ======
	public function index($bestado = 1)
	{
		$reservadetalletour = $this->reservadetalletour->getReservadetalletours(20, 1, 1, '');
		$total = $this->reservadetalletour->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'reservadetalletour', 'pag' => $pag, 'datos' => $reservadetalletour];
		$reservadetalletour = $this->reservadetalletour->getReservadetalletours(10, 1, 1, '');
		$reserva = $this->reserva->getReservas(10, 1, 1, '');
		$tour = $this->tour->getTours(10, 1, 1, '');
		$cattour = $this->cattour->getCattours(10, 1, 1, '');

		echo view('layouts/header', ['reservas' => $reserva, 'tours' => $tour, 'cattours' => $cattour]);
		echo view('layouts/aside');
		echo view('reservadetalletour/list', $data);
		echo view('layouts/footer');

	}
//   SECCION ====== AGREGAR ======
	public function agregar(){

		$total = $this->reservadetalletour->getCount('', '');
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
			$nidreservatour = strtoupper(trim($this->request->getPost('idreservatour')));
			$sidtour = strtoupper(trim($this->request->getPost('idtour')));
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
					'nidreservatour' => intval($nidreservatour),
					'sidtour' => $sidtour,
					'sdescripcion' => $sdescripcion,
					'tfecha' => $tfecha,
					'ncantidad' => intval($ncantidad),
					'dprecio' => doubleval($dprecio),
					'dtotal' => doubleval($dtotal),
					'bconfirmado' => intval($bconfirmado),
					'bestado' => intval($bestado),

				);
				if ($this->reservadetalletour->existe($nidreserva, $nidreservatour, $sidtour) == 1){
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->reservadetalletour->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'nidreserva' => intval($nidreserva),
					'sidtour' => $sidtour,
					'sdescripcion' => $sdescripcion,
					'tfecha' => $tfecha,
					'ncantidad' => intval($ncantidad),
					'dprecio' => doubleval($dprecio),
					'dtotal' => doubleval($dtotal),
					'bconfirmado' => intval($bconfirmado),
					'bestado' => intval($bestado),

				);
				$this->reservadetalletour->UpdateReservadetalletour($nidreserva, $nidreservatour, $sidtour, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->reservadetalletour->UpdateReservadetalletour($nidreservatour, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->reservadetalletour->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->reservadetalletour->getReservadetalletours(20, $pag, $todos, $texto)];
		echo json_encode($respt);
	}

//   SECCION ====== EDIT ======
	public function edit(){
		$nidreserva = strtoupper(trim($this->request->getPost('idreserva')));
		$nidreservatour = strtoupper(trim($this->request->getPost('idreservatour')));
		$sidtour = strtoupper(trim($this->request->getPost('idtour')));

		$data = $this->reservadetalletour->getReservadetalletour($nidreserva, $nidreservatour, $sidtour);
		echo json_encode($data);
	}


	public function autocompletereservadetalletours()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->reservadetalletour->getAutocompletereservadetalletours($todos,$keyword);
		echo json_encode($data);
	}
	public function autocompletereservas()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->reserva->getAutocompletereservas($todos,$keyword);
		echo json_encode($data);
	}
	public function autocompletetours()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->tour->getAutocompletetours($todos,$keyword);
		echo json_encode($data);
	}
	public function autocompletecattours()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->cattour->getAutocompletecattours($todos,$keyword);
		echo json_encode($data);
	}
//   SECCION ====== Reservadetalletour SELECT NOMBRE ======
	public function getReservadetalletoursSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->reservadetalletour->getReservadetalletoursSelectNombre($searchTerm);
		echo json_encode($response);
	}


//   SECCION ====== PDF ======
	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de reservadetalletour', 0, 1, 'C');
		$pdf->Output('reservadetalletour.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

//   SECCION ====== EXCEL ======
	public function excel()
	{
		$total = $this->reservadetalletour->getCount();

		$reservadetalletour = $this->reservadetalletour->getReservadetalletours($total, 1, 1, '');
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
		$sheet->getStyle('A1:P1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF92C5FC');
		$border = ['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000'], ], ], ];
		$sheet->setCellValue('A1', 'IDRESERVATOUR');
		$sheet->setCellValue('B1', 'DESCRIPCION');
		$sheet->setCellValue('C1', 'FECHA');
		$sheet->setCellValue('D1', 'CANTIDAD');
		$sheet->setCellValue('E1', 'PRECIO');
		$sheet->setCellValue('F1', 'TOTAL');
		$sheet->setCellValue('G1', 'CONFIRMADO');
		$sheet->setCellValue('H1', 'ESTADO');
		$sheet->setCellValue('I1', 'IDRESERVA');
		$sheet->setCellValue('J1', 'RESERVANOMBRE');
		$sheet->setCellValue('K1', 'IDTOUR');
		$sheet->setCellValue('L1', 'TOURNOMBRE');
		$sheet->setCellValue('M1', 'IDCATTOUR');
		$sheet->setCellValue('N1', 'NOMBRE');
		$sheet->setCellValue('O1', 'CONCATENADO');
		$sheet->setCellValue('P1', 'CONCATENADODETALLE');
		$i=2;
		foreach ($reservadetalletour as $row){
			$sheet->setCellValue('A'.$i, $row['idreservatour']);
			$sheet->setCellValue('B'.$i, $row['descripcion']);
			$sheet->setCellValue('C'.$i, $row['fecha']);
			$sheet->setCellValue('D'.$i, $row['cantidad']);
			$sheet->setCellValue('E'.$i, $row['precio']);
			$sheet->setCellValue('F'.$i, $row['total']);
			$sheet->setCellValue('G'.$i, $row['confirmado']);
			$sheet->setCellValue('H'.$i, $row['estado']);
			$sheet->setCellValue('I'.$i, $row['idreserva']);
			$sheet->setCellValue('J'.$i, $row['reservanombre']);
			$sheet->setCellValue('K'.$i, $row['idtour']);
			$sheet->setCellValue('L'.$i, $row['tournombre']);
			$sheet->setCellValue('M'.$i, $row['idcattour']);
			$sheet->setCellValue('N'.$i, $row['nombre']);
			$sheet->setCellValue('O'.$i, $row['concatenado']);
			$sheet->setCellValue('P'.$i, $row['concatenadodetalle']);
			$i++;
		}
		$sheet->getStyle('A1:P1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++){
			$sheet->getStyle('A'.$j.':P'.$j)->applyFromArray($border);
		}

		$writer = new Xls($spreadsheet);
		$filename = 'Lista_Reservadetalletour.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit;
	}

}
