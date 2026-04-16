<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/menu.php'; ?>

<h1>Lista de bibliotecas</h1>

<?php if (!empty($message)): ?>
    <div class="alert-error">
        <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>
    </div>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <div class="alert-success">
        <?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?>
    </div>
<?php endif; ?>

<?php if (empty($bibliotecas)): ?>
    <p>No hay bibliotecas registradas todavía.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Ciudad</th>
                <th>País</th>
                <th>Teléfono</th>
                <th>Horario</th>
                <th>Pública</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bibliotecas as $biblioteca): ?>
                <tr>
                    <td><?= htmlspecialchars($biblioteca->getNombre(), ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($biblioteca->getCiudad(), ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($biblioteca->getPais(), ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($biblioteca->getTelefono(), ENT_QUOTES, 'UTF-8') ?></td>
                    <td>
                        <?= htmlspecialchars($biblioteca->getHorarioApertura(), ENT_QUOTES, 'UTF-8') ?>
                        –
                        <?= htmlspecialchars($biblioteca->getHorarioCierre(), ENT_QUOTES, 'UTF-8') ?>
                    </td>
                    <td><?= $biblioteca->getEsPublica() ? 'Sí' : 'No' ?></td>
                    <td>
                        <a class="btn btn-sm" href="?route=bibliotecas.show&amp;id=<?= urlencode($biblioteca->getId()) ?>">Ver</a>
                        <a class="btn btn-sm btn-warning" href="?route=bibliotecas.edit&amp;id=<?= urlencode($biblioteca->getId()) ?>">Editar</a>
                        <form method="POST" action="?route=bibliotecas.delete" style="display:inline"
                              onsubmit="return confirm('¿Eliminar «<?= htmlspecialchars(addslashes($biblioteca->getNombre()), ENT_QUOTES, 'UTF-8') ?>»?');">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($biblioteca->getId(), ENT_QUOTES, 'UTF-8') ?>">
                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
