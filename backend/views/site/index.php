<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $apples backend\models\Apple[] */

$this->title = 'Яблоки';
?>
<div class="site-index">
    <h1><?= Html::encode($this->title) ?></h1>
    
    <h2>Создать яблоки</h2>
    <p><?= Html::a('Сгенерировать яблоки', ['apple/generate-apples'], ['class' => 'btn btn-primary']) ?></p>

    <h2>Яблоки</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Цвет</th>
                <th>Дата появления</th>
                <th>Дата падения</th>
                <th>Статус</th>
                <th>Съедено (%)</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($apples as $apple): ?>
                <tr>
                    <td><?= $apple->id ?></td>
                    <td><?= $apple->color ?></td>
                    <td><?= date('Y-m-d H:i:s', $apple->appearance_date) ?></td>
                    <td><?php if ($apple->fall_date != null) { echo date('Y-m-d H:i:s', $apple->fall_date); } ?></td>
                    <td><?= $apple->getState() ?></td>
                    <td><?= $apple->eaten_percent ?></td>
                    <td>
                        <?php if ($apple->status === \backend\models\Apple::STATUS_ON_GROUND && !$apple->is_rotten): ?>
                            <?php $form = ActiveForm::begin(['action' => ['apple/eat-apple', 'id' => $apple->id]]); ?>
                                <?= $form->field($apple, 'eaten_percent')->textInput(['type' => 'number', 'min' => 0, 'max' => 100, 'name' => 'percent']) ?>
                                <?= Html::submitButton('Съесть', ['class' => 'btn btn-success']) ?>
                            <?php ActiveForm::end(); ?>
                        <?php elseif ($apple->status === \backend\models\Apple::STATUS_ON_TREE): ?>
                            <?= Html::a('Упасть', ['apple/fall-apple', 'id' => $apple->id], ['class' => 'btn btn-primary']) ?>
                        <?php endif; ?>
                        <?= Html::a('Удалить', ['apple/delete-apple', 'id' => $apple->id], ['class' => 'btn btn-danger']) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
