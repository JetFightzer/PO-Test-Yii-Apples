<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Apple */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Apples', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="apple-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
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
        ],
    ]) ?>

</div>
