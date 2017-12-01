<?php
    $templateBlockId = empty($templateOption['templateBlockId']) ? '' : $templateOption['templateBlockId'];
?>

<div class="<?= isset($templateOption['templateClassWrapper']) ? $templateOption['templateClassWrapper'] : '' ?>" id="<?= $templateBlockId ?>-t2">
    <div class="<?= $templateBlockId ?>-main-wrapper">
        <div class="<?= $templateBlockId ?>-progress-info">
            <div class="<?= $templateBlockId ?>-progress">
                <span style="width: <?= $ratioValue ?>;" class="<?= $templateBlockId ?>-progress-bar">
                     <?php if(!empty($templateOption['srReaderHint'])): ?>
                        <span class="sr-only"><?= $ratioValue ?> <?= $templateOption['srReaderHint'] ?></span>
                     <?php endif; ?>
                </span>
            </div>
            <div class="<?= $templateBlockId ?>-status">
                <?php if(!empty($templateOption['startHintText'])): ?>
                    <div class="<?= $templateBlockId ?>-status-title"> <?= $templateOption['startHintText']; ?> </div>
                <?php endif; ?>
                <div class="<?= $templateBlockId ?>-status-number"> <?= $ratioValue ?></div>
            </div>
        </div>
    </div>
</div>