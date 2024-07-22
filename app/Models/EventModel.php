<?php

namespace App\Models;
use CodeIgniter\Model;

class EventModel extends Model
{
    protected $table      = 'treserva';
	protected $primaryKey = 'nidreserva';
    protected $allowedFields = ['sreservanombre', 'tfechainicio', 'tfechafin'];
}
?>