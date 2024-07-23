<?php

namespace App\Models;
use CodeIgniter\Model; 

class BancoModel extends Model
{
	protected $table      = 'tbanco';
	protected $primaryKey = 'nidbanco';
	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['nidbanco', 'snombre', 'bestado'];
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
	public function existe($nidbanco){
		return $this->where(['nidbanco' => $nidbanco])->countAllResults();
	}

//   SECCION ====== TODOS ======
	public function getBancos($total, $pag = 1, $todos = 1, $text = ''){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;

		$builder = $this->conexion('tbanco t0');

		$builder->select("t0.nidbanco idbanco, t0.snombre nombre, t0.bestado estado, CONCAT(t0.snombre) concatenado, CONCAT(t0.snombre) concatenadodetalle");


		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidbanco', $text)
				->orLike('t0.snombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidbanco', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== AUTOCOMPLETE ======
	public function getAutocompleteBancos($todos = 1, $text = ''){
		$builder = $this->conexion('tbanco t0');

		$builder->select("t0.nidbanco idbanco, t0.snombre nombre, t0.bestado estado, CONCAT(t0.snombre) concatenado, CONCAT(t0.snombre) concatenadodetalle");

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidbanco', $text)
				->orLike('t0.snombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidbanco', 'DESC');
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== GET ======
	public function getbanco($nidbanco){
		$builder = $this->conexion('tbanco t0');
		$builder->select("t0.nidbanco idbanco, t0.snombre nombre, t0.bestado estado");
		$builder->where(['nidbanco' => $nidbanco]);
		$query = $builder->get();
		return $query->getRowArray();
	}

//   SECCION ====== GET 2 ======
	public function getBanco2($id){
		$builder = $this->conexion('tbanco t0');
		$builder->select("t0.nidbanco idbanco, t0.snombre nombre, t0.bestado estado");
		$builder->where('t0.nidbanco', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}
//   SECCION ====== COUNT ======
	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('tbanco t0');
		$builder->select('nidbanco');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidbanco', $text)
				->orLike('t0.snombre', $text)
				->groupEnd();
		}

		return $builder->countAllResults();
	}

//   SECCION ====== UPDATE ======
	public function UpdateBanco($nidbanco,  $datos){
		$builder = $this->conexion('tbanco');
		$builder->where(['nidbanco' => $nidbanco]);
		$builder->set($datos);
		$builder->update();
	}

//   SECCION ====== MAXIMO ID ======
	public function getMaxid(){
		$builder = $this->conexion('tbanco');
		$builder->selectMax('nidbanco');
		$query = $builder->get();
		return  $query->getResult()[0]->nidbanco;
	}
}
?>
