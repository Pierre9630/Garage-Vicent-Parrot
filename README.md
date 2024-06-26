# Projet GarageVParrot

Bienvenue dans le projet GarageVParrot ! Ce guide vous aidera à cloner le projet, installer les dépendances, configurer la base de données et exécuter l'application Symfony.

## Clonage du Projet

```bash
git clone https://github.com/votre-utilisateur/GarageVParrot.git
cd GarageVParrot
```

## Installation des Dépendances avec Composer

```bash
composer install
```

## Rajouter dependance apache-pack

```bash
composer require symfony/apache-pack
```

## Configuration de la Base de Données

1. Créez un utilisateur MySQL (optionnel si vous n'en avez pas déjà un) :

```sql
CREATE USER 'vparrot'@'localhost' IDENTIFIED BY 'lemotdepasse';
```

2. Créez une base de données MySQL :

```sql
CREATE DATABASE GarageVParrot CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
```

3. Accordez les privilèges à l'utilisateur sur la base de données :

```sql
GRANT ALL PRIVILEGES ON GarageVParrot.* TO 'vparrot'@'localhost';
FLUSH PRIVILEGES;
```

4. Modifiez la variable `DATABASE_URL` dans le fichier `.env` avec vos informations de connexion :

```env
DATABASE_URL=mysql://vparrot:lemotdepasse@localhost:3306/GarageVParrot
```

## Installation des Modules Node.js avec npm

```bash
npm install
```

## Compilation des Assets avec Webpack Encore

```bash
npm run dev
```

## Deinstaller les dépendences (et des dépendences associées) pouvant empêcher le bon fonctionnement local (à utiliser en cas de problème liés à ces dépedences)

```bash
composer remove nelmio/cors-bundle --update-with-dependencies
composer remove karser/karser-recaptcha3-bundle --update-with-dependencies
```

## Lancement du Serveur Symfony

Pour lancer le serveur Symfony en mode détaché :

```bash
symfony serve -d
```

### Compatibilité Moteurs Bases de données

SQLITE non compatible
```bash

```

L'application devrait être accessible à l'adresse [http://localhost:8000](http://localhost:8000).
Lien du Trello https://trello.com/b/r7JBZ2B1/garage-vparrot
---

N'oubliez pas de consulter la documentation Symfony pour plus d'informations sur le développement : [Documentation Symfony](https://symfony.com/doc/current/index.html)
