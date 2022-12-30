<?php
declare(strict_types=1);
use ByTIC\Assets\Assets;

Assets::entry()->addFromWebpack('frontend');
Assets::entry()->addFromWebpack('frontend-vendor');
?>
<?= $this->Stylesheets()->render(); ?>

<script type="text/javascript">
    var APP = {
        path: {
            root: '<?php // echo BASE_URL;?>',
            images: '<?php // echo IMAGES_URL;?>',
            flash: '<?php // echo FLASH_URL;?>',
            scripts: '<?php // echo SCRIPTS_URL;?>'
        }
    }
</script>
