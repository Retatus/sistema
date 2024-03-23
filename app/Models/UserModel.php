<?php namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password'];

    public function authenticate($username, $password)
    {
        //$user = $this->where('username', $username)->first();

        // if ($user && password_verify($password, $user['password'])) {
        //     return $user;
        // }

        return true;
    }
}