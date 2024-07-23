<?php

namespace App\Models;
use CodeIgniter\Model; 

class ReservadetallehorarioticketmapiModel extends Model
{
	protected $table      = 'treservadetallehorarioticketmapi';
	protected $primaryKey = 'nidreservadetallehorarioticketmapi';
	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['nidreservadetallehorarioticketmapi', 'nidreserva', 'tfecha', 'sdescripcion', 'ncantidad', 'dprecio', 'dtotal', 'nidhorarioticketmapi', 'bconfirmado', 'bestado'];
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
	public function existe($nidreservadetallehorarioticketmapi, $nidreserva, $nidhorarioticketmapi){
		return $this->where(['nidreservadetallehorarioticketmapi' => $nidreservadetallehorarioticketmapi, 'nidreserva' => $nidreserva, 'nidhorarioticketmapi' => $nidhorarioticketmapi])->countAllResults();
	}

//   SECCION ====== TODOS ======
	public function getReservadetallehorarioticketmapis($total, $pag = 1, $todos = 1, $text = ''){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;

		$builder = $this->conexion('treservadetallehorarioticketmapi t0');

		$builder->select("t0.nidreservadetallehorarioticketmapi idreservadetallehorarioticketmapi, DATE_FORMAT(t0.tfecha,'%d/%m/%Y') fecha, t0.sdescripcion descripcion, t0.ncantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado, t1.nidhorarioticketmapi idhorarioticketmapi, t2.nidclientetipo idclientetipo, t2.snombre nombre, t3.nidhoraticketmapi idhoraticketmapi, t3.snombre nombre, t4.nidticketmapi idticketmapi, t4.snombre nombre, t5.nidreserva idreserva, t5.sreservanombre reservanombre, CONCAT('[',t0.dprecio,']',' - ','[',t1.dprecio,']',' - ',t2.snombre,' - ',t3.snombre,' - ',t4.snombre,' - ',t5.sreservanombre) concatenado, CONCAT(t2.snombre,' - ',t3.snombre,' - ',t4.snombre,' - ',t5.sreservanombre) concatenadodetalle");

		$builder->join('thorarioticketmapi t1', 't1.nidhorarioticketmapi = t0.nidhorarioticketmapi');
		$builder->join('tclientetipo t2', 't2.nidclientetipo = t1.nidclientetipo');
		$builder->join('thoraticketmapi t3', 't3.nidhoraticketmapi = t1.nidhoraticketmapi');
		$builder->join('tticketmapi t4', 't4.nidticketmapi = t1.nidticketmapi');
		$builder->join('treserva t5', 't5.nidreserva = t0.nidreserva');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidreservadetallehorarioticketmapi', $text)
				->orLike('t0.dprecio', $text)
				->orLike('t1.dprecio', $text)
				->orLike('t2.snombre', $text)
				->orLike('t3.snombre', $text)
				->orLike('t4.snombre', $text)
				->orLike('t5.sreservanombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidreservadetallehorarioticketmapi', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== AUTOCOMPLETE ======
	public function getAutocompleteReservadetallehorarioticketmapis($todos = 1, $text = ''){
		$builder = $this->conexion('treservadetallehorarioticketmapi t0');

		$builder->select("t0.nidreservadetallehorarioticketmapi idreservadetallehorarioticketmapi, DATE_FORMAT(t0.tfecha,'%d/%m/%Y') fecha, t0.sdescripcion descripcion, t0.ncantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado, t1.nidhorarioticketmapi idhorarioticketmapi, t2.nidclientetipo idclientetipo, t2.snombre nombre, t3.nidhoraticketmapi idhoraticketmapi, t3.snombre nombre, t4.nidticketmapi idticketmapi, t4.snombre nombre, t5.nidreserva idreserva, t5.sreservanombre reservanombre, CONCAT('[',t0.dprecio,']',' - ','[',t1.dprecio,']',' - ',t2.snombre,' - ',t3.snombre,' - ',t4.snombre,' - ',t5.sreservanombre) concatenado, CONCAT(t2.snombre,' - ',t3.snombre,' - ',t4.snombre,' - ',t5.sreservanombre) concatenadodetalle");
		$builder->join('thorarioticketmapi t1', 't1.nidhorarioticketmapi = t0.nidhorarioticketmapi');
		$builder->join('tclientetipo t2', 't2.nidclientetipo = t1.nidclientetipo');
		$builder->join('thoraticketmapi t3', 't3.nidhoraticketmapi = t1.nidhoraticketmapi');
		$builder->join('tticketmapi t4', 't4.nidticketmapi = t1.nidticketmapi');
		$builder->join('treserva t5', 't5.nidreserva = t0.nidreserva');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidreservadetallehorarioticketmapi', $text)
				->orLike('t0.dprecio', $text)
				->orLike('t1.dprecio', $text)
				->orLike('t2.snombre', $text)
				->orLike('t3.snombre', $text)
				->orLike('t4.snombre', $text)
				->orLike('t5.sreservanombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidreservadetallehorarioticketmapi', 'DESC');
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== GET ======
	public function getreservadetallehorarioticketmapi($nidreservadetallehorarioticketmapi, $nidreserva, $nidhorarioticketmapi){
		$builder = $this->conexion('treservadetallehorarioticketmapi t0');
		$builder->select("t0.nidreservadetallehorarioticketmapi idreservadetallehorarioticketmapi, t0.nidreserva idreserva, DATE_FORMAT(t0.tfecha,'%d/%m/%Y') fecha, t0.sdescripcion descripcion, t0.ncantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.nidhorarioticketmapi idhorarioticketmapi, t0.bconfirmado confirmado, t0.bestado estado");
		$builder->where(['nidreservadetallehorarioticketmapi' => $nidreservadetallehorarioticketmapi, 'nidreserva' => $nidreserva, 'nidhorarioticketmapi' => $nidhorarioticketmapi]);
		$query = $builder->get();
		return $query->getRowArray();
	}

//   SECCION ====== GET 2 ======
	public function getReservadetallehorarioticketmapi2($id){
		$builder = $this->conexion('treservadetallehorarioticketmapi t0');
		$builder->select("t0.nidreservadetallehorarioticketmapi idreservadetallehorarioticketmapi, t0.nidreserva idreserva, DATE_FORMAT(t0.tfecha,'%d/%m/%Y') fecha, t0.sdescripcion descripcion, t0.ncantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.nidhorarioticketmapi idhorarioticketmapi, t0.bconfirmado confirmado, t0.bestado estado");
		$builder->join('thorarioticketmapi t1', 't1.nidhorarioticketmapi = t0.nidhorarioticketmapi');
		$builder->join('tclientetipo t2', 't2.nidclientetipo = t1.nidclientetipo');
		$builder->join('thoraticketmapi t3', 't3.nidhoraticketmapi = t1.nidhoraticketmapi');
		$builder->join('tticketmapi t4', 't4.nidticketmapi = t1.nidticketmapi');
		$builder->join('treserva t5', 't5.nidreserva = t0.nidreserva');
		$builder->where('t0.nidreservadetallehorarioticketmapi', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}
//   SECCION ====== COUNT ======
	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('treservadetallehorarioticketmapi t0');
		$builder->select('nidreservadetallehorarioticketmapi');
		$builder->join('thorarioticketmapi t1', 't1.nidhorarioticketmapi = t0.nidhorarioticketmapi');
		$builder->join('tclientetipo t2', 't2.nidclientetipo = t1.nidclientetipo');
		$builder->join('thoraticketmapi t3', 't3.nidhoraticketmapi = t1.nidhoraticketmapi');
		$builder->join('tticketmapi t4', 't4.nidticketmapi = t1.nidticketmapi');
		$builder->join('treserva t5', 't5.nidreserva = t0.nidreserva');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidreservadetallehorarioticketmapi', $text)
				->orLike('t0.dprecio', $text)
				->orLike('t1.dprecio', $text)
				->orLike('t2.snombre', $text)
				->orLike('t3.snombre', $text)
				->orLike('t4.snombre', $text)
				->orLike('t5.sreservanombre', $text)
				->groupEnd();
		}

		return $builder->countAllResults();
	}

//   SECCION ====== UPDATE ======
	public function UpdateReservadetallehorarioticketmapi($nidreservadetallehorarioticketmapi, $nidreserva, $nidhorarioticketmapi,  $datos){
		$builder = $this->conexion('treservadetallehorarioticketmapi');
		$builder->where(['nidreservadetallehorarioticketmapi' => $nidreservadetallehorarioticketmapi, 'nidreserva' => $nidreserva, 'nidhorarioticketmapi' => $nidhorarioticketmapi]);
		$builder->set($datos);
		$builder->update();
	}

//   SECCION ====== MAXIMO ID ======
	public function getMaxid(){
		$builder = $this->conexion('treservadetallehorarioticketmapi');
		$builder->selectMax('nidreservadetallehorarioticketmapi');
		$query = $builder->get();
		return  $query->getResult()[0]->nidreservadetallehorarioticketmapi;
	}
}
?>
