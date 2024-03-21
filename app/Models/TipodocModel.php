<?php 

namespace App\Models;
use CodeIgniter\Model; 

class TipodocModel extends Model
{
	protected $table      = 'ttipodoc';
	protected $primaryKey = 'nidtipodoc';

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
		return $this->where(['nidtipodoc' => $id])->countAllResults();
	}

	public function getTipodocs($todos = 1, $text = '', $total, $pag = 1){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;
		$builder = $this->conexion('ttipodoc t0');
		$builder->select("t0.nidtipodoc idtipodoc, t0.snombre nombre, t0.bestado estado,  CONCAT(t0.snombre) as concatenado, CONCAT(t0.snombre) as concatenadodetalle");

		if ($todos !== '') 
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidtipodoc', $text);
		$builder->orLike('t0.snombre', $text);

		$builder->orderBy('t0.nidtipodoc', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getAutocompletetipodocs($todos = 1, $text = ''){
		$builder = $this->conexion('ttipodoc t0');
		$builder->select("t0.nidtipodoc idtipodoc, t0.snombre nombre, t0.bestado estado,  CONCAT(t0.snombre) as concatenado, CONCAT(t0.snombre) as concatenadodetalle");

		if ($todos !== '') 
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidtipodoc', $text);
		$builder->orLike('t0.snombre', $text);

		$builder->orderBy('t0.nidtipodoc', 'DESC');
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getTipodoc($id){
		$builder = $this->conexion('ttipodoc t0');
		$builder->select("t0.nidtipodoc idtipodoc, t0.snombre nombre, t0.bestado estado");
		$builder->where('nidtipodoc', $id);
		$query = $builder->get();
		return $query->getRowArray();
	}

	public function getTipodoc2($id){
		$builder = $this->conexion('ttipodoc t0');
		$builder->select(" t0.nidtipodoc idtipodoc0, t0.snombre nombre0, t0.bestado estado0,");

		$builder->where('t0.nidreserva', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('ttipodoc t0');
		$builder->select('nidtipodoc');

		if ($todos !== '')
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidtipodoc', $text);
		$builder->orLike('t0.snombre', $text);

		return $builder->countAllResults();
	}

	public function UpdateTipodoc($id, $datos){
		$builder = $this->conexion('ttipodoc');
		$builder->where('nidtipodoc', $id);
		$builder->set($datos);
		$builder->update();
	}

	public function getMaxid(){
		$builder = $this->conexion('ttipodoc');
		$builder->selectMax('nidtipodoc');
		$query = $builder->get();
		return  $query->getResult()[0]->nidtipodoc;
	}
}
?>
