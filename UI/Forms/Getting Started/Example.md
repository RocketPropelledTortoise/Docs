# Example

## PHP
A slightly better syntax is in preparation for PHP and Blde, but is not ready right now

``` php
    echo FE('email', 'Adresse E-mail, 'email')->width(6);
    echo FE('password', 'Mot de passe', 'password')->width(6);
    echo FE('remember', 'Se souvenir de moi', 'checkbox')->width(6);
```

## Blade
A slightly better syntax is in preparation for PHP and Blde, but is not ready right now

    {{ FE('email', 'Adresse E-mail, 'email')->width(6) }}
    {{ FE('password', 'Mot de passe', 'password')->width(6) }}
    {{ FE('remember', 'Se souvenir de moi', 'checkbox')->width(6) }}

## Twig
With the twig extension, it is very easy to create form fields with a fluid syntax

    {% form 'email' 'Adresse E-mail' 'email' width(6) %}
    {% form 'password' 'Mot de passe' 'password' width(6) %}
    {% form 'remember' 'Se souvenir de moi' 'checkbox' width(6) %}