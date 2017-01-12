<?php

class ContatoController extends MainController
{

    public function index()
    {

        $modelo = $this->load_model('contato/ContatoModel');
        require_once ABSPATH . '/views/contato/contato-view.php';
    }

    public function contatoSubmit()
    {
        $input = filter_input_array(INPUT_POST,INPUT_DEFAULT);
    }

}
