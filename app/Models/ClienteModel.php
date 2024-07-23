<?php

namespace App\Models;
use CodeIgniter\Model; 

class ClienteModel extends Model
{
	protected $table      = 'tcliente';
	protected $primaryKey = 'sidcliente';
	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['sidcliente', 'nidtipodoc', 'sclientenombre', 'sclienteapellidos', 'sclientetelefono', 'sclientecorreo', 'sclientedireccion', 'sclientepais', 'tclientefechanacimiento', 'nclienteedad', 'bclientesexo', 'bclienteestado'];
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
	public function existe($sidcliente, $nidtipodoc){
		return $this->where(['sidcliente' => $sidcliente, 'nidtipodoc' => $nidtipodoc])->countAllResults();
	}

//   SECCION ====== TODOS ======
	public function getClientes($total, $pag = 1, $todos = 1, $text = ''){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;

		$builder = $this->conexion('tcliente t0');

		$builder->select("t0.sidcliente idcliente, t0.sclientenombre clientenombre, t0.sclienteapellidos clienteapellidos, t0.sclientetelefono clientetelefono, t0.sclientecorreo clientecorreo, t0.sclientedireccion clientedireccion, t0.sclientepais clientepais, DATE_FORMAT(t0.tclientefechanacimiento,'%d/%m/%Y') clientefechanacimiento, t0.nclienteedad clienteedad, t0.bclientesexo clientesexo, t0.bclienteestado clienteestado, t1.nidtipodoc idtipodoc, t1.snombre nombre, CONCAT(t0.sclientenombre,' - ',t1.snombre) concatenado, CONCAT(t0.sclientenombre,' - ',t1.snombre) concatenadodetalle");

		$builder->join('ttipodoc t1', 't1.nidtipodoc = t0.nidtipodoc');

		if ($todos !== '') {
			$builder->where('t0.bclienteestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.sidcliente', $text)
				->orLike('t0.sclientenombre', $text)
				->orLike('t1.snombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.sidcliente', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== AUTOCOMPLETE ======
	public function getAutocompleteClientes($todos = 1, $text = ''){
		$builder = $this->conexion('tcliente t0');

		$builder->select("t0.sidcliente idcliente, t0.sclientenombre clientenombre, t0.sclienteapellidos clienteapellidos, t0.sclientetelefono clientetelefono, t0.sclientecorreo clientecorreo, t0.sclientedireccion clientedireccion, t0.sclientepais clientepais, DATE_FORMAT(t0.tclientefechanacimiento,'%d/%m/%Y') clientefechanacimiento, t0.nclienteedad clienteedad, t0.bclientesexo clientesexo, t0.bclienteestado clienteestado, t1.nidtipodoc idtipodoc, t1.snombre nombre, CONCAT(t0.sclientenombre,' - ',t1.snombre) concatenado, CONCAT(t0.sclientenombre,' - ',t1.snombre) concatenadodetalle");
		$builder->join('ttipodoc t1', 't1.nidtipodoc = t0.nidtipodoc');

		if ($todos !== '') {
			$builder->where('t0.bclienteestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.sidcliente', $text)
				->orLike('t0.sclientenombre', $text)
				->orLike('t1.snombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.sidcliente', 'DESC');
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== GET ======
	public function getcliente($sidcliente, $nidtipodoc){
		$builder = $this->conexion('tcliente t0');
		$builder->select("t0.sidcliente idcliente, t0.nidtipodoc idtipodoc, t0.sclientenombre clientenombre, t0.sclienteapellidos clienteapellidos, t0.sclientetelefono clientetelefono, t0.sclientecorreo clientecorreo, t0.sclientedireccion clientedireccion, t0.sclientepais clientepais, DATE_FORMAT(t0.tclientefechanacimiento,'%d/%m/%Y') clientefechanacimiento, t0.nclienteedad clienteedad, t0.bclientesexo clientesexo, t0.bclienteestado clienteestado");
		$builder->where(['sidcliente' => $sidcliente, 'nidtipodoc' => $nidtipodoc]);
		$query = $builder->get();
		return $query->getRowArray();
	}

//   SECCION ====== GET 2 ======
	public function getCliente2($id){
		$builder = $this->conexion('tcliente t0');
		$builder->select("t0.sidcliente idcliente, t0.nidtipodoc idtipodoc, t0.sclientenombre clientenombre, t0.sclienteapellidos clienteapellidos, t0.sclientetelefono clientetelefono, t0.sclientecorreo clientecorreo, t0.sclientedireccion clientedireccion, t0.sclientepais clientepais, DATE_FORMAT(t0.tclientefechanacimiento,'%d/%m/%Y') clientefechanacimiento, t0.nclienteedad clienteedad, t0.bclientesexo clientesexo, t0.bclienteestado clienteestado");
		$builder->join('ttipodoc t1', 't1.nidtipodoc = t0.nidtipodoc');
		$builder->where('t0.sidcliente', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}
//   SECCION ====== COUNT ======
	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('tcliente t0');
		$builder->select('sidcliente');
		$builder->join('ttipodoc t1', 't1.nidtipodoc = t0.nidtipodoc');

		if ($todos !== '') {
			$builder->where('t0.bclienteestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.sidcliente', $text)
				->orLike('t0.sclientenombre', $text)
				->orLike('t1.snombre', $text)
				->groupEnd();
		}

		return $builder->countAllResults();
	}

//   SECCION ====== UPDATE ======
	public function UpdateCliente($sidcliente, $nidtipodoc,  $datos){
		$builder = $this->conexion('tcliente');
		$builder->where(['sidcliente' => $sidcliente, 'nidtipodoc' => $nidtipodoc]);
		$builder->set($datos);
		$builder->update();
	}

//   SECCION ====== MAXIMO ID ======
	public function getMaxid(){
		$builder = $this->conexion('tcliente');
		$builder->selectMax('sidcliente');
		$query = $builder->get();
		return  $query->getResult()[0]->sidcliente;
	}
}
?>
