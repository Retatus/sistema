<?php

namespace App\Models;
use CodeIgniter\Model; 

class OtroservicioModel extends Model
{
	protected $table      = 'totroservicio';
	protected $primaryKey = 'nidotroservicio';
	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['nidotroservicio', 'sotroservicionombre', 'dotroservicioprecio', 'botroservicioestado'];
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
	public function existe($nidotroservicio){
		return $this->where(['nidotroservicio' => $nidotroservicio])->countAllResults();
	}

//   SECCION ====== TODOS ======
	public function getOtroservicios($total, $pag = 1, $todos = 1, $text = ''){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;

		$builder = $this->conexion('totroservicio t0');

		$builder->select("t0.nidotroservicio idotroservicio, t0.sotroservicionombre otroservicionombre, t0.dotroservicioprecio otroservicioprecio, t0.botroservicioestado otroservicioestado, CONCAT('[',t0.dotroservicioprecio,']',' - ',t0.sotroservicionombre) concatenado, CONCAT(t0.sotroservicionombre) concatenadodetalle");


		if ($todos !== '') {
			$builder->where('t0.botroservicioestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidotroservicio', $text)
				->orLike('t0.dotroservicioprecio', $text)
				->orLike('t0.sotroservicionombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidotroservicio', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== AUTOCOMPLETE ======
	public function getAutocompleteOtroservicios($todos = 1, $text = ''){
		$builder = $this->conexion('totroservicio t0');

		$builder->select("t0.nidotroservicio idotroservicio, t0.sotroservicionombre otroservicionombre, t0.dotroservicioprecio otroservicioprecio, t0.botroservicioestado otroservicioestado, CONCAT('[',t0.dotroservicioprecio,']',' - ',t0.sotroservicionombre) concatenado, CONCAT(t0.sotroservicionombre) concatenadodetalle");

		if ($todos !== '') {
			$builder->where('t0.botroservicioestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidotroservicio', $text)
				->orLike('t0.dotroservicioprecio', $text)
				->orLike('t0.sotroservicionombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidotroservicio', 'DESC');
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== GET ======
	public function getotroservicio($nidotroservicio){
		$builder = $this->conexion('totroservicio t0');
		$builder->select("t0.nidotroservicio idotroservicio, t0.sotroservicionombre otroservicionombre, t0.dotroservicioprecio otroservicioprecio, t0.botroservicioestado otroservicioestado");
		$builder->where(['nidotroservicio' => $nidotroservicio]);
		$query = $builder->get();
		return $query->getRowArray();
	}

//   SECCION ====== GET 2 ======
	public function getOtroservicio2($id){
		$builder = $this->conexion('totroservicio t0');
		$builder->select("t0.nidotroservicio idotroservicio, t0.sotroservicionombre otroservicionombre, t0.dotroservicioprecio otroservicioprecio, t0.botroservicioestado otroservicioestado");
		$builder->where('t0.nidotroservicio', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}
//   SECCION ====== COUNT ======
	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('totroservicio t0');
		$builder->select('nidotroservicio');

		if ($todos !== '') {
			$builder->where('t0.botroservicioestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidotroservicio', $text)
				->orLike('t0.dotroservicioprecio', $text)
				->orLike('t0.sotroservicionombre', $text)
				->groupEnd();
		}

		return $builder->countAllResults();
	}

//   SECCION ====== UPDATE ======
	public function UpdateOtroservicio($nidotroservicio,  $datos){
		$builder = $this->conexion('totroservicio');
		$builder->where(['nidotroservicio' => $nidotroservicio]);
		$builder->set($datos);
		$builder->update();
	}

//   SECCION ====== MAXIMO ID ======
	public function getMaxid(){
		$builder = $this->conexion('totroservicio');
		$builder->selectMax('nidotroservicio');
		$query = $builder->get();
		return  $query->getResult()[0]->nidotroservicio;
	}
}
?>
