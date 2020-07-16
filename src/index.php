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
$this->registerCssFile("@web/css/style.min.css", ["depends" => ["backend\\assets\\AppAsset"]]);

//weui
$this->registerCssFile("@web/css/weui.min.css", ["depends" => ["backend\\assets\\AppAsset"]]);
$this->registerJsFile("@web/js/weui.min.js", ["depends" => ["backend\\assets\\AppAsset"]]);

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
                            //'registerLinkTags' => true, //页面head上会生成当前页，下一个最后一页的信息link https://www.w3.org/TR/html401/struct/links.html#h-12.1.2
                        ]
                    ]); ?>
            </div>
        </div>
    </div>
    <?php Pjax::end(); ?>
</div>

<div id="containerss" style="display: none;">
    Click me to load content...
</div>

<?php $this->registerJs("
$(\".roadtrip\").one(\"click\", function(a) { //采用one就是绑定执行一次就结束了，如果有多个roadtrip元素的话，没有点击到的roadtrip还是可以执行事件的，很符合我们的要求
    //阻止事件冒泡到DOM树上
    a.stopPropagation();  //pic-1本身就在一个标签中，这个a标签外层还有一个a标签，这个a标签点击了是跳转到详情页去的
    //采用了微信的weuil来做提示效果
    var loading = weui.loading('loading', {
        className: 'custom-classname'
    });
    //console.log(this);
    $(\"#containerss\").load($(this).data('load')+\" .details-content\", function(response, status, xhr) { //jquery load方法事件
        //load() 方法从服务器加载数据，并把返回的数据放置到指定的元素中。
        //上面的意思是请求服务器获取内容，将内容中的.details-content区域内容替换掉#containerss的内容。如果服务器正常返回status=success,但是没有内容空内容或者返回的内容没有details-content的话，那么就替换空内容进#containerss中
        //console.log(response,status, xhr);
        $('.details-content a').trigger('click');
        //本来也试了$(response).find('.details-content a').trigger('click');但是最后没有很好的搭配效果，是因为$(response).find('.details-content a')找到的内容没有追加或者写入页面document中，是没有办法正常执行到trigger('click');的
        loading.hide(function() {
            console.log('`loading` has been hidden');
        });
        //最后将loading效果去除掉
    });
});
");?>