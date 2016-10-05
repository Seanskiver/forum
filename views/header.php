<hmtl>
    <head>
        <title>Open Forum</title>
        <!--Materialize-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.7/css/materialize.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="../css/custom.css" rel="stylesheet">
    </head>
    
    <body class="blue-grey lighten-3">
        <nav class="blue-grey darken-4">
            <div class="nav-wrapper">
            <div class="container">
                <a href="http://www.simple-forum-seanskiver.c9users.io/" class="brand-logo">Simple Forum<i class="material-icons">announcement</i></a>

                <ul id="userDropdown" class="dropdown-content" >
                    <li><a href=".?action=add-post-form" class="blue-grey-text darken-4"> New Post</a></li>
                    <li><a href="#!" class="blue-grey-text darken-4">Profile</a></li>
                    <?php if ($_SESSION['admin'] == 1) : ?>
                        <li><a href=".?action=admin-controls" class="blue-grey-text darken-4">Admin Controls</a></li>
                    <?php endif; ?>
                    <li class="divider"></li>
                    <li><a href=".?action=logout" class="blue-grey-text darken-4">Logout</a></li>
                </ul>
                
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <?php if (isset($_SESSION['username'])) : ?>
                        <!--<li><a href="#!" class="dropdown-button" data-activates="userDropdown"><i class="material-icons right">arrow_drop_down</i></a></li>-->
                        <li><a class="dropdown-button" href="#!" data-activates="userDropdown" data-beloworigin="true"><b><?= $_SESSION['username'] ?></b><i class="material-icons right">arrow_drop_down</i></a></li>

                    <?php else : ?>
                        <li><a href=".?action=signup-form" class="btn  green darken-4">Sign up</a></li>
                        <li><a href=".?action=login-form">Login</a></li>
                    <?php endif; ?>
                </ul>
            </div>
            </div>
        </nav>
        <div class="container" id="">
