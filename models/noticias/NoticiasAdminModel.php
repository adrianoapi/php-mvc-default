<?php

/**
 * Modelo para gerenciar notícias
 *
 */
class NoticiasAdminModel extends MainModel implements INoticias
{

    private $id;
    private $date;
    private $autor;
    private $titulo;
    private $texto;
    private $imagem;
    public $itens_por_pagina = 10;

    public function __construct($db = false, $controller = null)
    {
        $this->db = $db;
        $this->controller = $controller;
        $this->parametros = $this->controller->parametros;
        $this->userdata = $this->controller->userdata;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    public function getAutor()
    {
        return $this->autor;
    }

    public function setAutor($autor)
    {
        $this->autor = $autor;
        return $this;
    }

    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
        return $this;
    }

    public function getTexto()
    {
        return $this->texto;
    }

    public function setTexto($text)
    {
        $this->texto = $text;
        return $this;
    }

    public function getImagem()
    {
        return $this->imagem;
    }

    public function setImagem($img)
    {
        $this->imagem = $img;
        return $this;
    }

    public function getNoticia($id)
    {
        $where = " WHERE noticia_id = ? ";
        $query_limit = ' LIMIT 1';
        $query = $this->db->query(
                'SELECT * FROM noticias ' . $where . ' ORDER BY noticia_id DESC' . $query_limit, $id
        );
        return $query->fetchAll();
    }

    /**
     * Lista notícias
     *
     * @since 0.1
     * @access public
     * @return array Os dados da base de dados
     */
    public function listar_noticias()
    {

        // Configura as variáveis que vamos utilizar
        $id = $where = $query_limit = null;

        // Verifica se um parâmetro foi enviado para carregar uma notícia
        if (is_numeric(chk_array($this->parametros, 0))) {

            // Configura o ID para enviar para a consulta
            $id = array(chk_array($this->parametros, 0));

            // Configura a cláusula where da consulta
            $where = " WHERE noticia_id = ? ";
        }

        // Configura a página a ser exibida
        $pagina = !empty($this->parametros[1]) ? $this->parametros[1] : 1;

        // A páginação inicia do 0
        $pagina--;

        // Configura o número de posts por página
        $itens_por_pagina = $this->itens_por_pagina;

        // O offset dos posts da consulta
        $offset = $pagina * $itens_por_pagina;

        /*
          Esta propriedade foi configurada no NoticiasAdminModel.php para
          prevenir limite ou paginação na administração.
         */
        if (empty($this->sem_limite)) {

            // Configura o limite da consulta
            $query_limit = " LIMIT $offset,$itens_por_pagina ";
        }

        // Faz a consulta
        $query = $this->db->query(
                'SELECT * FROM noticias ' . $where . ' ORDER BY noticia_id DESC' . $query_limit, $id
        );

        // Retorna
        return $query->fetchAll();
    }

// listar_noticias

    /**
     * Obtém a notícia e atualiza os dados se algo for postado
     *
     * Obtém apenas uma notícia da base de dados para preencher o formulário de
     * edição.
     * Configura a propriedade $this->form_data.
     *
     * @since 0.1
     * @access public
     */
    public function obtem_noticia()
    {

        // Verifica se o primeiro parâmetro é "edit"
        if (chk_array($this->parametros, 0) != 'edit') {
            return;
        }

        // Verifica se o segundo parâmetro é um número
        if (!is_numeric(chk_array($this->parametros, 1))) {
            return;
        }

        // Configura o ID da notícia
        $noticia_id = chk_array($this->parametros, 1);

        /*
          Verifica se algo foi postado e se está vindo do form que tem o campo
          insere_noticia.

          Se verdadeiro, atualiza os dados conforme a requisição.
         */
        if ('POST' == $_SERVER['REQUEST_METHOD'] && !empty($_POST['insere_noticia'])) {

            // Remove o campo insere_notica para não gerar problema com o PDO
            unset($_POST['insere_noticia']);

            // Verifica se a data foi enviada
            $data = chk_array($_POST, 'noticia_data');

            /*
              Inverte a data para os formatos dd-mm-aaaa hh:mm:ss
              ou aaaa-mm-dd hh:mm:ss
             */
            $nova_data = $this->inverte_data($data);

            // Adiciona a data no $_POST		
            $_POST['noticia_data'] = $nova_data;

            // Tenta enviar a imagem
            $imagem = $this->upload_imagem();

            // Verifica se a imagem foi enviada
            if ($imagem) {
                // Adiciona a imagem no $_POST
                $_POST['noticia_imagem'] = $imagem;
            }

            // Atualiza os dados
            $query = $this->db->update('noticias', 'noticia_id', $noticia_id, $_POST);

            // Verifica a consulta
            if ($query) {
                // Retorna uma mensagem
                $this->form_msg = '<p class="success">Notícia atualizada com sucesso!</p>';
            }
        }

        // Faz a consulta para obter o valor
        $query = $this->db->query(
                'SELECT * FROM noticias WHERE noticia_id = ? LIMIT 1', array($noticia_id)
        );

        // Obtém os dados
        $fetch_data = $query->fetch();

        // Se os dados estiverem nulos, não faz nada
        if (empty($fetch_data)) {
            return;
        }

        // Configura os dados do formulário
        $this->form_data = $fetch_data;
    }

// obtem_noticia

