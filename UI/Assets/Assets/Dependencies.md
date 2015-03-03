---
title: Dependencies
layout: toc_ui-assets
component: UI / Assets

---
The libraries can depend on each other, there are different options available for this

### Libraries loading order

Each asset has a `weight` property, with higher values; the asset sinks, with lower values; the asset rises.

```php
        $am->set('foundation_jquery', (new JsAsset($jsdir . 'jquery-1.11.0.min.js'))->setWeight(-100));
        $am->set('foundation_bootstrap', (new JsAsset($jsdir . 'bootstrap-3.1.1.min.js'))->setWeight(-99));

```

In this case, jquery has a weight of -100 (so it will be loaded first) and bootstrap has a weight of -99