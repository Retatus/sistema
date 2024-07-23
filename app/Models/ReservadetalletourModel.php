<?php

namespace App\Models;
use CodeIgniter\Model; 

class ReservadetalletourModel extends Model
{
	protected $table      = 'treservadetalletour';
	protected $primaryKey = 'nidreservatour';
	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['nidreserva', 'nidreservatour', 'sidtour', 'sdescripcion', 'tfecha', 'ncantidad', 'dprecio', 'dtotal', 'bconfirmado', 'bestado'];
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
	public function existe($nidreserva, $nidreservatour, $sidtour){
		return $this->where(['nidreserva' => $nidreserva, 'nidreservatour' => $nidreservatour, 'sidtour' => $sidtour])->countAllResults();
	}

//   SECCION ====== TODOS ======
	public function getReservadetalletours($total, $pag = 1, $todos = 1, $text = ''){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;

		$builder = $this->conexion('treservadetalletour t0');

		$builder->select("t0.nidreservatour idreservatour, t0.sdescripcion descripcion, DATE_FORMAT(t0.tfecha,'%d/%m/%Y') fecha, t0.ncantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado, t1.nidreserva idreserva, t1.sreservanombre reservanombre, t2.sidtour idtour, t2.stournombre tournombre, t3.nidcattour idcattour, t3.snombre nombre, CONCAT('[',t0.dprecio,']',' - ','[',t2.dtourprecio,']',' - ',t1.sreservanombre,' - ',t2.stournombre,' - ',t3.snombre) concatenado, CONCAT(t1.sreservanombre,' - ',t2.stournombre,' - ',t3.snombre) concatenadodetalle");

		$builder->join('treserva t1', 't1.nidreserva = t0.nidreserva');
		$builder->join('ttour t2', 't2.sidtour = t0.sidtour');
		$builder->join('tcattour t3', 't3.nidcattour = t2.nidcattour');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidreservatour', $text)
				->orLike('t0.dprecio', $text)
				->orLike('t2.dtourprecio', $text)
				->orLike('t1.sreservanombre', $text)
				->orLike('t2.stournombre', $text)
				->orLike('t3.snombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidreservatour', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== AUTOCOMPLETE ======
	public function getAutocompleteReservadetalletours($todos = 1, $text = ''){
		$builder = $this->conexion('treservadetalletour t0');

		$builder->select("t0.nidreservatour idreservatour, t0.sdescripcion descripcion, DATE_FORMAT(t0.tfecha,'%d/%m/%Y') fecha, t0.ncantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado, t1.nidreserva idreserva, t1.sreservanombre reservanombre, t2.sidtour idtour, t2.stournombre tournombre, t3.nidcattour idcattour, t3.snombre nombre, CONCAT('[',t0.dprecio,']',' - ','[',t2.dtourprecio,']',' - ',t1.sreservanombre,' - ',t2.stournombre,' - ',t3.snombre) concatenado, CONCAT(t1.sreservanombre,' - ',t2.stournombre,' - ',t3.snombre) concatenadodetalle");
		$builder->join('treserva t1', 't1.nidreserva = t0.nidreserva');
		$builder->join('ttour t2', 't2.sidtour = t0.sidtour');
		$builder->join('tcattour t3', 't3.nidcattour = t2.nidcattour');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidreservatour', $text)
				->orLike('t0.dprecio', $text)
				->orLike('t2.dtourprecio', $text)
				->orLike('t1.sreservanombre', $text)
				->orLike('t2.stournombre', $text)
				->orLike('t3.snombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidreservatour', 'DESC');
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== GET ======
	public function getreservadetalletour($nidreserva, $nidreservatour, $sidtour){
		$builder = $this->conexion('treservadetalletour t0');
		$builder->select("t0.nidreserva idreserva, t0.nidreservatour idreservatour, t0.sidtour idtour, t0.sdescripcion descripcion, DATE_FORMAT(t0.tfecha,'%d/%m/%Y') fecha, t0.ncantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado");
		$builder->where(['nidreserva' => $nidreserva, 'nidreservatour' => $nidreservatour, 'sidtour' => $sidtour]);
		$query = $builder->get();
		return $query->getRowArray();
	}

//   SECCION ====== GET 2 ======
	public function getReservadetalletour2($id){
		$builder = $this->conexion('treservadetalletour t0');
		$builder->select("t0.nidreserva idreserva, t0.nidreservatour idreservatour, t0.sidtour idtour, t0.sdescripcion descripcion, DATE_FORMAT(t0.tfecha,'%d/%m/%Y') fecha, t0.ncantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado");
		$builder->join('treserva t1', 't1.nidreserva = t0.nidreserva');
		$builder->join('ttour t2', 't2.sidtour = t0.sidtour');
		$builder->join('tcattour t3', 't3.nidcattour = t2.nidcattour');
		$builder->where('t0.nidreservatour', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}
//   SECCION ====== COUNT ======
	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('treservadetalletour t0');
		$builder->select('nidreservatour');
		$builder->join('treserva t1', 't1.nidreserva = t0.nidreserva');
		$builder->join('ttour t2', 't2.sidtour = t0.sidtour');
		$builder->join('tcattour t3', 't3.nidcattour = t2.nidcattour');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidreservatour', $text)
				->orLike('t0.dprecio', $text)
				->orLike('t2.dtourprecio', $text)
				->orLike('t1.sreservanombre', $text)
				->orLike('t2.stournombre', $text)
				->orLike('t3.snombre', $text)
				->groupEnd();
		}

		return $builder->countAllResults();
	}

//   SECCION ====== UPDATE ======
	public function UpdateReservadetalletour($nidreserva, $nidreservatour, $sidtour,  $datos){
		$builder = $this->conexion('treservadetalletour');
		$builder->where(['nidreserva' => $nidreserva, 'nidreservatour' => $nidreservatour, 'sidtour' => $sidtour]);
		$builder->set($datos);
		$builder->update();
	}

//   SECCION ====== MAXIMO ID ======
	public function getMaxid(){
		$builder = $this->conexion('treservadetalletour');
		$builder->selectMax('nidreservatour');
		$query = $builder->get();
		return  $query->getResult()[0]->nidreservatour;
	}
}
?>
