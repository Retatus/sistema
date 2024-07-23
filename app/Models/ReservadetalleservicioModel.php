<?php

namespace App\Models;
use CodeIgniter\Model; 

class ReservadetalleservicioModel extends Model
{
	protected $table      = 'treservadetalleservicio';
	protected $primaryKey = 'nidreservadetalleservicio';
	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['nidreserva', 'nidreservadetalleservicio', 'sdescripcion', 'tfecha', 'dcantidad', 'dprecio', 'dtotal', 'bconfirmado', 'bestado'];
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
	public function existe($nidreservadetalleservicio){
		return $this->where(['nidreservadetalleservicio' => $nidreservadetalleservicio])->countAllResults();
	}

//   SECCION ====== TODOS ======
	public function getReservadetalleservicios($total, $pag = 1, $todos = 1, $text = ''){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;

		$builder = $this->conexion('treservadetalleservicio t0');

		$builder->select("t0.nidreserva idreserva, t0.nidreservadetalleservicio idreservadetalleservicio, t0.sdescripcion descripcion, DATE_FORMAT(t0.tfecha,'%d/%m/%Y') fecha, t0.dcantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado, CONCAT('[',t0.dprecio,']') concatenado");


		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidreservadetalleservicio', $text)
				->orLike('t0.dprecio', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidreservadetalleservicio', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== AUTOCOMPLETE ======
	public function getAutocompleteReservadetalleservicios($todos = 1, $text = ''){
		$builder = $this->conexion('treservadetalleservicio t0');

		$builder->select("t0.nidreserva idreserva, t0.nidreservadetalleservicio idreservadetalleservicio, t0.sdescripcion descripcion, DATE_FORMAT(t0.tfecha,'%d/%m/%Y') fecha, t0.dcantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado, CONCAT('[',t0.dprecio,']') concatenado");

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidreservadetalleservicio', $text)
				->orLike('t0.dprecio', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidreservadetalleservicio', 'DESC');
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== GET ======
	public function getreservadetalleservicio($nidreservadetalleservicio){
		$builder = $this->conexion('treservadetalleservicio t0');
		$builder->select("t0.nidreserva idreserva, t0.nidreservadetalleservicio idreservadetalleservicio, t0.sdescripcion descripcion, DATE_FORMAT(t0.tfecha,'%d/%m/%Y') fecha, t0.dcantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado");
		$builder->where(['nidreservadetalleservicio' => $nidreservadetalleservicio]);
		$query = $builder->get();
		return $query->getRowArray();
	}

//   SECCION ====== GET 2 ======
	public function getReservadetalleservicio2($id){
		$builder = $this->conexion('treservadetalleservicio t0');
		$builder->select("t0.nidreserva idreserva, t0.nidreservadetalleservicio idreservadetalleservicio, t0.sdescripcion descripcion, DATE_FORMAT(t0.tfecha,'%d/%m/%Y') fecha, t0.dcantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado");
		$builder->where('t0.nidreservadetalleservicio', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}
//   SECCION ====== COUNT ======
	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('treservadetalleservicio t0');
		$builder->select('nidreservadetalleservicio');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidreservadetalleservicio', $text)
				->orLike('t0.dprecio', $text)
				->groupEnd();
		}

		return $builder->countAllResults();
	}

//   SECCION ====== UPDATE ======
	public function UpdateReservadetalleservicio($nidreservadetalleservicio,  $datos){
		$builder = $this->conexion('treservadetalleservicio');
		$builder->where(['nidreservadetalleservicio' => $nidreservadetalleservicio]);
		$builder->set($datos);
		$builder->update();
	}

//   SECCION ====== MAXIMO ID ======
	public function getMaxid(){
		$builder = $this->conexion('treservadetalleservicio');
		$builder->selectMax('nidreservadetalleservicio');
		$query = $builder->get();
		return  $query->getResult()[0]->nidreservadetalleservicio;
	}
}
?>
