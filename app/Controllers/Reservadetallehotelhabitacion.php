<?php namespace App\Controllers;
use App\Controllers\BaseController;
use DateTime;
use App\Models\PaginadoModel;
use App\Models\ReservadetallehotelhabitacionModel;
use App\Models\HotelhabitacionModel;
use App\Models\CathabitacionModel;
use App\Models\HotelModel;
use App\Models\BancoModel;
use App\Models\CathotelModel;
use App\Models\ReservaModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;


class Reservadetallehotelhabitacion extends BaseController
{
	protected $paginado;
	protected $reservadetallehotelhabitacion;
	protected $hotelhabitacion;
	protected $cathabitacion;
	protected $hotel;
	protected $banco;
	protected $cathotel;
	protected $reserva;


//   SECCION ====== CONSTRUCT ======
	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->reservadetallehotelhabitacion = new ReservadetallehotelhabitacionModel();
		$this->hotelhabitacion = new HotelhabitacionModel();
		$this->cathabitacion = new CathabitacionModel();
		$this->hotel = new HotelModel();
		$this->banco = new BancoModel();
		$this->cathotel = new CathotelModel();
		$this->reserva = new ReservaModel();

	}

//   SECCION ====== INDEX ======
	public function index($bestado = 1)
	{
		$reservadetallehotelhabitacion = $this->reservadetallehotelhabitacion->getReservadetallehotelhabitacions(20, 1, 1, '');
		$total = $this->reservadetallehotelhabitacion->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'reservadetallehotelhabitacion', 'pag' => $pag, 'datos' => $reservadetallehotelhabitacion];
		$reservadetallehotelhabitacion = $this->reservadetallehotelhabitacion->getReservadetallehotelhabitacions(10, 1, 1, '');
		$hotelhabitacion = $this->hotelhabitacion->getHotelhabitacions(10, 1, 1, '');
		$cathabitacion = $this->cathabitacion->getCathabitacions(10, 1, 1, '');
		$hotel = $this->hotel->getHotels(10, 1, 1, '');
		$banco = $this->banco->getBancos(10, 1, 1, '');
		$cathotel = $this->cathotel->getCathotels(10, 1, 1, '');
		$reserva = $this->reserva->getReservas(10, 1, 1, '');

		echo view('layouts/header', ['hotelhabitacions' => $hotelhabitacion, 'cathabitacions' => $cathabitacion, 'hotels' => $hotel, 'bancos' => $banco, 'cathotels' => $cathotel, 'reservas' => $reserva]);
		echo view('layouts/aside');
		echo view('reservadetallehotelhabitacion/list', $data);
		echo view('layouts/footer');

	}
//   SECCION ====== AGREGAR ======
	public function agregar(){

		$total = $this->reservadetallehotelhabitacion->getCount('', '');
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
		}


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion){
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
				if ($this->reservadetallehotelhabitacion->existe($nidreserva, $nidreservadetallehotelhabitacion, $nidhotelhabitacion) == 1){
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
				$this->reservadetallehotelhabitacion->UpdateReservadetallehotelhabitacion($nidreserva, $nidreservadetallehotelhabitacion, $nidhotelhabitacion, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->reservadetallehotelhabitacion->UpdateReservadetallehotelhabitacion($nidreservadetallehotelhabitacion, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->reservadetallehotelhabitacion->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->reservadetallehotelhabitacion->getReservadetallehotelhabitacions(20, $pag, $todos, $texto)];
		echo json_encode($respt);
	}

//   SECCION ====== EDIT ======
	public function edit(){
		$nidreserva = strtoupper(trim($this->request->getPost('idreserva')));
		$nidreservadetallehotelhabitacion = strtoupper(trim($this->request->getPost('idreservadetallehotelhabitacion')));
		$nidhotelhabitacion = strtoupper(trim($this->request->getPost('idhotelhabitacion')));

		$data = $this->reservadetallehotelhabitacion->getReservadetallehotelhabitacion($nidreserva, $nidreservadetallehotelhabitacion, $nidhotelhabitacion);
		echo json_encode($data);
	}


	public function autocompletereservadetallehotelhabitacions()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->reservadetallehotelhabitacion->getAutocompletereservadetallehotelhabitacions($todos,$keyword);
		echo json_encode($data);
	}
	public function autocompletehotelhabitacions()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->hotelhabitacion->getAutocompletehotelhabitacions($todos,$keyword);
		echo json_encode($data);
	}
	public function autocompletecathabitacions()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->cathabitacion->getAutocompletecathabitacions($todos,$keyword);
		echo json_encode($data);
	}
	public function autocompletehotels()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->hotel->getAutocompletehotels($todos,$keyword);
		echo json_encode($data);
	}
	public function autocompletebancos()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->banco->getAutocompletebancos($todos,$keyword);
		echo json_encode($data);
	}
	public function autocompletecathotels()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->cathotel->getAutocompletecathotels($todos,$keyword);
		echo json_encode($data);
	}
	public function autocompletereservas()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->reserva->getAutocompletereservas($todos,$keyword);
		echo json_encode($data);
	}
