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

## Configuration de la Base de Données

1. Créez un utilisateur MySQL (optionnel si vous n'en avez pas déjà un) :

```sql
CREATE USER 'vparrot'@'localhost' IDENTIFIED BY '2C5rbvC6m3B3hA';
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
DATABASE_URL=mysql://vparrot:2C5rbvC6m3B3hA@localhost:3306/GarageVParrot
```

## Installation des Modules Node.js avec npm

```bash
npm install
```

## Compilation des Assets avec Webpack Encore

```bash
npm run dev
```

## Lancement du Serveur Symfony

Pour lancer le serveur Symfony en mode détaché :

```bash
symfony serve -d
```

L'application devrait être accessible à l'adresse [http://localhost:8000](http://localhost:8000).

---

N'oubliez pas de consulter la documentation Symfony pour plus d'informations sur le développement : [Documentation Symfony](https://symfony.com/doc/current/index.html)
