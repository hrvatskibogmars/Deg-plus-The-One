This folder is base for partials for your page. Separating page elements into partials leads to better modularity and reusability.

Basic idea is as follows:

    1) Create ACF sections for page templates. Each section will represent a partial on the page.
    2) Fetch all fields in page template (so there are no multiple queries)
    3) Provide fetched data to the partial
    4) Generate output through partial



Proposed structure for elements in this folder is following:

    partials/
        about/
            contact.php
            history.php
        gallery/
            video


        ...



This way we can be consistent through multiple projects and we can "hop in" for temporal changes on different project.
