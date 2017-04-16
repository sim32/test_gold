<? if (!empty($error)): ?>

    <div class="alert alert-danger">
        <?= $error ?>
    </div>

<? elseif(!empty($success)): ?>

    <div class="alert alert-success">
        <?= $success ?>
    </div>

<? endif; ?>