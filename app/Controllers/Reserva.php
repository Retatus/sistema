<?php namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PaginadoModel;
use App\Models\ReservaModel;
use App\Models\EventModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;


class Reserva extends BaseController
{
	protected $paginado;
	protected $reserva;


//   SECCION ====== CONSTRUCT ======
	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->reserva = new ReservaModel();
	}

	public function calendar()
    {
		$reserva = $this->reserva->getReservas(20, 1, 1, '');
		$total = $this->reserva->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'reserva', 'pag' => $pag, 'datos' => $reserva];

        echo view('layouts/header');
		echo view('layouts/aside');
		echo view('reserva/calendar');
		echo view('layouts/footer');
    }
	
	public function getEvents()
    {
        $model = new EventModel();
        $events = $model->findAll(); // Recupera todos los eventos		
        // Formatea los eventos para que FullCalendar los entienda
        $formattedEvents = array_map(function($event) {
            return [
                'id' => $event['nidreserva'],
                'title' => $event['sreservanombre'],
                'start' => $event['tfechainicio'], // Asegúrate de que el formato sea 'YYYY-MM-DD' o 'YYYY-MM-DD HH:MM:SS'
                'end' => $event['tfechafin'] // Opcional
            ];
        }, $events);

        return $this->response->setJSON($formattedEvents);
    }

//   SECCION ====== INDEX ======
	public function index($bestado = 1)
	{
		$reserva = $this->reserva->getReservas(20, 1, 1, '');
		$total = $this->reserva->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'reserva', 'pag' => $pag, 'datos' => $reserva];
		$reserva = $this->reserva->getReservas(10, 1, 1, '');

		echo view('layouts/header', []);
		echo view('layouts/aside');
		echo view('reserva/list', $data);
		echo view('layouts/footer');

	}
//   SECCION ====== AGREGAR ======
	public function agregar(){

		$total = $this->reserva->getCount('', '');
		$pag = $this->paginado->pagina(1, $total, 1);
		print_r($pag);
	}

//   SECCION ====== OPCIONES ======
	public function opciones(){
		$accion = (isset($_GET['accion'])) ? $_GET['accion']:'leer';
		$pag = (int)(isset($_GET['pag'])) ? $_GET['pag']:1;
		
		$todos = $this->request->getPost('todos');
		$texto = strtoupper(trim($this->request->getPost('texto')));

		$nidreserva = strtoupper(trim($this->request->getPost('idreserva')));
		$sreservanombre = strtoupper(trim($this->request->getPost('reservanombre')));
		$tempdate = trim($this->request->getPost('fechainicio'));
		$tempdate = explode('/', $tempdate);
		$tfechainicio = date('Y-m-d', strtotime($tempdate[1].'/'.$tempdate[0].'/'.$tempdate[2]));
		$tempdate = trim($this->request->getPost('fechafin'));
		$tempdate = explode('/', $tempdate);
		$tfechafin = date('Y-m-d', strtotime($tempdate[1].'/'.$tempdate[0].'/'.$tempdate[2]));
		$ntipodoc = strtoupper(trim($this->request->getPost('tipodoc')));
		$sidpersona = strtoupper(trim($this->request->getPost('idpersona')));
		$sreservatelefono = strtoupper(trim($this->request->getPost('reservatelefono')));
		$sreservacorreo = strtoupper(trim($this->request->getPost('reservacorreo')));
		$dmontototal = strtoupper(trim($this->request->getPost('montototal')));
		$bpagado = strtoupper(trim($this->request->getPost('pagado')));
		$bestado = strtoupper(trim($this->request->getPost('estado')));


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion){
			case 'agregar':
				$data  = array(
					'nidreserva' => intval($nidreserva),
					'sreservanombre' => $sreservanombre,
					'tfechainicio' => $tfechainicio,
					'tfechafin' => $tfechafin,
					'ntipodoc' => $ntipodoc,
					'sidpersona' => $sidpersona,
					'sreservatelefono' => $sreservatelefono,
					'sreservacorreo' => $sreservacorreo,
					'dmontototal' => doubleval($dmontototal),
					'bpagado' => intval($bpagado),
					'bestado' => $bestado,

				);
				if ($this->reserva->existe($nidreserva) == 1){
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->reserva->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'sreservanombre' => $sreservanombre,
					'tfechainicio' => $tfechainicio,
					'tfechafin' => $tfechafin,
					'ntipodoc' => $ntipodoc,
					'sidpersona' => $sidpersona,
					'sreservatelefono' => $sreservatelefono,
					'sreservacorreo' => $sreservacorreo,
					'dmontototal' => doubleval($dmontototal),
					'bpagado' => intval($bpagado),
					'bestado' => $bestado,

				);
				$this->reserva->UpdateReserva($nidreserva, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->reserva->UpdateReserva($nidreserva, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->reserva->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->reserva->getReservas(20, $pag, $todos, $texto)];
		echo json_encode($respt);
	}

//   SECCION ====== EDIT ======
	public function edit(){
		$nidreserva = strtoupper(trim($this->request->getPost('idreserva')));

		$data = $this->reserva->getReserva($nidreserva);
		echo json_encode($data);
	}


	public function autocompletereservas()
	{
		$todos = 1;
		$keyword = $this->request->getPost('keyword');
		$data = $this->reserva->getAutocompletereservas($todos,$keyword);
		echo json_encode($data);
	}
//   SECCION ====== Reserva SELECT NOMBRE ======
	public function getReservasSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->reserva->getReservasSelectNombre($searchTerm);
		echo json_encode($response);
	}


