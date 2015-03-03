
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
    function (Assetic\AssetManager $am) {

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

## Change an asset

When you add an element to the Asset manager, it is simply by key => value, so if you call `set` again with the same key but another asset it will replace it and when you require it will take your file instead of the default one.

This can be very useful if for some special case, you need to load a different version of jQuery or you made a custom Twitter Bootstrap base theme.

By getting the asset you can also change it directly. here are some examples.


```php
		//change asset
        $am->set('foundation_jquery', (new JsAsset($jsdir . 'jquery-2.0.0.min.js'))->setWeight(-100));

        //change weight
        $am->get('foundation_bootstrap')->setWeight(-99);

```