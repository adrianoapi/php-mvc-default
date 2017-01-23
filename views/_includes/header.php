<?php if (!defined('ABSPATH')) exit; ?>

<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" lang="pt-BR">
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" lang="pt-BR">
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html lang="pt-BR">
    <!--<![endif]-->

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <link rel="stylesheet" href="<?php echo HOME_URI; ?>/views/_css/bootstrap.css" media="screen">
        <link rel="stylesheet" href="<?php echo HOME_URI; ?>/views/_css/custom.min.css">
        <!--[if lt IE 9]>
        <script src="<?php echo HOME_URI; ?>/views/_js/scripts.js"></script>
        <![endif]-->

        <title><?php echo $this->title; ?></title>
    </head>
    <body>

        <div class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <a href="../" class="navbar-brand">MVC Defalut</a>
                    <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="navbar-collapse collapse" id="navbar-main">
                    <ul class="nav navbar-nav">
                        <li><a href="<?php echo HOME_URI; ?>">Home</a></li>
                        <li><a href="<?php echo HOME_URI; ?>/login/">Login</a></li>
                        <li><a href="<?php echo HOME_URI; ?>/user-register/">User Register</a></li>
                        <li><a href="<?php echo HOME_URI; ?>/noticias/">Notícias</a></li>
                        <li><a href="<?php echo HOME_URI; ?>/noticias/adm/">Notícias Admin</a></li>
                        <li><a href="<?php echo HOME_URI; ?>/contato/">Contato</a></li>
                        <li><a href="<?php echo HOME_URI; ?>/login/sair/">Sair</a></li>
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#" target="_blank">Perfil</a></li>
                    </ul>

                </div>
            </div>
        </div>

        <p>&nbsp;</p>

        <div class="container">