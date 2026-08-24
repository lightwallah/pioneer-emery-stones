<?php

$types = require __DIR__ . '/stone_types.php';
$specs = [];
foreach ($types as $key => $type) {
    $specs[] = [
        'id' => $key,
        'title_key' => 'spec_' . $key,
        'rows' => $type['rows'],
    ];
}
return $specs;
