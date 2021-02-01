<?php

use app\core\Application;

$shot = Application::$app->templates->shot;
$shot->show($post);

echo '<div id="comments">';
$grid = Application::$app->templates->comments;
$grid->getCount($comments);
$grid->show($comments);
echo '</div>';
?>
<?php if(!Application::isGuest()): ?>

<div id="commentForm"></div>

<script type="text/babel" src="/views/js/asyncRequest.js"></script>
<script type="text/babel" src="/views/js/Comment.js"></script>
<?php endif; ?>

