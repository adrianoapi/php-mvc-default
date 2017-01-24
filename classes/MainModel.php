<?php

/**
 * MainModel - Modelo geral
 */
class MainModel
{

    public $form_data;
    public $form_msg;
    public $form_confirma;
    public $db;
    public $controller;
    public $parametros;
    public $userdata;

    /**
     * Inverte datas 
     *
     * Obtém a data e inverte seu valor.
     * De: d-m-Y H:i:s para Y-m-d H:i:s ou vice-versa.
     *
     * @since 0.1
     * @access public
     * @param string $data A data
     */
    public function inverte_data($data = null)
    {

        // Configura uma variável para receber a nova data
        $nova_data = null;

        // Se a data for enviada
        if ($data) {

            // Explode a data por -, /, : ou espaço
            $data = preg_split('/\-|\/|\s|:/', $data);

            // Remove os espaços do começo e do fim dos valores
            $data = array_map('trim', $data);

            // Cria a data invertida
            $nova_data .= chk_array($data, 2) . '-';
            $nova_data .= chk_array($data, 1) . '-';
            $nova_data .= chk_array($data, 0);

            // Configura a hora
            if (chk_array($data, 3)) {
                $nova_data .= ' ' . chk_array($data, 3);
            }

            // Configura os minutos
            if (chk_array($data, 4)) {
                $nova_data .= ':' . chk_array($data, 4);
            }

            // Configura os segundos
            if (chk_array($data, 5)) {
                $nova_data .= ':' . chk_array($data, 5);
            }
        }

        // Retorna a nova data
        return $nova_data;
    }
    
    public function paginacao()
    {

        /*
          Verifica se o primeiro parâmetro não é um número. Se for é um single
          e não precisa de paginação.
         */
        if (is_numeric(chk_array($this->parametros, 0))) {
            return;
        }

        // Obtém o número total de notícias da base de dados
        $query = $this->db->query(
                'SELECT COUNT(*) as total FROM noticias '
        );
        $total = $query->fetch();
        $total = $total['total'];

        // Configura o caminho para a paginação
        $caminho_noticias = HOME_URI . '/noticias/index/page/';

        // Itens por página
        $posts_per_page = $this->itens_por_pagina;

        // Obtém a última página possível
        $last = ceil($total / $posts_per_page);

        // Configura a primeira página
        $first = 1;

        // Configura os offsets
        $offset1 = 3;
        $offset2 = 6;

        // Página atual
        $current = $this->parametros[1] ? $this->parametros[1] : 1;

        // Exibe a primeira página e reticências no início
        if ($current > 4) {
            echo "<a href='$caminho_noticias$first'>[$first]</a> ... ";
        }

        // O primeiro loop toma conta da parte esquerda dos números
        for ($i = ( $current - $offset1 ); $i < $current; $i++) {
            if ($i > 0) {
                echo "&nbsp;<a href='$caminho_noticias$i'>[$i]</a>";

                // Diminiu o offset do segundo loop
                $offset2--;
            }
        }

        // O segundo loop toma conta da parte direita dos números
        // Obs.: A primeira expressão realmente não é necessária
        for (; $i < $current + $offset2; $i++) {
            if ($i <= $last) {
                echo "&nbsp;<a href='$caminho_noticias$i'>[$i]</a>";
            }
        }

        // Exibe reticências e a última página no final
        if ($current <= ( $last - $offset1 )) {
            echo " ... <a href='$caminho_noticias$last'>[$last]</a>";
        }
    }

}