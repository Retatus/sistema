<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PaginadoModel;
use App\Models\TicketbusModel;


class Ticketbus extends BaseController
{
	protected $paginado;
	protected $ticketbus;


	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->ticketbus = new TicketbusModel();

	}

	public function index($bestado = 1)
	{
		$ticketbus = $this->ticketbus->getTicketbuss(1, '', 20, 1);
		$total = $this->ticketbus->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'ticketbus', 'pag' => $pag, 'datos' => $ticketbus];

		echo view('layouts/header');
		echo view('layouts/aside');
		echo view('ticketbus/list', $data);
		echo view('layouts/footer');

	}
	public function agregar(){
	
		$total = $this->ticketbus->getCount('', '');
		$pag = $this->paginado->pagina(1, $total, 1);
		print_r($pag);
	}

	public function opciones(){
		$accion = (isset($_GET['accion'])) ? $_GET['accion']:'leer';
		$pag = (int)(isset($_GET['pag'])) ? $_GET['pag']:1;

		$todos = $this->request->getPost('todos');
		$texto = strtoupper(trim($this->request->getPost('texto')));

		$nidticketbus = strtoupper(trim($this->request->getPost('idticketbus')));
		$snombre = strtoupper(trim($this->request->getPost('nombre')));
		$sdescripcion = strtoupper(trim($this->request->getPost('descripcion')));
		$dprecio = strtoupper(trim($this->request->getPost('precio')));
		$bestado = strtoupper(trim($this->request->getPost('estado')));


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion) {
			case 'agregar':
				$data  = array(
					'nidticketbus' => $nidticketbus,
					'snombre' => $snombre,
					'sdescripcion' => $sdescripcion,
					'dprecio' => doubleval($dprecio),
					'bestado' => intval($bestado),

				);
				if ($this->ticketbus->existe($nidticketbus) == 1) {
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->ticketbus->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'snombre' => $snombre,
					'sdescripcion' => $sdescripcion,
					'dprecio' => doubleval($dprecio),
					'bestado' => intval($bestado),

				);
				$this->ticketbus->UpdateTicketbus($nidticketbus, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->ticketbus->UpdateTicketbus($nidticketbus, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->ticketbus->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->ticketbus->getticketbuss($todos, $texto, 10, $pag)];
		echo json_encode($respt);
	}

	public function edit(){ 
		$nidticketbus = strtoupper(trim($this->request->getPost('idticketbus')));

		$data = $this->ticketbus->getTicketbus($nidticketbus);
		echo json_encode($data);
	}


	public function getticketbussSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->ticketbus->getticketbussSelectNombre($searchTerm);
		echo json_encode($response);
	}


	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de ticketbus', 0, 1, 'C');
		$pdf->Output('ticketbus.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

	public function excel()
	{
		$total = $this->ticketbus->getCount();

		$ticketbus = $this->ticketbus->getTicketbuss(1, '', $total, 1);
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
		$doc->getActiveSheet()->SetCellValue('C1', 'PRECIO');
		$doc->getActiveSheet()->SetCellValue('D1', 'ESTADO');
		$i=2;
		foreach ($ticketbus as $row) {
			$doc->getActiveSheet()->SetCellValue('A'.$i, $row['nombre']);
			$doc->getActiveSheet()->SetCellValue('B'.$i, $row['descripcion']);
			$doc->getActiveSheet()->SetCellValue('C'.$i, $row['precio']);
			$doc->getActiveSheet()->SetCellValue('D'.$i, $row['estado']);
			$i++;
		}
		$doc->getActiveSheet()->getStyle('A1:D1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++) {
			$doc->getActiveSheet()->getStyle('A'.$j.':D'.$j)->applyFromArray($border);
		}

		$filename = 'Lista_ticketbus.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$objWriter = \PHPExcel_IOFactory::createWriter($doc, 'Excel5');
		$objWriter->save('php://output');
	}

}
