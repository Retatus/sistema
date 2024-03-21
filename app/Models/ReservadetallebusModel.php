<?php 

namespace App\Models;
use CodeIgniter\Model; 

class ReservadetallebusModel extends Model
{
	protected $table      = 'treservadetallebus';
	protected $primaryKey = 'nidreserva';

	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['nidreserva','nidticketbus','sdescripcion','tfecha','ncantidad','dprecio','dtotal','bconfirmado','bestado'];
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

	public function getReservadetallebuss($todos = 1, $text = '', $total, $pag = 1){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;
		$builder = $this->conexion('treservadetallebus t0');
		$builder->select("t0.nidreserva idreserva, t0.nidreservadetalleticketbus idreservadetalleticketbus, t0.nidticketbus idticketbus, t0.sdescripcion descripcion, DATE_FORMAT(CAST(t0.tfecha As Date), '%d-%m-%Y') fecha, t0.ncantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado,  t1.nidreserva idreserva, t1.sreservanombre reservanombre, t2.nidticketbus idticketbus, t2.snombre nombre, CONCAT(t2.snombre, ' - ', '[' ,t2.dprecio, ']' ) as concatenado, CONCAT(t2.snombre) as concatenadodetalle");
		$builder->join('treserva t1', ' t1.nidreserva = t0.nidreserva');
		$builder->join('tticketbus t2', ' t2.nidticketbus = t0.nidticketbus');

		if ($todos !== '') 
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidreservadetalleticketbus', $text);
		$builder->orLike('t2.snombre', $text);
		$builder->orLike('t2.dprecio', $text);

		$builder->orderBy('t0.nidreserva', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getAutocompletereservadetallebuss($todos = 1, $text = ''){
		$builder = $this->conexion('treservadetallebus t0');
		$builder->select("t0.nidreserva idreserva, t0.nidreservadetalleticketbus idreservadetalleticketbus, t0.nidticketbus idticketbus, t0.sdescripcion descripcion, DATE_FORMAT(CAST(t0.tfecha As Date), '%d-%m-%Y') fecha, t0.ncantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado,  t1.nidreserva idreserva, t1.sreservanombre reservanombre, t2.nidticketbus idticketbus, t2.snombre nombre, CONCAT(t2.snombre, ' - ', '[' ,t2.dprecio, ']' ) as concatenado, CONCAT(t2.snombre) as concatenadodetalle");
		$builder->join('treserva t1', ' t1.nidreserva = t0.nidreserva');
		$builder->join('tticketbus t2', ' t2.nidticketbus = t0.nidticketbus');

		if ($todos !== '') 
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidreservadetalleticketbus', $text);
		$builder->orLike('t2.snombre', $text);
		$builder->orLike('t2.dprecio', $text);

		$builder->orderBy('t0.nidreserva', 'DESC');
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getReservadetallebus($id){
		$builder = $this->conexion('treservadetallebus t0');
		$builder->select("t0.nidreserva idreserva, t0.nidreservadetalleticketbus idreservadetalleticketbus, t0.nidticketbus idticketbus, t0.sdescripcion descripcion,DATE_FORMAT(CAST(t0.tfecha As Date), '%d/%m/%Y') fecha, t0.ncantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado");
		$builder->where('nidreserva', $id);
		$query = $builder->get();
		return $query->getRowArray();
	}

	public function getReservadetallebus2($id){
		$builder = $this->conexion('treservadetallebus t0');
		$builder->select(" t0.nidreservadetalleticketbus idreservadetalleticketbus0, t0.sdescripcion descripcion0, t0.tfecha fecha0, t0.ncantidad cantidad0, t0.dprecio precio0, t0.dtotal total0, t0.bconfirmado confirmado0, t0.bestado estado0, t1.nidreserva idreserva1, t1.sreservanombre reservanombre1, t1.tfechainicio fechainicio1, t1.tfechafin fechafin1, t1.ntipodoc tipodoc1, t1.sidpersona idpersona1, t1.sreservatelefono reservatelefono1, t1.sreservacorreo reservacorreo1, t1.dmontototal montototal1, t1.bpagado pagado1, t1.bestado estado1, t2.nidticketbus idticketbus2, t2.snombre nombre2, t2.sdescripcion descripcion2, t2.dprecio precio2, t2.bestado estado2,");
		$builder->join('treserva t1', ' t0.nidreserva = t1.nidreserva');
		$builder->join('tticketbus t2', ' t0.nidticketbus = t2.nidticketbus');

		$builder->where('t0.nidreserva', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('treservadetallebus t0');
		$builder->select('nidreserva');
		$builder->join('treserva t1', ' t1.nidreserva = t0.nidreserva');
		$builder->join('tticketbus t2', ' t2.nidticketbus = t0.nidticketbus');

		if ($todos !== '')
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidreservadetalleticketbus', $text);
		$builder->orLike('t2.snombre', $text);
		$builder->orLike('t2.dprecio', $text);

		return $builder->countAllResults();
	}

	public function UpdateReservadetallebus($id, $datos){
		$builder = $this->conexion('treservadetallebus');
		$builder->where('nidreserva', $id);
		$builder->set($datos);
		$builder->update();
	}

	public function getMaxid(){
		$builder = $this->conexion('treservadetallebus');
		$builder->selectMax('nidreserva');
		$query = $builder->get();
		return  $query->getResult()[0]->nidreserva;
	}
}
?>
