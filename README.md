# Naski / PDO

Ajoute quelques utilitaires pour gérer des base de données plus facilement.

## Connexion
```php
<?php

use Naski\Pdo\MySQLDatabase;

$db = new MySQLDatabase(array(
    'host' => '127.0.0.1',
    'username' => 'root',
    'password' => '',
    'dbname' => 'tests'
));
```

## Query basique
```php
<?php
$q = $db->query("SELECT * from users");
while ($l = $q->fetch()) {
    print_r($l);
}
```

## Insert / Update assité
```php
<?php

// Insert dans une table
$db->insert('users', array(
    'name' => 'John',
    'date' => 'NOW()'
));

// Update avec condition
$db->update('users', array(
    'name' => 'Doe'
), array(
    'name' => 'John'
));

## TODO
- Faire un GET d'un ensemble de ligne
- Pouvoir récupérer l'ID du dernier Insert
- Pouvoir GET une ligne
- Logger les requêtes trop longues

```