<?php

/* @var $this yii\web\View */
/* @var $trees Trees[] */

$this->title = 'Деревья';

$this->params['breadcrumbs'][] = $this->title;

use core\ActiveRecord\Trees\Trees;
use rmrevin\yii\fontawesome\FAS;
use rmrevin\yii\fontawesome\FontAwesome;
use yii\helpers\Html;
use yii\helpers\Url; ?>


<p>

    <?= Html::a('<i class="fa fa-plus"></i> Создать дерево', Url::to(['trees/create']), [
        'class' => 'btn btn-success',
        'data' => [
            'method' => 'post'
        ]
    ]) ?>

</p>

<?php if ($trees): ?>
    <div class="row">
        <?php foreach ($trees as $tree): ?>
            <div class="col-md-2">
                <div class="panel">
                    <div class="panel-heading text-center">
                        <h3><?= FAS::i('tree')->size(FontAwesome::SIZE_6X)?> <?= $tree->name ?></h3>
                        <div>
                            Яблок: <?=$tree->applesCount?>
                        </div>
                    </div>
                    <div class="panel-body">
                        <?= Html::a('Смотреть', Url::to(['view', 'id' => $tree->id]), ['class' => 'btn btn-primary btn-sm btn-block']) ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
