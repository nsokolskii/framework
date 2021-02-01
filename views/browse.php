<div align="center"><div class="header" align="left">Shots</div></div>

<?php

use app\core\Application;

$grid = Application::$app->templates->browse;
$grid->show($shots);
?>