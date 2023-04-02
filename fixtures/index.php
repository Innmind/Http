<?php

$post = \array_map(
    static fn($value) => \mb_strlen($value, 'ASCII'),
    $_POST,
);
$files = \array_map(
    static fn($file) => \mb_strlen(\file_get_contents($file['tmp_name']), 'ASCII'),
    $_FILES,
);

// expose the length of values as the values may contain data that json_encode
// don't support
echo \json_encode([
    'post' => $post,
    'files' => $files,
]);
