const mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js("resources/js/app.js", "public/js")
    .sass("resources/sass/app.scss", "public/css")
    .scripts(
        [
            "resources/assets/js/jquery.min.js",
            "resources/assets/js/bootstrap.bundle.min.js",
            "resources/assets/js/jquery.slimscroll.js",
            "resources/assets/js/metisMenu.min.js",
            "resources/assets/js/waves.min.js",
            "resources/assets/plugins/jquery-sparkline/jquery.sparkline.min.js",
            // "resources/assets/js/select2.min.js",
            "resources/assets/js/app.js"
        ],
        "public/admin_template/js/all.js"
    )
    .styles(
        [
            "resources/assets/css/bootstrap.min.css",
            "resources/assets/css/icons.css",
            "resources/assets/css/metismenu.min.css",
            // "resources/assets/css/select2.min.css",
            // "resources/assets/css/select2-bootstrap4.css",
            "resources/assets/css/style.css"
        ],
        "public/admin_template/css/all.css"
    )
    .copyDirectory("resources/assets/fonts", "public/admin_template/fonts")
    .copyDirectory("resources/assets/images", "public/admin_template/images");
