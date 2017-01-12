<?php

class HomeController extends MainController
{

    public function index()
    {
        $this->title = 'Home';

        // Parametros da função
        $parametros = ( func_num_args() >= 1 ) ? func_get_arg(0) : array();


        require ABSPATH . '/views/_includes/header.php';

        require ABSPATH . '/views/_includes/menu.php';

        require ABSPATH . '/views/home/home-view.php';
        echo "<pre>";
        print_r($parametros);
        echo "</pre>";

        require ABSPATH . '/views/_includes/footer.php';
    }

}
