<?php namespace App\Controllers;
use App\Controllers\BaseController;
use DateTime;
use App\Models\PaginadoModel;
use App\Models\ReservadetalleclienteModel;
use App\Models\ReservaModel;
use App\Models\ClienteModel;
use App\Models\TipodocModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;


class Reservadetallecliente extends BaseController
{
	protected $paginado;
	protected $reservadetallecliente;
	protected $reserva;
	protected $cliente;
	protected $tipodoc;


//   SECCION ====== CONSTRUCT ======
	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->reservadetallecliente = new ReservadetalleclienteModel();
		$this->reserva = new ReservaModel();
		$this->cliente = new ClienteModel();
		$this->tipodoc = new TipodocModel();

	}

//   SECCION ====== INDEX ======
	public function index($bestado = 1)
	{
		$reservadetallecliente = $this->reservadetallecliente->getReservadetalleclientes(20, 1, 1, '');
		$total = $this->reservadetallecliente->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'reservadetallecliente', 'pag' => $pag, 'datos' => $reservadetallecliente];
		$reservadetallecliente = $this->reservadetallecliente->getReservadetalleclientes(10, 1, 1, '');
		$reserva = $this->reserva->getReservas(10, 1, 1, '');
		$cliente = $this->cliente->getClientes(10, 1, 1, '');
		$tipodoc = $this->tipodoc->getTipodocs(10, 1, 1, '');

		echo view('layouts/header', ['reservas' => $reserva, 'clientes' => $cliente, 'tipodocs' => $tipodoc]);
		echo view('layouts/aside');
		echo view('reservadetallecliente/list', $data);
		echo view('layouts/footer');

	}
//   SECCION ====== AGREGAR ======
	public function agregar(){

		$total = $this->reservadetallecliente->getCount('', '');
		$pag = $this->paginado->pagina(1, $total, 1);
		print_r($pag);
	}

//   SECCION ====== OPCIONES ======
	public function opciones(){
		$accion = (isset($_GET['accion'])) ? $_GET['accion']:'leer';
		$pag = (int)(isset($_GET['pag'])) ? $_GET['pag']:1;
		
		$todos = $this->request->getPost('todos');
		$texto = strtoupper(trim($this->request->getPost('texto')));

		if($accion !== 'leer'){
			$nidreservadetallecliente = strtoupper(trim($this->request->getPost('idreservadetallecliente')));
			$nidreserva = strtoupper(trim($this->request->getPost('idreserva')));
			$sidcliente = strtoupper(trim($this->request->getPost('idcliente')));
			$ncantidad = strtoupper(trim($this->request->getPost('cantidad')));
			$dprecio = strtoupper(trim($this->request->getPost('precio')));
			$dtotal = strtoupper(trim($this->request->getPost('total')));
			$bconfirmado = strtoupper(trim($this->request->getPost('confirmado')));
			$bestado = strtoupper(trim($this->request->getPost('estado')));
		}


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion){
			case 'agregar':
				$data  = array(
					'nidreservadetallecliente' => intval($nidreservadetallecliente),
					'nidreserva' => intval($nidreserva),
					'sidcliente' => $sidcliente,
					'ncantidad' => intval($ncantidad),
					'dprecio' => doubleval($dprecio),
					'dtotal' => doubleval($dtotal),
					'bconfirmado' => intval($bconfirmado),
					'bestado' => intval($bestado),

				);
				if ($this->reservadetallecliente->existe($nidreservadetallecliente, $nidreserva, $sidcliente) == 1){
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->reservadetallecliente->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'nidreserva' => intval($nidreserva),
					'sidcliente' => $sidcliente,
					'ncantidad' => intval($ncantidad),
					'dprecio' => doubleval($dprecio),
					'dtotal' => doubleval($dtotal),
					'bconfirmado' => intval($bconfirmado),
					'bestado' => intval($bestado),

				);
				$this->reservadetallecliente->UpdateReservadetallecliente($nidreservadetallecliente, $nidreserva, $sidcliente, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->reservadetallecliente->UpdateReservadetallecliente($nidreservadetallecliente, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->reservadetallecliente->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->reservadetallecliente->getReservadetalleclientes(20, $pag, $todos, $texto)];
		echo json_encode($respt);
	}

//   SECCION ====== EDIT ======
	public function edit(){
		$nidreservadetallecliente = strtoupper(trim($this->request->getPost('idreservadetallecliente')));
		$nidreserva = strtoupper(trim($this->request->getPost('idreserva')));
		$sidcliente = strtoupper(trim($this->request->getPost('idcliente')));

		$data = $this->reservadetallecliente->getReservadetallecliente($nidreservadetallecliente, $nidreserva, $sidcliente);
		echo json_encode($data);
	}


	public function autocompletereservadetalleclientes()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->reservadetallecliente->getAutocompletereservadetalleclientes($todos,$keyword);
		echo json_encode($data);
	}
	public function autocompletereservas()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->reserva->getAutocompletereservas($todos,$keyword);
		echo json_encode($data);
	}
	public function autocompleteclientes()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->cliente->getAutocompleteclientes($todos,$keyword);
		echo json_encode($data);
	}
	public function autocompletetipodocs()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->tipodoc->getAutocompletetipodocs($todos,$keyword);
		echo json_encode($data);
	}
