<?php

namespace App\Models;
use CodeIgniter\Model; 

class TicketmapiModel extends Model
{
	protected $table      = 'tticketmapi';
	protected $primaryKey = 'nidticketmapi';
	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['nidticketmapi', 'snombre', 'bestado'];
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
	public function existe($nidticketmapi){
		return $this->where(['nidticketmapi' => $nidticketmapi])->countAllResults();
	}

//   SECCION ====== TODOS ======
	public function getTicketmapis($total, $pag = 1, $todos = 1, $text = ''){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;

		$builder = $this->conexion('tticketmapi t0');

		$builder->select("t0.nidticketmapi idticketmapi, t0.snombre nombre, t0.bestado estado, CONCAT(t0.snombre) concatenado, CONCAT(t0.snombre) concatenadodetalle");


		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidticketmapi', $text)
				->orLike('t0.snombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidticketmapi', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== AUTOCOMPLETE ======
	public function getAutocompleteTicketmapis($todos = 1, $text = ''){
		$builder = $this->conexion('tticketmapi t0');

		$builder->select("t0.nidticketmapi idticketmapi, t0.snombre nombre, t0.bestado estado, CONCAT(t0.snombre) concatenado, CONCAT(t0.snombre) concatenadodetalle");

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidticketmapi', $text)
				->orLike('t0.snombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidticketmapi', 'DESC');
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== GET ======
	public function getticketmapi($nidticketmapi){
		$builder = $this->conexion('tticketmapi t0');
		$builder->select("t0.nidticketmapi idticketmapi, t0.snombre nombre, t0.bestado estado");
		$builder->where(['nidticketmapi' => $nidticketmapi]);
		$query = $builder->get();
		return $query->getRowArray();
	}

//   SECCION ====== GET 2 ======
	public function getTicketmapi2($id){
		$builder = $this->conexion('tticketmapi t0');
		$builder->select("t0.nidticketmapi idticketmapi, t0.snombre nombre, t0.bestado estado");
		$builder->where('t0.nidticketmapi', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}
//   SECCION ====== COUNT ======
	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('tticketmapi t0');
		$builder->select('nidticketmapi');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidticketmapi', $text)
				->orLike('t0.snombre', $text)
				->groupEnd();
		}

		return $builder->countAllResults();
	}

//   SECCION ====== UPDATE ======
	public function UpdateTicketmapi($nidticketmapi,  $datos){
		$builder = $this->conexion('tticketmapi');
		$builder->where(['nidticketmapi' => $nidticketmapi]);
		$builder->set($datos);
		$builder->update();
	}

//   SECCION ====== MAXIMO ID ======
	public function getMaxid(){
		$builder = $this->conexion('tticketmapi');
		$builder->selectMax('nidticketmapi');
		$query = $builder->get();
		return  $query->getResult()[0]->nidticketmapi;
	}
}
?>
