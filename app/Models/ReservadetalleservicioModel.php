<?php 

namespace App\Models;
use CodeIgniter\Model; 

class ReservadetalleservicioModel extends Model
{
	protected $table      = 'treservadetalleservicio';
	protected $primaryKey = 'nidreserva';

	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['nidreserva','nidreservadetalleservicio','sdescripcion','tfecha','dcantidad','dprecio','dtotal','bconfirmado','bestado'];
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

	public function getReservadetalleservicios($todos = 1, $text = '', $total, $pag = 1){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;
		$builder = $this->conexion('treservadetalleservicio t0');
		$builder->select("t0.nidreserva idreserva, t0.nidreservadetalleservicio idreservadetalleservicio, t0.sdescripcion descripcion, DATE_FORMAT(CAST(t0.tfecha As Date), '%d-%m-%Y') fecha, t0.dcantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado");

		if ($todos !== '') 
		$builder->where('t0.bestado', intval($todos));


		$builder->orderBy('t0.nidreserva', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getAutocompletereservadetalleservicios($todos = 1, $text = ''){
		$builder = $this->conexion('treservadetalleservicio t0');
		$builder->select("t0.nidreserva idreserva, t0.nidreservadetalleservicio idreservadetalleservicio, t0.sdescripcion descripcion, DATE_FORMAT(CAST(t0.tfecha As Date), '%d-%m-%Y') fecha, t0.dcantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado");

		if ($todos !== '') 
		$builder->where('t0.bestado', intval($todos));


		$builder->orderBy('t0.nidreserva', 'DESC');
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getReservadetalleservicio($nidreservadetalleservicio){
		$builder = $this->conexion('treservadetalleservicio t0');
		$builder->select("t0.nidreserva idreserva, t0.nidreservadetalleservicio idreservadetalleservicio, t0.sdescripcion descripcion,DATE_FORMAT(CAST(t0.tfecha As Date), '%d/%m/%Y') fecha, t0.dcantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado");
		$builder->where(['nidreservadetalleservicio' => $nidreservadetalleservicio]);
		$query = $builder->get();
		return $query->getRowArray();
	}

	public function getReservadetalleservicio2($id){
		$builder = $this->conexion('treservadetalleservicio t0');
		$builder->select(" t0.nidreserva idreserva0, t0.nidreservadetalleservicio idreservadetalleservicio0, t0.sdescripcion descripcion0, t0.tfecha fecha0, t0.dcantidad cantidad0, t0.dprecio precio0, t0.dtotal total0, t0.bconfirmado confirmado0, t0.bestado estado0,");

		$builder->where('t0.nidreserva', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('treservadetalleservicio t0');
		$builder->select('nidreserva');

		if ($todos !== '')
		$builder->where('t0.bestado', intval($todos));


		return $builder->countAllResults();
	}

	public function UpdateReservadetalleservicio($nidreservadetalleservicio, $datos){
		$builder = $this->conexion('treservadetalleservicio');
		$builder->where(['nidreservadetalleservicio' => $nidreservadetalleservicio]);
		$builder->set($datos);
		$builder->update();
	}

	public function getMaxid(){
		$builder = $this->conexion('treservadetalleservicio');
		$builder->selectMax('nidreserva');
		$query = $builder->get();
		return  $query->getResult()[0]->nidreserva;
	}
}
?>
