`bibli.sql` = database principale

`mysql.sql` = droits d'utilisateur sur `bibli`

TODO (obligatoire) :

- recherche de documents (titre/auteur/thème) + page document (toutes les infos associées) + page auteur (tous les documents écrits) + page thème (tous les documents concernés + tous les thèmes similaires)

- gestion documents (ajout/modif/suppression + auteurs + thèmes)

TODO (pas obligatoire mais utile quand même) :

- pour les emprunts et retours, permettre de sélectionner l'abonné en rentrant le pseudo dans un champ, ou le document par l'ID

- formater les dates

- plus de style

- remplir plus les BDDs

- hash passwords dans la BDD

- plus de vérifications internes que ça marche

Known issues (et on s'en fout) :

- si un abonné fait plusieurs cotisations le même jour, seule la première est affichée