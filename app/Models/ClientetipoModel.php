<?php

namespace App\Models;
use CodeIgniter\Model; 

class ClientetipoModel extends Model
{
	protected $table      = 'tclientetipo';
	protected $primaryKey = 'nidclientetipo';
	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['nidclientetipo', 'snombre', 'bestado'];
	protected $useTimestamps = false;
	protected $createdField  = 'tfecha_alt';
	protected $updatedField  = 'tfecha_edi';
	protected $deletedField  = 'deleted_at';

	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = false;

//   SECCION ====== CONEXION ======
	protected function conexion(string $table = null){
		$this->db = \Config\Database::connect();
		$this->builder = $this->db->table($table);
		return $this->builder;
	}

//   SECCION ====== EXISTE ======
	public function existe($nidclientetipo){
		return $this->where(['nidclientetipo' => $nidclientetipo])->countAllResults();
	}

//   SECCION ====== TODOS ======
	public function getClientetipos($total, $pag = 1, $todos = 1, $text = ''){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;

		$builder = $this->conexion('tclientetipo t0');

		$builder->select("t0.nidclientetipo idclientetipo, t0.snombre nombre, t0.bestado estado, CONCAT(t0.snombre) concatenado, CONCAT(t0.snombre) concatenadodetalle");


		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidclientetipo', $text)
				->orLike('t0.snombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidclientetipo', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== AUTOCOMPLETE ======
	public function getAutocompleteClientetipos($todos = 1, $text = ''){
		$builder = $this->conexion('tclientetipo t0');

		$builder->select("t0.nidclientetipo idclientetipo, t0.snombre nombre, t0.bestado estado, CONCAT(t0.snombre) concatenado, CONCAT(t0.snombre) concatenadodetalle");

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidclientetipo', $text)
				->orLike('t0.snombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidclientetipo', 'DESC');
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== GET ======
	public function getclientetipo($nidclientetipo){
		$builder = $this->conexion('tclientetipo t0');
		$builder->select("t0.nidclientetipo idclientetipo, t0.snombre nombre, t0.bestado estado");
		$builder->where(['nidclientetipo' => $nidclientetipo]);
		$query = $builder->get();
		return $query->getRowArray();
	}

//   SECCION ====== GET 2 ======
	public function getClientetipo2($id){
		$builder = $this->conexion('tclientetipo t0');
		$builder->select("t0.nidclientetipo idclientetipo, t0.snombre nombre, t0.bestado estado");
		$builder->where('t0.nidclientetipo', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}
//   SECCION ====== COUNT ======
	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('tclientetipo t0');
		$builder->select('nidclientetipo');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidclientetipo', $text)
				->orLike('t0.snombre', $text)
				->groupEnd();
		}

		return $builder->countAllResults();
	}

//   SECCION ====== UPDATE ======
	public function UpdateClientetipo($nidclientetipo,  $datos){
		$builder = $this->conexion('tclientetipo');
		$builder->where(['nidclientetipo' => $nidclientetipo]);
		$builder->set($datos);
		$builder->update();
	}

//   SECCION ====== MAXIMO ID ======
	public function getMaxid(){
		$builder = $this->conexion('tclientetipo');
		$builder->selectMax('nidclientetipo');
		$query = $builder->get();
		return  $query->getResult()[0]->nidclientetipo;
	}
}
?>
