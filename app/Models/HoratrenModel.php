<?php 

namespace App\Models;
use CodeIgniter\Model; 

class HoratrenModel extends Model
{
	protected $table      = 'thoratren';
	protected $primaryKey = 'nidhorario';

	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['snombre','sdescripcion','bida','bestado'];
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
		return $this->where(['nidhorario' => $id])->countAllResults();
	}

	public function getHoratrens($todos = 1, $text = '', $total, $pag = 1){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;
		$builder = $this->conexion('thoratren t0');
		$builder->select("t0.nidhorario idhorario, t0.snombre nombre, t0.sdescripcion descripcion, t0.bida ida, t0.bestado estado,  CONCAT(t0.snombre) as concatenado, CONCAT(t0.snombre) as concatenadodetalle");

		if ($todos !== '') 
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidhorario', $text);
		$builder->orLike('t0.snombre', $text);

		$builder->orderBy('t0.nidhorario', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getAutocompletehoratrens($todos = 1, $text = ''){
		$builder = $this->conexion('thoratren t0');
		$builder->select("t0.nidhorario idhorario, t0.snombre nombre, t0.sdescripcion descripcion, t0.bida ida, t0.bestado estado,  CONCAT(t0.snombre) as concatenado, CONCAT(t0.snombre) as concatenadodetalle");

		if ($todos !== '') 
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidhorario', $text);
		$builder->orLike('t0.snombre', $text);

		$builder->orderBy('t0.nidhorario', 'DESC');
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getHoratren($nidhorario){
		$builder = $this->conexion('thoratren t0');
		$builder->select("t0.nidhorario idhorario, t0.snombre nombre, t0.sdescripcion descripcion, t0.bida ida, t0.bestado estado");
		$builder->where(['nidhorario' => $nidhorario]);
		$query = $builder->get();
		return $query->getRowArray();
	}

	public function getHoratren2($id){
		$builder = $this->conexion('thoratren t0');
		$builder->select(" t0.nidhorario idhorario0, t0.snombre nombre0, t0.sdescripcion descripcion0, t0.bida ida0, t0.bestado estado0,");

		$builder->where('t0.nidreserva', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('thoratren t0');
		$builder->select('nidhorario');

		if ($todos !== '')
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidhorario', $text);
		$builder->orLike('t0.snombre', $text);

		return $builder->countAllResults();
	}

	public function UpdateHoratren($nidhorario, $datos){
		$builder = $this->conexion('thoratren');
		$builder->where(['nidhorario' => $nidhorario]);
		$builder->set($datos);
		$builder->update();
	}

	public function getMaxid(){
		$builder = $this->conexion('thoratren');
		$builder->selectMax('nidhorario');
		$query = $builder->get();
		return  $query->getResult()[0]->nidhorario;
	}
}
?>
