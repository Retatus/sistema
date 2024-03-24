<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PaginadoModel;
use App\Models\ClienteModel;
use App\Models\TipodocModel;


class Cliente extends BaseController
{
	protected $paginado;
	protected $cliente;
	protected $tipodoc;


	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->cliente = new ClienteModel();
		$this->tipodoc = new TipodocModel();

	}

	public function index($bestado = 1)
	{
		$cliente = $this->cliente->getClientes(1, '', 10, 1);
		$total = $this->cliente->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'cliente', 'pag' => $pag, 'datos' => $cliente];
		$tipodoc = $this->tipodoc->getTipodocs(1, '', 10, 1);

		echo view('layouts/header', ['tipodocs' => $tipodoc]);
		echo view('layouts/aside');
		echo view('cliente/list', $data);
		echo view('layouts/footer');

	}
	public function agregar(){
	
		$total = $this->cliente->getCount('', '');
		$pag = $this->paginado->pagina(1, $total, 1);
		print_r($pag);
	}

	public function opciones(){
		$accion = (isset($_GET['accion'])) ? $_GET['accion']:'leer';
		$pag = (int)(isset($_GET['pag'])) ? $_GET['pag']:1;

		$todos = $this->request->getPost('todos');
		$texto = strtoupper(trim($this->request->getPost('texto')));

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


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion) {
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
				if ($this->cliente->existe($sidcliente,$nidtipodoc) == 1) {
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
				$this->cliente->UpdateCliente($sidcliente,$nidtipodoc, $data);
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
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->cliente->getclientes($todos, $texto, 10, $pag)];
		echo json_encode($respt);
	}

	public function edit(){ 
		$sidcliente = strtoupper(trim($this->request->getPost('idcliente')));
		$nidtipodoc = strtoupper(trim($this->request->getPost('idtipodoc')));

		$data = $this->cliente->getCliente($sidcliente,$nidtipodoc);
		echo json_encode($data);
	}

	public function autocompletetipodocs()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->tipodoc->getAutocompletetipodocs($todos,$keyword);
		echo json_encode($data);
	}

	public function getclientesSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->cliente->getclientesSelectNombre($searchTerm);
		echo json_encode($response);
	}


	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de cliente', 0, 1, 'C');
		$pdf->Output('cliente.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

	public function excel()
	{
		$total = $this->cliente->getCount();

		$cliente = $this->cliente->getClientes(1, '', $total, 1);
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
		$doc->getActiveSheet()->SetCellValue('A1', 'ID');
		$doc->getActiveSheet()->SetCellValue('B1', 'NOMBRE');
		$doc->getActiveSheet()->SetCellValue('C1', 'IDTIPODOC');
		$doc->getActiveSheet()->SetCellValue('D1', 'NOMBRE');
		$doc->getActiveSheet()->SetCellValue('E1', 'APELLIDOS');
		$doc->getActiveSheet()->SetCellValue('F1', 'TELEFONO');
		$doc->getActiveSheet()->SetCellValue('G1', 'CORREO');
		$doc->getActiveSheet()->SetCellValue('H1', 'DIRECCION');
		$doc->getActiveSheet()->SetCellValue('I1', 'PAIS');
		$doc->getActiveSheet()->SetCellValue('J1', 'FECHANACIMIENTO');
		$doc->getActiveSheet()->SetCellValue('K1', 'EDAD');
		$doc->getActiveSheet()->SetCellValue('L1', 'SEXO');
		$doc->getActiveSheet()->SetCellValue('M1', 'ESTADO');
		$i=2;
		foreach ($cliente as $row) {
			$doc->getActiveSheet()->SetCellValue('A'.$i, $row['idcliente']);
			$doc->getActiveSheet()->SetCellValue('B'.$i, $row['nombre']);
			$doc->getActiveSheet()->SetCellValue('C'.$i, $row['idtipodoc']);
			$doc->getActiveSheet()->SetCellValue('D'.$i, $row['clientenombre']);
			$doc->getActiveSheet()->SetCellValue('E'.$i, $row['clienteapellidos']);
			$doc->getActiveSheet()->SetCellValue('F'.$i, $row['clientetelefono']);
			$doc->getActiveSheet()->SetCellValue('G'.$i, $row['clientecorreo']);
			$doc->getActiveSheet()->SetCellValue('H'.$i, $row['clientedireccion']);
			$doc->getActiveSheet()->SetCellValue('I'.$i, $row['clientepais']);
			$doc->getActiveSheet()->SetCellValue('J'.$i, $row['clientefechanacimiento']);
			$doc->getActiveSheet()->SetCellValue('K'.$i, $row['clienteedad']);
			$doc->getActiveSheet()->SetCellValue('L'.$i, $row['clientesexo']);
			$doc->getActiveSheet()->SetCellValue('M'.$i, $row['clienteestado']);
			$i++;
		}
		$doc->getActiveSheet()->getStyle('A1:M1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++) {
			$doc->getActiveSheet()->getStyle('A'.$j.':M'.$j)->applyFromArray($border);
		}

		$filename = 'Lista_cliente.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$objWriter = \PHPExcel_IOFactory::createWriter($doc, 'Excel5');
		$objWriter->save('php://output');
	}

}
