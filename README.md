# SAÉ 2.01 - Développement d'une application Web de consultation de séries

## Membres du binôme

* **Nom :** GENEVOIS
* **Prénom :** Gatien
* **Email :** gatien.genevois@etudiant.univ-reims.fr
* **Login :** gene0024
* **Nom :** AUDINOT
* **Prénom :** Tristan
* **Login :** audi0010
* **Email :** tristan.audinot@etudiant.univ-reims.fr

## Description du projet

Ce projet consiste à développer une application Web de consultation de séries à partir d'une base de données . Dans un second temps, des interfaces Web permettant de modifier le contenu de la base de données seront créées.

## Technologies utilisées

* **PHP**
* **Composer**
* **MySQL**
* **HTML**
* **CSS** (flexbox, mobile first, media queries)

## Contraintes de réalisation

* Respect de la recommandation **PSR-12** pour le code PHP
* Code en **anglais**
* Compatibilité **Linux** et **Windows**
* Documentation dans le `README.md`
* Utilisation de **MyPDO** et **WebPage** (ou **AppWebPage**)
* Structure du code en classes d'entités, collections et formulaires
* Mise en forme **CSS** avec **flexbox**, approche **mobile first** et **media queries**
* Validation **HTML** et **CSS**, vérification des performances avec **Lighthouse**
* Réponses **HTTP** avec codes de statut appropriés
* Tests (facultatifs) avec une base de données **SQLite** réduite

## Installation et lancement

1. **Cloner le dépôt :** `git clone https://iut-info.univ-reims.fr/gitlab/audi0010/php-crud-tvshow.git`
2. **Installer les dépendances :** `composer install`
3. **Lancer le serveur web :** *php -d display_errors -S localhost:8000 -t public/* ou *composer start:linux/windows*

## Création de la base de données

1. **Créer la base de donnée :** `CREATE DATABASE tvshow_db;
   `  
2. **Utiliser la base de données nouvellement créée :** `USE tvshow_db;
   `
3. **Importer le script SQL pour créer les tables et insérer les données initiales :** `USE tvshow_db;
   `
4. **Possible avec l'interface graphique de phpmyadmin**

## Tests

1. **Installer Codeception globalement si ce n'est pas déjà fait :** `composer global require codeception/codeception`
2. **Initialiser Codeception dans le projet :** `codecept bootstrap`
3. **Utitliser la commande `composer:test` pour lancer les test**

## Fonctionnalités

* **Consultation des données :** Affichage des données de la base de données (séries, saisons, épisodes).
* **Modification des données :** Interfaces pour ajouter, modifier et supprimer des données (séries).

## Documentation
* **La documentation est disponible dans Documentation/index.html**