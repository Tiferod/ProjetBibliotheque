# Installation du programme

Le code PHP doit tourner sur un serveur, on peut le faire tourner en local avec WAMP (Windows) ou LAMP (Linux).
Dé-zipper le code dans un sous-dossier de `C:\wamp\www\` (Windows) ou `/srv/http/` (Linux),
puis accéder via un navigateur à `http://localhost/sous_dossier/index.php`.

# Chargement des BDDs

Il y a 2 fichiers à intégrer au service MySQL :

- `bibli.sql` : Une base de données avec le contenu de l'application.

- `mysql.sql` : 2 tables indiquant les droits d'accès des utilisateurs à la base ci-dessus.
	Sur *phpMyAdmin* (pas testé ailleurs), ces infos sont stockées dans la BDD `mysql`.

# Navigation

Nous avons défini 2 types d'utilisateurs : les administrateurs et les simples abonnés.
Les abonnés n'ont que des droits de lecture, les admins ont tous les droits sur `bibli`.
Pour se connecter, les *users* abonnés existants sont `sroubaud`, `jlantier` et `gmacquart`.
Les *users* admins sont `pnegrel` et `elantier`.
Par souci de simplicité pour la démo, tous les utilisateurs ont le mot de passe `password`.