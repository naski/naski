# Installation

Installer les dépendances :
```
composer install
```

Configurer les droits du repertoire (linux uniquement) :
```
./core/scripts/set_perms.sh
```

Faire pointer un alias domaine racine sur /web/

# TODO

- Multisite
    - Gestion des permissions
    - Auto gestion
        - Inclure les controlleurs
- Faire un test d'api REST
- Étudier le système de log debug qui s'affiche quand nécessaire

# Repertoires

TODO

# Normes de codage
Norme du code (Nommage) : http://www.php-fig.org/psr/psr-1/fr/ (PSR-1)
Style du code (Formatage, prenthèses...) : http://www.php-fig.org/psr/psr-2/fr/ (PSR-2)

- Les variables locales utilisées dans plusieurs fichiers doivent être considérées comme globales et doivent nommées en MAJUSCULES. Exemples : $CONFIG, $IM

# FAQ Architecture des fichiers

**Où mettre mes fichiers javascript ?**


**Où mettre mes fichiers CSS ?**


**Où créer une nouvelle classe métier ?**
Dossier src/classes

**Comment créer un nouvel espace ?**
Créer un nouveau dossier dans src/websites/browser et déclarer les régles d'accés dans app/ressouces/multisite.json

**Comment créer un nouveau web service ?**
Créer un nouveau dossier dans src/websites/rest et déclarer les régles d'accés dans app/ressouces/multisite.json

**Où créer une nouvelle page AJAX ?**
Créer une nouvelle action dans un controlleur adapté et la déclarer dans le routing.json du site associé

**Où ajouter un nouveau script PHP ? (Cron, Nettoyeur, importeur...) ?**
Si c'est un script executé en ligne de commande (pas depuis le navigateur), le créer dans le dossier app/scripts/ et inclure boot.php pour l'initialiser

**Comment corriger un bug sur un composant externe (exemple : MySQL Database) ?**
Les composants externes sont dans le dossier /vendor/. Ne jamais modifier le contenu de ce repertoire.
Faire la modification sur le GIT du composant externe, puis faire un *composer update* sur le projet.

**Où ajouter de nouvelles constantes métiers ? (URL distante, logins API externe...)**
Créer un fichier .php dans /src/boot/ puis l'inclure dans /web/index.php
