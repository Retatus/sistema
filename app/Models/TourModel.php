<?php

namespace App\Models;
use CodeIgniter\Model; 

class TourModel extends Model
{
	protected $table      = 'ttour';
	protected $primaryKey = 'sidtour';
	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['sidtour', 'stournombre', 'stourdescripcion', 'dtourprecio', 'scolor', 'stourdiashabiles', 'btourestado', 'nidcattour'];
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
	public function existe($sidtour, $nidcattour){
		return $this->where(['sidtour' => $sidtour, 'nidcattour' => $nidcattour])->countAllResults();
	}

//   SECCION ====== TODOS ======
	public function getTours($total, $pag = 1, $todos = 1, $text = ''){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;

		$builder = $this->conexion('ttour t0');

		$builder->select("t0.sidtour idtour, t0.stournombre tournombre, t0.stourdescripcion tourdescripcion, t0.dtourprecio tourprecio, t0.scolor color, t0.stourdiashabiles tourdiashabiles, t0.btourestado tourestado, t1.nidcattour idcattour, t1.snombre nombre, CONCAT('[',t0.dtourprecio,']',' - ',t0.stournombre,' - ',t1.snombre) concatenado, CONCAT(t0.stournombre,' - ',t1.snombre) concatenadodetalle");

		$builder->join('tcattour t1', 't1.nidcattour = t0.nidcattour');

		if ($todos !== '') {
			$builder->where('t0.btourestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.sidtour', $text)
				->orLike('t0.dtourprecio', $text)
				->orLike('t0.stournombre', $text)
				->orLike('t1.snombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.sidtour', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== AUTOCOMPLETE ======
	public function getAutocompleteTours($todos = 1, $text = ''){
		$builder = $this->conexion('ttour t0');

		$builder->select("t0.sidtour idtour, t0.stournombre tournombre, t0.stourdescripcion tourdescripcion, t0.dtourprecio tourprecio, t0.scolor color, t0.stourdiashabiles tourdiashabiles, t0.btourestado tourestado, t1.nidcattour idcattour, t1.snombre nombre, CONCAT('[',t0.dtourprecio,']',' - ',t0.stournombre,' - ',t1.snombre) concatenado, CONCAT(t0.stournombre,' - ',t1.snombre) concatenadodetalle");
		$builder->join('tcattour t1', 't1.nidcattour = t0.nidcattour');

		if ($todos !== '') {
			$builder->where('t0.btourestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.sidtour', $text)
				->orLike('t0.dtourprecio', $text)
				->orLike('t0.stournombre', $text)
				->orLike('t1.snombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.sidtour', 'DESC');
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== GET ======
	public function gettour($sidtour, $nidcattour){
		$builder = $this->conexion('ttour t0');
		$builder->select("t0.sidtour idtour, t0.stournombre tournombre, t0.stourdescripcion tourdescripcion, t0.dtourprecio tourprecio, t0.scolor color, t0.stourdiashabiles tourdiashabiles, t0.btourestado tourestado, t0.nidcattour idcattour");
		$builder->where(['sidtour' => $sidtour, 'nidcattour' => $nidcattour]);
		$query = $builder->get();
		return $query->getRowArray();
	}

//   SECCION ====== GET 2 ======
	public function getTour2($id){
		$builder = $this->conexion('ttour t0');
		$builder->select("t0.sidtour idtour, t0.stournombre tournombre, t0.stourdescripcion tourdescripcion, t0.dtourprecio tourprecio, t0.scolor color, t0.stourdiashabiles tourdiashabiles, t0.btourestado tourestado, t0.nidcattour idcattour");
		$builder->join('tcattour t1', 't1.nidcattour = t0.nidcattour');
		$builder->where('t0.sidtour', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}
//   SECCION ====== COUNT ======
	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('ttour t0');
		$builder->select('sidtour');
		$builder->join('tcattour t1', 't1.nidcattour = t0.nidcattour');

		if ($todos !== '') {
			$builder->where('t0.btourestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.sidtour', $text)
				->orLike('t0.dtourprecio', $text)
				->orLike('t0.stournombre', $text)
				->orLike('t1.snombre', $text)
				->groupEnd();
		}

		return $builder->countAllResults();
	}

//   SECCION ====== UPDATE ======
	public function UpdateTour($sidtour, $nidcattour,  $datos){
		$builder = $this->conexion('ttour');
		$builder->where(['sidtour' => $sidtour, 'nidcattour' => $nidcattour]);
		$builder->set($datos);
		$builder->update();
	}

//   SECCION ====== MAXIMO ID ======
	public function getMaxid(){
		$builder = $this->conexion('ttour');
		$builder->selectMax('sidtour');
		$query = $builder->get();
		return  $query->getResult()[0]->sidtour;
	}
}
?>
