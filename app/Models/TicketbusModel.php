<?php

namespace App\Models;
use CodeIgniter\Model; 

class TicketbusModel extends Model
{
	protected $table      = 'tticketbus';
	protected $primaryKey = 'nidticketbus';
	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['nidticketbus', 'snombre', 'sdescripcion', 'dprecio', 'bestado'];
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
	public function existe($nidticketbus){
		return $this->where(['nidticketbus' => $nidticketbus])->countAllResults();
	}

//   SECCION ====== TODOS ======
	public function getTicketbuss($total, $pag = 1, $todos = 1, $text = ''){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;

		$builder = $this->conexion('tticketbus t0');

		$builder->select("t0.nidticketbus idticketbus, t0.snombre nombre, t0.sdescripcion descripcion, t0.dprecio precio, t0.bestado estado, CONCAT('[',t0.dprecio,']',' - ',t0.snombre) concatenado, CONCAT(t0.snombre) concatenadodetalle");


		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidticketbus', $text)
				->orLike('t0.dprecio', $text)
				->orLike('t0.snombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidticketbus', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== AUTOCOMPLETE ======
	public function getAutocompleteTicketbuss($todos = 1, $text = ''){
		$builder = $this->conexion('tticketbus t0');

		$builder->select("t0.nidticketbus idticketbus, t0.snombre nombre, t0.sdescripcion descripcion, t0.dprecio precio, t0.bestado estado, CONCAT('[',t0.dprecio,']',' - ',t0.snombre) concatenado, CONCAT(t0.snombre) concatenadodetalle");

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidticketbus', $text)
				->orLike('t0.dprecio', $text)
				->orLike('t0.snombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidticketbus', 'DESC');
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== GET ======
	public function getticketbus($nidticketbus){
		$builder = $this->conexion('tticketbus t0');
		$builder->select("t0.nidticketbus idticketbus, t0.snombre nombre, t0.sdescripcion descripcion, t0.dprecio precio, t0.bestado estado");
		$builder->where(['nidticketbus' => $nidticketbus]);
		$query = $builder->get();
		return $query->getRowArray();
	}

//   SECCION ====== GET 2 ======
	public function getTicketbus2($id){
		$builder = $this->conexion('tticketbus t0');
		$builder->select("t0.nidticketbus idticketbus, t0.snombre nombre, t0.sdescripcion descripcion, t0.dprecio precio, t0.bestado estado");
		$builder->where('t0.nidticketbus', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}
//   SECCION ====== COUNT ======
	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('tticketbus t0');
		$builder->select('nidticketbus');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidticketbus', $text)
				->orLike('t0.dprecio', $text)
				->orLike('t0.snombre', $text)
				->groupEnd();
		}

		return $builder->countAllResults();
	}

//   SECCION ====== UPDATE ======
	public function UpdateTicketbus($nidticketbus,  $datos){
		$builder = $this->conexion('tticketbus');
		$builder->where(['nidticketbus' => $nidticketbus]);
		$builder->set($datos);
		$builder->update();
	}

//   SECCION ====== MAXIMO ID ======
	public function getMaxid(){
		$builder = $this->conexion('tticketbus');
		$builder->selectMax('nidticketbus');
		$query = $builder->get();
		return  $query->getResult()[0]->nidticketbus;
	}
}
?>
