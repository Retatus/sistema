<?php 

namespace App\Models;
use CodeIgniter\Model; 

class CattourModel extends Model
{
	protected $table      = 'tcattour';
	protected $primaryKey = 'nidcattour';

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
		return $this->where(['nidcattour' => $id])->countAllResults();
	}

	public function getCattours($todos = 1, $text = '', $total, $pag = 1){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;
		$builder = $this->conexion('tcattour t0');
		$builder->select("t0.nidcattour idcattour, t0.snombre nombre, t0.bestado estado,  CONCAT(t0.snombre) as concatenado, CONCAT(t0.snombre) as concatenadodetalle");

		if ($todos !== '') 
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidcattour', $text);
		$builder->orLike('t0.snombre', $text);

		$builder->orderBy('t0.nidcattour', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getAutocompletecattours($todos = 1, $text = ''){
		$builder = $this->conexion('tcattour t0');
		$builder->select("t0.nidcattour idcattour, t0.snombre nombre, t0.bestado estado,  CONCAT(t0.snombre) as concatenado, CONCAT(t0.snombre) as concatenadodetalle");

		if ($todos !== '') 
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidcattour', $text);
		$builder->orLike('t0.snombre', $text);

		$builder->orderBy('t0.nidcattour', 'DESC');
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getCattour($nidcattour){
		$builder = $this->conexion('tcattour t0');
		$builder->select("t0.nidcattour idcattour, t0.snombre nombre, t0.bestado estado");
		$builder->where(['nidcattour' => $nidcattour]);
		$query = $builder->get();
		return $query->getRowArray();
	}

	public function getCattour2($id){
		$builder = $this->conexion('tcattour t0');
		$builder->select(" t0.nidcattour idcattour0, t0.snombre nombre0, t0.bestado estado0,");

		$builder->where('t0.nidreserva', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('tcattour t0');
		$builder->select('nidcattour');

		if ($todos !== '')
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidcattour', $text);
		$builder->orLike('t0.snombre', $text);

		return $builder->countAllResults();
	}

	public function UpdateCattour($nidcattour, $datos){
		$builder = $this->conexion('tcattour');
		$builder->where(['nidcattour' => $nidcattour]);
		$builder->set($datos);
		$builder->update();
	}

	public function getMaxid(){
		$builder = $this->conexion('tcattour');
		$builder->selectMax('nidcattour');
		$query = $builder->get();
		return  $query->getResult()[0]->nidcattour;
	}
}
?>
