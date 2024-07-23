<?php namespace App\Controllers;
use App\Controllers\BaseController;
use DateTime;
use App\Models\PaginadoModel;
use App\Models\HoratrenModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;


class Horatren extends BaseController
{
	protected $paginado;
	protected $horatren;


//   SECCION ====== CONSTRUCT ======
	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->horatren = new HoratrenModel();

	}

//   SECCION ====== INDEX ======
	public function index($bestado = 1)
	{
		$horatren = $this->horatren->getHoratrens(20, 1, 1, '');
		$total = $this->horatren->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'horatren', 'pag' => $pag, 'datos' => $horatren];
		$horatren = $this->horatren->getHoratrens(10, 1, 1, '');

		echo view('layouts/header', []);
		echo view('layouts/aside');
		echo view('horatren/list', $data);
		echo view('layouts/footer');

	}
//   SECCION ====== AGREGAR ======
	public function agregar(){

		$total = $this->horatren->getCount('', '');
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
			$nidhorario = strtoupper(trim($this->request->getPost('idhorario')));
			$snombre = strtoupper(trim($this->request->getPost('nombre')));
			$sdescripcion = strtoupper(trim($this->request->getPost('descripcion')));
			$bida = strtoupper(trim($this->request->getPost('ida')));
			$bestado = strtoupper(trim($this->request->getPost('estado')));
		}


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion){
			case 'agregar':
				$data  = array(
					'nidhorario' => $nidhorario,
					'snombre' => $snombre,
					'sdescripcion' => $sdescripcion,
					'bida' => intval($bida),
					'bestado' => intval($bestado),

				);
				if ($this->horatren->existe($nidhorario) == 1){
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->horatren->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'snombre' => $snombre,
					'sdescripcion' => $sdescripcion,
					'bida' => intval($bida),
					'bestado' => intval($bestado),

				);
				$this->horatren->UpdateHoratren($nidhorario, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->horatren->UpdateHoratren($nidhorario, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->horatren->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->horatren->getHoratrens(20, $pag, $todos, $texto)];
		echo json_encode($respt);
	}

//   SECCION ====== EDIT ======
	public function edit(){
		$nidhorario = strtoupper(trim($this->request->getPost('idhorario')));

		$data = $this->horatren->getHoratren($nidhorario);
		echo json_encode($data);
	}


	public function autocompletehoratrens()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->horatren->getAutocompletehoratrens($todos,$keyword);
		echo json_encode($data);
	}
//   SECCION ====== Horatren SELECT NOMBRE ======
	public function getHoratrensSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->horatren->getHoratrensSelectNombre($searchTerm);
		echo json_encode($response);
	}


//   SECCION ====== PDF ======
	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de horatren', 0, 1, 'C');
		$pdf->Output('horatren.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

//   SECCION ====== EXCEL ======
	public function excel()
	{
		$total = $this->horatren->getCount();

		$horatren = $this->horatren->getHoratrens($total, 1, 1, '');
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
		$sheet->getStyle('A1:G1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF92C5FC');
		$border = ['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000'], ], ], ];
		$sheet->setCellValue('A1', 'IDHORARIO');
		$sheet->setCellValue('B1', 'NOMBRE');
		$sheet->setCellValue('C1', 'DESCRIPCION');
		$sheet->setCellValue('D1', 'IDA');
		$sheet->setCellValue('E1', 'ESTADO');
		$sheet->setCellValue('F1', 'CONCATENADO');
		$sheet->setCellValue('G1', 'CONCATENADODETALLE');
		$i=2;
		foreach ($horatren as $row){
			$sheet->setCellValue('A'.$i, $row['idhorario']);
			$sheet->setCellValue('B'.$i, $row['nombre']);
			$sheet->setCellValue('C'.$i, $row['descripcion']);
			$sheet->setCellValue('D'.$i, $row['ida']);
			$sheet->setCellValue('E'.$i, $row['estado']);
			$sheet->setCellValue('F'.$i, $row['concatenado']);
			$sheet->setCellValue('G'.$i, $row['concatenadodetalle']);
			$i++;
		}
		$sheet->getStyle('A1:G1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++){
			$sheet->getStyle('A'.$j.':G'.$j)->applyFromArray($border);
		}

		$writer = new Xls($spreadsheet);
		$filename = 'Lista_Horatren.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit;
	}

}
