<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/menu.php'; ?>

<h1>Editar biblioteca</h1>

<?php if (!empty($message)): ?>
    <div class="alert-error">
        <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>
    </div>
<?php endif; ?>

<form method="POST" action="?route=bibliotecas.update">
    <input type="hidden" name="id" value="<?= htmlspecialchars($old['id'] ?? $biblioteca->getId(), ENT_QUOTES, 'UTF-8') ?>">

    <div class="form-group">
        <label for="nombre">Nombre</label><br>
        <input type="text" id="nombre" name="nombre"
               value="<?= htmlspecialchars($old['nombre'] ?? $biblioteca->getNombre(), ENT_QUOTES, 'UTF-8') ?>">
        <?php if (!empty($errors['nombre'])): ?>
            <div class="field-error"><?= htmlspecialchars($errors['nombre'], ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="direccion">Dirección</label><br>
        <input type="text" id="direccion" name="direccion"
               value="<?= htmlspecialchars($old['direccion'] ?? $biblioteca->getDireccion(), ENT_QUOTES, 'UTF-8') ?>">
        <?php if (!empty($errors['direccion'])): ?>
            <div class="field-error"><?= htmlspecialchars($errors['direccion'], ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="ciudad">Ciudad</label><br>
        <input type="text" id="ciudad" name="ciudad"
               value="<?= htmlspecialchars($old['ciudad'] ?? $biblioteca->getCiudad(), ENT_QUOTES, 'UTF-8') ?>">
        <?php if (!empty($errors['ciudad'])): ?>
            <div class="field-error"><?= htmlspecialchars($errors['ciudad'], ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="pais">País</label><br>
        <input type="text" id="pais" name="pais"
               value="<?= htmlspecialchars($old['pais'] ?? $biblioteca->getPais(), ENT_QUOTES, 'UTF-8') ?>">
        <?php if (!empty($errors['pais'])): ?>
            <div class="field-error"><?= htmlspecialchars($errors['pais'], ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="telefono">Teléfono</label><br>
        <input type="text" id="telefono" name="telefono"
               value="<?= htmlspecialchars($old['telefono'] ?? $biblioteca->getTelefono(), ENT_QUOTES, 'UTF-8') ?>">
        <?php if (!empty($errors['telefono'])): ?>
            <div class="field-error"><?= htmlspecialchars($errors['telefono'], ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="email">Email</label><br>
        <input type="email" id="email" name="email"
               value="<?= htmlspecialchars($old['email'] ?? $biblioteca->getEmail(), ENT_QUOTES, 'UTF-8') ?>">
        <?php if (!empty($errors['email'])): ?>
            <div class="field-error"><?= htmlspecialchars($errors['email'], ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="horario_apertura">Horario de apertura (HH:MM)</label><br>
        <input type="time" id="horario_apertura" name="horario_apertura"
               value="<?= htmlspecialchars($old['horario_apertura'] ?? $biblioteca->getHorarioApertura(), ENT_QUOTES, 'UTF-8') ?>">
        <?php if (!empty($errors['horario_apertura'])): ?>
            <div class="field-error"><?= htmlspecialchars($errors['horario_apertura'], ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="horario_cierre">Horario de cierre (HH:MM)</label><br>
        <input type="time" id="horario_cierre" name="horario_cierre"
               value="<?= htmlspecialchars($old['horario_cierre'] ?? $biblioteca->getHorarioCierre(), ENT_QUOTES, 'UTF-8') ?>">
        <?php if (!empty($errors['horario_cierre'])): ?>
            <div class="field-error"><?= htmlspecialchars($errors['horario_cierre'], ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="num_libros">Número de libros</label><br>
        <input type="number" id="num_libros" name="num_libros" min="0"
               value="<?= htmlspecialchars((string) ($old['num_libros'] ?? $biblioteca->getNumLibros()), ENT_QUOTES, 'UTF-8') ?>">
        <?php if (!empty($errors['num_libros'])): ?>
            <div class="field-error"><?= htmlspecialchars($errors['num_libros'], ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="num_usuarios">Número de usuarios</label><br>
        <input type="number" id="num_usuarios" name="num_usuarios" min="0"
               value="<?= htmlspecialchars((string) ($old['num_usuarios'] ?? $biblioteca->getNumUsuarios()), ENT_QUOTES, 'UTF-8') ?>">
        <?php if (!empty($errors['num_usuarios'])): ?>
            <div class="field-error"><?= htmlspecialchars($errors['num_usuarios'], ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label>
            <input type="checkbox" name="es_publica" value="1"
                   <?= isset($old['es_publica']) ? ($old['es_publica'] ? 'checked' : '') : ($biblioteca->getEsPublica() ? 'checked' : '') ?>>
            Biblioteca pública
        </label>
    </div>

    <div class="form-group">
        <label for="web">Sitio web <small>(opcional)</small></label><br>
        <input type="url" id="web" name="web"
               value="<?= htmlspecialchars($old['web'] ?? $biblioteca->getWeb(), ENT_QUOTES, 'UTF-8') ?>">
        <?php if (!empty($errors['web'])): ?>
            <div class="field-error"><?= htmlspecialchars($errors['web'], ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>
    </div>

    <button type="submit" class="btn btn-primary">Guardar cambios</button>
    &nbsp;
    <a class="btn" href="?route=bibliotecas.index">Cancelar</a>
</form>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
