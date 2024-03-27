<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PaginadoModel;
use App\Models\TipodocModel;


class Tipodoc extends BaseController
{
	protected $paginado;
	protected $tipodoc;


	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->tipodoc = new TipodocModel();

	}

	public function index($bestado = 1)
	{
		$tipodoc = $this->tipodoc->getTipodocs(1, '', 20, 1);
		$total = $this->tipodoc->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'tipodoc', 'pag' => $pag, 'datos' => $tipodoc];

		echo view('layouts/header');
		echo view('layouts/aside');
		echo view('tipodoc/list', $data);
		echo view('layouts/footer');

	}
	public function agregar(){
	
		$total = $this->tipodoc->getCount('', '');
		$pag = $this->paginado->pagina(1, $total, 1);
		print_r($pag);
	}

	public function opciones(){
		$accion = (isset($_GET['accion'])) ? $_GET['accion']:'leer';
		$pag = (int)(isset($_GET['pag'])) ? $_GET['pag']:1;

		$todos = $this->request->getPost('todos');
		$texto = strtoupper(trim($this->request->getPost('texto')));

		$nidtipodoc = strtoupper(trim($this->request->getPost('idtipodoc')));
		$snombre = strtoupper(trim($this->request->getPost('nombre')));
		$bestado = strtoupper(trim($this->request->getPost('estado')));


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion) {
			case 'agregar':
				$data  = array(
					'nidtipodoc' => $nidtipodoc,
					'snombre' => $snombre,
					'bestado' => intval($bestado),

				);
				if ($this->tipodoc->existe($nidtipodoc) == 1) {
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
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->tipodoc->gettipodocs($todos, $texto, 20, $pag)];
		echo json_encode($respt);
	}

	public function edit(){ 
		$nidtipodoc = strtoupper(trim($this->request->getPost('idtipodoc')));

		$data = $this->tipodoc->getTipodoc($nidtipodoc);
		echo json_encode($data);
	}


	public function gettipodocsSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->tipodoc->gettipodocsSelectNombre($searchTerm);
		echo json_encode($response);
	}


	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de tipodoc', 0, 1, 'C');
		$pdf->Output('tipodoc.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

	public function excel()
	{
		$total = $this->tipodoc->getCount();

		$tipodoc = $this->tipodoc->getTipodocs(1, '', $total, 1);
		$doc = new \PHPExcel();
		$doc->setActiveSheetIndex(0);
		$doc->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$doc->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$doc->getActiveSheet()->getStyle('A1:B1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF92C5FC');
		$border = array('borders' => array('allborders' => array('style' => \PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))));
		$doc->getActiveSheet()->SetCellValue('A1', 'NOMBRE');
		$doc->getActiveSheet()->SetCellValue('B1', 'ESTADO');
		$i=2;
		foreach ($tipodoc as $row) {
			$doc->getActiveSheet()->SetCellValue('A'.$i, $row['nombre']);
			$doc->getActiveSheet()->SetCellValue('B'.$i, $row['estado']);
			$i++;
		}
		$doc->getActiveSheet()->getStyle('A1:B1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++) {
			$doc->getActiveSheet()->getStyle('A'.$j.':B'.$j)->applyFromArray($border);
		}

		$filename = 'Lista_tipodoc.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$objWriter = \PHPExcel_IOFactory::createWriter($doc, 'Excel5');
		$objWriter->save('php://output');
	}

}