    /**
     * Insere notícias
     *
     * @since 0.1
     * @access public
     */
    public function insere_noticia()
    {
        # Teste
//        die('<p>parou arqui!<p/>');
        /*
          Verifica se algo foi postado e se está vindo do form que tem o campo
          insere_noticia.
         */
        if ('POST' != $_SERVER['REQUEST_METHOD'] || empty($_POST['insere_noticia'])) {
            return;
        }

        /*
          Para evitar conflitos apenas inserimos valores se o parâmetro edit
          não estiver configurado.
         */
        if (chk_array($this->parametros, 0) == 'edit') {
            return;
        }

        // Só pra garantir que não estamos atualizando nada
        if (is_numeric(chk_array($this->parametros, 1))) {
            return;
        }

        // Tenta enviar a imagem
        $imagem = $this->upload_imagem();

        // Verifica se a imagem foi enviada
        if (!$imagem) {
            return;
        }

        // Remove o campo insere_notica para não gerar problema com o PDO
        unset($_POST['insere_noticia']);

        // Insere a imagem em $_POST
        $_POST['noticia_imagem'] = $imagem;

        // Configura a data
        $data = chk_array($_POST, 'noticia_data');
        $nova_data = $this->inverte_data($data);

        // Adiciona a data no POST
        $_POST['noticia_data'] = $nova_data;

        // Insere os dados na base de dados
        $query = $this->db->insert('noticias', $_POST);

        // Verifica a consulta
        if ($query) {

            // Retorna uma mensagem
            $this->form_msg = '<p class="success">Notícia atualizada com sucesso!</p>';
            return;
        }

        // :(
        $this->form_msg = '<p class="error">Erro ao enviar dados!</p>';
    }

// insere_noticia

    /**
     * Apaga a notícia
     *
     * @since 0.1
     * @access public
     */
    public function apaga_noticia()
    {

        // O parâmetro del deverá ser enviado
        if (chk_array($this->parametros, 0) != 'del') {
            return;
        }

        // O segundo parâmetro deverá ser um ID numérico
        if (!is_numeric(chk_array($this->parametros, 1))) {
            return;
        }

        // Para excluir, o terceiro parâmetro deverá ser "confirma"
        if (chk_array($this->parametros, 2) != 'confirma') {

            // Configura uma mensagem de confirmação para o usuário
            $mensagem = '<p class="alert">Tem certeza que deseja apgar a notícia?</p>';
            $mensagem .= '<p><a href="' . $_SERVER['REQUEST_URI'] . '/confirma/">Sim</a> | ';
            $mensagem .= '<a href="' . HOME_URI . '/noticias/adm/">Não</a></p>';

            // Retorna a mensagem e não excluir
            return $mensagem;
        }

        // Configura o ID da notícia
        $noticia_id = (int) chk_array($this->parametros, 1);

        // Executa a consulta
        $query = $this->db->delete('noticias', 'noticia_id', $noticia_id);

        // Redireciona para a página de administração de notícias
        echo '<meta http-equiv="Refresh" content="0; url=' . HOME_URI . '/noticias/adm/">';
        echo '<script type="text/javascript">window.location.href = "' . HOME_URI . '/noticias/adm/";</script>';
    }

// apaga_noticia

    /**
     * Envia a imagem
     *
     * @since 0.1
     * @access public
     */
    public function upload_imagem()
    {

        // Verifica se o arquivo da imagem existe
        if (empty($_FILES['noticia_imagem'])) {
            return;
        }

        // Configura os dados da imagem
        $imagem = $_FILES['noticia_imagem'];

        // Nome e extensão
        $nome_imagem = strtolower($imagem['name']);
        $ext_imagem = explode('.', $nome_imagem);
        $ext_imagem = end($ext_imagem);
        $nome_imagem = preg_replace('/[^a-zA-Z0-9]/', '', $nome_imagem);
        $nome_imagem .= '_' . mt_rand() . '.' . $ext_imagem;

        // Tipo, nome temporário, erro e tamanho
        $tipo_imagem = $imagem['type'];
        $tmp_imagem = $imagem['tmp_name'];
        $erro_imagem = $imagem['error'];
        $tamanho_imagem = $imagem['size'];

        // Os mime types permitidos
        $permitir_tipos = array(
            'image/bmp',
            'image/x-windows-bmp',
            'image/gif',
            'image/jpeg',
            'image/pjpeg',
            'image/png',
        );

        # Verifica se o mimetype enviado é permitido
//		if ( ! in_array( $tipo_imagem, $permitir_tipos ) ) {
//			// Retorna uma mensagem
//			$this->form_msg = '<p class="error">Você deve enviar uma imagem.</p>';
//			return;
//		}
        # Tenta mover o arquivo enviado
//		if ( ! move_uploaded_file( $tmp_imagem, UP_ABSPATH . '/' . $nome_imagem ) ) {
//			// Retorna uma mensagem
//			$this->form_msg = '<p class="error">Erro ao enviar imagem.</p>';
//			return;
//		}
        // Retorna o nome da imagem
        return $nome_imagem;
    }

// upload_imagem

}
