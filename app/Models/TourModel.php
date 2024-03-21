<?php 

namespace App\Models;
use CodeIgniter\Model; 

class TourModel extends Model
{
	protected $table      = 'ttour';
	protected $primaryKey = 'sidtour';

	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['sidtour','stournombre','stourdescripcion','dtourprecio','scolor','stourdiashabiles','btourestado','nidcattour'];
	protected $useTimestamps = false;
	protected $createdField  = 'tfecha_alt';
	protected $updatedField  = 'tfecha_edi';
	protected $deletedField  = 'deleted_at';

	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = false;

	protected function conexion(string $table = null){
		$this->db = \Config\Database::connect();
		$this->builder = $this->db->table($table);
		return $this->builder;
	}

	public function existe($id){
		return $this->where(['sidtour' => $id])->countAllResults();
	}

	public function getTours($todos = 1, $text = '', $total, $pag = 1){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;
		$builder = $this->conexion('ttour t0');
		$builder->select("t0.sidtour idtour, t0.stournombre tournombre, t0.stourdescripcion tourdescripcion, t0.dtourprecio tourprecio, t0.scolor color, t0.stourdiashabiles tourdiashabiles, t0.btourestado tourestado, t0.nidcattour idcattour,  t1.nidcattour idcattour, t1.snombre nombre, CONCAT(t0.stournombre, ' - ', t1.snombre, ' - ', '[' ,t0.dtourprecio, ']' ) as concatenado, CONCAT(t0.stournombre, ' - ', t1.snombre) as concatenadodetalle");
		$builder->join('tcattour t1', ' t1.nidcattour = t0.nidcattour');

		if ($todos !== '') 
		$builder->where('t0.btourestado', intval($todos));

		$builder->like('t0.sidtour', $text);
		$builder->orLike('t0.stournombre', $text);
		$builder->orLike('t1.snombre', $text);
		$builder->orLike('t0.dtourprecio', $text);

		$builder->orderBy('t0.sidtour', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getAutocompletetours($todos = 1, $text = ''){
		$builder = $this->conexion('ttour t0');
		$builder->select("t0.sidtour idtour, t0.stournombre tournombre, t0.stourdescripcion tourdescripcion, t0.dtourprecio tourprecio, t0.scolor color, t0.stourdiashabiles tourdiashabiles, t0.btourestado tourestado, t0.nidcattour idcattour,  t1.nidcattour idcattour, t1.snombre nombre, CONCAT(t0.stournombre, ' - ', t1.snombre, ' - ', '[' ,t0.dtourprecio, ']' ) as concatenado, CONCAT(t0.stournombre, ' - ', t1.snombre) as concatenadodetalle");
		$builder->join('tcattour t1', ' t1.nidcattour = t0.nidcattour');

		if ($todos !== '') 
		$builder->where('t0.btourestado', intval($todos));

		$builder->like('t0.sidtour', $text);
		$builder->orLike('t0.stournombre', $text);
		$builder->orLike('t1.snombre', $text);
		$builder->orLike('t0.dtourprecio', $text);

		$builder->orderBy('t0.sidtour', 'DESC');
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getTour($id){
		$builder = $this->conexion('ttour t0');
		$builder->select("t0.sidtour idtour, t0.stournombre tournombre, t0.stourdescripcion tourdescripcion, t0.dtourprecio tourprecio, t0.scolor color, t0.stourdiashabiles tourdiashabiles, t0.btourestado tourestado, t0.nidcattour idcattour");
		$builder->where('sidtour', $id);
		$query = $builder->get();
		return $query->getRowArray();
	}

	public function getTour2($id){
		$builder = $this->conexion('ttour t0');
		$builder->select(" t0.sidtour idtour0, t0.stournombre tournombre0, t0.stourdescripcion tourdescripcion0, t0.dtourprecio tourprecio0, t0.scolor color0, t0.stourdiashabiles tourdiashabiles0, t0.btourestado tourestado0, t1.nidcattour idcattour1, t1.snombre nombre1, t1.bestado estado1,");
		$builder->join('tcattour t1', ' t0.nidcattour = t1.nidcattour');

		$builder->where('t0.nidreserva', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('ttour t0');
		$builder->select('sidtour');
		$builder->join('tcattour t1', ' t1.nidcattour = t0.nidcattour');

		if ($todos !== '')
		$builder->where('t0.btourestado', intval($todos));

		$builder->like('t0.sidtour', $text);
		$builder->orLike('t0.stournombre', $text);
		$builder->orLike('t1.snombre', $text);
		$builder->orLike('t0.dtourprecio', $text);

		return $builder->countAllResults();
	}

	public function UpdateTour($id, $datos){
		$builder = $this->conexion('ttour');
		$builder->where('sidtour', $id);
		$builder->set($datos);
		$builder->update();
	}

	public function getMaxid(){
		$builder = $this->conexion('ttour');
		$builder->selectMax('sidtour');
		$query = $builder->get();
		return  $query->getResult()[0]->sidtour;
	}
}
?>
