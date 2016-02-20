<?php

$globals_needles = ['ROOT_SYSTEM', 'NASKI_CORE_PATH', 'NASKI_APP_PATH'];
foreach ($globals_needles as $v) {
    if (!defined($v)) {
        die("La globale $v n'est pas définie dans /boot.php");
    }
}
