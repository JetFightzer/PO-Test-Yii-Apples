<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Apples';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCsrfMetaTags();
?>
<div class="apple-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Apple', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Generate Apples', ['generate'], ['class' => 'btn btn-success']) ?>
    </p>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],   

            'id',
            [
                'attribute' => 'color', 
                'format' => 'raw',
                'value' => function($model) {
                    $options1 = $options2 = [
                        'style' => [
                            'padding' => '0 4px',
                            'background' => $model->color,
                            'font-family' => 'monospace',
                        ],
                    ];
                    Html::addCssStyle($options1, ['color' => 'black']);
                    Html::addCssStyle($options2, ['color' => 'white']);
                    return
                        Html::tag('span', $model->color, $options1) .
                        Html::tag('span', $model->color, $options2);
                }
            ],
            'appearance_date',
            'fall_date',
            [
                'attribute' => 'state',
                'header' => 'State',
                'class'  => 'yii\grid\DataColumn',
                'value'  => function ($data) {
                    return $data->stateLabeled;
                },
            ],
            [
                'attribute' => 'left',
                'value' => function($model) {
                    return ($model->left * 100) . '%';
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {throw} {eat}',
                'buttons' => [
                    'throw' => function ($url, $model, $key) {
                        $span = Html::tag('span', '', ['class' => 'glyphicon glyphicon-arrow-down']);
                        return Html::a($span, $url, [
                            'title'        => 'throw',
                            'aria-label'   => 'throw',
                            'data-pjax'    => 0,
                            'data-confirm' => 'Are you sure you want to throw this item?',
                            'data-method'  => 'post',
                        ]);
                    },
                    'eat' => function ($url, $model, $key) {
                        $button = Html::tag('a', '', ['class' => 'glyphicon glyphicon-apple submit']);
                        $csrf = Html::hiddenInput(Yii::$app->getRequest()->csrfParam, Yii::$app->getRequest()->getCsrfToken(), []);
                        $form = Html::tag('form', $button . $csrf, [
                            'action' => $url,
                            'method' => 'post',
                            'style' => ['display' => 'contents'],
                        ]);
                        return $form;
                    },
                ],
                'visibleButtons' => [
                    'throw' => function ($model, $key, $index) {
                        return $model->state == 'on_tree';
                    },
                    'eat' => function ($model, $key, $index) {
                        return $model->state == 'falled_down';
                    },
                ],
            ],
        ],
    ]); ?>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            jQuery('form a.submit').click(e => {
                e.preventDefault();
                const form = e.target.closest('form');
                const amount = prompt('How much to eat (in percents)?', 25);
                if(amount) {
                    const $input = $('<input>').attr({
                        type: 'hidden',
                        name:  'amount',
                        value: amount,
                    })
                    $input.appendTo(form);
                    form.submit();
                }
            });
        });
    </script>


</div>
