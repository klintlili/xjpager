<?php
/**
 * Created by PhpStorm.
 * User: klint
 * Date: 2020/7/16
 * Time: 16:47
 */
use yii\helpers\Html;

/* @var $model \backend\models\Pics */
?>
<div class="details-content">
<?php foreach ($model->picsDetails as $pics) : ?>
    <?= Html::a(Html::img('/image/pic-1.png'), $pics->pic_url, ['data-lightbox' => 'roadtrip', 'data-title' => "$model->title<br />$pics->pic_url"]); ?>
<?php endforeach; ?>
    </div>
