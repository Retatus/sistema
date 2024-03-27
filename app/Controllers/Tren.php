<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PaginadoModel;
use App\Models\TrenModel;


class Tren extends BaseController
{
	protected $paginado;
	protected $tren;


	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->tren = new TrenModel();

	}

	public function index($bestado = 1)
	{
		$tren = $this->tren->getTrens(1, '', 20, 1);
		$total = $this->tren->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'tren', 'pag' => $pag, 'datos' => $tren];

		echo view('layouts/header');
		echo view('layouts/aside');
		echo view('tren/list', $data);
		echo view('layouts/footer');

	}
	public function agregar(){
	
		$total = $this->tren->getCount('', '');
		$pag = $this->paginado->pagina(1, $total, 1);
		print_r($pag);
	}

	public function opciones(){
		$accion = (isset($_GET['accion'])) ? $_GET['accion']:'leer';
		$pag = (int)(isset($_GET['pag'])) ? $_GET['pag']:1;

		$todos = $this->request->getPost('todos');
		$texto = strtoupper(trim($this->request->getPost('texto')));

		$nidtren = strtoupper(trim($this->request->getPost('idtren')));
		$snombre = strtoupper(trim($this->request->getPost('nombre')));
		$sempresa = strtoupper(trim($this->request->getPost('empresa')));
		$bestado = strtoupper(trim($this->request->getPost('estado')));


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion) {
			case 'agregar':
				$data  = array(
					'nidtren' => $nidtren,
					'snombre' => $snombre,
					'sempresa' => $sempresa,
					'bestado' => intval($bestado),

				);
				if ($this->tren->existe($nidtren) == 1) {
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->tren->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'snombre' => $snombre,
					'sempresa' => $sempresa,
					'bestado' => intval($bestado),

				);
				$this->tren->UpdateTren($nidtren, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->tren->UpdateTren($nidtren, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->tren->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->tren->gettrens($todos, $texto, 20, $pag)];
		echo json_encode($respt);
	}

	public function edit(){ 
		$nidtren = strtoupper(trim($this->request->getPost('idtren')));

		$data = $this->tren->getTren($nidtren);
		echo json_encode($data);
	}


	public function gettrensSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->tren->gettrensSelectNombre($searchTerm);
		echo json_encode($response);
	}


	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de tren', 0, 1, 'C');
		$pdf->Output('tren.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

	public function excel()
	{
		$total = $this->tren->getCount();

		$tren = $this->tren->getTrens(1, '', $total, 1);
		$doc = new \PHPExcel();
		$doc->setActiveSheetIndex(0);
		$doc->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$doc->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$doc->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$doc->getActiveSheet()->getStyle('A1:C1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF92C5FC');
		$border = array('borders' => array('allborders' => array('style' => \PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))));
		$doc->getActiveSheet()->SetCellValue('A1', 'NOMBRE');
		$doc->getActiveSheet()->SetCellValue('B1', 'EMPRESA');
		$doc->getActiveSheet()->SetCellValue('C1', 'ESTADO');
		$i=2;
		foreach ($tren as $row) {
			$doc->getActiveSheet()->SetCellValue('A'.$i, $row['nombre']);
			$doc->getActiveSheet()->SetCellValue('B'.$i, $row['empresa']);
			$doc->getActiveSheet()->SetCellValue('C'.$i, $row['estado']);
			$i++;
		}
		$doc->getActiveSheet()->getStyle('A1:C1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++) {
			$doc->getActiveSheet()->getStyle('A'.$j.':C'.$j)->applyFromArray($border);
		}

		$filename = 'Lista_tren.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$objWriter = \PHPExcel_IOFactory::createWriter($doc, 'Excel5');
		$objWriter->save('php://output');
	}

}
