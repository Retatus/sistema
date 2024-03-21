<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PaginadoModel;
use App\Models\HorariotrenModel;
use App\Models\HoratrenModel;
use App\Models\TrenModel;


class Horariotren extends BaseController
{
	protected $paginado;
	protected $horariotren;
	protected $horatren;
	protected $tren;


	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->horariotren = new HorariotrenModel();
		$this->horatren = new HoratrenModel();
		$this->tren = new TrenModel();

	}

	public function index($bestado = 1)
	{
		$horariotren = $this->horariotren->getHorariotrens(1, '', 10, 1);
		$total = $this->horariotren->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'horariotren', 'pag' => $pag, 'datos' => $horariotren];
		$horatren = $this->horatren->getHoratrens(1, '', 10, 1);
		$tren = $this->tren->getTrens(1, '', 10, 1);

		echo view('layouts/header', ['horatrens' => $horatren, 'trens' => $tren]);
		echo view('layouts/aside');
		echo view('horariotren/list', $data);
		echo view('layouts/footer');

	}
	public function agregar(){
	
		$total = $this->horariotren->getCount('', '');
		$pag = $this->paginado->pagina(1, $total, 1);
		print_r($pag);
	}

	public function opciones(){
		$accion = (isset($_GET['accion'])) ? $_GET['accion']:'leer';
		$pag = (int)(isset($_GET['pag'])) ? $_GET['pag']:1;

		$todos = $this->request->getPost('todos');
		$texto = strtoupper(trim($this->request->getPost('texto')));

		$nidhorariotren = strtoupper(trim($this->request->getPost('idhorariotren')));
		$nidtren = strtoupper(trim($this->request->getPost('idtren')));
		$nidhorario = strtoupper(trim($this->request->getPost('idhorario')));
		$dprecio = strtoupper(trim($this->request->getPost('precio')));
		$bestado = strtoupper(trim($this->request->getPost('estado')));


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion) {
			case 'agregar':
				$data  = array(
					'nidhorariotren' => $nidhorariotren,
					'nidtren' => $nidtren,
					'nidhorario' => $nidhorario,
					'dprecio' => doubleval($dprecio),
					'bestado' => intval($bestado),

				);
				if ($this->horariotren->existe($nidhorariotren,$nidhorario,$nidtren) == 1) {
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
				$this->horariotren->UpdateHorariotren($nidhorariotren, $data);
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
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->horariotren->gethorariotrens($todos, $texto, 10, $pag)];
		echo json_encode($respt);
	}

	public function edit(){ 
		$nidhorariotren = strtoupper(trim($this->request->getPost('idhorariotren')));
		$nidtren = strtoupper(trim($this->request->getPost('idtren')));
		$nidhorario = strtoupper(trim($this->request->getPost('idhorario')));

		$data = $this->horariotren->getHorariotren($nidhorariotren,$nidtren,$nidhorario);
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

	public function gethorariotrensSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->horariotren->gethorariotrensSelectNombre($searchTerm);
		echo json_encode($response);
	}


	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de horariotren', 0, 1, 'C');
		$pdf->Output('horariotren.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

	public function excel()
	{
		$total = $this->horariotren->getCount();

		$horariotren = $this->horariotren->getHorariotrens(1, '', $total, 1);
		$doc = new \PHPExcel();
		$doc->setActiveSheetIndex(0);
		$doc->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$doc->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$doc->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$doc->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$doc->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$doc->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$doc->getActiveSheet()->getStyle('A1:F1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF92C5FC');
		$border = array('borders' => array('allborders' => array('style' => \PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))));
		$doc->getActiveSheet()->SetCellValue('A1', 'NOMBRE');
		$doc->getActiveSheet()->SetCellValue('B1', 'IDTREN');
		$doc->getActiveSheet()->SetCellValue('C1', 'NOMBRE');
		$doc->getActiveSheet()->SetCellValue('D1', 'IDHORARIO');
		$doc->getActiveSheet()->SetCellValue('E1', 'PRECIO');
		$doc->getActiveSheet()->SetCellValue('F1', 'ESTADO');
		$i=2;
		foreach ($horariotren as $row) {
			$doc->getActiveSheet()->SetCellValue('A'.$i, $row['nombre']);
			$doc->getActiveSheet()->SetCellValue('B'.$i, $row['idtren']);
			$doc->getActiveSheet()->SetCellValue('C'.$i, $row['nombre']);
			$doc->getActiveSheet()->SetCellValue('D'.$i, $row['idhorario']);
			$doc->getActiveSheet()->SetCellValue('E'.$i, $row['precio']);
			$doc->getActiveSheet()->SetCellValue('F'.$i, $row['estado']);
			$i++;
		}
		$doc->getActiveSheet()->getStyle('A1:F1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++) {
			$doc->getActiveSheet()->getStyle('A'.$j.':F'.$j)->applyFromArray($border);
		}

		$filename = 'Lista_horariotren.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$objWriter = \PHPExcel_IOFactory::createWriter($doc, 'Excel5');
		$objWriter->save('php://output');
	}

}
