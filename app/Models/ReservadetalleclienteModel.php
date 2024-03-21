<?php 

namespace App\Models;
use CodeIgniter\Model; 

class ReservadetalleclienteModel extends Model
{
	protected $table      = 'treservadetallecliente';
	protected $primaryKey = 'nidreservadetallecliente';

	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['nidreserva','sidcliente','ncantidad','dprecio','dtotal','bconfirmado','bestado'];
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
		return $this->where(['nidreservadetallecliente' => $id])->countAllResults();
	}

	public function getReservadetalleclientes($todos = 1, $text = '', $total, $pag = 1){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;
		$builder = $this->conexion('treservadetallecliente t0');
		$builder->select("t0.nidreservadetallecliente idreservadetallecliente, t0.nidreserva idreserva, t0.sidcliente idcliente, t0.ncantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado,  t1.nidreserva idreserva, t1.sreservanombre reservanombre, t2.sidcliente idcliente, t2.sclientenombre clientenombre, t3.snombre tipodoc, CONCAT(t2.sidcliente, ' - ', t2.nidtipodoc, ' - ', t2.sclientenombre, ' - ', t2.sclienteapellidos) as concatenado, CONCAT(t2.sidcliente, ' - ', t2.nidtipodoc, ' - ', t2.sclientenombre, ' - ', t2.sclienteapellidos) as concatenadodetalle");
		$builder->join('treserva t1', ' t1.nidreserva = t0.nidreserva');
		$builder->join('tcliente t2', ' t2.sidcliente = t0.sidcliente');
		$builder->join('ttipodoc t3', ' t3.nidtipodoc = t2.nidtipodoc');

		if ($todos !== '') 
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidreservadetallecliente', $text);
		$builder->orLike('t2.sidcliente', $text);
		$builder->orLike('t2.nidtipodoc', $text);
		$builder->orLike('t2.sclientenombre', $text);
		$builder->orLike('t2.sclienteapellidos', $text);

		$builder->orderBy('t0.nidreservadetallecliente', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getAutocompletereservadetalleclientes($todos = 1, $text = ''){
		$builder = $this->conexion('treservadetallecliente t0');
		$builder->select("t0.nidreservadetallecliente idreservadetallecliente, t0.nidreserva idreserva, t0.sidcliente idcliente, t0.ncantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado,  t1.nidreserva idreserva, t1.sreservanombre reservanombre, t2.sidcliente idcliente, t2.sclientenombre clientenombre, t3.snombre tipodoc, CONCAT(t2.sidcliente, ' - ', t2.nidtipodoc, ' - ', t2.sclientenombre, ' - ', t2.sclienteapellidos) as concatenado, CONCAT(t2.sidcliente, ' - ', t2.nidtipodoc, ' - ', t2.sclientenombre, ' - ', t2.sclienteapellidos) as concatenadodetalle");
		$builder->join('treserva t1', ' t1.nidreserva = t0.nidreserva');
		$builder->join('tcliente t2', ' t2.sidcliente = t0.sidcliente');
		$builder->join('ttipodoc t3', ' t3.nidtipodoc = t2.nidtipodoc');

		if ($todos !== '') 
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidreservadetallecliente', $text);
		$builder->orLike('t2.sidcliente', $text);
		$builder->orLike('t2.nidtipodoc', $text);
		$builder->orLike('t2.sclientenombre', $text);
		$builder->orLike('t2.sclienteapellidos', $text);

		$builder->orderBy('t0.nidreservadetallecliente', 'DESC');
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getReservadetallecliente($id){
		$builder = $this->conexion('treservadetallecliente t0');
		$builder->select("t0.nidreservadetallecliente idreservadetallecliente, t0.nidreserva idreserva, t0.sidcliente idcliente, t0.ncantidad cantidad, t0.dprecio precio, t0.dtotal total, t0.bconfirmado confirmado, t0.bestado estado");
		$builder->where('nidreservadetallecliente', $id);
		$query = $builder->get();
		return $query->getRowArray();
	}

	public function getReservadetallecliente2($id){
		$builder = $this->conexion('treservadetallecliente t0');
		$builder->select(" t0.nidreservadetallecliente idreservadetallecliente0, t0.ncantidad cantidad0, t0.dprecio precio0, t0.dtotal total0, t0.bconfirmado confirmado0, t0.bestado estado0, t1.nidreserva idreserva1, t1.sreservanombre reservanombre1, t1.tfechainicio fechainicio1, t1.tfechafin fechafin1, t1.ntipodoc tipodoc1, t1.sidpersona idpersona1, t1.sreservatelefono reservatelefono1, t1.sreservacorreo reservacorreo1, t1.dmontototal montototal1, t1.bpagado pagado1, t1.bestado estado1, t2.sidcliente idcliente2, t2.sclientenombre clientenombre2, t2.sclienteapellidos clienteapellidos2, t2.sclientetelefono clientetelefono2, t2.sclientecorreo clientecorreo2, t2.sclientedireccion clientedireccion2, t2.sclientepais clientepais2, t2.tclientefechanacimiento clientefechanacimiento2, t2.nclienteedad clienteedad2, t2.bclientesexo clientesexo2, t2.bclienteestado clienteestado2, t3.nidtipodoc idtipodoc3, t3.snombre nombre3, t3.bestado estado3,");
		$builder->join('treserva t1', ' t0.nidreserva = t1.nidreserva');
		$builder->join('tcliente t2', ' t0.sidcliente = t2.sidcliente');
		$builder->join('ttipodoc t3', ' t2.nidtipodoc = t3.nidtipodoc');

		$builder->where('t0.nidreserva', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('treservadetallecliente t0');
		$builder->select('nidreservadetallecliente');
		$builder->join('treserva t1', ' t1.nidreserva = t0.nidreserva');
		$builder->join('tcliente t2', ' t2.sidcliente = t0.sidcliente');
		$builder->join('ttipodoc t3', ' t3.nidtipodoc = t2.nidtipodoc');

		if ($todos !== '')
		$builder->where('t0.bestado', intval($todos));

		$builder->like('t0.nidreservadetallecliente', $text);
		$builder->orLike('t2.sidcliente', $text);
		$builder->orLike('t2.nidtipodoc', $text);
		$builder->orLike('t2.sclientenombre', $text);
		$builder->orLike('t2.sclienteapellidos', $text);

		return $builder->countAllResults();
	}

	public function UpdateReservadetallecliente($id, $datos){
		$builder = $this->conexion('treservadetallecliente');
		$builder->where('nidreservadetallecliente', $id);
		$builder->set($datos);
		$builder->update();
	}

	public function getMaxid(){
		$builder = $this->conexion('treservadetallecliente');
		$builder->selectMax('nidreservadetallecliente');
		$query = $builder->get();
		return  $query->getResult()[0]->nidreservadetallecliente;
	}
}
?>
