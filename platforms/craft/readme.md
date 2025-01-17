# Y7K Craft Project

Version: See [project.json](project.json)
Changelog: See [changelog.md](changelog.md)

## Prerequisites

- [Git](http://git-scm.com/)
- [Node.js](http://nodejs.org/) (with NPM)
- [Composer](https://getcomposer.org/)

## Installation

1. `git clone <repository-url>` this repository
2. Change into the new directory
3. Install composer packages with `composer install`
4. Install node packages with `npm install`
5. Run `composer run-script project-created-cmd`
6. Set Project Domain and Database in `.env`
7. Install Craft at `yourdomain.test/admin`
8. If you're building a multi-language page, configure nginx accordingly (see [Multilanguage NGINX Setup](#user-content-multilanguage-nginx-setup) or example below)

## Favicons

- Replace all Favicons in `resources/images/meta/`
- Replace `favicon.ico` and `browserconfig.xml` in `public/` and `public/de/` 
- Use correct file-paths in `browserconfig.xml` and `resources/images/meta/manifest.json` 

## Development

### Local Server

You can use [Laravel Homestead](https://laravel.com/docs/master/homestead) as development server. Please read [these instructions](https://medium.com/@didgeoridoo/how-to-get-craft-cms-2-5-running-on-a-laravel-homestead-3-0-x-vagrant-box-556fe57ff807#.siftkm7kt) on how to set it up to get Craft running on it.
Run `npm run watch` to build and watch your files, while livereloading the browser via browser-sync. Visit [http://localhost:3000](http://localhost:3000) to view the page. It works as a proxy to your dev domain specified in the `.env` file. Use your original url for going to the CMS Backend tough.

### Build Assets

- Run `npm run dev`  for development build of all assets (non-minified)
- Run `npm run prod` for production build (minified sources and minified images) 

### Localtunnel

You can use [localtunnel](http://http://localtunnel.me/) to serve your local dev site to public internet access (for testing on other devices, webservices, api's etc.) like this: `lt --port 3000 --subdomain yourpreferedsubdomain`. If you're not using the browser-sync dev server at `localhost:3000`, you can define a host like this: `lt --local_host yourdomain.dev --port 80 --subdomain yourpreferedsubdomain`

## Multilanguage Setup

For Multilanguage support, add following entries to the servers *nginx* config.
Example with 'de' folder for German:

```
# Start Localization Rewrites
 
location /de/ {
        try_files $uri $uri/ @derewrites;
}

location @derewrites {
        rewrite ^/de/(.*)$ /de/index.php?$query_string;
}

# End Localization Rewrites
```

## Console
Access the Yii Command Runner by running `php console` from the project root (on the server or vm).
