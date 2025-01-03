<?php namespace App\Controllers;
use App\Controllers\BaseController;
use DateTime;
use App\Models\PaginadoModel;
use App\Models\ClienteModel;
use App\Models\TipodocModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;


class Cliente extends BaseController
{
	protected $paginado;
	protected $cliente;
	protected $tipodoc;


//   SECCION ====== CONSTRUCT ======
	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->cliente = new ClienteModel();
		$this->tipodoc = new TipodocModel();

	}

//   SECCION ====== INDEX ======
	public function index($bestado = 1)
	{
		$cliente = $this->cliente->getClientes(20, 1, 1, '');
		$total = $this->cliente->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'cliente', 'pag' => $pag, 'datos' => $cliente];
		$cliente = $this->cliente->getClientes(10, 1, 1, '');
		$tipodoc = $this->tipodoc->getTipodocs(10, 1, 1, '');

		echo view('layouts/header', ['tipodocs' => $tipodoc]);
		echo view('layouts/aside');
		echo view('cliente/list', $data);
		echo view('layouts/footer');

	}
//   SECCION ====== AGREGAR ======
	public function agregar(){

		$total = $this->cliente->getCount('', '');
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
			$sidcliente = strtoupper(trim($this->request->getPost('idcliente')));
			$nidtipodoc = strtoupper(trim($this->request->getPost('idtipodoc')));
			$sclientenombre = strtoupper(trim($this->request->getPost('clientenombre')));
			$sclienteapellidos = strtoupper(trim($this->request->getPost('clienteapellidos')));
			$sclientetelefono = strtoupper(trim($this->request->getPost('clientetelefono')));
			$sclientecorreo = strtoupper(trim($this->request->getPost('clientecorreo')));
			$sclientedireccion = strtoupper(trim($this->request->getPost('clientedireccion')));
			$sclientepais = strtoupper(trim($this->request->getPost('clientepais')));
			$tempdate = trim($this->request->getPost('clientefechanacimiento'));
			$tempdate = explode('/', $tempdate);
			$tclientefechanacimiento = date('Y-m-d', strtotime($tempdate[1].'/'.$tempdate[0].'/'.$tempdate[2]));
			$nclienteedad = strtoupper(trim($this->request->getPost('clienteedad')));
			$bclientesexo = strtoupper(trim($this->request->getPost('clientesexo')));
			$bclienteestado = strtoupper(trim($this->request->getPost('clienteestado')));
		}


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion){
			case 'agregar':
				$data  = array(
					'sidcliente' => $sidcliente,
					'nidtipodoc' => $nidtipodoc,
					'sclientenombre' => $sclientenombre,
					'sclienteapellidos' => $sclienteapellidos,
					'sclientetelefono' => $sclientetelefono,
					'sclientecorreo' => $sclientecorreo,
					'sclientedireccion' => $sclientedireccion,
					'sclientepais' => $sclientepais,
					'tclientefechanacimiento' => $tclientefechanacimiento,
					'nclienteedad' => $nclienteedad,
					'bclientesexo' => intval($bclientesexo),
					'bclienteestado' => intval($bclienteestado),

				);
				if ($this->cliente->existe($sidcliente, $nidtipodoc) == 1){
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->cliente->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'nidtipodoc' => $nidtipodoc,
					'sclientenombre' => $sclientenombre,
					'sclienteapellidos' => $sclienteapellidos,
					'sclientetelefono' => $sclientetelefono,
					'sclientecorreo' => $sclientecorreo,
					'sclientedireccion' => $sclientedireccion,
					'sclientepais' => $sclientepais,
					'tclientefechanacimiento' => $tclientefechanacimiento,
					'nclienteedad' => $nclienteedad,
					'bclientesexo' => intval($bclientesexo),
					'bclienteestado' => intval($bclienteestado),

				);
				$this->cliente->UpdateCliente($sidcliente, $nidtipodoc, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->cliente->UpdateCliente($sidcliente, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->cliente->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->cliente->getClientes(20, $pag, $todos, $texto)];
		echo json_encode($respt);
	}

//   SECCION ====== EDIT ======
	public function edit(){
		$sidcliente = strtoupper(trim($this->request->getPost('idcliente')));
		$nidtipodoc = strtoupper(trim($this->request->getPost('idtipodoc')));

		$data = $this->cliente->getCliente($sidcliente, $nidtipodoc);
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
//   SECCION ====== Cliente SELECT NOMBRE ======
	public function getClientesSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->cliente->getClientesSelectNombre($searchTerm);
		echo json_encode($response);
	}


//   SECCION ====== PDF ======
	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de cliente', 0, 1, 'C');
		$pdf->Output('cliente.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

//   SECCION ====== EXCEL ======
	public function excel()
	{
		$total = $this->cliente->getCount();

		$cliente = $this->cliente->getClientes($total, 1, 1, '');
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
		$sheet->getColumnDimension('O')->setAutoSize(true);
		$sheet->getStyle('A1:O1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF92C5FC');
		$border = ['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000'], ], ], ];
		$sheet->setCellValue('A1', 'IDCLIENTE');
		$sheet->setCellValue('B1', 'CLIENTENOMBRE');
		$sheet->setCellValue('C1', 'CLIENTEAPELLIDOS');
		$sheet->setCellValue('D1', 'CLIENTETELEFONO');
		$sheet->setCellValue('E1', 'CLIENTECORREO');
		$sheet->setCellValue('F1', 'CLIENTEDIRECCION');
		$sheet->setCellValue('G1', 'CLIENTEPAIS');
		$sheet->setCellValue('H1', 'CLIENTEFECHANACIMIENTO');
		$sheet->setCellValue('I1', 'CLIENTEEDAD');
		$sheet->setCellValue('J1', 'CLIENTESEXO');
		$sheet->setCellValue('K1', 'CLIENTEESTADO');
		$sheet->setCellValue('L1', 'IDTIPODOC');
		$sheet->setCellValue('M1', 'NOMBRE');
		$sheet->setCellValue('N1', 'CONCATENADO');
		$sheet->setCellValue('O1', 'CONCATENADODETALLE');
		$i=2;
		foreach ($cliente as $row){
			$sheet->setCellValue('A'.$i, $row['idcliente']);
			$sheet->setCellValue('B'.$i, $row['clientenombre']);
			$sheet->setCellValue('C'.$i, $row['clienteapellidos']);
			$sheet->setCellValue('D'.$i, $row['clientetelefono']);
			$sheet->setCellValue('E'.$i, $row['clientecorreo']);
			$sheet->setCellValue('F'.$i, $row['clientedireccion']);
			$sheet->setCellValue('G'.$i, $row['clientepais']);
			$sheet->setCellValue('H'.$i, $row['clientefechanacimiento']);
			$sheet->setCellValue('I'.$i, $row['clienteedad']);
			$sheet->setCellValue('J'.$i, $row['clientesexo']);
			$sheet->setCellValue('K'.$i, $row['clienteestado']);
			$sheet->setCellValue('L'.$i, $row['idtipodoc']);
			$sheet->setCellValue('M'.$i, $row['nombre']);
			$sheet->setCellValue('N'.$i, $row['concatenado']);
			$sheet->setCellValue('O'.$i, $row['concatenadodetalle']);
			$i++;
		}
		$sheet->getStyle('A1:O1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++){
			$sheet->getStyle('A'.$j.':O'.$j)->applyFromArray($border);
		}

		$writer = new Xls($spreadsheet);
		$filename = 'Lista_Cliente.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit;
	}

}
