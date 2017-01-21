<?php

class ContatoController extends MainController {

    public function index() {

        $modelo = $this->load_model('contato/ContatoModel');
        require ABSPATH . '/views/_includes/header.php';
        require ABSPATH . '/views/_includes/menu.php';
        require_once ABSPATH . '/views/contato/contato-view.php';
        require ABSPATH . '/views/_includes/footer.php';
    }

    public function contatoSubmit() {
        $input = filter_input_array(INPUT_POST, INPUT_DEFAULT);
    }

}
