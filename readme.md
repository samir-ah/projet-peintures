# Projet symfony peintures

site présentant des peintures

## Environnement de dev

### Pré-requis

- Php 7.4
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
symfony console doctrine:database:create
```

```bash
symfony console doctrine:migrations:migrate
```

```bash
symfony console doctrine:fixtures:load
```

### Création de la bdd de test

```bash
symfony console --env=test doctrine:database:create
```

```bash
symfony console --env=test doctrine:migrations:migrate
```

```bash
symfony console --env=test doctrine:fixtures:load
```

### Lancer les tests

```bash
php bin/phpunit --testdox
```

### Lancer test coverage

```bash
php bin/phpunit --coverage-html var/log/test/test-coverage
```

### Lancer test coverage (test env)

```bash
APP_ENV=test symfony php bin/phpunit --coverage-html var/log/test/test-coverage
```

## Production

### Envoi des emails de Contacts

Les emails sont stockés en bdd, pour les envoyer mettre en place un cron:

```bash
symfony console app:send-emailcontact
```
