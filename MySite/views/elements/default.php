<?php if($match){ ?>

<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="/media/logo/logoBlack2.bmp" />
    <title><?= $title ?? 'Mon site' ?> </title>
    <link rel="stylesheet" href="/bootstrap-v4/bootstrap.min.css">
    <link rel="stylesheet" href="/css/customise.css">
    <link rel="stylesheet" href="/css/register.css">
    <link rel="stylesheet" href="/css/forum.css">
</head>

<body class="h-100">
    <header id="h-home" class="m-0 w-100 <?php if(isset($match)){ echo 'h-home-background';} ?> ">
        <div class="maskor m-0 pt-2">
            <div class="maskor-sup">
                <a href="#" class="m-0 p-0">
                    <span class="m-0 p-0">
                        <img src="/media/logo/logoBlack2Sans.png" alt="Mon Logo" width="200">
                    </span>
                </a>
                <nav class="navor navbar navbar-expand-lg navbar-dark mx-auto mb-2 px-5 py-0">
                    <a href=" <?php if(isset($match) && $match['name'] == 'Home'){echo "#";}else{echo $router->urlPut('Home');} ?> " class="navbar-brand px-3 m-0 mr-2 hover <?php if(isset($match) && $match['name'] == 'Home'){ echo "active";}?> ">Home</a>
                    <a href="#" class="navbar-brand px-3 m-0 mr-2 menu hover">Menu</a>
                    <a href="<?php if(isset($match) && $match['name'] == 'Forum'){echo "#";}else{echo $router->urlPut('Forum');}  ?>" class="navbar-brand px-3 m-0 mr-2 hover <?php if(isset($match) && ($match['name'] == 'Forum' || preg_match('/\/forum/', $match['target']) == 1)){ echo "active";}?> ">Forum</a>
                    <a href="#" class="navbar-brand px-3 m-0 mr-2 hover">Blog</a>
                    <a href="#" class="navbar-brand px-3 m-0 mr-2 hover">Contacts</a>
                </nav>
                <div class="loginer mx-0">
                    <?php if(!isset($_SESSION['id'])) {?>
                        <nav class="navbar navbar-expand-lg navbar-dark mx-0 mb-2">
                            <a href="<?= $router->urlPut('Login') ?>" class="navbar-brand px-3 mx-0 hover">Login/Register</a>
                        </nav>
                    <?php }else{ ?>
                        <nav class="navbar navbar-expand-lg navbar-dark mx-0 mb-2">
                            <a href="<?= $router->urlPut('LoginOut') ?>" class="navbar-brand px-3 mx-0 hover">Login out</a>
                        </nav>
                    <?php } ?>    
                </div>
                <div class="premiumer mx-0">
                    <?php if(isset($_SESSION['id']) && $_SESSION['id'] == 1){ ?>
                        <nav class="navbar navbar-expand-lg navbar-dark mx-0 mb-2">
                            <a href="<?php if(isset($match) && $match['name'] == 'Admin'){echo '#';}else{ echo $router->urlPut('Admin');}?>" class="navbar-brand px-3 mx-0 premiumer-link">Administrator</a>
                        </nav>
                    <?php }elseif(!isset($_SESSION['id']) || (isset($_SESSION['id']) && $_SESSION['id'] !== 1)){ ?>
                         <nav class="navbar navbar-expand-lg navbar-dark mx-0 mb-2">
                            <a href="#" class="navbar-brand px-3 mx-0 premiumer-link">Devenir Premium</a>
                        </nav>
                    <?php } ?>
                </div>
            </div>
            <?php if(isset($match) && $match['name'] == 'Home'){ ?>
            <div class="textor mx-auto text-white mt-5 text-center">
                <h3 class="text-center">
                    Bienvenue sur <a href="#"> ZtweN.com</a>!
                </h3>
                <div class="m-0 p-0">
                    <p class="mt-3 w-50">
                        Bien je ne sais quoi vous dire pour commencer, mais faites comme chez vous!
                        Et surtout n'oubliez pas de vous inscrire afin de benificier de plus de fonctionnalites du site.
                    </p>
                    <p class="w-50 ">
                         Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptas debitis culpa earum eligendi nobis soluta doloribus delectus accusantium id alias natus, iure dolor aperiam consequatur nulla, possimus commodi eius tempore.
                    </p>
                    <p class="w-50 planor">
                         <a href="#">Decouvrir le plan du site en 5s</a>
                     </p>
                </div>
                
            </div>
            <?php }elseif(isset($match) && $match['name'] !== 'Home' && $match['name'] !== null){ ?>
            <div class="container-contents">
                <div class="p-0 m-0 container-contents-show mr-1">
                    <p class="indicator">Vous etes ici <?= $_SERVER['REQUEST_URI']?></p>
                    <p class="px-2 text-white d-inline-block float-left">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. In, pariatur, autem. 
                    </p>
                   <?= $content ?>
                </div> 
                <div class="m-0 px-0 container-aside ml-1">
                    <?php require_once "layout_aside.php"; // on inclure ici la partie aside pour les actualités ?>
                </div>
            </div>

            <?php } ?>
            <div class="menu-activator display-none">
                <nav class=" w-100 m-0 p-0 text-center">
                    <a href="#" class="d-block w-100 py-2 mx-1">Menu1</a>
                    <a href="#" class="d-block w-100 py-2 mx-1">Menu2</a>
                    <a href="#" class="d-block w-100 py-2 mx-1">Menu3</a>
                </nav>
            </div>   
        </div>
    </header>
    <?php if((isset($match) && $match['name'] == 'Home' ) || $match == null){ ?>
    <div class="mb-1 container-show">
        <div class="container py-2">
            <?php 
                echo $content;
            ?>
        </div>
    </div>
    <?php } ?>
<p class="indicator-timer mb-auto text-info">Page générée en <?= rand(2, 7)."ms" ?></p>   
<footer class="footer mt-auto p-0">
    <div id="footer-maskor" class="px-3 py-2 m-0">
        <div class="d-flex m-0 p-0 w-100">
            <div class="footer-left w-50 px-3 py-0">
                <div class="m-0 p-0">
                    <h5>ZtweN-Oströgrasdki@</h5>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. At aspernatur, perferendis adipisci eligendi ea voluptatem dolores distinctio, earum officiis ab, excepturi enim necessitatibus alias amet natus iusto ipsum illo quasi!
                    </p>
                </div>
                <div class="mt-2 p-0">
                    <h5>Faites moi connaitre vos remarques concernant le site</h5>
                    <form action="" class="form-group w-75">
                        <label for="email" class="mb-0">Votre E-mail</label>
                        <input type="email" placeholder="Votre adresse mail" id="email" name="email" class="p-1 form-control">

                        <label for="comment" class="mb-0 mt-1">Votre Remarque</label>
                        <textarea name="comment" id="comment" cols="10" class="form-control p-1 d-inline-block"></textarea>
                        <button type="submit" class="btn btn-secondary d-inline-block float-right mt-1 w-25">Envoyez</button>
                    </form>
                </div>
            </div>
            <div class="footer-center w-33 px-3">
                <div class="c-header m-0 p-0 h-75">
                    <h5>Mes derniers tweets</h5>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos recusandae, officia sunt itaque molestias id eius modi quod iusto eaque, ducimus obcaecati suscipit facilis totam, minus asperiores voluptatum! Doloribus, error.
                    </p>
                </div>
                <div class="c-footer m-0 p-0">
                    <h5>Me suivre</h5>
                    <nav class="m-0 p-0 w-100">
                        <a href="#" class="facebook"></a>
                        <a href="#" class="twitter"></a>
                        <a href="#" class="instagram"></a>
                        <a href="#" class="youtube"></a>
                        <a href="#" class="gmail"></a>
                    </nav>
                </div>
            </div>
            <div class="footer-right">
                <h5>Me contacter</h5>
                <ul>
                    <li>
                        <a href="#">
                            <img src="/media/icons/mail2.png" alt="" width="18" class="mr-2">
                            Par email
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="/media/icons/group.png" alt="" width="18" class="mr-2">
                            Tchat
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="/media/icons/whatsApp.png" alt="" width="18" class="mr-2">
                            Whats'App
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="/media/icons/messenger.png" alt="" width="18" class="mr-2">
                            Messenger
                        </a>
                    </li>
                     <li>
                        <a href="#">
                            <img src="/media/icons/discord.png" alt="" width="18" class="mr-2">
                            Via Discord
                        </a>
                    </li>
                </ul>
                <div class="other">
                    <h5 class="mt-4">Divers</h5>
                    <ul>
                        <li>
                            <a href="#">
                                <img src="/media/icons/ps2.png" alt="" width="18" class="mr-2">
                                Jouer
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src="/media/icons/calendar-clock.png" alt="" width="18" class="mr-2">
                                Obtenir un entretien
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src="/media/icons/about1.png" alt="" width="18" class="mr-2">
                                A propos
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src="/media/icons/security.png" alt="" width="18" class="mr-2">
                                Politique de confidentialités
                            </a>
                        </li>
                    </ul>
                    <span class="m-0 p-0 logo d-inline-block float-right">
                        <img src="/media/logo/logoBlack2Sans.png" alt="" width="150" class="float-right">
                    </span>
                </div>
            </div>
        </div>
    </div>
</footer>
<script type="text/javascript" src="/js/query.js"></script>    
</body>
</html>
<?php }elseif($match == null){ require_once "default_404.php";} // On inclure ici la page par defaut 404?>
