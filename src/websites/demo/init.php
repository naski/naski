<?php

use Naski\Routing\Routing;
use Naski\Routing\Rule;

require ROOT_SYSTEM . 'src/websites/demo/controllers/home.php';

$ROUTING = new Routing();
$ROUTING->addRules(Naski\getRulesFromJsonFile(ROOT_SYSTEM . 'src/websites/demo/routing.json'));

if (!$ROUTING->process($path)) {
    die('Aucune route trouvée.');
}
