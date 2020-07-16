<?php

use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PicsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pics';
$this->params['breadcrumbs'][] = $this->title;

//lightbox2
$this->registerCssFile("@web/css/lightbox.min.css", ["depends" => ["backend\\assets\\AppAsset"]]);
$this->registerJsFile("@web/js/lightbox.min.js", ["depends" => ["backend\\assets\\AppAsset"]]);

//import css style.css
$this->registerCssFile("@web/css/style.css", ["depends" => ["backend\\assets\\AppAsset"]]);
?>
<style type="text/css">
    .custompage{
        display: inline-block;
        padding-left: 20px;
        margin: 20px 0;
        border-radius: 4px;
    }
</style>
<div class="pics-index">
    <?php Pjax::begin([
        'timeout' => 3000,
    ]); ?>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="row">
        <div class="col-md-91 col-sm-12 box-main-content">
            <div class="layout-box clearfix">
                <div class="box-title">
                    <h3 class="m-0">亚洲图片</h3>
                    <div class="more pull-right"></div>
                </div>
                <ul class="box-topic-list p-0 clearfix" id="adlist"></ul>
                <ul class="box-topic-list p-0 clearfix">
                    <?= \yii\widgets\ListView::widget([
                        'dataProvider' => $dataProvider,
                        'options'=> ['tag' => false],
                        'itemView' => '_item',//子视图
                        'layout' => "{items}\n </ul><div class=\"box-page clearfix\" id=\"long-page\">{pager}</div>",
                        'itemOptions' => ['tag' => false],
                        'pager' => [
                            'class' => \common\widgets\XjPager::class,
                            //'template' => "{pageButtons} <div class=\"custompage\"> {customPage} {pageSize2} </div>\n {customPage2}",
                            'template' => "{pageButtons} <div class=\"custompage\"> {customPage} {pageSize} </div>\n {customPage2}",
                            'options' => ['id' => 'page6666'],
                            'filterRowOptions' => ['id' => 'page6666'],
                            'filterSelector' => 'input[name=page], select[name=per-page]',
                            'pageSizeOptions' => [
//                                'onchange' =>  new \yii\web\JsExpression('
//                                //获取下拉框选中的索引
//                                var index=this.selectedIndex;
//                                //console.log(index);
//			                      //拿到选中项的属性值
//                                var value=this[index].getAttribute("data-v");
//                                //console.log(value);
//                                if(value) window.location = value;
//                                return true;
//                            '),
                                'class' => 'form-control',
                                'style' => [
                                    'display' => 'inline-block',
                                    'width' => 'auto',
                                    'margin-top' => '0px',
                                ],
                            ],
                            'pageSizeList' => [10, 20, 30, 50],
                            'customPageWidth' => 50,
                            'customPageBefore' => ' Jump to ',
                            'customPageAfter' => ' Page ',
                            'registerLinkTags' => true, //页面head上会生成当前页，下一个最后一页的信息link https://www.w3.org/TR/html401/struct/links.html#h-12.1.2
                        ]
                    ]); ?>
            </div>
        </div>
    </div>
    <?php Pjax::end(); ?>
</div>