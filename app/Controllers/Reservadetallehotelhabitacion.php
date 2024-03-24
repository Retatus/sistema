<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PaginadoModel;
use App\Models\ReservadetallehotelhabitacionModel;
use App\Models\HotelhabitacionModel;
use App\Models\ReservaModel;


class Reservadetallehotelhabitacion extends BaseController
{
	protected $paginado;
	protected $reservadetallehotelhabitacion;
	protected $hotelhabitacion;
	protected $reserva;


	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->reservadetallehotelhabitacion = new ReservadetallehotelhabitacionModel();
		$this->hotelhabitacion = new HotelhabitacionModel();
		$this->reserva = new ReservaModel();

	}

	public function index($bestado = 1)
	{
		$reservadetallehotelhabitacion = $this->reservadetallehotelhabitacion->getReservadetallehotelhabitacions(1, '', 10, 1);
		$total = $this->reservadetallehotelhabitacion->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'reservadetallehotelhabitacion', 'pag' => $pag, 'datos' => $reservadetallehotelhabitacion];
		$hotelhabitacion = $this->hotelhabitacion->getHotelhabitacions(1, '', 10, 1);
		$reserva = $this->reserva->getReservas(1, '', 10, 1);

		echo view('layouts/header', ['hotelhabitacions' => $hotelhabitacion, 'reservas' => $reserva]);
		echo view('layouts/aside');
		echo view('reservadetallehotelhabitacion/list', $data);
		echo view('layouts/footer');

	}
	public function agregar(){
	
		$total = $this->reservadetallehotelhabitacion->getCount('', '');
		$pag = $this->paginado->pagina(1, $total, 1);
		print_r($pag);
	}

	public function opciones(){
		$accion = (isset($_GET['accion'])) ? $_GET['accion']:'leer';
		$pag = (int)(isset($_GET['pag'])) ? $_GET['pag']:1;

		$todos = $this->request->getPost('todos');
		$texto = strtoupper(trim($this->request->getPost('texto')));

		$nidreserva = strtoupper(trim($this->request->getPost('idreserva')));
		$nidreservadetallehotelhabitacion = strtoupper(trim($this->request->getPost('idreservadetallehotelhabitacion')));
		$nidhotelhabitacion = strtoupper(trim($this->request->getPost('idhotelhabitacion')));
		$sdescripcion = strtoupper(trim($this->request->getPost('descripcion')));
		$tempdate = trim($this->request->getPost('fechaingreso'));
		$tempdate = explode('/', $tempdate);
		$tfechaingreso = date('Y-m-d', strtotime($tempdate[1].'/'.$tempdate[0].'/'.$tempdate[2]));
		$tempdate = trim($this->request->getPost('fechasalida'));
		$tempdate = explode('/', $tempdate);
		$tfechasalida = date('Y-m-d', strtotime($tempdate[1].'/'.$tempdate[0].'/'.$tempdate[2]));
		$nadultos = strtoupper(trim($this->request->getPost('adultos')));
		$nninios = strtoupper(trim($this->request->getPost('ninios')));
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
					'nidreservadetallehotelhabitacion' => intval($nidreservadetallehotelhabitacion),
					'nidhotelhabitacion' => $nidhotelhabitacion,
					'sdescripcion' => $sdescripcion,
					'tfechaingreso' => $tfechaingreso,
					'tfechasalida' => $tfechasalida,
					'nadultos' => intval($nadultos),
					'nninios' => intval($nninios),
					'ncantidad' => intval($ncantidad),
					'dprecio' => doubleval($dprecio),
					'dtotal' => doubleval($dtotal),
					'bconfirmado' => intval($bconfirmado),
					'bestado' => intval($bestado),

				);
				if ($this->reservadetallehotelhabitacion->existe($nidreservadetallehotelhabitacion,$nidhotelhabitacion,$nidreserva) == 1) {
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->reservadetallehotelhabitacion->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'nidreserva' => intval($nidreserva),
					'nidhotelhabitacion' => $nidhotelhabitacion,
					'sdescripcion' => $sdescripcion,
					'tfechaingreso' => $tfechaingreso,
					'tfechasalida' => $tfechasalida,
					'nadultos' => intval($nadultos),
					'nninios' => intval($nninios),
					'ncantidad' => intval($ncantidad),
					'dprecio' => doubleval($dprecio),
					'dtotal' => doubleval($dtotal),
					'bconfirmado' => intval($bconfirmado),
					'bestado' => intval($bestado),

				);
				$this->reservadetallehotelhabitacion->UpdateReservadetallehotelhabitacion($nidreservadetallehotelhabitacion,$nidhotelhabitacion,$nidreserva, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->reservadetallehotelhabitacion->UpdateReservadetallehotelhabitacion($nidreserva, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->reservadetallehotelhabitacion->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->reservadetallehotelhabitacion->getreservadetallehotelhabitacions($todos, $texto, 10, $pag)];
		echo json_encode($respt);
	}

	public function edit(){ 
		$nidreserva = strtoupper(trim($this->request->getPost('idreserva')));
		$nidreservadetallehotelhabitacion = strtoupper(trim($this->request->getPost('idreservadetallehotelhabitacion')));
		$nidhotelhabitacion = strtoupper(trim($this->request->getPost('idhotelhabitacion')));

		$data = $this->reservadetallehotelhabitacion->getReservadetallehotelhabitacion($nidreservadetallehotelhabitacion,$nidhotelhabitacion,$nidreserva);
		echo json_encode($data);
	}

	public function autocompletehotelhabitacions()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->hotelhabitacion->getAutocompletehotelhabitacions($todos,$keyword);
		echo json_encode($data);
	}
	public function autocompletereservas()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->reserva->getAutocompletereservas($todos,$keyword);
		echo json_encode($data);
	}

	public function getreservadetallehotelhabitacionsSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->reservadetallehotelhabitacion->getreservadetallehotelhabitacionsSelectNombre($searchTerm);
		echo json_encode($response);
	}


	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de reservadetallehotelhabitacion', 0, 1, 'C');
		$pdf->Output('reservadetallehotelhabitacion.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

	public function excel()
	{
		$total = $this->reservadetallehotelhabitacion->getCount();

		$reservadetallehotelhabitacion = $this->reservadetallehotelhabitacion->getReservadetallehotelhabitacions(1, '', $total, 1);
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
		$doc->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
		$doc->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
		$doc->getActiveSheet()->getStyle('A1:O1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF92C5FC');
		$border = array('borders' => array('allborders' => array('style' => \PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))));
		$doc->getActiveSheet()->SetCellValue('A1', 'RESERVANOMBRE');
		$doc->getActiveSheet()->SetCellValue('B1', 'IDRESERVA');
		$doc->getActiveSheet()->SetCellValue('C1', 'CATHABITACION');
		$doc->getActiveSheet()->SetCellValue('D1', 'HOTEL');
		$doc->getActiveSheet()->SetCellValue('E1', 'IDHOTELHABITACION');
		$doc->getActiveSheet()->SetCellValue('F1', 'DESCRIPCION');
		$doc->getActiveSheet()->SetCellValue('G1', 'FECHAINGRESO');
		$doc->getActiveSheet()->SetCellValue('H1', 'FECHASALIDA');
		$doc->getActiveSheet()->SetCellValue('I1', 'ADULTOS');
		$doc->getActiveSheet()->SetCellValue('J1', 'NINIOS');
		$doc->getActiveSheet()->SetCellValue('K1', 'CANTIDAD');
		$doc->getActiveSheet()->SetCellValue('L1', 'PRECIO');
		$doc->getActiveSheet()->SetCellValue('M1', 'TOTAL');
		$doc->getActiveSheet()->SetCellValue('N1', 'CONFIRMADO');
		$doc->getActiveSheet()->SetCellValue('O1', 'ESTADO');
		$i=2;
		foreach ($reservadetallehotelhabitacion as $row) {
			$doc->getActiveSheet()->SetCellValue('A'.$i, $row['reservanombre']);
			$doc->getActiveSheet()->SetCellValue('B'.$i, $row['idreserva']);
			$doc->getActiveSheet()->SetCellValue('C'.$i, $row['cathabitacion']);
			$doc->getActiveSheet()->SetCellValue('D'.$i, $row['hotel']);
			$doc->getActiveSheet()->SetCellValue('E'.$i, $row['idhotelhabitacion']);
			$doc->getActiveSheet()->SetCellValue('F'.$i, $row['descripcion']);
			$doc->getActiveSheet()->SetCellValue('G'.$i, $row['fechaingreso']);
			$doc->getActiveSheet()->SetCellValue('H'.$i, $row['fechasalida']);
			$doc->getActiveSheet()->SetCellValue('I'.$i, $row['adultos']);
			$doc->getActiveSheet()->SetCellValue('J'.$i, $row['ninios']);
			$doc->getActiveSheet()->SetCellValue('K'.$i, $row['cantidad']);
			$doc->getActiveSheet()->SetCellValue('L'.$i, $row['precio']);
			$doc->getActiveSheet()->SetCellValue('M'.$i, $row['total']);
			$doc->getActiveSheet()->SetCellValue('N'.$i, $row['confirmado']);
			$doc->getActiveSheet()->SetCellValue('O'.$i, $row['estado']);
			$i++;
		}
		$doc->getActiveSheet()->getStyle('A1:O1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++) {
			$doc->getActiveSheet()->getStyle('A'.$j.':O'.$j)->applyFromArray($border);
		}

		$filename = 'Lista_reservadetallehotelhabitacion.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$objWriter = \PHPExcel_IOFactory::createWriter($doc, 'Excel5');
		$objWriter->save('php://output');
	}

}
