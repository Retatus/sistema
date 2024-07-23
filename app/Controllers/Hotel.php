<?php namespace App\Controllers;
use App\Controllers\BaseController;
use DateTime;
use App\Models\PaginadoModel;
use App\Models\HotelModel;
use App\Models\BancoModel;
use App\Models\CathotelModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;


class Hotel extends BaseController
{
	protected $paginado;
	protected $hotel;
	protected $banco;
	protected $cathotel;


//   SECCION ====== CONSTRUCT ======
	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->hotel = new HotelModel();
		$this->banco = new BancoModel();
		$this->cathotel = new CathotelModel();

	}

//   SECCION ====== INDEX ======
	public function index($bestado = 1)
	{
		$hotel = $this->hotel->getHotels(20, 1, 1, '');
		$total = $this->hotel->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'hotel', 'pag' => $pag, 'datos' => $hotel];
		$hotel = $this->hotel->getHotels(10, 1, 1, '');
		$banco = $this->banco->getBancos(10, 1, 1, '');
		$cathotel = $this->cathotel->getCathotels(10, 1, 1, '');

		echo view('layouts/header', ['bancos' => $banco, 'cathotels' => $cathotel]);
		echo view('layouts/aside');
		echo view('hotel/list', $data);
		echo view('layouts/footer');

	}
