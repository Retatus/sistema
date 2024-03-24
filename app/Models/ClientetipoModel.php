<?php 

namespace App\Models;
use CodeIgniter\Model; 

class ClientetipoModel extends Model
{
	protected $table      = 'tclientetipo';
	protected $primaryKey = 'nidclientetipo';

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
		return $this->where(['nidclientetipo' => $id])->countAllResults();
	}

	public function getClientetipos($todos = 1, $text = '', $total, $pag = 1){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;
		$builder = $this->conexion('tclientetipo t0');
		$builder->select("t0.nidclientetipo idclientetipo, t0.snombre nombre, t0.bestado estado,  CONCAT(t0.snombre) as concatenado, CONCAT(t0.snombre) as concatenadodetalle");

		if ($todos !== '') 
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidclientetipo', $text);
		$builder->orLike('t0.snombre', $text);

		$builder->orderBy('t0.nidclientetipo', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getAutocompleteclientetipos($todos = 1, $text = ''){
		$builder = $this->conexion('tclientetipo t0');
		$builder->select("t0.nidclientetipo idclientetipo, t0.snombre nombre, t0.bestado estado,  CONCAT(t0.snombre) as concatenado, CONCAT(t0.snombre) as concatenadodetalle");

		if ($todos !== '') 
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidclientetipo', $text);
		$builder->orLike('t0.snombre', $text);

		$builder->orderBy('t0.nidclientetipo', 'DESC');
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getClientetipo($nidclientetipo){
		$builder = $this->conexion('tclientetipo t0');
		$builder->select("t0.nidclientetipo idclientetipo, t0.snombre nombre, t0.bestado estado");
		$builder->where(['nidclientetipo' => $nidclientetipo]);
		$query = $builder->get();
		return $query->getRowArray();
	}

	public function getClientetipo2($id){
		$builder = $this->conexion('tclientetipo t0');
		$builder->select(" t0.nidclientetipo idclientetipo0, t0.snombre nombre0, t0.bestado estado0,");

		$builder->where('t0.nidreserva', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('tclientetipo t0');
		$builder->select('nidclientetipo');

		if ($todos !== '')
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidclientetipo', $text);
		$builder->orLike('t0.snombre', $text);

		return $builder->countAllResults();
	}

	public function UpdateClientetipo($nidclientetipo, $datos){
		$builder = $this->conexion('tclientetipo');
		$builder->where(['nidclientetipo' => $nidclientetipo]);
		$builder->set($datos);
		$builder->update();
	}

	public function getMaxid(){
		$builder = $this->conexion('tclientetipo');
		$builder->selectMax('nidclientetipo');
		$query = $builder->get();
		return  $query->getResult()[0]->nidclientetipo;
	}
}
?>
