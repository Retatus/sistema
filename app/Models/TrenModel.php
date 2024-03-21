<?php 

namespace App\Models;
use CodeIgniter\Model; 

class TrenModel extends Model
{
	protected $table      = 'ttren';
	protected $primaryKey = 'nidtren';

	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['snombre','sempresa','bestado'];
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
		return $this->where(['nidtren' => $id])->countAllResults();
	}

	public function getTrens($todos = 1, $text = '', $total, $pag = 1){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;
		$builder = $this->conexion('ttren t0');
		$builder->select("t0.nidtren idtren, t0.snombre nombre, t0.sempresa empresa, t0.bestado estado,  CONCAT(t0.snombre, ' - ', t0.sempresa) as concatenado, CONCAT(t0.snombre, ' - ', t0.sempresa) as concatenadodetalle");

		if ($todos !== '') 
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidtren', $text);
		$builder->orLike('t0.snombre', $text);
		$builder->orLike('t0.sempresa', $text);

		$builder->orderBy('t0.nidtren', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getAutocompletetrens($todos = 1, $text = ''){
		$builder = $this->conexion('ttren t0');
		$builder->select("t0.nidtren idtren, t0.snombre nombre, t0.sempresa empresa, t0.bestado estado,  CONCAT(t0.snombre, ' - ', t0.sempresa) as concatenado, CONCAT(t0.snombre, ' - ', t0.sempresa) as concatenadodetalle");

		if ($todos !== '') 
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidtren', $text);
		$builder->orLike('t0.snombre', $text);
		$builder->orLike('t0.sempresa', $text);

		$builder->orderBy('t0.nidtren', 'DESC');
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getTren($id){
		$builder = $this->conexion('ttren t0');
		$builder->select("t0.nidtren idtren, t0.snombre nombre, t0.sempresa empresa, t0.bestado estado");
		$builder->where('nidtren', $id);
		$query = $builder->get();
		return $query->getRowArray();
	}

	public function getTren2($id){
		$builder = $this->conexion('ttren t0');
		$builder->select(" t0.nidtren idtren0, t0.snombre nombre0, t0.sempresa empresa0, t0.bestado estado0,");

		$builder->where('t0.nidreserva', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('ttren t0');
		$builder->select('nidtren');

		if ($todos !== '')
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidtren', $text);
		$builder->orLike('t0.snombre', $text);
		$builder->orLike('t0.sempresa', $text);

		return $builder->countAllResults();
	}

	public function UpdateTren($id, $datos){
		$builder = $this->conexion('ttren');
		$builder->where('nidtren', $id);
		$builder->set($datos);
		$builder->update();
	}

	public function getMaxid(){
		$builder = $this->conexion('ttren');
		$builder->selectMax('nidtren');
		$query = $builder->get();
		return  $query->getResult()[0]->nidtren;
	}
}
?>
