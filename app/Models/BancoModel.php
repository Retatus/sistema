<?php 

namespace App\Models;
use CodeIgniter\Model; 

class BancoModel extends Model
{
	protected $table      = 'tbanco';
	protected $primaryKey = 'nidbanco';

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
		return $this->where(['nidbanco' => $id])->countAllResults();
	}

	public function getBancos($todos = 1, $text = '', $total, $pag = 1){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;
		$builder = $this->conexion('tbanco t0');
		$builder->select("t0.nidbanco idbanco, t0.snombre nombre, t0.bestado estado,  CONCAT(t0.snombre) as concatenado, CONCAT(t0.snombre) as concatenadodetalle");

		if ($todos !== '') 
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidbanco', $text);
		$builder->orLike('t0.snombre', $text);

		$builder->orderBy('t0.nidbanco', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getAutocompletebancos($todos = 1, $text = ''){
		$builder = $this->conexion('tbanco t0');
		$builder->select("t0.nidbanco idbanco, t0.snombre nombre, t0.bestado estado,  CONCAT(t0.snombre) as concatenado, CONCAT(t0.snombre) as concatenadodetalle");

		if ($todos !== '') 
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidbanco', $text);
		$builder->orLike('t0.snombre', $text);

		$builder->orderBy('t0.nidbanco', 'DESC');
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getBanco($nidbanco){
		$builder = $this->conexion('tbanco t0');
		$builder->select("t0.nidbanco idbanco, t0.snombre nombre, t0.bestado estado");
		$builder->where(['nidbanco' => $nidbanco]);
		$query = $builder->get();
		return $query->getRowArray();
	}

	public function getBanco2($id){
		$builder = $this->conexion('tbanco t0');
		$builder->select(" t0.nidbanco idbanco0, t0.snombre nombre0, t0.bestado estado0,");

		$builder->where('t0.nidreserva', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('tbanco t0');
		$builder->select('nidbanco');

		if ($todos !== '')
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidbanco', $text);
		$builder->orLike('t0.snombre', $text);

		return $builder->countAllResults();
	}

	public function UpdateBanco($nidbanco, $datos){
		$builder = $this->conexion('tbanco');
		$builder->where(['nidbanco' => $nidbanco]);
		$builder->set($datos);
		$builder->update();
	}

	public function getMaxid(){
		$builder = $this->conexion('tbanco');
		$builder->selectMax('nidbanco');
		$query = $builder->get();
		return  $query->getResult()[0]->nidbanco;
	}
}
?>
