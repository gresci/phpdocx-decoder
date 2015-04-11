<?php

$startTime = microtime(true);

// settings
$classesDir = 'classes';
$outputDir = 'classes_decoded';
$exclude = [
    'CreateDocx.inc',
    'AutoLoader.inc',
    'Phpdocx_config.inc',
    'CreateElement.inc',
    'Helpers.inc',
];

// checks dirs
if (!is_dir($classesDir)) {
    echo 'Directory ' . $classesDir . " doesn't exist";
    die();
}
if (!is_dir($outputDir) && !mkdir($outputDir)) {
    echo 'Unable to make dir ' . $outputDir;
    die();
}

// decodes encoded classes
$files = array_diff(scandir($classesDir), ['.', '..'], $exclude);
foreach ($files as $file) {
    $pathToFile = $classesDir . DIRECTORY_SEPARATOR . $file;
    $base64 = file_get_contents($pathToFile);
    $inflated = base64_decode($base64, true);
    $decoded = gzinflate($inflated);
    if ($base64 && $inflated && $decoded) {
        $savePath = $outputDir . DIRECTORY_SEPARATOR . $file;
        if (!file_put_contents($savePath, '<?php' . $decoded)) {
            echo 'Unable to save ' . $file . '<br>';
        }
    } else {
        echo 'Error with ' . $file . '<br>';
    }
}

// copies not encoded classes
foreach ($exclude as $file) {
    $pathToFile = $classesDir . DIRECTORY_SEPARATOR . $file;
    $savePath = $outputDir . DIRECTORY_SEPARATOR . $file;
    if (file_exists($pathToFile)) {
        if (!copy($pathToFile, $savePath)) {
            echo 'Unable to save ' . $file . '<br>';
        }
    } else {
        echo 'File ' . $file . " doesn't exist" . '<br>';
    }
}

echo 'Done in ' . round(microtime(true) - $startTime, 3) . ' seconds.';
