---
title: Working with terms
layout: toc_core-taxonomy
component: Core / Taxonomy

---
# Working with terms

A term contains a __title__ and a __description__.<br />
A term is a simple term or a category<br />
A term can be one language or more


## Term creation

    integer Taxonomy::getTermId(string $title, string|integer $vocabulary_id, integer $language_id = null, integer $type = Taxonomy::TERM_CONTENT)

The minimum to create a term is the title and the `vocabulary_id`, apart from `getTermIds` everywhere a `vocabulary_id` is requested, you can use the vocabulary name or its id.<br />
`Taxonomy::getTermId('A term', 'tag')` or `Taxonomy::getTermId('A term', Taxonomy::vocabulary('tag'))` both work

By default, if you don't specify the language, it will use the current language.

    // creating a simple term
    $id = Taxonomy::getTermId('The title', 'tag');

    // creating a term for another language
    $id = Taxonom::getTermId('Un terme', 'tag', 2);


### Creating a category

A category is nothing more than a term with the category type.

    $id = Taxonomy::getTermId('Testing', 'tag', null, Taxonomy::TERM_CATEGORY)

### Creating a lot of terms a once

    array<integer> Taxonomy::getTermIds(array<string, array<string>> $taxonomies)

The creation of a lot of terms can be done for multiple vocabularies.
The return of the function is an array of ids with no separation between the vocabularies.

    $terms = [
        'tag' => ['Doc', 'Tutorial'],
        'artist' => ['Indochine', 'Dionysos']
    ];

    $ids = Taxonomy::getTermIds($terms);

## Retrieving a term from database

    $id = Taxonomy::getTermId('The title', 'tag');

    $term = Taxonomy::getTerm($id);

### Printing a term

You can simply output a term's title by echoing it.

   echo $term;

Or you can use these methods:

    echo $term['title'];
    echo $term->title();

You can also get the description this way:

    echo $term['description'];
    echo $term->description();

### Retrieving other languages

As a a vocabulary can be multilingual, when a term is retrieved it's with all it's languages so you can use them right away:

    echo $term->title('fr');
    echo $term->description('fr');

If the language has not been translated, it will output the text in the language in which it was created, see with the following example:

    $id = Taxonomy::getTermId('The title', 'tag');
    $term = Taxonomy::getTerm($id);

    echo $term->title(); // The title
    echo $term->title('fr'); // The title

    $language = $term->editLanguage('fr') //TermData
    $language->title = 'Le titre';
    $language->save();

    echo $term->title('fr'); // Le titre

To check if a language is already translated or not there is the `translated` method

    $id = Taxonomy::getTermId('The title', 'tag');
    $term = Taxonomy::getTerm($id);

    echo $term->translated('fr'); // false

    $language = $term->editLanguage('fr') //TermData
    $language->title = 'Le titre';
    $language->save();

    echo $term->translated('fr'); // true

### Simple term or category ?

A term can be one of `Taxonomy::TERM_CONTENT` or `Taxonomy::TERM_CATEGORY` this can be checked with


    $term->getType();

or

    $term->isSubcategory();

### Term ID

If needed, you can also get the term's id.

    $term->id();
