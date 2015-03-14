---
title: Hierarchies
layout: toc_core-taxonomy
component: Core / Taxonomy

---
A Vocabulary can be one of three hierarchy types:

- None: no hierarchy
- Simple: one parent per term
- Multiple: each term can have many parents

You can use the following methods to edit the parents of a term

## Adding a parent

    Taxonomy::addParent(integer $term_id, integer $parent_term_id);

    $term->addParent(integer $parent_id)

    $term->addParents(array<integer> $parents)

## Replacing all parents

    $term->setParent(integer $parent_id)

    $term->setParents(array<integer> $parents)

## Removing all parents

    Taxonomy::unsetParents($term_id)

    $term->setParents([])
