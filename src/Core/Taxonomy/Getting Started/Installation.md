## Service Provider

You need to add both the Taxonomy and Translation Service Providers

    '\Rocket\Translation\TranslationServiceProvider',
    '\Rocket\Taxonomy\ServiceProvider'

## Aliases

    'I18N' => '\Rocket\Translation\I18NFacade',
    'Taxonomy' => '\Illuminate\Support\Facades\Facade',

## Migrations

    php artisan migrate --path Translation/migrations
    php artisan migrate --path Taxonomy/migrations

