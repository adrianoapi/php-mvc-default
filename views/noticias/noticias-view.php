<?php
if (!defined('ABSPATH'))
    exit;
?>

<div class="wrap">

    <?php
    $noticia = $modelo->getNoticia($modelo->parametros);
//    echo "<pre>";
//    print_r($noticia);
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

</div> <!-- .wrap -->
