# la médiathèque de La Chapelle-Curreaux

La Réserve de la Chapelle (la médiathèque de La Chapelle-Curreaux) est un site internet pour pouvoir emprunter des livres.

## Environnement de développement

### Pré-requis

* PHP 8.1
* Composer
* Symfony CLI

Vous pouvez vérifier les pré-requis avec la commande suivante (de la CLI Symfony) :

```bash
symfony check:requirement
```
### Lancer l'environnement de développement

bien vérifier si le fichier .env est bien dans votre environnement
Ne pas hésiter à la modifier

```bash
symfony console doctrine:database:create
symfony console doctrine:migrate:migration
symfony server:start -d
```