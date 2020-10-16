<?php

/** @var \ByTIC\Hello\Models\Clients\Client $item */
$item = isset($item) ? $item : $this->item;
$itemManager = $item->getManager();
?>
<table class="details table table-striped">
    <tbody>
    <tr>
        <td class="name">
            <?php echo translator()->trans('name'); ?>:
        </td>
        <td class="value">
            <?php echo $item->getName(); ?>
        </td>
    </tr>
    <tr>
        <td class="name">
            <?php echo $itemManager->getLabel('identifier'); ?>:
        </td>
        <td class="value">
            <?php echo $item->getIdentifier(); ?>
        </td>
    </tr>
    <tr>
        <td class="name">
            <?php echo $itemManager->getLabel('secret'); ?>:
        </td>
        <td class="value">
            <?php echo $item->getSecret(); ?>
            <a href="<?php echo $item->compileURL('regenerateSecret'); ?>" class="btn btn-info btn-xs float-right">
                Reset
            </a>
        </td>
    </tr>
    <tr>
        <td class="name">
            <?php echo $itemManager->getLabel('redirect'); ?>:
        </td>
        <td class="value">
            <?php echo $item->redirect; ?> |
            URI: <?php echo $item->getRedirectUri(); ?>
        </td>
    </tr>
    <tr>
        <td class="name">
            <?php echo $itemManager->getLabel('grant_types'); ?>:
        </td>
        <td class="value">
            <?php echo implode(',', $item->getGrants()); ?>
        </td>
    </tr>
    <tr>
        <td class="name"><?php echo translator()->trans('updated'); ?>:</td>
        <td class="value"><?php echo _strftime($item->updated); ?></td>
    </tr>
    <tr>
        <td class="name"><?php echo translator()->trans('created'); ?>:</td>
        <td class="value"><?php echo _strftime($item->created); ?></td>
    </tr>
    </tbody>
</table>