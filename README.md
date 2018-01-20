`bibli.sql` = database principale

`mysql.sql` = droits d'utilisateur sur `bibli`

Users ayant accès à la BDD (pour les tests) :

- `dev` / `password` : grand manitou, utilisé dans le code, peut-être de manière permanente

- `jsnow` / `password` : un abonné standard

- `nstark` / `password` : un admin standard

TODO :

- style

- remplir les BDDs

- gestion admins : ajouter privilèges globaux GRANT / CREATE USER + prévoir le DELETE USER + permettre de modifier

- gestion abonnés : remplacer admins par abonnés avec quelques opérations en plus (on mettra tout sur la même page, tant pis)

- gestion documents : remplacer admins par auteurs / documents (attention si plusieurs auteurs par document)

- emprunts : 2 menus déroulants + une grosse requête SQL

- retours : 1 menu déroulant + une grosse requête SQL

- modération : 3 requêtes

- recherche de documents : des requêtes et des URLs

- formater les dates

- auteurs : nom + prénom ?

- hash passwords ?