# FAQ Architecture des fichiers

**Où mettre mes fichiers javascript ?**


**Où mettre mes fichiers CSS ?**


**Où créer une nouvelle classe métier ?**
Dossier src/classes

**Comment créer un nouvel espace ?**
Créer un nouveau dossier dans src/websites/browser et déclarer les régles d'accés dans src/ressouces/multisite.json

**Comment créer un nouveau web service ?**
Créer un nouveau dossier dans src/websites/rest et déclarer les régles d'accés dans src/ressouces/multisite.json

**Où créer une nouvelle page AJAX pour un espace spécifique ?**
Créer une nouvelle action dans un controlleur adapté et la déclarer dans le routing.json du site associé

**Où ajouter un nouveau script PHP ? (Cron, Nettoyeur, importeur...) ?**
Si c'est un script executé en ligne de commande (pas depuis le navigateur), le créer dans le dossier app/scripts/ et inclure boot.php pour l'initialiser

**Comment corriger un bug sur un composant externe (exemple : MySQL Database) ?**
Les composants externes sont dans le dossier /vendor/. Ne jamais modifier le contenu de ce repertoire.
Faire la modification sur le GIT du composant externe, puis faire un *composer update* sur le projet.
