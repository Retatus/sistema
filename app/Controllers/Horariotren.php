<?php namespace App\Controllers;
use App\Controllers\BaseController;
use DateTime;
use App\Models\PaginadoModel;
use App\Models\HorariotrenModel;
use App\Models\HoratrenModel;
use App\Models\TrenModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;


class Horariotren extends BaseController
{
	protected $paginado;
	protected $horariotren;
	protected $horatren;
	protected $tren;


//   SECCION ====== CONSTRUCT ======
	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->horariotren = new HorariotrenModel();
		$this->horatren = new HoratrenModel();
		$this->tren = new TrenModel();

	}

//   SECCION ====== INDEX ======
	public function index($bestado = 1)
	{
		$horariotren = $this->horariotren->getHorariotrens(20, 1, 1, '');
		$total = $this->horariotren->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'horariotren', 'pag' => $pag, 'datos' => $horariotren];
		$horariotren = $this->horariotren->getHorariotrens(10, 1, 1, '');
		$horatren = $this->horatren->getHoratrens(10, 1, 1, '');
		$tren = $this->tren->getTrens(10, 1, 1, '');

		echo view('layouts/header', ['horatrens' => $horatren, 'trens' => $tren]);
		echo view('layouts/aside');
		echo view('horariotren/list', $data);
		echo view('layouts/footer');

	}
//   SECCION ====== AGREGAR ======
	public function agregar(){

		$total = $this->horariotren->getCount('', '');
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
			$nidhorariotren = strtoupper(trim($this->request->getPost('idhorariotren')));
			$nidtren = strtoupper(trim($this->request->getPost('idtren')));
			$nidhorario = strtoupper(trim($this->request->getPost('idhorario')));
			$dprecio = strtoupper(trim($this->request->getPost('precio')));
			$bestado = strtoupper(trim($this->request->getPost('estado')));
		}


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion){
			case 'agregar':
				$data  = array(
					'nidhorariotren' => $nidhorariotren,
					'nidtren' => $nidtren,
					'nidhorario' => $nidhorario,
					'dprecio' => doubleval($dprecio),
					'bestado' => intval($bestado),

				);
				if ($this->horariotren->existe($nidhorariotren, $nidtren, $nidhorario) == 1){
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->horariotren->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'nidtren' => $nidtren,
					'nidhorario' => $nidhorario,
					'dprecio' => doubleval($dprecio),
					'bestado' => intval($bestado),

				);
				$this->horariotren->UpdateHorariotren($nidhorariotren, $nidtren, $nidhorario, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->horariotren->UpdateHorariotren($nidhorariotren, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->horariotren->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->horariotren->getHorariotrens(20, $pag, $todos, $texto)];
		echo json_encode($respt);
	}

//   SECCION ====== EDIT ======
	public function edit(){
		$nidhorariotren = strtoupper(trim($this->request->getPost('idhorariotren')));
		$nidtren = strtoupper(trim($this->request->getPost('idtren')));
		$nidhorario = strtoupper(trim($this->request->getPost('idhorario')));

		$data = $this->horariotren->getHorariotren($nidhorariotren, $nidtren, $nidhorario);
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
//   SECCION ====== Horariotren SELECT NOMBRE ======
	public function getHorariotrensSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->horariotren->getHorariotrensSelectNombre($searchTerm);
		echo json_encode($response);
	}


//   SECCION ====== PDF ======
	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de horariotren', 0, 1, 'C');
		$pdf->Output('horariotren.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

//   SECCION ====== EXCEL ======
	public function excel()
	{
		$total = $this->horariotren->getCount();

		$horariotren = $this->horariotren->getHorariotrens($total, 1, 1, '');
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
		$sheet->getStyle('A1:I1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF92C5FC');
		$border = ['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000'], ], ], ];
		$sheet->setCellValue('A1', 'IDHORARIOTREN');
		$sheet->setCellValue('B1', 'PRECIO');
		$sheet->setCellValue('C1', 'ESTADO');
		$sheet->setCellValue('D1', 'IDHORARIO');
		$sheet->setCellValue('E1', 'NOMBRE');
		$sheet->setCellValue('F1', 'IDTREN');
		$sheet->setCellValue('G1', 'NOMBRE');
		$sheet->setCellValue('H1', 'CONCATENADO');
		$sheet->setCellValue('I1', 'CONCATENADODETALLE');
		$i=2;
		foreach ($horariotren as $row){
			$sheet->setCellValue('A'.$i, $row['idhorariotren']);
			$sheet->setCellValue('B'.$i, $row['precio']);
			$sheet->setCellValue('C'.$i, $row['estado']);
			$sheet->setCellValue('D'.$i, $row['idhorario']);
			$sheet->setCellValue('E'.$i, $row['nombre']);
			$sheet->setCellValue('F'.$i, $row['idtren']);
			$sheet->setCellValue('G'.$i, $row['nombre']);
			$sheet->setCellValue('H'.$i, $row['concatenado']);
			$sheet->setCellValue('I'.$i, $row['concatenadodetalle']);
			$i++;
		}
		$sheet->getStyle('A1:I1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++){
			$sheet->getStyle('A'.$j.':I'.$j)->applyFromArray($border);
		}

		$writer = new Xls($spreadsheet);
		$filename = 'Lista_Horariotren.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit;
	}

}
