<?php 

namespace App\Models;
use CodeIgniter\Model; 

class TicketbusModel extends Model
{
	protected $table      = 'tticketbus';
	protected $primaryKey = 'nidticketbus';

	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['snombre','sdescripcion','dprecio','bestado'];
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
		return $this->where(['nidticketbus' => $id])->countAllResults();
	}

	public function getTicketbuss($todos = 1, $text = '', $total, $pag = 1){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;
		$builder = $this->conexion('tticketbus t0');
		$builder->select("t0.nidticketbus idticketbus, t0.snombre nombre, t0.sdescripcion descripcion, t0.dprecio precio, t0.bestado estado,  CONCAT(t0.snombre, ' - ', '[' ,t0.dprecio, ']' ) as concatenado, CONCAT(t0.snombre) as concatenadodetalle");

		if ($todos !== '') 
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidticketbus', $text);
		$builder->orLike('t0.snombre', $text);
		$builder->orLike('t0.dprecio', $text);

		$builder->orderBy('t0.nidticketbus', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getAutocompleteticketbuss($todos = 1, $text = ''){
		$builder = $this->conexion('tticketbus t0');
		$builder->select("t0.nidticketbus idticketbus, t0.snombre nombre, t0.sdescripcion descripcion, t0.dprecio precio, t0.bestado estado,  CONCAT(t0.snombre, ' - ', '[' ,t0.dprecio, ']' ) as concatenado, CONCAT(t0.snombre) as concatenadodetalle");

		if ($todos !== '') 
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidticketbus', $text);
		$builder->orLike('t0.snombre', $text);
		$builder->orLike('t0.dprecio', $text);

		$builder->orderBy('t0.nidticketbus', 'DESC');
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getTicketbus($nidticketbus){
		$builder = $this->conexion('tticketbus t0');
		$builder->select("t0.nidticketbus idticketbus, t0.snombre nombre, t0.sdescripcion descripcion, t0.dprecio precio, t0.bestado estado");
		$builder->where(['nidticketbus' => $nidticketbus]);
		$query = $builder->get();
		return $query->getRowArray();
	}

	public function getTicketbus2($id){
		$builder = $this->conexion('tticketbus t0');
		$builder->select(" t0.nidticketbus idticketbus0, t0.snombre nombre0, t0.sdescripcion descripcion0, t0.dprecio precio0, t0.bestado estado0,");

		$builder->where('t0.nidreserva', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('tticketbus t0');
		$builder->select('nidticketbus');

		if ($todos !== '')
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidticketbus', $text);
		$builder->orLike('t0.snombre', $text);
		$builder->orLike('t0.dprecio', $text);

		return $builder->countAllResults();
	}

	public function UpdateTicketbus($nidticketbus, $datos){
		$builder = $this->conexion('tticketbus');
		$builder->where(['nidticketbus' => $nidticketbus]);
		$builder->set($datos);
		$builder->update();
	}

	public function getMaxid(){
		$builder = $this->conexion('tticketbus');
		$builder->selectMax('nidticketbus');
		$query = $builder->get();
		return  $query->getResult()[0]->nidticketbus;
	}
}
?>
