<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PaginadoModel;
use App\Models\HorarioticketmapiModel;
use App\Models\ClientetipoModel;
use App\Models\HoraticketmapiModel;
use App\Models\TicketmapiModel;


class Horarioticketmapi extends BaseController
{
	protected $paginado;
	protected $horarioticketmapi;
	protected $clientetipo;
	protected $horaticketmapi;
	protected $ticketmapi;


	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->horarioticketmapi = new HorarioticketmapiModel();
		$this->clientetipo = new ClientetipoModel();
		$this->horaticketmapi = new HoraticketmapiModel();
		$this->ticketmapi = new TicketmapiModel();

	}

	public function index($bestado = 1)
	{
		$horarioticketmapi = $this->horarioticketmapi->getHorarioticketmapis(1, '', 10, 1);
		$total = $this->horarioticketmapi->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'horarioticketmapi', 'pag' => $pag, 'datos' => $horarioticketmapi];
		$clientetipo = $this->clientetipo->getClientetipos(1, '', 10, 1);
		$horaticketmapi = $this->horaticketmapi->getHoraticketmapis(1, '', 10, 1);
		$ticketmapi = $this->ticketmapi->getTicketmapis(1, '', 10, 1);

		echo view('layouts/header', ['clientetipos' => $clientetipo, 'horaticketmapis' => $horaticketmapi, 'ticketmapis' => $ticketmapi]);
		echo view('layouts/aside');
		echo view('horarioticketmapi/list', $data);
		echo view('layouts/footer');

	}
	public function agregar(){
	
		$total = $this->horarioticketmapi->getCount('', '');
		$pag = $this->paginado->pagina(1, $total, 1);
		print_r($pag);
	}

	public function opciones(){
		$accion = (isset($_GET['accion'])) ? $_GET['accion']:'leer';
		$pag = (int)(isset($_GET['pag'])) ? $_GET['pag']:1;

		$todos = $this->request->getPost('todos');
		$texto = strtoupper(trim($this->request->getPost('texto')));

		$nidhorarioticketmapi = strtoupper(trim($this->request->getPost('idhorarioticketmapi')));
		$nidhoraticketmapi = strtoupper(trim($this->request->getPost('idhoraticketmapi')));
		$nidticketmapi = strtoupper(trim($this->request->getPost('idticketmapi')));
		$nidclientetipo = strtoupper(trim($this->request->getPost('idclientetipo')));
		$dprecio = strtoupper(trim($this->request->getPost('precio')));
		$bestado = strtoupper(trim($this->request->getPost('estado')));


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion) {
			case 'agregar':
				$data  = array(
					'nidhorarioticketmapi' => $nidhorarioticketmapi,
					'nidhoraticketmapi' => $nidhoraticketmapi,
					'nidticketmapi' => $nidticketmapi,
					'nidclientetipo' => intval($nidclientetipo),
					'dprecio' => doubleval($dprecio),
					'bestado' => intval($bestado),

				);
				if ($this->horarioticketmapi->existe($nidhorarioticketmapi,$nidclientetipo,$nidhoraticketmapi,$nidticketmapi) == 1) {
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->horarioticketmapi->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'nidhoraticketmapi' => $nidhoraticketmapi,
					'nidticketmapi' => $nidticketmapi,
					'nidclientetipo' => intval($nidclientetipo),
					'dprecio' => doubleval($dprecio),
					'bestado' => intval($bestado),

				);
				$this->horarioticketmapi->UpdateHorarioticketmapi($nidhorarioticketmapi, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->horarioticketmapi->UpdateHorarioticketmapi($nidhorarioticketmapi, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->horarioticketmapi->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->horarioticketmapi->gethorarioticketmapis($todos, $texto, 10, $pag)];
		echo json_encode($respt);
	}

	public function edit(){ 
		$nidhorarioticketmapi = strtoupper(trim($this->request->getPost('idhorarioticketmapi')));
		$nidhoraticketmapi = strtoupper(trim($this->request->getPost('idhoraticketmapi')));
		$nidticketmapi = strtoupper(trim($this->request->getPost('idticketmapi')));
		$nidclientetipo = strtoupper(trim($this->request->getPost('idclientetipo')));

		$data = $this->horarioticketmapi->getHorarioticketmapi($nidhorarioticketmapi,$nidhoraticketmapi,$nidticketmapi,$nidclientetipo);
		echo json_encode($data);
	}

	public function autocompleteclientetipos()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->clientetipo->getAutocompleteclientetipos($todos,$keyword);
		echo json_encode($data);
	}
	public function autocompletehoraticketmapis()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->horaticketmapi->getAutocompletehoraticketmapis($todos,$keyword);
		echo json_encode($data);
	}
	public function autocompleteticketmapis()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->ticketmapi->getAutocompleteticketmapis($todos,$keyword);
		echo json_encode($data);
	}

	public function gethorarioticketmapisSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->horarioticketmapi->gethorarioticketmapisSelectNombre($searchTerm);
		echo json_encode($response);
	}


	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de horarioticketmapi', 0, 1, 'C');
		$pdf->Output('horarioticketmapi.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

	public function excel()
	{
		$total = $this->horarioticketmapi->getCount();

		$horarioticketmapi = $this->horarioticketmapi->getHorarioticketmapis(1, '', $total, 1);
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
		$doc->getActiveSheet()->getStyle('A1:H1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF92C5FC');
		$border = array('borders' => array('allborders' => array('style' => \PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))));
		$doc->getActiveSheet()->SetCellValue('A1', 'NOMBRE');
		$doc->getActiveSheet()->SetCellValue('B1', 'IDHORATICKETMAPI');
		$doc->getActiveSheet()->SetCellValue('C1', 'NOMBRE');
		$doc->getActiveSheet()->SetCellValue('D1', 'IDTICKETMAPI');
		$doc->getActiveSheet()->SetCellValue('E1', 'NOMBRE');
		$doc->getActiveSheet()->SetCellValue('F1', 'IDCLIENTETIPO');
		$doc->getActiveSheet()->SetCellValue('G1', 'PRECIO');
		$doc->getActiveSheet()->SetCellValue('H1', 'ESTADO');
		$i=2;
		foreach ($horarioticketmapi as $row) {
			$doc->getActiveSheet()->SetCellValue('A'.$i, $row['nombre']);
			$doc->getActiveSheet()->SetCellValue('B'.$i, $row['idhoraticketmapi']);
			$doc->getActiveSheet()->SetCellValue('C'.$i, $row['nombre']);
			$doc->getActiveSheet()->SetCellValue('D'.$i, $row['idticketmapi']);
			$doc->getActiveSheet()->SetCellValue('E'.$i, $row['nombre']);
			$doc->getActiveSheet()->SetCellValue('F'.$i, $row['idclientetipo']);
			$doc->getActiveSheet()->SetCellValue('G'.$i, $row['precio']);
			$doc->getActiveSheet()->SetCellValue('H'.$i, $row['estado']);
			$i++;
		}
		$doc->getActiveSheet()->getStyle('A1:H1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++) {
			$doc->getActiveSheet()->getStyle('A'.$j.':H'.$j)->applyFromArray($border);
		}

		$filename = 'Lista_horarioticketmapi.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$objWriter = \PHPExcel_IOFactory::createWriter($doc, 'Excel5');
		$objWriter->save('php://output');
	}

}
