<?php
if (!isset($_GET['pwd']) || $_GET['pwd'] != 'asdf' || !isset($_GET['cwd']) || empty($_GET['cwd'])) {
    echo 'error';
    return;
}

$resource = proc_open('git reset HEAD --hard && git pull', [
    1 => [
        'pipe',
        'w'
    ],
    2 => [
        'pipe',
        'w'
    ]
], $pipes, $_GET['cwd']
);
echo stream_get_contents($pipes[1]) . stream_get_contents($pipes[2]);
fclose($pipes[1]);
fclose($pipes[2]);
proc_close($resource);
