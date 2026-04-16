<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/menu.php'; ?>

<h1>Detalle de biblioteca</h1>

<?php if (!empty($message)): ?>
    <div class="alert-error">
        <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>
    </div>
<?php endif; ?>

<table class="detail-table">
    <tr><th>ID</th>              <td><?= htmlspecialchars($biblioteca->getId(), ENT_QUOTES, 'UTF-8') ?></td></tr>
    <tr><th>Nombre</th>          <td><?= htmlspecialchars($biblioteca->getNombre(), ENT_QUOTES, 'UTF-8') ?></td></tr>
    <tr><th>Dirección</th>       <td><?= htmlspecialchars($biblioteca->getDireccion(), ENT_QUOTES, 'UTF-8') ?></td></tr>
    <tr><th>Ciudad</th>          <td><?= htmlspecialchars($biblioteca->getCiudad(), ENT_QUOTES, 'UTF-8') ?></td></tr>
    <tr><th>País</th>            <td><?= htmlspecialchars($biblioteca->getPais(), ENT_QUOTES, 'UTF-8') ?></td></tr>
    <tr><th>Teléfono</th>        <td><?= htmlspecialchars($biblioteca->getTelefono(), ENT_QUOTES, 'UTF-8') ?></td></tr>
    <tr><th>Email</th>           <td><?= htmlspecialchars($biblioteca->getEmail(), ENT_QUOTES, 'UTF-8') ?></td></tr>
    <tr><th>Horario apertura</th><td><?= htmlspecialchars($biblioteca->getHorarioApertura(), ENT_QUOTES, 'UTF-8') ?></td></tr>
    <tr><th>Horario cierre</th>  <td><?= htmlspecialchars($biblioteca->getHorarioCierre(), ENT_QUOTES, 'UTF-8') ?></td></tr>
    <tr><th>Núm. libros</th>     <td><?= $biblioteca->getNumLibros() ?></td></tr>
    <tr><th>Núm. usuarios</th>   <td><?= $biblioteca->getNumUsuarios() ?></td></tr>
    <tr><th>Pública</th>         <td><?= $biblioteca->getEsPublica() ? 'Sí' : 'No' ?></td></tr>
    <tr>
        <th>Web</th>
        <td>
            <?php if ($biblioteca->getWeb() !== ''): ?>
                <a href="<?= htmlspecialchars($biblioteca->getWeb(), ENT_QUOTES, 'UTF-8') ?>" target="_blank" rel="noopener">
                    <?= htmlspecialchars($biblioteca->getWeb(), ENT_QUOTES, 'UTF-8') ?>
                </a>
            <?php else: ?>
                —
            <?php endif; ?>
        </td>
    </tr>
</table>

<p style="margin-top: 16px;">
    <a class="btn btn-warning" href="?route=bibliotecas.edit&amp;id=<?= urlencode($biblioteca->getId()) ?>">Editar</a>
    &nbsp;
    <a class="btn" href="?route=bibliotecas.index">Volver al listado</a>
</p>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
