# la médiathèque de La Chapelle-Curreaux

La Réserve de la Chapelle (la médiathèque de La Chapelle-Curreaux) est un site internet pour pouvoir emprunter des livres.

## Environnement de développement

### Pré-requis

* Symfony 6.0
* PHP 8.1
* Composer
* Symfony CLI
* nodejs et npm

Vous pouvez vérifier les pré-requis avec la commande suivante (de la CLI Symfony) :

```bash
symfony check:requirement
```
### Lancer l'environnement de développement

bien vérifier si le fichier .env est bien dans votre environnement
Ne pas hésiter à la modifier

```bash
composer install
npm install
npm run build
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
symfony server:start -d
```

Mise en place des couleurs du théme
library\node_modules\bootstrap\scss\_variables.scss
On le pousse dans le :
library\assets\styles\custom.scss