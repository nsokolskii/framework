<div class="header">
    Log in
</div>
<?php

use app\core\Application;

$form = Application::$app->templates->form;
$form->begin('', "post");

?>
<?php $form->field($model, 'email'); ?>
<?php $form->field($model, 'password', 1); ?>
<a href="/restore">Restore password</a><br><br>
<button type="submit" class="btn btn-primary">Submit</button>
<?php $form->end(); ?>