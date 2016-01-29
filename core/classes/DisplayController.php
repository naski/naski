<?php

namespace Naski;

use Naski\Routing\Rule;
use Naski\Bundle\BundleManager;
use Naski\Bundle\Bundle;
use Naski\Bundle\DisplayBundle;

/**
 * Représente un controlleur qui réalise un affichage sur une page,
 * en utilisant le moteur principal Twig
 *
 * @author Stéphane Wouters <doelia@doelia.fr>
 *
 */
class DisplayController extends Controller {

    public function __construct(Rule $rule = null)
    {
        parent::__construct($rule);
    }
}
