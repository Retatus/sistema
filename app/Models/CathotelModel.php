<?php

namespace App\Models;
use CodeIgniter\Model; 

class CathotelModel extends Model
{
	protected $table      = 'tcathotel';
	protected $primaryKey = 'nidcathotel';
	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['nidcathotel', 'snombre', 'bestado'];
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
	public function existe($nidcathotel){
		return $this->where(['nidcathotel' => $nidcathotel])->countAllResults();
	}

//   SECCION ====== TODOS ======
	public function getCathotels($total, $pag = 1, $todos = 1, $text = ''){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;

		$builder = $this->conexion('tcathotel t0');

		$builder->select("t0.nidcathotel idcathotel, t0.snombre nombre, t0.bestado estado, CONCAT(t0.snombre) concatenado, CONCAT(t0.snombre) concatenadodetalle");


		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidcathotel', $text)
				->orLike('t0.snombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidcathotel', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== AUTOCOMPLETE ======
	public function getAutocompleteCathotels($todos = 1, $text = ''){
		$builder = $this->conexion('tcathotel t0');

		$builder->select("t0.nidcathotel idcathotel, t0.snombre nombre, t0.bestado estado, CONCAT(t0.snombre) concatenado, CONCAT(t0.snombre) concatenadodetalle");

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidcathotel', $text)
				->orLike('t0.snombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidcathotel', 'DESC');
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== GET ======
	public function getcathotel($nidcathotel){
		$builder = $this->conexion('tcathotel t0');
		$builder->select("t0.nidcathotel idcathotel, t0.snombre nombre, t0.bestado estado");
		$builder->where(['nidcathotel' => $nidcathotel]);
		$query = $builder->get();
		return $query->getRowArray();
	}

//   SECCION ====== GET 2 ======
	public function getCathotel2($id){
		$builder = $this->conexion('tcathotel t0');
		$builder->select("t0.nidcathotel idcathotel, t0.snombre nombre, t0.bestado estado");
		$builder->where('t0.nidcathotel', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}
//   SECCION ====== COUNT ======
	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('tcathotel t0');
		$builder->select('nidcathotel');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidcathotel', $text)
				->orLike('t0.snombre', $text)
				->groupEnd();
		}

		return $builder->countAllResults();
	}

//   SECCION ====== UPDATE ======
	public function UpdateCathotel($nidcathotel,  $datos){
		$builder = $this->conexion('tcathotel');
		$builder->where(['nidcathotel' => $nidcathotel]);
		$builder->set($datos);
		$builder->update();
	}

//   SECCION ====== MAXIMO ID ======
	public function getMaxid(){
		$builder = $this->conexion('tcathotel');
		$builder->selectMax('nidcathotel');
		$query = $builder->get();
		return  $query->getResult()[0]->nidcathotel;
	}
}
?>
