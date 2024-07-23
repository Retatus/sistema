<?php namespace App\Controllers;
use App\Controllers\BaseController;
use DateTime;
use App\Models\PaginadoModel;
use App\Models\HotelhabitacionModel;
use App\Models\CathabitacionModel;
use App\Models\HotelModel;
use App\Models\BancoModel;
use App\Models\CathotelModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;


class Hotelhabitacion extends BaseController
{
	protected $paginado;
	protected $hotelhabitacion;
	protected $cathabitacion;
	protected $hotel;
	protected $banco;
	protected $cathotel;


//   SECCION ====== CONSTRUCT ======
	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->hotelhabitacion = new HotelhabitacionModel();
		$this->cathabitacion = new CathabitacionModel();
		$this->hotel = new HotelModel();
		$this->banco = new BancoModel();
		$this->cathotel = new CathotelModel();

	}

//   SECCION ====== INDEX ======
	public function index($bestado = 1)
	{
		$hotelhabitacion = $this->hotelhabitacion->getHotelhabitacions(20, 1, 1, '');
		$total = $this->hotelhabitacion->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'hotelhabitacion', 'pag' => $pag, 'datos' => $hotelhabitacion];
		$hotelhabitacion = $this->hotelhabitacion->getHotelhabitacions(10, 1, 1, '');
		$cathabitacion = $this->cathabitacion->getCathabitacions(10, 1, 1, '');
		$hotel = $this->hotel->getHotels(10, 1, 1, '');
		$banco = $this->banco->getBancos(10, 1, 1, '');
		$cathotel = $this->cathotel->getCathotels(10, 1, 1, '');

		echo view('layouts/header', ['cathabitacions' => $cathabitacion, 'hotels' => $hotel, 'bancos' => $banco, 'cathotels' => $cathotel]);
		echo view('layouts/aside');
		echo view('hotelhabitacion/list', $data);
		echo view('layouts/footer');

	}
//   SECCION ====== AGREGAR ======
	public function agregar(){

		$total = $this->hotelhabitacion->getCount('', '');
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
			$nidhotelhabitacion = strtoupper(trim($this->request->getPost('idhotelhabitacion')));
			$sidhotel = strtoupper(trim($this->request->getPost('idhotel')));
			$nidcathabitacion = strtoupper(trim($this->request->getPost('idcathabitacion')));
			$dprecio = strtoupper(trim($this->request->getPost('precio')));
			$tempdate = trim($this->request->getPost('fecha'));
			$tempdate = explode('/', $tempdate);
			$tfecha = date('Y-m-d', strtotime($tempdate[1].'/'.$tempdate[0].'/'.$tempdate[2]));
			$bestado = strtoupper(trim($this->request->getPost('estado')));
			$bconfirmado = strtoupper(trim($this->request->getPost('confirmado')));
		}


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion){
			case 'agregar':
				$data  = array(
					'nidhotelhabitacion' => $nidhotelhabitacion,
					'sidhotel' => $sidhotel,
					'nidcathabitacion' => $nidcathabitacion,
					'dprecio' => doubleval($dprecio),
					'tfecha' => $tfecha,
					'bestado' => intval($bestado),
					'bconfirmado' => intval($bconfirmado),

				);
				if ($this->hotelhabitacion->existe($nidhotelhabitacion, $sidhotel, $nidcathabitacion) == 1){
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->hotelhabitacion->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'sidhotel' => $sidhotel,
					'nidcathabitacion' => $nidcathabitacion,
					'dprecio' => doubleval($dprecio),
					'tfecha' => $tfecha,
					'bestado' => intval($bestado),
					'bconfirmado' => intval($bconfirmado),

				);
				$this->hotelhabitacion->UpdateHotelhabitacion($nidhotelhabitacion, $sidhotel, $nidcathabitacion, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->hotelhabitacion->UpdateHotelhabitacion($nidhotelhabitacion, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->hotelhabitacion->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->hotelhabitacion->getHotelhabitacions(20, $pag, $todos, $texto)];
		echo json_encode($respt);
	}

//   SECCION ====== EDIT ======
	public function edit(){
		$nidhotelhabitacion = strtoupper(trim($this->request->getPost('idhotelhabitacion')));
		$sidhotel = strtoupper(trim($this->request->getPost('idhotel')));
		$nidcathabitacion = strtoupper(trim($this->request->getPost('idcathabitacion')));

		$data = $this->hotelhabitacion->getHotelhabitacion($nidhotelhabitacion, $sidhotel, $nidcathabitacion);
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
//   SECCION ====== Hotelhabitacion SELECT NOMBRE ======
	public function getHotelhabitacionsSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->hotelhabitacion->getHotelhabitacionsSelectNombre($searchTerm);
		echo json_encode($response);
	}


//   SECCION ====== PDF ======
	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de hotelhabitacion', 0, 1, 'C');
		$pdf->Output('hotelhabitacion.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

//   SECCION ====== EXCEL ======
	public function excel()
	{
		$total = $this->hotelhabitacion->getCount();

		$hotelhabitacion = $this->hotelhabitacion->getHotelhabitacions($total, 1, 1, '');
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
		$sheet->setCellValue('A1', 'IDHOTELHABITACION');
		$sheet->setCellValue('B1', 'PRECIO');
		$sheet->setCellValue('C1', 'FECHA');
		$sheet->setCellValue('D1', 'ESTADO');
		$sheet->setCellValue('E1', 'CONFIRMADO');
		$sheet->setCellValue('F1', 'IDCATHABITACION');
		$sheet->setCellValue('G1', 'NOMBRE');
		$sheet->setCellValue('H1', 'IDHOTEL');
		$sheet->setCellValue('I1', 'NOMBRE');
		$sheet->setCellValue('J1', 'IDBANCO');
		$sheet->setCellValue('K1', 'NOMBRE');
		$sheet->setCellValue('L1', 'IDCATHOTEL');
		$sheet->setCellValue('M1', 'NOMBRE');
		$sheet->setCellValue('N1', 'CONCATENADO');
		$sheet->setCellValue('O1', 'CONCATENADODETALLE');
		$i=2;
		foreach ($hotelhabitacion as $row){
			$sheet->setCellValue('A'.$i, $row['idhotelhabitacion']);
			$sheet->setCellValue('B'.$i, $row['precio']);
			$sheet->setCellValue('C'.$i, $row['fecha']);
			$sheet->setCellValue('D'.$i, $row['estado']);
			$sheet->setCellValue('E'.$i, $row['confirmado']);
			$sheet->setCellValue('F'.$i, $row['idcathabitacion']);
			$sheet->setCellValue('G'.$i, $row['nombre']);
			$sheet->setCellValue('H'.$i, $row['idhotel']);
			$sheet->setCellValue('I'.$i, $row['nombre']);
			$sheet->setCellValue('J'.$i, $row['idbanco']);
			$sheet->setCellValue('K'.$i, $row['nombre']);
			$sheet->setCellValue('L'.$i, $row['idcathotel']);
			$sheet->setCellValue('M'.$i, $row['nombre']);
			$sheet->setCellValue('N'.$i, $row['concatenado']);
			$sheet->setCellValue('O'.$i, $row['concatenadodetalle']);
			$i++;
		}
		$sheet->getStyle('A1:O1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++){
			$sheet->getStyle('A'.$j.':O'.$j)->applyFromArray($border);
		}

		$writer = new Xls($spreadsheet);
		$filename = 'Lista_Hotelhabitacion.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit;
	}

}
