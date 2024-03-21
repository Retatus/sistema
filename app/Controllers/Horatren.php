<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PaginadoModel;
use App\Models\HoratrenModel;


class Horatren extends BaseController
{
	protected $paginado;
	protected $horatren;


	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->horatren = new HoratrenModel();

	}

	public function index($bestado = 1)
	{
		$horatren = $this->horatren->getHoratrens(1, '', 10, 1);
		$total = $this->horatren->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'horatren', 'pag' => $pag, 'datos' => $horatren];

		echo view('layouts/header');
		echo view('layouts/aside');
		echo view('horatren/list', $data);
		echo view('layouts/footer');

	}
	public function agregar(){
	
		$total = $this->horatren->getCount('', '');
		$pag = $this->paginado->pagina(1, $total, 1);
		print_r($pag);
	}

	public function opciones(){
		$accion = (isset($_GET['accion'])) ? $_GET['accion']:'leer';
		$pag = (int)(isset($_GET['pag'])) ? $_GET['pag']:1;

		$todos = $this->request->getPost('todos');
		$texto = strtoupper(trim($this->request->getPost('texto')));

		$nidhorario = strtoupper(trim($this->request->getPost('idhorario')));
		$snombre = strtoupper(trim($this->request->getPost('nombre')));
		$sdescripcion = strtoupper(trim($this->request->getPost('descripcion')));
		$bida = strtoupper(trim($this->request->getPost('ida')));
		$bestado = strtoupper(trim($this->request->getPost('estado')));


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion) {
			case 'agregar':
				$data  = array(
					'nidhorario' => $nidhorario,
					'snombre' => $snombre,
					'sdescripcion' => $sdescripcion,
					'bida' => intval($bida),
					'bestado' => intval($bestado),

				);
				if ($this->horatren->existe($nidhorario) == 1) {
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
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->horatren->gethoratrens($todos, $texto, 10, $pag)];
		echo json_encode($respt);
	}

	public function edit(){ 
		$nidhorario = strtoupper(trim($this->request->getPost('idhorario')));

		$data = $this->horatren->getHoratren($nidhorario);
		echo json_encode($data);
	}


	public function gethoratrensSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->horatren->gethoratrensSelectNombre($searchTerm);
		echo json_encode($response);
	}


	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de horatren', 0, 1, 'C');
		$pdf->Output('horatren.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

	public function excel()
	{
		$total = $this->horatren->getCount();

		$horatren = $this->horatren->getHoratrens(1, '', $total, 1);
		$doc = new \PHPExcel();
		$doc->setActiveSheetIndex(0);
		$doc->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$doc->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$doc->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$doc->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$doc->getActiveSheet()->getStyle('A1:D1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF92C5FC');
		$border = array('borders' => array('allborders' => array('style' => \PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))));
		$doc->getActiveSheet()->SetCellValue('A1', 'NOMBRE');
		$doc->getActiveSheet()->SetCellValue('B1', 'DESCRIPCION');
		$doc->getActiveSheet()->SetCellValue('C1', 'IDA');
		$doc->getActiveSheet()->SetCellValue('D1', 'ESTADO');
		$i=2;
		foreach ($horatren as $row) {
			$doc->getActiveSheet()->SetCellValue('A'.$i, $row['nombre']);
			$doc->getActiveSheet()->SetCellValue('B'.$i, $row['descripcion']);
			$doc->getActiveSheet()->SetCellValue('C'.$i, $row['ida']);
			$doc->getActiveSheet()->SetCellValue('D'.$i, $row['estado']);
			$i++;
		}
		$doc->getActiveSheet()->getStyle('A1:D1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++) {
			$doc->getActiveSheet()->getStyle('A'.$j.':D'.$j)->applyFromArray($border);
		}

		$filename = 'Lista_horatren.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$objWriter = \PHPExcel_IOFactory::createWriter($doc, 'Excel5');
		$objWriter->save('php://output');
	}

}
