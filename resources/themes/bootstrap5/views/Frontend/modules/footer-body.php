<?php declare(strict_types=1);
echo $this->Stylesheets()->renderRaw();
echo $this->Scripts()->render();
echo $this->Scripts()->renderRaw();
?>

<?= $this->GoogleAnalytics()->render(); ?>
