# Hierarchies

This documentation needs to be expanded...

### Adding a parent

    Taxonomy::addParent(integer $term_id, integer $parent_term_id);

    $term->addParent(integer $parent_id)

    $term->addParents(array<integer> $parents)

### Replacing all parents

    $term->setParent(integer $parent_id)

    $term->setParents(array<integer> $parents)

### Removing all parents

    Taxonomy::unsetParents($term_id)

    $term->setParents([])
