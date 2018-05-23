
<h2 align="center"><? Редагування оцінок ?></h2>

<div class="subjects-buttons-col">

	$subjests = get_subjects();

	<?foreach($subjests as $item):?>

		<div><?=Html::a($item['name'], Yii::$app->urlManager->createUrl(['site/addmarks','subject' => $item['name']]),['class' => 'btn-default'])?></div>

	<?endforeach;?>

</div>

<?include($_SERVER['DOCUMENT_ROOT'].'/frontend/views/site/dyntab.php');?>