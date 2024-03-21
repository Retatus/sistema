<?php 

namespace App\Models;
use CodeIgniter\Model; 

class ReservadetalletourModel extends Model
{
	protected $table      = 'treservadetalletour';
	protected $primaryKey = 'nidreserva';

	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['nidreserva','sidtour','sdescripcion','tfecha','ncantidad','dprecio','dtotal','bconfirmado','bestado'];
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

	public function getReservadetalletours($todos = 1, $text = '', $total, $pag = 1){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;
		$builder = $this->conexion('treservadetalletour t0');
		$builder->select("t0.nidreserva idreserva, t0.nidreservatour idreservatour, t0.sidtour idtour, t0.sdescripcion descripcion, DATE_FORMAT(CAST(t0.tfecha As Date), '%d-%m-%Y') fecha, t0.ncantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado,  t1.nidreserva idreserva, t1.sreservanombre reservanombre, t2.sidtour idtour, t2.stournombre tournombre, t3.snombre cattour, CONCAT(t2.stournombre, ' - ', '[' ,t2.dtourprecio, ']' ) as concatenado, CONCAT(t2.stournombre) as concatenadodetalle");
		$builder->join('treserva t1', ' t1.nidreserva = t0.nidreserva');
		$builder->join('ttour t2', ' t2.sidtour = t0.sidtour');
		$builder->join('tcattour t3', ' t3.nidcattour = t2.nidcattour');

		if ($todos !== '') 
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidreservatour', $text);
		$builder->orLike('t2.stournombre', $text);
		$builder->orLike('t2.dtourprecio', $text);

		$builder->orderBy('t0.nidreserva', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getAutocompletereservadetalletours($todos = 1, $text = ''){
		$builder = $this->conexion('treservadetalletour t0');
		$builder->select("t0.nidreserva idreserva, t0.nidreservatour idreservatour, t0.sidtour idtour, t0.sdescripcion descripcion, DATE_FORMAT(CAST(t0.tfecha As Date), '%d-%m-%Y') fecha, t0.ncantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado,  t1.nidreserva idreserva, t1.sreservanombre reservanombre, t2.sidtour idtour, t2.stournombre tournombre, t3.snombre cattour, CONCAT(t2.stournombre, ' - ', '[' ,t2.dtourprecio, ']' ) as concatenado, CONCAT(t2.stournombre) as concatenadodetalle");
		$builder->join('treserva t1', ' t1.nidreserva = t0.nidreserva');
		$builder->join('ttour t2', ' t2.sidtour = t0.sidtour');
		$builder->join('tcattour t3', ' t3.nidcattour = t2.nidcattour');

		if ($todos !== '') 
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidreservatour', $text);
		$builder->orLike('t2.stournombre', $text);
		$builder->orLike('t2.dtourprecio', $text);

		$builder->orderBy('t0.nidreserva', 'DESC');
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getReservadetalletour($id){
		$builder = $this->conexion('treservadetalletour t0');
		$builder->select("t0.nidreserva idreserva, t0.nidreservatour idreservatour, t0.sidtour idtour, t0.sdescripcion descripcion,DATE_FORMAT(CAST(t0.tfecha As Date), '%d/%m/%Y') fecha, t0.ncantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado");
		$builder->where('nidreserva', $id);
		$query = $builder->get();
		return $query->getRowArray();
	}

	public function getReservadetalletour2($id){
		$builder = $this->conexion('treservadetalletour t0');
		$builder->select(" t0.nidreservatour idreservatour0, t0.sdescripcion descripcion0, t0.tfecha fecha0, t0.ncantidad cantidad0, t0.dprecio precio0, t0.dtotal total0, t0.bconfirmado confirmado0, t0.bestado estado0, t1.nidreserva idreserva1, t1.sreservanombre reservanombre1, t1.tfechainicio fechainicio1, t1.tfechafin fechafin1, t1.ntipodoc tipodoc1, t1.sidpersona idpersona1, t1.sreservatelefono reservatelefono1, t1.sreservacorreo reservacorreo1, t1.dmontototal montototal1, t1.bpagado pagado1, t1.bestado estado1, t2.sidtour idtour2, t2.stournombre tournombre2, t2.stourdescripcion tourdescripcion2, t2.dtourprecio tourprecio2, t2.scolor color2, t2.stourdiashabiles tourdiashabiles2, t2.btourestado tourestado2, t3.nidcattour idcattour3, t3.snombre nombre3, t3.bestado estado3,");
		$builder->join('treserva t1', ' t0.nidreserva = t1.nidreserva');
		$builder->join('ttour t2', ' t0.sidtour = t2.sidtour');
		$builder->join('tcattour t3', ' t2.nidcattour = t3.nidcattour');

		$builder->where('t0.nidreserva', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('treservadetalletour t0');
		$builder->select('nidreserva');
		$builder->join('treserva t1', ' t1.nidreserva = t0.nidreserva');
		$builder->join('ttour t2', ' t2.sidtour = t0.sidtour');
		$builder->join('tcattour t3', ' t3.nidcattour = t2.nidcattour');

		if ($todos !== '')
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidreservatour', $text);
		$builder->orLike('t2.stournombre', $text);
		$builder->orLike('t2.dtourprecio', $text);

		return $builder->countAllResults();
	}

	public function UpdateReservadetalletour($id, $datos){
		$builder = $this->conexion('treservadetalletour');
		$builder->where('nidreserva', $id);
		$builder->set($datos);
		$builder->update();
	}

	public function getMaxid(){
		$builder = $this->conexion('treservadetalletour');
		$builder->selectMax('nidreserva');
		$query = $builder->get();
		return  $query->getResult()[0]->nidreserva;
	}
}
?>
