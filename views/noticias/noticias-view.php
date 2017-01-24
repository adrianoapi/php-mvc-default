<?php
// Evita acesso direto a este arquivo
if (!defined('ABSPATH'))
    exit;
?>

<div class="wrap">

    <?php
// Número de posts por página
// Lista notícias
    $noticia = $modelo->getNoticia($modelo->parametros);
//    echo "<pre>";
//    print_r($noticia[0]['noticia_titulo']);
//    echo "</pre>";
    ?>

    <table class="table table-bordered">
        <tr>
                    <td>
                        <p>
                            <?php echo $modelo->inverte_data($noticia[0]['noticia_data']); ?> | 
                            <?php echo $noticia[0]['noticia_autor']; ?> 
                        </p>

                        <p>
                            <img src="<?php echo HOME_URI . '/views/_uploads/' . $noticia[0]['noticia_imagem']; ?>">
                        </p>
                        <?php echo $noticia[0]['noticia_texto']; ?>
                    </td>
                </tr>
    </table>
    <?php $modelo->paginacao(); ?>

</div> <!-- .wrap -->
