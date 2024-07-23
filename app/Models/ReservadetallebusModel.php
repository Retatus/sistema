<?php

namespace App\Models;
use CodeIgniter\Model; 

class ReservadetallebusModel extends Model
{
	protected $table      = 'treservadetallebus';
	protected $primaryKey = 'nidreservadetalleticketbus';
	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['nidreserva', 'nidreservadetalleticketbus', 'nidticketbus', 'sdescripcion', 'tfecha', 'ncantidad', 'dprecio', 'dtotal', 'bconfirmado', 'bestado'];
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
	public function existe($nidreserva, $nidreservadetalleticketbus, $nidticketbus){
		return $this->where(['nidreserva' => $nidreserva, 'nidreservadetalleticketbus' => $nidreservadetalleticketbus, 'nidticketbus' => $nidticketbus])->countAllResults();
	}

//   SECCION ====== TODOS ======
	public function getReservadetallebuss($total, $pag = 1, $todos = 1, $text = ''){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;

		$builder = $this->conexion('treservadetallebus t0');

		$builder->select("t0.nidreservadetalleticketbus idreservadetalleticketbus, t0.sdescripcion descripcion, DATE_FORMAT(t0.tfecha,'%d/%m/%Y') fecha, t0.ncantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado, t1.nidreserva idreserva, t1.sreservanombre reservanombre, t2.nidticketbus idticketbus, t2.snombre nombre, CONCAT('[',t0.dprecio,']',' - ','[',t2.dprecio,']',' - ',t1.sreservanombre,' - ',t2.snombre) concatenado, CONCAT(t1.sreservanombre,' - ',t2.snombre) concatenadodetalle");

		$builder->join('treserva t1', 't1.nidreserva = t0.nidreserva');
		$builder->join('tticketbus t2', 't2.nidticketbus = t0.nidticketbus');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidreservadetalleticketbus', $text)
				->orLike('t0.dprecio', $text)
				->orLike('t2.dprecio', $text)
				->orLike('t1.sreservanombre', $text)
				->orLike('t2.snombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidreservadetalleticketbus', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== AUTOCOMPLETE ======
	public function getAutocompleteReservadetallebuss($todos = 1, $text = ''){
		$builder = $this->conexion('treservadetallebus t0');

		$builder->select("t0.nidreservadetalleticketbus idreservadetalleticketbus, t0.sdescripcion descripcion, DATE_FORMAT(t0.tfecha,'%d/%m/%Y') fecha, t0.ncantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado, t1.nidreserva idreserva, t1.sreservanombre reservanombre, t2.nidticketbus idticketbus, t2.snombre nombre, CONCAT('[',t0.dprecio,']',' - ','[',t2.dprecio,']',' - ',t1.sreservanombre,' - ',t2.snombre) concatenado, CONCAT(t1.sreservanombre,' - ',t2.snombre) concatenadodetalle");
		$builder->join('treserva t1', 't1.nidreserva = t0.nidreserva');
		$builder->join('tticketbus t2', 't2.nidticketbus = t0.nidticketbus');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidreservadetalleticketbus', $text)
				->orLike('t0.dprecio', $text)
				->orLike('t2.dprecio', $text)
				->orLike('t1.sreservanombre', $text)
				->orLike('t2.snombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidreservadetalleticketbus', 'DESC');
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== GET ======
	public function getreservadetallebus($nidreserva, $nidreservadetalleticketbus, $nidticketbus){
		$builder = $this->conexion('treservadetallebus t0');
		$builder->select("t0.nidreserva idreserva, t0.nidreservadetalleticketbus idreservadetalleticketbus, t0.nidticketbus idticketbus, t0.sdescripcion descripcion, DATE_FORMAT(t0.tfecha,'%d/%m/%Y') fecha, t0.ncantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado");
		$builder->where(['nidreserva' => $nidreserva, 'nidreservadetalleticketbus' => $nidreservadetalleticketbus, 'nidticketbus' => $nidticketbus]);
		$query = $builder->get();
		return $query->getRowArray();
	}

//   SECCION ====== GET 2 ======
	public function getReservadetallebus2($id){
		$builder = $this->conexion('treservadetallebus t0');
		$builder->select("t0.nidreserva idreserva, t0.nidreservadetalleticketbus idreservadetalleticketbus, t0.nidticketbus idticketbus, t0.sdescripcion descripcion, DATE_FORMAT(t0.tfecha,'%d/%m/%Y') fecha, t0.ncantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado");
		$builder->join('treserva t1', 't1.nidreserva = t0.nidreserva');
		$builder->join('tticketbus t2', 't2.nidticketbus = t0.nidticketbus');
		$builder->where('t0.nidreservadetalleticketbus', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}
//   SECCION ====== COUNT ======
	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('treservadetallebus t0');
		$builder->select('nidreservadetalleticketbus');
		$builder->join('treserva t1', 't1.nidreserva = t0.nidreserva');
		$builder->join('tticketbus t2', 't2.nidticketbus = t0.nidticketbus');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidreservadetalleticketbus', $text)
				->orLike('t0.dprecio', $text)
				->orLike('t2.dprecio', $text)
				->orLike('t1.sreservanombre', $text)
				->orLike('t2.snombre', $text)
				->groupEnd();
		}

		return $builder->countAllResults();
	}

//   SECCION ====== UPDATE ======
	public function UpdateReservadetallebus($nidreserva, $nidreservadetalleticketbus, $nidticketbus,  $datos){
		$builder = $this->conexion('treservadetallebus');
		$builder->where(['nidreserva' => $nidreserva, 'nidreservadetalleticketbus' => $nidreservadetalleticketbus, 'nidticketbus' => $nidticketbus]);
		$builder->set($datos);
		$builder->update();
	}

//   SECCION ====== MAXIMO ID ======
	public function getMaxid(){
		$builder = $this->conexion('treservadetallebus');
		$builder->selectMax('nidreservadetalleticketbus');
		$query = $builder->get();
		return  $query->getResult()[0]->nidreservadetalleticketbus;
	}
}
?>
