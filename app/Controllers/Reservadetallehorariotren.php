<?php namespace App\Controllers;
use App\Controllers\BaseController;
use DateTime;
use App\Models\PaginadoModel;
use App\Models\ReservadetallehorariotrenModel;
use App\Models\HorariotrenModel;
use App\Models\HoratrenModel;
use App\Models\TrenModel;
use App\Models\ReservaModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;


class Reservadetallehorariotren extends BaseController
{
	protected $paginado;
	protected $reservadetallehorariotren;
	protected $horariotren;
	protected $horatren;
	protected $tren;
	protected $reserva;


//   SECCION ====== CONSTRUCT ======
	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->reservadetallehorariotren = new ReservadetallehorariotrenModel();
		$this->horariotren = new HorariotrenModel();
		$this->horatren = new HoratrenModel();
		$this->tren = new TrenModel();
		$this->reserva = new ReservaModel();

	}

//   SECCION ====== INDEX ======
	public function index($bestado = 1)
	{
		$reservadetallehorariotren = $this->reservadetallehorariotren->getReservadetallehorariotrens(20, 1, 1, '');
		$total = $this->reservadetallehorariotren->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'reservadetallehorariotren', 'pag' => $pag, 'datos' => $reservadetallehorariotren];
		$reservadetallehorariotren = $this->reservadetallehorariotren->getReservadetallehorariotrens(10, 1, 1, '');
		$horariotren = $this->horariotren->getHorariotrens(10, 1, 1, '');
		$horatren = $this->horatren->getHoratrens(10, 1, 1, '');
		$tren = $this->tren->getTrens(10, 1, 1, '');
		$reserva = $this->reserva->getReservas(10, 1, 1, '');

		echo view('layouts/header', ['horariotrens' => $horariotren, 'horatrens' => $horatren, 'trens' => $tren, 'reservas' => $reserva]);
		echo view('layouts/aside');
		echo view('reservadetallehorariotren/list', $data);
		echo view('layouts/footer');

	}
//   SECCION ====== AGREGAR ======
	public function agregar(){

		$total = $this->reservadetallehorariotren->getCount('', '');
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
		}


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion){
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
				if ($this->reservadetallehorariotren->existe($nidreserva, $nidreservadetallehorariotren, $nidhorariotren) == 1){
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
				$this->reservadetallehorariotren->UpdateReservadetallehorariotren($nidreserva, $nidreservadetallehorariotren, $nidhorariotren, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->reservadetallehorariotren->UpdateReservadetallehorariotren($nidreservadetallehorariotren, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->reservadetallehorariotren->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->reservadetallehorariotren->getReservadetallehorariotrens(20, $pag, $todos, $texto)];
		echo json_encode($respt);
	}

//   SECCION ====== EDIT ======
	public function edit(){
		$nidreserva = strtoupper(trim($this->request->getPost('idreserva')));
		$nidreservadetallehorariotren = strtoupper(trim($this->request->getPost('idreservadetallehorariotren')));
		$nidhorariotren = strtoupper(trim($this->request->getPost('idhorariotren')));

		$data = $this->reservadetallehorariotren->getReservadetallehorariotren($nidreserva, $nidreservadetallehorariotren, $nidhorariotren);
		echo json_encode($data);
	}


	public function autocompletereservadetallehorariotrens()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->reservadetallehorariotren->getAutocompletereservadetallehorariotrens($todos,$keyword);
		echo json_encode($data);
	}
	public function autocompletehorariotrens()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->horariotren->getAutocompletehorariotrens($todos,$keyword);
		echo json_encode($data);
	}
	public function autocompletehoratrens()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->horatren->getAutocompletehoratrens($todos,$keyword);
		echo json_encode($data);
	}
	public function autocompletetrens()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->tren->getAutocompletetrens($todos,$keyword);
		echo json_encode($data);
	}
	public function autocompletereservas()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->reserva->getAutocompletereservas($todos,$keyword);
		echo json_encode($data);
	}
//   SECCION ====== Reservadetallehorariotren SELECT NOMBRE ======
	public function getReservadetallehorariotrensSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->reservadetallehorariotren->getReservadetallehorariotrensSelectNombre($searchTerm);
		echo json_encode($response);
	}


//   SECCION ====== PDF ======
	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de reservadetallehorariotren', 0, 1, 'C');
		$pdf->Output('reservadetallehorariotren.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

//   SECCION ====== EXCEL ======
	public function excel()
	{
		$total = $this->reservadetallehorariotren->getCount();

		$reservadetallehorariotren = $this->reservadetallehorariotren->getReservadetallehorariotrens($total, 1, 1, '');
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
		$sheet->getColumnDimension('Q')->setAutoSize(true);
		$sheet->getStyle('A1:Q1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF92C5FC');
		$border = ['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000'], ], ], ];
		$sheet->setCellValue('A1', 'IDRESERVADETALLEHORARIOTREN');
		$sheet->setCellValue('B1', 'DESCRIPCION');
		$sheet->setCellValue('C1', 'FECHA');
		$sheet->setCellValue('D1', 'CANTIDAD');
		$sheet->setCellValue('E1', 'PRECIO');
		$sheet->setCellValue('F1', 'TOTAL');
		$sheet->setCellValue('G1', 'CONFIRMADO');
		$sheet->setCellValue('H1', 'ESTADO');
		$sheet->setCellValue('I1', 'IDHORARIOTREN');
		$sheet->setCellValue('J1', 'IDHORARIO');
		$sheet->setCellValue('K1', 'NOMBRE');
		$sheet->setCellValue('L1', 'IDTREN');
		$sheet->setCellValue('M1', 'NOMBRE');
		$sheet->setCellValue('N1', 'IDRESERVA');
		$sheet->setCellValue('O1', 'RESERVANOMBRE');
		$sheet->setCellValue('P1', 'CONCATENADO');
		$sheet->setCellValue('Q1', 'CONCATENADODETALLE');
		$i=2;
		foreach ($reservadetallehorariotren as $row){
			$sheet->setCellValue('A'.$i, $row['idreservadetallehorariotren']);
			$sheet->setCellValue('B'.$i, $row['descripcion']);
			$sheet->setCellValue('C'.$i, $row['fecha']);
			$sheet->setCellValue('D'.$i, $row['cantidad']);
			$sheet->setCellValue('E'.$i, $row['precio']);
			$sheet->setCellValue('F'.$i, $row['total']);
			$sheet->setCellValue('G'.$i, $row['confirmado']);
			$sheet->setCellValue('H'.$i, $row['estado']);
			$sheet->setCellValue('I'.$i, $row['idhorariotren']);
			$sheet->setCellValue('J'.$i, $row['idhorario']);
			$sheet->setCellValue('K'.$i, $row['nombre']);
			$sheet->setCellValue('L'.$i, $row['idtren']);
			$sheet->setCellValue('M'.$i, $row['nombre']);
			$sheet->setCellValue('N'.$i, $row['idreserva']);
			$sheet->setCellValue('O'.$i, $row['reservanombre']);
			$sheet->setCellValue('P'.$i, $row['concatenado']);
			$sheet->setCellValue('Q'.$i, $row['concatenadodetalle']);
			$i++;
		}
		$sheet->getStyle('A1:Q1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++){
			$sheet->getStyle('A'.$j.':Q'.$j)->applyFromArray($border);
		}

		$writer = new Xls($spreadsheet);
		$filename = 'Lista_Reservadetallehorariotren.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit;
	}

}
