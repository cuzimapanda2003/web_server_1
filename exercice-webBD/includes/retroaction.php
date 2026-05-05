<?php if (!empty($erreurs) && is_array($erreurs)) : ?>
    <div class="zone-erreur">
        <h4>Erreurs</h4>
        <?php foreach ($erreurs as $err) : ?>
            <p><?= htmlspecialchars((string)$err, ENT_QUOTES, 'UTF-8');  ?></p>
        <?php endforeach; ?>
    </div>
<?php elseif (!empty($infos) && is_array($infos)): ?>
    <div class="zone-info">
        <h4>Informations</h4>
        <?php foreach ($infos as $info) : ?>
            <p><?= htmlspecialchars((string)$info, ENT_QUOTES, 'UTF-8');  ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>