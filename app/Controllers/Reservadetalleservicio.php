<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PaginadoModel;
use App\Models\ReservadetalleservicioModel;


class Reservadetalleservicio extends BaseController
{
	protected $paginado;
	protected $reservadetalleservicio;


	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->reservadetalleservicio = new ReservadetalleservicioModel();

	}

	public function index($bestado = 1)
	{
		$reservadetalleservicio = $this->reservadetalleservicio->getReservadetalleservicios(1, '', 20, 1);
		$total = $this->reservadetalleservicio->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'reservadetalleservicio', 'pag' => $pag, 'datos' => $reservadetalleservicio];

		echo view('layouts/header');
		echo view('layouts/aside');
		echo view('reservadetalleservicio/list', $data);
		echo view('layouts/footer');

	}
	public function agregar(){
	
		$total = $this->reservadetalleservicio->getCount('', '');
		$pag = $this->paginado->pagina(1, $total, 1);
		print_r($pag);
	}

	public function opciones(){
		$accion = (isset($_GET['accion'])) ? $_GET['accion']:'leer';
		$pag = (int)(isset($_GET['pag'])) ? $_GET['pag']:1;

		$todos = $this->request->getPost('todos');
		$texto = strtoupper(trim($this->request->getPost('texto')));

		$nidreserva = strtoupper(trim($this->request->getPost('idreserva')));
		$nidreservadetalleservicio = strtoupper(trim($this->request->getPost('idreservadetalleservicio')));
		$sdescripcion = strtoupper(trim($this->request->getPost('descripcion')));
		$tempdate = trim($this->request->getPost('fecha'));
		$tempdate = explode('/', $tempdate);
		$tfecha = date('Y-m-d', strtotime($tempdate[1].'/'.$tempdate[0].'/'.$tempdate[2]));
		$dcantidad = strtoupper(trim($this->request->getPost('cantidad')));
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
					'nidreservadetalleservicio' => intval($nidreservadetalleservicio),
					'sdescripcion' => $sdescripcion,
					'tfecha' => $tfecha,
					'dcantidad' => intval($dcantidad),
					'dprecio' => doubleval($dprecio),
					'dtotal' => doubleval($dtotal),
					'bconfirmado' => $bconfirmado,
					'bestado' => $bestado,

				);
				if ($this->reservadetalleservicio->existe($nidreservadetalleservicio) == 1) {
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->reservadetalleservicio->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'nidreserva' => intval($nidreserva),
					'sdescripcion' => $sdescripcion,
					'tfecha' => $tfecha,
					'dcantidad' => intval($dcantidad),
					'dprecio' => doubleval($dprecio),
					'dtotal' => doubleval($dtotal),
					'bconfirmado' => $bconfirmado,
					'bestado' => $bestado,

				);
				$this->reservadetalleservicio->UpdateReservadetalleservicio($nidreservadetalleservicio, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->reservadetalleservicio->UpdateReservadetalleservicio($nidreserva, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->reservadetalleservicio->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->reservadetalleservicio->getreservadetalleservicios($todos, $texto, 10, $pag)];
		echo json_encode($respt);
	}

	public function edit(){ 
		$nidreservadetalleservicio = strtoupper(trim($this->request->getPost('idreservadetalleservicio')));

		$data = $this->reservadetalleservicio->getReservadetalleservicio($nidreservadetalleservicio);
		echo json_encode($data);
	}


	public function getreservadetalleserviciosSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->reservadetalleservicio->getreservadetalleserviciosSelectNombre($searchTerm);
		echo json_encode($response);
	}


	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de reservadetalleservicio', 0, 1, 'C');
		$pdf->Output('reservadetalleservicio.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

	public function excel()
	{
		$total = $this->reservadetalleservicio->getCount();

		$reservadetalleservicio = $this->reservadetalleservicio->getReservadetalleservicios(1, '', $total, 1);
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
		$doc->getActiveSheet()->getStyle('A1:I1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF92C5FC');
		$border = array('borders' => array('allborders' => array('style' => \PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))));
		$doc->getActiveSheet()->SetCellValue('A1', 'IDRESERVA');
		$doc->getActiveSheet()->SetCellValue('B1', 'ID');
		$doc->getActiveSheet()->SetCellValue('C1', 'DESCRIPCION');
		$doc->getActiveSheet()->SetCellValue('D1', 'FECHA');
		$doc->getActiveSheet()->SetCellValue('E1', 'CANTIDAD');
		$doc->getActiveSheet()->SetCellValue('F1', 'PRECIO');
		$doc->getActiveSheet()->SetCellValue('G1', 'TOTAL');
		$doc->getActiveSheet()->SetCellValue('H1', 'CONFIRMADO');
		$doc->getActiveSheet()->SetCellValue('I1', 'ESTADO');
		$i=2;
		foreach ($reservadetalleservicio as $row) {
			$doc->getActiveSheet()->SetCellValue('A'.$i, $row['idreserva']);
			$doc->getActiveSheet()->SetCellValue('B'.$i, $row['idreservadetalleservicio']);
			$doc->getActiveSheet()->SetCellValue('C'.$i, $row['descripcion']);
			$doc->getActiveSheet()->SetCellValue('D'.$i, $row['fecha']);
			$doc->getActiveSheet()->SetCellValue('E'.$i, $row['cantidad']);
			$doc->getActiveSheet()->SetCellValue('F'.$i, $row['precio']);
			$doc->getActiveSheet()->SetCellValue('G'.$i, $row['total']);
			$doc->getActiveSheet()->SetCellValue('H'.$i, $row['confirmado']);
			$doc->getActiveSheet()->SetCellValue('I'.$i, $row['estado']);
			$i++;
		}
		$doc->getActiveSheet()->getStyle('A1:I1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++) {
			$doc->getActiveSheet()->getStyle('A'.$j.':I'.$j)->applyFromArray($border);
		}

		$filename = 'Lista_reservadetalleservicio.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$objWriter = \PHPExcel_IOFactory::createWriter($doc, 'Excel5');
		$objWriter->save('php://output');
	}

}
