<div id="commentForm"></div>
<div id="searchRes">
<?php

use app\core\Application;

if($shots){
    echo '<div align="center">
    <div class="header" align="left">Shots</div>
    </div>';
    $grid = Application::$app->templates->browse;
    $grid->begin();
    $grid->show($shots);
    $grid->end();
}
else{
    echo "No shots found";
}
if($users){
    echo '<div align="center">
    <div class="header" align="left">Users</div>
    </div>';
    var_dump($users);
}
else{
    echo "No users found";
}

?></div>

<script type="text/babel" src="/views/js/getData.js"></script>
<script type="text/babel" src="/views/js/R.js"></script>
<script type="text/babel" src="/views/js/postData.js"></script>
<script type="text/babel" src="/views/js/LoadMoreButton.js"></script>
<script type="text/babel" src="/views/js/Search.js"></script>