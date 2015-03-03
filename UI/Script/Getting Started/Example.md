---
title: Example
layout: toc_ui-script
component: UI / Script

---
``` php
JS::ready(' console.log("you\'re a wizard, Harry!"); ');
JS::ready(' console.log("Dobby is freeeee!"); ');
```

Will produce

``` javascript
<script>
$(function() {
    console.log("you're a wizard, Harry!");
    
    //---
    
    console.log("Dobby is freeeee!");
});
</script>
```