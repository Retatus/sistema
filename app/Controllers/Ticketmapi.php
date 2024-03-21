<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PaginadoModel;
use App\Models\TicketmapiModel;


class Ticketmapi extends BaseController
{
	protected $paginado;
	protected $ticketmapi;


	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->ticketmapi = new TicketmapiModel();

	}

	public function index($bestado = 1)
	{
		$ticketmapi = $this->ticketmapi->getTicketmapis(1, '', 10, 1);
		$total = $this->ticketmapi->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'ticketmapi', 'pag' => $pag, 'datos' => $ticketmapi];

		echo view('layouts/header');
		echo view('layouts/aside');
		echo view('ticketmapi/list', $data);
		echo view('layouts/footer');

	}
	public function agregar(){
	
		$total = $this->ticketmapi->getCount('', '');
		$pag = $this->paginado->pagina(1, $total, 1);
		print_r($pag);
	}

	public function opciones(){
		$accion = (isset($_GET['accion'])) ? $_GET['accion']:'leer';
		$pag = (int)(isset($_GET['pag'])) ? $_GET['pag']:1;

		$todos = $this->request->getPost('todos');
		$texto = strtoupper(trim($this->request->getPost('texto')));

		$nidticketmapi = strtoupper(trim($this->request->getPost('idticketmapi')));
		$snombre = strtoupper(trim($this->request->getPost('nombre')));
		$bestado = strtoupper(trim($this->request->getPost('estado')));


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion) {
			case 'agregar':
				$data  = array(
					'nidticketmapi' => $nidticketmapi,
					'snombre' => $snombre,
					'bestado' => intval($bestado),

				);
				if ($this->ticketmapi->existe($nidticketmapi) == 1) {
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->ticketmapi->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'snombre' => $snombre,
					'bestado' => intval($bestado),

				);
				$this->ticketmapi->UpdateTicketmapi($nidticketmapi, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->ticketmapi->UpdateTicketmapi($nidticketmapi, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->ticketmapi->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->ticketmapi->getticketmapis($todos, $texto, 10, $pag)];
		echo json_encode($respt);
	}

	public function edit(){ 
		$nidticketmapi = strtoupper(trim($this->request->getPost('idticketmapi')));

		$data = $this->ticketmapi->getTicketmapi($nidticketmapi);
		echo json_encode($data);
	}


	public function getticketmapisSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->ticketmapi->getticketmapisSelectNombre($searchTerm);
		echo json_encode($response);
	}


	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de ticketmapi', 0, 1, 'C');
		$pdf->Output('ticketmapi.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

	public function excel()
	{
		$total = $this->ticketmapi->getCount();

		$ticketmapi = $this->ticketmapi->getTicketmapis(1, '', $total, 1);
		$doc = new \PHPExcel();
		$doc->setActiveSheetIndex(0);
		$doc->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$doc->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$doc->getActiveSheet()->getStyle('A1:B1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF92C5FC');
		$border = array('borders' => array('allborders' => array('style' => \PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))));
		$doc->getActiveSheet()->SetCellValue('A1', 'NOMBRE');
		$doc->getActiveSheet()->SetCellValue('B1', 'ESTADO');
		$i=2;
		foreach ($ticketmapi as $row) {
			$doc->getActiveSheet()->SetCellValue('A'.$i, $row['nombre']);
			$doc->getActiveSheet()->SetCellValue('B'.$i, $row['estado']);
			$i++;
		}
		$doc->getActiveSheet()->getStyle('A1:B1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++) {
			$doc->getActiveSheet()->getStyle('A'.$j.':B'.$j)->applyFromArray($border);
		}

		$filename = 'Lista_ticketmapi.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$objWriter = \PHPExcel_IOFactory::createWriter($doc, 'Excel5');
		$objWriter->save('php://output');
	}

}
