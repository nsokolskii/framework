<?php 
use app\core\Application;
?>
<link type="text/css" rel="stylesheet" href="/views/stylesheets/gr.css">
<link type="text/css" rel="stylesheet" href="/views/stylesheets/post.css">

<div align="center"><div class="header" align="left">Shots by <?php echo $user->nickname; ?><div id="root"></div></div></div>
<div id="container">

<?php
$grid = Application::$app->templates->browse;
$grid->show($shots);
?>
</div>
<script src="https://unpkg.com/react@17/umd/react.development.js" crossorigin></script>
<script src="https://unpkg.com/react-dom@17/umd/react-dom.development.js" crossorigin></script>
<script src="https://unpkg.com/babel-standalone@6/babel.min.js"></script>
<script type="text/babel" src="/views/js/asyncRequest.js"></script>
<script type="text/babel" src="/views/js/root.js"></script>
