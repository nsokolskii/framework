<div align="center">
    <div class="header" align="left">Create a shot</div>
</div>
<div class="comments">
    <?php

    use app\core\Application;

    $form = Application::$app->templates->form;
    $form->begin('', "post", "multipart/form-data");

    ?>
    <input type="file" name="image">
    <span class="fileError">
        <?php if ($fileModel->getError()) : ?>
            <?php echo $fileModel->getError(); ?>
        <?php endif; ?>
    </span>
    <?php $form->field($model, 'title'); ?>
    <?php $form->field($model, 'description'); ?>
    <button type="submit" class="btn btn-primary">Upload</button>
    <?php $form->end(); ?>
</div>