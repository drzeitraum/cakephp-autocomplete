<ul class='ac-list'>
    <? if (count($results)) { ?>
        <? foreach ($results as $result) { ?>
            <li id='<?= h($result->id) ?>'><?= $this->Base->illumination(h($this->getRequest()->getQuery('q')), $result->name) ?></li>
        <? } ?>
    <? } else { ?>
        <li id='ac_not_found'><?= __('At your request {0} nothing found', ['<b>' . $this->getRequest()->getQuery('q') . '</b>']) ?></li>
    <? } ?>
</ul>