<?php 

namespace App\Models;
use CodeIgniter\Model; 

class HotelhabitacionModel extends Model
{
	protected $table      = 'thotelhabitacion';
	protected $primaryKey = 'nidhotelhabitacion';

	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['sidhotel','nidcathabitacion','dprecio','tfecha','bestado','bconfirmado'];
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
		return $this->where(['nidhotelhabitacion' => $id])->countAllResults();
	}

	public function getHotelhabitacions($todos = 1, $text = '', $total, $pag = 1){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;
		$builder = $this->conexion('thotelhabitacion t0');
		$builder->select("t0.nidhotelhabitacion idhotelhabitacion, t0.sidhotel idhotel, t0.nidcathabitacion idcathabitacion, t0.dprecio precio, DATE_FORMAT(CAST(t0.tfecha As Date), '%d-%m-%Y') fecha, t0.bestado estado, t0.bconfirmado confirmado,  t1.nidcathabitacion idcathabitacion, t1.snombre nombre, t2.sidhotel idhotel, t2.snombre nombre, t3.snombre banco, t4.snombre cathotel, CONCAT('[' ,t0.dprecio, ']' , ' - ', t2.snombre, ' - ', t1.snombre) as concatenado, CONCAT(t2.snombre, ' - ', t1.snombre) as concatenadodetalle");
		$builder->join('tcathabitacion t1', ' t1.nidcathabitacion = t0.nidcathabitacion');
		$builder->join('thotel t2', ' t2.sidhotel = t0.sidhotel');
		$builder->join('tbanco t3', ' t3.nidbanco = t2.nidbanco');
		$builder->join('tcathotel t4', ' t4.nidcathotel = t2.nidcathotel');

		if ($todos !== '') 
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidhotelhabitacion', $text);
		$builder->orLike('t0.dprecio', $text);
		$builder->orLike('t2.snombre', $text);
		$builder->orLike('t1.snombre', $text);

		$builder->orderBy('t0.nidhotelhabitacion', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getAutocompletehotelhabitacions($todos = 1, $text = ''){
		$builder = $this->conexion('thotelhabitacion t0');
		$builder->select("t0.nidhotelhabitacion idhotelhabitacion, t0.sidhotel idhotel, t0.nidcathabitacion idcathabitacion, t0.dprecio precio, DATE_FORMAT(CAST(t0.tfecha As Date), '%d-%m-%Y') fecha, t0.bestado estado, t0.bconfirmado confirmado,  t1.nidcathabitacion idcathabitacion, t1.snombre nombre, t2.sidhotel idhotel, t2.snombre nombre, t3.snombre banco, t4.snombre cathotel, CONCAT('[' ,t0.dprecio, ']' , ' - ', t2.snombre, ' - ', t1.snombre) as concatenado, CONCAT(t2.snombre, ' - ', t1.snombre) as concatenadodetalle");
		$builder->join('tcathabitacion t1', ' t1.nidcathabitacion = t0.nidcathabitacion');
		$builder->join('thotel t2', ' t2.sidhotel = t0.sidhotel');
		$builder->join('tbanco t3', ' t3.nidbanco = t2.nidbanco');
		$builder->join('tcathotel t4', ' t4.nidcathotel = t2.nidcathotel');

		if ($todos !== '') 
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidhotelhabitacion', $text);
		$builder->orLike('t0.dprecio', $text);
		$builder->orLike('t2.snombre', $text);
		$builder->orLike('t1.snombre', $text);

		$builder->orderBy('t0.nidhotelhabitacion', 'DESC');
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getHotelhabitacion($id){
		$builder = $this->conexion('thotelhabitacion t0');
		$builder->select("t0.nidhotelhabitacion idhotelhabitacion, t0.sidhotel idhotel, t0.nidcathabitacion idcathabitacion, t0.dprecio precio,DATE_FORMAT(CAST(t0.tfecha As Date), '%d/%m/%Y') fecha, t0.bestado estado, t0.bconfirmado confirmado");
		$builder->where('nidhotelhabitacion', $id);
		$query = $builder->get();
		return $query->getRowArray();
	}

	public function getHotelhabitacion2($id){
		$builder = $this->conexion('thotelhabitacion t0');
		$builder->select(" t0.nidhotelhabitacion idhotelhabitacion0, t0.dprecio precio0, t0.tfecha fecha0, t0.bestado estado0, t0.bconfirmado confirmado0, t1.sidhotel idhotel1, t1.snombre nombre1, t1.sdireccion direccion1, t1.stelefono telefono1, t1.scorreo correo1, t1.sruc ruc1, t1.srazonsocial razonsocial1, t1.snrocuenta nrocuenta1, t1.subigeo ubigeo1, t1.dlatitud latitud1, t1.dlongitud longitud1, t1.bestado estado1, t2.nidcathotel idcathotel2, t2.snombre nombre2, t2.bestado estado2, t3.nidbanco idbanco3, t3.snombre nombre3, t3.bestado estado3, t2.nidcathabitacion idcathabitacion2, t2.snombre nombre2, t2.bestado estado2,");
		$builder->join('thotel t1', ' t0.sidhotel = t1.sidhotel');
		$builder->join('tcathotel t2', ' t1.nidcathotel = t2.nidcathotel');
		$builder->join('tbanco t3', ' t1.nidbanco = t3.nidbanco');
		$builder->join('tcathabitacion t2', ' t0.nidcathabitacion = t2.nidcathabitacion');

		$builder->where('t0.nidreserva', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('thotelhabitacion t0');
		$builder->select('nidhotelhabitacion');
		$builder->join('tcathabitacion t1', ' t1.nidcathabitacion = t0.nidcathabitacion');
		$builder->join('thotel t2', ' t2.sidhotel = t0.sidhotel');
		$builder->join('tbanco t3', ' t3.nidbanco = t2.nidbanco');
		$builder->join('tcathotel t4', ' t4.nidcathotel = t2.nidcathotel');

		if ($todos !== '')
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidhotelhabitacion', $text);
		$builder->orLike('t0.dprecio', $text);
		$builder->orLike('t2.snombre', $text);
		$builder->orLike('t1.snombre', $text);

		return $builder->countAllResults();
	}

	public function UpdateHotelhabitacion($id, $datos){
		$builder = $this->conexion('thotelhabitacion');
		$builder->where('nidhotelhabitacion', $id);
		$builder->set($datos);
		$builder->update();
	}

	public function getMaxid(){
		$builder = $this->conexion('thotelhabitacion');
		$builder->selectMax('nidhotelhabitacion');
		$query = $builder->get();
		return  $query->getResult()[0]->nidhotelhabitacion;
	}
}
?>
