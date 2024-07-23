<?php namespace App\Controllers;
use App\Controllers\BaseController;
use DateTime;
use App\Models\PaginadoModel;
use App\Models\RestauranteModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;


class Restaurante extends BaseController
{
	protected $paginado;
	protected $restaurante;


//   SECCION ====== CONSTRUCT ======
	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->restaurante = new RestauranteModel();

	}

//   SECCION ====== INDEX ======
	public function index($bestado = 1)
	{
		$restaurante = $this->restaurante->getRestaurantes(20, 1, 1, '');
		$total = $this->restaurante->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'restaurante', 'pag' => $pag, 'datos' => $restaurante];
		$restaurante = $this->restaurante->getRestaurantes(10, 1, 1, '');

		echo view('layouts/header', []);
		echo view('layouts/aside');
		echo view('restaurante/list', $data);
		echo view('layouts/footer');

	}
//   SECCION ====== AGREGAR ======
	public function agregar(){

		$total = $this->restaurante->getCount('', '');
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
			$sidtrestaurante = strtoupper(trim($this->request->getPost('idtrestaurante')));
			$srestaurantenombre = strtoupper(trim($this->request->getPost('restaurantenombre')));
			$nidrestaurantecategoria = strtoupper(trim($this->request->getPost('idrestaurantecategoria')));
			$srestaurantedireccion = strtoupper(trim($this->request->getPost('restaurantedireccion')));
			$srestaurantetelefono = strtoupper(trim($this->request->getPost('restaurantetelefono')));
			$srestaurantecorreo = strtoupper(trim($this->request->getPost('restaurantecorreo')));
			$srestauranteruc = strtoupper(trim($this->request->getPost('restauranteruc')));
			$srestauranterazon = strtoupper(trim($this->request->getPost('restauranterazon')));
			$srestaurantenrocuenta = strtoupper(trim($this->request->getPost('restaurantenrocuenta')));
			$srestauranteubigeo = strtoupper(trim($this->request->getPost('restauranteubigeo')));
			$drestaurantelatitud = strtoupper(trim($this->request->getPost('restaurantelatitud')));
			$drestaurantelongitud = strtoupper(trim($this->request->getPost('restaurantelongitud')));
			$brestauranteestado = strtoupper(trim($this->request->getPost('restauranteestado')));
		}


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion){
			case 'agregar':
				$data  = array(
					'sidtrestaurante' => $sidtrestaurante,
					'srestaurantenombre' => $srestaurantenombre,
					'nidrestaurantecategoria' => $nidrestaurantecategoria,
					'srestaurantedireccion' => $srestaurantedireccion,
					'srestaurantetelefono' => $srestaurantetelefono,
					'srestaurantecorreo' => $srestaurantecorreo,
					'srestauranteruc' => $srestauranteruc,
					'srestauranterazon' => $srestauranterazon,
					'srestaurantenrocuenta' => $srestaurantenrocuenta,
					'srestauranteubigeo' => $srestauranteubigeo,
					'drestaurantelatitud' => doubleval($drestaurantelatitud),
					'drestaurantelongitud' => doubleval($drestaurantelongitud),
					'brestauranteestado' => intval($brestauranteestado),

				);
				if ($this->restaurante->existe($sidtrestaurante) == 1){
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->restaurante->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'srestaurantenombre' => $srestaurantenombre,
					'nidrestaurantecategoria' => $nidrestaurantecategoria,
					'srestaurantedireccion' => $srestaurantedireccion,
					'srestaurantetelefono' => $srestaurantetelefono,
					'srestaurantecorreo' => $srestaurantecorreo,
					'srestauranteruc' => $srestauranteruc,
					'srestauranterazon' => $srestauranterazon,
					'srestaurantenrocuenta' => $srestaurantenrocuenta,
					'srestauranteubigeo' => $srestauranteubigeo,
					'drestaurantelatitud' => doubleval($drestaurantelatitud),
					'drestaurantelongitud' => doubleval($drestaurantelongitud),
					'brestauranteestado' => intval($brestauranteestado),

				);
				$this->restaurante->UpdateRestaurante($sidtrestaurante, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->restaurante->UpdateRestaurante($sidtrestaurante, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->restaurante->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->restaurante->getRestaurantes(20, $pag, $todos, $texto)];
		echo json_encode($respt);
	}

//   SECCION ====== EDIT ======
	public function edit(){
		$sidtrestaurante = strtoupper(trim($this->request->getPost('idtrestaurante')));

		$data = $this->restaurante->getRestaurante($sidtrestaurante);
		echo json_encode($data);
	}


	public function autocompleterestaurantes()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->restaurante->getAutocompleterestaurantes($todos,$keyword);
		echo json_encode($data);
	}
