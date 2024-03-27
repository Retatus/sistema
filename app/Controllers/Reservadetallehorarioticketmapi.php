<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PaginadoModel;
use App\Models\ReservadetallehorarioticketmapiModel;
use App\Models\HorarioticketmapiModel;
use App\Models\ReservaModel;


class Reservadetallehorarioticketmapi extends BaseController
{
	protected $paginado;
	protected $reservadetallehorarioticketmapi;
	protected $horarioticketmapi;
	protected $reserva;


	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->reservadetallehorarioticketmapi = new ReservadetallehorarioticketmapiModel();
		$this->horarioticketmapi = new HorarioticketmapiModel();
		$this->reserva = new ReservaModel();

	}

	public function index($bestado = 1)
	{
		$reservadetallehorarioticketmapi = $this->reservadetallehorarioticketmapi->getReservadetallehorarioticketmapis(1, '', 20, 1);
		$total = $this->reservadetallehorarioticketmapi->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'reservadetallehorarioticketmapi', 'pag' => $pag, 'datos' => $reservadetallehorarioticketmapi];
		$horarioticketmapi = $this->horarioticketmapi->getHorarioticketmapis(1, '', 10, 1);
		$reserva = $this->reserva->getReservas(1, '', 10, 1);

		echo view('layouts/header', ['horarioticketmapis' => $horarioticketmapi, 'reservas' => $reserva]);
		echo view('layouts/aside');
		echo view('reservadetallehorarioticketmapi/list', $data);
		echo view('layouts/footer');

	}
	public function agregar(){
	
		$total = $this->reservadetallehorarioticketmapi->getCount('', '');
		$pag = $this->paginado->pagina(1, $total, 1);
		print_r($pag);
	}

	public function opciones(){
		$accion = (isset($_GET['accion'])) ? $_GET['accion']:'leer';
		$pag = (int)(isset($_GET['pag'])) ? $_GET['pag']:1;

		$todos = $this->request->getPost('todos');
		$texto = strtoupper(trim($this->request->getPost('texto')));

		$nidreserva = strtoupper(trim($this->request->getPost('idreserva')));
		$nidreservadetallehorarioticketmapi = strtoupper(trim($this->request->getPost('idreservadetallehorarioticketmapi')));
		$nidhorarioticketmapi = strtoupper(trim($this->request->getPost('idhorarioticketmapi')));
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
					'nidreservadetallehorarioticketmapi' => intval($nidreservadetallehorarioticketmapi),
					'nidhorarioticketmapi' => $nidhorarioticketmapi,
					'sdescripcion' => $sdescripcion,
					'tfecha' => $tfecha,
					'ncantidad' => intval($ncantidad),
					'dprecio' => doubleval($dprecio),
					'dtotal' => doubleval($dtotal),
					'bconfirmado' => intval($bconfirmado),
					'bestado' => intval($bestado),

				);
				if ($this->reservadetallehorarioticketmapi->existe($nidreservadetallehorarioticketmapi,$nidhorarioticketmapi,$nidreserva) == 1) {
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->reservadetallehorarioticketmapi->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'nidreserva' => intval($nidreserva),
					'nidhorarioticketmapi' => $nidhorarioticketmapi,
					'sdescripcion' => $sdescripcion,
					'tfecha' => $tfecha,
					'ncantidad' => intval($ncantidad),
					'dprecio' => doubleval($dprecio),
					'dtotal' => doubleval($dtotal),
					'bconfirmado' => intval($bconfirmado),
					'bestado' => intval($bestado),

				);
				$this->reservadetallehorarioticketmapi->UpdateReservadetallehorarioticketmapi($nidreservadetallehorarioticketmapi,$nidhorarioticketmapi,$nidreserva, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->reservadetallehorarioticketmapi->UpdateReservadetallehorarioticketmapi($nidreserva, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->reservadetallehorarioticketmapi->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->reservadetallehorarioticketmapi->getreservadetallehorarioticketmapis($todos, $texto, 20, $pag)];
		echo json_encode($respt);
	}

	public function edit(){ 
		$nidreserva = strtoupper(trim($this->request->getPost('idreserva')));
		$nidreservadetallehorarioticketmapi = strtoupper(trim($this->request->getPost('idreservadetallehorarioticketmapi')));
		$nidhorarioticketmapi = strtoupper(trim($this->request->getPost('idhorarioticketmapi')));

		$data = $this->reservadetallehorarioticketmapi->getReservadetallehorarioticketmapi($nidreservadetallehorarioticketmapi,$nidhorarioticketmapi,$nidreserva);
		echo json_encode($data);
	}

	public function autocompletehorarioticketmapis()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->horarioticketmapi->getAutocompletehorarioticketmapis($todos,$keyword);
		echo json_encode($data);
	}
	public function autocompletereservas()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->reserva->getAutocompletereservas($todos,$keyword);
		echo json_encode($data);
	}

	public function getreservadetallehorarioticketmapisSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->reservadetallehorarioticketmapi->getreservadetallehorarioticketmapisSelectNombre($searchTerm);
		echo json_encode($response);
	}


	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de reservadetallehorarioticketmapi', 0, 1, 'C');
		$pdf->Output('reservadetallehorarioticketmapi.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

	public function excel()
	{
		$total = $this->reservadetallehorarioticketmapi->getCount();

		$reservadetallehorarioticketmapi = $this->reservadetallehorarioticketmapi->getReservadetallehorarioticketmapis(1, '', $total, 1);
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
		$doc->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
		$doc->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
		$doc->getActiveSheet()->getStyle('A1:M1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF92C5FC');
		$border = array('borders' => array('allborders' => array('style' => \PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))));
		$doc->getActiveSheet()->SetCellValue('A1', 'RESERVANOMBRE');
		$doc->getActiveSheet()->SetCellValue('B1', 'IDRESERVA');
		$doc->getActiveSheet()->SetCellValue('C1', 'CLIENTETIPO');
		$doc->getActiveSheet()->SetCellValue('D1', 'HORATICKETMAPI');
		$doc->getActiveSheet()->SetCellValue('E1', 'TICKETMAPI');
		$doc->getActiveSheet()->SetCellValue('F1', 'IDHORARIOTICKETMAPI');
		$doc->getActiveSheet()->SetCellValue('G1', 'DESCRIPCION');
		$doc->getActiveSheet()->SetCellValue('H1', 'FECHA');
		$doc->getActiveSheet()->SetCellValue('I1', 'CANTIDAD');
		$doc->getActiveSheet()->SetCellValue('J1', 'PRECIO');
		$doc->getActiveSheet()->SetCellValue('K1', 'TOTAL');
		$doc->getActiveSheet()->SetCellValue('L1', 'CONFIRMADO');
		$doc->getActiveSheet()->SetCellValue('M1', 'ESTADO');
		$i=2;
		foreach ($reservadetallehorarioticketmapi as $row) {
			$doc->getActiveSheet()->SetCellValue('A'.$i, $row['reservanombre']);
			$doc->getActiveSheet()->SetCellValue('B'.$i, $row['idreserva']);
			$doc->getActiveSheet()->SetCellValue('C'.$i, $row['clientetipo']);
			$doc->getActiveSheet()->SetCellValue('D'.$i, $row['horaticketmapi']);
			$doc->getActiveSheet()->SetCellValue('E'.$i, $row['ticketmapi']);
			$doc->getActiveSheet()->SetCellValue('F'.$i, $row['idhorarioticketmapi']);
			$doc->getActiveSheet()->SetCellValue('G'.$i, $row['descripcion']);
			$doc->getActiveSheet()->SetCellValue('H'.$i, $row['fecha']);
			$doc->getActiveSheet()->SetCellValue('I'.$i, $row['cantidad']);
			$doc->getActiveSheet()->SetCellValue('J'.$i, $row['precio']);
			$doc->getActiveSheet()->SetCellValue('K'.$i, $row['total']);
			$doc->getActiveSheet()->SetCellValue('L'.$i, $row['confirmado']);
			$doc->getActiveSheet()->SetCellValue('M'.$i, $row['estado']);
			$i++;
		}
		$doc->getActiveSheet()->getStyle('A1:M1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++) {
			$doc->getActiveSheet()->getStyle('A'.$j.':M'.$j)->applyFromArray($border);
		}

		$filename = 'Lista_reservadetallehorarioticketmapi.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$objWriter = \PHPExcel_IOFactory::createWriter($doc, 'Excel5');
		$objWriter->save('php://output');
	}

}
