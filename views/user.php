<link type="text/css" rel="stylesheet" href="/views/stylesheets/gr.css">
<link type="text/css" rel="stylesheet" href="/views/stylesheets/post.css">
<div align="center"><div class="header" align="left">Shots by <?php echo $user; ?></div></div>
<div class="container">
<?php

use app\core\Application;

$grid = Application::$app->templates->browse;
$grid->show($shots);
?>
</div>