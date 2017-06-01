<?php

/**
 * General Configuration
 *
 * All of your system's general configuration settings go in here.
 * You can see a list of the default settings in craft/app/etc/config/defaults/general.php
 */


return [

    '*' => [
        'omitScriptNameInUrls' => true,
        'usePathInfo' => true,
        'convertFilenamesToAscii' => true, // Convert upload filenames to valid ascii chars
        'limitAutoSlugsToAscii' => true, // Converts Umlauts etc. in slugs to ascii
        'enableCsrfProtection' => true, // Enable CSRF protection (will be default in Craft 3)
        'cacheDuration' => 'P2W', // Set default template caching time to 2 weeks
        'generateTransformsBeforePageLoad' => true, // Generate Image Transforms before page load. Else caching may be a problem
        'sendPoweredByHeader' => false, // Disable sending a "Powered by Craft" header
        'defaultWeekStartDay' => 1, // Start Week on Monday
        'allowAutoUpdates' => (getenv('APP_ENV') == 'local') ? 'minor-only' : false, // Disable auto-updates on servers
        'timezone' => 'Europe/Zurich', // Set Timezone to Zurich
        'cpTrigger' => 'admin',

        // Restrict upload to certain extensions
//        'allowedFileExtensions' => 'json, jpg, jpeg, png, gif, pdf, zip',
        // Allow upload of Json files, also used for external Video Plugin
        'extraAllowedFileExtensions' => 'json',

        'devMode' => (getenv('APP_DEBUG')=='true'),
        'enableTemplateCaching' => (getenv('TEMPLATE_CACHING')=='true'),

        'appId' => getenv('APP_NAME'),
        'appEnv' => getenv('APP_ENV'),
        'piwikSiteId' => getenv('PIWIK_SITE_ID'),

        'siteUrl' => [
            'en' => getenv('APP_URL') . '/',
//            'de' => getenv('APP_URL') . '/de/',
        ],

        'environmentVariables' => [
            'basePath' => $_SERVER['DOCUMENT_ROOT'],
        ]

    ],

];