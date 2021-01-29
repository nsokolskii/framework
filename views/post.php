<link type="text/css" rel="stylesheet" href="/views/stylesheets/post.css">
<link type="text/css" rel="stylesheet" href="/views/stylesheets/gr.css">


<?php

use app\core\Application;

echo sprintf("
<div align='center'>
<div class='header'>
<div align='left'>
<a href='#' onClick='history.go(-1);'>< go back</a>&nbsp;
%s
</div>
</div>
</div>
", 
Application::$app->user->id == $post->author ? '<a href="/edit/'.$post->id.'" class="btn btn-primary">Edit post</a>' : "");
echo sprintf("
<div class='posthead' align='center'>
<div class='postimage' style='background-image: url(%s%s);'>
</div>
<div class='postinfo' align='left'>
<div class='posttitle'>
%s
</div>
<div class='username'>
<a href='/user/%s'>%s</a> <span class='created_at'> | %s</span>
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
$post->time_elapsed_string($post->created_at),
$post->description
);

echo '<div id="comments">';
$grid = Application::$app->templates->comments;
$grid->getCount($comments);
$grid->show($comments);
$grid->end();
echo '</div>';
?>
<?php if(!Application::isGuest()): ?>
<div class="comments">
<div id="commentForm"></div>
</div>
<script src="https://unpkg.com/react@17/umd/react.development.js" crossorigin></script>
<script src="https://unpkg.com/react-dom@17/umd/react-dom.development.js" crossorigin></script>
<script src="https://unpkg.com/babel-standalone@6/babel.min.js"></script>
<script type="text/babel" src="/views/js/asyncRequest.js"></script>
<script type="text/babel" src="/views/js/Comment.js"></script>
<?php endif; ?>

