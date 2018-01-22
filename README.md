`bibli.sql` = database principale

`mysql.sql` = droits d'utilisateur sur `bibli`

TODO (obligatoire) :

- recherche de documents (titre/auteur/thème) + page document (toutes les infos associées) + page auteur (tous les documents écrits) + page thème (tous les documents concernés + tous les thèmes similaires)

- gestion documents (ajout/modif/suppression + auteurs + thèmes)

TODO (pas obligatoire mais utile quand même) :

- pour les emprunts et retours, permettre de sélectionner l'abonné en rentrant le pseudo dans un champ, ou le document par l'ID
    (quoique, on s'en fout : dans la plupart des navigateurs, en ouvrant le menu déroulant, on peut taper le début d'un item pour le sélectionner ; ici on affiche le pseudo / l'ID du document au début de chaque item, donc la recherche serait facile même avec N items dans la liste)

- formater les dates

- plus de style

- remplir plus les BDDs (au moins rajouter des thèmes)

- hash passwords dans la BDD

- plus de vérifications internes que ça marche (ou pas)

Known issues (et on s'en fout) :

- si un abonné fait plusieurs cotisations le même jour, seule la première est affichée
