<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

#  Définition : c’est quoi le "cache" en programmation ?
En programmation, un cache est un stockage temporaire utilisé pour enregistrer les résultats de calculs, requêtes, ou fichiers générés, afin d’éviter de les recalculer à chaque fois.




## Emplacement des fichiers de cache Laravel

# Cache général (sessions, données diverses...)
cache (données app) => storage/framework/cache/ 

# compiled (Fichiers précompilés pour améliorer les performances)
bootstrap/cache/ (nom du fichier => compiled.php, services.php)

# config (Contient toutes les configs combinées (depuis config/*.php))
bootstrap/cache/ (nom du fichier => config.php)

# events (Contient les events/listeners préchargés)
bootstrap/cache/ (nom du fichier => events.php)

# routes (Toutes les routes regroupées dans un seul fichier pour un chargement plus rapide)
bootstrap/cache/ (nom du fichier => routes-v7.php (ou routes.php))

# views (Vues Blade compilées en PHP)
storage/framework/views/ (nom du fichier => *.php fichiers compilés)


## Commandes Artisan pour gérer les caches dans Laravel

# Mettre en cache la configuration 
php artisan config:cache

# Supprimer ce cache de configuration
php artisan config:clear

# Mettre en cache les routes 
php artisan route:cache

# Supprimer le cache des routes 
php artisan route:clear

# Compiler les vues Blade 
php artisan view:cache

# Supprimer le cache des vues 
php artisan view:clear

# Mettre en cache les events/listeners 
php artisan event:cache

# Supprimer le cache des events/listeners
php artisan event:clear

# Supprime le cache d’application (clé-valeur, sessions, etc.)
php artisan cache:clear

#  Tout vider d’un coup (recommandé en dev)
php artisan optimize:clear

#
composer dump-autoload 



# php artisan migrate:refresh
Supprime les tables créées avec migrations en executant la methode down()
et relance toutes les migrations.

# php artisan migrate:fresh
Supprime toutes les tables (même celles créées sans migration)
et relance toutes les migrations. Très utile pour repartir de zéro rapidement

# php artisan make:seeder NomDuSeeder
créée un seeder

# php artisan make:factory NomFactory --model=NomDuModel
créée une Factory pour un modele

# php artisan db:seed --class=NomDuSeeder
exécute un seeder indépendamment, sans migrate:fresh

# php artisan migrate:fresh --seed
réinitialise la base et exécute les seeders.

# php artisan migrate:refresh --seed
réinitialise la base et exécute les seeders.

# composer show
Lister tous les packages installés dans ton projet via Composer, avec leurs versions.

# composer show NomDuPackage
Affiche les détails d’un package







