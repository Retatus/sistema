<?php

namespace App\Models;
use CodeIgniter\Model; 

class TipodocModel extends Model
{
	protected $table      = 'ttipodoc';
	protected $primaryKey = 'nidtipodoc';
	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['nidtipodoc', 'snombre', 'bestado'];
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
	public function existe($nidtipodoc){
		return $this->where(['nidtipodoc' => $nidtipodoc])->countAllResults();
	}

//   SECCION ====== TODOS ======
	public function getTipodocs($total, $pag = 1, $todos = 1, $text = ''){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;

		$builder = $this->conexion('ttipodoc t0');

		$builder->select("t0.nidtipodoc idtipodoc, t0.snombre nombre, t0.bestado estado, CONCAT(t0.snombre) concatenado, CONCAT(t0.snombre) concatenadodetalle");


		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidtipodoc', $text)
				->orLike('t0.snombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidtipodoc', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== AUTOCOMPLETE ======
	public function getAutocompleteTipodocs($todos = 1, $text = ''){
		$builder = $this->conexion('ttipodoc t0');

		$builder->select("t0.nidtipodoc idtipodoc, t0.snombre nombre, t0.bestado estado, CONCAT(t0.snombre) concatenado, CONCAT(t0.snombre) concatenadodetalle");

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidtipodoc', $text)
				->orLike('t0.snombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidtipodoc', 'DESC');
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== GET ======
	public function gettipodoc($nidtipodoc){
		$builder = $this->conexion('ttipodoc t0');
		$builder->select("t0.nidtipodoc idtipodoc, t0.snombre nombre, t0.bestado estado");
		$builder->where(['nidtipodoc' => $nidtipodoc]);
		$query = $builder->get();
		return $query->getRowArray();
	}

//   SECCION ====== GET 2 ======
	public function getTipodoc2($id){
		$builder = $this->conexion('ttipodoc t0');
		$builder->select("t0.nidtipodoc idtipodoc, t0.snombre nombre, t0.bestado estado");
		$builder->where('t0.nidtipodoc', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}
//   SECCION ====== COUNT ======
	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('ttipodoc t0');
		$builder->select('nidtipodoc');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidtipodoc', $text)
				->orLike('t0.snombre', $text)
				->groupEnd();
		}

		return $builder->countAllResults();
	}

//   SECCION ====== UPDATE ======
	public function UpdateTipodoc($nidtipodoc,  $datos){
		$builder = $this->conexion('ttipodoc');
		$builder->where(['nidtipodoc' => $nidtipodoc]);
		$builder->set($datos);
		$builder->update();
	}

//   SECCION ====== MAXIMO ID ======
	public function getMaxid(){
		$builder = $this->conexion('ttipodoc');
		$builder->selectMax('nidtipodoc');
		$query = $builder->get();
		return  $query->getResult()[0]->nidtipodoc;
	}
}
?>
