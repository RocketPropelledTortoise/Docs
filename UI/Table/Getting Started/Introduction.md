---
title: Introduction
layout: toc_ui-table
component: UI / Table

---
Generating tables is not complicated, but generating them with code is very verbose.

This helper makes table generation very easy.

```php

$heads = ['Title', 'Author'];

$content = [
    ['Dr. No', 'Ian Fleming'],
    ['The Catcher in the Rye', 'J. D. Salinger']
];

echo \Rocket\UI\Table\Table::quick($heads, $content);
```

Will output

```html
<table class="table table-striped sticky-enabled">
<thead>
<tr><th>Title</th><th>Author</th></tr>
</thead><tbody>
<tr><td>Dr. No</td><td>Ian Fleming</td></tr>
<tr><td>The Catcher in the Rye</td><td>J. D. Salinger</td></tr>
</tbody>
</table>
```
