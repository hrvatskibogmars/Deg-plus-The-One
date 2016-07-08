# The Degordian Pattern
----------

Writing CSS is hard. Even if you know all the intricacies of position, float, overflow, z-index etc., it's easy to end up with spaghetti code where you need inline styles, !important rules, unused cruft. 

N folders, 1 file

Basically, you have all your partials stuffed into different folders, and a single file at the root level (named main.scss)

main.scss - The main file shold be the only Sass file from the whole code base not to begin with an underscore. This file should not contain anything but @import and comments.

Folders:
- variables/
- helpers/
- base/
- frameworks/
- layout/
- modules/
- pages/
- themes/
- vendors/

```
One file to rule them all. One file to find them. One file to bring them all. And in The SASS way merge them. (Julien He)
```

# Commenting
Using "//" for your comments in Scss and they will not output in the compiled CSS

# Rules
One line for each selector or rule
Only nest 3 levels deep
Break files onto small modules (avoid having large SCSS files)
Avoid using IDs throughout the app/site. Use IDs for parent element like: header, footer, main...
If a :hover pseudo class is styled; :focus shold also be syled for accessibility.