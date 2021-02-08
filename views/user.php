<?php

use app\core\Application;
?>

<div align="center">
    <div class="header" align="left">
        <?php echo $shots ? "S" : "No s";
              echo "hots by " . $user->nickname; ?>
        <div id="root"></div>
    </div>
</div>
<div id="container">
    <?php

    if ($shots) {
        $grid = Application::$app->templates->browse;
        $grid->begin();
        $grid->show($shots);
        $grid->end();
    }

    ?>
</div>
<?php if ($shots) : ?>
    <script type="text/babel" src="/views/js/postData.js"></script>
    <script type="text/babel" src="/views/js/SortForm.js"></script>
<?php endif; ?>