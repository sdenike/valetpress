# ValetPress

ValetPress allows for the quick installation and configuration of WordPress install for local development and testing. The idea of this script was inspired by the script that [@AaronRutley](https://twitter.com/AaronRutley) originally created (https://github.com/AaronRutley/valetpress) but has been written from the ground up to provide cleaner code, as well as adding/removing features that I felt were or were not necessary for my daily usage.

## What?

The script itself uses Laravel Valet and WP-CLI to speed up the creation of a WordPress install on your local system.  Before @AaronRutley demoed his script to me I was using MAMP, and/or manually setting up installs on my computer which was far more time-consuming than his script was.

## Why?

While the original script works great… I got bored and decided to rewrite it for my own needs.

## Features

- Create a fresh WordPress site in a few seconds
- Download, Install and activate WordPress
- Auto-login to the new WordPress install
- Easily delete the WordPress install(s)

## To install
1. Setup Laravel Valet / MySQL [Instructions](https://laravel.com/docs/5.6/valet#installation)
2. Download / Clone this repo into a directory such as `~/Scripts/valetpress`
3. Include the `vp` script in your `.bash_profile` or `.zshrc` file
4. A Brewfile is included to help with the dependencies that are needed. `brew bundle`
5. Update the `config.json` file to reflect your needed settings. (see the 'Config Explained' section below)

## Available Commands:

`vp create`

- Download WordPress into a directory like `~/Sites/myproject` as specified in the config.json
- Setup the database called `myproject` & configure the install
- Create a user `admin` with the password `password`
- Have `myproject.test` running in just a few seconds

`vp delete`

- Lists all ValetPress installations 
- Will ask for the name of the project you would like to delete
- Ask you to confirm that you wish to delete the project
- Deletes the database for that project
- Deletes the directory for that project

`vp help`

- Will display a summary of available commands

## Config Explained
 - `wp_admin_email` is used as the admin email address for new WP installs. 
 - `wp_admin_user` is used as the username for new WP installs. [If changed you must update the username in the valetpress plugin](https://github.com/SystmWeb/valetpress/blob/master/plugins/valetpress/valetpress.php#L17)
 - `wp_admin_password` is used as the password for new WP installs. [If changed you must update the password in the valetpress plugin](https://github.com/SystmWeb/valetpress/blob/master/plugins/valetpress/valetpress.php#L18)
 - `sites_folder` is a directory that you've run `valet park` in to serve sites.
 - `open_browser` if set to `1` a browser will auto-open after the install completes, `0` will make so that it doesn't
 - `browser` you can set the default browser such as Safari, Google Chrome, etc
 - `valet_domain` Default is set to `test` but you can change this to whatever you use for Valet, this can be adjusted by using `valet domain TLDTOUSE`
 - `plugins_add` Plugins that you wish to install/activate on each new install
 - `plugins_remove` Plugins that you wish to remove from the default installs
 - `auto_update` Enabled auto-updates to core, plugin and theme. 0 = Disabled, 1 = Enabled
 - `php` Specify the location of PHP
 - `valet` Specify the location of Laravel Valet
 - `wpcli` Specify the location of WP-CLI
 
## Requirements

Below you will find a list of all required system files in order for ValetPress to properly work.

- [Valet](https://laravel.com/docs/5.2/valet) - With out this sites will not load
- MySQL or MariaDB - Needed for WordPress
- [Homebrew](https://brew.sh) - Used for installing MySQL/PHP/etc
- [jq](https://stedolan.github.io/jq/) - Used for reading the config file
- [WP-CLI](https://wp-cli.org/) - Needed to complete WordPress installs.

Note: You will need to add the ValetPress directory to your $PATH in your `.bash_profile` or `.zshrc` so that you can run the `vp` command from anywhere on your computer.