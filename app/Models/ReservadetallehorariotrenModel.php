<?php 

namespace App\Models;
use CodeIgniter\Model; 

class ReservadetallehorariotrenModel extends Model
{
	protected $table      = 'treservadetallehorariotren';
	protected $primaryKey = 'nidreserva';

	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['nidreserva','nidhorariotren','sdescripcion','tfecha','ncantidad','dprecio','dtotal','bconfirmado','bestado'];
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

	public function getReservadetallehorariotrens($todos = 1, $text = '', $total, $pag = 1){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;
		$builder = $this->conexion('treservadetallehorariotren t0');
		$builder->select("t0.nidreserva idreserva, t0.nidreservadetallehorariotren idreservadetallehorariotren, t0.nidhorariotren idhorariotren, t0.sdescripcion descripcion, DATE_FORMAT(CAST(t0.tfecha As Date), '%d-%m-%Y') fecha, t0.ncantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado,  t1.nidhorariotren idhorariotren, t2.nidreserva idreserva, t2.sreservanombre reservanombre, t3.snombre horatren, t4.snombre tren, CONCAT('[' ,t0.dprecio, ']' ) as concatenado");
		$builder->join('thorariotren t1', ' t1.nidhorariotren = t0.nidhorariotren');
		$builder->join('treserva t2', ' t2.nidreserva = t0.nidreserva');
		$builder->join('thoratren t3', ' t3.nidhorario = t1.nidhorario');
		$builder->join('ttren t4', ' t4.nidtren = t1.nidtren');

		if ($todos !== '') 
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidreservadetallehorariotren', $text);
		$builder->orLike('t0.dprecio', $text);

		$builder->orderBy('t0.nidreserva', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getAutocompletereservadetallehorariotrens($todos = 1, $text = ''){
		$builder = $this->conexion('treservadetallehorariotren t0');
		$builder->select("t0.nidreserva idreserva, t0.nidreservadetallehorariotren idreservadetallehorariotren, t0.nidhorariotren idhorariotren, t0.sdescripcion descripcion, DATE_FORMAT(CAST(t0.tfecha As Date), '%d-%m-%Y') fecha, t0.ncantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado,  t1.nidhorariotren idhorariotren, t2.nidreserva idreserva, t2.sreservanombre reservanombre, t3.snombre horatren, t4.snombre tren, CONCAT('[' ,t0.dprecio, ']' ) as concatenado");
		$builder->join('thorariotren t1', ' t1.nidhorariotren = t0.nidhorariotren');
		$builder->join('treserva t2', ' t2.nidreserva = t0.nidreserva');
		$builder->join('thoratren t3', ' t3.nidhorario = t1.nidhorario');
		$builder->join('ttren t4', ' t4.nidtren = t1.nidtren');

		if ($todos !== '') 
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidreservadetallehorariotren', $text);
		$builder->orLike('t0.dprecio', $text);

		$builder->orderBy('t0.nidreserva', 'DESC');
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getReservadetallehorariotren($id){
		$builder = $this->conexion('treservadetallehorariotren t0');
		$builder->select("t0.nidreserva idreserva, t0.nidreservadetallehorariotren idreservadetallehorariotren, t0.nidhorariotren idhorariotren, t0.sdescripcion descripcion,DATE_FORMAT(CAST(t0.tfecha As Date), '%d/%m/%Y') fecha, t0.ncantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado");
		$builder->where('nidreserva', $id);
		$query = $builder->get();
		return $query->getRowArray();
	}

	public function getReservadetallehorariotren2($id){
		$builder = $this->conexion('treservadetallehorariotren t0');
		$builder->select(" t0.nidreservadetallehorariotren idreservadetallehorariotren0, t0.sdescripcion descripcion0, t0.tfecha fecha0, t0.ncantidad cantidad0, t0.dprecio precio0, t0.dtotal total0, t0.bconfirmado confirmado0, t0.bestado estado0, t1.nidreserva idreserva1, t1.sreservanombre reservanombre1, t1.tfechainicio fechainicio1, t1.tfechafin fechafin1, t1.ntipodoc tipodoc1, t1.sidpersona idpersona1, t1.sreservatelefono reservatelefono1, t1.sreservacorreo reservacorreo1, t1.dmontototal montototal1, t1.bpagado pagado1, t1.bestado estado1, t2.nidhorariotren idhorariotren2, t2.dprecio precio2, t2.bestado estado2, t3.nidtren idtren3, t3.snombre nombre3, t3.sempresa empresa3, t3.bestado estado3, t4.nidhorario idhorario4, t4.snombre nombre4, t4.sdescripcion descripcion4, t4.bida ida4, t4.bestado estado4,");
		$builder->join('treserva t1', ' t0.nidreserva = t1.nidreserva');
		$builder->join('thorariotren t2', ' t0.nidhorariotren = t2.nidhorariotren');
		$builder->join('ttren t3', ' t2.nidtren = t3.nidtren');
		$builder->join('thoratren t4', ' t2.nidhorario = t4.nidhorario');

		$builder->where('t0.nidreserva', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('treservadetallehorariotren t0');
		$builder->select('nidreserva');
		$builder->join('thorariotren t1', ' t1.nidhorariotren = t0.nidhorariotren');
		$builder->join('treserva t2', ' t2.nidreserva = t0.nidreserva');
		$builder->join('thoratren t3', ' t3.nidhorario = t1.nidhorario');
		$builder->join('ttren t4', ' t4.nidtren = t1.nidtren');

		if ($todos !== '')
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidreservadetallehorariotren', $text);
		$builder->orLike('t0.dprecio', $text);

		return $builder->countAllResults();
	}

	public function UpdateReservadetallehorariotren($id, $datos){
		$builder = $this->conexion('treservadetallehorariotren');
		$builder->where('nidreserva', $id);
		$builder->set($datos);
		$builder->update();
	}

	public function getMaxid(){
		$builder = $this->conexion('treservadetallehorariotren');
		$builder->selectMax('nidreserva');
		$query = $builder->get();
		return  $query->getResult()[0]->nidreserva;
	}
}
?>
