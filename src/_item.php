<?php
/**
 * Created by PhpStorm.
 * User: klint
 * Date: 2020/7/15
 * Time: 11:24
 */

use yii\helpers\Url;
use yii\helpers\Html;

/* @var $model \backend\models\Pics */
?>
<li class="col-md-14 col-sm-16 col-xs-12 clearfix news-box">

    <a href="<?= Url::to(['/pics/view', 'id' => $model->id]); ?>" data-pjax="0" title="<?= $model->title; ?>" target="_blank">
        <span class="xslist text-bg-c"><?= $model->title; ?>
            <!--  如果当前列表也需要展示对应所有图片的话导致性能下降，最好还是详情页去展示图片-->
            <?php foreach ($model->picsDetails as $k => $pics) : ?>

                <?php if($k == 0) : ?>
<!--                    --><?php //echo Html::a(Html::img('/image/pic-1.png'), $pics->pic_url, ['data-lightbox' => 'roadtrip', 'data-title' => "$model->title<br />$pics->pic_url"]); ?>
                <?php else: ?>
<!--                    --><?php //echo Html::a(Html::img('/image/pic-1.png'), $pics->pic_url, ['style' => 'display: none;', 'data-lightbox' => 'roadtrip', 'data-title' => "$model->title<br />$pics->pic_url"]); ?>
                <?php endif; ?>
            <?php endforeach; ?>
<!--            //之前采用的是将每个主体下的所有图片都隐藏展示出来，这样做有好处与坏处，好处是可以一次浏览所有的图片，缺点是列表页一开始就加载了本来要详情里面去看的所有图片出来，拉高了运行时长和占用了资源-->
            <?= Html::a(Html::img('/image/pic-1.png'), 'javascript:void(0);', ['class' => 'roadtrip', 'data-load' => Url::to(['/pics/ajax', 'id' => $model->id])]);?>
            <font color="#808080"><?= Yii::$app->formatter->asDate($model->created_at, 'php:m-d') ?></font>
        </span>
    </a>
</li>
