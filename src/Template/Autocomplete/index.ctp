<ul class='ac-list'>
    <? if (count($results)) { ?>
        <? foreach ($results as $result) { ?>
            <li id='<?= $result->id ?>'><?= $this->Base->illumination($_REQUEST['search'], $result->name) ?></li>
        <? } ?>
    <? } else { ?>
        <li id='ac_not_found'>At your request <b><?= $_REQUEST['search'] ?></b> nothing found</li>
    <? } ?>
</ul>
