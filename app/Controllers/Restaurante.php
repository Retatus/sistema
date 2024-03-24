<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PaginadoModel;
use App\Models\RestauranteModel;


class Restaurante extends BaseController
{
	protected $paginado;
	protected $restaurante;


	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->restaurante = new RestauranteModel();

	}

	public function index($bestado = 1)
	{
		$restaurante = $this->restaurante->getRestaurantes(1, '', 20, 1);
		$total = $this->restaurante->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'restaurante', 'pag' => $pag, 'datos' => $restaurante];

		echo view('layouts/header');
		echo view('layouts/aside');
		echo view('restaurante/list', $data);
		echo view('layouts/footer');

	}
	public function agregar(){
	
		$total = $this->restaurante->getCount('', '');
		$pag = $this->paginado->pagina(1, $total, 1);
		print_r($pag);
	}

	public function opciones(){
		$accion = (isset($_GET['accion'])) ? $_GET['accion']:'leer';
		$pag = (int)(isset($_GET['pag'])) ? $_GET['pag']:1;

		$todos = $this->request->getPost('todos');
		$texto = strtoupper(trim($this->request->getPost('texto')));

		$sidtrestaurante = strtoupper(trim($this->request->getPost('idtrestaurante')));
		$srestaurantenombre = strtoupper(trim($this->request->getPost('restaurantenombre')));
		$nidrestaurantecategoria = strtoupper(trim($this->request->getPost('idrestaurantecategoria')));
		$srestaurantedireccion = strtoupper(trim($this->request->getPost('restaurantedireccion')));
		$srestaurantetelefono = strtoupper(trim($this->request->getPost('restaurantetelefono')));
		$srestaurantecorreo = strtoupper(trim($this->request->getPost('restaurantecorreo')));
		$srestauranteruc = strtoupper(trim($this->request->getPost('restauranteruc')));
		$srestauranterazon = strtoupper(trim($this->request->getPost('restauranterazon')));
		$srestaurantenrocuenta = strtoupper(trim($this->request->getPost('restaurantenrocuenta')));
		$srestauranteubigeo = strtoupper(trim($this->request->getPost('restauranteubigeo')));
		$drestaurantelatitud = strtoupper(trim($this->request->getPost('restaurantelatitud')));
		$drestaurantelongitud = strtoupper(trim($this->request->getPost('restaurantelongitud')));
		$brestauranteestado = strtoupper(trim($this->request->getPost('restauranteestado')));


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion) {
			case 'agregar':
				$data  = array(
					'sidtrestaurante' => $sidtrestaurante,
					'srestaurantenombre' => $srestaurantenombre,
					'nidrestaurantecategoria' => $nidrestaurantecategoria,
					'srestaurantedireccion' => $srestaurantedireccion,
					'srestaurantetelefono' => $srestaurantetelefono,
					'srestaurantecorreo' => $srestaurantecorreo,
					'srestauranteruc' => $srestauranteruc,
					'srestauranterazon' => $srestauranterazon,
					'srestaurantenrocuenta' => $srestaurantenrocuenta,
					'srestauranteubigeo' => $srestauranteubigeo,
					'drestaurantelatitud' => doubleval($drestaurantelatitud),
					'drestaurantelongitud' => doubleval($drestaurantelongitud),
					'brestauranteestado' => intval($brestauranteestado),

				);
				if ($this->restaurante->existe($sidtrestaurante) == 1) {
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->restaurante->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'srestaurantenombre' => $srestaurantenombre,
					'nidrestaurantecategoria' => $nidrestaurantecategoria,
					'srestaurantedireccion' => $srestaurantedireccion,
					'srestaurantetelefono' => $srestaurantetelefono,
					'srestaurantecorreo' => $srestaurantecorreo,
					'srestauranteruc' => $srestauranteruc,
					'srestauranterazon' => $srestauranterazon,
					'srestaurantenrocuenta' => $srestaurantenrocuenta,
					'srestauranteubigeo' => $srestauranteubigeo,
					'drestaurantelatitud' => doubleval($drestaurantelatitud),
					'drestaurantelongitud' => doubleval($drestaurantelongitud),
					'brestauranteestado' => intval($brestauranteestado),

				);
				$this->restaurante->UpdateRestaurante($sidtrestaurante, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->restaurante->UpdateRestaurante($sidtrestaurante, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->restaurante->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->restaurante->getrestaurantes($todos, $texto, 10, $pag)];
		echo json_encode($respt);
	}

	public function edit(){ 
		$sidtrestaurante = strtoupper(trim($this->request->getPost('idtrestaurante')));

		$data = $this->restaurante->getRestaurante($sidtrestaurante);
		echo json_encode($data);
	}


	public function getrestaurantesSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->restaurante->getrestaurantesSelectNombre($searchTerm);
		echo json_encode($response);
	}


	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de restaurante', 0, 1, 'C');
		$pdf->Output('restaurante.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

	public function excel()
	{
		$total = $this->restaurante->getCount();

		$restaurante = $this->restaurante->getRestaurantes(1, '', $total, 1);
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
		$doc->getActiveSheet()->SetCellValue('A1', 'IDT');
		$doc->getActiveSheet()->SetCellValue('B1', 'NOMBRE');
		$doc->getActiveSheet()->SetCellValue('C1', 'IDCATEGORIA');
		$doc->getActiveSheet()->SetCellValue('D1', 'DIRECCION');
		$doc->getActiveSheet()->SetCellValue('E1', 'TELEFONO');
		$doc->getActiveSheet()->SetCellValue('F1', 'CORREO');
		$doc->getActiveSheet()->SetCellValue('G1', 'RUC');
		$doc->getActiveSheet()->SetCellValue('H1', 'RAZON');
		$doc->getActiveSheet()->SetCellValue('I1', 'NROCUENTA');
		$doc->getActiveSheet()->SetCellValue('J1', 'UBIGEO');
		$doc->getActiveSheet()->SetCellValue('K1', 'LATITUD');
		$doc->getActiveSheet()->SetCellValue('L1', 'LONGITUD');
		$doc->getActiveSheet()->SetCellValue('M1', 'ESTADO');
		$i=2;
		foreach ($restaurante as $row) {
			$doc->getActiveSheet()->SetCellValue('A'.$i, $row['idtrestaurante']);
			$doc->getActiveSheet()->SetCellValue('B'.$i, $row['restaurantenombre']);
			$doc->getActiveSheet()->SetCellValue('C'.$i, $row['idrestaurantecategoria']);
			$doc->getActiveSheet()->SetCellValue('D'.$i, $row['restaurantedireccion']);
			$doc->getActiveSheet()->SetCellValue('E'.$i, $row['restaurantetelefono']);
			$doc->getActiveSheet()->SetCellValue('F'.$i, $row['restaurantecorreo']);
			$doc->getActiveSheet()->SetCellValue('G'.$i, $row['restauranteruc']);
			$doc->getActiveSheet()->SetCellValue('H'.$i, $row['restauranterazon']);
			$doc->getActiveSheet()->SetCellValue('I'.$i, $row['restaurantenrocuenta']);
			$doc->getActiveSheet()->SetCellValue('J'.$i, $row['restauranteubigeo']);
			$doc->getActiveSheet()->SetCellValue('K'.$i, $row['restaurantelatitud']);
			$doc->getActiveSheet()->SetCellValue('L'.$i, $row['restaurantelongitud']);
			$doc->getActiveSheet()->SetCellValue('M'.$i, $row['restauranteestado']);
			$i++;
		}
		$doc->getActiveSheet()->getStyle('A1:M1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++) {
			$doc->getActiveSheet()->getStyle('A'.$j.':M'.$j)->applyFromArray($border);
		}

		$filename = 'Lista_restaurante.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$objWriter = \PHPExcel_IOFactory::createWriter($doc, 'Excel5');
		$objWriter->save('php://output');
	}

}
