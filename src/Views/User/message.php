<?php if (!empty($message)): ?>
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
        <p><?= $message ?></p>
    </div>
<?php endif; ?>

<?php if (!empty($error)): ?>
    <div class="bg-red-500 border-l-4 border-green-500 text-white p-4 mb-4" role="alert">
        <p><?= $error ?></p>
    </div>
<?php endif; ?>
