<?php 
require dirname(__DIR__, 1) . '/vendor/autoload.php';
use Kemlu\Oauth2\Client\Provider\KemluUser;

$a = ['id'=>1,'email'=>'abc.@dfd.com'];
$user = new KemluUser($a);
var_dump(get_declared_classes()); 
//phpinfo();