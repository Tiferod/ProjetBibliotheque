`bibli.sql` = database principale

`mysql.sql` = droits d'utilisateur sur `bibli`

Users ayant accès à la BDD (pour les tests) :

- `dev` / `password` : grand manitou, utilisé dans le code, peut-être de manière permanente

- `jsnow` / `password` : un abonné standard

- `nstark` / `password` : un admin standard

TODO :

- style

- remplir les BDDs

- modération : 3 requêtes

(- recherche de documents : des requêtes et des URLs)

(- gestion documents : remplacer admins par auteurs / documents (attention si plusieurs auteurs par document))

- formater les dates

(- auteurs : nom + prénom ?)

- hash passwords ?

- plus de vérifications internes que ça marche

- pour les emprunts et retours, sélectionner abonné en rentrant le pseudo ou le document par l'ID