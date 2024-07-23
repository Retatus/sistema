<?php

namespace App\Models;
use CodeIgniter\Model; 

class HotelhabitacionModel extends Model
{
	protected $table      = 'thotelhabitacion';
	protected $primaryKey = 'nidhotelhabitacion';
	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['nidhotelhabitacion', 'sidhotel', 'nidcathabitacion', 'dprecio', 'tfecha', 'bestado', 'bconfirmado'];
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
	public function existe($nidhotelhabitacion, $sidhotel, $nidcathabitacion){
		return $this->where(['nidhotelhabitacion' => $nidhotelhabitacion, 'sidhotel' => $sidhotel, 'nidcathabitacion' => $nidcathabitacion])->countAllResults();
	}

//   SECCION ====== TODOS ======
	public function getHotelhabitacions($total, $pag = 1, $todos = 1, $text = ''){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;

		$builder = $this->conexion('thotelhabitacion t0');

		$builder->select("t0.nidhotelhabitacion idhotelhabitacion, t0.dprecio precio, DATE_FORMAT(t0.tfecha,'%d/%m/%Y') fecha, t0.bestado estado, t0.bconfirmado confirmado, t1.nidcathabitacion idcathabitacion, t1.snombre nombre, t2.sidhotel idhotel, t2.snombre nombre, t3.nidbanco idbanco, t3.snombre nombre, t4.nidcathotel idcathotel, t4.snombre nombre, CONCAT('[',t0.dprecio,']',' - ',t1.snombre,' - ',t2.snombre,' - ',t3.snombre,' - ',t4.snombre) concatenado, CONCAT(t1.snombre,' - ',t2.snombre,' - ',t3.snombre,' - ',t4.snombre) concatenadodetalle");

		$builder->join('tcathabitacion t1', 't1.nidcathabitacion = t0.nidcathabitacion');
		$builder->join('thotel t2', 't2.sidhotel = t0.sidhotel');
		$builder->join('tbanco t3', 't3.nidbanco = t2.nidbanco');
		$builder->join('tcathotel t4', 't4.nidcathotel = t2.nidcathotel');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidhotelhabitacion', $text)
				->orLike('t0.dprecio', $text)
				->orLike('t1.snombre', $text)
				->orLike('t2.snombre', $text)
				->orLike('t3.snombre', $text)
				->orLike('t4.snombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidhotelhabitacion', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== AUTOCOMPLETE ======
	public function getAutocompleteHotelhabitacions($todos = 1, $text = ''){
		$builder = $this->conexion('thotelhabitacion t0');

		$builder->select("t0.nidhotelhabitacion idhotelhabitacion, t0.dprecio precio, DATE_FORMAT(t0.tfecha,'%d/%m/%Y') fecha, t0.bestado estado, t0.bconfirmado confirmado, t1.nidcathabitacion idcathabitacion, t1.snombre nombre, t2.sidhotel idhotel, t2.snombre nombre, t3.nidbanco idbanco, t3.snombre nombre, t4.nidcathotel idcathotel, t4.snombre nombre, CONCAT('[',t0.dprecio,']',' - ',t1.snombre,' - ',t2.snombre,' - ',t3.snombre,' - ',t4.snombre) concatenado, CONCAT(t1.snombre,' - ',t2.snombre,' - ',t3.snombre,' - ',t4.snombre) concatenadodetalle");
		$builder->join('tcathabitacion t1', 't1.nidcathabitacion = t0.nidcathabitacion');
		$builder->join('thotel t2', 't2.sidhotel = t0.sidhotel');
		$builder->join('tbanco t3', 't3.nidbanco = t2.nidbanco');
		$builder->join('tcathotel t4', 't4.nidcathotel = t2.nidcathotel');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidhotelhabitacion', $text)
				->orLike('t0.dprecio', $text)
				->orLike('t1.snombre', $text)
				->orLike('t2.snombre', $text)
				->orLike('t3.snombre', $text)
				->orLike('t4.snombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidhotelhabitacion', 'DESC');
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== GET ======
	public function gethotelhabitacion($nidhotelhabitacion, $sidhotel, $nidcathabitacion){
		$builder = $this->conexion('thotelhabitacion t0');
		$builder->select("t0.nidhotelhabitacion idhotelhabitacion, t0.sidhotel idhotel, t0.nidcathabitacion idcathabitacion, t0.dprecio precio, DATE_FORMAT(t0.tfecha,'%d/%m/%Y') fecha, t0.bestado estado, t0.bconfirmado confirmado");
		$builder->where(['nidhotelhabitacion' => $nidhotelhabitacion, 'sidhotel' => $sidhotel, 'nidcathabitacion' => $nidcathabitacion]);
		$query = $builder->get();
		return $query->getRowArray();
	}

//   SECCION ====== GET 2 ======
	public function getHotelhabitacion2($id){
		$builder = $this->conexion('thotelhabitacion t0');
		$builder->select("t0.nidhotelhabitacion idhotelhabitacion, t0.sidhotel idhotel, t0.nidcathabitacion idcathabitacion, t0.dprecio precio, DATE_FORMAT(t0.tfecha,'%d/%m/%Y') fecha, t0.bestado estado, t0.bconfirmado confirmado");
		$builder->join('tcathabitacion t1', 't1.nidcathabitacion = t0.nidcathabitacion');
		$builder->join('thotel t2', 't2.sidhotel = t0.sidhotel');
		$builder->join('tbanco t3', 't3.nidbanco = t2.nidbanco');
		$builder->join('tcathotel t4', 't4.nidcathotel = t2.nidcathotel');
		$builder->where('t0.nidhotelhabitacion', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}
//   SECCION ====== COUNT ======
	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('thotelhabitacion t0');
		$builder->select('nidhotelhabitacion');
		$builder->join('tcathabitacion t1', 't1.nidcathabitacion = t0.nidcathabitacion');
		$builder->join('thotel t2', 't2.sidhotel = t0.sidhotel');
		$builder->join('tbanco t3', 't3.nidbanco = t2.nidbanco');
		$builder->join('tcathotel t4', 't4.nidcathotel = t2.nidcathotel');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidhotelhabitacion', $text)
				->orLike('t0.dprecio', $text)
				->orLike('t1.snombre', $text)
				->orLike('t2.snombre', $text)
				->orLike('t3.snombre', $text)
				->orLike('t4.snombre', $text)
				->groupEnd();
		}

		return $builder->countAllResults();
	}

//   SECCION ====== UPDATE ======
	public function UpdateHotelhabitacion($nidhotelhabitacion, $sidhotel, $nidcathabitacion,  $datos){
		$builder = $this->conexion('thotelhabitacion');
		$builder->where(['nidhotelhabitacion' => $nidhotelhabitacion, 'sidhotel' => $sidhotel, 'nidcathabitacion' => $nidcathabitacion]);
		$builder->set($datos);
		$builder->update();
	}

//   SECCION ====== MAXIMO ID ======
	public function getMaxid(){
		$builder = $this->conexion('thotelhabitacion');
		$builder->selectMax('nidhotelhabitacion');
		$query = $builder->get();
		return  $query->getResult()[0]->nidhotelhabitacion;
	}
}
?>
