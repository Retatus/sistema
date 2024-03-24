<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PaginadoModel;
use App\Models\ReservadetalleclienteModel;
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
		$reservadetallecliente = $this->reservadetallecliente->getReservadetalleclientes(1, '', 10, 1);
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
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->reservadetallecliente->getreservadetalleclientes($todos, $texto, 10, $pag)];
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
		$doc->getActiveSheet()->SetCellValue('A1', 'RESERVANOMBRE');
		$doc->getActiveSheet()->SetCellValue('B1', 'IDRESERVA');
		$doc->getActiveSheet()->SetCellValue('C1', 'TIPODOC');
		$doc->getActiveSheet()->SetCellValue('D1', 'CLIENTENOMBRE');
		$doc->getActiveSheet()->SetCellValue('E1', 'IDCLIENTE');
		$doc->getActiveSheet()->SetCellValue('F1', 'CANTIDAD');
		$doc->getActiveSheet()->SetCellValue('G1', 'PRECIO');
		$doc->getActiveSheet()->SetCellValue('H1', 'TOTAL');
		$doc->getActiveSheet()->SetCellValue('I1', 'CONFIRMADO');
		$doc->getActiveSheet()->SetCellValue('J1', 'ESTADO');
		$i=2;
		foreach ($reservadetallecliente as $row) {
			$doc->getActiveSheet()->SetCellValue('A'.$i, $row['reservanombre']);
			$doc->getActiveSheet()->SetCellValue('B'.$i, $row['idreserva']);
			$doc->getActiveSheet()->SetCellValue('C'.$i, $row['tipodoc']);
			$doc->getActiveSheet()->SetCellValue('D'.$i, $row['clientenombre']);
			$doc->getActiveSheet()->SetCellValue('E'.$i, $row['idcliente']);
			$doc->getActiveSheet()->SetCellValue('F'.$i, $row['cantidad']);
			$doc->getActiveSheet()->SetCellValue('G'.$i, $row['precio']);
			$doc->getActiveSheet()->SetCellValue('H'.$i, $row['total']);
			$doc->getActiveSheet()->SetCellValue('I'.$i, $row['confirmado']);
			$doc->getActiveSheet()->SetCellValue('J'.$i, $row['estado']);
			$i++;
		}
		$doc->getActiveSheet()->getStyle('A1:J1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++) {
			$doc->getActiveSheet()->getStyle('A'.$j.':J'.$j)->applyFromArray($border);
		}

		$filename = 'Lista_reservadetallecliente.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$objWriter = \PHPExcel_IOFactory::createWriter($doc, 'Excel5');
		$objWriter->save('php://output');
	}

}
