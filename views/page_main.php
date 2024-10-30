<!DOCTYPE html>
<html>
    <head>
   
        <link rel="stylesheet" type="text/css" href="<?php echo SITE_ROOT?>css/main_style.css">
        
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>S.O.S. Vízvezeték szervíz</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- bootstrap css -->
      <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
      <!-- style css -->
      <link rel="stylesheet" type="text/css" href="css/style.css">
      <!-- Responsive-->
      <link rel="stylesheet" href="css/responsive.css">
      <!-- fevicon -->
      <link rel="icon" href="images/fevicon.png" type="image/gif" />
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <!-- fonts -->
      <link href="https://fonts.googleapis.com/css?family=Dancing+Script:400,700|Poppins:400,700&display=swap" rel="stylesheet">
      <!-- owl stylesheets --> 
      <link rel="stylesheet" href="css/owl.carousel.min.css">
      <link rel="stylesheet" href="css/owl.theme.default.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
      <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

      <?php if($viewData['style']) echo '<link rel="stylesheet" type="text/css" href="'.$viewData['style'].'">'; ?>   
    </head>
    <body>
    <div class="header_top_section">
        <div class="container">
            <div class="row">
               <div class="col-sm-12">
                    <div class="header_top_main">
                        <div id="user"><em><?= $_SESSION['userlastname']." ".$_SESSION['userfirstname'] ?></em>
                        </div>
                        <h1 >Web-programozás II - MVC alkalmazás</h1>
                    </div>
               </div>
            </div>
         </div>
    </div>
            <!-- header top section end -->
      <!-- header section start -->

<div class="header_section">
    <div class="container">
        <nav class="">
        <a class="navbar-brand"href="index.php"><img src="images/logo.png"></a>
               <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
               </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
               
            
            <form class="form-inline my-2 my-lg-0"> 
                                 </form>
               </div >
                    <div class="custom_bg">
                        <div class="custom_menu">
                            <?php echo Menu::getMenu($viewData['selectedItems']); ?>

                        </div >
                        <form class="form-inline my-2 my-lg-0">
                            <div class="search_btn">
                                <li><a href="#"><i class="fa fa-user" aria-hidden="true"></i><span class="signup_text">Login</span></a></li>
                                <li><a href="#"><i class="fa fa-user" aria-hidden="true"></i><span class="signup_text">Sign Up</span></a></li>
                                <li><a href="#"><i class="fa fa-search" aria-hidden="true"></i></a></li>
                            </div>
                        </form>
                    </div>
</div>
         <!-- header section end -->
         <!-- banner section start --> 
<div class="banner_section layout_padding">
            <div class="container">
               <div class="row">
                  <div class="col-md-12">
                     
                     <?php if($viewData['render']) include($viewData['render']); ?>
                     
                  </div>
               </div>
            </div>
         
         
            
</div>
        <!-- banner section end -->
        <footer>&copy; NJE - GAMF - Informatika Tanszék <?= date("Y") ?></footer>
    </body>
</html>
