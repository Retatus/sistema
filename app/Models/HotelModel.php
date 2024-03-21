<?php 

namespace App\Models;
use CodeIgniter\Model; 

class HotelModel extends Model
{
	protected $table      = 'thotel';
	protected $primaryKey = 'sidhotel';

	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['sidhotel','snombre','nidcathotel','sdireccion','stelefono','scorreo','sruc','srazonsocial','snrocuenta','nidbanco','subigeo','dlatitud','dlongitud','bestado'];
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
		return $this->where(['sidhotel' => $id])->countAllResults();
	}

	public function getHotels($todos = 1, $text = '', $total, $pag = 1){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;
		$builder = $this->conexion('thotel t0');
		$builder->select("t0.sidhotel idhotel, t0.snombre nombre, t0.nidcathotel idcathotel, t0.sdireccion direccion, t0.stelefono telefono, t0.scorreo correo, t0.sruc ruc, t0.srazonsocial razonsocial, t0.snrocuenta nrocuenta, t0.nidbanco idbanco, t0.subigeo ubigeo, t0.dlatitud latitud, t0.dlongitud longitud, t0.bestado estado,  t1.nidbanco idbanco, t1.snombre nombre, t2.nidcathotel idcathotel, t2.snombre nombre, CONCAT(t0.snombre, ' - ', t2.snombre) as concatenado, CONCAT(t0.snombre, ' - ', t2.snombre) as concatenadodetalle");
		$builder->join('tbanco t1', ' t1.nidbanco = t0.nidbanco');
		$builder->join('tcathotel t2', ' t2.nidcathotel = t0.nidcathotel');

		if ($todos !== '') 
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.sidhotel', $text);
		$builder->orLike('t0.snombre', $text);
		$builder->orLike('t2.snombre', $text);

		$builder->orderBy('t0.sidhotel', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getAutocompletehotels($todos = 1, $text = ''){
		$builder = $this->conexion('thotel t0');
		$builder->select("t0.sidhotel idhotel, t0.snombre nombre, t0.nidcathotel idcathotel, t0.sdireccion direccion, t0.stelefono telefono, t0.scorreo correo, t0.sruc ruc, t0.srazonsocial razonsocial, t0.snrocuenta nrocuenta, t0.nidbanco idbanco, t0.subigeo ubigeo, t0.dlatitud latitud, t0.dlongitud longitud, t0.bestado estado,  t1.nidbanco idbanco, t1.snombre nombre, t2.nidcathotel idcathotel, t2.snombre nombre, CONCAT(t0.snombre, ' - ', t2.snombre) as concatenado, CONCAT(t0.snombre, ' - ', t2.snombre) as concatenadodetalle");
		$builder->join('tbanco t1', ' t1.nidbanco = t0.nidbanco');
		$builder->join('tcathotel t2', ' t2.nidcathotel = t0.nidcathotel');

		if ($todos !== '') 
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.sidhotel', $text);
		$builder->orLike('t0.snombre', $text);
		$builder->orLike('t2.snombre', $text);

		$builder->orderBy('t0.sidhotel', 'DESC');
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getHotel($id){
		$builder = $this->conexion('thotel t0');
		$builder->select("t0.sidhotel idhotel, t0.snombre nombre, t0.nidcathotel idcathotel, t0.sdireccion direccion, t0.stelefono telefono, t0.scorreo correo, t0.sruc ruc, t0.srazonsocial razonsocial, t0.snrocuenta nrocuenta, t0.nidbanco idbanco, t0.subigeo ubigeo, t0.dlatitud latitud, t0.dlongitud longitud, t0.bestado estado");
		$builder->where('sidhotel', $id);
		$query = $builder->get();
		return $query->getRowArray();
	}

	public function getHotel2($id){
		$builder = $this->conexion('thotel t0');
		$builder->select(" t0.sidhotel idhotel0, t0.snombre nombre0, t0.sdireccion direccion0, t0.stelefono telefono0, t0.scorreo correo0, t0.sruc ruc0, t0.srazonsocial razonsocial0, t0.snrocuenta nrocuenta0, t0.subigeo ubigeo0, t0.dlatitud latitud0, t0.dlongitud longitud0, t0.bestado estado0, t1.nidcathotel idcathotel1, t1.snombre nombre1, t1.bestado estado1, t2.nidbanco idbanco2, t2.snombre nombre2, t2.bestado estado2,");
		$builder->join('tcathotel t1', ' t0.nidcathotel = t1.nidcathotel');
		$builder->join('tbanco t2', ' t0.nidbanco = t2.nidbanco');

		$builder->where('t0.nidreserva', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('thotel t0');
		$builder->select('sidhotel');
		$builder->join('tbanco t1', ' t1.nidbanco = t0.nidbanco');
		$builder->join('tcathotel t2', ' t2.nidcathotel = t0.nidcathotel');

		if ($todos !== '')
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.sidhotel', $text);
		$builder->orLike('t0.snombre', $text);
		$builder->orLike('t2.snombre', $text);

		return $builder->countAllResults();
	}

	public function UpdateHotel($id, $datos){
		$builder = $this->conexion('thotel');
		$builder->where('sidhotel', $id);
		$builder->set($datos);
		$builder->update();
	}

	public function getMaxid(){
		$builder = $this->conexion('thotel');
		$builder->selectMax('sidhotel');
		$query = $builder->get();
		return  $query->getResult()[0]->sidhotel;
	}
}
?>
