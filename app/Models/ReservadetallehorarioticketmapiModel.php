<?php 

namespace App\Models;
use CodeIgniter\Model; 

class ReservadetallehorarioticketmapiModel extends Model
{
	protected $table      = 'treservadetallehorarioticketmapi';
	protected $primaryKey = 'nidreserva';

	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['nidreserva','nidhorarioticketmapi','sdescripcion','tfecha','ncantidad','dprecio','dtotal','bconfirmado','bestado'];
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

	public function getReservadetallehorarioticketmapis($todos = 1, $text = '', $total, $pag = 1){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;
		$builder = $this->conexion('treservadetallehorarioticketmapi t0');
		$builder->select("t0.nidreserva idreserva, t0.nidreservadetallehorarioticketmapi idreservadetallehorarioticketmapi, t0.nidhorarioticketmapi idhorarioticketmapi, t0.sdescripcion descripcion, DATE_FORMAT(CAST(t0.tfecha As Date), '%d-%m-%Y') fecha, t0.ncantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado,  t1.nidhorarioticketmapi idhorarioticketmapi, t2.nidreserva idreserva, t2.sreservanombre reservanombre, t3.snombre clientetipo, t4.snombre horaticketmapi, t5.snombre ticketmapi, CONCAT('[' ,t0.dprecio, ']' ) as concatenado");
		$builder->join('thorarioticketmapi t1', ' t1.nidhorarioticketmapi = t0.nidhorarioticketmapi');
		$builder->join('treserva t2', ' t2.nidreserva = t0.nidreserva');
		$builder->join('tclientetipo t3', ' t3.nidclientetipo = t1.nidclientetipo');
		$builder->join('thoraticketmapi t4', ' t4.nidhoraticketmapi = t1.nidhoraticketmapi');
		$builder->join('tticketmapi t5', ' t5.nidticketmapi = t1.nidticketmapi');

		if ($todos !== '') 
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidreservadetallehorarioticketmapi', $text);
		$builder->orLike('t0.dprecio', $text);

		$builder->orderBy('t0.nidreserva', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getAutocompletereservadetallehorarioticketmapis($todos = 1, $text = ''){
		$builder = $this->conexion('treservadetallehorarioticketmapi t0');
		$builder->select("t0.nidreserva idreserva, t0.nidreservadetallehorarioticketmapi idreservadetallehorarioticketmapi, t0.nidhorarioticketmapi idhorarioticketmapi, t0.sdescripcion descripcion, DATE_FORMAT(CAST(t0.tfecha As Date), '%d-%m-%Y') fecha, t0.ncantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado,  t1.nidhorarioticketmapi idhorarioticketmapi, t2.nidreserva idreserva, t2.sreservanombre reservanombre, t3.snombre clientetipo, t4.snombre horaticketmapi, t5.snombre ticketmapi, CONCAT('[' ,t0.dprecio, ']' ) as concatenado");
		$builder->join('thorarioticketmapi t1', ' t1.nidhorarioticketmapi = t0.nidhorarioticketmapi');
		$builder->join('treserva t2', ' t2.nidreserva = t0.nidreserva');
		$builder->join('tclientetipo t3', ' t3.nidclientetipo = t1.nidclientetipo');
		$builder->join('thoraticketmapi t4', ' t4.nidhoraticketmapi = t1.nidhoraticketmapi');
		$builder->join('tticketmapi t5', ' t5.nidticketmapi = t1.nidticketmapi');

		if ($todos !== '') 
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidreservadetallehorarioticketmapi', $text);
		$builder->orLike('t0.dprecio', $text);

		$builder->orderBy('t0.nidreserva', 'DESC');
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getReservadetallehorarioticketmapi($id){
		$builder = $this->conexion('treservadetallehorarioticketmapi t0');
		$builder->select("t0.nidreserva idreserva, t0.nidreservadetallehorarioticketmapi idreservadetallehorarioticketmapi, t0.nidhorarioticketmapi idhorarioticketmapi, t0.sdescripcion descripcion,DATE_FORMAT(CAST(t0.tfecha As Date), '%d/%m/%Y') fecha, t0.ncantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado");
		$builder->where('nidreserva', $id);
		$query = $builder->get();
		return $query->getRowArray();
	}

	public function getReservadetallehorarioticketmapi2($id){
		$builder = $this->conexion('treservadetallehorarioticketmapi t0');
		$builder->select(" t0.nidreservadetallehorarioticketmapi idreservadetallehorarioticketmapi0, t0.sdescripcion descripcion0, t0.tfecha fecha0, t0.ncantidad cantidad0, t0.dprecio precio0, t0.dtotal total0, t0.bconfirmado confirmado0, t0.bestado estado0, t1.nidreserva idreserva1, t1.sreservanombre reservanombre1, t1.tfechainicio fechainicio1, t1.tfechafin fechafin1, t1.ntipodoc tipodoc1, t1.sidpersona idpersona1, t1.sreservatelefono reservatelefono1, t1.sreservacorreo reservacorreo1, t1.dmontototal montototal1, t1.bpagado pagado1, t1.bestado estado1, t2.nidhorarioticketmapi idhorarioticketmapi2, t2.dprecio precio2, t2.bestado estado2, t3.nidhoraticketmapi idhoraticketmapi3, t3.snombre nombre3, t3.bestado estado3, t4.nidticketmapi idticketmapi4, t4.snombre nombre4, t4.bestado estado4, t5.nidclientetipo idclientetipo5, t5.snombre nombre5, t5.bestado estado5,");
		$builder->join('treserva t1', ' t0.nidreserva = t1.nidreserva');
		$builder->join('thorarioticketmapi t2', ' t0.nidhorarioticketmapi = t2.nidhorarioticketmapi');
		$builder->join('thoraticketmapi t3', ' t2.nidhoraticketmapi = t3.nidhoraticketmapi');
		$builder->join('tticketmapi t4', ' t2.nidticketmapi = t4.nidticketmapi');
		$builder->join('tclientetipo t5', ' t2.nidclientetipo = t5.nidclientetipo');

		$builder->where('t0.nidreserva', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('treservadetallehorarioticketmapi t0');
		$builder->select('nidreserva');
		$builder->join('thorarioticketmapi t1', ' t1.nidhorarioticketmapi = t0.nidhorarioticketmapi');
		$builder->join('treserva t2', ' t2.nidreserva = t0.nidreserva');
		$builder->join('tclientetipo t3', ' t3.nidclientetipo = t1.nidclientetipo');
		$builder->join('thoraticketmapi t4', ' t4.nidhoraticketmapi = t1.nidhoraticketmapi');
		$builder->join('tticketmapi t5', ' t5.nidticketmapi = t1.nidticketmapi');

		if ($todos !== '')
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidreservadetallehorarioticketmapi', $text);
		$builder->orLike('t0.dprecio', $text);

		return $builder->countAllResults();
	}

	public function UpdateReservadetallehorarioticketmapi($id, $datos){
		$builder = $this->conexion('treservadetallehorarioticketmapi');
		$builder->where('nidreserva', $id);
		$builder->set($datos);
		$builder->update();
	}

	public function getMaxid(){
		$builder = $this->conexion('treservadetallehorarioticketmapi');
		$builder->selectMax('nidreserva');
		$query = $builder->get();
		return  $query->getResult()[0]->nidreserva;
	}
}
?>
