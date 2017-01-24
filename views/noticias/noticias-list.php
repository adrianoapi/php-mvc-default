<?php
// Evita acesso direto a este arquivo
if (!defined('ABSPATH'))
    exit;
?>

<div class="wrap">

    <?php
//    $modelo->posts_por_pagina = 10;
    $lista = $modelo->listar_noticias();
    ?>

    <table class="table table-bordered">
        <?php foreach ($lista as $noticia): ?>
            <tr>
                <td>
                    <a href="<?php echo HOME_URI ?>/noticias/visualizar/<?php echo $noticia['noticia_id'] ?>">
                        <?php echo $noticia['noticia_titulo'] ?>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php $modelo->paginacao(); ?>

</div> <!-- .wrap -->
