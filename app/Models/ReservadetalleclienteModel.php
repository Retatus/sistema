<?php

namespace App\Models;
use CodeIgniter\Model; 

class ReservadetalleclienteModel extends Model
{
	protected $table      = 'treservadetallecliente';
	protected $primaryKey = 'nidreservadetallecliente';
	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['nidreservadetallecliente', 'nidreserva', 'sidcliente', 'ncantidad', 'dprecio', 'dtotal', 'bconfirmado', 'bestado'];
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
	public function existe($nidreservadetallecliente, $nidreserva, $sidcliente){
		return $this->where(['nidreservadetallecliente' => $nidreservadetallecliente, 'nidreserva' => $nidreserva, 'sidcliente' => $sidcliente])->countAllResults();
	}

//   SECCION ====== TODOS ======
	public function getReservadetalleclientes($total, $pag = 1, $todos = 1, $text = ''){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;

		$builder = $this->conexion('treservadetallecliente t0');

		$builder->select("t0.nidreservadetallecliente idreservadetallecliente, t0.ncantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado, t1.nidreserva idreserva, t1.sreservanombre reservanombre, t2.sidcliente idcliente, t2.sclientenombre clientenombre, t3.nidtipodoc idtipodoc, t3.snombre nombre, CONCAT('[',t0.dprecio,']',' - ',t1.sreservanombre,' - ',t2.sclientenombre,' - ',t3.snombre) concatenado, CONCAT(t1.sreservanombre,' - ',t2.sclientenombre,' - ',t3.snombre) concatenadodetalle");

		$builder->join('treserva t1', 't1.nidreserva = t0.nidreserva');
		$builder->join('tcliente t2', 't2.sidcliente = t0.sidcliente');
		$builder->join('ttipodoc t3', 't3.nidtipodoc = t2.nidtipodoc');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidreservadetallecliente', $text)
				->orLike('t0.dprecio', $text)
				->orLike('t1.sreservanombre', $text)
				->orLike('t2.sclientenombre', $text)
				->orLike('t3.snombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidreservadetallecliente', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== AUTOCOMPLETE ======
	public function getAutocompleteReservadetalleclientes($todos = 1, $text = ''){
		$builder = $this->conexion('treservadetallecliente t0');

		$builder->select("t0.nidreservadetallecliente idreservadetallecliente, t0.ncantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado, t1.nidreserva idreserva, t1.sreservanombre reservanombre, t2.sidcliente idcliente, t2.sclientenombre clientenombre, t3.nidtipodoc idtipodoc, t3.snombre nombre, CONCAT('[',t0.dprecio,']',' - ',t1.sreservanombre,' - ',t2.sclientenombre,' - ',t3.snombre) concatenado, CONCAT(t1.sreservanombre,' - ',t2.sclientenombre,' - ',t3.snombre) concatenadodetalle");
		$builder->join('treserva t1', 't1.nidreserva = t0.nidreserva');
		$builder->join('tcliente t2', 't2.sidcliente = t0.sidcliente');
		$builder->join('ttipodoc t3', 't3.nidtipodoc = t2.nidtipodoc');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidreservadetallecliente', $text)
				->orLike('t0.dprecio', $text)
				->orLike('t1.sreservanombre', $text)
				->orLike('t2.sclientenombre', $text)
				->orLike('t3.snombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidreservadetallecliente', 'DESC');
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== GET ======
	public function getreservadetallecliente($nidreservadetallecliente, $nidreserva, $sidcliente){
		$builder = $this->conexion('treservadetallecliente t0');
		$builder->select("t0.nidreservadetallecliente idreservadetallecliente, t0.nidreserva idreserva, t0.sidcliente idcliente, t0.ncantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado");
		$builder->where(['nidreservadetallecliente' => $nidreservadetallecliente, 'nidreserva' => $nidreserva, 'sidcliente' => $sidcliente]);
		$query = $builder->get();
		return $query->getRowArray();
	}

//   SECCION ====== GET 2 ======
	public function getReservadetallecliente2($id){
		$builder = $this->conexion('treservadetallecliente t0');
		$builder->select("t0.nidreservadetallecliente idreservadetallecliente, t0.nidreserva idreserva, t0.sidcliente idcliente, t0.ncantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado");
		$builder->join('treserva t1', 't1.nidreserva = t0.nidreserva');
		$builder->join('tcliente t2', 't2.sidcliente = t0.sidcliente');
		$builder->join('ttipodoc t3', 't3.nidtipodoc = t2.nidtipodoc');
		$builder->where('t0.nidreservadetallecliente', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}
//   SECCION ====== COUNT ======
	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('treservadetallecliente t0');
		$builder->select('nidreservadetallecliente');
		$builder->join('treserva t1', 't1.nidreserva = t0.nidreserva');
		$builder->join('tcliente t2', 't2.sidcliente = t0.sidcliente');
		$builder->join('ttipodoc t3', 't3.nidtipodoc = t2.nidtipodoc');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidreservadetallecliente', $text)
				->orLike('t0.dprecio', $text)
				->orLike('t1.sreservanombre', $text)
				->orLike('t2.sclientenombre', $text)
				->orLike('t3.snombre', $text)
				->groupEnd();
		}

		return $builder->countAllResults();
	}

//   SECCION ====== UPDATE ======
	public function UpdateReservadetallecliente($nidreservadetallecliente, $nidreserva, $sidcliente,  $datos){
		$builder = $this->conexion('treservadetallecliente');
		$builder->where(['nidreservadetallecliente' => $nidreservadetallecliente, 'nidreserva' => $nidreserva, 'sidcliente' => $sidcliente]);
		$builder->set($datos);
		$builder->update();
	}

//   SECCION ====== MAXIMO ID ======
	public function getMaxid(){
		$builder = $this->conexion('treservadetallecliente');
		$builder->selectMax('nidreservadetallecliente');
		$query = $builder->get();
		return  $query->getResult()[0]->nidreservadetallecliente;
	}
}
?>
