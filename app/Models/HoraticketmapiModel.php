<?php 

namespace App\Models;
use CodeIgniter\Model; 

class HoraticketmapiModel extends Model
{
	protected $table      = 'thoraticketmapi';
	protected $primaryKey = 'nidhoraticketmapi';

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
		return $this->where(['nidhoraticketmapi' => $id])->countAllResults();
	}

	public function getHoraticketmapis($todos = 1, $text = '', $total, $pag = 1){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;
		$builder = $this->conexion('thoraticketmapi t0');
		$builder->select("t0.nidhoraticketmapi idhoraticketmapi, t0.snombre nombre, t0.bestado estado,  CONCAT(t0.snombre) as concatenado, CONCAT(t0.snombre) as concatenadodetalle");

		if ($todos !== '') 
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidhoraticketmapi', $text);
		$builder->orLike('t0.snombre', $text);

		$builder->orderBy('t0.nidhoraticketmapi', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getAutocompletehoraticketmapis($todos = 1, $text = ''){
		$builder = $this->conexion('thoraticketmapi t0');
		$builder->select("t0.nidhoraticketmapi idhoraticketmapi, t0.snombre nombre, t0.bestado estado,  CONCAT(t0.snombre) as concatenado, CONCAT(t0.snombre) as concatenadodetalle");

		if ($todos !== '') 
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidhoraticketmapi', $text);
		$builder->orLike('t0.snombre', $text);

		$builder->orderBy('t0.nidhoraticketmapi', 'DESC');
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getHoraticketmapi($nidhoraticketmapi){
		$builder = $this->conexion('thoraticketmapi t0');
		$builder->select("t0.nidhoraticketmapi idhoraticketmapi, t0.snombre nombre, t0.bestado estado");
		$builder->where(['nidhoraticketmapi' => $nidhoraticketmapi]);
		$query = $builder->get();
		return $query->getRowArray();
	}

	public function getHoraticketmapi2($id){
		$builder = $this->conexion('thoraticketmapi t0');
		$builder->select(" t0.nidhoraticketmapi idhoraticketmapi0, t0.snombre nombre0, t0.bestado estado0,");

		$builder->where('t0.nidreserva', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('thoraticketmapi t0');
		$builder->select('nidhoraticketmapi');

		if ($todos !== '')
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidhoraticketmapi', $text);
		$builder->orLike('t0.snombre', $text);

		return $builder->countAllResults();
	}

	public function UpdateHoraticketmapi($nidhoraticketmapi, $datos){
		$builder = $this->conexion('thoraticketmapi');
		$builder->where(['nidhoraticketmapi' => $nidhoraticketmapi]);
		$builder->set($datos);
		$builder->update();
	}

	public function getMaxid(){
		$builder = $this->conexion('thoraticketmapi');
		$builder->selectMax('nidhoraticketmapi');
		$query = $builder->get();
		return  $query->getResult()[0]->nidhoraticketmapi;
	}
}
?>
