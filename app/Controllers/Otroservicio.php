<?php namespace App\Controllers;
use App\Controllers\BaseController;
use DateTime;
use App\Models\PaginadoModel;
use App\Models\OtroservicioModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;


class Otroservicio extends BaseController
{
	protected $paginado;
	protected $otroservicio;


//   SECCION ====== CONSTRUCT ======
	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->otroservicio = new OtroservicioModel();

	}

//   SECCION ====== INDEX ======
	public function index($bestado = 1)
	{
		$otroservicio = $this->otroservicio->getOtroservicios(20, 1, 1, '');
		$total = $this->otroservicio->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'otroservicio', 'pag' => $pag, 'datos' => $otroservicio];
		$otroservicio = $this->otroservicio->getOtroservicios(10, 1, 1, '');

		echo view('layouts/header', []);
		echo view('layouts/aside');
		echo view('otroservicio/list', $data);
		echo view('layouts/footer');

	}
//   SECCION ====== AGREGAR ======
	public function agregar(){

		$total = $this->otroservicio->getCount('', '');
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
			$nidotroservicio = strtoupper(trim($this->request->getPost('idotroservicio')));
			$sotroservicionombre = strtoupper(trim($this->request->getPost('otroservicionombre')));
			$dotroservicioprecio = strtoupper(trim($this->request->getPost('otroservicioprecio')));
			$botroservicioestado = strtoupper(trim($this->request->getPost('otroservicioestado')));
		}


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion){
			case 'agregar':
				$data  = array(
					'nidotroservicio' => intval($nidotroservicio),
					'sotroservicionombre' => $sotroservicionombre,
					'dotroservicioprecio' => doubleval($dotroservicioprecio),
					'botroservicioestado' => intval($botroservicioestado),

				);
				if ($this->otroservicio->existe($nidotroservicio) == 1){
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->otroservicio->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'sotroservicionombre' => $sotroservicionombre,
					'dotroservicioprecio' => doubleval($dotroservicioprecio),
					'botroservicioestado' => intval($botroservicioestado),

				);
				$this->otroservicio->UpdateOtroservicio($nidotroservicio, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->otroservicio->UpdateOtroservicio($nidotroservicio, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->otroservicio->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->otroservicio->getOtroservicios(20, $pag, $todos, $texto)];
		echo json_encode($respt);
	}

//   SECCION ====== EDIT ======
	public function edit(){
		$nidotroservicio = strtoupper(trim($this->request->getPost('idotroservicio')));

		$data = $this->otroservicio->getOtroservicio($nidotroservicio);
		echo json_encode($data);
	}


	public function autocompleteotroservicios()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->otroservicio->getAutocompleteotroservicios($todos,$keyword);
		echo json_encode($data);
	}
//   SECCION ====== Otroservicio SELECT NOMBRE ======
	public function getOtroserviciosSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->otroservicio->getOtroserviciosSelectNombre($searchTerm);
		echo json_encode($response);
	}


//   SECCION ====== PDF ======
	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de otroservicio', 0, 1, 'C');
		$pdf->Output('otroservicio.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

//   SECCION ====== EXCEL ======
	public function excel()
	{
		$total = $this->otroservicio->getCount();

		$otroservicio = $this->otroservicio->getOtroservicios($total, 1, 1, '');
		require_once ROOTPATH . 'vendor/autoload.php';
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->setActiveSheetIndex(0);
		$sheet->getColumnDimension('A')->setAutoSize(true);
		$sheet->getColumnDimension('B')->setAutoSize(true);
		$sheet->getColumnDimension('C')->setAutoSize(true);
		$sheet->getColumnDimension('D')->setAutoSize(true);
		$sheet->getColumnDimension('E')->setAutoSize(true);
		$sheet->getColumnDimension('F')->setAutoSize(true);
		$sheet->getStyle('A1:F1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF92C5FC');
		$border = ['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000'], ], ], ];
		$sheet->setCellValue('A1', 'IDOTROSERVICIO');
		$sheet->setCellValue('B1', 'OTROSERVICIONOMBRE');
		$sheet->setCellValue('C1', 'OTROSERVICIOPRECIO');
		$sheet->setCellValue('D1', 'OTROSERVICIOESTADO');
		$sheet->setCellValue('E1', 'CONCATENADO');
		$sheet->setCellValue('F1', 'CONCATENADODETALLE');
		$i=2;
		foreach ($otroservicio as $row){
			$sheet->setCellValue('A'.$i, $row['idotroservicio']);
			$sheet->setCellValue('B'.$i, $row['otroservicionombre']);
			$sheet->setCellValue('C'.$i, $row['otroservicioprecio']);
			$sheet->setCellValue('D'.$i, $row['otroservicioestado']);
			$sheet->setCellValue('E'.$i, $row['concatenado']);
			$sheet->setCellValue('F'.$i, $row['concatenadodetalle']);
			$i++;
		}
		$sheet->getStyle('A1:F1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++){
			$sheet->getStyle('A'.$j.':F'.$j)->applyFromArray($border);
		}

		$writer = new Xls($spreadsheet);
		$filename = 'Lista_Otroservicio.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit;
	}

}
