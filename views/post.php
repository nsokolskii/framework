<?php

use app\core\Application;

$shot = Application::$app->templates->shot;
$shot->show($post);

?>
<div id="comments">
    <?php
    $grid = Application::$app->templates->comments;
    $grid->getCount($comments);
    $grid->begin();
    $grid->show($comments);
    $grid->end();

    ?>
</div>
<?php if (!Application::$app->service->isGuest()) : ?>

    <div id="commentForm"></div>

    <script type="text/babel" src="/views/js/returnBack.js"></script>
    <script type="text/babel" src="/views/js/postData.js"></script>
    <script type="text/babel" src="/views/js/Comment.js"></script>

<?php endif; ?>