<link type="text/css" rel="stylesheet" href="/views/stylesheets/gr.css">
<link type="text/css" rel="stylesheet" href="/views/stylesheets/post.css">
<div align="center"><div class="header" align="left">Shots</div></div>
<div class="container">
<?php
$grid = new \app\core\grid\BrowseGrid();
$grid->begin($shots);
$grid->end();
?>
</div>