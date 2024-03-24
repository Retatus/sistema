<?php 

namespace App\Models;
use CodeIgniter\Model; 

class CathabitacionModel extends Model
{
	protected $table      = 'tcathabitacion';
	protected $primaryKey = 'nidcathabitacion';

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
		return $this->where(['nidcathabitacion' => $id])->countAllResults();
	}

	public function getCathabitacions($todos = 1, $text = '', $total, $pag = 1){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;
		$builder = $this->conexion('tcathabitacion t0');
		$builder->select("t0.nidcathabitacion idcathabitacion, t0.snombre nombre, t0.bestado estado,  CONCAT(t0.snombre) as concatenado, CONCAT(t0.snombre) as concatenadodetalle");

		if ($todos !== '') 
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidcathabitacion', $text);
		$builder->orLike('t0.snombre', $text);

		$builder->orderBy('t0.nidcathabitacion', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getAutocompletecathabitacions($todos = 1, $text = ''){
		$builder = $this->conexion('tcathabitacion t0');
		$builder->select("t0.nidcathabitacion idcathabitacion, t0.snombre nombre, t0.bestado estado,  CONCAT(t0.snombre) as concatenado, CONCAT(t0.snombre) as concatenadodetalle");

		if ($todos !== '') 
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidcathabitacion', $text);
		$builder->orLike('t0.snombre', $text);

		$builder->orderBy('t0.nidcathabitacion', 'DESC');
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getCathabitacion($nidcathabitacion){
		$builder = $this->conexion('tcathabitacion t0');
		$builder->select("t0.nidcathabitacion idcathabitacion, t0.snombre nombre, t0.bestado estado");
		$builder->where(['nidcathabitacion' => $nidcathabitacion]);
		$query = $builder->get();
		return $query->getRowArray();
	}

	public function getCathabitacion2($id){
		$builder = $this->conexion('tcathabitacion t0');
		$builder->select(" t0.nidcathabitacion idcathabitacion0, t0.snombre nombre0, t0.bestado estado0,");

		$builder->where('t0.nidreserva', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('tcathabitacion t0');
		$builder->select('nidcathabitacion');

		if ($todos !== '')
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidcathabitacion', $text);
		$builder->orLike('t0.snombre', $text);

		return $builder->countAllResults();
	}

	public function UpdateCathabitacion($nidcathabitacion, $datos){
		$builder = $this->conexion('tcathabitacion');
		$builder->where(['nidcathabitacion' => $nidcathabitacion]);
		$builder->set($datos);
		$builder->update();
	}

	public function getMaxid(){
		$builder = $this->conexion('tcathabitacion');
		$builder->selectMax('nidcathabitacion');
		$query = $builder->get();
		return  $query->getResult()[0]->nidcathabitacion;
	}
}
?>
