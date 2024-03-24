<?php 

namespace App\Models;
use CodeIgniter\Model; 

class RestauranteModel extends Model
{
	protected $table      = 'trestaurante';
	protected $primaryKey = 'sidtrestaurante';

	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['sidtrestaurante','srestaurantenombre','nidrestaurantecategoria','srestaurantedireccion','srestaurantetelefono','srestaurantecorreo','srestauranteruc','srestauranterazon','srestaurantenrocuenta','srestauranteubigeo','drestaurantelatitud','drestaurantelongitud','brestauranteestado'];
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
		return $this->where(['sidtrestaurante' => $id])->countAllResults();
	}

	public function getRestaurantes($todos = 1, $text = '', $total, $pag = 1){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;
		$builder = $this->conexion('trestaurante t0');
		$builder->select("t0.sidtrestaurante idtrestaurante, t0.srestaurantenombre restaurantenombre, t0.nidrestaurantecategoria idrestaurantecategoria, t0.srestaurantedireccion restaurantedireccion, t0.srestaurantetelefono restaurantetelefono, t0.srestaurantecorreo restaurantecorreo, t0.srestauranteruc restauranteruc, t0.srestauranterazon restauranterazon, t0.srestaurantenrocuenta restaurantenrocuenta, t0.srestauranteubigeo restauranteubigeo, t0.drestaurantelatitud restaurantelatitud, t0.drestaurantelongitud restaurantelongitud, t0.brestauranteestado restauranteestado,  CONCAT(t0.srestaurantenombre) as concatenado, CONCAT(t0.srestaurantenombre) as concatenadodetalle");

		if ($todos !== '') 
		$builder->where('t0.brestauranteestado', intval($todos));

		$builder->like('t0.sidtrestaurante', $text);
		$builder->orLike('t0.srestaurantenombre', $text);

		$builder->orderBy('t0.sidtrestaurante', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getAutocompleterestaurantes($todos = 1, $text = ''){
		$builder = $this->conexion('trestaurante t0');
		$builder->select("t0.sidtrestaurante idtrestaurante, t0.srestaurantenombre restaurantenombre, t0.nidrestaurantecategoria idrestaurantecategoria, t0.srestaurantedireccion restaurantedireccion, t0.srestaurantetelefono restaurantetelefono, t0.srestaurantecorreo restaurantecorreo, t0.srestauranteruc restauranteruc, t0.srestauranterazon restauranterazon, t0.srestaurantenrocuenta restaurantenrocuenta, t0.srestauranteubigeo restauranteubigeo, t0.drestaurantelatitud restaurantelatitud, t0.drestaurantelongitud restaurantelongitud, t0.brestauranteestado restauranteestado,  CONCAT(t0.srestaurantenombre) as concatenado, CONCAT(t0.srestaurantenombre) as concatenadodetalle");

		if ($todos !== '') 
		$builder->where('t0.brestauranteestado', intval($todos));

		$builder->like('t0.sidtrestaurante', $text);
		$builder->orLike('t0.srestaurantenombre', $text);

		$builder->orderBy('t0.sidtrestaurante', 'DESC');
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getRestaurante($sidtrestaurante){
		$builder = $this->conexion('trestaurante t0');
		$builder->select("t0.sidtrestaurante idtrestaurante, t0.srestaurantenombre restaurantenombre, t0.nidrestaurantecategoria idrestaurantecategoria, t0.srestaurantedireccion restaurantedireccion, t0.srestaurantetelefono restaurantetelefono, t0.srestaurantecorreo restaurantecorreo, t0.srestauranteruc restauranteruc, t0.srestauranterazon restauranterazon, t0.srestaurantenrocuenta restaurantenrocuenta, t0.srestauranteubigeo restauranteubigeo, t0.drestaurantelatitud restaurantelatitud, t0.drestaurantelongitud restaurantelongitud, t0.brestauranteestado restauranteestado");
		$builder->where(['sidtrestaurante' => $sidtrestaurante]);
		$query = $builder->get();
		return $query->getRowArray();
	}

	public function getRestaurante2($id){
		$builder = $this->conexion('trestaurante t0');
		$builder->select(" t0.sidtrestaurante idtrestaurante0, t0.srestaurantenombre restaurantenombre0, t0.nidrestaurantecategoria idrestaurantecategoria0, t0.srestaurantedireccion restaurantedireccion0, t0.srestaurantetelefono restaurantetelefono0, t0.srestaurantecorreo restaurantecorreo0, t0.srestauranteruc restauranteruc0, t0.srestauranterazon restauranterazon0, t0.srestaurantenrocuenta restaurantenrocuenta0, t0.srestauranteubigeo restauranteubigeo0, t0.drestaurantelatitud restaurantelatitud0, t0.drestaurantelongitud restaurantelongitud0, t0.brestauranteestado restauranteestado0,");

		$builder->where('t0.nidreserva', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}

	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('trestaurante t0');
		$builder->select('sidtrestaurante');

		if ($todos !== '')
		$builder->where('t0.brestauranteestado', intval($todos));

		$builder->like('t0.sidtrestaurante', $text);
		$builder->orLike('t0.srestaurantenombre', $text);

		return $builder->countAllResults();
	}

	public function UpdateRestaurante($sidtrestaurante, $datos){
		$builder = $this->conexion('trestaurante');
		$builder->where(['sidtrestaurante' => $sidtrestaurante]);
		$builder->set($datos);
		$builder->update();
	}

	public function getMaxid(){
		$builder = $this->conexion('trestaurante');
		$builder->selectMax('sidtrestaurante');
		$query = $builder->get();
		return  $query->getResult()[0]->sidtrestaurante;
	}
}
?>
