<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\db\Connection;

/**
 * ContactForm is the model behind the contact form.
 */
class Marks extends Model
{
    /**
     * Load Subjects from adv
     */
    public function loadSubjects()
    {
        return Yii::$app->db->createCommand('SELECT * FROM subjects')
            ->queryAll();
    }

    /**
     * Load Lessons for current subject in adv
     */
    public function loadLessons($subject_id, $month_cid)
    {
        return Yii::$app->db->createCommand('SELECT * FROM lessons WHERE subjects_id=:id AND month_id=:mid ORDER BY day')
            ->bindValue(':id', $subject_id)
            ->bindValue(':mid', $month_cid)
            ->queryAll();
    }

    /**
     * Load Pupils from adv
     */
    public function loadPupils()
    {
        return Yii::$app->db->createCommand('SELECT * FROM pupils')
            ->queryAll();
    }

    /**
     * Fill in the Tab with pupils marks
     */
    public function addMark($pupil_id, $subjects_id, $day, $month_id)
    {
        return Yii::$app->db->createCommand('SELECT mark FROM marks WHERE pupils_id=:pid AND subjects_id=:sid AND day=:d AND month_id=:mid')
            ->bindValue(':pid', $pupil_id)
            ->bindValue(':sid', $subjects_id)
            ->bindValue(':d', $day)
            ->bindValue(':mid', $month_id)
            ->queryOne()['mark'];
    }

    /**
     * Get all current pupil marks to calculate the level
     */
    public function getLevel($pupil_id, $subjects_id)
    {
        $pupilmarks = Yii::$app->db->createCommand('SELECT mark FROM marks WHERE pupils_id=:pid AND subjects_id=:sid')
            ->bindValue(':pid', $pupil_id)
            ->bindValue(':sid', $subjects_id)
            ->queryAll();

        if(!$pupilmarks)
            return 0;

        $average = 0;
        $count = 0;
        foreach($pupilmarks as $mark):
            $average+= intval($mark['mark']);
            $count++;
        endforeach;

        return number_format($average/$count, 2);
    }

    /**
     * Add new lesson to DB adv
     */
    public function addLesson($subject_id, $day, $month_id, $theme)
    {
        $isInDb = Yii::$app->db->createCommand('SELECT id FROM lessons WHERE subjects_id=:sid AND day=:d AND month_id=:mid')
            ->bindValue(':sid', $subject_id)
            ->bindValue(':d', $day)
            ->bindValue(':mid', $month_id)
            ->queryOne();

         if(!$isInDb['id']) {
            Yii::$app->db->createCommand('UPDATE months SET lessons_present=1 WHERE calendar_count=:mid')
            ->bindValue(':mid', $month_id)
            ->execute();

            return Yii::$app->db->createCommand('INSERT INTO lessons ( theme, subjects_id, day, month_id) VALUES (:thm, :sid, :d, :mid)')
                ->bindValue(':thm', $theme)
                ->bindValue(':sid', $subject_id)
                ->bindValue(':d', $day)
                ->bindValue(':mid', $month_id)
                ->execute();
         }
    }

    /**
    * Check changes in marks's field and add to DB if necessary
    */
    public function saveMark($pupil_id, $subject_id, $mark, $day, $month_id)
    {
        $isInDb = Yii::$app->db->createCommand('SELECT id, mark FROM marks WHERE pupils_id=:pid AND subjects_id=:sid AND day=:d AND month_id=:mid')
            ->bindValue(':pid', $pupil_id)
            ->bindValue(':sid', $subject_id)
            ->bindValue(':d', $day)
            ->bindValue(':mid', $month_id)
            ->queryOne();

        if($isInDb['id']) {
            if($mark) {
                return Yii::$app->db->createCommand('UPDATE marks SET mark=:m WHERE pupils_id=:pid AND subjects_id=:sid AND day=:d AND month_id=:mid')
                    ->bindValue(':m', $mark)
                    ->bindValue(':pid', $pupil_id)
                    ->bindValue(':sid', $subject_id)
                    ->bindValue(':d', $day)
                    ->bindValue(':mid', $month_id)
                    ->execute();
            } else {
                return Yii::$app->db->createCommand('DELETE FROM marks WHERE id=:iid')
                    ->bindValue(':iid', $isInDb['id'])
                    ->execute();
            }
        } else {
            return $mark ? Yii::$app->db->createCommand('INSERT INTO marks ( pupils_id, subjects_id, day, month_id, mark) VALUES (:pid, :sid, :d, :mid, :m)')
                ->bindValue(':pid', $pupil_id)
                ->bindValue(':sid', $subject_id)
                ->bindValue(':d', $day)
                ->bindValue(':mid', $month_id)
                ->bindValue(':m', $mark)
                ->execute()
                : false;
        }
    }

    /**
     * Load Months for convenient grouping by month
     */
    public function loadMonths()
    {
        return Yii::$app->db->createCommand('SELECT * FROM months')
            ->queryAll();
    }

    /**
     * Get current month data from months
     */
    public function getCurrentMonth($month_num)
    {
        return Yii::$app->db->createCommand('SELECT * FROM months WHERE calendar_count=:mid LIMIT 1')
            ->bindValue(':mid', $month_num)
            ->query();
    }
}
