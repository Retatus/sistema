<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PaginadoModel;
use App\Models\TrenModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;


class Tren extends BaseController
{
	protected $paginado;
	protected $tren;


	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->tren = new TrenModel();

	}

	public function index($bestado = 1)
	{
		$tren = $this->tren->getTrens(1, '', 20, 1);
		$total = $this->tren->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'tren', 'pag' => $pag, 'datos' => $tren];

		echo view('layouts/header');
		echo view('layouts/aside');
		echo view('tren/list', $data);
		echo view('layouts/footer');

	}
	public function agregar(){
	
		$total = $this->tren->getCount('', '');
		$pag = $this->paginado->pagina(1, $total, 1);
		print_r($pag);
	}

	public function opciones(){
		$accion = (isset($_GET['accion'])) ? $_GET['accion']:'leer';
		$pag = (int)(isset($_GET['pag'])) ? $_GET['pag']:1;

		$todos = $this->request->getPost('todos');
		$texto = strtoupper(trim($this->request->getPost('texto')));

		$nidtren = strtoupper(trim($this->request->getPost('idtren')));
		$snombre = strtoupper(trim($this->request->getPost('nombre')));
		$sempresa = strtoupper(trim($this->request->getPost('empresa')));
		$bestado = strtoupper(trim($this->request->getPost('estado')));


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion) {
			case 'agregar':
				$data  = array(
					'nidtren' => $nidtren,
					'snombre' => $snombre,
					'sempresa' => $sempresa,
					'bestado' => intval($bestado),

				);
				if ($this->tren->existe($nidtren) == 1) {
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->tren->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'snombre' => $snombre,
					'sempresa' => $sempresa,
					'bestado' => intval($bestado),

				);
				$this->tren->UpdateTren($nidtren, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->tren->UpdateTren($nidtren, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->tren->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->tren->gettrens($todos, $texto, 20, $pag)];
		echo json_encode($respt);
	}

	public function edit(){ 
		$nidtren = strtoupper(trim($this->request->getPost('idtren')));

		$data = $this->tren->getTren($nidtren);
		echo json_encode($data);
	}


	public function gettrensSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->tren->gettrensSelectNombre($searchTerm);
		echo json_encode($response);
	}


	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de tren', 0, 1, 'C');
		$pdf->Output('tren.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

	public function excel()
	{
		$total = $this->tren->getCount();

		$tren = $this->tren->getTrens(1, '', $total, 1);
		require_once ROOTPATH . 'vendor/autoload.php';
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->setActiveSheetIndex(0);
		$sheet->getColumnDimension('A')->setAutoSize(true);
		$sheet->getColumnDimension('B')->setAutoSize(true);
		$sheet->getColumnDimension('C')->setAutoSize(true);
		$sheet->getStyle('A1:C1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF92C5FC');
		$border = ['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000'], ], ], ];
		$sheet->setCellValue('A1', 'NOMBRE');
		$sheet->setCellValue('B1', 'EMPRESA');
		$sheet->setCellValue('C1', 'ESTADO');
		$i=2;
		foreach ($tren as $row) {
			$sheet->setCellValue('A'.$i, $row['nombre']);
			$sheet->setCellValue('B'.$i, $row['empresa']);
			$sheet->setCellValue('C'.$i, $row['estado']);
			$i++;
		}
		$sheet->getStyle('A1:C1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++) {
			$sheet->getStyle('A'.$j.':C'.$j)->applyFromArray($border);
		}

		$writer = new Xls($spreadsheet);
		$filename = 'Lista_tren.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit;
	}

}
