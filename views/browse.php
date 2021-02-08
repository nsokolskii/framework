<div id="routeCheck"><div align="center">
    <div class="header" align="left">Shots</div>
</div>
    <?php
    use app\core\Application;

    $grid = Application::$app->templates->browse;
    $grid->begin();
    $grid->show($shots);
    $grid->end();

    ?>

<div align="center">
    <div class="header" align="center">
        <div id="loadMoreButton"></div>
    </div>
</div>
</div>
<script type="text/babel" src="/views/js/getData.js"></script>
<script type="text/babel" src="/views/js/postData.js"></script>
<script type="text/babel" src="/views/js/LoadMoreButton.js"></script>