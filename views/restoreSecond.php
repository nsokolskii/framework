<div class="header">
Enter a new password
</div>
<?php 

use app\core\Application;

$form = Application::$app->templates->form; 
$form->begin('', "post"); 
?>
    <?php $form->field($model, 'password', 1); ?>
    <?php $form->field($model, 'confirmPassword', 1); ?>
    <button type="submit" class="btn btn-primary">Submit</button>
<?php $form->end(); ?>