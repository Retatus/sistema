<?php 
namespace App\Controllers;
use CodeIgniter\Controller;

class Login extends BaseController
{
    public function login()
    {
        // Verificar si el formulario ha sido enviado
        if ($this->request->getMethod() === 'post') {
            // Validar los campos del formulario
            $rules = [
                'username' => 'required|valid_email',
                'password' => 'required'
            ];

            if ($this->validate($rules)) {
                // Procesar la autenticación
                $username = $this->request->getPost('username');
                $password = $this->request->getPost('password');

                // Aquí debes incluir la lógica de autenticación, como comprobar en la base de datos si las credenciales son válidas.

                // Ejemplo básico de autenticación:
                if ($username === 'usuario@example.com' && $password === 'contraseña') {
                    // Usuario autenticado correctamente
                    return redirect()->to(base_url('reserva'));
                } else {
                    // Credenciales incorrectas
                    //return redirect()->back()->withInput()->with('error', 'Credenciales incorrectas');
                    return redirect()->to(previous_url())->withInput()->with('error', 'Credenciales incorrectas');
                }
            } else {
                // Validación fallida
                //return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
                return redirect()->to(base_url('login/login'))->withInput()->with('error', 'Credenciales incorrectas');
            }
        }

        // Si no se ha enviado el formulario, cargar la vista de inicio de sesión
        return view('login/login');
    }

    public function logout()
    {
        // Destruir la sesión y redirigir al inicio de sesión
        session()->destroy();
        //return redirect()->to('login');
        return redirect()->to(base_url('login'));
    }

    public function index()
    {
        echo view('login/login');
    }
}