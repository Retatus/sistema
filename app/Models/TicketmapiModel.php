<?php 

namespace App\Models;
use CodeIgniter\Model; 

class TicketmapiModel extends Model
{
	protected $table      = 'tticketmapi';
	protected $primaryKey = 'nidticketmapi';

	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['snombre','bestado'];
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
		return $this->where(['nidticketmapi' => $id])->countAllResults();
	}

	public function getTicketmapis($todos = 1, $text = '', $total, $pag = 1){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;
		$builder = $this->conexion('tticketmapi t0');
		$builder->select("t0.nidticketmapi idticketmapi, t0.snombre nombre, t0.bestado estado,  CONCAT(t0.snombre) as concatenado, CONCAT(t0.snombre) as concatenadodetalle");

		if ($todos !== '') 
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidticketmapi', $text);
		$builder->orLike('t0.snombre', $text);

		$builder->orderBy('t0.nidticketmapi', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getAutocompleteticketmapis($todos = 1, $text = ''){
		$builder = $this->conexion('tticketmapi t0');
		$builder->select("t0.nidticketmapi idticketmapi, t0.snombre nombre, t0.bestado estado,  CONCAT(t0.snombre) as concatenado, CONCAT(t0.snombre) as concatenadodetalle");

		if ($todos !== '') 
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidticketmapi', $text);
		$builder->orLike('t0.snombre', $text);

		$builder->orderBy('t0.nidticketmapi', 'DESC');
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getTicketmapi($id){
		$builder = $this->conexion('tticketmapi t0');
		$builder->select("t0.nidticketmapi idticketmapi, t0.snombre nombre, t0.bestado estado");
		$builder->where('nidticketmapi', $id);
		$query = $builder->get();
		return $query->getRowArray();
	}

	public function getTicketmapi2($id){
		$builder = $this->conexion('tticketmapi t0');
		$builder->select(" t0.nidticketmapi idticketmapi0, t0.snombre nombre0, t0.bestado estado0,");

		$builder->where('t0.nidreserva', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('tticketmapi t0');
		$builder->select('nidticketmapi');

		if ($todos !== '')
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidticketmapi', $text);
		$builder->orLike('t0.snombre', $text);

		return $builder->countAllResults();
	}

	public function UpdateTicketmapi($id, $datos){
		$builder = $this->conexion('tticketmapi');
		$builder->where('nidticketmapi', $id);
		$builder->set($datos);
		$builder->update();
	}

	public function getMaxid(){
		$builder = $this->conexion('tticketmapi');
		$builder->selectMax('nidticketmapi');
		$query = $builder->get();
		return  $query->getResult()[0]->nidticketmapi;
	}
}
?>
