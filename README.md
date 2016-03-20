<<<<<<< HEAD
# Framework Naski

## Présentation
=======
# Présentation
>>>>>>> demo/master

Ce framework met à disposition des fonctionnalités et outils imbriquables, sans l'obligation de les utiliser.

Composants intégrés
- [Assetic](https://github.com/kriswallsmith/assetic), framework de gestion d'assets
- [Twig](http://twig.sensiolabs.org/), moteur de template
- [Monolog](https://github.com/Seldaek/monolog), gestionnaire de logs

Fonctionnalités :
- Respect des normes [PHP-PSR](http://www.php-fig.org/psr/)
- Gestion multisite avec [Naski/Routing](https://github.com/Doelia/naski-routing)
- Routing d'URL intégrant le MVC avec [Naski/Routing](https://github.com/Doelia/naski-routing)
- Chargement de config JSON avec [Naski/Config](https://github.com/Doelia/naski-config)
- Interface de communication avec des bases de données avec [Naski/Pdo](https://github.com/Doelia/naski-pdo)
- Système de "Bundles" pour découper les fonctionnalités en modules

Fonctionnaltés à venir :
- Système de cache Memcache
- API de maintenance multi-serveur (git pull, composer update, cleaner...)

<<<<<<< HEAD
## Get started
Un minimum de pré-requis est nécessaire pour créer un nouveau projet avec Naski Core.  
Voir projet de démonstration. (En construction)
=======
# Installation

Installer les dépendances :
```
composer update
```

Configurer les droits du repertoire (linux uniquement) :
```
./core/scripts/set_perms.sh
```

Faire pointer un alias domaine racine sur /web/
>>>>>>> demo/master
