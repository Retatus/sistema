<?php

namespace App\Models;
use CodeIgniter\Model; 

class ReservadetalleotroservicioModel extends Model
{
	protected $table      = 'treservadetalleotroservicio';
	protected $primaryKey = 'nidreservadetalleotroservicio';
	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['nidreserva', 'nidreservadetalleotroservicio', 'nidotroservicio', 'sdescripcion', 'tfecha', 'ncantidad', 'dprecio', 'dtotal', 'bconfirmado', 'bestado'];
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
	public function existe($nidreserva, $nidreservadetalleotroservicio, $nidotroservicio){
		return $this->where(['nidreserva' => $nidreserva, 'nidreservadetalleotroservicio' => $nidreservadetalleotroservicio, 'nidotroservicio' => $nidotroservicio])->countAllResults();
	}

//   SECCION ====== TODOS ======
	public function getReservadetalleotroservicios($total, $pag = 1, $todos = 1, $text = ''){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;

		$builder = $this->conexion('treservadetalleotroservicio t0');

		$builder->select("t0.nidreservadetalleotroservicio idreservadetalleotroservicio, t0.sdescripcion descripcion, DATE_FORMAT(t0.tfecha,'%d/%m/%Y') fecha, t0.ncantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado, t1.nidotroservicio idotroservicio, t1.sotroservicionombre otroservicionombre, t2.nidreserva idreserva, t2.sreservanombre reservanombre, CONCAT('[',t0.dprecio,']',' - ','[',t1.dotroservicioprecio,']',' - ',t1.sotroservicionombre,' - ',t2.sreservanombre) concatenado, CONCAT(t1.sotroservicionombre,' - ',t2.sreservanombre) concatenadodetalle");

		$builder->join('totroservicio t1', 't1.nidotroservicio = t0.nidotroservicio');
		$builder->join('treserva t2', 't2.nidreserva = t0.nidreserva');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidreservadetalleotroservicio', $text)
				->orLike('t0.dprecio', $text)
				->orLike('t1.dotroservicioprecio', $text)
				->orLike('t1.sotroservicionombre', $text)
				->orLike('t2.sreservanombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidreservadetalleotroservicio', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== AUTOCOMPLETE ======
	public function getAutocompleteReservadetalleotroservicios($todos = 1, $text = ''){
		$builder = $this->conexion('treservadetalleotroservicio t0');

		$builder->select("t0.nidreservadetalleotroservicio idreservadetalleotroservicio, t0.sdescripcion descripcion, DATE_FORMAT(t0.tfecha,'%d/%m/%Y') fecha, t0.ncantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado, t1.nidotroservicio idotroservicio, t1.sotroservicionombre otroservicionombre, t2.nidreserva idreserva, t2.sreservanombre reservanombre, CONCAT('[',t0.dprecio,']',' - ','[',t1.dotroservicioprecio,']',' - ',t1.sotroservicionombre,' - ',t2.sreservanombre) concatenado, CONCAT(t1.sotroservicionombre,' - ',t2.sreservanombre) concatenadodetalle");
		$builder->join('totroservicio t1', 't1.nidotroservicio = t0.nidotroservicio');
		$builder->join('treserva t2', 't2.nidreserva = t0.nidreserva');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidreservadetalleotroservicio', $text)
				->orLike('t0.dprecio', $text)
				->orLike('t1.dotroservicioprecio', $text)
				->orLike('t1.sotroservicionombre', $text)
				->orLike('t2.sreservanombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidreservadetalleotroservicio', 'DESC');
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== GET ======
	public function getreservadetalleotroservicio($nidreserva, $nidreservadetalleotroservicio, $nidotroservicio){
		$builder = $this->conexion('treservadetalleotroservicio t0');
		$builder->select("t0.nidreserva idreserva, t0.nidreservadetalleotroservicio idreservadetalleotroservicio, t0.nidotroservicio idotroservicio, t0.sdescripcion descripcion, DATE_FORMAT(t0.tfecha,'%d/%m/%Y') fecha, t0.ncantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado");
		$builder->where(['nidreserva' => $nidreserva, 'nidreservadetalleotroservicio' => $nidreservadetalleotroservicio, 'nidotroservicio' => $nidotroservicio]);
		$query = $builder->get();
		return $query->getRowArray();
	}

//   SECCION ====== GET 2 ======
	public function getReservadetalleotroservicio2($id){
		$builder = $this->conexion('treservadetalleotroservicio t0');
		$builder->select("t0.nidreserva idreserva, t0.nidreservadetalleotroservicio idreservadetalleotroservicio, t0.nidotroservicio idotroservicio, t0.sdescripcion descripcion, DATE_FORMAT(t0.tfecha,'%d/%m/%Y') fecha, t0.ncantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado");
		$builder->join('totroservicio t1', 't1.nidotroservicio = t0.nidotroservicio');
		$builder->join('treserva t2', 't2.nidreserva = t0.nidreserva');
		$builder->where('t0.nidreservadetalleotroservicio', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}
//   SECCION ====== COUNT ======
	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('treservadetalleotroservicio t0');
		$builder->select('nidreservadetalleotroservicio');
		$builder->join('totroservicio t1', 't1.nidotroservicio = t0.nidotroservicio');
		$builder->join('treserva t2', 't2.nidreserva = t0.nidreserva');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidreservadetalleotroservicio', $text)
				->orLike('t0.dprecio', $text)
				->orLike('t1.dotroservicioprecio', $text)
				->orLike('t1.sotroservicionombre', $text)
				->orLike('t2.sreservanombre', $text)
				->groupEnd();
		}

		return $builder->countAllResults();
	}

//   SECCION ====== UPDATE ======
	public function UpdateReservadetalleotroservicio($nidreserva, $nidreservadetalleotroservicio, $nidotroservicio,  $datos){
		$builder = $this->conexion('treservadetalleotroservicio');
		$builder->where(['nidreserva' => $nidreserva, 'nidreservadetalleotroservicio' => $nidreservadetalleotroservicio, 'nidotroservicio' => $nidotroservicio]);
		$builder->set($datos);
		$builder->update();
	}

//   SECCION ====== MAXIMO ID ======
	public function getMaxid(){
		$builder = $this->conexion('treservadetalleotroservicio');
		$builder->selectMax('nidreservadetalleotroservicio');
		$query = $builder->get();
		return  $query->getResult()[0]->nidreservadetalleotroservicio;
	}
}
?>
