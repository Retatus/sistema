<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PaginadoModel;
use App\Models\TourModel;
use App\Models\CattourModel;


class Tour extends BaseController
{
	protected $paginado;
	protected $tour;
	protected $cattour;


	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->tour = new TourModel();
		$this->cattour = new CattourModel();

	}

	public function index($bestado = 1)
	{
		$tour = $this->tour->getTours(1, '', 20, 1);
		$total = $this->tour->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'tour', 'pag' => $pag, 'datos' => $tour];
		$cattour = $this->cattour->getCattours(1, '', 10, 1);

		echo view('layouts/header', ['cattours' => $cattour]);
		echo view('layouts/aside');
		echo view('tour/list', $data);
		echo view('layouts/footer');

	}
	public function agregar(){
	
		$total = $this->tour->getCount('', '');
		$pag = $this->paginado->pagina(1, $total, 1);
		print_r($pag);
	}

	public function opciones(){
		$accion = (isset($_GET['accion'])) ? $_GET['accion']:'leer';
		$pag = (int)(isset($_GET['pag'])) ? $_GET['pag']:1;

		$todos = $this->request->getPost('todos');
		$texto = strtoupper(trim($this->request->getPost('texto')));

		$sidtour = strtoupper(trim($this->request->getPost('idtour')));
		$stournombre = strtoupper(trim($this->request->getPost('tournombre')));
		$stourdescripcion = strtoupper(trim($this->request->getPost('tourdescripcion')));
		$dtourprecio = strtoupper(trim($this->request->getPost('tourprecio')));
		$scolor = strtoupper(trim($this->request->getPost('color')));
		$stourdiashabiles = strtoupper(trim($this->request->getPost('tourdiashabiles')));
		$btourestado = strtoupper(trim($this->request->getPost('tourestado')));
		$nidcattour = strtoupper(trim($this->request->getPost('idcattour')));


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion) {
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
				if ($this->tour->existe($sidtour,$nidcattour) == 1) {
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
				$this->tour->UpdateTour($sidtour,$nidcattour, $data);
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
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->tour->gettours($todos, $texto, 20, $pag)];
		echo json_encode($respt);
	}

	public function edit(){ 
		$sidtour = strtoupper(trim($this->request->getPost('idtour')));
		$nidcattour = strtoupper(trim($this->request->getPost('idcattour')));

		$data = $this->tour->getTour($sidtour,$nidcattour);
		echo json_encode($data);
	}

	public function autocompletecattours()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->cattour->getAutocompletecattours($todos,$keyword);
		echo json_encode($data);
	}

	public function gettoursSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->tour->gettoursSelectNombre($searchTerm);
		echo json_encode($response);
	}


	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de tour', 0, 1, 'C');
		$pdf->Output('tour.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

	public function excel()
	{
		$total = $this->tour->getCount();

		$tour = $this->tour->getTours(1, '', $total, 1);
		$doc = new \PHPExcel();
		$doc->setActiveSheetIndex(0);
		$doc->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$doc->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$doc->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$doc->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$doc->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$doc->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$doc->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		$doc->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
		$doc->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
		$doc->getActiveSheet()->getStyle('A1:I1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF92C5FC');
		$border = array('borders' => array('allborders' => array('style' => \PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))));
		$doc->getActiveSheet()->SetCellValue('A1', 'ID');
		$doc->getActiveSheet()->SetCellValue('B1', 'NOMBRE');
		$doc->getActiveSheet()->SetCellValue('C1', 'DESCRIPCION');
		$doc->getActiveSheet()->SetCellValue('D1', 'PRECIO');
		$doc->getActiveSheet()->SetCellValue('E1', 'COLOR');
		$doc->getActiveSheet()->SetCellValue('F1', 'DIASHABILES');
		$doc->getActiveSheet()->SetCellValue('G1', 'ESTADO');
		$doc->getActiveSheet()->SetCellValue('H1', 'NOMBRE');
		$doc->getActiveSheet()->SetCellValue('I1', 'IDCAT');
		$i=2;
		foreach ($tour as $row) {
			$doc->getActiveSheet()->SetCellValue('A'.$i, $row['idtour']);
			$doc->getActiveSheet()->SetCellValue('B'.$i, $row['tournombre']);
			$doc->getActiveSheet()->SetCellValue('C'.$i, $row['tourdescripcion']);
			$doc->getActiveSheet()->SetCellValue('D'.$i, $row['tourprecio']);
			$doc->getActiveSheet()->SetCellValue('E'.$i, $row['color']);
			$doc->getActiveSheet()->SetCellValue('F'.$i, $row['tourdiashabiles']);
			$doc->getActiveSheet()->SetCellValue('G'.$i, $row['tourestado']);
			$doc->getActiveSheet()->SetCellValue('H'.$i, $row['nombre']);
			$doc->getActiveSheet()->SetCellValue('I'.$i, $row['idcattour']);
			$i++;
		}
		$doc->getActiveSheet()->getStyle('A1:I1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++) {
			$doc->getActiveSheet()->getStyle('A'.$j.':I'.$j)->applyFromArray($border);
		}

		$filename = 'Lista_tour.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$objWriter = \PHPExcel_IOFactory::createWriter($doc, 'Excel5');
		$objWriter->save('php://output');
	}

}
