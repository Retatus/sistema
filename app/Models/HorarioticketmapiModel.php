<?php 

namespace App\Models;
use CodeIgniter\Model; 

class HorarioticketmapiModel extends Model
{
	protected $table      = 'thorarioticketmapi';
	protected $primaryKey = 'nidhorarioticketmapi';

	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['nidhoraticketmapi','nidticketmapi','nidclientetipo','dprecio','bestado'];
	protected $useTimestamps = false;
	protected $createdField  = 'tfecha_alt';
	protected $updatedField  = 'tfecha_edi';
	protected $deletedField  = 'deleted_at';

	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = false;

	protected function conexion(string $table = null){
		$this->db = \Config\Database::connect();
		$this->builder = $this->db->table($table);
		return $this->builder;
	}

	public function existe($id){
		return $this->where(['nidhorarioticketmapi' => $id])->countAllResults();
	}

	public function getHorarioticketmapis($todos = 1, $text = '', $total, $pag = 1){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;
		$builder = $this->conexion('thorarioticketmapi t0');
		$builder->select("t0.nidhorarioticketmapi idhorarioticketmapi, t0.nidhoraticketmapi idhoraticketmapi, t0.nidticketmapi idticketmapi, t0.nidclientetipo idclientetipo, t0.dprecio precio, t0.bestado estado,  t1.nidclientetipo idclientetipo, t1.snombre nombre, t2.nidhoraticketmapi idhoraticketmapi, t2.snombre nombre, t3.nidticketmapi idticketmapi, t3.snombre nombre, CONCAT('[' ,t0.dprecio, ']' , ' - ', t3.snombre, ' - ', t2.snombre, ' - ', t1.snombre) as concatenado, CONCAT(t3.snombre, ' - ', t2.snombre, ' - ', t1.snombre) as concatenadodetalle");
		$builder->join('tclientetipo t1', ' t1.nidclientetipo = t0.nidclientetipo');
		$builder->join('thoraticketmapi t2', ' t2.nidhoraticketmapi = t0.nidhoraticketmapi');
		$builder->join('tticketmapi t3', ' t3.nidticketmapi = t0.nidticketmapi');

		if ($todos !== '') 
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidhorarioticketmapi', $text);
		$builder->orLike('t0.dprecio', $text);
		$builder->orLike('t3.snombre', $text);
		$builder->orLike('t2.snombre', $text);
		$builder->orLike('t1.snombre', $text);

		$builder->orderBy('t0.nidhorarioticketmapi', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getAutocompletehorarioticketmapis($todos = 1, $text = ''){
		$builder = $this->conexion('thorarioticketmapi t0');
		$builder->select("t0.nidhorarioticketmapi idhorarioticketmapi, t0.nidhoraticketmapi idhoraticketmapi, t0.nidticketmapi idticketmapi, t0.nidclientetipo idclientetipo, t0.dprecio precio, t0.bestado estado,  t1.nidclientetipo idclientetipo, t1.snombre nombre, t2.nidhoraticketmapi idhoraticketmapi, t2.snombre nombre, t3.nidticketmapi idticketmapi, t3.snombre nombre, CONCAT('[' ,t0.dprecio, ']' , ' - ', t3.snombre, ' - ', t2.snombre, ' - ', t1.snombre) as concatenado, CONCAT(t3.snombre, ' - ', t2.snombre, ' - ', t1.snombre) as concatenadodetalle");
		$builder->join('tclientetipo t1', ' t1.nidclientetipo = t0.nidclientetipo');
		$builder->join('thoraticketmapi t2', ' t2.nidhoraticketmapi = t0.nidhoraticketmapi');
		$builder->join('tticketmapi t3', ' t3.nidticketmapi = t0.nidticketmapi');

		if ($todos !== '') 
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidhorarioticketmapi', $text);
		$builder->orLike('t0.dprecio', $text);
		$builder->orLike('t3.snombre', $text);
		$builder->orLike('t2.snombre', $text);
		$builder->orLike('t1.snombre', $text);

		$builder->orderBy('t0.nidhorarioticketmapi', 'DESC');
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getHorarioticketmapi($id){
		$builder = $this->conexion('thorarioticketmapi t0');
		$builder->select("t0.nidhorarioticketmapi idhorarioticketmapi, t0.nidhoraticketmapi idhoraticketmapi, t0.nidticketmapi idticketmapi, t0.nidclientetipo idclientetipo, t0.dprecio precio, t0.bestado estado");
		$builder->where('nidhorarioticketmapi', $id);
		$query = $builder->get();
		return $query->getRowArray();
	}

	public function getHorarioticketmapi2($id){
		$builder = $this->conexion('thorarioticketmapi t0');
		$builder->select(" t0.nidhorarioticketmapi idhorarioticketmapi0, t0.dprecio precio0, t0.bestado estado0, t1.nidhoraticketmapi idhoraticketmapi1, t1.snombre nombre1, t1.bestado estado1, t2.nidticketmapi idticketmapi2, t2.snombre nombre2, t2.bestado estado2, t3.nidclientetipo idclientetipo3, t3.snombre nombre3, t3.bestado estado3,");
		$builder->join('thoraticketmapi t1', ' t0.nidhoraticketmapi = t1.nidhoraticketmapi');
		$builder->join('tticketmapi t2', ' t0.nidticketmapi = t2.nidticketmapi');
		$builder->join('tclientetipo t3', ' t0.nidclientetipo = t3.nidclientetipo');

		$builder->where('t0.nidreserva', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('thorarioticketmapi t0');
		$builder->select('nidhorarioticketmapi');
		$builder->join('tclientetipo t1', ' t1.nidclientetipo = t0.nidclientetipo');
		$builder->join('thoraticketmapi t2', ' t2.nidhoraticketmapi = t0.nidhoraticketmapi');
		$builder->join('tticketmapi t3', ' t3.nidticketmapi = t0.nidticketmapi');

		if ($todos !== '')
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidhorarioticketmapi', $text);
		$builder->orLike('t0.dprecio', $text);
		$builder->orLike('t3.snombre', $text);
		$builder->orLike('t2.snombre', $text);
		$builder->orLike('t1.snombre', $text);

		return $builder->countAllResults();
	}

	public function UpdateHorarioticketmapi($id, $datos){
		$builder = $this->conexion('thorarioticketmapi');
		$builder->where('nidhorarioticketmapi', $id);
		$builder->set($datos);
		$builder->update();
	}

	public function getMaxid(){
		$builder = $this->conexion('thorarioticketmapi');
		$builder->selectMax('nidhorarioticketmapi');
		$query = $builder->get();
		return  $query->getResult()[0]->nidhorarioticketmapi;
	}
}
?>
