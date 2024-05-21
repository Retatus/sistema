<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PaginadoModel;
use App\Models\HorariotrenModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use App\Models\HoratrenModel;
use App\Models\TrenModel;


class Horariotren extends BaseController
{
	protected $paginado;
	protected $horariotren;
	protected $horatren;
	protected $tren;


	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->horariotren = new HorariotrenModel();
		$this->horatren = new HoratrenModel();
		$this->tren = new TrenModel();

	}

	public function index($bestado = 1)
	{
		$horariotren = $this->horariotren->getHorariotrens(1, '', 20, 1);
		$total = $this->horariotren->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'horariotren', 'pag' => $pag, 'datos' => $horariotren];
		$horatren = $this->horatren->getHoratrens(1, '', 10, 1);
		$tren = $this->tren->getTrens(1, '', 10, 1);

		echo view('layouts/header', ['horatrens' => $horatren, 'trens' => $tren]);
		echo view('layouts/aside');
		echo view('horariotren/list', $data);
		echo view('layouts/footer');

	}
	public function agregar(){
	
		$total = $this->horariotren->getCount('', '');
		$pag = $this->paginado->pagina(1, $total, 1);
		print_r($pag);
	}

	public function opciones(){
		$accion = (isset($_GET['accion'])) ? $_GET['accion']:'leer';
		$pag = (int)(isset($_GET['pag'])) ? $_GET['pag']:1;

		$todos = $this->request->getPost('todos');
		$texto = strtoupper(trim($this->request->getPost('texto')));

		$nidhorariotren = strtoupper(trim($this->request->getPost('idhorariotren')));
		$nidtren = strtoupper(trim($this->request->getPost('idtren')));
		$nidhorario = strtoupper(trim($this->request->getPost('idhorario')));
		$dprecio = strtoupper(trim($this->request->getPost('precio')));
		$bestado = strtoupper(trim($this->request->getPost('estado')));


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion) {
			case 'agregar':
				$data  = array(
					'nidhorariotren' => $nidhorariotren,
					'nidtren' => $nidtren,
					'nidhorario' => $nidhorario,
					'dprecio' => doubleval($dprecio),
					'bestado' => intval($bestado),

				);
				if ($this->horariotren->existe($nidhorariotren,$nidhorario,$nidtren) == 1) {
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->horariotren->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'nidtren' => $nidtren,
					'nidhorario' => $nidhorario,
					'dprecio' => doubleval($dprecio),
					'bestado' => intval($bestado),

				);
				$this->horariotren->UpdateHorariotren($nidhorariotren,$nidhorario,$nidtren, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->horariotren->UpdateHorariotren($nidhorariotren, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->horariotren->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->horariotren->gethorariotrens($todos, $texto, 20, $pag)];
		echo json_encode($respt);
	}

	public function edit(){ 
		$nidhorariotren = strtoupper(trim($this->request->getPost('idhorariotren')));
		$nidtren = strtoupper(trim($this->request->getPost('idtren')));
		$nidhorario = strtoupper(trim($this->request->getPost('idhorario')));

		$data = $this->horariotren->getHorariotren($nidhorariotren,$nidhorario,$nidtren);
		echo json_encode($data);
	}

	public function autocompletehoratrens()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->horatren->getAutocompletehoratrens($todos,$keyword);
		echo json_encode($data);
	}
	public function autocompletetrens()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->tren->getAutocompletetrens($todos,$keyword);
		echo json_encode($data);
	}

	public function gethorariotrensSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->horariotren->gethorariotrensSelectNombre($searchTerm);
		echo json_encode($response);
	}


	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de horariotren', 0, 1, 'C');
		$pdf->Output('horariotren.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

	public function excel()
	{
		$total = $this->horariotren->getCount();

		$horariotren = $this->horariotren->getHorariotrens(1, '', $total, 1);
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
		$sheet->setCellValue('A1', 'NOMBRE');
		$sheet->setCellValue('B1', 'IDTREN');
		$sheet->setCellValue('C1', 'NOMBRE');
		$sheet->setCellValue('D1', 'IDHORARIO');
		$sheet->setCellValue('E1', 'PRECIO');
		$sheet->setCellValue('F1', 'ESTADO');
		$i=2;
		foreach ($horariotren as $row) {
			$sheet->setCellValue('A'.$i, $row['nombre']);
			$sheet->setCellValue('B'.$i, $row['idtren']);
			$sheet->setCellValue('C'.$i, $row['nombre']);
			$sheet->setCellValue('D'.$i, $row['idhorario']);
			$sheet->setCellValue('E'.$i, $row['precio']);
			$sheet->setCellValue('F'.$i, $row['estado']);
			$i++;
		}
		$sheet->getStyle('A1:F1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++) {
			$sheet->getStyle('A'.$j.':F'.$j)->applyFromArray($border);
		}

		$writer = new Xls($spreadsheet);
		$filename = 'Lista_horariotren.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit;
	}

}
