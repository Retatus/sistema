<?php namespace App\Controllers;
use App\Controllers\BaseController;
use DateTime;
use App\Models\PaginadoModel;
use App\Models\TipodocModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;


class Tipodoc extends BaseController
{
	protected $paginado;
	protected $tipodoc;


//   SECCION ====== CONSTRUCT ======
	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->tipodoc = new TipodocModel();

	}

//   SECCION ====== INDEX ======
	public function index($bestado = 1)
	{
		$tipodoc = $this->tipodoc->getTipodocs(20, 1, 1, '');
		$total = $this->tipodoc->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'tipodoc', 'pag' => $pag, 'datos' => $tipodoc];
		$tipodoc = $this->tipodoc->getTipodocs(10, 1, 1, '');

		echo view('layouts/header', []);
		echo view('layouts/aside');
		echo view('tipodoc/list', $data);
		echo view('layouts/footer');

	}
//   SECCION ====== AGREGAR ======
	public function agregar(){

		$total = $this->tipodoc->getCount('', '');
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
			$nidtipodoc = strtoupper(trim($this->request->getPost('idtipodoc')));
			$snombre = strtoupper(trim($this->request->getPost('nombre')));
			$bestado = strtoupper(trim($this->request->getPost('estado')));
		}


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion){
			case 'agregar':
				$data  = array(
					'nidtipodoc' => $nidtipodoc,
					'snombre' => $snombre,
					'bestado' => intval($bestado),

				);
				if ($this->tipodoc->existe($nidtipodoc) == 1){
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->tipodoc->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'snombre' => $snombre,
					'bestado' => intval($bestado),

				);
				$this->tipodoc->UpdateTipodoc($nidtipodoc, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->tipodoc->UpdateTipodoc($nidtipodoc, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->tipodoc->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->tipodoc->getTipodocs(20, $pag, $todos, $texto)];
		echo json_encode($respt);
	}

//   SECCION ====== EDIT ======
	public function edit(){
		$nidtipodoc = strtoupper(trim($this->request->getPost('idtipodoc')));

		$data = $this->tipodoc->getTipodoc($nidtipodoc);
		echo json_encode($data);
	}


	public function autocompletetipodocs()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->tipodoc->getAutocompletetipodocs($todos,$keyword);
		echo json_encode($data);
	}
//   SECCION ====== Tipodoc SELECT NOMBRE ======
	public function getTipodocsSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->tipodoc->getTipodocsSelectNombre($searchTerm);
		echo json_encode($response);
	}


//   SECCION ====== PDF ======
	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de tipodoc', 0, 1, 'C');
		$pdf->Output('tipodoc.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

//   SECCION ====== EXCEL ======
	public function excel()
	{
		$total = $this->tipodoc->getCount();

		$tipodoc = $this->tipodoc->getTipodocs($total, 1, 1, '');
		require_once ROOTPATH . 'vendor/autoload.php';
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->setActiveSheetIndex(0);
		$sheet->getColumnDimension('A')->setAutoSize(true);
		$sheet->getColumnDimension('B')->setAutoSize(true);
		$sheet->getColumnDimension('C')->setAutoSize(true);
		$sheet->getColumnDimension('D')->setAutoSize(true);
		$sheet->getColumnDimension('E')->setAutoSize(true);
		$sheet->getStyle('A1:E1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF92C5FC');
		$border = ['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000'], ], ], ];
		$sheet->setCellValue('A1', 'IDTIPODOC');
		$sheet->setCellValue('B1', 'NOMBRE');
		$sheet->setCellValue('C1', 'ESTADO');
		$sheet->setCellValue('D1', 'CONCATENADO');
		$sheet->setCellValue('E1', 'CONCATENADODETALLE');
		$i=2;
		foreach ($tipodoc as $row){
			$sheet->setCellValue('A'.$i, $row['idtipodoc']);
			$sheet->setCellValue('B'.$i, $row['nombre']);
			$sheet->setCellValue('C'.$i, $row['estado']);
			$sheet->setCellValue('D'.$i, $row['concatenado']);
			$sheet->setCellValue('E'.$i, $row['concatenadodetalle']);
			$i++;
		}
		$sheet->getStyle('A1:E1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++){
			$sheet->getStyle('A'.$j.':E'.$j)->applyFromArray($border);
		}

		$writer = new Xls($spreadsheet);
		$filename = 'Lista_Tipodoc.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit;
	}

}
