<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PaginadoModel;
use App\Models\OrigenclienteModel;


class Origencliente extends BaseController
{
	protected $paginado;
	protected $origencliente;


	public function __construct(){
		$this->paginado = new PaginadoModel();
		$this->origencliente = new OrigenclienteModel();

	}

	public function index($bestado = 1)
	{
		$origencliente = $this->origencliente->getOrigenclientes(1, '', 10, 1);
		$total = $this->origencliente->getCount();
		$adjacents = 1;
		$pag = $this->paginado->pagina(1, $total, $adjacents);
		$data = ['titulo' => 'origencliente', 'pag' => $pag, 'datos' => $origencliente];

		echo view('layouts/header');
		echo view('layouts/aside');
		echo view('origencliente/list', $data);
		echo view('layouts/footer');

	}

	public function agregar(){
	
		$total = $this->origencliente->getCount('', '');
		$pag = $this->paginado->pagina(1, $total, 1);
		print_r($pag);
	}

	public function opciones(){
		$accion = (isset($_GET['accion'])) ? $_GET['accion']:'leer';
		$pag = (int)(isset($_GET['pag'])) ? $_GET['pag']:1;

		$todos = $this->request->getPost('todos');
		$texto = strtoupper(trim($this->request->getPost('texto')));

		$nidorigencliente = strtoupper(trim($this->request->getPost('idorigencliente')));
		$snombre = strtoupper(trim($this->request->getPost('nombre')));
		$bestado = strtoupper(trim($this->request->getPost('estado')));


		$respt = array();
		$id = 0; $mensaje = '';
		switch ($accion) {
			case 'agregar':
				$data  = array(
					'nidorigencliente' => intval($nidorigencliente),
					'snombre' => $snombre,
					'bestado' => intval($bestado),

				);
				if ($this->origencliente->existe($nidorigencliente) == 1) {
					$id = 0; $mensaje = 'CODIGO YA EXISTE'; 
				} else {
					$this->origencliente->insert($data);
					$id = 1; $mensaje = 'INSERTADO CORRECTAMENTE';
				}
				break;
			case 'modificar':
				$data  = array(
					'snombre' => $snombre,
					'bestado' => intval($bestado),

				);
				$this->origencliente->UpdateOrigencliente($nidorigencliente, $data);
				$id = 1; $mensaje = 'ATUALIZADO CORRECTAMENTE';
				break;
			case 'eliminar':
				$data  = array(
					'bestado' => 0
				);
				$this->origencliente->UpdateOrigencliente($nidorigencliente, $data);
				$id = 1; $mensaje = 'ANULADO CORRECTAMENTE';
				break;
			default:
				$id = 1; $mensaje = 'LISTADO CORRECTAMENTE';
				break;
		}
		$adjacents = 1;
		$total = $this->origencliente->getCount($todos, $texto);
		$respt = ['id' => $id, 'mensaje' => $mensaje, 'pag' => $this->paginado->pagina($pag, $total, $adjacents), 'datos' => $this->origencliente->getorigenclientes($todos, $texto, $total, $pag)];
		echo json_encode($respt);
	}

	public function edit(){ 
		$nidorigencliente = strtoupper(trim($this->request->getPost('idorigencliente')));

		$data = $this->origencliente->getOrigencliente($nidorigencliente);
		echo json_encode($data);
	}

	public function autocomplete()
	{
		$keyword = $this->input->post('keyword');
		$data  = $this->Servicios_model->autocomplete($keyword);
		echo json_encode($data);
	}

	public function getorigenclientesSelectNombre(){
		$searchTerm = trim($this->request->getPost('term'));
		$response = $this->origencliente->getorigenclientesSelectNombre($searchTerm);
		echo json_encode($response);
	}

}
