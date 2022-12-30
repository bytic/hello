<?php declare(strict_types=1);
$hasRedirect = !empty($this->redirect);
?>

<?= $hasRedirect ?
    $this->Messages()->info(
        \Nip\Records\Locator\ModelLocator::get('users')->getMessage('registerThankYou.explanation',
            ['redirectURL' => $this->redirect])
    )
    : '';
?>

<?php if ($hasRedirect) { ?>
    <script>
        <?php if ('opener' == $this->redirect) { ?>
        // window.opener.location.reload();
        window.close();
        <?php } else { ?>
        setTimeout("window.location.href = '<?= $this->redirect; ?>'", 5 * 1000);
        <?php } ?>
    </script>
<?php } ?>