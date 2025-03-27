<?php
// PhpSpreadsheet manuel autoload
spl_autoload_register(function ($class) {
    $prefix = 'PhpOffice\\PhpSpreadsheet\\';
    $base_dir = __DIR__ . '/vendor/PhpSpreadsheet/src/PhpSpreadsheet/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

// PSR SimpleCache manuel çözüm (ekstra gerekebilir)
spl_autoload_register(function ($class) {
    if ($class === 'Psr\\SimpleCache\\CacheInterface') {
        require_once __DIR__ . '/vendor/Psr/SimpleCache/CacheInterface.php';
    }
});
// Composer\Pcre\Preg için manuel autoload
spl_autoload_register(function ($class) {
    if ($class === 'Composer\\Pcre\\Preg') {
        require_once __DIR__ . '/vendor/Composer/Pcre/Preg.php';
    }
});
