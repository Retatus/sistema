<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PaginadoModel;
use App\Models\ReservadetalleclienteModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use App\Models\ReservaModel;
use App\Models\ClienteModel;


class Reservadetallecliente extends BaseController
{
	protected $paginado;
	protected $reservadetallecliente;
	protected $reserva;
	protected $cliente;


	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->reservadetallecliente = new ReservadetalleclienteModel();
		$this->reserva = new ReservaModel();
		$this->cliente = new ClienteModel();

	}

	public function index($bestado = 1)
	{
		$reservadetallecliente = $this->reservadetallecliente->getReservadetalleclientes(1, '', 20, 1);
		$total = $this->reservadetallecliente->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'reservadetallecliente', 'pag' => $pag, 'datos' => $reservadetallecliente];
		$reserva = $this->reserva->getReservas(1, '', 10, 1);
		$cliente = $this->cliente->getClientes(1, '', 10, 1);

		echo view('layouts/header', ['reservas' => $reserva, 'clientes' => $cliente]);
		echo view('layouts/aside');
		echo view('reservadetallecliente/list', $data);
		echo view('layouts/footer');

	}
	public function agregar(){
	
		$total = $this->reservadetallecliente->getCount('', '');
		$pag = $this->paginado->pagina(1, $total, 1);
		print_r($pag);
	}

	public function opciones(){
		$accion = (isset($_GET['accion'])) ? $_GET['accion']:'leer';
		$pag = (int)(isset($_GET['pag'])) ? $_GET['pag']:1;

		$todos = $this->request->getPost('todos');
		$texto = strtoupper(trim($this->request->getPost('texto')));

		$nidreservadetallecliente = strtoupper(trim($this->request->getPost('idreservadetallecliente')));
		$nidreserva = strtoupper(trim($this->request->getPost('idreserva')));
		$sidcliente = strtoupper(trim($this->request->getPost('idcliente')));
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
					'nidreservadetallecliente' => intval($nidreservadetallecliente),
					'nidreserva' => intval($nidreserva),
					'sidcliente' => $sidcliente,
					'ncantidad' => intval($ncantidad),
					'dprecio' => doubleval($dprecio),
					'dtotal' => doubleval($dtotal),
					'bconfirmado' => intval($bconfirmado),
					'bestado' => intval($bestado),

				);
				if ($this->reservadetallecliente->existe($nidreservadetallecliente,$nidreserva,$sidcliente) == 1) {
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
				$this->reservadetallecliente->UpdateReservadetallecliente($nidreservadetallecliente,$nidreserva,$sidcliente, $data);
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
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->reservadetallecliente->getreservadetalleclientes($todos, $texto, 20, $pag)];
		echo json_encode($respt);
	}

	public function edit(){ 
		$nidreservadetallecliente = strtoupper(trim($this->request->getPost('idreservadetallecliente')));
		$nidreserva = strtoupper(trim($this->request->getPost('idreserva')));
		$sidcliente = strtoupper(trim($this->request->getPost('idcliente')));

		$data = $this->reservadetallecliente->getReservadetallecliente($nidreservadetallecliente,$nidreserva,$sidcliente);
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

	public function getreservadetalleclientesSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->reservadetallecliente->getreservadetalleclientesSelectNombre($searchTerm);
		echo json_encode($response);
	}


	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de reservadetallecliente', 0, 1, 'C');
		$pdf->Output('reservadetallecliente.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

	public function excel()
	{
		$total = $this->reservadetallecliente->getCount();

		$reservadetallecliente = $this->reservadetallecliente->getReservadetalleclientes(1, '', $total, 1);
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
		$sheet->getStyle('A1:J1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF92C5FC');
		$border = ['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000'], ], ], ];
		$sheet->setCellValue('A1', 'RESERVANOMBRE');
		$sheet->setCellValue('B1', 'IDRESERVA');
		$sheet->setCellValue('C1', 'TIPODOC');
		$sheet->setCellValue('D1', 'CLIENTENOMBRE');
		$sheet->setCellValue('E1', 'IDCLIENTE');
		$sheet->setCellValue('F1', 'CANTIDAD');
		$sheet->setCellValue('G1', 'PRECIO');
		$sheet->setCellValue('H1', 'TOTAL');
		$sheet->setCellValue('I1', 'CONFIRMADO');
		$sheet->setCellValue('J1', 'ESTADO');
		$i=2;
		foreach ($reservadetallecliente as $row) {
			$sheet->setCellValue('A'.$i, $row['reservanombre']);
			$sheet->setCellValue('B'.$i, $row['idreserva']);
			$sheet->setCellValue('C'.$i, $row['tipodoc']);
			$sheet->setCellValue('D'.$i, $row['clientenombre']);
			$sheet->setCellValue('E'.$i, $row['idcliente']);
			$sheet->setCellValue('F'.$i, $row['cantidad']);
			$sheet->setCellValue('G'.$i, $row['precio']);
			$sheet->setCellValue('H'.$i, $row['total']);
			$sheet->setCellValue('I'.$i, $row['confirmado']);
			$sheet->setCellValue('J'.$i, $row['estado']);
			$i++;
		}
		$sheet->getStyle('A1:J1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++) {
			$sheet->getStyle('A'.$j.':J'.$j)->applyFromArray($border);
		}

		$writer = new Xls($spreadsheet);
		$filename = 'Lista_reservadetallecliente.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit;
	}

}