//   SECCION ====== Reservadetallehotelhabitacion SELECT NOMBRE ======
	public function getReservadetallehotelhabitacionsSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->reservadetallehotelhabitacion->getReservadetallehotelhabitacionsSelectNombre($searchTerm);
		echo json_encode($response);
	}


//   SECCION ====== PDF ======
	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de reservadetallehotelhabitacion', 0, 1, 'C');
		$pdf->Output('reservadetallehotelhabitacion.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

//   SECCION ====== EXCEL ======
	public function excel()
	{
		$total = $this->reservadetallehotelhabitacion->getCount();

		$reservadetallehotelhabitacion = $this->reservadetallehotelhabitacion->getReservadetallehotelhabitacions($total, 1, 1, '');
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
		$sheet->getColumnDimension('R')->setAutoSize(true);
		$sheet->getColumnDimension('S')->setAutoSize(true);
		$sheet->getColumnDimension('T')->setAutoSize(true);
		$sheet->getColumnDimension('U')->setAutoSize(true);
		$sheet->getColumnDimension('V')->setAutoSize(true);
		$sheet->getColumnDimension('W')->setAutoSize(true);
		$sheet->getColumnDimension('X')->setAutoSize(true);
		$sheet->getStyle('A1:X1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF92C5FC');
		$border = ['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000'], ], ], ];
		$sheet->setCellValue('A1', 'IDRESERVADETALLEHOTELHABITACION');
		$sheet->setCellValue('B1', 'DESCRIPCION');
		$sheet->setCellValue('C1', 'FECHAINGRESO');
		$sheet->setCellValue('D1', 'FECHASALIDA');
		$sheet->setCellValue('E1', 'ADULTOS');
		$sheet->setCellValue('F1', 'NINIOS');
		$sheet->setCellValue('G1', 'CANTIDAD');
		$sheet->setCellValue('H1', 'PRECIO');
		$sheet->setCellValue('I1', 'TOTAL');
		$sheet->setCellValue('J1', 'CONFIRMADO');
		$sheet->setCellValue('K1', 'ESTADO');
		$sheet->setCellValue('L1', 'IDHOTELHABITACION');
		$sheet->setCellValue('M1', 'IDCATHABITACION');
		$sheet->setCellValue('N1', 'NOMBRE');
		$sheet->setCellValue('O1', 'IDHOTEL');
		$sheet->setCellValue('P1', 'NOMBRE');
		$sheet->setCellValue('Q1', 'IDBANCO');
		$sheet->setCellValue('R1', 'NOMBRE');
		$sheet->setCellValue('S1', 'IDCATHOTEL');
		$sheet->setCellValue('T1', 'NOMBRE');
		$sheet->setCellValue('U1', 'IDRESERVA');
		$sheet->setCellValue('V1', 'RESERVANOMBRE');
		$sheet->setCellValue('W1', 'CONCATENADO');
		$sheet->setCellValue('X1', 'CONCATENADODETALLE');
		$i=2;
		foreach ($reservadetallehotelhabitacion as $row){
			$sheet->setCellValue('A'.$i, $row['idreservadetallehotelhabitacion']);
			$sheet->setCellValue('B'.$i, $row['descripcion']);
			$sheet->setCellValue('C'.$i, $row['fechaingreso']);
			$sheet->setCellValue('D'.$i, $row['fechasalida']);
			$sheet->setCellValue('E'.$i, $row['adultos']);
			$sheet->setCellValue('F'.$i, $row['ninios']);
			$sheet->setCellValue('G'.$i, $row['cantidad']);
			$sheet->setCellValue('H'.$i, $row['precio']);
			$sheet->setCellValue('I'.$i, $row['total']);
			$sheet->setCellValue('J'.$i, $row['confirmado']);
			$sheet->setCellValue('K'.$i, $row['estado']);
			$sheet->setCellValue('L'.$i, $row['idhotelhabitacion']);
			$sheet->setCellValue('M'.$i, $row['idcathabitacion']);
			$sheet->setCellValue('N'.$i, $row['nombre']);
			$sheet->setCellValue('O'.$i, $row['idhotel']);
			$sheet->setCellValue('P'.$i, $row['nombre']);
			$sheet->setCellValue('Q'.$i, $row['idbanco']);
			$sheet->setCellValue('R'.$i, $row['nombre']);
			$sheet->setCellValue('S'.$i, $row['idcathotel']);
			$sheet->setCellValue('T'.$i, $row['nombre']);
			$sheet->setCellValue('U'.$i, $row['idreserva']);
			$sheet->setCellValue('V'.$i, $row['reservanombre']);
			$sheet->setCellValue('W'.$i, $row['concatenado']);
			$sheet->setCellValue('X'.$i, $row['concatenadodetalle']);
			$i++;
		}
		$sheet->getStyle('A1:X1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++){
			$sheet->getStyle('A'.$j.':X'.$j)->applyFromArray($border);
		}

		$writer = new Xls($spreadsheet);
		$filename = 'Lista_Reservadetallehotelhabitacion.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit;
	}

}
