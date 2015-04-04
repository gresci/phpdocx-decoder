<?php

header('Content-type: text/plain');

$classesDir = 'classes';
$outputDir = 'classes_decoded';
$exclude = [
    '.', '..',
    'CreateDocx.inc',
    'AutoLoader.inc',
    'Phpdocx_config.inc',
    'CreateElement.inc',
    'Helpers.inc',
];

if (!is_dir($outputDir)) {
    if (!mkdir($outputDir)) {
        echo 'Unable to make dir ' . $outputDir . PHP_EOL;
        die();
    }
}
$files = scandir($classesDir);
foreach ($files as $file) {
    if (!in_array($file, $exclude)) {
        $pathToFile = $classesDir . DIRECTORY_SEPARATOR . $file;
        $base64 = file_get_contents($pathToFile);
        $inflated = base64_decode($base64, true);
        $decoded = gzinflate($inflated);
        if ($base64 && $inflated && $decoded) {
            $savePath = $outputDir . DIRECTORY_SEPARATOR . $file;
            if (!file_put_contents($savePath, '<?php' . $decoded)) {
                echo 'Unable to save ' . $file . PHP_EOL;
            }
        } else {
            echo 'Error with ' . $file . PHP_EOL;
        }
    }
}
echo 'Done.' . PHP_EOL;
