<?php 

namespace App\Models;
use CodeIgniter\Model; 

class ReservaModel extends Model
{
	protected $table      = 'treserva';
	protected $primaryKey = 'nidreserva';

	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['sreservanombre','tfechainicio','tfechafin','ntipodoc','sidpersona','sreservatelefono','sreservacorreo','dmontototal','bpagado','bestado'];
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
		return $this->where(['nidreserva' => $id])->countAllResults();
	}

	public function getReservas($todos = 1, $text = '', $total, $pag = 1){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;
		$builder = $this->conexion('treserva t0');
		$builder->select("t0.nidreserva idreserva, t0.sreservanombre reservanombre, DATE_FORMAT(CAST(t0.tfechainicio As Date), '%d-%m-%Y') fechainicio, DATE_FORMAT(CAST(t0.tfechafin As Date), '%d-%m-%Y') fechafin, t0.ntipodoc tipodoc, t0.sidpersona idpersona, t0.sreservatelefono reservatelefono, t0.sreservacorreo reservacorreo, t0.dmontototal montototal, t0.bpagado pagado, t0.bestado estado,  CONCAT(t0.sreservanombre) as concatenado, CONCAT(t0.sreservanombre) as concatenadodetalle");

		if ($todos !== '') 
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidreserva', $text);
		$builder->orLike('t0.sreservanombre', $text);

		$builder->orderBy('t0.nidreserva', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getAutocompletereservas($todos = 1, $text = ''){
		$builder = $this->conexion('treserva t0');
		$builder->select("t0.nidreserva idreserva, t0.sreservanombre reservanombre, DATE_FORMAT(CAST(t0.tfechainicio As Date), '%d-%m-%Y') fechainicio, DATE_FORMAT(CAST(t0.tfechafin As Date), '%d-%m-%Y') fechafin, t0.ntipodoc tipodoc, t0.sidpersona idpersona, t0.sreservatelefono reservatelefono, t0.sreservacorreo reservacorreo, t0.dmontototal montototal, t0.bpagado pagado, t0.bestado estado,  CONCAT(t0.sreservanombre) as concatenado, CONCAT(t0.sreservanombre) as concatenadodetalle");

		if ($todos !== '') 
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidreserva', $text);
		$builder->orLike('t0.sreservanombre', $text);

		$builder->orderBy('t0.nidreserva', 'DESC');
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getReserva($nidreserva){
		$builder = $this->conexion('treserva t0');
		$builder->select("t0.nidreserva idreserva, t0.sreservanombre reservanombre,DATE_FORMAT(CAST(t0.tfechainicio As Date), '%d/%m/%Y') fechainicio,DATE_FORMAT(CAST(t0.tfechafin As Date), '%d/%m/%Y') fechafin, t0.ntipodoc tipodoc, t0.sidpersona idpersona, t0.sreservatelefono reservatelefono, t0.sreservacorreo reservacorreo, t0.dmontototal montototal, t0.bpagado pagado, t0.bestado estado");
		$builder->where(['nidreserva' => $nidreserva]);
		$query = $builder->get();
		return $query->getRowArray();
	}

	public function getReserva2($id){
		$builder = $this->conexion('treserva t0');
		$builder->select(" t0.nidreserva idreserva0, t0.sreservanombre reservanombre0, t0.tfechainicio fechainicio0, t0.tfechafin fechafin0, t0.ntipodoc tipodoc0, t0.sidpersona idpersona0, t0.sreservatelefono reservatelefono0, t0.sreservacorreo reservacorreo0, t0.dmontototal montototal0, t0.bpagado pagado0, t0.bestado estado0,");

		$builder->where('t0.nidreserva', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('treserva t0');
		$builder->select('nidreserva');

		if ($todos !== '')
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidreserva', $text);
		$builder->orLike('t0.sreservanombre', $text);

		return $builder->countAllResults();
	}

	public function UpdateReserva($nidreserva, $datos){
		$builder = $this->conexion('treserva');
		$builder->where(['nidreserva' => $nidreserva]);
		$builder->set($datos);
		$builder->update();
	}

	public function getMaxid(){
		$builder = $this->conexion('treserva');
		$builder->selectMax('nidreserva');
		$query = $builder->get();
		return  $query->getResult()[0]->nidreserva;
	}
}
?>
