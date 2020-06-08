<?= $this->Form->create($user, ['id' => 'user']) ?>
<?= $this->Form->control('country_id', ['type' => 'ac', 'class' => 'ac-input', 'options' => $countries]) ?>
<?= $this->Form->button('Save') ?>
<?= $this->Form->end() ?>
