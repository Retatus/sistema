<?php

namespace App\Models;
use CodeIgniter\Model; 

class HorariotrenModel extends Model
{
	protected $table      = 'thorariotren';
	protected $primaryKey = 'nidhorariotren';
	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['nidhorariotren', 'nidtren', 'nidhorario', 'dprecio', 'bestado'];
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
	public function existe($nidhorariotren, $nidtren, $nidhorario){
		return $this->where(['nidhorariotren' => $nidhorariotren, 'nidtren' => $nidtren, 'nidhorario' => $nidhorario])->countAllResults();
	}

//   SECCION ====== TODOS ======
	public function getHorariotrens($total, $pag = 1, $todos = 1, $text = ''){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;

		$builder = $this->conexion('thorariotren t0');

		$builder->select("t0.nidhorariotren idhorariotren, t0.dprecio precio, t0.bestado estado, t1.nidhorario idhorario, t1.snombre nombre, t2.nidtren idtren, t2.snombre nombre, CONCAT('[',t0.dprecio,']',' - ',t1.snombre,' - ',t2.snombre) concatenado, CONCAT(t1.snombre,' - ',t2.snombre) concatenadodetalle");

		$builder->join('thoratren t1', 't1.nidhorario = t0.nidhorario');
		$builder->join('ttren t2', 't2.nidtren = t0.nidtren');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidhorariotren', $text)
				->orLike('t0.dprecio', $text)
				->orLike('t1.snombre', $text)
				->orLike('t2.snombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidhorariotren', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== AUTOCOMPLETE ======
	public function getAutocompleteHorariotrens($todos = 1, $text = ''){
		$builder = $this->conexion('thorariotren t0');

		$builder->select("t0.nidhorariotren idhorariotren, t0.dprecio precio, t0.bestado estado, t1.nidhorario idhorario, t1.snombre nombre, t2.nidtren idtren, t2.snombre nombre, CONCAT('[',t0.dprecio,']',' - ',t1.snombre,' - ',t2.snombre) concatenado, CONCAT(t1.snombre,' - ',t2.snombre) concatenadodetalle");
		$builder->join('thoratren t1', 't1.nidhorario = t0.nidhorario');
		$builder->join('ttren t2', 't2.nidtren = t0.nidtren');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidhorariotren', $text)
				->orLike('t0.dprecio', $text)
				->orLike('t1.snombre', $text)
				->orLike('t2.snombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.nidhorariotren', 'DESC');
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== GET ======
	public function gethorariotren($nidhorariotren, $nidtren, $nidhorario){
		$builder = $this->conexion('thorariotren t0');
		$builder->select("t0.nidhorariotren idhorariotren, t0.nidtren idtren, t0.nidhorario idhorario, t0.dprecio precio, t0.bestado estado");
		$builder->where(['nidhorariotren' => $nidhorariotren, 'nidtren' => $nidtren, 'nidhorario' => $nidhorario]);
		$query = $builder->get();
		return $query->getRowArray();
	}

//   SECCION ====== GET 2 ======
	public function getHorariotren2($id){
		$builder = $this->conexion('thorariotren t0');
		$builder->select("t0.nidhorariotren idhorariotren, t0.nidtren idtren, t0.nidhorario idhorario, t0.dprecio precio, t0.bestado estado");
		$builder->join('thoratren t1', 't1.nidhorario = t0.nidhorario');
		$builder->join('ttren t2', 't2.nidtren = t0.nidtren');
		$builder->where('t0.nidhorariotren', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}
//   SECCION ====== COUNT ======
	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('thorariotren t0');
		$builder->select('nidhorariotren');
		$builder->join('thoratren t1', 't1.nidhorario = t0.nidhorario');
		$builder->join('ttren t2', 't2.nidtren = t0.nidtren');

		if ($todos !== '') {
			$builder->where('t0.bestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.nidhorariotren', $text)
				->orLike('t0.dprecio', $text)
				->orLike('t1.snombre', $text)
				->orLike('t2.snombre', $text)
				->groupEnd();
		}

		return $builder->countAllResults();
	}

//   SECCION ====== UPDATE ======
	public function UpdateHorariotren($nidhorariotren, $nidtren, $nidhorario,  $datos){
		$builder = $this->conexion('thorariotren');
		$builder->where(['nidhorariotren' => $nidhorariotren, 'nidtren' => $nidtren, 'nidhorario' => $nidhorario]);
		$builder->set($datos);
		$builder->update();
	}

//   SECCION ====== MAXIMO ID ======
	public function getMaxid(){
		$builder = $this->conexion('thorariotren');
		$builder->selectMax('nidhorariotren');
		$query = $builder->get();
		return  $query->getResult()[0]->nidhorariotren;
	}
}
?>
