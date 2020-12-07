<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Apples';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="apple-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Apple', ['create'], ['class' => 'btn btn-success']) ?>
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
                'class'  => 'yii\grid\DataColumn', // can be omitted, as it is the default
                'value'  => function ($data) {
                    return $data->stateLabeled; // $data['name'] for array data, e.g. using SqlDataProvider.
                },
            ],
            [
                'attribute' => 'left',
                'value' => function($model) {
                    return $model->left . '%';
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