//   SECCION ====== Restaurante SELECT NOMBRE ======
	public function getRestaurantesSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->restaurante->getRestaurantesSelectNombre($searchTerm);
		echo json_encode($response);
	}


//   SECCION ====== PDF ======
	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de restaurante', 0, 1, 'C');
		$pdf->Output('restaurante.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

//   SECCION ====== EXCEL ======
	public function excel()
	{
		$total = $this->restaurante->getCount();

		$restaurante = $this->restaurante->getRestaurantes($total, 1, 1, '');
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
		$sheet->setCellValue('A1', 'IDTRESTAURANTE');
		$sheet->setCellValue('B1', 'RESTAURANTENOMBRE');
		$sheet->setCellValue('C1', 'IDRESTAURANTECATEGORIA');
		$sheet->setCellValue('D1', 'RESTAURANTEDIRECCION');
		$sheet->setCellValue('E1', 'RESTAURANTETELEFONO');
		$sheet->setCellValue('F1', 'RESTAURANTECORREO');
		$sheet->setCellValue('G1', 'RESTAURANTERUC');
		$sheet->setCellValue('H1', 'RESTAURANTERAZON');
		$sheet->setCellValue('I1', 'RESTAURANTENROCUENTA');
		$sheet->setCellValue('J1', 'RESTAURANTEUBIGEO');
		$sheet->setCellValue('K1', 'RESTAURANTELATITUD');
		$sheet->setCellValue('L1', 'RESTAURANTELONGITUD');
		$sheet->setCellValue('M1', 'RESTAURANTEESTADO');
		$sheet->setCellValue('N1', 'CONCATENADO');
		$sheet->setCellValue('O1', 'CONCATENADODETALLE');
		$i=2;
		foreach ($restaurante as $row){
			$sheet->setCellValue('A'.$i, $row['idtrestaurante']);
			$sheet->setCellValue('B'.$i, $row['restaurantenombre']);
			$sheet->setCellValue('C'.$i, $row['idrestaurantecategoria']);
			$sheet->setCellValue('D'.$i, $row['restaurantedireccion']);
			$sheet->setCellValue('E'.$i, $row['restaurantetelefono']);
			$sheet->setCellValue('F'.$i, $row['restaurantecorreo']);
			$sheet->setCellValue('G'.$i, $row['restauranteruc']);
			$sheet->setCellValue('H'.$i, $row['restauranterazon']);
			$sheet->setCellValue('I'.$i, $row['restaurantenrocuenta']);
			$sheet->setCellValue('J'.$i, $row['restauranteubigeo']);
			$sheet->setCellValue('K'.$i, $row['restaurantelatitud']);
			$sheet->setCellValue('L'.$i, $row['restaurantelongitud']);
			$sheet->setCellValue('M'.$i, $row['restauranteestado']);
			$sheet->setCellValue('N'.$i, $row['concatenado']);
			$sheet->setCellValue('O'.$i, $row['concatenadodetalle']);
			$i++;
		}
		$sheet->getStyle('A1:O1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++){
			$sheet->getStyle('A'.$j.':O'.$j)->applyFromArray($border);
		}

		$writer = new Xls($spreadsheet);
		$filename = 'Lista_Restaurante.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit;
	}

}
