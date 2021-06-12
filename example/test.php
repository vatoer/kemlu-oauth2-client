<?php 
require dirname(__DIR__, 1) . '/vendor/autoload.php';
use Kemlu\OAuth2\Client\Provider\Kemlu;
use Kemlu\OAuth2\Client\Provider\KemluUser as KemluUser;

$a = ['id'=>1,'email'=>'abc.@dfd.com'];
$user = new KemluUser($a);
print_r(get_declared_classes()); 
//phpinfo();