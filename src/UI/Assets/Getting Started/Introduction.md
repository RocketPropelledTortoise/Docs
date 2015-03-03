## About
In any web application you need to load Javascript and CSS files to work.
With more and more plugins, parts and modules, you need an optimal way to load them.

Require JS techniques are now the de-facto standard to load javascript. But I will bring it a step further, this is a require JS backend.


## How it works

You declare your assets on the backend, jquery, bootstrap, whatever..., declare their dependencies this would give for example:

    ++ bootstrap.popover -> bootstrap.popover.min.js
    |++ bootstrap.tooltip -> bootstrap.tooltip.min.js
    | +- jquery -> jquery.min.js
    ++ jquery.maxlength -> jquery.maxlength.js
     +- jquery -> jquery.min.js

If you have these libraries declared, you can load them this way:

- `http://server/_assets/jquery.js` -> this loads jQuery only
- `http://server/_assets/bootstrap.tooltip.js` -> this loads jQuery and bootstrap.tooltip (in that order)
- `http://server/_assets/bootstrap.popover,jquery.maxlength.js` -> this loads jquery, bootstrap.tooltip, bootstrap.popover, jquery.maxlength

This works the same way with CSS :
- `http://server/_assets/bootstrap.css`
- `http://server/_assets/bootstrap.theme.css`

## What it is not

This asset manager will not provide server side support to generate/minify your `less`, `sass`, `coffeescript` or other languages, other tools like `grunt` or `gulp` are better suited for that task.

The asset manager's role is only to concatenate and serve the assets, but if you want to do it, you can, as we depend on Kris Wallsmith's Assetic package
