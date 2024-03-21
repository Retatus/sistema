<?php 
namespace App\Models;
use CodeIgniter\Model;
use App\Models\ConexionModel;

class ConexionModel extends Model
{   
    protected function conexion(string $table = null)
    {
        if ($this->builder instanceof BaseBuilder) {
            return $this->builder;
        }
        $table = empty($table) ? $this->table : $table;
        // Ensure we have a good db connection
        if (!$this->db instanceof BaseConnection) {
            $this->db = \Config\Database::connect();
        }
        $this->builder = $this->db->table($table);
        return $this->builder;
    }
}

?>