The basic definition of a term is:

- A term contains a __title__ and a __description__.
- A term is a simple term or a category
- A term can be one language or more

## Term creation

    integer Taxonomy::getTermId(string $title, string|integer $vocabulary_id, integer $language_id = null, integer $type = Taxonomy::TERM_CONTENT)

The minimum to create a term is the title and the `vocabulary_id`, apart from `getTermIds` everywhere a `vocabulary_id` is requested, you can use the vocabulary name or its id.<br />
`Taxonomy::getTermId('A term', 'tag')` or `Taxonomy::getTermId('A term', Taxonomy::vocabulary('tag'))` both work

By default, if you don't specify the language, it will use the current language.

```php
// creating a simple term
$id = Taxonomy::getTermId('The title', 'tag');

// creating a term for another language
$id = Taxonom::getTermId('Un terme', 'tag', 2);
```

### Creating a category

A category is nothing more than a term with the category type.

```php
$id = Taxonomy::getTermId('Testing', 'tag', null, Taxonomy::TERM_CATEGORY)
```

### Creating a lot of terms a once

    array<integer> Taxonomy::getTermIds(array<string, array<string>> $taxonomies)

The creation of a lot of terms can be done for multiple vocabularies.
The return of the function is an array of ids with no separation between the vocabularies.

```php
$terms = [
    'tag' => ['Doc', 'Tutorial'],
    'artist' => ['Indochine', 'Dionysos']
];

$ids = Taxonomy::getTermIds($terms);
```

## Retrieving a term from database

```php
$id = Taxonomy::getTermId('The title', 'tag');

$term = Taxonomy::getTerm($id);
```

### Printing a term

You can simply output a term's title by echoing it.

```php
echo $term;
```

Or you can use these methods:

```php
echo $term['title'];
echo $term->title();
```

You can also get the description this way:

```php
echo $term['description'];
echo $term->description();
```

### Retrieving other languages

As a a vocabulary can be multilingual, when a term is retrieved it's with all it's languages so you can use them right away:

```php
echo $term->title('fr');
echo $term->description('fr');
```

If the language has not been translated, it will output the text in the language in which it was created, see with the following example:

```php
$id = Taxonomy::getTermId('The title', 'tag');
$term = Taxonomy::getTerm($id);

echo $term->title(); // The title
echo $term->title('fr'); // The title

$language = $term->editLanguage('fr') //TermData
$language->title = 'Le titre';
$language->save();

echo $term->title('fr'); // Le titre
```

To check if a language is already translated or not there is the `translated` method

```php
$id = Taxonomy::getTermId('The title', 'tag');
$term = Taxonomy::getTerm($id);

echo $term->translated('fr'); // false

$language = $term->editLanguage('fr') //TermData
$language->title = 'Le titre';
$language->save();

echo $term->translated('fr'); // true
```

### Simple term or category ?

A term can be one of `Taxonomy::TERM_CONTENT` or `Taxonomy::TERM_CATEGORY` this can be checked with

```php
$term->getType();
```

or

```php
$term->isSubcategory();
```

### Term ID

If needed, you can also get the term's id.

```php
$term->id();
```
