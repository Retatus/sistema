<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PaginadoModel;
use App\Models\OtroservicioModel;


class Otroservicio extends BaseController
{
	protected $paginado;
	protected $otroservicio;


	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->otroservicio = new OtroservicioModel();

	}

	public function index($bestado = 1)
	{
		$otroservicio = $this->otroservicio->getOtroservicios(1, '', 20, 1);
		$total = $this->otroservicio->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'otroservicio', 'pag' => $pag, 'datos' => $otroservicio];

		echo view('layouts/header');
		echo view('layouts/aside');
		echo view('otroservicio/list', $data);
		echo view('layouts/footer');

	}
	public function agregar(){
	
		$total = $this->otroservicio->getCount('', '');
		$pag = $this->paginado->pagina(1, $total, 1);
		print_r($pag);
	}

	public function opciones(){
		$accion = (isset($_GET['accion'])) ? $_GET['accion']:'leer';
		$pag = (int)(isset($_GET['pag'])) ? $_GET['pag']:1;

		$todos = $this->request->getPost('todos');
		$texto = strtoupper(trim($this->request->getPost('texto')));

		$nidotroservicio = strtoupper(trim($this->request->getPost('idotroservicio')));
		$sotroservicionombre = strtoupper(trim($this->request->getPost('otroservicionombre')));
		$dotroservicioprecio = strtoupper(trim($this->request->getPost('otroservicioprecio')));
		$botroservicioestado = strtoupper(trim($this->request->getPost('otroservicioestado')));


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion) {
			case 'agregar':
				$data  = array(
					'nidotroservicio' => intval($nidotroservicio),
					'sotroservicionombre' => $sotroservicionombre,
					'dotroservicioprecio' => doubleval($dotroservicioprecio),
					'botroservicioestado' => intval($botroservicioestado),

				);
				if ($this->otroservicio->existe($nidotroservicio) == 1) {
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->otroservicio->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'sotroservicionombre' => $sotroservicionombre,
					'dotroservicioprecio' => doubleval($dotroservicioprecio),
					'botroservicioestado' => intval($botroservicioestado),

				);
				$this->otroservicio->UpdateOtroservicio($nidotroservicio, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->otroservicio->UpdateOtroservicio($nidotroservicio, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->otroservicio->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->otroservicio->getotroservicios($todos, $texto, 20, $pag)];
		echo json_encode($respt);
	}

	public function edit(){ 
		$nidotroservicio = strtoupper(trim($this->request->getPost('idotroservicio')));

		$data = $this->otroservicio->getOtroservicio($nidotroservicio);
		echo json_encode($data);
	}


	public function getotroserviciosSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->otroservicio->getotroserviciosSelectNombre($searchTerm);
		echo json_encode($response);
	}


	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de otroservicio', 0, 1, 'C');
		$pdf->Output('otroservicio.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

	public function excel()
	{
		$total = $this->otroservicio->getCount();

		$otroservicio = $this->otroservicio->getOtroservicios(1, '', $total, 1);
		$doc = new \PHPExcel();
		$doc->setActiveSheetIndex(0);
		$doc->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$doc->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$doc->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$doc->getActiveSheet()->getStyle('A1:C1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF92C5FC');
		$border = array('borders' => array('allborders' => array('style' => \PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))));
		$doc->getActiveSheet()->SetCellValue('A1', 'NOMBRE');
		$doc->getActiveSheet()->SetCellValue('B1', 'PRECIO');
		$doc->getActiveSheet()->SetCellValue('C1', 'ESTADO');
		$i=2;
		foreach ($otroservicio as $row) {
			$doc->getActiveSheet()->SetCellValue('A'.$i, $row['otroservicionombre']);
			$doc->getActiveSheet()->SetCellValue('B'.$i, $row['otroservicioprecio']);
			$doc->getActiveSheet()->SetCellValue('C'.$i, $row['otroservicioestado']);
			$i++;
		}
		$doc->getActiveSheet()->getStyle('A1:C1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++) {
			$doc->getActiveSheet()->getStyle('A'.$j.':C'.$j)->applyFromArray($border);
		}

		$filename = 'Lista_otroservicio.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$objWriter = \PHPExcel_IOFactory::createWriter($doc, 'Excel5');
		$objWriter->save('php://output');
	}

}
