<?php

/**
 * NoticiasController - Controller de exemplo
 *
 * @package TutsupMVC
 * @since 0.1
 */
class NoticiasController extends MainController
{

    public $login_required = false;
    public $permission_required;

    public function index()
    {
        // Título da página
        $this->title = 'Notícias';

        // Carrega o modelo para este view
        $modelo = $this->load_model('noticias/NoticiasAdminModel');

        require ABSPATH . '/views/_includes/header.php';
        require ABSPATH . '/views/_includes/menu.php';
        require ABSPATH . '/views/noticias/noticias-view.php';
        require ABSPATH . '/views/_includes/footer.php';
    }

    public function adm()
    {
        // Page title
        $this->title = 'Gerenciar notícias';
        $this->permission_required = 'gerenciar-noticias';

        // Verifica se o usuário está logado
        if (!$this->logged_in) {

            // Se não; garante o logout
            $this->logout();

            // Redireciona para a página de login
            $this->goto_login();

            // Garante que o script não vai passar daqui
            return;
        }

        // Verifica se o usuário tem a permissão para acessar essa página
        if (!$this->check_permissions($this->permission_required, $this->userdata['user_permissions'])) {

            // Exibe uma mensagem
            echo 'Você não tem permissões para acessar essa página.';

            // Finaliza aqui
            return;
        }

        // Carrega o modelo para este view
        $modelo = $this->load_model('noticias/NoticiasAdminModel');

        /** Carrega os arquivos do view * */
        // /views/_includes/header.php
        require ABSPATH . '/views/_includes/header.php';

        // /views/_includes/menu.php
        require ABSPATH . '/views/_includes/menu.php';

        // /views/noticias/index.php
        require ABSPATH . '/views/noticias/noticias-adm-view.php';

        // /views/_includes/footer.php
        require ABSPATH . '/views/_includes/footer.php';
    }

}
