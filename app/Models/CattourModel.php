<?php

namespace App\Models;
use CodeIgniter\Model; 

class CattourModel extends Model
{
	protected $table      = 'tcattour';
	protected $primaryKey = 'nidcattour';
	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['nidcattour', 'snombre', 'bestado'];
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
	public function existe($nidcattour){
		return $this->where(['nidcattour' => $nidcattour])->countAllResults();
	}

//   SECCION ====== TODOS ======
	public function getCattours($total, $pag = 1, $todos = 1, $text = ''){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;

		$builder = $this->conexion('tcattour t0');

		$builder->select("t0.nidcattour idcattour, t0.snombre nombre, t0.bestado estado, CONCAT(t0.snombre) concatenado, CONCAT(t0.snombre) concatenadodetalle");


		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidcattour', $text)
				->orLike('t0.snombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidcattour', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== AUTOCOMPLETE ======
	public function getAutocompleteCattours($todos = 1, $text = ''){
		$builder = $this->conexion('tcattour t0');

		$builder->select("t0.nidcattour idcattour, t0.snombre nombre, t0.bestado estado, CONCAT(t0.snombre) concatenado, CONCAT(t0.snombre) concatenadodetalle");

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidcattour', $text)
				->orLike('t0.snombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidcattour', 'DESC');
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== GET ======
	public function getcattour($nidcattour){
		$builder = $this->conexion('tcattour t0');
		$builder->select("t0.nidcattour idcattour, t0.snombre nombre, t0.bestado estado");
		$builder->where(['nidcattour' => $nidcattour]);
		$query = $builder->get();
		return $query->getRowArray();
	}

//   SECCION ====== GET 2 ======
	public function getCattour2($id){
		$builder = $this->conexion('tcattour t0');
		$builder->select("t0.nidcattour idcattour, t0.snombre nombre, t0.bestado estado");
		$builder->where('t0.nidcattour', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}
//   SECCION ====== COUNT ======
	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('tcattour t0');
		$builder->select('nidcattour');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidcattour', $text)
				->orLike('t0.snombre', $text)
				->groupEnd();
		}

		return $builder->countAllResults();
	}

//   SECCION ====== UPDATE ======
	public function UpdateCattour($nidcattour,  $datos){
		$builder = $this->conexion('tcattour');
		$builder->where(['nidcattour' => $nidcattour]);
		$builder->set($datos);
		$builder->update();
	}

//   SECCION ====== MAXIMO ID ======
	public function getMaxid(){
		$builder = $this->conexion('tcattour');
		$builder->selectMax('nidcattour');
		$query = $builder->get();
		return  $query->getResult()[0]->nidcattour;
	}
}
?>
