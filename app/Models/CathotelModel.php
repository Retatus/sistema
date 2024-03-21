<?php 

namespace App\Models;
use CodeIgniter\Model; 

class CathotelModel extends Model
{
	protected $table      = 'tcathotel';
	protected $primaryKey = 'nidcathotel';

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
		return $this->where(['nidcathotel' => $id])->countAllResults();
	}

	public function getCathotels($todos = 1, $text = '', $total, $pag = 1){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;
		$builder = $this->conexion('tcathotel t0');
		$builder->select("t0.nidcathotel idcathotel, t0.snombre nombre, t0.bestado estado,  CONCAT(t0.snombre) as concatenado, CONCAT(t0.snombre) as concatenadodetalle");

		if ($todos !== '') 
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidcathotel', $text);
		$builder->orLike('t0.snombre', $text);

		$builder->orderBy('t0.nidcathotel', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getAutocompletecathotels($todos = 1, $text = ''){
		$builder = $this->conexion('tcathotel t0');
		$builder->select("t0.nidcathotel idcathotel, t0.snombre nombre, t0.bestado estado,  CONCAT(t0.snombre) as concatenado, CONCAT(t0.snombre) as concatenadodetalle");

		if ($todos !== '') 
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidcathotel', $text);
		$builder->orLike('t0.snombre', $text);

		$builder->orderBy('t0.nidcathotel', 'DESC');
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getCathotel($id){
		$builder = $this->conexion('tcathotel t0');
		$builder->select("t0.nidcathotel idcathotel, t0.snombre nombre, t0.bestado estado");
		$builder->where('nidcathotel', $id);
		$query = $builder->get();
		return $query->getRowArray();
	}

	public function getCathotel2($id){
		$builder = $this->conexion('tcathotel t0');
		$builder->select(" t0.nidcathotel idcathotel0, t0.snombre nombre0, t0.bestado estado0,");

		$builder->where('t0.nidreserva', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('tcathotel t0');
		$builder->select('nidcathotel');

		if ($todos !== '')
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidcathotel', $text);
		$builder->orLike('t0.snombre', $text);

		return $builder->countAllResults();
	}

	public function UpdateCathotel($id, $datos){
		$builder = $this->conexion('tcathotel');
		$builder->where('nidcathotel', $id);
		$builder->set($datos);
		$builder->update();
	}

	public function getMaxid(){
		$builder = $this->conexion('tcathotel');
		$builder->selectMax('nidcathotel');
		$query = $builder->get();
		return  $query->getResult()[0]->nidcathotel;
	}
}
?>
