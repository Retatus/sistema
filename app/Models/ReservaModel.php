<?php

namespace App\Models;
use CodeIgniter\Model; 

class ReservaModel extends Model
{
	protected $table      = 'treserva';
	protected $primaryKey = 'nidreserva';
	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['nidreserva', 'sreservanombre', 'tfechainicio', 'tfechafin', 'ntipodoc', 'sidpersona', 'sreservatelefono', 'sreservacorreo', 'dmontototal', 'bpagado', 'bestado'];
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
	public function existe($nidreserva){
		return $this->where(['nidreserva' => $nidreserva])->countAllResults();
	}

//   SECCION ====== TODOS ======
	public function getReservas($total, $pag = 1, $todos = 1, $text = ''){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;

		$builder = $this->conexion('treserva t0');

		$builder->select("t0.nidreserva idreserva, t0.sreservanombre reservanombre, DATE_FORMAT(t0.tfechainicio,'%d/%m/%Y') fechainicio, DATE_FORMAT(t0.tfechafin,'%d/%m/%Y') fechafin, t0.ntipodoc tipodoc, t0.sidpersona idpersona, t0.sreservatelefono reservatelefono, t0.sreservacorreo reservacorreo, t0.dmontototal montototal, t0.bpagado pagado, t0.bestado estado, CONCAT(t0.sreservanombre) concatenado, CONCAT(t0.sreservanombre) concatenadodetalle");


		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidreserva', $text)
				->orLike('t0.sreservanombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidreserva', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== AUTOCOMPLETE ======
	public function getAutocompleteReservas($todos = 1, $text = ''){
		$builder = $this->conexion('treserva t0');

		$builder->select("t0.nidreserva idreserva, t0.sreservanombre reservanombre, DATE_FORMAT(t0.tfechainicio,'%d/%m/%Y') fechainicio, DATE_FORMAT(t0.tfechafin,'%d/%m/%Y') fechafin, t0.ntipodoc tipodoc, t0.sidpersona idpersona, t0.sreservatelefono reservatelefono, t0.sreservacorreo reservacorreo, t0.dmontototal montototal, t0.bpagado pagado, t0.bestado estado, CONCAT(t0.sreservanombre) concatenado, CONCAT(t0.sreservanombre) concatenadodetalle");

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidreserva', $text)
				->orLike('t0.sreservanombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidreserva', 'DESC');
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== GET ======
	public function getreserva($nidreserva){
		$builder = $this->conexion('treserva t0');
		$builder->select("t0.nidreserva idreserva, t0.sreservanombre reservanombre, DATE_FORMAT(t0.tfechainicio,'%d/%m/%Y') fechainicio, DATE_FORMAT(t0.tfechafin,'%d/%m/%Y') fechafin, t0.ntipodoc tipodoc, t0.sidpersona idpersona, t0.sreservatelefono reservatelefono, t0.sreservacorreo reservacorreo, t0.dmontototal montototal, t0.bpagado pagado, t0.bestado estado");
		$builder->where(['nidreserva' => $nidreserva]);
		$query = $builder->get();
		return $query->getRowArray();
	}

//   SECCION ====== GET 2 ======
	public function getReserva2($id){
		$builder = $this->conexion('treserva t0');
		$builder->select("t0.nidreserva idreserva, t0.sreservanombre reservanombre, DATE_FORMAT(t0.tfechainicio,'%d/%m/%Y') fechainicio, DATE_FORMAT(t0.tfechafin,'%d/%m/%Y') fechafin, t0.ntipodoc tipodoc, t0.sidpersona idpersona, t0.sreservatelefono reservatelefono, t0.sreservacorreo reservacorreo, t0.dmontototal montototal, t0.bpagado pagado, t0.bestado estado");
		$builder->where('t0.nidreserva', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}
//   SECCION ====== COUNT ======
	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('treserva t0');
		$builder->select('nidreserva');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidreserva', $text)
				->orLike('t0.sreservanombre', $text)
				->groupEnd();
		}

		return $builder->countAllResults();
	}

//   SECCION ====== UPDATE ======
	public function UpdateReserva($nidreserva,  $datos){
		$builder = $this->conexion('treserva');
		$builder->where(['nidreserva' => $nidreserva]);
		$builder->set($datos);
		$builder->update();
	}

//   SECCION ====== MAXIMO ID ======
	public function getMaxid(){
		$builder = $this->conexion('treserva');
		$builder->selectMax('nidreserva');
		$query = $builder->get();
		return  $query->getResult()[0]->nidreserva;
	}
}
?>
