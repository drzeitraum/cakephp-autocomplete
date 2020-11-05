<?= $this->Form->create($user, ['id' => 'user', 'class' => 'align-middle']) ?>
<div class="form-group">
    <?= $this->Form->control('country_id', ['type' => 'ac', 'class' => 'ac-input form-control', 'options' => $countries]) ?>
</div>
<?= $this->Form->button('Save', ['class' => 'btn btn-primary']) ?>
<?= $this->Form->end() ?>
