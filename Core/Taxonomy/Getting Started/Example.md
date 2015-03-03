---
title: Example
layout: toc_core-taxonomy
component: Core / Taxonomy

---

## Using the Taxonomy module

In this example, we use the table `posts` as our content and will add some tags to it.

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
