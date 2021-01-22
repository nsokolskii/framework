<?php

use app\core\Application;

$classesArgs = [
  'shots' => app\repository\PostEntry::class,
  'users' => app\repository\User::class
];

?>

<link type="text/css" rel="stylesheet" href="/views/stylesheets/post.css">
<div class="header">
Restore password, using repository
</div>
<?php $form = \app\core\form\Form::begin('', "post"); ?>
    <?php echo $form->field($model, 'email'); ?>
    <button type="submit" class="btn btn-primary">Continue</button>
<?php echo \app\core\form\Form::end(); ?>