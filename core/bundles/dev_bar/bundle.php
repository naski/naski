<?php

use Naski\Bundle\Bundle;

class DevBarBundle extends Bundle
{
    public function load()
    {
        echo "Chargement du DevBarBundle";
        global $CONFIG, $IM;
        $this->setVariable('twig_params', array(
            'n_requests' => \Naski\sumCalls($IM->getDatabaseInstances(), 'getRequestsNumber'), // TODO décalage
            'env' => $CONFIG['env'],
            'IM' => $IM
        ));
    }
}
