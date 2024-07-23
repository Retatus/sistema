<?php

namespace App\Models;
use CodeIgniter\Model; 

class ReservadetallehotelhabitacionModel extends Model
{
	protected $table      = 'treservadetallehotelhabitacion';
	protected $primaryKey = 'nidreservadetallehotelhabitacion';
	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['nidreserva', 'nidreservadetallehotelhabitacion', 'nidhotelhabitacion', 'sdescripcion', 'tfechaingreso', 'tfechasalida', 'nadultos', 'nninios', 'ncantidad', 'dprecio', 'dtotal', 'bconfirmado', 'bestado'];
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
	public function existe($nidreserva, $nidreservadetallehotelhabitacion, $nidhotelhabitacion){
		return $this->where(['nidreserva' => $nidreserva, 'nidreservadetallehotelhabitacion' => $nidreservadetallehotelhabitacion, 'nidhotelhabitacion' => $nidhotelhabitacion])->countAllResults();
	}

//   SECCION ====== TODOS ======
	public function getReservadetallehotelhabitacions($total, $pag = 1, $todos = 1, $text = ''){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;

		$builder = $this->conexion('treservadetallehotelhabitacion t0');

		$builder->select("t0.nidreservadetallehotelhabitacion idreservadetallehotelhabitacion, t0.sdescripcion descripcion, DATE_FORMAT(t0.tfechaingreso,'%d/%m/%Y') fechaingreso, DATE_FORMAT(t0.tfechasalida,'%d/%m/%Y') fechasalida, t0.nadultos adultos, t0.nninios ninios, t0.ncantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado, t1.nidhotelhabitacion idhotelhabitacion, t2.nidcathabitacion idcathabitacion, t2.snombre nombre, t3.sidhotel idhotel, t3.snombre nombre, t4.nidbanco idbanco, t4.snombre nombre, t5.nidcathotel idcathotel, t5.snombre nombre, t6.nidreserva idreserva, t6.sreservanombre reservanombre, CONCAT('[',t0.dprecio,']',' - ','[',t1.dprecio,']',' - ',t2.snombre,' - ',t3.snombre,' - ',t4.snombre,' - ',t5.snombre,' - ',t6.sreservanombre) concatenado, CONCAT(t2.snombre,' - ',t3.snombre,' - ',t4.snombre,' - ',t5.snombre,' - ',t6.sreservanombre) concatenadodetalle");

		$builder->join('thotelhabitacion t1', 't1.nidhotelhabitacion = t0.nidhotelhabitacion');
		$builder->join('tcathabitacion t2', 't2.nidcathabitacion = t1.nidcathabitacion');
		$builder->join('thotel t3', 't3.sidhotel = t1.sidhotel');
		$builder->join('tbanco t4', 't4.nidbanco = t3.nidbanco');
		$builder->join('tcathotel t5', 't5.nidcathotel = t3.nidcathotel');
		$builder->join('treserva t6', 't6.nidreserva = t0.nidreserva');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidreservadetallehotelhabitacion', $text)
				->orLike('t0.dprecio', $text)
				->orLike('t1.dprecio', $text)
				->orLike('t2.snombre', $text)
				->orLike('t3.snombre', $text)
				->orLike('t4.snombre', $text)
				->orLike('t5.snombre', $text)
				->orLike('t6.sreservanombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidreservadetallehotelhabitacion', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== AUTOCOMPLETE ======
	public function getAutocompleteReservadetallehotelhabitacions($todos = 1, $text = ''){
		$builder = $this->conexion('treservadetallehotelhabitacion t0');

		$builder->select("t0.nidreservadetallehotelhabitacion idreservadetallehotelhabitacion, t0.sdescripcion descripcion, DATE_FORMAT(t0.tfechaingreso,'%d/%m/%Y') fechaingreso, DATE_FORMAT(t0.tfechasalida,'%d/%m/%Y') fechasalida, t0.nadultos adultos, t0.nninios ninios, t0.ncantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado, t1.nidhotelhabitacion idhotelhabitacion, t2.nidcathabitacion idcathabitacion, t2.snombre nombre, t3.sidhotel idhotel, t3.snombre nombre, t4.nidbanco idbanco, t4.snombre nombre, t5.nidcathotel idcathotel, t5.snombre nombre, t6.nidreserva idreserva, t6.sreservanombre reservanombre, CONCAT('[',t0.dprecio,']',' - ','[',t1.dprecio,']',' - ',t2.snombre,' - ',t3.snombre,' - ',t4.snombre,' - ',t5.snombre,' - ',t6.sreservanombre) concatenado, CONCAT(t2.snombre,' - ',t3.snombre,' - ',t4.snombre,' - ',t5.snombre,' - ',t6.sreservanombre) concatenadodetalle");
		$builder->join('thotelhabitacion t1', 't1.nidhotelhabitacion = t0.nidhotelhabitacion');
		$builder->join('tcathabitacion t2', 't2.nidcathabitacion = t1.nidcathabitacion');
		$builder->join('thotel t3', 't3.sidhotel = t1.sidhotel');
		$builder->join('tbanco t4', 't4.nidbanco = t3.nidbanco');
		$builder->join('tcathotel t5', 't5.nidcathotel = t3.nidcathotel');
		$builder->join('treserva t6', 't6.nidreserva = t0.nidreserva');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidreservadetallehotelhabitacion', $text)
				->orLike('t0.dprecio', $text)
				->orLike('t1.dprecio', $text)
				->orLike('t2.snombre', $text)
				->orLike('t3.snombre', $text)
				->orLike('t4.snombre', $text)
				->orLike('t5.snombre', $text)
				->orLike('t6.sreservanombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidreservadetallehotelhabitacion', 'DESC');
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== GET ======
	public function getreservadetallehotelhabitacion($nidreserva, $nidreservadetallehotelhabitacion, $nidhotelhabitacion){
		$builder = $this->conexion('treservadetallehotelhabitacion t0');
		$builder->select("t0.nidreserva idreserva, t0.nidreservadetallehotelhabitacion idreservadetallehotelhabitacion, t0.nidhotelhabitacion idhotelhabitacion, t0.sdescripcion descripcion, DATE_FORMAT(t0.tfechaingreso,'%d/%m/%Y') fechaingreso, DATE_FORMAT(t0.tfechasalida,'%d/%m/%Y') fechasalida, t0.nadultos adultos, t0.nninios ninios, t0.ncantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado");
		$builder->where(['nidreserva' => $nidreserva, 'nidreservadetallehotelhabitacion' => $nidreservadetallehotelhabitacion, 'nidhotelhabitacion' => $nidhotelhabitacion]);
		$query = $builder->get();
		return $query->getRowArray();
	}

//   SECCION ====== GET 2 ======
	public function getReservadetallehotelhabitacion2($id){
		$builder = $this->conexion('treservadetallehotelhabitacion t0');
		$builder->select("t0.nidreserva idreserva, t0.nidreservadetallehotelhabitacion idreservadetallehotelhabitacion, t0.nidhotelhabitacion idhotelhabitacion, t0.sdescripcion descripcion, DATE_FORMAT(t0.tfechaingreso,'%d/%m/%Y') fechaingreso, DATE_FORMAT(t0.tfechasalida,'%d/%m/%Y') fechasalida, t0.nadultos adultos, t0.nninios ninios, t0.ncantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado");
		$builder->join('thotelhabitacion t1', 't1.nidhotelhabitacion = t0.nidhotelhabitacion');
		$builder->join('tcathabitacion t2', 't2.nidcathabitacion = t1.nidcathabitacion');
		$builder->join('thotel t3', 't3.sidhotel = t1.sidhotel');
		$builder->join('tbanco t4', 't4.nidbanco = t3.nidbanco');
		$builder->join('tcathotel t5', 't5.nidcathotel = t3.nidcathotel');
		$builder->join('treserva t6', 't6.nidreserva = t0.nidreserva');
		$builder->where('t0.nidreservadetallehotelhabitacion', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}
//   SECCION ====== COUNT ======
	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('treservadetallehotelhabitacion t0');
		$builder->select('nidreservadetallehotelhabitacion');
		$builder->join('thotelhabitacion t1', 't1.nidhotelhabitacion = t0.nidhotelhabitacion');
		$builder->join('tcathabitacion t2', 't2.nidcathabitacion = t1.nidcathabitacion');
		$builder->join('thotel t3', 't3.sidhotel = t1.sidhotel');
		$builder->join('tbanco t4', 't4.nidbanco = t3.nidbanco');
		$builder->join('tcathotel t5', 't5.nidcathotel = t3.nidcathotel');
		$builder->join('treserva t6', 't6.nidreserva = t0.nidreserva');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidreservadetallehotelhabitacion', $text)
				->orLike('t0.dprecio', $text)
				->orLike('t1.dprecio', $text)
				->orLike('t2.snombre', $text)
				->orLike('t3.snombre', $text)
				->orLike('t4.snombre', $text)
				->orLike('t5.snombre', $text)
				->orLike('t6.sreservanombre', $text)
				->groupEnd();
		}

		return $builder->countAllResults();
	}

//   SECCION ====== UPDATE ======
	public function UpdateReservadetallehotelhabitacion($nidreserva, $nidreservadetallehotelhabitacion, $nidhotelhabitacion,  $datos){
		$builder = $this->conexion('treservadetallehotelhabitacion');
		$builder->where(['nidreserva' => $nidreserva, 'nidreservadetallehotelhabitacion' => $nidreservadetallehotelhabitacion, 'nidhotelhabitacion' => $nidhotelhabitacion]);
		$builder->set($datos);
		$builder->update();
	}

//   SECCION ====== MAXIMO ID ======
	public function getMaxid(){
		$builder = $this->conexion('treservadetallehotelhabitacion');
		$builder->selectMax('nidreservadetallehotelhabitacion');
		$query = $builder->get();
		return  $query->getResult()[0]->nidreservadetallehotelhabitacion;
	}
}
?>
