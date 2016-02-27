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

$db->insert('users', array(
    'name' => 'John',
    'date' => 'NOW()'
));

$db->update('users', array(
    'name' => 'Doe'
), $where = array(
    'name' => 'Doe'
));

```