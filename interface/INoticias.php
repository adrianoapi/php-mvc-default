<?php

interface INoticias
{

    public function getId();
    public function setId($id);
    public function getDate();
    public function setDate($date);
    public function getAutor();
    public function setAutor($autor);
    public function setTitulo($titulo);
    public function getTexto();
    public function setTexto($text);
    public function getImagem();
    public function setImagem($img);
}
