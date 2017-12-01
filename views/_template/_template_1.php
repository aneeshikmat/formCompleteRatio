<?php
    $templateBlockId = empty($templateOption['templateBlockId']) ? '' : $templateOption['templateBlockId'];
?>

<div class="<?= isset($templateOption['templateClassWrapper']) ? $templateOption['templateClassWrapper'] : '' ?>" id="<?= $templateBlockId ?>">
    <div class="<?= $templateBlockId ?>-main-wrapper">
        <div class="<?= $templateBlockId ?>-row-1">
            <?php if(!empty($templateOption['title'])): ?>
                <div class="<?= $templateBlockId ?>-title">
                    <h3 class="<?= $templateBlockId ?>-title-h3">
                        <span><?= $templateOption['title'] ?></span>
                    </h3>
                    <small></small>
                </div>
            <?php endif; ?>
            <?php if(!empty($templateOption['url'])): ?>
                <div class="pull-right">
                    <a class="btn btn-success <?= $templateBlockId ?>-url" href="<?= $templateOption['url'] ?>"> <?= $templateOption['urlText']; ?> </a>
                </div>
            <?php endif; ?>
        </div>
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