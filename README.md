# Overview #

It is very annoying to flush cache manually. To solve this issue, PHP Studios provides a solution.
### Features ###

* Select caches you want to flush from admin configuration.
* Flush selected caches from cache storage whenever a page is loaded from the frontend or backend.
* Show a message on the admin side after a successful cache flush.

### Key Features ###
* Set Enable Auto Cache Flush

The vendor has to set Enable Auto Cache Flush to ‘Yes’ to use this feature. The vendor will be able to see the cache types multi-select after enabling it.

* Flush specific cache types
The vendor(s) can select specific cache types that they want to flush automatically when they get invalidated.

* Success Message
After reloading the page, you’ll see a success message if any one of your selected cache types is invalidated.