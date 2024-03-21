<?php 

namespace App\Models;
use CodeIgniter\Model; 

class HorariotrenModel extends Model
{
	protected $table      = 'thorariotren';
	protected $primaryKey = 'nidhorariotren';

	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['nidtren','nidhorario','dprecio','bestado'];
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
		return $this->where(['nidhorariotren' => $id])->countAllResults();
	}

	public function getHorariotrens($todos = 1, $text = '', $total, $pag = 1){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;
		$builder = $this->conexion('thorariotren t0');
		$builder->select("t0.nidhorariotren idhorariotren, t0.nidtren idtren, t0.nidhorario idhorario, t0.dprecio precio, t0.bestado estado,  t1.nidhorario idhorario, t1.snombre nombre, t2.nidtren idtren, t2.snombre nombre, CONCAT(t2.sempresa, ' - ', t2.snombre, ' - ', t1.snombre, ' - ', '[' ,t0.dprecio, ']' ) as concatenado, CONCAT(t2.sempresa, ' - ', t2.snombre, ' - ', t1.snombre) as concatenadodetalle");
		$builder->join('thoratren t1', ' t1.nidhorario = t0.nidhorario');
		$builder->join('ttren t2', ' t2.nidtren = t0.nidtren');

		if ($todos !== '') 
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidhorariotren', $text);
		$builder->orLike('t2.sempresa', $text);
		$builder->orLike('t2.snombre', $text);
		$builder->orLike('t1.snombre', $text);
		$builder->orLike('t0.dprecio', $text);

		$builder->orderBy('t0.nidhorariotren', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getAutocompletehorariotrens($todos = 1, $text = ''){
		$builder = $this->conexion('thorariotren t0');
		$builder->select("t0.nidhorariotren idhorariotren, t0.nidtren idtren, t0.nidhorario idhorario, t0.dprecio precio, t0.bestado estado,  t1.nidhorario idhorario, t1.snombre nombre, t2.nidtren idtren, t2.snombre nombre, CONCAT(t2.sempresa, ' - ', t2.snombre, ' - ', t1.snombre, ' - ', '[' ,t0.dprecio, ']' ) as concatenado, CONCAT(t2.sempresa, ' - ', t2.snombre, ' - ', t1.snombre) as concatenadodetalle");
		$builder->join('thoratren t1', ' t1.nidhorario = t0.nidhorario');
		$builder->join('ttren t2', ' t2.nidtren = t0.nidtren');

		if ($todos !== '') 
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidhorariotren', $text);
		$builder->orLike('t2.sempresa', $text);
		$builder->orLike('t2.snombre', $text);
		$builder->orLike('t1.snombre', $text);
		$builder->orLike('t0.dprecio', $text);

		$builder->orderBy('t0.nidhorariotren', 'DESC');
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getHorariotren($id){
		$builder = $this->conexion('thorariotren t0');
		$builder->select("t0.nidhorariotren idhorariotren, t0.nidtren idtren, t0.nidhorario idhorario, t0.dprecio precio, t0.bestado estado");
		$builder->where('nidhorariotren', $id);
		$query = $builder->get();
		return $query->getRowArray();
	}

	public function getHorariotren2($id){
		$builder = $this->conexion('thorariotren t0');
		$builder->select(" t0.nidhorariotren idhorariotren0, t0.dprecio precio0, t0.bestado estado0, t1.nidtren idtren1, t1.snombre nombre1, t1.sempresa empresa1, t1.bestado estado1, t2.nidhorario idhorario2, t2.snombre nombre2, t2.sdescripcion descripcion2, t2.bida ida2, t2.bestado estado2,");
		$builder->join('ttren t1', ' t0.nidtren = t1.nidtren');
		$builder->join('thoratren t2', ' t0.nidhorario = t2.nidhorario');

		$builder->where('t0.nidreserva', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('thorariotren t0');
		$builder->select('nidhorariotren');
		$builder->join('thoratren t1', ' t1.nidhorario = t0.nidhorario');
		$builder->join('ttren t2', ' t2.nidtren = t0.nidtren');

		if ($todos !== '')
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidhorariotren', $text);
		$builder->orLike('t2.sempresa', $text);
		$builder->orLike('t2.snombre', $text);
		$builder->orLike('t1.snombre', $text);
		$builder->orLike('t0.dprecio', $text);

		return $builder->countAllResults();
	}

	public function UpdateHorariotren($id, $datos){
		$builder = $this->conexion('thorariotren');
		$builder->where('nidhorariotren', $id);
		$builder->set($datos);
		$builder->update();
	}

	public function getMaxid(){
		$builder = $this->conexion('thorariotren');
		$builder->selectMax('nidhorariotren');
		$query = $builder->get();
		return  $query->getResult()[0]->nidhorariotren;
	}
}
?>
