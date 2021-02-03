<div class="header">
    Restore password
</div>
<?php

use app\core\Application;

$form = Application::$app->templates->form;
$form->begin('', "post");

?>

<?php $form->field($model, 'email'); ?>
<button type="submit" class="btn btn-primary">Continue</button>

<?php $form->end(); ?>