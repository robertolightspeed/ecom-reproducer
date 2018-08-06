<?php
require 'vendor/autoload.php';

use App\Cupid;

putenv('SHOP_URL=https://yourshop.com/admin/');
putenv('TOKEN=XXX');

$cupid = new Cupid();

$cupid->throwArrow(999, \App\Minions\ProductTaxCollections::class);
