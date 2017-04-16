<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use app\models\Role;
?>
<? if (!empty($data['error'])): ?>

    <div class="alert alert-danger">
        <?= $data['error'] ?>
    </div>

<? elseif(!empty($data['success'])): ?>

    <div class="alert alert-success">
        <?= $data['success'] ?>
    </div>

<? endif; ?>
<div class="row">
    <div class="col-lg-5">

        <?php $form = ActiveForm::begin(['id' => 'edit-form']); ?>

        <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'phone') ?>

        <?= $form->field($model, 'email') ?>

        <?= $form->field($model, 'role_id')->dropdownList(
            Role::find()->select(['title', 'id'])->indexBy('id')->column(),
            ['prompt'=>'Select Category']
        )
        ?>

        <?=
        $form->field($model, 'active')
            ->checkbox([
                'label' => 'Пользователь активен',
                'labelOptions' => [
                    'style' => 'padding-left:20px;'
                ],
                'selected' => $model->active
            ]);
        ?>

        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>