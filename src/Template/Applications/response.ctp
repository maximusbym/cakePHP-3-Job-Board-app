<div class="applications form large-12 medium-12 columns">
    <?= $this->Form->create($application) ?>
    <fieldset>
        <legend><?= __('Add Application') ?></legend>
        <?php
        echo $this->Form->input('email');
        echo $this->Form->input('text');
        echo $this->Form->input('vacancy_id', ['options' => $vacancies, 'default' => $vacancyId]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
