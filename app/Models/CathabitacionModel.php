<?php

namespace App\Models;
use CodeIgniter\Model; 

class CathabitacionModel extends Model
{
	protected $table      = 'tcathabitacion';
	protected $primaryKey = 'nidcathabitacion';
	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['nidcathabitacion', 'snombre', 'bestado'];
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
	public function existe($nidcathabitacion){
		return $this->where(['nidcathabitacion' => $nidcathabitacion])->countAllResults();
	}

//   SECCION ====== TODOS ======
	public function getCathabitacions($total, $pag = 1, $todos = 1, $text = ''){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;

		$builder = $this->conexion('tcathabitacion t0');

		$builder->select("t0.nidcathabitacion idcathabitacion, t0.snombre nombre, t0.bestado estado, CONCAT(t0.snombre) concatenado, CONCAT(t0.snombre) concatenadodetalle");


		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidcathabitacion', $text)
				->orLike('t0.snombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidcathabitacion', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== AUTOCOMPLETE ======
	public function getAutocompleteCathabitacions($todos = 1, $text = ''){
		$builder = $this->conexion('tcathabitacion t0');

		$builder->select("t0.nidcathabitacion idcathabitacion, t0.snombre nombre, t0.bestado estado, CONCAT(t0.snombre) concatenado, CONCAT(t0.snombre) concatenadodetalle");

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidcathabitacion', $text)
				->orLike('t0.snombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidcathabitacion', 'DESC');
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== GET ======
	public function getcathabitacion($nidcathabitacion){
		$builder = $this->conexion('tcathabitacion t0');
		$builder->select("t0.nidcathabitacion idcathabitacion, t0.snombre nombre, t0.bestado estado");
		$builder->where(['nidcathabitacion' => $nidcathabitacion]);
		$query = $builder->get();
		return $query->getRowArray();
	}

//   SECCION ====== GET 2 ======
	public function getCathabitacion2($id){
		$builder = $this->conexion('tcathabitacion t0');
		$builder->select("t0.nidcathabitacion idcathabitacion, t0.snombre nombre, t0.bestado estado");
		$builder->where('t0.nidcathabitacion', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}
//   SECCION ====== COUNT ======
	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('tcathabitacion t0');
		$builder->select('nidcathabitacion');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidcathabitacion', $text)
				->orLike('t0.snombre', $text)
				->groupEnd();
		}

		return $builder->countAllResults();
	}

//   SECCION ====== UPDATE ======
	public function UpdateCathabitacion($nidcathabitacion,  $datos){
		$builder = $this->conexion('tcathabitacion');
		$builder->where(['nidcathabitacion' => $nidcathabitacion]);
		$builder->set($datos);
		$builder->update();
	}

//   SECCION ====== MAXIMO ID ======
	public function getMaxid(){
		$builder = $this->conexion('tcathabitacion');
		$builder->selectMax('nidcathabitacion');
		$query = $builder->get();
		return  $query->getResult()[0]->nidcathabitacion;
	}
}
?>
