# ValetPress

ValetPress is a script that allows for the quick installation and configuration of WordPress for local development and testing. This is a full rewrite of the code that @AaronRutley originally created (https://github.com/AaronRutley/valetpress) but has been written from the ground up to add other features that I found the need for in my local setup.

## Features

- Create a fresh WordPress site in a few seconds
- Download, Install and activate WordPress
- Auto login to the new WordPress install
- Easily delete the WordPress install(s)

## To install
1. Setup Laravel Valet / MySQL [Instructions](https://laravel.com/docs/5.6/valet#installation)
2. Download / Clone this repo into a directory such as `~/Scripts/valetpress`
3. Include the `vp` script in your `.bash_profile` or `.zshrc` file
4. Run `vp install` to install all dependencies (This command currently does not work, everything must already be installed. Please see the 'Requirements' section of the readme.)
5. Update the `config.json` file to reflect your needed settings. (see the 'Config Explained' section below)

## Available Commands:

`vp create`

- Download WordPress into a directory like `~/Sites/myproject` as specified in the config.json
- Setup the database called `myproject` & configure the install
- Create a user `shelby` with the password `password`
- Have `myproject.test` running in just a few seconds

`vp delete`

- Lists all ValetPress installations 
- Will ask for the name of the project you would like to delete
- Ask you to confim that you wish to delete the project
- Deletes the database for that project
- Deletes the directory for that project

`vp help`

- Will display a summary of available commands

## Config Explained
 - `wp_admin_email` is used as the admin email address for new WP installs.
 - `wp_admin_user` is used as the username for new WP installs.
 - `wp_admin_password` is used as the password for new WP installs.
 - `sites_folder` is a directory that you've run `valet park` in to serve sites.
 - `open_browser` if set to 1 a browser will auto open after an install, 0 will make so it doesn't.
 - `browser` you can set the default browser such as Safari, or Google Chrome, etc
 - `valet_domain` Default is set to `test` but you can change this to whatever you use for Valet, this can be adjusted by using `valet domain TLDTOUSE`
 
## Requirements

Below you will find a list of all required system files in order for ValetPress to proper work.

- [Valet](https://laravel.com/docs/5.2/valet) - With out this sites will not load
- MySQL or MariaDB - Needed for WordPress
- [Homebrew](https://brew.sh) - Used for installing MySQL/PHP/etc
- [jq](https://stedolan.github.io/jq/) - Used for reading the config file
- [WP-CLI](https://wp-cli.org/) - Needed to complete WordPress installs
- [TGMPA WP-CLI plugin](https://github.com/itspriddle/wp-cli-tgmpa-plugin) - Used for WordPress plugin activation

Note: You will need to add the ValetPress directory to your $PATH in your .bash_profile or .zshrc so that you can run the `vp` command from anywhere on your computer.