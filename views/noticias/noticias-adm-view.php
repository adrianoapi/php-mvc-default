<?php
// Evita acesso direto a este arquivo
if (!defined('ABSPATH'))
    exit;

// Configura as URLs
$adm_uri = HOME_URI . '/noticias/adm/';
$edit_uri = $adm_uri . 'edit/';
$delete_uri = $adm_uri . 'del/';


// Carrega o método para obter uma notícia
$modelo->obtem_noticia();

// Carrega o método para inserir uma notícia
$modelo->insere_noticia();

// Carrega o método para apagar a notícia
$modelo->form_confirma = $modelo->apaga_noticia();

// Remove o limite de valores da lista de notícias
$modelo->sem_limite = true;
?>

<div class="wrap">

    <?php
    // Mensagem de configuração caso o usuário tente apagar algo
    echo $modelo->form_confirma;
    ?>

    <!-- Formulário de edição das notícias -->
    <form method="post" action="" enctype="multipart/form-data">
        <table class="table table-bordered">
            <tr>
                <td>
                    Título: <br>
                    <input type="text" name="noticia_titulo" value="<?php echo htmlentities(chk_array($modelo->form_data, 'noticia_titulo')); ?>" />
                </td>
            </tr>
            <tr>
                <td>
                    Imagem: <br>
                    <input type="file" name="noticia_imagem" value="" />
                </td>
            </tr>
            <tr>
                <td>
                    Data: <br>
                    <input type="text" name="noticia_data" value="<?php
                    $data = chk_array($modelo->form_data, 'noticia_data');
                    if ($data && $data != '0000-00-00 00:00:00') {
                        echo date('Y-m-d H:i:s', strtotime($data));
                    } else {
                        echo date('Y-m-d H:i:s');
                    }
                    ?>" />
                </td>
            </tr>
            <tr>
                <td>
                    Autor: <br>
                    <input type="text" name="noticia_autor" value="<?php
                    echo htmlentities($_SESSION['userdata']['user_name']);
                    ?>" />
                </td>
            </tr>
            <tr>
                <td>
                    Texto da notícia: <br>
                    <textarea name="noticia_texto"><?php
                        echo htmlentities(chk_array($modelo->form_data, 'noticia_texto'));
                        ?></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <?php echo $modelo->form_msg; ?>
                    <input type="submit" value="Save" />
                </td>
            </tr>
        </table>

        <input type="hidden" name="insere_noticia" value="1" />
    </form>

    <?php $lista = $modelo->listar_noticias(); ?>

    <table class="table table-bordered table-condensed table-striped">
        <tr>
            <th class="col-md-9">Título</th>
            <th class="col-md-3">Ação</th>
        </tr>
        <?php foreach ($lista as $noticia): ?>
            <tr>
                <td><?php echo $noticia['noticia_titulo'] ?></td>
                <td>
                    <a class="btn-sm btn-primary" href="<?php echo $edit_uri . $noticia['noticia_id'] ?>">
                        Editar
                    </a> 
                    &nbsp;
                    <a class="btn-sm btn-primary" href="<?php echo $delete_uri . $noticia['noticia_id'] ?>">
                        Apagar
                    </a>
                </td>
            </tr>

        <?php endforeach; ?>

    </table>

</div> <!-- .wrap -->
