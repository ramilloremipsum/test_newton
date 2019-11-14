<?php
/* @var $this yii\web\View */
/* @var $tree Trees */
/* @var $createAppleForm CreateAppleForm */
/* @var $eatAppleForm EatAppleForm */

/* @var $appleColors AppleColors[] */

use core\ActiveRecord\Apples\AppleColors;
use core\ActiveRecord\Apples\Apples;
use core\ActiveRecord\Trees\Trees;
use core\Forms\backend\Trees\EatAppleForm;
use core\Forms\backend\Trees\CreateAppleForm;
use kartik\form\ActiveForm;
use rmrevin\yii\fontawesome\FAB;
use rmrevin\yii\fontawesome\FontAwesome;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;


$this->title = 'Дерево "' . $tree->name . '"';

$this->params['breadcrumbs'][] = ['label' => 'Деревья', 'url' => Url::to(['trees/index'])];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-5">
        <?php $form = ActiveForm::begin() ?>
        <?= $form->field($createAppleForm, 'color_id')->dropDownList(ArrayHelper::map(
            $appleColors, 'id', 'value'
        )) ?>
        <div class="form-group">
            <?= Html::submitButton('<i class="fa fa-plus"></i> Добавить одно яблоко', [
                'class' => 'btn btn-success btn-block',
                'name' => 'create-apple',
                'value' => 1
            ]) ?>
        </div>
        <?php ActiveForm::end() ?>
        <?= Html::beginForm(
            Url::to(['trees/fill-up'])
        ) ?>
        <?= Html::hiddenInput('tree_id', $tree->id) ?>
        <?= Html::submitButton('<i class="glyphicon glyphicon-refresh"></i> Обновить яблоки рандомно, от ' . Apples::MIN_RANDOM_GENERATE . ' до ' . Apples::MAX_RANDOM_GENERATE, ['class' => 'btn btn-primary btn-block']) ?>
        <?= Html::endForm() ?>
    </div>
</div>
<hr>

<?php if ($tree->apples): ?>
    <div class="row">
        <?php foreach ($tree->apples as $apple): ?>
            <div class="col-md-4">
                <div class="panel panel-default text-center">
                    <div class="panel-heading">
                        <?= FAB::i('apple', ['style' => 'color:' . ($apple->isRotten ? 'black' : $apple->color->value)])->size(FontAwesome::SIZE_5X) ?>
                        <div><?= $apple->isRotten ? 'Сгнившее' : 'Свежачок' ?></div>
                        <div>
                            <?php if ($apple->is_on_tree): ?>
                                Висит на дереве
                            <?php else: ?>
                                На земле c <?= Yii::$app->formatter->asDatetime($apple->fell_at) ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div>
                            Создано:
                            <?= Yii::$app->formatter->asDatetime($apple->created_at) ?>
                        </div>
                        <div>
                            Сорвано времени: <?= $apple->timeOnEarth ?>
                        </div>
                        <div>
                            Съели: <?= Yii::$app->formatter->asPercent($apple->eaten, 0) ?>
                        </div>
                        <div>
                            Осталось: <?= Yii::$app->formatter->asPercent($apple->size, 0) ?>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            <!--                            --><?php //if (!$apple->isRotten): ?>
                            <?php $form = ActiveForm::begin([
                                'id' => 'apple-eat-' . $apple->id,
                            ]) ?>
                            <div class="col-md-7">
                                <?= $form->field($eatAppleForm, 'eat_percent', [
                                    'addon' => [
                                        'append' => [
                                            'asButton' => true,
                                            'content' => Html::submitButton('Есть', ['name' => 'eat', 'value' => 1, 'class' => 'btn btn-warning btn-block'])
                                        ],
                                    ],
                                ])->input('text', [
                                    'min' => 5,
                                    'max' => $apple->maxToEat,
                                    'step' => 5,
                                    'value' => 0,
                                ])->label(false)
                                ?>
                                <?= $form->field($eatAppleForm, 'apple_id')->hiddenInput(['value' => $apple->id])->label(false) ?>
                            </div>
                            <?php ActiveForm::end() ?>
                            <!--                            --><?php //endif ?>
                            <div class="col-md-5">
                                <?php if ($apple->is_on_tree): ?>
                                    <?= Html::beginForm(
                                        Url::to(['trees/drop-apple'])
                                    ) ?>
                                    <?= Html::hiddenInput('apple_id', $apple->id) ?>
                                    <?= Html::submitButton('<i class="fa fa-download"></i> Скинуть', ['class' => 'btn btn-primary btn-block']) ?>
                                    <?= Html::endForm() ?>
                                <?php else: ?>
                                    <?= Html::beginForm(
                                        Url::to(['trees/hang-apple'])
                                    ) ?>
                                    <?= Html::hiddenInput('apple_id', $apple->id) ?>
                                    <?= Html::submitButton('<i class="fa fa-upload"></i> Повесить', ['class' => 'btn btn-primary btn-block']) ?>
                                    <?= Html::endForm() ?>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
