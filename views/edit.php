<div align="center"><div class="header" align="left">Edit a shot &nbsp;<span id="deleteButton"></span></div></div>
<div class="comments">

<?php

use app\core\Application;

$form = Application::$app->templates->form; 
$form->begin('', "post", "multipart/form-data");

?>

<label>Current picture</label>

<?php
echo sprintf("
<div align='center'>
<div class='postimage' style='background-image: url(%s%s); border-radius:5px'>
</div>
</div>
", 
'/runtime/img/',
$model->image
);
?>
<br>
<label>Replace current picture</label><br>
<input type="file" name="image">
    <span class="fileError">
    <?php if($fileModel->getError()): ?>
    <?php echo $fileModel->getError(); ?>
<?php endif; ?>
</span>
<?php $form->field($model, 'title'); ?>
<?php $form->field($model, 'description'); ?>
<button type="submit" class="btn btn-primary">Upload</button>
<?php $form->end(); ?>
</div>

<script type="text/babel" src="/views/js/DeleteButton.js"></script>