<link type="text/css" rel="stylesheet" href="/views/stylesheets/post.css">

<?php
echo sprintf("
<div class='posthead' align='center'>
<div class='postimage' style='background-image: url(%s%s);'>
</div>
<div class='postinfo' align='left'>
<div class='posttitle'>
%s
</div>
<div class='postdesc'>
%s
</div>
</div>
</div>
", 
'/runtime/img/',
$post['image'],
$post['title'],
$post['description']
);

$grid = new \app\core\grid\CommentGrid();
$n = count($comments);
$postfix = ($n == 1) ? '' : 's';
if($n){
    echo sprintf('<div align="center"><div class="header" align="left">%s comment%s:</div></div>', $n, $postfix);
}
else echo '<div align="center"><div class="header" align="left">No comments yet</div></div>';
$grid->begin($comments);
$grid->end();