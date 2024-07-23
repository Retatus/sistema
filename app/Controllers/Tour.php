<?php namespace App\Controllers;
use App\Controllers\BaseController;
use DateTime;
use App\Models\PaginadoModel;
use App\Models\TourModel;
use App\Models\CattourModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;


class Tour extends BaseController
{
	protected $paginado;
	protected $tour;
	protected $cattour;


//   SECCION ====== CONSTRUCT ======
	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->tour = new TourModel();
		$this->cattour = new CattourModel();

	}

//   SECCION ====== INDEX ======
	public function index($bestado = 1)
	{
		$tour = $this->tour->getTours(20, 1, 1, '');
		$total = $this->tour->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'tour', 'pag' => $pag, 'datos' => $tour];
		$tour = $this->tour->getTours(10, 1, 1, '');
		$cattour = $this->cattour->getCattours(10, 1, 1, '');

		echo view('layouts/header', ['cattours' => $cattour]);
		echo view('layouts/aside');
		echo view('tour/list', $data);
		echo view('layouts/footer');

	}
//   SECCION ====== AGREGAR ======
	public function agregar(){

		$total = $this->tour->getCount('', '');
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
			$sidtour = strtoupper(trim($this->request->getPost('idtour')));
			$stournombre = strtoupper(trim($this->request->getPost('tournombre')));
			$stourdescripcion = strtoupper(trim($this->request->getPost('tourdescripcion')));
			$dtourprecio = strtoupper(trim($this->request->getPost('tourprecio')));
			$scolor = strtoupper(trim($this->request->getPost('color')));
			$stourdiashabiles = strtoupper(trim($this->request->getPost('tourdiashabiles')));
			$btourestado = strtoupper(trim($this->request->getPost('tourestado')));
			$nidcattour = strtoupper(trim($this->request->getPost('idcattour')));
		}


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion){
			case 'agregar':
				$data  = array(
					'sidtour' => $sidtour,
					'stournombre' => $stournombre,
					'stourdescripcion' => $stourdescripcion,
					'dtourprecio' => doubleval($dtourprecio),
					'scolor' => $scolor,
					'stourdiashabiles' => $stourdiashabiles,
					'btourestado' => intval($btourestado),
					'nidcattour' => $nidcattour,

				);
				if ($this->tour->existe($sidtour, $nidcattour) == 1){
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->tour->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'stournombre' => $stournombre,
					'stourdescripcion' => $stourdescripcion,
					'dtourprecio' => doubleval($dtourprecio),
					'scolor' => $scolor,
					'stourdiashabiles' => $stourdiashabiles,
					'btourestado' => intval($btourestado),
					'nidcattour' => $nidcattour,

				);
				$this->tour->UpdateTour($sidtour, $nidcattour, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->tour->UpdateTour($sidtour, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->tour->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->tour->getTours(20, $pag, $todos, $texto)];
		echo json_encode($respt);
	}

//   SECCION ====== EDIT ======
	public function edit(){
		$sidtour = strtoupper(trim($this->request->getPost('idtour')));
		$nidcattour = strtoupper(trim($this->request->getPost('idcattour')));

		$data = $this->tour->getTour($sidtour, $nidcattour);
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
//   SECCION ====== Tour SELECT NOMBRE ======
	public function getToursSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->tour->getToursSelectNombre($searchTerm);
		echo json_encode($response);
	}


//   SECCION ====== PDF ======
	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de tour', 0, 1, 'C');
		$pdf->Output('tour.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

//   SECCION ====== EXCEL ======
	public function excel()
	{
		$total = $this->tour->getCount();

		$tour = $this->tour->getTours($total, 1, 1, '');
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
		$sheet->getStyle('A1:K1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF92C5FC');
		$border = ['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000'], ], ], ];
		$sheet->setCellValue('A1', 'IDTOUR');
		$sheet->setCellValue('B1', 'TOURNOMBRE');
		$sheet->setCellValue('C1', 'TOURDESCRIPCION');
		$sheet->setCellValue('D1', 'TOURPRECIO');
		$sheet->setCellValue('E1', 'COLOR');
		$sheet->setCellValue('F1', 'TOURDIASHABILES');
		$sheet->setCellValue('G1', 'TOURESTADO');
		$sheet->setCellValue('H1', 'IDCATTOUR');
		$sheet->setCellValue('I1', 'NOMBRE');
		$sheet->setCellValue('J1', 'CONCATENADO');
		$sheet->setCellValue('K1', 'CONCATENADODETALLE');
		$i=2;
		foreach ($tour as $row){
			$sheet->setCellValue('A'.$i, $row['idtour']);
			$sheet->setCellValue('B'.$i, $row['tournombre']);
			$sheet->setCellValue('C'.$i, $row['tourdescripcion']);
			$sheet->setCellValue('D'.$i, $row['tourprecio']);
			$sheet->setCellValue('E'.$i, $row['color']);
			$sheet->setCellValue('F'.$i, $row['tourdiashabiles']);
			$sheet->setCellValue('G'.$i, $row['tourestado']);
			$sheet->setCellValue('H'.$i, $row['idcattour']);
			$sheet->setCellValue('I'.$i, $row['nombre']);
			$sheet->setCellValue('J'.$i, $row['concatenado']);
			$sheet->setCellValue('K'.$i, $row['concatenadodetalle']);
			$i++;
		}
		$sheet->getStyle('A1:K1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++){
			$sheet->getStyle('A'.$j.':K'.$j)->applyFromArray($border);
		}

		$writer = new Xls($spreadsheet);
		$filename = 'Lista_Tour.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit;
	}

}
