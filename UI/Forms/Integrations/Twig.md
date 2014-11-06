---
title: Twig
layout: toc_ui-forms
component: UI / Forms

---
# Twig

There is an extension for Twig to allow you to simply create forms with.

```php
$twig->addExtension(new Rocket\UI\Forms\Support\Twig\Extension());
``

## Result

You'll be able to declare your fields like this :

    {{ "{% form 'email' 'Adresse E-mail' 'email' width(6) " }}%}
    {{ "{% form 'password' 'Mot de passe' 'password' width(6) " }}%}
    {{ "{% form 'remember' 'Se souvenir de moi' 'checkbox' width(6) " }}%}