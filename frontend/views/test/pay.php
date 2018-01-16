<?php

use yii\helpers\Html;

?>
<h1>Оплат обработано: <? echo count($results); ?></h1>

<p>
<?
foreach ($results as $result) {
	echo $result.'<br>';
}

?>
</p>
