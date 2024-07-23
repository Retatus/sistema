<?php

namespace App\Models;
use CodeIgniter\Model; 

class ReservadetallehorariotrenModel extends Model
{
	protected $table      = 'treservadetallehorariotren';
	protected $primaryKey = 'nidreservadetallehorariotren';
	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['nidreserva', 'nidreservadetallehorariotren', 'nidhorariotren', 'sdescripcion', 'tfecha', 'ncantidad', 'dprecio', 'dtotal', 'bconfirmado', 'bestado'];
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
	public function existe($nidreserva, $nidreservadetallehorariotren, $nidhorariotren){
		return $this->where(['nidreserva' => $nidreserva, 'nidreservadetallehorariotren' => $nidreservadetallehorariotren, 'nidhorariotren' => $nidhorariotren])->countAllResults();
	}

//   SECCION ====== TODOS ======
	public function getReservadetallehorariotrens($total, $pag = 1, $todos = 1, $text = ''){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;

		$builder = $this->conexion('treservadetallehorariotren t0');

		$builder->select("t0.nidreservadetallehorariotren idreservadetallehorariotren, t0.sdescripcion descripcion, DATE_FORMAT(t0.tfecha,'%d/%m/%Y') fecha, t0.ncantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado, t1.nidhorariotren idhorariotren, t2.nidhorario idhorario, t2.snombre nombre, t3.nidtren idtren, t3.snombre nombre, t4.nidreserva idreserva, t4.sreservanombre reservanombre, CONCAT('[',t0.dprecio,']',' - ','[',t1.dprecio,']',' - ',t2.snombre,' - ',t3.snombre,' - ',t4.sreservanombre) concatenado, CONCAT(t2.snombre,' - ',t3.snombre,' - ',t4.sreservanombre) concatenadodetalle");

		$builder->join('thorariotren t1', 't1.nidhorariotren = t0.nidhorariotren');
		$builder->join('thoratren t2', 't2.nidhorario = t1.nidhorario');
		$builder->join('ttren t3', 't3.nidtren = t1.nidtren');
		$builder->join('treserva t4', 't4.nidreserva = t0.nidreserva');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidreservadetallehorariotren', $text)
				->orLike('t0.dprecio', $text)
				->orLike('t1.dprecio', $text)
				->orLike('t2.snombre', $text)
				->orLike('t3.snombre', $text)
				->orLike('t4.sreservanombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidreservadetallehorariotren', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== AUTOCOMPLETE ======
	public function getAutocompleteReservadetallehorariotrens($todos = 1, $text = ''){
		$builder = $this->conexion('treservadetallehorariotren t0');

		$builder->select("t0.nidreservadetallehorariotren idreservadetallehorariotren, t0.sdescripcion descripcion, DATE_FORMAT(t0.tfecha,'%d/%m/%Y') fecha, t0.ncantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado, t1.nidhorariotren idhorariotren, t2.nidhorario idhorario, t2.snombre nombre, t3.nidtren idtren, t3.snombre nombre, t4.nidreserva idreserva, t4.sreservanombre reservanombre, CONCAT('[',t0.dprecio,']',' - ','[',t1.dprecio,']',' - ',t2.snombre,' - ',t3.snombre,' - ',t4.sreservanombre) concatenado, CONCAT(t2.snombre,' - ',t3.snombre,' - ',t4.sreservanombre) concatenadodetalle");
		$builder->join('thorariotren t1', 't1.nidhorariotren = t0.nidhorariotren');
		$builder->join('thoratren t2', 't2.nidhorario = t1.nidhorario');
		$builder->join('ttren t3', 't3.nidtren = t1.nidtren');
		$builder->join('treserva t4', 't4.nidreserva = t0.nidreserva');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidreservadetallehorariotren', $text)
				->orLike('t0.dprecio', $text)
				->orLike('t1.dprecio', $text)
				->orLike('t2.snombre', $text)
				->orLike('t3.snombre', $text)
				->orLike('t4.sreservanombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidreservadetallehorariotren', 'DESC');
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== GET ======
	public function getreservadetallehorariotren($nidreserva, $nidreservadetallehorariotren, $nidhorariotren){
		$builder = $this->conexion('treservadetallehorariotren t0');
		$builder->select("t0.nidreserva idreserva, t0.nidreservadetallehorariotren idreservadetallehorariotren, t0.nidhorariotren idhorariotren, t0.sdescripcion descripcion, DATE_FORMAT(t0.tfecha,'%d/%m/%Y') fecha, t0.ncantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado");
		$builder->where(['nidreserva' => $nidreserva, 'nidreservadetallehorariotren' => $nidreservadetallehorariotren, 'nidhorariotren' => $nidhorariotren]);
		$query = $builder->get();
		return $query->getRowArray();
	}

//   SECCION ====== GET 2 ======
	public function getReservadetallehorariotren2($id){
		$builder = $this->conexion('treservadetallehorariotren t0');
		$builder->select("t0.nidreserva idreserva, t0.nidreservadetallehorariotren idreservadetallehorariotren, t0.nidhorariotren idhorariotren, t0.sdescripcion descripcion, DATE_FORMAT(t0.tfecha,'%d/%m/%Y') fecha, t0.ncantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado");
		$builder->join('thorariotren t1', 't1.nidhorariotren = t0.nidhorariotren');
		$builder->join('thoratren t2', 't2.nidhorario = t1.nidhorario');
		$builder->join('ttren t3', 't3.nidtren = t1.nidtren');
		$builder->join('treserva t4', 't4.nidreserva = t0.nidreserva');
		$builder->where('t0.nidreservadetallehorariotren', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}
//   SECCION ====== COUNT ======
	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('treservadetallehorariotren t0');
		$builder->select('nidreservadetallehorariotren');
		$builder->join('thorariotren t1', 't1.nidhorariotren = t0.nidhorariotren');
		$builder->join('thoratren t2', 't2.nidhorario = t1.nidhorario');
		$builder->join('ttren t3', 't3.nidtren = t1.nidtren');
		$builder->join('treserva t4', 't4.nidreserva = t0.nidreserva');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidreservadetallehorariotren', $text)
				->orLike('t0.dprecio', $text)
				->orLike('t1.dprecio', $text)
				->orLike('t2.snombre', $text)
				->orLike('t3.snombre', $text)
				->orLike('t4.sreservanombre', $text)
				->groupEnd();
		}

		return $builder->countAllResults();
	}

//   SECCION ====== UPDATE ======
	public function UpdateReservadetallehorariotren($nidreserva, $nidreservadetallehorariotren, $nidhorariotren,  $datos){
		$builder = $this->conexion('treservadetallehorariotren');
		$builder->where(['nidreserva' => $nidreserva, 'nidreservadetallehorariotren' => $nidreservadetallehorariotren, 'nidhorariotren' => $nidhorariotren]);
		$builder->set($datos);
		$builder->update();
	}

//   SECCION ====== MAXIMO ID ======
	public function getMaxid(){
		$builder = $this->conexion('treservadetallehorariotren');
		$builder->selectMax('nidreservadetallehorariotren');
		$query = $builder->get();
		return  $query->getResult()[0]->nidreservadetallehorariotren;
	}
}
?>
