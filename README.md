# Kakte_kitchen

## Deploiement
### Serveur

- Acheter/louer un serveur (dédié, VPS ou mutualisé)
- Se connecter en SSH pour accéder au serveur distant et exécuter les lignes de commandes pour l'installation des logiciels nécessaires
- Le configurer pour installer PHP, Apache, MySQL (via les lignes de commandes Linux du serveur) ==> c'est ce que fait MAMP quand on travaille en local

### Installation du projet Symfony sur le serveur
- se connecter en SSH dans le dossier du serveur qui est "public" (l'équivalent du ht docs de MAMP en local) ==> c'est notre dossier ciblé pour être le dossier racine
- récupérer le lien du projet à jour sur GitHub & git clone pour créer le dossier dans le dossier racine du serveur
- Exécuter "composer install" pour installer les dépendances nécessaires aux projet (symfony, doctrine, twig) dans le dossier vendor (qui n'est pas push sur le git)
- Copier-coller le .env en le duplicant en .env.local, modifier dans ce .env.local avec les informations de la DataBase liée au serveur acheté/loué
- Modifier la variable d'environnement APP_ENV pour la passer en "PROD" (par défaut en "dev"). Cela permet de faire fonctionner le projet en mode production (sans les messages d'erreur de Symfo), donc les infos vont en cache, ce qui permet un fonctionnement plus rapide.*
- REcréer le schéma de DB (tables, colonnes, etc.) avec "php bin/console docrine:migrations:migrate"
- vider les caches avec "php bin/console cache:clear --env=prod --no-debug"

### Nom de domaine
- S'assurer que Apache soit configuré pour pointer directement dans le dossier public de Symfony
- Acheter un nom de domaine avec un certificat SSL (pour avoir HTTPS)
- Relier le nom de domaine à l'adresse IP du serveur


    
