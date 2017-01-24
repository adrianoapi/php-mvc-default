<?php

class DB
{

    public $host = 'localhost',
            $db_name = 'lab_mvc_default',
            $password = '',
            $user = 'root',
            $charset = 'utf8',
            $pdo = null,
            $error = null,
            $debug = false,
            $last_id = null;

    /**
     * Construtor da classe
     *
     * @since 0.1
     * @access public
     * @param string $host     
     * @param string $db_name
     * @param string $password
     * @param string $user
     * @param string $charset
     * @param string $debug
     */
    public function __construct(
    $host = null, $db_name = null, $password = null, $user = null, $charset = null, $debug = null
    )
    {
        $this->host = defined('HOSTNAME') ? HOSTNAME : $this->host;
        $this->db_name = defined('DB_NAME') ? DB_NAME : $this->db_name;
        $this->password = defined('DB_PASSWORD') ? DB_PASSWORD : $this->password;
        $this->user = defined('DB_USER') ? DB_USER : $this->user;
        $this->charset = defined('DB_CHARSET') ? DB_CHARSET : $this->charset;
        $this->debug = defined('DEBUG') ? DEBUG : $this->debug;

        $this->connect();
    }

// __construct

    /**
     * Cria a conexão PDO
     *
     * @since 0.1
     * @final
     * @access protected
     */
    final protected function connect()
    {

        /* Os detalhes da nossa conexão PDO */
        $pdo_details = "mysql:host={$this->host};";
        $pdo_details .= "dbname={$this->db_name};";
        $pdo_details .= "charset={$this->charset};";

        // Tenta conectar
        try {

            $this->pdo = new PDO($pdo_details, $this->user, $this->password);

            // Verifica se devemos debugar
            if ($this->debug === true) {

                // Configura o PDO ERROR MODE
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            }

            unset($this->host);
            unset($this->db_name);
            unset($this->password);
            unset($this->user);
            unset($this->charset);
        } catch (PDOException $e) {
            if ($this->debug === true) {
                echo "Erro: " . $e->getMessage();
            }
            die();
        }
    }

    /**
     * query - Consulta PDO
     *
     * @since 0.1
     * @access public
     * @return object|bool Retorna a consulta ou falso
     */
    public function query($stmt, $data_array = null)
    {

        // Prepara e executa
        $query = $this->pdo->prepare($stmt);
        $check_exec = $query->execute($data_array);

        // Verifica se a consulta aconteceu
        if ($check_exec) {
            return $query;
        } else {
            $error = $query->errorInfo();
            $this->error = $error[2];
            return false;
        }
    }

    /**
     * insert - Insere valores
     *
     * Insere os valores e tenta retornar o último id enviado
     *
     * @since 0.1
     * @access public
     * @param string $table O nome da tabela
     * @param array ... Ilimitado número de arrays com chaves e valores
     * @return object|bool Retorna a consulta ou falso
     */
    public function insert($table)
    {
        // Configura o array de colunas
        $cols = array();

        // Configura o valor inicial do modelo
        $place_holders = '(';

        // Configura o array de valores
        $values = array();

        // O $j will assegura que colunas serão configuradas apenas uma vez
        $j = 1;

        // Obtém os argumentos enviados
        $data = func_get_args();

        // É preciso enviar pelo menos um array de chaves e valores
        if (!isset($data[1]) || !is_array($data[1])) {
            return;
        }

        // Faz um laço nos argumentos
        for ($i = 1; $i < count($data); $i++) {

            // Obtém as chaves como colunas e valores como valores
            foreach ($data[$i] as $col => $val) {

                // A primeira volta do laço configura as colunas
                if ($i === 1) {
                    $cols[] = "`$col`";
                }

                if ($j <> $i) {
                    // Configura os divisores
                    $place_holders .= '), (';
                }

                // Configura os place holders do PDO
                $place_holders .= '?, ';

                // Configura os valores que vamos enviar
                $values[] = $val;

                $j = $i;
            }

            // Remove os caracteres extra dos place holders
            $place_holders = substr($place_holders, 0, strlen($place_holders) - 2);
        }

        // Separa as colunas por vírgula
        $cols = implode(', ', $cols);

        // Cria a declaração para enviar ao PDO
        $stmt = "INSERT INTO `$table` ( $cols ) VALUES $place_holders) ";

        // Insere os valores
        $insert = $this->query($stmt, $values);

        // Verifica se a consulta foi realizada com sucesso
        if ($insert) {

            // Verifica se temos o último ID enviado
            if (method_exists($this->pdo, 'lastInsertId') && $this->pdo->lastInsertId()
            ) {
                // Configura o último ID
                $this->last_id = $this->pdo->lastInsertId();
            }

            // Retorna a consulta
            return $insert;
        }

        return;
    }

// insert

    /**
     * Update simples
     *
     * Atualiza uma linha da tabela baseada em um campo
     *
     * @since 0.1
     * @access protected
     * @param string $table Nome da tabela
     * @param string $where_field WHERE $where_field = $where_field_value
     * @param string $where_field_value WHERE $where_field = $where_field_value
     * @param array $values Um array com os novos valores
     * @return object|bool Retorna a consulta ou falso
     */
    public function update($table, $where_field, $where_field_value, $values)
    {

        if (empty($table) || empty($where_field) || empty($where_field_value)) {
            return;
        }

        $stmt = " UPDATE `$table` SET ";
        $set = array();
        $where = " WHERE `$where_field` = ? ";

        if (!is_array($values)) {
            return;
        }

        foreach ($values as $column => $value) {
            $set[] = " `$column` = ?";
        }


        $set = implode(', ', $set);
        $stmt .= $set . $where;
        $values[] = $where_field_value;

        $values = array_values($values);
        
//        print_r($stmt);
//        echo "<br/>";
//        print_r($values);
//        die();

        $update = $this->query($stmt, $values);

        if ($update) {
            return $update;
        }

        return;
    }

// update

    /**
     * Delete
     *
     * Deleta uma linha da tabela
     *
     * @since 0.1
     * @access protected
     * @param string $table Nome da tabela
     * @param string $where_field WHERE $where_field = $where_field_value
     * @param string $where_field_value WHERE $where_field = $where_field_value
     * @return object|bool Retorna a consulta ou falso
     */
    public function delete($table, $where_field, $where_field_value)
    {
        // Você precisa enviar todos os parâmetros
        if (empty($table) || empty($where_field) || empty($where_field_value)) {
            return;
        }

        $stmt = " DELETE FROM `$table` ";
        $where = " WHERE `$where_field` = ? ";
        $stmt .= $where;

        // O valor que vamos buscar para apagar
        $values = array($where_field_value);

        // Apaga
        $delete = $this->query($stmt, $values);

        // Verifica se a consulta está OK
        if ($delete) {
            // Retorna a consulta
            return $delete;
        }
        return;
    }

// delete
}

// Class TutsupDB