<?php 

namespace App\Models;
use CodeIgniter\Model; 

class OtroservicioModel extends Model
{
	protected $table      = 'totroservicio';
	protected $primaryKey = 'nidotroservicio';

	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['sotroservicionombre','dotroservicioprecio','botroservicioestado'];
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
		return $this->where(['nidotroservicio' => $id])->countAllResults();
	}

	public function getOtroservicios($todos = 1, $text = '', $total, $pag = 1){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;
		$builder = $this->conexion('totroservicio t0');
		$builder->select("t0.nidotroservicio idotroservicio, t0.sotroservicionombre otroservicionombre, t0.dotroservicioprecio otroservicioprecio, t0.botroservicioestado otroservicioestado,  CONCAT(t0.sotroservicionombre, ' - ', '[' ,t0.dotroservicioprecio, ']' ) as concatenado, CONCAT(t0.sotroservicionombre) as concatenadodetalle");

		if ($todos !== '') 
		$builder->where('t0.botroservicioestado', intval($todos));

		$builder->like('t0.nidotroservicio', $text);
		$builder->orLike('t0.sotroservicionombre', $text);
		$builder->orLike('t0.dotroservicioprecio', $text);

		$builder->orderBy('t0.nidotroservicio', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getAutocompleteotroservicios($todos = 1, $text = ''){
		$builder = $this->conexion('totroservicio t0');
		$builder->select("t0.nidotroservicio idotroservicio, t0.sotroservicionombre otroservicionombre, t0.dotroservicioprecio otroservicioprecio, t0.botroservicioestado otroservicioestado,  CONCAT(t0.sotroservicionombre, ' - ', '[' ,t0.dotroservicioprecio, ']' ) as concatenado, CONCAT(t0.sotroservicionombre) as concatenadodetalle");

		if ($todos !== '') 
		$builder->where('t0.botroservicioestado', intval($todos));

		$builder->like('t0.nidotroservicio', $text);
		$builder->orLike('t0.sotroservicionombre', $text);
		$builder->orLike('t0.dotroservicioprecio', $text);

		$builder->orderBy('t0.nidotroservicio', 'DESC');
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getOtroservicio($id){
		$builder = $this->conexion('totroservicio t0');
		$builder->select("t0.nidotroservicio idotroservicio, t0.sotroservicionombre otroservicionombre, t0.dotroservicioprecio otroservicioprecio, t0.botroservicioestado otroservicioestado");
		$builder->where('nidotroservicio', $id);
		$query = $builder->get();
		return $query->getRowArray();
	}

	public function getOtroservicio2($id){
		$builder = $this->conexion('totroservicio t0');
		$builder->select(" t0.nidotroservicio idotroservicio0, t0.sotroservicionombre otroservicionombre0, t0.dotroservicioprecio otroservicioprecio0, t0.botroservicioestado otroservicioestado0,");

		$builder->where('t0.nidreserva', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('totroservicio t0');
		$builder->select('nidotroservicio');

		if ($todos !== '')
		$builder->where('t0.botroservicioestado', intval($todos));

		$builder->like('t0.nidotroservicio', $text);
		$builder->orLike('t0.sotroservicionombre', $text);
		$builder->orLike('t0.dotroservicioprecio', $text);

		return $builder->countAllResults();
	}

	public function UpdateOtroservicio($id, $datos){
		$builder = $this->conexion('totroservicio');
		$builder->where('nidotroservicio', $id);
		$builder->set($datos);
		$builder->update();
	}

	public function getMaxid(){
		$builder = $this->conexion('totroservicio');
		$builder->selectMax('nidotroservicio');
		$query = $builder->get();
		return  $query->getResult()[0]->nidotroservicio;
	}
}
?>
