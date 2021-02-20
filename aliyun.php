<?php

$dir    = '/www/';
$log    = '/tmp/hook.log';
$handle = fopen($log, 'a');

if ($_GET['token'] !== 'asdf') {
    fwrite($handle, date('Y-m-d H:i:s ') . 'token error' . PHP_EOL);
    exit;
}

if (!is_dir($dir . $_GET['project'])) {
    fwrite($handle, date('Y-m-d H:i:s ') . 'project error' . PHP_EOL);
    exit;
}

fwrite($handle, date('Y-m-d H:i:s ') . 'token right' . $_GET['project'] . PHP_EOL);

$resource = proc_open(
    'git reset --hard && git pull 2>&1',
    [1 => ['file', $log, 'a']],
    $pipes,
    $dir . $_GET['project']
);

fclose($pipes[1]);
proc_close($resource);