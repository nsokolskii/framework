<?php

use app\core\Application; 

?>
<div id="loadMoreCheck"></div>
<?php if (Application::$app->service->isGuest()) : ?>
    <div class="comments" style="padding-top:10px;">
        <?php
        $form = Application::$app->templates->form;
        $form->begin('', "post");
        ?>
        <?php $form->field($model, 'query'); ?>
        <button type="submit" class="btn btn-primary">Search</button>
        <?php $form->end(); ?>
    </div>

<?php else : ?>
    <div id="commentForm">
        <div id="searchField"></div>
    </div>
<?php endif; ?>

<div id="searchRes">
    <?php if ($shots) : ?>
        <div align="center">
            <div class="header" align="left">Shots </div>
        </div>
        <?php
        $grid = Application::$app->templates->browse;
        $grid->begin();
        $grid->show($shots);
        $grid->end();
        ?>
            
            <div align="center">
                <div id="loadMoreSearchButton"></div>
            </div>
            
    <?php else : ?>
        <div align="center">
            <div class="header" align="left" style="opacity: 0.5">No shots found</div>
        </div>
    <?php endif; ?>
    <?php if ($users) : ?>
        <div align="center">
            <div class="header" align="left">Users</div>
        </div>
        <?php
        $grid = Application::$app->templates->users;
        $grid->begin();
        $grid->show($users);
        $grid->end();
        ?>
    <?php else : ?>
        <div align="center">
            <div class="header" align="left" style="opacity: 0.5">No users found</div>
        </div>
    <?php endif; ?>
    <?php if ($comments) : ?>
        <div align="center">
            <div class="header" align="left">Comments</div>
        </div>
        <?php
        $grid = Application::$app->templates->commentsSearch;
        $grid->begin();
        $grid->show($comments);
        $grid->end();
        ?>
    <?php else : ?>
        <div align="center">
            <div class="header" align="left" style="opacity: 0.5">No users found</div>
        </div>
    <?php endif; ?>
</div>

<?php if (!Application::$app->service->isGuest()) : ?>
    <script type="text/babel" src="/views/js/getData.js"></script>
    <script type="text/babel" src="/views/js/R.js"></script>
    <script type="text/babel" src="/views/js/postData.js"></script>
    <script type="text/babel" src="/views/js/LoadMoreButton.js"></script>
    <script type="text/babel" src="/views/js/Search.js"></script>
<?php endif; ?>