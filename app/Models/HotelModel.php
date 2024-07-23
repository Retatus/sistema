<?php

namespace App\Models;
use CodeIgniter\Model; 

class HotelModel extends Model
{
	protected $table      = 'thotel';
	protected $primaryKey = 'sidhotel';
	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['sidhotel', 'snombre', 'nidcathotel', 'sdireccion', 'stelefono', 'scorreo', 'sruc', 'srazonsocial', 'snrocuenta', 'nidbanco', 'subigeo', 'dlatitud', 'dlongitud', 'bestado'];
	protected $useTimestamps = false;
	protected $createdField  = 'tfecha_alt';
	protected $updatedField  = 'tfecha_edi';
	protected $deletedField  = 'deleted_at';

	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = false;

//   SECCION ====== CONEXION ======
	protected function conexion(string $table = null){
		$this->db = \Config\Database::connect();
		$this->builder = $this->db->table($table);
		return $this->builder;
	}

//   SECCION ====== EXISTE ======
	public function existe($sidhotel, $nidcathotel, $nidbanco){
		return $this->where(['sidhotel' => $sidhotel, 'nidcathotel' => $nidcathotel, 'nidbanco' => $nidbanco])->countAllResults();
	}

//   SECCION ====== TODOS ======
	public function getHotels($total, $pag = 1, $todos = 1, $text = ''){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;

		$builder = $this->conexion('thotel t0');

		$builder->select("t0.sidhotel idhotel, t0.snombre nombre, t0.sdireccion direccion, t0.stelefono telefono, t0.scorreo correo, t0.sruc ruc, t0.srazonsocial razonsocial, t0.snrocuenta nrocuenta, t0.subigeo ubigeo, t0.dlatitud latitud, t0.dlongitud longitud, t0.bestado estado, t1.nidbanco idbanco, t1.snombre nombre, t2.nidcathotel idcathotel, t2.snombre nombre, CONCAT(t0.snombre,' - ',t1.snombre,' - ',t2.snombre) concatenado, CONCAT(t0.snombre,' - ',t1.snombre,' - ',t2.snombre) concatenadodetalle");

		$builder->join('tbanco t1', 't1.nidbanco = t0.nidbanco');
		$builder->join('tcathotel t2', 't2.nidcathotel = t0.nidcathotel');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.sidhotel', $text)
				->orLike('t0.snombre', $text)
				->orLike('t1.snombre', $text)
				->orLike('t2.snombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.sidhotel', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== AUTOCOMPLETE ======
	public function getAutocompleteHotels($todos = 1, $text = ''){
		$builder = $this->conexion('thotel t0');

		$builder->select("t0.sidhotel idhotel, t0.snombre nombre, t0.sdireccion direccion, t0.stelefono telefono, t0.scorreo correo, t0.sruc ruc, t0.srazonsocial razonsocial, t0.snrocuenta nrocuenta, t0.subigeo ubigeo, t0.dlatitud latitud, t0.dlongitud longitud, t0.bestado estado, t1.nidbanco idbanco, t1.snombre nombre, t2.nidcathotel idcathotel, t2.snombre nombre, CONCAT(t0.snombre,' - ',t1.snombre,' - ',t2.snombre) concatenado, CONCAT(t0.snombre,' - ',t1.snombre,' - ',t2.snombre) concatenadodetalle");
		$builder->join('tbanco t1', 't1.nidbanco = t0.nidbanco');
		$builder->join('tcathotel t2', 't2.nidcathotel = t0.nidcathotel');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.sidhotel', $text)
				->orLike('t0.snombre', $text)
				->orLike('t1.snombre', $text)
				->orLike('t2.snombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.sidhotel', 'DESC');
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== GET ======
	public function gethotel($sidhotel, $nidcathotel, $nidbanco){
		$builder = $this->conexion('thotel t0');
		$builder->select("t0.sidhotel idhotel, t0.snombre nombre, t0.nidcathotel idcathotel, t0.sdireccion direccion, t0.stelefono telefono, t0.scorreo correo, t0.sruc ruc, t0.srazonsocial razonsocial, t0.snrocuenta nrocuenta, t0.nidbanco idbanco, t0.subigeo ubigeo, t0.dlatitud latitud, t0.dlongitud longitud, t0.bestado estado");
		$builder->where(['sidhotel' => $sidhotel, 'nidcathotel' => $nidcathotel, 'nidbanco' => $nidbanco]);
		$query = $builder->get();
		return $query->getRowArray();
	}

//   SECCION ====== GET 2 ======
	public function getHotel2($id){
		$builder = $this->conexion('thotel t0');
		$builder->select("t0.sidhotel idhotel, t0.snombre nombre, t0.nidcathotel idcathotel, t0.sdireccion direccion, t0.stelefono telefono, t0.scorreo correo, t0.sruc ruc, t0.srazonsocial razonsocial, t0.snrocuenta nrocuenta, t0.nidbanco idbanco, t0.subigeo ubigeo, t0.dlatitud latitud, t0.dlongitud longitud, t0.bestado estado");
		$builder->join('tbanco t1', 't1.nidbanco = t0.nidbanco');
		$builder->join('tcathotel t2', 't2.nidcathotel = t0.nidcathotel');
		$builder->where('t0.sidhotel', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}
//   SECCION ====== COUNT ======
	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('thotel t0');
		$builder->select('sidhotel');
		$builder->join('tbanco t1', 't1.nidbanco = t0.nidbanco');
		$builder->join('tcathotel t2', 't2.nidcathotel = t0.nidcathotel');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.sidhotel', $text)
				->orLike('t0.snombre', $text)
				->orLike('t1.snombre', $text)
				->orLike('t2.snombre', $text)
				->groupEnd();
		}

		return $builder->countAllResults();
	}

//   SECCION ====== UPDATE ======
	public function UpdateHotel($sidhotel, $nidcathotel, $nidbanco,  $datos){
		$builder = $this->conexion('thotel');
		$builder->where(['sidhotel' => $sidhotel, 'nidcathotel' => $nidcathotel, 'nidbanco' => $nidbanco]);
		$builder->set($datos);
		$builder->update();
	}

//   SECCION ====== MAXIMO ID ======
	public function getMaxid(){
		$builder = $this->conexion('thotel');
		$builder->selectMax('sidhotel');
		$query = $builder->get();
		return  $query->getResult()[0]->sidhotel;
	}
}
?>
