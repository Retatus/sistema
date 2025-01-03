<?php 

namespace App\Models;
use CodeIgniter\Model; 

class OrigenclienteModel extends Model
{
	protected $table      = 'torigencliente';
	protected $primaryKey = 'nidorigencliente';

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
		return $this->where(['nidorigencliente' => $id])->countAllResults();
	}

	public function getOrigenclientes($todos = 1, $text = '', $total, $pag = 1){
		$CantidadMostrar = 10;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;
		$builder = $this->conexion('torigencliente t0');
		$builder->select("t0.nidorigencliente idorigencliente, t0.snombre nombre, t0.bestado estado,  CONCAT(t0.snombre) as concatenado");

		if ($todos !== '') 
		$builder->where('t0.bestado', intval($todos));
		$builder->like('t0.nidorigencliente', $text);
		$builder->orLike('t0.snombre', $text);

		$builder->orderBy('t0.nidorigencliente', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getOrigencliente($id){
		$builder = $this->conexion('torigencliente');
		$builder->select("nidorigencliente idorigencliente, snombre nombre, bestado estado");
		$builder->where('nidorigencliente', $id);
		$query = $builder->get();
		return $query->getRowArray();
	}

	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('torigencliente t0');
		$builder->select('nidorigencliente');

		if ($todos !== '')  
		$builder->where('t0.bestado', intval($todos));
		$builder->like('t0.nidorigencliente', $text);
		$builder->orLike('t0.snombre', $text);

		return $builder->countAllResults();
	}

	public function UpdateOrigencliente($id, $datos){
		$builder = $this->conexion('torigencliente');
		$builder->where('nidorigencliente', $id);
		$builder->set($datos);
		$builder->update();
	}
}
?>
