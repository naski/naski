# Naski Routing

[![Build Status](https://travis-ci.org/Doelia/routing.svg?branch=master)](https://travis-ci.org/Doelia/routing)


## Fonctionnalités
- Routing d'un path dans une liste de régles
    - Système de controleur/action
    - Parametrage URL avec récupération dans le controleur (*exemple : product/23*)
    - Gestion des formulaires POST avec détection et netoyage des entrées
- Gestion multi-site
    - Conditions d'entrée configurable via regex : path, domaine, https...
- Utilisation du composant Naski/Config pour charger des régles depuis des fichiers JSON

## Dépendances

- [nikic/FastRoute](https://github.com/nikic/FastRoute) pour le routing
- [wixel/gump](https://github.com/Wixel/GUMP) pour la validation des parametres


## Routing

### Exemple de routing

```
$routing = new Routing();

$routing >addRule(new Rule(array(
    'path' => '/toto',
    'controller' => 'MyController',
    'action' => 'totoAction',
)));

// Avec parametres : /user/42, mais pas /user/xyz
$routing >addRule(new Rule(array(
    'path' => '/user:{id:\d+}',
    'controller' => 'MyController',
    'action' => 'userAction',
)));

// Route par défaut
$routing >addRule(new Rule(array(
    'path' => '*',
    'controller' => 'MyController',
    'action' => 'notFoundAction',
)));

// Executera la bonne action en fonction du path
$routing->process($_SERVER[REQUEST_URI]);
```
Voir [nikic/FastRoute](https://github.com/nikic/FastRoute) pour plus d'exemples sur la synthaxe.

### Formulaires POST
Il est possible de spécifier directement dans la règle la liste des parametres POST attendue, avec des régles de validation et de filtre.  
Les parametres se récupérent dans le controlleur avec *$this->inputs['key']* . Le test se fait avec *$this->inputValid()*. À utiliser uniquement comme sécurité côté serveur, préférer la validation côté client pour l'aspect estétique.

```
$routing >addRule(new Rule(array(
    'path' => 'formulare',
    'controller' => 'MyController',
    'action' => 'formAction',
    'params' => array(
        array(
            "name": "id",
            "validation_rules": "required",
            "filter_rules": "trim"
        ),
        array(
            "name": "username",
            "validation_rules": "required|max_len,100|min_len,6",
            "filter_rules": "trim|sanitize_string"
        )
    )
)));
```

Voir [wixel/gump](https://github.com/Wixel/GUMP) pour les synthaxes de validation_rules et filter_rules.

### Exemple de controleur

```
use Naski\Routing\Controller;

class TestController extends Controller
{
    public function totoAction()
    {
        $tpl = new Template('home.html');
        $tpl->render();
    }

    public function userAction($idUser)
    {
        $user = User::getUser($idUser);
        echo 'Hello '.$user->getName();
    }

    public function notFoundAction()
    {
        echo "Page not Found";
    }

    public function formAction()
    {
        if (!$this->inputValid()) {
            die('Erreur, formulaire invalide');
        } else {
            print_r($this->inputs);
        }
    }
}
```

### Chargement depuis un fichier
routing.json :
```
{
    "rules": [
        {
            "path": "/product",
            "controller": "HomeController",
            "action": "productAction",
            "params": [
                {
                    "name": "id",
                    "validation_rules": "required",
                    "filter_rules": "trim"
                }
            ]
        },
        {
            "path": "/",
            "controller": "HomeController",
            "action": "indexAction"
        },
        {
            "path": "*",
            "controller": "HomeController",
            "action": "badAction"
        }
    ]
}
```
boot.php :
 ```
use Naski\Config\Config;
use Naski\Routing\Routing;

$config = new Config();
$config->loadJSONFile('routing.json');

$routing = Routing::buildFromConfig($config);
$routing->process($_SERVER[REQUEST_URI]);
```

## Multi-sites

Si votre application est décomposée de plusieurs "sous-sites", vous pouvez utilser le composant Naski Multi-site intégré pour gérer les appels.

// TODO
