<?php

/**
 * NoticiasController
 */
class NoticiasController extends MainController
{

    public $login_required = false;
    public $permission_required;
    private $service;

    public function __construct($parametros = array())
    {
        $interface = $this->load_interface('INoticias');
        
        parent::__construct($parametros);
    }

    public function index()
    {
        $this->title = 'Notícias';
        $modelo = $this->load_model('noticias/NoticiasAdminModel');
        require ABSPATH . '/views/_includes/header.php';
        require ABSPATH . '/views/_includes/menu.php';
        require ABSPATH . '/views/noticias/noticias-list.php';
        require ABSPATH . '/views/_includes/footer.php';
    }

    public function visualizar()
    {
        $this->title = 'Notícias';
        $modelo = $this->load_model('noticias/NoticiasAdminModel');
        require ABSPATH . '/views/_includes/header.php';
        require ABSPATH . '/views/_includes/menu.php';
        require ABSPATH . '/views/noticias/noticias-view.php';
        require ABSPATH . '/views/_includes/footer.php';
    }

    public function adm()
    {
        $this->title = 'Gerenciar notícias';
        $this->permission_required = 'gerenciar-noticias';
        # Verifica se o usuário está logado
        if (!$this->logged_in) {
            $this->logout();
            $this->goto_login();
            return;
        }
        # Checa permissão
        if (!$this->check_permissions($this->permission_required, $this->userdata['user_permissions'])) {
            echo 'Você não tem permissões para acessar essa página.';
            return;
        }
        $modelo = $this->load_model('noticias/NoticiasAdminModel');
        require ABSPATH . '/views/_includes/header.php';
        require ABSPATH . '/views/_includes/menu.php';
        require ABSPATH . '/views/noticias/noticias-adm-view.php';
        require ABSPATH . '/views/_includes/footer.php';
    }

}
