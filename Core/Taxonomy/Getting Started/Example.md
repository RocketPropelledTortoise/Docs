---
title: Example
layout: toc_core-taxonomy
component: Core / Taxonomy

---

### Declare a library

To declare a library you have to listen for the `rocket.assets.js` and `rocket.assets.css` events.

Here is an example taken from a RocketPropelledTortoise Library

```php
use Taxonomy;
use Model;

use Rocket\Taxonomy\TaxonomyTrait;
use Rocket\Translation\Model\Language;
use Schema;

class Post extends Model {

    // add the taxonomy trait
    use TaxonomyTrait;

    public $fillable = ['content'];
}


Vocabulary::insert(['name' => 'Tag', 'machine_name' => 'tag', 'hierarchy' => 0, 'translatable' => true]);

// create the post
$post = new Post(['content' => 'a test post']);
$post->save();

// add the tags to it
$ids = T::getTermIds(['tag' => ['TDD', 'PHP', 'Add some tags']]);
$post->setTerms($ids);

// get the tags from the Post
$terms = $post->getTerms('tag')

```
