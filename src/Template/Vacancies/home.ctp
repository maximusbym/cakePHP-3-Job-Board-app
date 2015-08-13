<div class="vacancies index large-12 medium-12 columns">
    <table cellpadding="0" cellspacing="0">
        <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('title') ?></th>
            <th><?= $this->Paginator->sort('category_id') ?></th>
            <th><?= $this->Paginator->sort('created') ?></th>
            <th><?= h('Tags') ?></th>
            <th><?= $this->Paginator->sort('user_id') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($vacancies as $vacancy): ?>
            <tr>
                <td><?= $this->Number->format($vacancy->id) ?></td>
                <td><?= h($vacancy->title) ?></td>
                <td>
                    <?= $vacancy->has('category') ? h($vacancy->category->name) : '' ?>
                </td>
                <td><?= h($vacancy->created) ?></td>
                <td><?= h($vacancy->tag_string) ?></td>
                <td>
                    <?= $vacancy->has('user') ? h($vacancy->user->username) : '' ?>
                </td>
                <td class="actions">
                    <?= $this->Html->link(__('Apply'), 'applications/response/'.$vacancy->id) ?>
                </td>
            </tr>

        <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
