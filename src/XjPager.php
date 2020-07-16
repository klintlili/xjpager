<?php
/**
 * Created by PhpStorm.
 * User: klint
 * Date: 2020/7/15
 * Time: 11:38
 */

namespace common\widgets;

use Yii;
use yii\grid\GridViewAsset;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\widgets\LinkPager;

class XjPager extends LinkPager
{
    public $options = [];
    public $lastPageLabel = '尾页';
    public $disableCurrentPageButton = true;
    public $pageCssClass = 'hidden-xs';
    public $firstPageLabel = '首页';
    public $prevPageLabel = '上一页';
    public $nextPageLabel = '下一页';
    
    /**
     * {pageButtons} {customPage} {pageSize} {customPage2}
     */
    public $template = '{pageButtons}<div class="form-inline">{customPage}</div>';

    /**
     * pageSize list
     */
    public $pageSizeList = [10, 20, 30, 50];

    /**
     *
     * Margin style for the  pageSize control
     */
    public $pageSizeMargin = [
        'margin-left' => '5px',
        'margin-right' => '5px',
    ];

    /**
     * customPage width
     */
    public $customPageWidth = 50;

    /**
     * Margin style for the  customPage control
     */
    public $customPageMargin = [
        'margin-left' => '5px',
        'margin-right' => '5px',
    ];

    /**
     * Jump
     */
    public $customPageBefore = '';
    /**
     * Page
     */
    public $customPageAfter = '';

    /**
     * @var array the HTML attributes for the filter row element.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $filterRowOptions = ['class' => 'filters'];

    /**
     * @var bool whatever to apply filters on losing focus. Leaves an ability to manage filters via yiiGridView JS
     * @since 2.0.16
     */
    public $filterOnFocusOut = true;

    /**
     * @var string|array the URL for returning the filtering result. [[Url::to()]] will be called to
     * normalize the URL. If not set, the current controller action will be used.
     * When the user makes change to any filter input, the current filtering inputs will be appended
     * as GET parameters to this URL.
     */
    public $filterUrl;

    /**
     * @var string additional jQuery selector for selecting filter input fields
     */
    public $filterSelector;

    /**
     * pageSize style
     */
    public $pageSizeOptions = [
        'class' => 'form-control',
        'style' => [
            'display' => 'inline-block',
            'width' => 'auto',
            'margin-top' => '0px',
        ],
    ];

    /**
     * customPage style
     */
    public $customPageOptions = [
        'class' => 'form-control',
        'style' => [
            'display' => 'inline-block',
            'margin-top' => '0px',
        ],
    ];

    public function init()
    {
        parent::init();

        if ($this->pageSizeMargin) {
            Html::addCssStyle($this->pageSizeOptions, $this->pageSizeMargin);
        }
        if ($this->customPageWidth) {
            Html::addCssStyle($this->customPageOptions, 'width:' . $this->customPageWidth . 'px;');
        }
        if ($this->customPageMargin) {
            Html::addCssStyle($this->customPageOptions, $this->customPageMargin);
        }

        if (!isset($this->filterRowOptions['id'])) {
            $this->filterRowOptions['id'] = $this->options['id'] . '-filters';
        }
    }

    /**
     * Executes the widget.
     * This overrides the parent implementation by displaying the generated page buttons.
     */
    public function run()
    {
        if ($this->registerLinkTags) {
            $this->registerLinkTags();
        }
        echo $this->renderPageContent();

        $view = $this->getView();
        GridViewAsset::register($view);
        $id = $this->options['id'];
        $options = Json::htmlEncode(array_merge($this->getClientOptions(), ['filterOnFocusOut' => $this->filterOnFocusOut]));
        $view->registerJs("jQuery('#$id').yiiGridView($options);");
    }

    /**
     * Returns the options for the grid view JS widget.
     * @return array the options
     */
    protected function getClientOptions()
    {
        $filterUrl = isset($this->filterUrl) ? $this->filterUrl : Yii::$app->request->url;
        $id = $this->filterRowOptions['id'];
        $filterSelector = "#$id input, #$id select";
        if (isset($this->filterSelector)) {
            $filterSelector .= ', ' . $this->filterSelector;
        }

        return [
            'filterUrl' => Url::to($filterUrl),
            'filterSelector' => $filterSelector,
        ];
    }

    protected function renderPageContent()
    {
        return preg_replace_callback('/\\{([\w\-\/]+)\\}/', function ($matches) {
            $name = $matches[1];
            if ('customPage' == $name) {
                return $this->renderCustomPage();
            } else if ('customPage2' == $name) {
                return $this->renderCustomPage2();
            } else if ('pageSize' == $name) {
                return $this->renderPageSize();
            } else if ('pageSize2' == $name) {
                return $this->renderPageSize2();
            } else if ('pageButtons' == $name) {
                return $this->renderPageButtons();
            }
            return '';
        }, $this->template);
    }

    protected function renderPageSize()
    {
        $pageSizeList = [];
        foreach ($this->pageSizeList as $value) {
            $pageSizeList[$value] = $value;
        }
        return Html::dropDownList($this->pagination->pageSizeParam, $this->pagination->getPageSize(), $pageSizeList, $this->pageSizeOptions);
    }

    //自己改造一下
    protected function renderPageSize2()
    {
        $pageSizeList = [];
        $current_url = array_merge([Yii::$app->controller->getRoute()], Yii::$app->request->queryParams);
        foreach ($this->pageSizeList as $value) {
            $url = $current_url;
            $url[$this->pagination->pageSizeParam] = $value;
            $pageSizeList[$value] = $value;
            $this->pageSizeOptions['options'][$value] = ['data-v' => Url::to($url)];
        }
        return Html::dropDownList($this->pagination->pageSizeParam, $this->pagination->getPageSize(), $pageSizeList, $this->pageSizeOptions);
    }

    protected function renderCustomPage()
    {
        $pageCount = $this->pagination->getPageCount();
        if ($pageCount < 2 && $this->hideOnSinglePage) {
            return '';
        }
        $page = 1;
        $params = Yii::$app->getRequest()->queryParams;
        if (isset($params[$this->pagination->pageParam])) {
            $page = intval($params[$this->pagination->pageParam]);
            if ($page < 1) {
                $page = 1;
            } else if ($page > $pageCount) {
                $page = $pageCount;
            }
        }
        return $this->customPageBefore . Html::textInput($this->pagination->pageParam, $page, $this->customPageOptions) . $this->customPageAfter;
    }

    protected function renderCustomPage2()
    {
        $pageCount = $this->pagination->getPageCount();
        $page = $this->pagination->getPage() + 1;
        $totalCount = $this->pagination->totalCount;

        return "共{$totalCount}套图片 当前:{$page}/{$pageCount}页";
    }
}