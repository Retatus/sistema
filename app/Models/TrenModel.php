<?php

namespace App\Models;
use CodeIgniter\Model; 

class TrenModel extends Model
{
	protected $table      = 'ttren';
	protected $primaryKey = 'nidtren';
	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['nidtren', 'snombre', 'sempresa', 'bestado'];
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
	public function existe($nidtren){
		return $this->where(['nidtren' => $nidtren])->countAllResults();
	}

//   SECCION ====== TODOS ======
	public function getTrens($total, $pag = 1, $todos = 1, $text = ''){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;

		$builder = $this->conexion('ttren t0');

		$builder->select("t0.nidtren idtren, t0.snombre nombre, t0.sempresa empresa, t0.bestado estado, CONCAT(t0.snombre) concatenado, CONCAT(t0.snombre) concatenadodetalle");


		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidtren', $text)
				->orLike('t0.snombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidtren', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== AUTOCOMPLETE ======
	public function getAutocompleteTrens($todos = 1, $text = ''){
		$builder = $this->conexion('ttren t0');

		$builder->select("t0.nidtren idtren, t0.snombre nombre, t0.sempresa empresa, t0.bestado estado, CONCAT(t0.snombre) concatenado, CONCAT(t0.snombre) concatenadodetalle");

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidtren', $text)
				->orLike('t0.snombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidtren', 'DESC');
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== GET ======
	public function gettren($nidtren){
		$builder = $this->conexion('ttren t0');
		$builder->select("t0.nidtren idtren, t0.snombre nombre, t0.sempresa empresa, t0.bestado estado");
		$builder->where(['nidtren' => $nidtren]);
		$query = $builder->get();
		return $query->getRowArray();
	}

//   SECCION ====== GET 2 ======
	public function getTren2($id){
		$builder = $this->conexion('ttren t0');
		$builder->select("t0.nidtren idtren, t0.snombre nombre, t0.sempresa empresa, t0.bestado estado");
		$builder->where('t0.nidtren', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}
//   SECCION ====== COUNT ======
	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('ttren t0');
		$builder->select('nidtren');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidtren', $text)
				->orLike('t0.snombre', $text)
				->groupEnd();
		}

		return $builder->countAllResults();
	}

//   SECCION ====== UPDATE ======
	public function UpdateTren($nidtren,  $datos){
		$builder = $this->conexion('ttren');
		$builder->where(['nidtren' => $nidtren]);
		$builder->set($datos);
		$builder->update();
	}

//   SECCION ====== MAXIMO ID ======
	public function getMaxid(){
		$builder = $this->conexion('ttren');
		$builder->selectMax('nidtren');
		$query = $builder->get();
		return  $query->getResult()[0]->nidtren;
	}
}
?>
