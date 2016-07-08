# Vendors

----------

Most projects will have a 'vendors/' folder containing all the CSS files from external libraries and frameworks. Putting those aside in the same folder is a good way to say "Hey, this is not from me, not my code, not my responsibility".

If you have to override a section of any vendor, I recommend you have a folder called 'vendors-extensions/' in which you may have files named exactly after the vendors they overwrite. This is to avoid editing the vendor files themselves, which is generally not a good idea.

