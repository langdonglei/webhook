<?php

const DIR_GIT  = '/www';
const DIR_SYNC = '/sync';

validate();

$project = $_GET['project'];
$sync    = $_GET['sync'];

$cmd = 'git reset --hard && git pull && composer install';
if ($sync == 1) {
    # cd $dir_git
    # sudo -u www git clone $project
    # sudo -u www composer install
    # sudo -u cp .example.env .env
    # rsync -ra --delete --exclude=.git --exclude=runtime . $sync/$project
    $cmd .= ' && rsync -ra --delete --exclude=.git --exclude=runtime . ' . DIR_SYNC . DIRECTORY_SEPARATOR . $project;
}
$resource = proc_open(
    $cmd,
    [
        1 => [
            'pipe',
            'w'
        ],
        2 => [
            'pipe',
            'w'
        ],
    ],
    $pipes,
    DIR_GIT . DIRECTORY_SEPARATOR . $project
);
echo stream_get_contents($pipes[1]) . stream_get_contents($pipes[2]);
fclose($pipes[1]);
fclose($pipes[2]);
proc_close($resource);


/**
 * @throws Throwable
 */
function validate()
{
    if ($_GET['token'] !== 'asdf') {
        throw new Exception('token error');
    }
    if (!is_dir(DIR_GIT . DIRECTORY_SEPARATOR . $_GET['project'])) {
        throw new Exception('project error');
    }
    if (isset($_GET['sync']) && !is_dir(DIR_SYNC)) {
        throw new Exception('sync error');
    }
}