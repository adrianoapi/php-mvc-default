<?php

/**
 * MainController - Todos os controllers deverão estender essa classe
 *
 */
class MainController extends UserLogin
{

    public $db;
    public $phpass;
    public $title;
    public $login_required = false;
    public $permission_required = 'any';
    public $parametros = array();

    public function __construct($parametros = array())
    {

        // Instancia do DB
        $this->db = new DB();

        // Phpass
        $this->phpass = new PasswordHash(8, false);

        // Parâmetros
        $this->parametros = $parametros;

        // Verifica o login
        $this->check_userlogin();
    }

    public function load_model($model_name = false)
    {

        // Um arquivo deverá ser enviado
        if (!$model_name)
            return;

        // Garante que o nome do modelo tenha letras minúsculas
        $model_name = strtolower($model_name);

        // Inclui o arquivo
        $model_path = ABSPATH . '/models/' . $model_name . '.php';

        // Verifica se o arquivo existe
        if (file_exists($model_path)) {

            // Inclui o arquivo
            require_once $model_path;

            // Remove os caminhos do arquivo (se tiver algum)
            $model_name = explode('/', $model_name);

            // Pega só o nome final do caminho
            $model_name = end($model_name);

            // Remove caracteres inválidos do nome do arquivo
            $model_name = preg_replace('/[^a-zA-Z0-9]/is', '', $model_name);

            // Verifica se a classe existe
            if (class_exists($model_name)) {

                // Retorna um objeto da classe
                return new $model_name($this->db, $this);
            }

            return;
        }
    }

    public function load_service($service_name = false)
    {

        if (!$service_name)
            return;

        $service_name = strtolower($service_name);

        $model_path = ABSPATH . '/service/' . $service_name . '.php';

        if (file_exists($model_path)) {

            require_once $model_path;

            $service_name = explode('/', $service_name);

            $service_name = end($service_name);

            $service_name = preg_replace('/[^a-zA-Z0-9]/is', '', $service_name);

            if (class_exists($service_name)) {

                return new $service_name($this->db, $this);
            }

            return;
        }
    }
    
     public function load_interface($interface_name = false)
    {

        if (!$interface_name)
            return;

        $interface_name = strtolower($interface_name);
        $model_path = ABSPATH . '/interface/' . $interface_name . '.php';
//        echo $model_path;
//        die();

        if (file_exists($model_path)) {

            require_once $model_path;

            $interface_name = explode('/', $interface_name);

            $interface_name = end($interface_name);

            $interface_name = preg_replace('/[^a-zA-Z0-9]/is', '', $interface_name);

            if (class_exists($interface_name)) {

                return new $interface_name($this->db, $this);
            }

            return;
        }
    }

}
