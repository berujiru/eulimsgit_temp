<?php

/* @var $this yii\web\View */

$this->title = 'Invoices';
$this->params['breadcrumbs'][] = ['label' => 'Finance', 'url' => ['/finance/']];
$this->params['breadcrumbs'][] = ['label' => 'Billing', 'url' => ['/finance/billing']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="Lab-default-index">
    <h1><?= $this->context->action->uniqueId ?></h1>
    <p>
        This is the view content for action "<?= $this->context->action->id ?>".
        The action belongs to the controller "<?= get_class($this->context) ?>"
        in the "<?= $this->context->module->id ?>" module.
    </p>
    <p>
        You may customize this page by editing the following file:<br>
        <code><?= __FILE__ ?></code>
    </p>
</div>
