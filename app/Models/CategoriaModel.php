<?php 

namespace App\Models;
use CodeIgniter\Model;
// USE agencia_viajes;
// SET FOREIGN_KEY_CHECKS=0;
// TRUNCATE TABLE `ttour`;
// SET FOREIGN_KEY_CHECKS=1;
class CategoriaModel extends Model
{
    // CATEGORIA TOURS
    protected $table      = 'tcattour';
    protected $primaryKey = 'nidcattour';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['snombre','bestado']; 

    protected $useTimestamps = false;
    protected $createdField  = 'tfecha_alt';
    protected $updatedField  = 'tfecha_edi';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function getNews($slug = 1)
    {
        if ($slug === 1)
        {
            return $this->findAll();
        }

        return $this->asArray()
                    ->where(['sidtour' => $slug])
                    ->first();
    }

	public function getCategorias($bestado = 1){
        if ($bestado === 1)
        {
            return $this->findAll();
        }
		return $this->where('bestado', $bestado)->findAll();
    }
    
    // public function getCategorias(){
	// 	$this->db->where("bestado","1");
	// 	$resultados = $this->db->get("tcattour");
	// 	return $resultados->result();
	// }

	public function saveCategoria($data){
		return $this->db->insert("tcattour",$data);
	}

	// public function getCategoria($id){
	// 	$this->db->where("nidcattour",$id);
	// 	$resultado = $this->db->get("tcattour");
	// 	return $resultado->row();
	// }

	// public function updateCategoria($id,$data){
	// 	$this->db->where("nidcattour",$id);
	// 	return $this->db->update("tcattour",$data);
	// }
}

?>