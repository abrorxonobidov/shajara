<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 25-Jul-20
 * Time: 15:20
 */

namespace common\components;


use common\models\base\LocalActiveRecord;
use yii\bootstrap\Html;

class HtmlHelper extends Html
{

    /**
     * @param $model LocalActiveRecord
     * @param $link string
     * @return string
     */
    public static function removeButton($model, $link = 'delete')
    {
        return
            Html::a(Html::icon('trash'), [$link, 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'title' => 'O‘chirish',
                'data' => [
                    'confirm' => 'Siz rostdan ham ushbu elementni o‘chirmoqchimisiz?',
                    'method' => 'post',
                ],]);
    }


    /**
     * @param $model LocalActiveRecord
     * @param $link string
     * @return string
     */
    public static function editButton($model, $link = 'update')
    {
        return Html::a(Html::icon('pencil'), [$link, 'id' => $model->id], ['class' => 'btn btn-primary', 'title' => 'Tahrirlash']);
    }


    /**
     * @param $title string
     * @param $link string
     * @param $target string
     * @return string
     */
    public static function createButton($title = 'Hosil qilish', $link = 'create', $target = '_blank')
    {
        return Html::a(Html::icon('plus'), [$link], ['class' => 'btn btn-success', 'title' => $title, 'target' => $target]);
    }
}