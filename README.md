# Installation

Installer les dépendances :
```
composer install
```

Configurer les droits du repertoire (linux uniquement) :
```
./scripts/set_perms.sh
```

Faire pointer un alias domaine racine sur /web/

# Repertoires

TODO

# Normes de codage
Norme du code (Nommage) : http://www.php-fig.org/psr/psr-1/fr/ (PSR-1)
Style du code (Formatage, prenthèses...) : http://www.php-fig.org/psr/psr-2/fr/ (PSR-2)


# FAQ Architecture des fichiers

**Où mettre mes fichiers javascript ?**
Dossier web/assets/

**Où mettre mes fichiers CSS ?**
Il vaut mieux utiliser les fichiers .less situés dans /src/less qui générera les assets.  
Si c'est un fichier CSS statique, l'ajouter dans /assets/

**Où créer une nouvelle classe métier ?**
Dossier src/Classes

**Comment créer un nouveau web service ?**

**Comment créer un nouvel espace ?**

**Où créer une nouvelle page AJAX ?**

**Où ajouter un nouveau script PHP ? (Nettoyeur, importeur...) ?**

**Comment corriger un bug sur un composant externe (exemple : MySQL Database) ?**
Les composants externes sont dans le dossier /vendor/. Ne jamais modifier le contenu de ce repertoire.
Faire la modification sur le GIT du composant externe, puis faire un *composer install* sur le projet.

**Où ajouter de nouvelles constantes métiers ? (URL distante, logins API externe...)**
Créer un fichier .php dans Boot/ puis l'inclure dans /web/index.php

# FAQ Utilisation du framework
