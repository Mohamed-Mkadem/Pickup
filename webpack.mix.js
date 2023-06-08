const mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.sass("resources/sass/fe_dark.scss", "public/dist/css")
    .sass("resources/sass/app_dark.scss", "public/dist/css")
    .sass("resources/sass/utilities.scss", "public/dist/css");
mix.sass("resources/sass/fe.scss", "public/dist/css").options({
    processCssUrls: false,
});
mix.sass("resources/sass/app.scss", "public/dist/css");
// mix.sass("resources/sass/main.scss", "public/css").sass(
//     "resources/sass/test.scss",
//     "public/css"
// );