//   SECCION ====== PDF ======
	public function pdf()
	{
		$pdf = new \FPDF();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 0, 'Reporte de reserva', 0, 1, 'C');
		$pdf->Output('reserva.pdf', 'I');
		$this->response->setHeader('Content-Type', 'application/pdf');
	}

//   SECCION ====== EXCEL ======
	public function excel()
	{
		$total = $this->reserva->getCount();

		$reserva = $this->reserva->getReservas($total, 1, 1, '');
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
		$sheet->getStyle('A1:M1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF92C5FC');
		$border = ['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000'], ], ], ];
		$sheet->setCellValue('A1', 'IDRESERVA');
		$sheet->setCellValue('B1', 'RESERVANOMBRE');
		$sheet->setCellValue('C1', 'FECHAINICIO');
		$sheet->setCellValue('D1', 'FECHAFIN');
		$sheet->setCellValue('E1', 'TIPODOC');
		$sheet->setCellValue('F1', 'IDPERSONA');
		$sheet->setCellValue('G1', 'RESERVATELEFONO');
		$sheet->setCellValue('H1', 'RESERVACORREO');
		$sheet->setCellValue('I1', 'MONTOTOTAL');
		$sheet->setCellValue('J1', 'PAGADO');
		$sheet->setCellValue('K1', 'ESTADO');
		$sheet->setCellValue('L1', 'CONCATENADO');
		$sheet->setCellValue('M1', 'CONCATENADODETALLE');
		$i=2;
		foreach ($reserva as $row){
			$sheet->setCellValue('A'.$i, $row['idreserva']);
			$sheet->setCellValue('B'.$i, $row['reservanombre']);
			$sheet->setCellValue('C'.$i, $row['fechainicio']);
			$sheet->setCellValue('D'.$i, $row['fechafin']);
			$sheet->setCellValue('E'.$i, $row['tipodoc']);
			$sheet->setCellValue('F'.$i, $row['idpersona']);
			$sheet->setCellValue('G'.$i, $row['reservatelefono']);
			$sheet->setCellValue('H'.$i, $row['reservacorreo']);
			$sheet->setCellValue('I'.$i, $row['montototal']);
			$sheet->setCellValue('J'.$i, $row['pagado']);
			$sheet->setCellValue('K'.$i, $row['estado']);
			$sheet->setCellValue('L'.$i, $row['concatenado']);
			$sheet->setCellValue('M'.$i, $row['concatenadodetalle']);
			$i++;
		}
		$sheet->getStyle('A1:M1')->applyFromArray($border);
		for ($j = 1; $j < $i ; $j++){
			$sheet->getStyle('A'.$j.':M'.$j)->applyFromArray($border);
		}

		$writer = new Xls($spreadsheet);
		$filename = 'Lista_Reserva.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit;
	}

}
