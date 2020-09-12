<?php
$this->assign('title', __('License Activation'));
$this->assign('description', '');
$this->assign('content_title', __('License Activation'));

?>

<div class="box box-primary">
    <div class="box-body">

        <?= $this->Form->create(null, [
            'url' => ['controller' => 'Activation', 'action' => 'index']
        ]); ?>

        <?=
        $this->Form->input('personal_token', [
            'label' => __('Personal Token'),
            'class' => 'form-control',
            'type' => 'text',
            'default' => get_option('personal_token', ''),
            'required' => 'required'
        ]);
        ?>

        <?=
        $this->Form->input('purchase_code', [
            'label' => __('Purchase Code'),
            'class' => 'form-control',
            'type' => 'text',
            'default' => get_option('purchase_code', ''),
            'required' => 'required'
        ]);
        ?>


        <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']); ?>
        <?= $this->Form->end(); ?>

    </div><!-- /.box-body -->
</div>
