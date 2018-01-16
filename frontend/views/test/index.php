<?php

use yii\helpers\Html;

?>
<h1>Загрузка файла и обработка оплаты</h1>

<p>
<?php if ($uploaded): ?>
<?php echo Html::beginForm('/test/pay', 'post', ['enctype' => 'multipart/form-data']); ?>
<p> Файл "<? echo $model->file; ?>" успешно загружен.</p>
<?php echo Html::hiddenInput('filename', $filename) ?>
<?php echo Html::submitButton('Оплатить'); ?>
<?php Html::endForm(); ?>
<?php else: ?>

<?php echo Html::beginForm('', 'post', ['enctype' => 'multipart/form-data']); ?>
<?php echo Html::error($model, 'file'); ?>
<?php echo Html::activeFileInput($model, 'file'); ?>

<?php echo Html::submitButton('Upload'); ?>
<?php Html::endForm(); ?>
<?php endif; ?>

</p>