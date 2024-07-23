<?php

namespace App\Models;
use CodeIgniter\Model; 

class HorarioticketmapiModel extends Model
{
	protected $table      = 'thorarioticketmapi';
	protected $primaryKey = 'nidhorarioticketmapi';
	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['nidhorarioticketmapi', 'nidhoraticketmapi', 'nidticketmapi', 'nidclientetipo', 'dprecio', 'bestado'];
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
	public function existe($nidhorarioticketmapi, $nidhoraticketmapi, $nidticketmapi, $nidclientetipo){
		return $this->where(['nidhorarioticketmapi' => $nidhorarioticketmapi, 'nidhoraticketmapi' => $nidhoraticketmapi, 'nidticketmapi' => $nidticketmapi, 'nidclientetipo' => $nidclientetipo])->countAllResults();
	}

//   SECCION ====== TODOS ======
	public function getHorarioticketmapis($total, $pag = 1, $todos = 1, $text = ''){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;

		$builder = $this->conexion('thorarioticketmapi t0');

		$builder->select("t0.nidhorarioticketmapi idhorarioticketmapi, t0.dprecio precio, t0.bestado estado, t1.nidclientetipo idclientetipo, t1.snombre nombre, t2.nidhoraticketmapi idhoraticketmapi, t2.snombre nombre, t3.nidticketmapi idticketmapi, t3.snombre nombre, CONCAT('[',t0.dprecio,']',' - ',t1.snombre,' - ',t2.snombre,' - ',t3.snombre) concatenado, CONCAT(t1.snombre,' - ',t2.snombre,' - ',t3.snombre) concatenadodetalle");

		$builder->join('tclientetipo t1', 't1.nidclientetipo = t0.nidclientetipo');
		$builder->join('thoraticketmapi t2', 't2.nidhoraticketmapi = t0.nidhoraticketmapi');
		$builder->join('tticketmapi t3', 't3.nidticketmapi = t0.nidticketmapi');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidhorarioticketmapi', $text)
				->orLike('t0.dprecio', $text)
				->orLike('t1.snombre', $text)
				->orLike('t2.snombre', $text)
				->orLike('t3.snombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidhorarioticketmapi', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== AUTOCOMPLETE ======
	public function getAutocompleteHorarioticketmapis($todos = 1, $text = ''){
		$builder = $this->conexion('thorarioticketmapi t0');

		$builder->select("t0.nidhorarioticketmapi idhorarioticketmapi, t0.dprecio precio, t0.bestado estado, t1.nidclientetipo idclientetipo, t1.snombre nombre, t2.nidhoraticketmapi idhoraticketmapi, t2.snombre nombre, t3.nidticketmapi idticketmapi, t3.snombre nombre, CONCAT('[',t0.dprecio,']',' - ',t1.snombre,' - ',t2.snombre,' - ',t3.snombre) concatenado, CONCAT(t1.snombre,' - ',t2.snombre,' - ',t3.snombre) concatenadodetalle");
		$builder->join('tclientetipo t1', 't1.nidclientetipo = t0.nidclientetipo');
		$builder->join('thoraticketmapi t2', 't2.nidhoraticketmapi = t0.nidhoraticketmapi');
		$builder->join('tticketmapi t3', 't3.nidticketmapi = t0.nidticketmapi');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidhorarioticketmapi', $text)
				->orLike('t0.dprecio', $text)
				->orLike('t1.snombre', $text)
				->orLike('t2.snombre', $text)
				->orLike('t3.snombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidhorarioticketmapi', 'DESC');
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== GET ======
	public function gethorarioticketmapi($nidhorarioticketmapi, $nidhoraticketmapi, $nidticketmapi, $nidclientetipo){
		$builder = $this->conexion('thorarioticketmapi t0');
		$builder->select("t0.nidhorarioticketmapi idhorarioticketmapi, t0.nidhoraticketmapi idhoraticketmapi, t0.nidticketmapi idticketmapi, t0.nidclientetipo idclientetipo, t0.dprecio precio, t0.bestado estado");
		$builder->where(['nidhorarioticketmapi' => $nidhorarioticketmapi, 'nidhoraticketmapi' => $nidhoraticketmapi, 'nidticketmapi' => $nidticketmapi, 'nidclientetipo' => $nidclientetipo]);
		$query = $builder->get();
		return $query->getRowArray();
	}

//   SECCION ====== GET 2 ======
	public function getHorarioticketmapi2($id){
		$builder = $this->conexion('thorarioticketmapi t0');
		$builder->select("t0.nidhorarioticketmapi idhorarioticketmapi, t0.nidhoraticketmapi idhoraticketmapi, t0.nidticketmapi idticketmapi, t0.nidclientetipo idclientetipo, t0.dprecio precio, t0.bestado estado");
		$builder->join('tclientetipo t1', 't1.nidclientetipo = t0.nidclientetipo');
		$builder->join('thoraticketmapi t2', 't2.nidhoraticketmapi = t0.nidhoraticketmapi');
		$builder->join('tticketmapi t3', 't3.nidticketmapi = t0.nidticketmapi');
		$builder->where('t0.nidhorarioticketmapi', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}
//   SECCION ====== COUNT ======
	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('thorarioticketmapi t0');
		$builder->select('nidhorarioticketmapi');
		$builder->join('tclientetipo t1', 't1.nidclientetipo = t0.nidclientetipo');
		$builder->join('thoraticketmapi t2', 't2.nidhoraticketmapi = t0.nidhoraticketmapi');
		$builder->join('tticketmapi t3', 't3.nidticketmapi = t0.nidticketmapi');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidhorarioticketmapi', $text)
				->orLike('t0.dprecio', $text)
				->orLike('t1.snombre', $text)
				->orLike('t2.snombre', $text)
				->orLike('t3.snombre', $text)
				->groupEnd();
		}

		return $builder->countAllResults();
	}

//   SECCION ====== UPDATE ======
	public function UpdateHorarioticketmapi($nidhorarioticketmapi, $nidhoraticketmapi, $nidticketmapi, $nidclientetipo,  $datos){
		$builder = $this->conexion('thorarioticketmapi');
		$builder->where(['nidhorarioticketmapi' => $nidhorarioticketmapi, 'nidhoraticketmapi' => $nidhoraticketmapi, 'nidticketmapi' => $nidticketmapi, 'nidclientetipo' => $nidclientetipo]);
		$builder->set($datos);
		$builder->update();
	}

//   SECCION ====== MAXIMO ID ======
	public function getMaxid(){
		$builder = $this->conexion('thorarioticketmapi');
		$builder->selectMax('nidhorarioticketmapi');
		$query = $builder->get();
		return  $query->getResult()[0]->nidhorarioticketmapi;
	}
}
?>
