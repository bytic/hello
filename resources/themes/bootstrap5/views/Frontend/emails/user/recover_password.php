<p>Draga <?= $this->user->getName(); ?>,</p>

<p>
    Ati initiat procedura de resetare a parolei a contului dumneavoastra de pe
    <a href="<?= $this->Url()->base(); ?>">
        <?= $this->Url()->base(); ?>
    </a>.
</p>
<p>Pentru a intra in cont, va rugam sa folositi urmatoarele informatii:</p>
<p>
    Email: <em><strong><?= $this->user->email; ?></strong></em>
    <br/>
    Parola: <?= $this->user->password; ?>
</p>
<br/>

<p>Sugestie: Dupa autentificare va sugeram sa va schimbati parola cu una noua pe care sa o memorati.</p>