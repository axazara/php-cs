<?php

$projectPath = __DIR__;
$scanDirectories = [
    $projectPath . '/src/',
];
$scanFiles = [
];

return [
    'composerJsonPath' => $projectPath . '/composer.json',
    'vendorPath'       => $projectPath . '/vendor/',

    'skipPackages' => [
    ],
    'scanDirectories' => $scanDirectories,
    'scanFiles'       => $scanFiles,
];
