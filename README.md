# camagru

An instagram-like web app from Hive web-dev project. 
PHP/vanilla JS (mandated by the exercise). 
Allows users to upload or capture photos with a web camera and add stickers to the pictures as well as allow logged in user to comment and like the posts.


# Installation instructions
1. Set the correct database connection details in `config/database.php`
2. Run `php config/setup.php` to initialise the database.
3. Serve through a web server with PHP support or `php -S localhost:3000`
4. *Emails (e.g. registration confirmation email) are sent through PHP `mail()`, which may or may not work depending on your settings. 

# Dependencies
* PHP (>=7.1.0?) & PHP PDO extension (bundled)
* PHP MySQL & GD extensions (e.g. `apt-get install php7.3-mysql php7.3-gd` on Debian)
* MySQL (can probably be changed for another SQL DB, see `config/database.php`)

# Requirements/Features
- [x] No error/log messages anywhere
- [x] Tech: PHP backend, PDO database driver, no frameworks/libraries except pure CSS ones
- [x] Firefox >= 41 (kind of) and Chrome >= 46 compatibility
- [x] index.php must be in directory root

## Security
- [x] Passwords must be encrypted
- [x] No possibility of SQL injection
- [x] Sanitise user input/output
- [x] Disallow uploading of 'unwanted' content

## User account features
- [x] Mandate email validity and password complexity
- [x] Email validation through one-time link
- [x] 'Forgot password' feature
- [x] Possibility to log out on any page
- [x] Ability to change username, email, password and email notification state
- [x] Ability to receive email on new comments to user's posts

## Post/gallery features
- [x] Ability to comment on posts
- [x] Ability to like posts
- [x] Gallery pagination
- [x] Ability to delete posts

## Capture features
- [x] Only allow logged in users to access the page
- [x] Editing section and gallery section
- [x] Allow user to select filter
- [x] Capture/(upload?) button must be inactive if no filter is selected
- [x] Filter must be superposed onto the image in the back-end
- [x] Allow uploading image file from computer

