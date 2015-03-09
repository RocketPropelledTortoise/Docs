
```php
Table::quick($header, $rows, $attributes = array(), $caption = null)
```

## Header
Header is the first parameter of the `Table::quick()` method
You can add classes like you would for any other cell.

But you can not add more than one line of header.

## Caption

Caption will create a `<caption>` tag in your table. it's the fourth parameter in `Table::quick()`

## Footer

To add a footer, you have to set `'footer' => true` in one or more rows.

Like in the following example:

```php
$content = [

    // <tr><td>Dr. No</td><td>Ian Fleming</td></tr>
    ['Dr. No', 'Ian Fleming'],

    // <tfoot>
    // <tr data-id="1"><td>The Catcher in the Rye</td><td>J. D. Salinger</td></tr>
    // </tfoot>
    ['footer' => true, 'data' => ['The Catcher in the Rye', 'J. D. Salinger']]

]
```
