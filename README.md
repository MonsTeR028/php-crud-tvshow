# SAÉ 2.01 - Développement d'une application Web de consultation de séries

## Membres du binôme

* **Nom :** GENEVOIS
* **Prénom :** Gatien
* **Email :** gatien.genevois.genevois@etudiant.univ-reims.fr
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

1. **Cloner le dépôt :** `git clone https://gitlab.com/votre_groupe/sae2-01.git`
2. **Installer les dépendances :** `composer install`
3. **Créer la base de données :** *Instructions fournies le 10 juin*
4. **Charger les fixtures :** *Instructions fournies le 10 juin*
5. **Lancer le serveur web :** *php -d display_errors -S localhost:8000 -t public/*

## Fonctionnalités

* **Consultation des données :** Affichage des données de la base de données.
* **Modification des données :** Interfaces pour ajouter, modifier et supprimer des données.