<?php

namespace App\Models;
use CodeIgniter\Model; 

class HoratrenModel extends Model
{
	protected $table      = 'thoratren';
	protected $primaryKey = 'nidhorario';
	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['nidhorario', 'snombre', 'sdescripcion', 'bida', 'bestado'];
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
	public function existe($nidhorario){
		return $this->where(['nidhorario' => $nidhorario])->countAllResults();
	}

//   SECCION ====== TODOS ======
	public function getHoratrens($total, $pag = 1, $todos = 1, $text = ''){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;

		$builder = $this->conexion('thoratren t0');

		$builder->select("t0.nidhorario idhorario, t0.snombre nombre, t0.sdescripcion descripcion, t0.bida ida, t0.bestado estado, CONCAT(t0.snombre) concatenado, CONCAT(t0.snombre) concatenadodetalle");


		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidhorario', $text)
				->orLike('t0.snombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidhorario', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== AUTOCOMPLETE ======
	public function getAutocompleteHoratrens($todos = 1, $text = ''){
		$builder = $this->conexion('thoratren t0');

		$builder->select("t0.nidhorario idhorario, t0.snombre nombre, t0.sdescripcion descripcion, t0.bida ida, t0.bestado estado, CONCAT(t0.snombre) concatenado, CONCAT(t0.snombre) concatenadodetalle");

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidhorario', $text)
				->orLike('t0.snombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidhorario', 'DESC');
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== GET ======
	public function gethoratren($nidhorario){
		$builder = $this->conexion('thoratren t0');
		$builder->select("t0.nidhorario idhorario, t0.snombre nombre, t0.sdescripcion descripcion, t0.bida ida, t0.bestado estado");
		$builder->where(['nidhorario' => $nidhorario]);
		$query = $builder->get();
		return $query->getRowArray();
	}

//   SECCION ====== GET 2 ======
	public function getHoratren2($id){
		$builder = $this->conexion('thoratren t0');
		$builder->select("t0.nidhorario idhorario, t0.snombre nombre, t0.sdescripcion descripcion, t0.bida ida, t0.bestado estado");
		$builder->where('t0.nidhorario', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}
//   SECCION ====== COUNT ======
	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('thoratren t0');
		$builder->select('nidhorario');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidhorario', $text)
				->orLike('t0.snombre', $text)
				->groupEnd();
		}

		return $builder->countAllResults();
	}

//   SECCION ====== UPDATE ======
	public function UpdateHoratren($nidhorario,  $datos){
		$builder = $this->conexion('thoratren');
		$builder->where(['nidhorario' => $nidhorario]);
		$builder->set($datos);
		$builder->update();
	}

//   SECCION ====== MAXIMO ID ======
	public function getMaxid(){
		$builder = $this->conexion('thoratren');
		$builder->selectMax('nidhorario');
		$query = $builder->get();
		return  $query->getResult()[0]->nidhorario;
	}
}
?>
