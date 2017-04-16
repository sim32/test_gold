<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Role;
?>
<div class="row">
    <?php $form = ActiveForm::begin(['id' => 'edit-form']); ?>
    <div class="col-md-3"><?= $form->field($searchForm, 'name') ?></div>
    <div class="col-md-3"><?= $form->field($searchForm, 'email') ?></div>
    <div class="col-md-2"><?= $form->field($searchForm, 'phone') ?></div>
    <div class="col-md-2">
    <?=
    $form->field($searchForm, 'role_id')->dropdownList(
        Role::find()->select(['title', 'id'])->indexBy('id')->column(),
        ['prompt'=>'Select Role']
    )
    ?>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
<table class="table table-striped">
    <thead>
    <tr>
        <th>#</th>
        <th>Имя</th>
        <th>Почта</th>
        <th>Телефон</th>
        <th>Роль</th>
        <th>Активный</th>
        <th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    <? foreach ($users as $user): ?>
        <tr>
            <td><?= $user->id ?></td>
            <td><?= $user->name ?></td>
            <td><?= $user->email ?></td>
            <td><?= $user->phone ?></td>
            <td><?= $user->role->title ?></td>
            <td><?= $user->active ? '+' : '-' ?></td>
            <td>
                <div class="btn-group">
                    <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                        Действие <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><?= Html::a('Редактировать', '/admin/edit/' . $user->id)?></li>
                        <li><?= Html::a('Удалить', '/admin/delete/' . $user->id)?></li>
                    </ul>
                </div>
            </td>
        </tr>
    <? endforeach; ?>
    </tbody>
</table>
