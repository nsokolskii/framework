<div align="center"><div class="header" align="left">Shots</div></div>
<div id="res">
<?php

use app\core\Application;

$grid = Application::$app->templates->browse;
$grid->show($shots);
?>
</div>
<div align="center"><div class="header" align="center"><div id="loadMoreButton"></div></div>
<script type="text/babel" src="/views/js/asyncRequest.js"></script>
<script type="text/babel" src="/views/js/LoadMoreButton.js"></script>