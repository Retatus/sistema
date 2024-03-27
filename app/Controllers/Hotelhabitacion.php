<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PaginadoModel;
use App\Models\HotelhabitacionModel;
use App\Models\CathabitacionModel;
use App\Models\HotelModel;


class Hotelhabitacion extends BaseController
{
	protected $paginado;
	protected $hotelhabitacion;
	protected $cathabitacion;
	protected $hotel;


	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->hotelhabitacion = new HotelhabitacionModel();
		$this->cathabitacion = new CathabitacionModel();
		$this->hotel = new HotelModel();

	}

	public function index($bestado = 1)
	{
		$hotelhabitacion = $this->hotelhabitacion->getHotelhabitacions(1, '', 20, 1);
		$total = $this->hotelhabitacion->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'hotelhabitacion', 'pag' => $pag, 'datos' => $hotelhabitacion];
		$cathabitacion = $this->cathabitacion->getCathabitacions(1, '', 10, 1);
		$hotel = $this->hotel->getHotels(1, '', 10, 1);

		echo view('layouts/header', ['cathabitacions' => $cathabitacion, 'hotels' => $hotel]);
		echo view('layouts/aside');
		echo view('hotelhabitacion/list', $data);
		echo view('layouts/footer');

	}
	public function agregar(){
	
		$total = $this->hotelhabitacion->getCount('', '');
		$pag = $this->paginado->pagina(1, $total, 1);
		print_r($pag);
	}

	public function opciones(){
		$accion = (isset($_GET['accion'])) ? $_GET['accion']:'leer';
		$pag = (int)(isset($_GET['pag'])) ? $_GET['pag']:1;

		$todos = $this->request->getPost('todos');
		$texto = strtoupper(trim($this->request->getPost('texto')));

		$nidhotelhabitacion = strtoupper(trim($this->request->getPost('idhotelhabitacion')));
		$sidhotel = strtoupper(trim($this->request->getPost('idhotel')));
		$nidcathabitacion = strtoupper(trim($this->request->getPost('idcathabitacion')));
		$dprecio = strtoupper(trim($this->request->getPost('precio')));
		$tempdate = trim($this->request->getPost('fecha'));
		$tempdate = explode('/', $tempdate);
		$tfecha = date('Y-m-d', strtotime($tempdate[1].'/'.$tempdate[0].'/'.$tempdate[2]));
		$bestado = strtoupper(trim($this->request->getPost('estado')));
		$bconfirmado = strtoupper(trim($this->request->getPost('confirmado')));


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion) {
			case 'agregar':
				$data  = array(
					'nidhotelhabitacion' => $nidhotelhabitacion,
					'sidhotel' => $sidhotel,
					'nidcathabitacion' => $nidcathabitacion,
					'dprecio' => doubleval($dprecio),
					'tfecha' => $tfecha,
					'bestado' => intval($bestado),
					'bconfirmado' => intval($bconfirmado),

				);
				if ($this->hotelhabitacion->existe($nidhotelhabitacion,$nidcathabitacion,$sidhotel) == 1) {
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->hotelhabitacion->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'sidhotel' => $sidhotel,
					'nidcathabitacion' => $nidcathabitacion,
					'dprecio' => doubleval($dprecio),
					'tfecha' => $tfecha,
					'bestado' => intval($bestado),
					'bconfirmado' => intval($bconfirmado),

				);
				$this->hotelhabitacion->UpdateHotelhabitacion($nidhotelhabitacion,$nidcathabitacion,$sidhotel, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->hotelhabitacion->UpdateHotelhabitacion($nidhotelhabitacion, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->hotelhabitacion->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->hotelhabitacion->gethotelhabitacions($todos, $texto, 20, $pag)];
		echo json_encode($respt);
	}

	public function edit(){ 
		$nidhotelhabitacion = strtoupper(trim($this->request->getPost('idhotelhabitacion')));
		$sidhotel = strtoupper(trim($this->request->getPost('idhotel')));
		$nidcathabitacion = strtoupper(trim($this->request->getPost('idcathabitacion')));

		$data = $this->hotelhabitacion->getHotelhabitacion($nidhotelhabitacion,$nidcathabitacion,$sidhotel);
		echo json_encode($data);
	}

	public function autocompletecathabitacions()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->cathabitacion->getAutocompletecathabitacions($todos,$keyword);
		echo json_encode($data);
	}
	public function autocompletehotels()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->hotel->getAutocompletehotels($todos,$keyword);
		echo json_encode($data);
	}

	public function gethotelhabitacionsSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->hotelhabitacion->gethotelhabitacionsSelectNombre($searchTerm);
		echo json_encode($response);
	}


	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de hotelhabitacion', 0, 1, 'C');
		$pdf->Output('hotelhabitacion.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

	public function excel()
	{
		$total = $this->hotelhabitacion->getCount();

		$hotelhabitacion = $this->hotelhabitacion->getHotelhabitacions(1, '', $total, 1);
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
		$doc->getActiveSheet()->getStyle('A1:J1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF92C5FC');
		$border = array('borders' => array('allborders' => array('style' => \PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))));
		$doc->getActiveSheet()->SetCellValue('A1', 'NOMBRE');
		$doc->getActiveSheet()->SetCellValue('B1', 'BANCO');
		$doc->getActiveSheet()->SetCellValue('C1', 'CATHOTEL');
		$doc->getActiveSheet()->SetCellValue('D1', 'IDHOTEL');
		$doc->getActiveSheet()->SetCellValue('E1', 'NOMBRE');
		$doc->getActiveSheet()->SetCellValue('F1', 'IDCATHABITACION');
		$doc->getActiveSheet()->SetCellValue('G1', 'PRECIO');
		$doc->getActiveSheet()->SetCellValue('H1', 'FECHA');
		$doc->getActiveSheet()->SetCellValue('I1', 'ESTADO');
		$doc->getActiveSheet()->SetCellValue('J1', 'CONFIRMADO');
		$i=2;
		foreach ($hotelhabitacion as $row) {
			$doc->getActiveSheet()->SetCellValue('A'.$i, $row['nombre']);
			$doc->getActiveSheet()->SetCellValue('B'.$i, $row['banco']);
			$doc->getActiveSheet()->SetCellValue('C'.$i, $row['cathotel']);
			$doc->getActiveSheet()->SetCellValue('D'.$i, $row['idhotel']);
			$doc->getActiveSheet()->SetCellValue('E'.$i, $row['nombre']);
			$doc->getActiveSheet()->SetCellValue('F'.$i, $row['idcathabitacion']);
			$doc->getActiveSheet()->SetCellValue('G'.$i, $row['precio']);
			$doc->getActiveSheet()->SetCellValue('H'.$i, $row['fecha']);
			$doc->getActiveSheet()->SetCellValue('I'.$i, $row['estado']);
			$doc->getActiveSheet()->SetCellValue('J'.$i, $row['confirmado']);
			$i++;
		}
		$doc->getActiveSheet()->getStyle('A1:J1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++) {
			$doc->getActiveSheet()->getStyle('A'.$j.':J'.$j)->applyFromArray($border);
		}

		$filename = 'Lista_hotelhabitacion.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$objWriter = \PHPExcel_IOFactory::createWriter($doc, 'Excel5');
		$objWriter->save('php://output');
	}

}
