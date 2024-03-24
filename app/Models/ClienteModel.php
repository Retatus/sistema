<?php 

namespace App\Models;
use CodeIgniter\Model; 

class ClienteModel extends Model
{
	protected $table      = 'tcliente';
	protected $primaryKey = 'sidcliente';

	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['sidcliente','nidtipodoc','sclientenombre','sclienteapellidos','sclientetelefono','sclientecorreo','sclientedireccion','sclientepais','tclientefechanacimiento','nclienteedad','bclientesexo','bclienteestado'];
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
		return $this->where(['sidcliente' => $id])->countAllResults();
	}

	public function getClientes($todos = 1, $text = '', $total, $pag = 1){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;
		$builder = $this->conexion('tcliente t0');
		$builder->select("t0.sidcliente idcliente, t0.nidtipodoc idtipodoc, t0.sclientenombre clientenombre, t0.sclienteapellidos clienteapellidos, t0.sclientetelefono clientetelefono, t0.sclientecorreo clientecorreo, t0.sclientedireccion clientedireccion, t0.sclientepais clientepais, DATE_FORMAT(CAST(t0.tclientefechanacimiento As Date), '%d-%m-%Y') clientefechanacimiento, t0.nclienteedad clienteedad, t0.bclientesexo clientesexo, t0.bclienteestado clienteestado,  t1.nidtipodoc idtipodoc, t1.snombre nombre, CONCAT(t0.sclientenombre, ' - ', t1.snombre, ' - ', t0.sclienteapellidos) as concatenado, CONCAT(t0.sclientenombre, ' - ', t1.snombre, ' - ', t0.sclienteapellidos) as concatenadodetalle");
		$builder->join('ttipodoc t1', ' t1.nidtipodoc = t0.nidtipodoc');

		if ($todos !== '') 
		$builder->where('t0.bclienteestado', intval($todos));

		$builder->like('t0.sidcliente', $text);
		$builder->orLike('t0.sclientenombre', $text);
		$builder->orLike('t1.snombre', $text);
		$builder->orLike('t0.sclienteapellidos', $text);

		$builder->orderBy('t0.sidcliente', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getAutocompleteclientes($todos = 1, $text = ''){
		$builder = $this->conexion('tcliente t0');
		$builder->select("t0.sidcliente idcliente, t0.nidtipodoc idtipodoc, t0.sclientenombre clientenombre, t0.sclienteapellidos clienteapellidos, t0.sclientetelefono clientetelefono, t0.sclientecorreo clientecorreo, t0.sclientedireccion clientedireccion, t0.sclientepais clientepais, DATE_FORMAT(CAST(t0.tclientefechanacimiento As Date), '%d-%m-%Y') clientefechanacimiento, t0.nclienteedad clienteedad, t0.bclientesexo clientesexo, t0.bclienteestado clienteestado,  t1.nidtipodoc idtipodoc, t1.snombre nombre, CONCAT(t0.sclientenombre, ' - ', t1.snombre, ' - ', t0.sclienteapellidos) as concatenado, CONCAT(t0.sclientenombre, ' - ', t1.snombre, ' - ', t0.sclienteapellidos) as concatenadodetalle");
		$builder->join('ttipodoc t1', ' t1.nidtipodoc = t0.nidtipodoc');

		if ($todos !== '') 
		$builder->where('t0.bclienteestado', intval($todos));

		$builder->like('t0.sidcliente', $text);
		$builder->orLike('t0.sclientenombre', $text);
		$builder->orLike('t1.snombre', $text);
		$builder->orLike('t0.sclienteapellidos', $text);

		$builder->orderBy('t0.sidcliente', 'DESC');
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getCliente($sidcliente,$nidtipodoc){
		$builder = $this->conexion('tcliente t0');
		$builder->select("t0.sidcliente idcliente, t0.nidtipodoc idtipodoc, t0.sclientenombre clientenombre, t0.sclienteapellidos clienteapellidos, t0.sclientetelefono clientetelefono, t0.sclientecorreo clientecorreo, t0.sclientedireccion clientedireccion, t0.sclientepais clientepais,DATE_FORMAT(CAST(t0.tclientefechanacimiento As Date), '%d/%m/%Y') clientefechanacimiento, t0.nclienteedad clienteedad, t0.bclientesexo clientesexo, t0.bclienteestado clienteestado");
		$builder->where(['sidcliente' => $sidcliente,'nidtipodoc' => $nidtipodoc]);
		$query = $builder->get();
		return $query->getRowArray();
	}

	public function getCliente2($id){
		$builder = $this->conexion('tcliente t0');
		$builder->select(" t0.sidcliente idcliente0, t0.sclientenombre clientenombre0, t0.sclienteapellidos clienteapellidos0, t0.sclientetelefono clientetelefono0, t0.sclientecorreo clientecorreo0, t0.sclientedireccion clientedireccion0, t0.sclientepais clientepais0, t0.tclientefechanacimiento clientefechanacimiento0, t0.nclienteedad clienteedad0, t0.bclientesexo clientesexo0, t0.bclienteestado clienteestado0, t1.nidtipodoc idtipodoc1, t1.snombre nombre1, t1.bestado estado1,");
		$builder->join('ttipodoc t1', ' t0.nidtipodoc = t1.nidtipodoc');

		$builder->where('t0.nidreserva', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('tcliente t0');
		$builder->select('sidcliente');
		$builder->join('ttipodoc t1', ' t1.nidtipodoc = t0.nidtipodoc');

		if ($todos !== '')
		$builder->where('t0.bclienteestado', intval($todos));

		$builder->like('t0.sidcliente', $text);
		$builder->orLike('t0.sclientenombre', $text);
		$builder->orLike('t1.snombre', $text);
		$builder->orLike('t0.sclienteapellidos', $text);

		return $builder->countAllResults();
	}

	public function UpdateCliente($sidcliente,$nidtipodoc, $datos){
		$builder = $this->conexion('tcliente');
		$builder->where(['sidcliente' => $sidcliente,'nidtipodoc' => $nidtipodoc]);
		$builder->set($datos);
		$builder->update();
	}

	public function getMaxid(){
		$builder = $this->conexion('tcliente');
		$builder->selectMax('sidcliente');
		$query = $builder->get();
		return  $query->getResult()[0]->sidcliente;
	}
}
?>
