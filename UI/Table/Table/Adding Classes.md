---
title: Adding Classes
layout: toc_ui-table
component: UI / Table

---
You can add classes and attributes to a table, row or cell.

## Table

```php
Table::quick($header, $rows, $attributes = array(), $caption = null)
```

Adding attributes to a table is just a matter of setting them as an array in the `attributes` parameter

## Row

To add classes and parameters to rows. wrap the row in an array, and put the data in a `data` key


```php
$content = [

    // <tr><td>Dr. No</td><td>Ian Fleming</td></tr>
    ['Dr. No', 'Ian Fleming'],

    // <tr data-id="1"><td>The Catcher in the Rye</td><td>J. D. Salinger</td></tr>
    ['data-id' => '1', 'data' => ['The Catcher in the Rye', 'J. D. Salinger']]

]
```

## Cell

The same principles apply for the cells than for the row:

```php
$content = [

    // <tr><td>Dr. No</td><td>Ian Fleming</td></tr>
    ['Dr. No', 'Ian Fleming'],

    // <tr><td>The Catcher in the Rye</td><td class="cell-danger">J. D. Salinger</td></tr>
    ['The Catcher in the Rye', ['class' => 'cell-danger', 'data' => 'J. D. Salinger']]

]
```
