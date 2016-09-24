<?php
$signature = trim(file_get_contents('https://composer.github.io/installer.sig'));

copy('https://getcomposer.org/installer', 'composer-setup.php');

$compareSignature = hash_file('SHA384', 'composer-setup.php');

if($signature == $compareSignature) {
    exec('php composer-setup.php');

    echo 'Composer Phar generated'.PHP_EOL;
    echo 'Remove Setup Script'.PHP_EOL;

    unlink('composer-setup.php');

    exit();
}

echo 'invalid signature'.PHP_EOL;
echo $signature;
echo $compareSignature.PHP_EOL;
exit(1);