//   SECCION ====== AGREGAR ======
	public function agregar(){

		$total = $this->hotel->getCount('', '');
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
			$sidhotel = strtoupper(trim($this->request->getPost('idhotel')));
			$snombre = strtoupper(trim($this->request->getPost('nombre')));
			$nidcathotel = strtoupper(trim($this->request->getPost('idcathotel')));
			$sdireccion = strtoupper(trim($this->request->getPost('direccion')));
			$stelefono = strtoupper(trim($this->request->getPost('telefono')));
			$scorreo = strtoupper(trim($this->request->getPost('correo')));
			$sruc = strtoupper(trim($this->request->getPost('ruc')));
			$srazonsocial = strtoupper(trim($this->request->getPost('razonsocial')));
			$snrocuenta = strtoupper(trim($this->request->getPost('nrocuenta')));
			$nidbanco = strtoupper(trim($this->request->getPost('idbanco')));
			$subigeo = strtoupper(trim($this->request->getPost('ubigeo')));
			$dlatitud = strtoupper(trim($this->request->getPost('latitud')));
			$dlongitud = strtoupper(trim($this->request->getPost('longitud')));
			$bestado = strtoupper(trim($this->request->getPost('estado')));
		}


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion){
			case 'agregar':
				$data  = array(
					'sidhotel' => $sidhotel,
					'snombre' => $snombre,
					'nidcathotel' => $nidcathotel,
					'sdireccion' => $sdireccion,
					'stelefono' => $stelefono,
					'scorreo' => $scorreo,
					'sruc' => $sruc,
					'srazonsocial' => $srazonsocial,
					'snrocuenta' => $snrocuenta,
					'nidbanco' => intval($nidbanco),
					'subigeo' => $subigeo,
					'dlatitud' => doubleval($dlatitud),
					'dlongitud' => doubleval($dlongitud),
					'bestado' => intval($bestado),

				);
				if ($this->hotel->existe($sidhotel, $nidcathotel, $nidbanco) == 1){
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->hotel->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'snombre' => $snombre,
					'nidcathotel' => $nidcathotel,
					'sdireccion' => $sdireccion,
					'stelefono' => $stelefono,
					'scorreo' => $scorreo,
					'sruc' => $sruc,
					'srazonsocial' => $srazonsocial,
					'snrocuenta' => $snrocuenta,
					'nidbanco' => intval($nidbanco),
					'subigeo' => $subigeo,
					'dlatitud' => doubleval($dlatitud),
					'dlongitud' => doubleval($dlongitud),
					'bestado' => intval($bestado),

				);
				$this->hotel->UpdateHotel($sidhotel, $nidcathotel, $nidbanco, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->hotel->UpdateHotel($sidhotel, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->hotel->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->hotel->getHotels(20, $pag, $todos, $texto)];
		echo json_encode($respt);
	}

//   SECCION ====== EDIT ======
	public function edit(){
		$sidhotel = strtoupper(trim($this->request->getPost('idhotel')));
		$nidcathotel = strtoupper(trim($this->request->getPost('idcathotel')));
		$nidbanco = strtoupper(trim($this->request->getPost('idbanco')));

		$data = $this->hotel->getHotel($sidhotel, $nidcathotel, $nidbanco);
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
//   SECCION ====== Hotel SELECT NOMBRE ======
	public function getHotelsSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->hotel->getHotelsSelectNombre($searchTerm);
		echo json_encode($response);
	}


//   SECCION ====== PDF ======
	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de hotel', 0, 1, 'C');
		$pdf->Output('hotel.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

//   SECCION ====== EXCEL ======
	public function excel()
	{
		$total = $this->hotel->getCount();

		$hotel = $this->hotel->getHotels($total, 1, 1, '');
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
		$sheet->getStyle('A1:R1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF92C5FC');
		$border = ['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000'], ], ], ];
		$sheet->setCellValue('A1', 'IDHOTEL');
		$sheet->setCellValue('B1', 'NOMBRE');
		$sheet->setCellValue('C1', 'DIRECCION');
		$sheet->setCellValue('D1', 'TELEFONO');
		$sheet->setCellValue('E1', 'CORREO');
		$sheet->setCellValue('F1', 'RUC');
		$sheet->setCellValue('G1', 'RAZONSOCIAL');
		$sheet->setCellValue('H1', 'NROCUENTA');
		$sheet->setCellValue('I1', 'UBIGEO');
		$sheet->setCellValue('J1', 'LATITUD');
		$sheet->setCellValue('K1', 'LONGITUD');
		$sheet->setCellValue('L1', 'ESTADO');
		$sheet->setCellValue('M1', 'IDBANCO');
		$sheet->setCellValue('N1', 'NOMBRE');
		$sheet->setCellValue('O1', 'IDCATHOTEL');
		$sheet->setCellValue('P1', 'NOMBRE');
		$sheet->setCellValue('Q1', 'CONCATENADO');
		$sheet->setCellValue('R1', 'CONCATENADODETALLE');
		$i=2;
		foreach ($hotel as $row){
			$sheet->setCellValue('A'.$i, $row['idhotel']);
			$sheet->setCellValue('B'.$i, $row['nombre']);
			$sheet->setCellValue('C'.$i, $row['direccion']);
			$sheet->setCellValue('D'.$i, $row['telefono']);
			$sheet->setCellValue('E'.$i, $row['correo']);
			$sheet->setCellValue('F'.$i, $row['ruc']);
			$sheet->setCellValue('G'.$i, $row['razonsocial']);
			$sheet->setCellValue('H'.$i, $row['nrocuenta']);
			$sheet->setCellValue('I'.$i, $row['ubigeo']);
			$sheet->setCellValue('J'.$i, $row['latitud']);
			$sheet->setCellValue('K'.$i, $row['longitud']);
			$sheet->setCellValue('L'.$i, $row['estado']);
			$sheet->setCellValue('M'.$i, $row['idbanco']);
			$sheet->setCellValue('N'.$i, $row['nombre']);
			$sheet->setCellValue('O'.$i, $row['idcathotel']);
			$sheet->setCellValue('P'.$i, $row['nombre']);
			$sheet->setCellValue('Q'.$i, $row['concatenado']);
			$sheet->setCellValue('R'.$i, $row['concatenadodetalle']);
			$i++;
		}
		$sheet->getStyle('A1:R1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++){
			$sheet->getStyle('A'.$j.':R'.$j)->applyFromArray($border);
		}

		$writer = new Xls($spreadsheet);
		$filename = 'Lista_Hotel.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit;
	}

}
