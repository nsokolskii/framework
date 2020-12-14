<?php
use app\core\Application;
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <title>Dribbble-copy</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="/">Dribbble-copy</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="/browse">Shots<span class="sr-only"></span></a>
            
        </li>
        
        
        </ul>
        <ul class="navbar-nav ml-auto">
        <?php if(Application::isGuest()): ?>
        <a class="nav-link" href="/login">Log in<span class="sr-only"></span></a>
        <a class="nav-link" href="/register">Register<span class="sr-only"></span></a>
        <?php else: ?>
        <?php if(Application::$app->user->isAuthor()): ?>
          <button type="button" class="btn btn-primary" style="margin-right: 10px;">Post a shot</button>
        <?php endif; ?>
        <a class="nav-link" href="#"><?php echo Application::$app->user->getDisplayName(); ?><span class="sr-only"></span></a>
        <a class="nav-link" href="/logout">Log out<span class="sr-only"></span></a>
        <?php endif; ?>
        
        </ul>
    </div>
    </nav>
    <div class="container">
      <?php if(\app\core\Application::$app->session->getFlash('success')): ?>
      <div class="alert alert-success">
        <?php echo \app\core\Application::$app->session->getFlash('success'); ?>
      </div>
      <?php endif; ?>
    {{content}}
    </div>
   

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

  </body>
</html>
