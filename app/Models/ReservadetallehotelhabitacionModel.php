<?php 

namespace App\Models;
use CodeIgniter\Model; 

class ReservadetallehotelhabitacionModel extends Model
{
	protected $table      = 'treservadetallehotelhabitacion';
	protected $primaryKey = 'nidreserva';

	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['nidreserva','nidhotelhabitacion','sdescripcion','tfechaingreso','tfechasalida','nadultos','nninios','ncantidad','dprecio','dtotal','bconfirmado','bestado'];
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

	public function getReservadetallehotelhabitacions($todos = 1, $text = '', $total, $pag = 1){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;
		$builder = $this->conexion('treservadetallehotelhabitacion t0');
		$builder->select("t0.nidreserva idreserva, t0.nidreservadetallehotelhabitacion idreservadetallehotelhabitacion, t0.nidhotelhabitacion idhotelhabitacion, t0.sdescripcion descripcion, DATE_FORMAT(CAST(t0.tfechaingreso As Date), '%d-%m-%Y') fechaingreso, DATE_FORMAT(CAST(t0.tfechasalida As Date), '%d-%m-%Y') fechasalida, t0.nadultos adultos, t0.nninios ninios, t0.ncantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado,  t1.nidhotelhabitacion idhotelhabitacion, t2.nidreserva idreserva, t2.sreservanombre reservanombre, t3.snombre cathabitacion, t4.snombre hotel, CONCAT('[' ,t0.dprecio, ']' ) as concatenado");
		$builder->join('thotelhabitacion t1', ' t1.nidhotelhabitacion = t0.nidhotelhabitacion');
		$builder->join('treserva t2', ' t2.nidreserva = t0.nidreserva');
		$builder->join('tcathabitacion t3', ' t3.nidcathabitacion = t1.nidcathabitacion');
		$builder->join('thotel t4', ' t4.sidhotel = t1.sidhotel');

		if ($todos !== '') 
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidreservadetallehotelhabitacion', $text);
		$builder->orLike('t0.dprecio', $text);

		$builder->orderBy('t0.nidreserva', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getAutocompletereservadetallehotelhabitacions($todos = 1, $text = ''){
		$builder = $this->conexion('treservadetallehotelhabitacion t0');
		$builder->select("t0.nidreserva idreserva, t0.nidreservadetallehotelhabitacion idreservadetallehotelhabitacion, t0.nidhotelhabitacion idhotelhabitacion, t0.sdescripcion descripcion, DATE_FORMAT(CAST(t0.tfechaingreso As Date), '%d-%m-%Y') fechaingreso, DATE_FORMAT(CAST(t0.tfechasalida As Date), '%d-%m-%Y') fechasalida, t0.nadultos adultos, t0.nninios ninios, t0.ncantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado,  t1.nidhotelhabitacion idhotelhabitacion, t2.nidreserva idreserva, t2.sreservanombre reservanombre, t3.snombre cathabitacion, t4.snombre hotel, CONCAT('[' ,t0.dprecio, ']' ) as concatenado");
		$builder->join('thotelhabitacion t1', ' t1.nidhotelhabitacion = t0.nidhotelhabitacion');
		$builder->join('treserva t2', ' t2.nidreserva = t0.nidreserva');
		$builder->join('tcathabitacion t3', ' t3.nidcathabitacion = t1.nidcathabitacion');
		$builder->join('thotel t4', ' t4.sidhotel = t1.sidhotel');

		if ($todos !== '') 
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidreservadetallehotelhabitacion', $text);
		$builder->orLike('t0.dprecio', $text);

		$builder->orderBy('t0.nidreserva', 'DESC');
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getReservadetallehotelhabitacion($nidreservadetallehotelhabitacion,$nidhotelhabitacion,$nidreserva){
		$builder = $this->conexion('treservadetallehotelhabitacion t0');
		$builder->select("t0.nidreserva idreserva, t0.nidreservadetallehotelhabitacion idreservadetallehotelhabitacion, t0.nidhotelhabitacion idhotelhabitacion, t0.sdescripcion descripcion,DATE_FORMAT(CAST(t0.tfechaingreso As Date), '%d/%m/%Y') fechaingreso,DATE_FORMAT(CAST(t0.tfechasalida As Date), '%d/%m/%Y') fechasalida, t0.nadultos adultos, t0.nninios ninios, t0.ncantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado");
		$builder->where(['nidreservadetallehotelhabitacion' => $nidreservadetallehotelhabitacion,'nidhotelhabitacion' => $nidhotelhabitacion,'nidreserva' => $nidreserva]);
		$query = $builder->get();
		return $query->getRowArray();
	}

	public function getReservadetallehotelhabitacion2($id){
		$builder = $this->conexion('treservadetallehotelhabitacion t0');
		$builder->select(" t0.nidreservadetallehotelhabitacion idreservadetallehotelhabitacion0, t0.sdescripcion descripcion0, t0.tfechaingreso fechaingreso0, t0.tfechasalida fechasalida0, t0.nadultos adultos0, t0.nninios ninios0, t0.ncantidad cantidad0, t0.dprecio precio0, t0.dtotal total0, t0.bconfirmado confirmado0, t0.bestado estado0, t1.nidreserva idreserva1, t1.sreservanombre reservanombre1, t1.tfechainicio fechainicio1, t1.tfechafin fechafin1, t1.ntipodoc tipodoc1, t1.sidpersona idpersona1, t1.sreservatelefono reservatelefono1, t1.sreservacorreo reservacorreo1, t1.dmontototal montototal1, t1.bpagado pagado1, t1.bestado estado1, t2.nidhotelhabitacion idhotelhabitacion2, t2.dprecio precio2, t2.tfecha fecha2, t2.bestado estado2, t2.bconfirmado confirmado2, t3.sidhotel idhotel3, t3.snombre nombre3, t3.sdireccion direccion3, t3.stelefono telefono3, t3.scorreo correo3, t3.sruc ruc3, t3.srazonsocial razonsocial3, t3.snrocuenta nrocuenta3, t3.subigeo ubigeo3, t3.dlatitud latitud3, t3.dlongitud longitud3, t3.bestado estado3, t4.nidcathotel idcathotel4, t4.snombre nombre4, t4.bestado estado4, t5.nidbanco idbanco5, t5.snombre nombre5, t5.bestado estado5, t4.nidcathabitacion idcathabitacion4, t4.snombre nombre4, t4.bestado estado4,");
		$builder->join('treserva t1', ' t0.nidreserva = t1.nidreserva');
		$builder->join('thotelhabitacion t2', ' t0.nidhotelhabitacion = t2.nidhotelhabitacion');
		$builder->join('thotel t3', ' t2.sidhotel = t3.sidhotel');
		$builder->join('tcathotel t4', ' t3.nidcathotel = t4.nidcathotel');
		$builder->join('tbanco t5', ' t3.nidbanco = t5.nidbanco');
		$builder->join('tcathabitacion t4', ' t2.nidcathabitacion = t4.nidcathabitacion');

		$builder->where('t0.nidreserva', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('treservadetallehotelhabitacion t0');
		$builder->select('nidreserva');
		$builder->join('thotelhabitacion t1', ' t1.nidhotelhabitacion = t0.nidhotelhabitacion');
		$builder->join('treserva t2', ' t2.nidreserva = t0.nidreserva');
		$builder->join('tcathabitacion t3', ' t3.nidcathabitacion = t1.nidcathabitacion');
		$builder->join('thotel t4', ' t4.sidhotel = t1.sidhotel');

		if ($todos !== '')
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidreservadetallehotelhabitacion', $text);
		$builder->orLike('t0.dprecio', $text);

		return $builder->countAllResults();
	}

	public function UpdateReservadetallehotelhabitacion($nidreservadetallehotelhabitacion,$nidhotelhabitacion,$nidreserva, $datos){
		$builder = $this->conexion('treservadetallehotelhabitacion');
		$builder->where(['nidreservadetallehotelhabitacion' => $nidreservadetallehotelhabitacion,'nidhotelhabitacion' => $nidhotelhabitacion,'nidreserva' => $nidreserva]);
		$builder->set($datos);
		$builder->update();
	}

	public function getMaxid(){
		$builder = $this->conexion('treservadetallehotelhabitacion');
		$builder->selectMax('nidreserva');
		$query = $builder->get();
		return  $query->getResult()[0]->nidreserva;
	}
}
?>
