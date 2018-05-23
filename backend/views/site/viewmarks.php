<?php
namespace backend\views;

use Yii;
use backend\models\Marks;
use yii\helpers\Html;


$current_month_reader = $_GET['m'] ? $marks->getCurrentMonth($_GET['m']) : $marks->getCurrentMonth(date("m"));
$current_month = $current_month_reader->readAll()[0];
?>

<h2 align="center"><?=$current_month['native_name']?></h2>

<div class="subjects-buttons-col">

	<?
	$subjects = $marks->loadSubjects();

	$months = $marks->loadMonths();

	foreach($subjects as $subject):?>

		<div id="<?=$subject['id']?>" class="subject-button <?=($subject['id']==$_GET['subject'])?"bold":""?>"><?=Html::a($subject['display_name'], Yii::$app->urlManager->createUrl(['site/viewmarks','subject' => $subject['id'], 'm' => $_GET['m'] ? $_GET['m'] : $current_month['native_name']],['class' => 'btn-default']))?></div>

	<?endforeach;?>

	<div class="pull-left">
	    <select class="form-control month-select" id="sel1">
		<?foreach($months as $month):

			if($month['lessons_present']) {?>

				<option <?=($month['id']==$current_month['id'])?"selected":""?> value="<?=$_GET['subject']."-".$month['calendar_count']?>"><?=$month['native_name']?></option>

			<?}
		endforeach;?>
	   </select>
	</div>

</div>

<div class="marks-tab-col">

<?
	$lessons = $marks->loadLessons($_GET['subject'], $current_month['calendar_count']);
	$lessonsCount = 0;
	$pupils = $marks->loadPupils();
?>

	<table class="table table-striped table-bordered">
		<tr class="marks-dates-list">

			<td id="lesson-0" class="marks-dates">#</td>
			<?foreach($lessons as $lesson):?>

				<td id="<?="lesson-".($lessonsCount+1)?>" class="marks-dates"><?=$lesson['day'] . "." . $lesson['month_id']?></td>

			<? $lessonsCount++;
			endforeach;?>

			<td>Рейтинг</td>

		</tr>

		<?foreach($pupils as $pupil):?>

			<tr class="pupil-marks-list">

				<td id="<?=$pupil['id']?>" class="pupil-name"><?=$pupil['name'] . ' ' . $pupil['surname']?></td>

				<?for($i = 0; $i < $lessonsCount; $i++) {?>

					<td><?=$marks->addMark($pupil['id'], $_GET['subject'], $lessons[$i]['day'], $_GET['m'])?></td>

				<?}?>

				<td><?=$marks->getLevel($pupil['id'], $_GET['subject'])?></td>

			</tr>

		<?endforeach;?>

	</table>

</div>

<script>
	$(".container").css("width", "80% !important");
</script>

