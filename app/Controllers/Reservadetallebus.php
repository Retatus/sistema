<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PaginadoModel;
use App\Models\ReservadetallebusModel;
use App\Models\ReservaModel;
use App\Models\TicketbusModel;


class Reservadetallebus extends BaseController
{
	protected $paginado;
	protected $reservadetallebus;
	protected $reserva;
	protected $ticketbus;


	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->reservadetallebus = new ReservadetallebusModel();
		$this->reserva = new ReservaModel();
		$this->ticketbus = new TicketbusModel();

	}

	public function index($bestado = 1)
	{
		$reservadetallebus = $this->reservadetallebus->getReservadetallebuss(1, '', 10, 1);
		$total = $this->reservadetallebus->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'reservadetallebus', 'pag' => $pag, 'datos' => $reservadetallebus];
		$reserva = $this->reserva->getReservas(1, '', 10, 1);
		$ticketbus = $this->ticketbus->getTicketbuss(1, '', 10, 1);

		echo view('layouts/header', ['reservas' => $reserva, 'ticketbuss' => $ticketbus]);
		echo view('layouts/aside');
		echo view('reservadetallebus/list', $data);
		echo view('layouts/footer');

	}
	public function agregar(){
	
		$total = $this->reservadetallebus->getCount('', '');
		$pag = $this->paginado->pagina(1, $total, 1);
		print_r($pag);
	}

	public function opciones(){
		$accion = (isset($_GET['accion'])) ? $_GET['accion']:'leer';
		$pag = (int)(isset($_GET['pag'])) ? $_GET['pag']:1;

		$todos = $this->request->getPost('todos');
		$texto = strtoupper(trim($this->request->getPost('texto')));

		$nidreserva = strtoupper(trim($this->request->getPost('idreserva')));
		$nidreservadetalleticketbus = strtoupper(trim($this->request->getPost('idreservadetalleticketbus')));
		$nidticketbus = strtoupper(trim($this->request->getPost('idticketbus')));
		$sdescripcion = strtoupper(trim($this->request->getPost('descripcion')));
		$tempdate = trim($this->request->getPost('fecha'));
		$tempdate = explode('/', $tempdate);
		$tfecha = date('Y-m-d', strtotime($tempdate[1].'/'.$tempdate[0].'/'.$tempdate[2]));
		$ncantidad = strtoupper(trim($this->request->getPost('cantidad')));
		$dprecio = strtoupper(trim($this->request->getPost('precio')));
		$dtotal = strtoupper(trim($this->request->getPost('total')));
		$bconfirmado = strtoupper(trim($this->request->getPost('confirmado')));
		$bestado = strtoupper(trim($this->request->getPost('estado')));


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion) {
			case 'agregar':
				$data  = array(
					'nidreserva' => intval($nidreserva),
					'nidreservadetalleticketbus' => intval($nidreservadetalleticketbus),
					'nidticketbus' => $nidticketbus,
					'sdescripcion' => $sdescripcion,
					'tfecha' => $tfecha,
					'ncantidad' => intval($ncantidad),
					'dprecio' => doubleval($dprecio),
					'dtotal' => doubleval($dtotal),
					'bconfirmado' => intval($bconfirmado),
					'bestado' => intval($bestado),

				);
				if ($this->reservadetallebus->existe($nidreservadetalleticketbus,$nidreserva,$nidticketbus) == 1) {
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->reservadetallebus->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'nidreserva' => intval($nidreserva),
					'nidticketbus' => $nidticketbus,
					'sdescripcion' => $sdescripcion,
					'tfecha' => $tfecha,
					'ncantidad' => intval($ncantidad),
					'dprecio' => doubleval($dprecio),
					'dtotal' => doubleval($dtotal),
					'bconfirmado' => intval($bconfirmado),
					'bestado' => intval($bestado),

				);
				$this->reservadetallebus->UpdateReservadetallebus($nidreserva, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->reservadetallebus->UpdateReservadetallebus($nidreserva, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->reservadetallebus->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->reservadetallebus->getreservadetallebuss($todos, $texto, 10, $pag)];
		echo json_encode($respt);
	}

	public function edit(){ 
		$nidreserva = strtoupper(trim($this->request->getPost('idreserva')));
		$nidreservadetalleticketbus = strtoupper(trim($this->request->getPost('idreservadetalleticketbus')));
		$nidticketbus = strtoupper(trim($this->request->getPost('idticketbus')));

		$data = $this->reservadetallebus->getReservadetallebus($nidreserva,$nidreservadetalleticketbus,$nidticketbus);
		echo json_encode($data);
	}

	public function autocompletereservas()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->reserva->getAutocompletereservas($todos,$keyword);
		echo json_encode($data);
	}
	public function autocompleteticketbuss()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->ticketbus->getAutocompleteticketbuss($todos,$keyword);
		echo json_encode($data);
	}

	public function getreservadetallebussSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->reservadetallebus->getreservadetallebussSelectNombre($searchTerm);
		echo json_encode($response);
	}


	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de reservadetallebus', 0, 1, 'C');
		$pdf->Output('reservadetallebus.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

	public function excel()
	{
		$total = $this->reservadetallebus->getCount();

		$reservadetallebus = $this->reservadetallebus->getReservadetallebuss(1, '', $total, 1);
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
		$doc->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
		$doc->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
		$doc->getActiveSheet()->getStyle('A1:K1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF92C5FC');
		$border = array('borders' => array('allborders' => array('style' => \PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))));
		$doc->getActiveSheet()->SetCellValue('A1', 'RESERVANOMBRE');
		$doc->getActiveSheet()->SetCellValue('B1', 'IDRESERVA');
		$doc->getActiveSheet()->SetCellValue('C1', 'NOMBRE');
		$doc->getActiveSheet()->SetCellValue('D1', 'IDTICKETBUS');
		$doc->getActiveSheet()->SetCellValue('E1', 'DESCRIPCION');
		$doc->getActiveSheet()->SetCellValue('F1', 'FECHA');
		$doc->getActiveSheet()->SetCellValue('G1', 'CANTIDAD');
		$doc->getActiveSheet()->SetCellValue('H1', 'PRECIO');
		$doc->getActiveSheet()->SetCellValue('I1', 'TOTAL');
		$doc->getActiveSheet()->SetCellValue('J1', 'CONFIRMADO');
		$doc->getActiveSheet()->SetCellValue('K1', 'ESTADO');
		$i=2;
		foreach ($reservadetallebus as $row) {
			$doc->getActiveSheet()->SetCellValue('A'.$i, $row['reservanombre']);
			$doc->getActiveSheet()->SetCellValue('B'.$i, $row['idreserva']);
			$doc->getActiveSheet()->SetCellValue('C'.$i, $row['nombre']);
			$doc->getActiveSheet()->SetCellValue('D'.$i, $row['idticketbus']);
			$doc->getActiveSheet()->SetCellValue('E'.$i, $row['descripcion']);
			$doc->getActiveSheet()->SetCellValue('F'.$i, $row['fecha']);
			$doc->getActiveSheet()->SetCellValue('G'.$i, $row['cantidad']);
			$doc->getActiveSheet()->SetCellValue('H'.$i, $row['precio']);
			$doc->getActiveSheet()->SetCellValue('I'.$i, $row['total']);
			$doc->getActiveSheet()->SetCellValue('J'.$i, $row['confirmado']);
			$doc->getActiveSheet()->SetCellValue('K'.$i, $row['estado']);
			$i++;
		}
		$doc->getActiveSheet()->getStyle('A1:K1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++) {
			$doc->getActiveSheet()->getStyle('A'.$j.':K'.$j)->applyFromArray($border);
		}

		$filename = 'Lista_reservadetallebus.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$objWriter = \PHPExcel_IOFactory::createWriter($doc, 'Excel5');
		$objWriter->save('php://output');
	}

}
