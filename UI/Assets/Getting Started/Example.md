---
title: Example
layout: toc_ui-assets
component: UI / Assets

---

## Declare a library

To declare a library you have to listen for the `rocket.assets.js` and `rocket.assets.css` events.

Here is an example taken from a RocketPropelledTortoise Library

```php
use Assetic\AssetManager;
use Assetic\Asset\AssetCollection;
use Rocket\UI\Assets\Assetic\Asset\AssetReference;
use Rocket\UI\Assets\Assetic\Asset\JsAsset;

Event::listen(
    'rocket.assets.js',
    function (AssetManager $am) {

        $jsdir = __DIR__ . '/js/assets/';

        $am->set('forms::pickadate_base', new JsAsset($jsdir . 'pickadate/picker.js'));
        $am->set('forms::pickadate_date', new JsAsset($jsdir . 'pickadate/picker.date.js'));
        $am->set('forms::pickadate_time', new JsAsset($jsdir . 'pickadate/picker.time.js'));


        $am->set(
            'forms::pickadate',
            new AssetCollection(
                array(
                    new AssetReference($am, 'forms::pickadate_base'),
                    new AssetReference($am, 'forms::pickadate_date'),
                )
            )
        );

        $am->set(
            'forms::pickatime',
            new AssetCollection(
                array(
                    new AssetReference($am, 'forms::pickadate_base'),
                    new AssetReference($am, 'forms::pickadate_time'),
                )
            )
        );

        $am->set(
            'forms::pickadatetime',
            new AssetCollection(
                array(
                    new AssetReference($am, 'forms::pickadate_base'),
                    new AssetReference($am, 'forms::pickadate_date'),
                    new AssetReference($am, 'forms::pickadate_time'),
                )
            )
        );
    }
);
```