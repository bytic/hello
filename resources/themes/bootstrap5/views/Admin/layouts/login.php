<?php

declare(strict_types=1);

use ByTIC\Assets\Assets;

Assets::entry()->addFromWebpack('frontend-vendor');
Assets::entry()->addFromWebpack('frontend');

?>
<?= $this->load('HelloFrontend::/layouts/login'); ?>
