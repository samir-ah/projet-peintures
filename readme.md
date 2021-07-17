# Projet symfony peintures
site présentant des peintures
## Environnement de dev
### Pré-requis
- Php 8.0
- Composer
- Symfony cli
- Docker
- Docker-compose
- nodejs, npm

Vous pouvez vérifier les pré-requis (sauf Docker et Docker-compose) avec la commande suivante de la cli symfony:
```bash
symfony check:requirements
```
### Lancer l'environnement de dev

```bash
composer install
npm install
npm run build
docker-compose up -d
symfony serve -d
```
### Ajouter les données de test (fixtures)

```bash
symfony console doctrine:fixtures:load
```
### Lancer les tests
```bash
php bin/phpunit --testdox 
```