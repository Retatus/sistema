<?php

namespace App\Models;
use CodeIgniter\Model; 

class RestauranteModel extends Model
{
	protected $table      = 'trestaurante';
	protected $primaryKey = 'sidtrestaurante';
	protected $returnType     = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = ['sidtrestaurante', 'srestaurantenombre', 'nidrestaurantecategoria', 'srestaurantedireccion', 'srestaurantetelefono', 'srestaurantecorreo', 'srestauranteruc', 'srestauranterazon', 'srestaurantenrocuenta', 'srestauranteubigeo', 'drestaurantelatitud', 'drestaurantelongitud', 'brestauranteestado'];
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
	public function existe($sidtrestaurante){
		return $this->where(['sidtrestaurante' => $sidtrestaurante])->countAllResults();
	}

//   SECCION ====== TODOS ======
	public function getRestaurantes($total, $pag = 1, $todos = 1, $text = ''){
		$CantidadMostrar = $total;
		$TotalReg = $this->getCount($todos, $text);
		$TotalRegistro = ceil($TotalReg/$CantidadMostrar);
		$desde = ($pag - 1) * $CantidadMostrar;

		$builder = $this->conexion('trestaurante t0');

		$builder->select("t0.sidtrestaurante idtrestaurante, t0.srestaurantenombre restaurantenombre, t0.nidrestaurantecategoria idrestaurantecategoria, t0.srestaurantedireccion restaurantedireccion, t0.srestaurantetelefono restaurantetelefono, t0.srestaurantecorreo restaurantecorreo, t0.srestauranteruc restauranteruc, t0.srestauranterazon restauranterazon, t0.srestaurantenrocuenta restaurantenrocuenta, t0.srestauranteubigeo restauranteubigeo, t0.drestaurantelatitud restaurantelatitud, t0.drestaurantelongitud restaurantelongitud, t0.brestauranteestado restauranteestado, CONCAT(t0.srestaurantenombre) concatenado, CONCAT(t0.srestaurantenombre) concatenadodetalle");


		if ($todos !== '') {
			$builder->where('t0.brestauranteestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.sidtrestaurante', $text)
				->orLike('t0.srestaurantenombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.sidtrestaurante', 'DESC');
		$builder->limit($CantidadMostrar, $desde);
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== AUTOCOMPLETE ======
	public function getAutocompleteRestaurantes($todos = 1, $text = ''){
		$builder = $this->conexion('trestaurante t0');

		$builder->select("t0.sidtrestaurante idtrestaurante, t0.srestaurantenombre restaurantenombre, t0.nidrestaurantecategoria idrestaurantecategoria, t0.srestaurantedireccion restaurantedireccion, t0.srestaurantetelefono restaurantetelefono, t0.srestaurantecorreo restaurantecorreo, t0.srestauranteruc restauranteruc, t0.srestauranterazon restauranterazon, t0.srestaurantenrocuenta restaurantenrocuenta, t0.srestauranteubigeo restauranteubigeo, t0.drestaurantelatitud restaurantelatitud, t0.drestaurantelongitud restaurantelongitud, t0.brestauranteestado restauranteestado, CONCAT(t0.srestaurantenombre) concatenado, CONCAT(t0.srestaurantenombre) concatenadodetalle");

		if ($todos !== '') {
			$builder->where('t0.brestauranteestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.sidtrestaurante', $text)
				->orLike('t0.srestaurantenombre', $text)
				->groupEnd();
		}

		$builder->orderBy('t0.sidtrestaurante', 'DESC');
		$query = $builder->get();

		return $query->getResultArray();
	}

//   SECCION ====== GET ======
	public function getrestaurante($sidtrestaurante){
		$builder = $this->conexion('trestaurante t0');
		$builder->select("t0.sidtrestaurante idtrestaurante, t0.srestaurantenombre restaurantenombre, t0.nidrestaurantecategoria idrestaurantecategoria, t0.srestaurantedireccion restaurantedireccion, t0.srestaurantetelefono restaurantetelefono, t0.srestaurantecorreo restaurantecorreo, t0.srestauranteruc restauranteruc, t0.srestauranterazon restauranterazon, t0.srestaurantenrocuenta restaurantenrocuenta, t0.srestauranteubigeo restauranteubigeo, t0.drestaurantelatitud restaurantelatitud, t0.drestaurantelongitud restaurantelongitud, t0.brestauranteestado restauranteestado");
		$builder->where(['sidtrestaurante' => $sidtrestaurante]);
		$query = $builder->get();
		return $query->getRowArray();
	}

//   SECCION ====== GET 2 ======
	public function getRestaurante2($id){
		$builder = $this->conexion('trestaurante t0');
		$builder->select("t0.sidtrestaurante idtrestaurante, t0.srestaurantenombre restaurantenombre, t0.nidrestaurantecategoria idrestaurantecategoria, t0.srestaurantedireccion restaurantedireccion, t0.srestaurantetelefono restaurantetelefono, t0.srestaurantecorreo restaurantecorreo, t0.srestauranteruc restauranteruc, t0.srestauranterazon restauranterazon, t0.srestaurantenrocuenta restaurantenrocuenta, t0.srestauranteubigeo restauranteubigeo, t0.drestaurantelatitud restaurantelatitud, t0.drestaurantelongitud restaurantelongitud, t0.brestauranteestado restauranteestado");
		$builder->where('t0.sidtrestaurante', $id);
		$query = $builder->get();
		return $query->getResultArray();
	}
//   SECCION ====== COUNT ======
	public function getCount($todos = 1, $text = ''){
		$builder = $this->conexion('trestaurante t0');
		$builder->select('sidtrestaurante');

		if ($todos !== '') {
			$builder->where('t0.brestauranteestado', intval($todos));
		}

		if ($text !== '') {
			$builder->groupStart()
				->like('t0.sidtrestaurante', $text)
				->orLike('t0.srestaurantenombre', $text)
				->groupEnd();
		}

		return $builder->countAllResults();
	}

//   SECCION ====== UPDATE ======
	public function UpdateRestaurante($sidtrestaurante,  $datos){
		$builder = $this->conexion('trestaurante');
		$builder->where(['sidtrestaurante' => $sidtrestaurante]);
		$builder->set($datos);
		$builder->update();
	}

//   SECCION ====== MAXIMO ID ======
	public function getMaxid(){
		$builder = $this->conexion('trestaurante');
		$builder->selectMax('sidtrestaurante');
		$query = $builder->get();
		return  $query->getResult()[0]->sidtrestaurante;
	}
}
?>
