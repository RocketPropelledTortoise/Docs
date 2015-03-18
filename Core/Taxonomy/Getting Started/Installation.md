---
title: Installation
layout: toc_core-taxonomy
component: Core / Taxonomy

---
## Service Provider

You need to add both the Taxonomy and Translation Service Providers

    '\Rocket\Translation\Support\Laravel5\ServiceProvider',
    '\Rocket\Taxonomy\Support\Laravel5\ServiceProvider'

## Aliases

    'I18N' => '\Rocket\Translation\Support\Laravel5\Facade',
    'Taxonomy' => '\Rocket\Taxonomy\Support\Laravel5\Facade',

## Migrations

    php artisan migrate --path Translation/migrations
    php artisan migrate --path Taxonomy/migrations
