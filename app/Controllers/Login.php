<?php 
//namespace App\Controllers;
// use App\Controllers\BaseController;
// use App\Models\UserModel;

namespace App\Controllers;
use CodeIgniter\Controller;

class Login extends BaseController
{
	// protected $user;

	// public function __construct(){        
	// 	$this->user = new UserModel();
	// } 

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
                    //return redirect()->to('dashboard'); // Redirigir a la página de inicio
                    echo view('layouts/header');
                    echo view('layouts/aside');
                    //echo view('banco/list', $data);
                    echo view('layouts/footer');
                } else {
                    // Credenciales incorrectas
                    //return redirect()->back()->withInput()->with('error', 'Credenciales incorrectas');
                    return redirect()->to('login/login')->with('error', 'Usuario o contraseña incorrectos.');
                }
            } else {
                // Validación fallida
                //return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
                return redirect()->to('login/login')->with('error', $this->validator->getErrors());
            }
        }

        // Si no se ha enviado el formulario, cargar la vista de inicio de sesión
        return view('login/login');
    }

    public function dashboard()
    {
        // Verificar si el usuario está autenticado, de lo contrario, redirigir al inicio de sesión
        // Ejemplo básico de autenticación: verificar si hay una sesión iniciada
        // Puedes implementar tu propio método de autenticación, como usar un middleware.
        if (!session()->has('isLoggedIn')) {
            return redirect()->to('login/login');
        }

        // Cargar la vista del panel de control
        //return view('dashboard');
        echo view('layouts/header');
		echo view('layouts/aside');
		//echo view('banco/list', $data);
		echo view('layouts/footer');
    }

    public function logout()
    {
        // Destruir la sesión y redirigir al inicio de sesión
        session()->destroy();
        return redirect()->to('login');
    }

    public function index()
    {
        echo view('login/login');
    }

    public function authenticate()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        //echo $username;
        //$user = $model->authenticate($username, $password);
        if (false) {
            // Usuario autenticado, guarda la información en la sesión
            // session()->set('isLoggedIn', true);
            // session()->set('userData', $user);

            echo view('layouts/header');
            echo view('layouts/aside');
            echo view('layouts/footer');
            echo $username;

            // Redirige a la página de inicio
            // return redirect()->to('/banco');
            //echo view('layouts/header');
        } else {
            // Credenciales incorrectas, muestra mensaje de error
            return redirect()->to('login/login')->with('error', 'Usuario o contraseña incorrectos.');
        }
    }
}