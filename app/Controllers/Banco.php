<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PaginadoModel;
use App\Models\BancoModel;


class Banco extends BaseController
{
	protected $paginado;
	protected $banco;


	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->banco = new BancoModel();

	}

	public function index($bestado = 1)
	{
		$banco = $this->banco->getBancos(1, '', 10, 1);
		$total = $this->banco->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'banco', 'pag' => $pag, 'datos' => $banco];

		echo view('layouts/header');
		echo view('layouts/aside');
		echo view('banco/list', $data);
		echo view('layouts/footer');

	}
	public function agregar(){
	
		$total = $this->banco->getCount('', '');
		$pag = $this->paginado->pagina(1, $total, 1);
		print_r($pag);
	}

	public function opciones(){
		$accion = (isset($_GET['accion'])) ? $_GET['accion']:'leer';
		$pag = (int)(isset($_GET['pag'])) ? $_GET['pag']:1;

		$todos = $this->request->getPost('todos');
		$texto = strtoupper(trim($this->request->getPost('texto')));

		$nidbanco = strtoupper(trim($this->request->getPost('idbanco')));
		$snombre = strtoupper(trim($this->request->getPost('nombre')));
		$bestado = strtoupper(trim($this->request->getPost('estado')));


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion) {
			case 'agregar':
				$data  = array(
					'nidbanco' => intval($nidbanco),
					'snombre' => $snombre,
					'bestado' => intval($bestado),

				);
				if ($this->banco->existe($nidbanco) == 1) {
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->banco->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'snombre' => $snombre,
					'bestado' => intval($bestado),

				);
				$this->banco->UpdateBanco($nidbanco, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->banco->UpdateBanco($nidbanco, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->banco->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->banco->getbancos($todos, $texto, 10, $pag)];
		echo json_encode($respt);
	}

	public function edit(){ 
		$nidbanco = strtoupper(trim($this->request->getPost('idbanco')));

		$data = $this->banco->getBanco($nidbanco);
		echo json_encode($data);
	}


	public function getbancosSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->banco->getbancosSelectNombre($searchTerm);
		echo json_encode($response);
	}


	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de banco', 0, 1, 'C');
		$pdf->Output('banco.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

	public function excel()
	{
		$total = $this->banco->getCount();

		$banco = $this->banco->getBancos(1, '', $total, 1);
		$doc = new \PHPExcel();
		$doc->setActiveSheetIndex(0);
		$doc->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$doc->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$doc->getActiveSheet()->getStyle('A1:B1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF92C5FC');
		$border = array('borders' => array('allborders' => array('style' => \PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))));
		$doc->getActiveSheet()->SetCellValue('A1', 'NOMBRE');
		$doc->getActiveSheet()->SetCellValue('B1', 'ESTADO');
		$i=2;
		foreach ($banco as $row) {
			$doc->getActiveSheet()->SetCellValue('A'.$i, $row['nombre']);
			$doc->getActiveSheet()->SetCellValue('B'.$i, $row['estado']);
			$i++;
		}
		$doc->getActiveSheet()->getStyle('A1:B1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++) {
			$doc->getActiveSheet()->getStyle('A'.$j.':B'.$j)->applyFromArray($border);
		}

		$filename = 'Lista_banco.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$objWriter = \PHPExcel_IOFactory::createWriter($doc, 'Excel5');
		$objWriter->save('php://output');
	}

}
