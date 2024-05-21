<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PaginadoModel;
use App\Models\CathotelModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;


class Cathotel extends BaseController
{
	protected $paginado;
	protected $cathotel;


	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->cathotel = new CathotelModel();

	}

	public function index($bestado = 1)
	{
		$cathotel = $this->cathotel->getCathotels(1, '', 20, 1);
		$total = $this->cathotel->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'cathotel', 'pag' => $pag, 'datos' => $cathotel];

		echo view('layouts/header');
		echo view('layouts/aside');
		echo view('cathotel/list', $data);
		echo view('layouts/footer');

	}
	public function agregar(){
	
		$total = $this->cathotel->getCount('', '');
		$pag = $this->paginado->pagina(1, $total, 1);
		print_r($pag);
	}

	public function opciones(){
		$accion = (isset($_GET['accion'])) ? $_GET['accion']:'leer';
		$pag = (int)(isset($_GET['pag'])) ? $_GET['pag']:1;

		$todos = $this->request->getPost('todos');
		$texto = strtoupper(trim($this->request->getPost('texto')));

		$nidcathotel = strtoupper(trim($this->request->getPost('idcathotel')));
		$snombre = strtoupper(trim($this->request->getPost('nombre')));
		$bestado = strtoupper(trim($this->request->getPost('estado')));


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion) {
			case 'agregar':
				$data  = array(
					'nidcathotel' => $nidcathotel,
					'snombre' => $snombre,
					'bestado' => intval($bestado),

				);
				if ($this->cathotel->existe($nidcathotel) == 1) {
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->cathotel->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'snombre' => $snombre,
					'bestado' => intval($bestado),

				);
				$this->cathotel->UpdateCathotel($nidcathotel, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->cathotel->UpdateCathotel($nidcathotel, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->cathotel->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->cathotel->getcathotels($todos, $texto, 20, $pag)];
		echo json_encode($respt);
	}

	public function edit(){ 
		$nidcathotel = strtoupper(trim($this->request->getPost('idcathotel')));

		$data = $this->cathotel->getCathotel($nidcathotel);
		echo json_encode($data);
	}


	public function getcathotelsSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->cathotel->getcathotelsSelectNombre($searchTerm);
		echo json_encode($response);
	}


	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de cathotel', 0, 1, 'C');
		$pdf->Output('cathotel.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

	public function excel()
	{
		$total = $this->cathotel->getCount();

		$cathotel = $this->cathotel->getCathotels(1, '', $total, 1);
		require_once ROOTPATH . 'vendor/autoload.php';
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->setActiveSheetIndex(0);
		$sheet->getColumnDimension('A')->setAutoSize(true);
		$sheet->getColumnDimension('B')->setAutoSize(true);
		$sheet->getStyle('A1:B1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF92C5FC');
		$border = ['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000'], ], ], ];
		$sheet->setCellValue('A1', 'NOMBRE');
		$sheet->setCellValue('B1', 'ESTADO');
		$i=2;
		foreach ($cathotel as $row) {
			$sheet->setCellValue('A'.$i, $row['nombre']);
			$sheet->setCellValue('B'.$i, $row['estado']);
			$i++;
		}
		$sheet->getStyle('A1:B1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++) {
			$sheet->getStyle('A'.$j.':B'.$j)->applyFromArray($border);
		}

		$writer = new Xls($spreadsheet);
		$filename = 'Lista_cathotel.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit;
	}

}
