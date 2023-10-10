# C'est Moi Qui Régale

<img src="https://github.com/cestmoiqui/regale/assets/142599647/971c2334-bfff-494d-a217-59ce9292014e" width="200">

C'est Moi Qui Régale est un projet Symfony conçu pour révolutionner votre expérience culinaire. C'est un blog de recettes avec un système de filtre avancé et un CMS pour gérer facilement vos créations culinaires. Laissez libre cours à votre créativité en cuisine et régalez-vous !

## Fonctionnalités

- Recherchez des recettes par ingrédient, type de plat ou cuisine du monde.
- Partagez vos recettes préférées avec d'autres passionnés de cuisine.
- Ajoutez vos propres recettes et astuces culinaires.
- Explorez des recettes recommandées et des tendances gastronomiques.

## Captures d'écran

<img width="600" alt="cmqr-accueil" src="https://github.com/cestmoiqui/regale/assets/142599647/aff30ac5-7eec-4b07-8b28-27e3c96eeae3">
<img width="200" alt="cmqr-mobile" src="https://github.com/cestmoiqui/regale/assets/142599647/15cec4ce-b3f2-43ba-8ea5-ad2b449c5792">


## Installation

1. Clonez ce dépôt : `git clone https://github.com/votre-utilisateur/cest-moi-qui-regale.git`
2. Installez les dépendances avec Composer : `composer install`
3. Créez la base de données : `php bin/console doctrine:database:create`
4. Appliquez les migrations : `php bin/console doctrine:migrations:migrate`
5. Lancez le serveur de développement : `php bin/console server:start`

## Fixtures

Le projet C'est Moi Qui Régale inclut des fixtures pour faciliter le développement et les tests. Vous pouvez les utiliser pour pré-remplir votre base de données avec des données de test. Voici comment les charger :

1. Chargez les fixtures des recettes en exécutant la commande Symfony suivante : `php bin/console doctrine:fixtures:load`
2. Chargez les fixtures des difficultés en exécutant la commande Symfony suivante : `php bin/console app:create-difficulty-levels`
3. Chargez les fixtures des articles en exécutant la commande Symfony suivante : `php bin/console app:generate-fake-articles`
4. Chargez les fixtures des médias en exécutant la commande Symfony suivante : `php bin/console app:generate-fake-media`

## Technologies Utilisées

- Symfony 6.3
- Bootstrap 5.3
- SCSS
- JavaScript

## Licence

Ce projet est sous licence Attribution-NonCommercial-ShareAlike 4.0 International - consultez le fichier [LICENSE](https://github.com/cestmoiqui/regale/blob/main/src/LICENSE.md) pour plus de détails.

---

Pour toute question ou commentaire, n'hésitez pas à me contacter à l'adresse [contact@cmoiqui.fr](mailto:contact@cmoiqui.fr).
