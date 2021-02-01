<?php 
use app\core\Application;
?>

<div align="center"><div class="header" align="left"><?php echo $shots ? "S" : "No s"; echo "hots by ".$user->nickname; ?><div id="root"></div></div></div>
<div id="container">

<?php
if($shots){
    $grid = Application::$app->templates->browse;
    $grid->show($shots);
}

?>
</div>
<?php if($shots): ?>
<script type="text/babel" src="/views/js/asyncRequest.js"></script>
<script type="text/babel" src="/views/js/root.js"></script>
<?php endif; ?>