//   SECCION ====== Reservadetallecliente SELECT NOMBRE ======
	public function getReservadetalleclientesSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->reservadetallecliente->getReservadetalleclientesSelectNombre($searchTerm);
		echo json_encode($response);
	}


//   SECCION ====== PDF ======
	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de reservadetallecliente', 0, 1, 'C');
		$pdf->Output('reservadetallecliente.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

//   SECCION ====== EXCEL ======
	public function excel()
	{
		$total = $this->reservadetallecliente->getCount();

		$reservadetallecliente = $this->reservadetallecliente->getReservadetalleclientes($total, 1, 1, '');
		require_once ROOTPATH . 'vendor/autoload.php';
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->setActiveSheetIndex(0);
		$sheet->getColumnDimension('A')->setAutoSize(true);
		$sheet->getColumnDimension('B')->setAutoSize(true);
		$sheet->getColumnDimension('C')->setAutoSize(true);
		$sheet->getColumnDimension('D')->setAutoSize(true);
		$sheet->getColumnDimension('E')->setAutoSize(true);
		$sheet->getColumnDimension('F')->setAutoSize(true);
		$sheet->getColumnDimension('G')->setAutoSize(true);
		$sheet->getColumnDimension('H')->setAutoSize(true);
		$sheet->getColumnDimension('I')->setAutoSize(true);
		$sheet->getColumnDimension('J')->setAutoSize(true);
		$sheet->getColumnDimension('K')->setAutoSize(true);
		$sheet->getColumnDimension('L')->setAutoSize(true);
		$sheet->getColumnDimension('M')->setAutoSize(true);
		$sheet->getColumnDimension('N')->setAutoSize(true);
		$sheet->getStyle('A1:N1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF92C5FC');
		$border = ['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000'], ], ], ];
		$sheet->setCellValue('A1', 'IDRESERVADETALLECLIENTE');
		$sheet->setCellValue('B1', 'CANTIDAD');
		$sheet->setCellValue('C1', 'PRECIO');
		$sheet->setCellValue('D1', 'TOTAL');
		$sheet->setCellValue('E1', 'CONFIRMADO');
		$sheet->setCellValue('F1', 'ESTADO');
		$sheet->setCellValue('G1', 'IDRESERVA');
		$sheet->setCellValue('H1', 'RESERVANOMBRE');
		$sheet->setCellValue('I1', 'IDCLIENTE');
		$sheet->setCellValue('J1', 'CLIENTENOMBRE');
		$sheet->setCellValue('K1', 'IDTIPODOC');
		$sheet->setCellValue('L1', 'NOMBRE');
		$sheet->setCellValue('M1', 'CONCATENADO');
		$sheet->setCellValue('N1', 'CONCATENADODETALLE');
		$i=2;
		foreach ($reservadetallecliente as $row){
			$sheet->setCellValue('A'.$i, $row['idreservadetallecliente']);
			$sheet->setCellValue('B'.$i, $row['cantidad']);
			$sheet->setCellValue('C'.$i, $row['precio']);
			$sheet->setCellValue('D'.$i, $row['total']);
			$sheet->setCellValue('E'.$i, $row['confirmado']);
			$sheet->setCellValue('F'.$i, $row['estado']);
			$sheet->setCellValue('G'.$i, $row['idreserva']);
			$sheet->setCellValue('H'.$i, $row['reservanombre']);
			$sheet->setCellValue('I'.$i, $row['idcliente']);
			$sheet->setCellValue('J'.$i, $row['clientenombre']);
			$sheet->setCellValue('K'.$i, $row['idtipodoc']);
			$sheet->setCellValue('L'.$i, $row['nombre']);
			$sheet->setCellValue('M'.$i, $row['concatenado']);
			$sheet->setCellValue('N'.$i, $row['concatenadodetalle']);
			$i++;
		}
		$sheet->getStyle('A1:N1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++){
			$sheet->getStyle('A'.$j.':N'.$j)->applyFromArray($border);
		}

		$writer = new Xls($spreadsheet);
		$filename = 'Lista_Reservadetallecliente.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit;
	}

}
