<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PaginadoModel;
use App\Models\ReservadetalleotroservicioModel;
use App\Models\OtroservicioModel;
use App\Models\ReservaModel;


class Reservadetalleotroservicio extends BaseController
{
	protected $paginado;
	protected $reservadetalleotroservicio;
	protected $otroservicio;
	protected $reserva;


	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->reservadetalleotroservicio = new ReservadetalleotroservicioModel();
		$this->otroservicio = new OtroservicioModel();
		$this->reserva = new ReservaModel();

	}

	public function index($bestado = 1)
	{
		$reservadetalleotroservicio = $this->reservadetalleotroservicio->getReservadetalleotroservicios(1, '', 20, 1);
		$total = $this->reservadetalleotroservicio->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'reservadetalleotroservicio', 'pag' => $pag, 'datos' => $reservadetalleotroservicio];
		$otroservicio = $this->otroservicio->getOtroservicios(1, '', 10, 1);
		$reserva = $this->reserva->getReservas(1, '', 10, 1);

		echo view('layouts/header', ['otroservicios' => $otroservicio, 'reservas' => $reserva]);
		echo view('layouts/aside');
		echo view('reservadetalleotroservicio/list', $data);
		echo view('layouts/footer');

	}
	public function agregar(){
	
		$total = $this->reservadetalleotroservicio->getCount('', '');
		$pag = $this->paginado->pagina(1, $total, 1);
		print_r($pag);
	}

	public function opciones(){
		$accion = (isset($_GET['accion'])) ? $_GET['accion']:'leer';
		$pag = (int)(isset($_GET['pag'])) ? $_GET['pag']:1;

		$todos = $this->request->getPost('todos');
		$texto = strtoupper(trim($this->request->getPost('texto')));

		$nidreserva = strtoupper(trim($this->request->getPost('idreserva')));
		$nidreservadetalleotroservicio = strtoupper(trim($this->request->getPost('idreservadetalleotroservicio')));
		$nidotroservicio = strtoupper(trim($this->request->getPost('idotroservicio')));
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
					'nidreservadetalleotroservicio' => intval($nidreservadetalleotroservicio),
					'nidotroservicio' => intval($nidotroservicio),
					'sdescripcion' => $sdescripcion,
					'tfecha' => $tfecha,
					'ncantidad' => intval($ncantidad),
					'dprecio' => doubleval($dprecio),
					'dtotal' => doubleval($dtotal),
					'bconfirmado' => intval($bconfirmado),
					'bestado' => intval($bestado),

				);
				if ($this->reservadetalleotroservicio->existe($nidreservadetalleotroservicio,$nidotroservicio,$nidreserva) == 1) {
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->reservadetalleotroservicio->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'nidreserva' => intval($nidreserva),
					'nidotroservicio' => intval($nidotroservicio),
					'sdescripcion' => $sdescripcion,
					'tfecha' => $tfecha,
					'ncantidad' => intval($ncantidad),
					'dprecio' => doubleval($dprecio),
					'dtotal' => doubleval($dtotal),
					'bconfirmado' => intval($bconfirmado),
					'bestado' => intval($bestado),

				);
				$this->reservadetalleotroservicio->UpdateReservadetalleotroservicio($nidreservadetalleotroservicio,$nidotroservicio,$nidreserva, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->reservadetalleotroservicio->UpdateReservadetalleotroservicio($nidreserva, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->reservadetalleotroservicio->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->reservadetalleotroservicio->getreservadetalleotroservicios($todos, $texto, 10, $pag)];
		echo json_encode($respt);
	}

	public function edit(){ 
		$nidreserva = strtoupper(trim($this->request->getPost('idreserva')));
		$nidreservadetalleotroservicio = strtoupper(trim($this->request->getPost('idreservadetalleotroservicio')));
		$nidotroservicio = strtoupper(trim($this->request->getPost('idotroservicio')));

		$data = $this->reservadetalleotroservicio->getReservadetalleotroservicio($nidreservadetalleotroservicio,$nidotroservicio,$nidreserva);
		echo json_encode($data);
	}

	public function autocompleteotroservicios()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->otroservicio->getAutocompleteotroservicios($todos,$keyword);
		echo json_encode($data);
	}
	public function autocompletereservas()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->reserva->getAutocompletereservas($todos,$keyword);
		echo json_encode($data);
	}

	public function getreservadetalleotroserviciosSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->reservadetalleotroservicio->getreservadetalleotroserviciosSelectNombre($searchTerm);
		echo json_encode($response);
	}


	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de reservadetalleotroservicio', 0, 1, 'C');
		$pdf->Output('reservadetalleotroservicio.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

	public function excel()
	{
		$total = $this->reservadetalleotroservicio->getCount();

		$reservadetalleotroservicio = $this->reservadetalleotroservicio->getReservadetalleotroservicios(1, '', $total, 1);
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
		$doc->getActiveSheet()->SetCellValue('C1', 'OTROSERVICIONOMBRE');
		$doc->getActiveSheet()->SetCellValue('D1', 'IDOTROSERVICIO');
		$doc->getActiveSheet()->SetCellValue('E1', 'DESCRIPCION');
		$doc->getActiveSheet()->SetCellValue('F1', 'FECHA');
		$doc->getActiveSheet()->SetCellValue('G1', 'CANTIDAD');
		$doc->getActiveSheet()->SetCellValue('H1', 'PRECIO');
		$doc->getActiveSheet()->SetCellValue('I1', 'TOTAL');
		$doc->getActiveSheet()->SetCellValue('J1', 'CONFIRMADO');
		$doc->getActiveSheet()->SetCellValue('K1', 'ESTADO');
		$i=2;
		foreach ($reservadetalleotroservicio as $row) {
			$doc->getActiveSheet()->SetCellValue('A'.$i, $row['reservanombre']);
			$doc->getActiveSheet()->SetCellValue('B'.$i, $row['idreserva']);
			$doc->getActiveSheet()->SetCellValue('C'.$i, $row['otroservicionombre']);
			$doc->getActiveSheet()->SetCellValue('D'.$i, $row['idotroservicio']);
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

		$filename = 'Lista_reservadetalleotroservicio.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$objWriter = \PHPExcel_IOFactory::createWriter($doc, 'Excel5');
		$objWriter->save('php://output');
	}

}
