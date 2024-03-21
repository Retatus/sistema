<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PaginadoModel;
use App\Models\HotelModel;
use App\Models\BancoModel;
use App\Models\CathotelModel;


class Hotel extends BaseController
{
	protected $paginado;
	protected $hotel;
	protected $banco;
	protected $cathotel;


	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->hotel = new HotelModel();
		$this->banco = new BancoModel();
		$this->cathotel = new CathotelModel();

	}

	public function index($bestado = 1)
	{
		$hotel = $this->hotel->getHotels(1, '', 10, 1);
		$total = $this->hotel->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'hotel', 'pag' => $pag, 'datos' => $hotel];
		$banco = $this->banco->getBancos(1, '', 10, 1);
		$cathotel = $this->cathotel->getCathotels(1, '', 10, 1);

		echo view('layouts/header', ['bancos' => $banco, 'cathotels' => $cathotel]);
		echo view('layouts/aside');
		echo view('hotel/list', $data);
		echo view('layouts/footer');

	}
	public function agregar(){
	
		$total = $this->hotel->getCount('', '');
		$pag = $this->paginado->pagina(1, $total, 1);
		print_r($pag);
	}

	public function opciones(){
		$accion = (isset($_GET['accion'])) ? $_GET['accion']:'leer';
		$pag = (int)(isset($_GET['pag'])) ? $_GET['pag']:1;

		$todos = $this->request->getPost('todos');
		$texto = strtoupper(trim($this->request->getPost('texto')));

		$sidhotel = strtoupper(trim($this->request->getPost('idhotel')));
		$snombre = strtoupper(trim($this->request->getPost('nombre')));
		$nidcathotel = strtoupper(trim($this->request->getPost('idcathotel')));
		$sdireccion = strtoupper(trim($this->request->getPost('direccion')));
		$stelefono = strtoupper(trim($this->request->getPost('telefono')));
		$scorreo = strtoupper(trim($this->request->getPost('correo')));
		$sruc = strtoupper(trim($this->request->getPost('ruc')));
		$srazonsocial = strtoupper(trim($this->request->getPost('razonsocial')));
		$snrocuenta = strtoupper(trim($this->request->getPost('nrocuenta')));
		$nidbanco = strtoupper(trim($this->request->getPost('idbanco')));
		$subigeo = strtoupper(trim($this->request->getPost('ubigeo')));
		$dlatitud = strtoupper(trim($this->request->getPost('latitud')));
		$dlongitud = strtoupper(trim($this->request->getPost('longitud')));
		$bestado = strtoupper(trim($this->request->getPost('estado')));


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion) {
			case 'agregar':
				$data  = array(
					'sidhotel' => $sidhotel,
					'snombre' => $snombre,
					'nidcathotel' => $nidcathotel,
					'sdireccion' => $sdireccion,
					'stelefono' => $stelefono,
					'scorreo' => $scorreo,
					'sruc' => $sruc,
					'srazonsocial' => $srazonsocial,
					'snrocuenta' => $snrocuenta,
					'nidbanco' => intval($nidbanco),
					'subigeo' => $subigeo,
					'dlatitud' => doubleval($dlatitud),
					'dlongitud' => doubleval($dlongitud),
					'bestado' => intval($bestado),

				);
				if ($this->hotel->existe($sidhotel,$nidbanco,$nidcathotel) == 1) {
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->hotel->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'snombre' => $snombre,
					'nidcathotel' => $nidcathotel,
					'sdireccion' => $sdireccion,
					'stelefono' => $stelefono,
					'scorreo' => $scorreo,
					'sruc' => $sruc,
					'srazonsocial' => $srazonsocial,
					'snrocuenta' => $snrocuenta,
					'nidbanco' => intval($nidbanco),
					'subigeo' => $subigeo,
					'dlatitud' => doubleval($dlatitud),
					'dlongitud' => doubleval($dlongitud),
					'bestado' => intval($bestado),

				);
				$this->hotel->UpdateHotel($sidhotel, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->hotel->UpdateHotel($sidhotel, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->hotel->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->hotel->gethotels($todos, $texto, 10, $pag)];
		echo json_encode($respt);
	}

	public function edit(){ 
		$sidhotel = strtoupper(trim($this->request->getPost('idhotel')));
		$nidcathotel = strtoupper(trim($this->request->getPost('idcathotel')));
		$nidbanco = strtoupper(trim($this->request->getPost('idbanco')));

		$data = $this->hotel->getHotel($sidhotel,$nidcathotel,$nidbanco);
		echo json_encode($data);
	}

	public function autocompletebancos()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->banco->getAutocompletebancos($todos,$keyword);
		echo json_encode($data);
	}
	public function autocompletecathotels()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->cathotel->getAutocompletecathotels($todos,$keyword);
		echo json_encode($data);
	}

	public function gethotelsSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->hotel->gethotelsSelectNombre($searchTerm);
		echo json_encode($response);
	}


	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de hotel', 0, 1, 'C');
		$pdf->Output('hotel.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

	public function excel()
	{
		$total = $this->hotel->getCount();

		$hotel = $this->hotel->getHotels(1, '', $total, 1);
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
		$doc->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
		$doc->getActiveSheet()->getStyle('A1:P1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF92C5FC');
		$border = array('borders' => array('allborders' => array('style' => \PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))));
		$doc->getActiveSheet()->SetCellValue('A1', 'ID');
		$doc->getActiveSheet()->SetCellValue('B1', 'NOMBRE');
		$doc->getActiveSheet()->SetCellValue('C1', 'NOMBRE');
		$doc->getActiveSheet()->SetCellValue('D1', 'IDCAT');
		$doc->getActiveSheet()->SetCellValue('E1', 'DIRECCION');
		$doc->getActiveSheet()->SetCellValue('F1', 'TELEFONO');
		$doc->getActiveSheet()->SetCellValue('G1', 'CORREO');
		$doc->getActiveSheet()->SetCellValue('H1', 'RUC');
		$doc->getActiveSheet()->SetCellValue('I1', 'RAZONSOCIAL');
		$doc->getActiveSheet()->SetCellValue('J1', 'NROCUENTA');
		$doc->getActiveSheet()->SetCellValue('K1', 'NOMBRE');
		$doc->getActiveSheet()->SetCellValue('L1', 'IDBANCO');
		$doc->getActiveSheet()->SetCellValue('M1', 'UBIGEO');
		$doc->getActiveSheet()->SetCellValue('N1', 'LATITUD');
		$doc->getActiveSheet()->SetCellValue('O1', 'LONGITUD');
		$doc->getActiveSheet()->SetCellValue('P1', 'ESTADO');
		$i=2;
		foreach ($hotel as $row) {
			$doc->getActiveSheet()->SetCellValue('A'.$i, $row['idhotel']);
			$doc->getActiveSheet()->SetCellValue('B'.$i, $row['nombre']);
			$doc->getActiveSheet()->SetCellValue('C'.$i, $row['nombre']);
			$doc->getActiveSheet()->SetCellValue('D'.$i, $row['idcathotel']);
			$doc->getActiveSheet()->SetCellValue('E'.$i, $row['direccion']);
			$doc->getActiveSheet()->SetCellValue('F'.$i, $row['telefono']);
			$doc->getActiveSheet()->SetCellValue('G'.$i, $row['correo']);
			$doc->getActiveSheet()->SetCellValue('H'.$i, $row['ruc']);
			$doc->getActiveSheet()->SetCellValue('I'.$i, $row['razonsocial']);
			$doc->getActiveSheet()->SetCellValue('J'.$i, $row['nrocuenta']);
			$doc->getActiveSheet()->SetCellValue('K'.$i, $row['nombre']);
			$doc->getActiveSheet()->SetCellValue('L'.$i, $row['idbanco']);
			$doc->getActiveSheet()->SetCellValue('M'.$i, $row['ubigeo']);
			$doc->getActiveSheet()->SetCellValue('N'.$i, $row['latitud']);
			$doc->getActiveSheet()->SetCellValue('O'.$i, $row['longitud']);
			$doc->getActiveSheet()->SetCellValue('P'.$i, $row['estado']);
			$i++;
		}
		$doc->getActiveSheet()->getStyle('A1:P1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++) {
			$doc->getActiveSheet()->getStyle('A'.$j.':P'.$j)->applyFromArray($border);
		}

		$filename = 'Lista_hotel.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$objWriter = \PHPExcel_IOFactory::createWriter($doc, 'Excel5');
		$objWriter->save('php://output');
	}

}
