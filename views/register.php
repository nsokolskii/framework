<link type="text/css" rel="stylesheet" href="/views/stylesheets/post.css">
<div class="header">
Register
</div>
<?php $form = \app\core\form\Form::begin('', "post"); ?>
    <?php echo $form->field($model, 'nickname'); ?>
    <?php echo $form->field($model, 'email'); ?>
    <?php echo $form->field($model, 'invitationCode'); ?>
    <?php echo $form->field($model, 'password')->passwordField(); ?>
    <?php echo $form->field($model, 'confirmPassword')->passwordField(); ?>
    <button type="submit" class="btn btn-primary">Submit</button>
<?php echo \app\core\form\Form::end(); ?>