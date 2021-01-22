<link type="text/css" rel="stylesheet" href="/views/stylesheets/post.css">


<?php

use app\core\Application;

echo sprintf("
<div align='center'>
<div class='header'>
<div align='left'>
<a href='%s'>< go back</a>
</div>
</div>
</div>
", 
$backPath);
echo sprintf("
<div class='posthead' align='center'>
<div class='postimage' style='background-image: url(%s%s);'>
</div>
<div class='postinfo' align='left'>
<div class='posttitle'>
%s
</div>
<div class='username'>
<a href='/user/%s'>%s</a>
</div>
<div class='postdesc'>
%s
</div>
</div>
</div>
", 
'/runtime/img/',
$post->image,
$post->title,
$post->author,
$post->nickname,
$post->description
);

$n = count($comments);
$postfix = ($n == 1) ? '' : 's';
if($n){
    echo sprintf('<div align="center"><div class="header" align="left">%s comment%s:</div></div>', $n, $postfix);
}
else echo '<div align="center"><div class="header" align="left">No comments yet</div></div>';
$grid = Application::$app->templates->comments;
$grid->show($comments);

?>
<?php if(!Application::isGuest()): ?>
<?php 
$form = Application::$app->templates->form; 
$form::begin('', "post"); 
?>
    <?php $form->field($model, 'comment'); ?>
    <button type="submit" class="btn btn-primary">Comment</button>
<?php $form::end(); ?>
<?php endif; ?>