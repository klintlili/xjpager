<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Pics */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Pics', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
//import css style.css
$this->registerCssFile("@web/css/style.css", ["depends" => ["backend\\assets\\AppAsset"]]);
//import js lazyload.min.js 延迟加载图片
$this->registerJsFile("@web/js/lazyload.min.js", ["depends" => ["backend\\assets\\AppAsset"]]);

//回到顶部
$this->registerJs("
var offset = 100,
offset_opacity = 1200,
scroll_top_duration = 700,
\$back_to_top = $('.cd-top');
$(window).scroll(function(){
    ( $(this).scrollTop() > offset ) ? \$back_to_top.addClass('cd-is-visible') : \$back_to_top.removeClass('cd-is-visible cd-fade-out');
    if( $(this).scrollTop() > offset_opacity ) {
        \$back_to_top.addClass('cd-fade-out');
    }
});
//smooth scroll to top
\$back_to_top.on('click', function(event){
    event.preventDefault();
    $('body,html').animate({
        scrollTop: 0 ,
    }, scroll_top_duration);
});
", \yii\web\View::POS_END);

$this->registerCss("
.cd-top {
    position: fixed;
    right: 1%;
    bottom: -999px;
    z-index: 99999;
    width: 50px;
    height: 60px;
    background: url(/image/gotop.png) no-repeat center;
    background-size: contain;
    -webkit-transition: all .5s ease-in-out;
    transition: all .5s ease-in-out;
    cursor: pointer;
    opacity: 0;
}    
.cd-top.cd-is-visible {
    opacity: .7;
    bottom: 8%;
}

.cd-top.cd-fade-out {
    opacity: .85;
}

.cd-top:hover {
    opacity: 1;
}
.cd-top:hover {
    -webkit-animation: btn-pudding 2s linear;
    animation: btn-pudding 2s linear;
}

@media screen and (max-width: 860px) {
    .cd-top {
        height: 40px;
        width: 50px;
    }
}");
?>
<div class="pics-view">
    <div class="row">
        <div style="position:static">
            <div class="layout-box clearfix">
                <div class="news_details">
                    <h1 class="text-overflow"><?= $model->title; ?></h1>
                    <div class="news_top text-center text-overflow"><span>时间：<?= Yii::$app->formatter->asDatetime($model->created_at, 'php:Y/m/d H:i:s'); ?></span></div>
                </div>

                <div class="details-content text-justify">
                    <p>
                        <!--  <img class="lazy" src="/image/grey.gif" data-original="http://img.localwuma.net/2.jpg" /><br /> -->
                        <?php foreach ($model->picsDetails as $pic) : ?>
                            <img class="lazy" data-original="http://img.localwuma.net/2.jpg" /><br />
                        <?php endforeach; ?>
                    </p>
                </div>
                <div class="clearfix"></div>
                <?php if($model->prevOne || $model->nextOne) : ?>
                    <div class="details-page clearfix">
                        <ul class="clearfix">
                            <?php if($model->prevOne): ?>
                                <li class="col-md-6"><a class="text-overflow" href="<?= Url::to(['pics/view', 'id' => $model->prevOne->id]); ?>">上一篇：<?= $model->prevOne->title; ?> </a></li>
                            <?php endif; ?>
                            <?php if($model->nextOne): ?>
                                <li class="col-md-6"><a href="<?= Url::to(['pics/view', 'id' => $model->nextOne->id]); ?>">下一篇：<?= $model->nextOne->title; ?> </a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<a href="#" class="cd-top"></a>

<?php $this->registerJs('
    $("img.lazy").lazyload({
        no_fake_img_loader:true,
        effect : "fadeIn"
    });
');?>
