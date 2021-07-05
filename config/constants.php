<?php
return [
    // Site name
    'site_name' => 'Admin Panel',

    // Default page title prefix
    'page_title_prefix' => '',

    // Default page title
    'page_title' => '',

    // Google Analytics User ID
    'ga_id' => '',
    // Default meta data
    'meta_data' => array(
        'author' => '',
        'description' => '',
        'keywords' => ''
    ),

    // Default scripts to embed at page head or end
    'scripts' => array(
        'head' => array(
            'assets/dist/admin/adminlte.min.js',
            'assets/dist/admin/lib.min.js',
            'assets/dist/admin/app.min.js'
        ),
        'foot' => array(),
    ),

    // Default stylesheets to embed at page head
    'stylesheets' => array(
        'screen' => array(
            'assets/dist/admin/adminlte.min.css',
            'assets/dist/admin/lib.min.css',
            'assets/dist/admin/app.min.css'
        )
    ),

    // Default CSS class for <body> tag
    'body_class' => '',

    // Multilingual settings
    'languages' => array(),

    // Menu items
    'menu' => array(
        'home' => array(
            'name' => 'Home',
            'url' => '',
            'icon' => 'fa fa-home',
        ),
        'user' => array(
            'name' => 'Users',
            'url' => 'investor',
            'icon' => 'fa fa-users',
            'children' => array(
                'List' => 'admin/investor',
            )
        ),
        'buy_package' => array(
            'name' => 'Buy Package',
            'url' => 'admin/buy_package',
            'icon' => 'fa fa-users',
            'children' => array(
                'List' => 'admin/buy_package',
            )
        ),


        'logout' => array(
            'name' => 'Sign Out',
            'url' => 'admin/logout',
            'icon' => 'fa fa-sign-out',
        )
    ),

    // Login page
    'login_url' => 'admin/login',

    // Restricted pages
    'page_auth' => array(
        'user/create' => array('webmaster', 'admin', 'manager'),
        'user/group' => array('webmaster', 'admin', 'manager'),
        'panel' => array('webmaster'),
        'panel/admin_user' => array('webmaster'),
        'panel/admin_user_create' => array('webmaster'),
        'panel/admin_user_group' => array('webmaster'),
        'util' => array('webmaster'),
        'util/list_db' => array('webmaster'),
        'util/backup_db' => array('webmaster'),
        'util/restore_db' => array('webmaster'),
        'util/remove_db' => array('webmaster'),
    ),

    // AdminLTE settings
    'adminlte' => array(
        'body_class' => array(
            'webmaster' => 'skin-red',
            'admin' => 'skin-purple',
            'manager' => 'skin-black',
            'staff' => 'skin-blue',
        )
    ),

    // Useful links to display at bottom of sidemenu
    'useful_links' => array(
        array(
            'auth' => array('webmaster', 'admin', 'manager', 'staff'),
            'name' => 'Frontend Website',
            'url' => '',
            'target' => '_blank',
            'color' => 'text-aqua'
        ),
        array(
            'auth' => array('webmaster', 'admin'),
            'name' => 'API Site',
            'url' => 'api',
            'target' => '_blank',
            'color' => 'text-orange'
        ),
        array(
            'auth' => array('webmaster', 'admin', 'manager', 'staff'),
            'name' => 'Github Repo',
            'url' => '',
            'target' => '_blank',
            'color' => 'text-green'
        ),
    ),
// Email config
    'email' => array(
        'from_email' => '',
        'from_name' => '',
        'subject_prefix' => '',

        // Mailgun HTTP API
        'mailgun_api' => array(
            'domain' => '',
            'private_api_key' => ''
        ),
    ),
    // Debug tools
    'debug' => array(
        'view_data' => FALSE,
        'profiler' => FALSE
    ),
];
