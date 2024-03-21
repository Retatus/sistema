<?php 

namespace App\Models;
use CodeIgniter\Model; 

class ReservadetalleotroservicioModel extends Model
{
	protected $table      = 'treservadetalleotroservicio';
	protected $primaryKey = 'nidreserva';

	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['nidreserva','nidotroservicio','sdescripcion','tfecha','ncantidad','dprecio','dtotal','bconfirmado','bestado'];
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
		return $this->where(['nidreserva' => $id])->countAllResults();
	}

	public function getReservadetalleotroservicios($todos = 1, $text = '', $total, $pag = 1){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;
		$builder = $this->conexion('treservadetalleotroservicio t0');
		$builder->select("t0.nidreserva idreserva, t0.nidreservadetalleotroservicio idreservadetalleotroservicio, t0.nidotroservicio idotroservicio, t0.sdescripcion descripcion, DATE_FORMAT(CAST(t0.tfecha As Date), '%d-%m-%Y') fecha, t0.ncantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado,  t1.nidotroservicio idotroservicio, t1.sotroservicionombre otroservicionombre, t2.nidreserva idreserva, t2.sreservanombre reservanombre, CONCAT(t1.sotroservicionombre) as concatenado, CONCAT(t1.sotroservicionombre) as concatenadodetalle");
		$builder->join('totroservicio t1', ' t1.nidotroservicio = t0.nidotroservicio');
		$builder->join('treserva t2', ' t2.nidreserva = t0.nidreserva');

		if ($todos !== '') 
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidreservadetalleotroservicio', $text);
		$builder->orLike('t1.sotroservicionombre', $text);

		$builder->orderBy('t0.nidreserva', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getAutocompletereservadetalleotroservicios($todos = 1, $text = ''){
		$builder = $this->conexion('treservadetalleotroservicio t0');
		$builder->select("t0.nidreserva idreserva, t0.nidreservadetalleotroservicio idreservadetalleotroservicio, t0.nidotroservicio idotroservicio, t0.sdescripcion descripcion, DATE_FORMAT(CAST(t0.tfecha As Date), '%d-%m-%Y') fecha, t0.ncantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado,  t1.nidotroservicio idotroservicio, t1.sotroservicionombre otroservicionombre, t2.nidreserva idreserva, t2.sreservanombre reservanombre, CONCAT(t1.sotroservicionombre) as concatenado, CONCAT(t1.sotroservicionombre) as concatenadodetalle");
		$builder->join('totroservicio t1', ' t1.nidotroservicio = t0.nidotroservicio');
		$builder->join('treserva t2', ' t2.nidreserva = t0.nidreserva');

		if ($todos !== '') 
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidreservadetalleotroservicio', $text);
		$builder->orLike('t1.sotroservicionombre', $text);

		$builder->orderBy('t0.nidreserva', 'DESC');
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getReservadetalleotroservicio($id){
		$builder = $this->conexion('treservadetalleotroservicio t0');
		$builder->select("t0.nidreserva idreserva, t0.nidreservadetalleotroservicio idreservadetalleotroservicio, t0.nidotroservicio idotroservicio, t0.sdescripcion descripcion,DATE_FORMAT(CAST(t0.tfecha As Date), '%d/%m/%Y') fecha, t0.ncantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado");
		$builder->where('nidreserva', $id);
		$query = $builder->get();
		return $query->getRowArray();
	}

	public function getReservadetalleotroservicio2($id){
		$builder = $this->conexion('treservadetalleotroservicio t0');
		$builder->select(" t0.nidreservadetalleotroservicio idreservadetalleotroservicio0, t0.sdescripcion descripcion0, t0.tfecha fecha0, t0.ncantidad cantidad0, t0.dprecio precio0, t0.dtotal total0, t0.bconfirmado confirmado0, t0.bestado estado0, t1.nidreserva idreserva1, t1.sreservanombre reservanombre1, t1.tfechainicio fechainicio1, t1.tfechafin fechafin1, t1.ntipodoc tipodoc1, t1.sidpersona idpersona1, t1.sreservatelefono reservatelefono1, t1.sreservacorreo reservacorreo1, t1.dmontototal montototal1, t1.bpagado pagado1, t1.bestado estado1, t2.nidotroservicio idotroservicio2, t2.sotroservicionombre otroservicionombre2, t2.dotroservicioprecio otroservicioprecio2, t2.botroservicioestado otroservicioestado2,");
		$builder->join('treserva t1', ' t0.nidreserva = t1.nidreserva');
		$builder->join('totroservicio t2', ' t0.nidotroservicio = t2.nidotroservicio');

		$builder->where('t0.nidreserva', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('treservadetalleotroservicio t0');
		$builder->select('nidreserva');
		$builder->join('totroservicio t1', ' t1.nidotroservicio = t0.nidotroservicio');
		$builder->join('treserva t2', ' t2.nidreserva = t0.nidreserva');

		if ($todos !== '')
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidreservadetalleotroservicio', $text);
		$builder->orLike('t1.sotroservicionombre', $text);

		return $builder->countAllResults();
	}

	public function UpdateReservadetalleotroservicio($id, $datos){
		$builder = $this->conexion('treservadetalleotroservicio');
		$builder->where('nidreserva', $id);
		$builder->set($datos);
		$builder->update();
	}

	public function getMaxid(){
		$builder = $this->conexion('treservadetalleotroservicio');
		$builder->selectMax('nidreserva');
		$query = $builder->get();
		return  $query->getResult()[0]->nidreserva;
	}
}
?>
