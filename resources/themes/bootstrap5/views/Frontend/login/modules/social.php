<h2 class="social-auth-title">
    <?= \Nip\Records\Locator\ModelLocator::get('users')->getLabel('login.social'); ?>
</h2>

<?= $this->load('/modules/social/oauth-btn'); ?>
