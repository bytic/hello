<?php
$headerUrl = isset($headerUrl) ? $headerUrl : '';
?>
<div id="header" class="header">
    <h1 id="logo">
        <a href="<?php echo $headerUrl; ?>" title="<?php echo config('app.name') ?>">
            <img src="<?php echo asset('/images/logo-white-full.png') ?>"
                 class="img-responsive"
                 alt="<?php echo config('app.name') ?>"/>
        </a>
    </h1>
    <h1 class="title"><?php echo $this->headerTitle; ?></h1>
</div>