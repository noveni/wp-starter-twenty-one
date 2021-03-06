let mix = require('laravel-mix');
var { CleanWebpackPlugin } = require('clean-webpack-plugin');
var FaviconsWebpackPlugin = require('favicons-webpack-plugin');
var StylelintPlugin = require('stylelint-webpack-plugin');
const path = require('path');

require("@tinypixelco/laravel-mix-wp-blocks")

// Front theme
mix.js('src/scripts/theme/index.js', 'js/theme.js')
    .block('src/scripts/admin/index.js', 'js/admin.js')
    .block('src/scripts/editor/index.js', 'js/editor.js')
    .block('src/scripts/theme-option-admin/index.js', 'js/theme-option-admin.js')
    .sass('src/styles/theme.scss', 'style.css')
    .sass('src/styles/editor.scss', 'editor.css')
    .sass('src/styles/theme-option-admin.scss', 'theme-option-admin.css')
    .sass('src/styles/admin-editor.scss', 'admin-editor.css')
    .sass('src/styles/woocommerce.scss', 'woocommerce.css')
    .options({
      fileLoaderDirs: {
        images: 'img',
        fonts: 'fonts'
      }
    });
    
mix.copy('src/blocks/**/*.php', 'assets/blocks/');
mix.setPublicPath('assets/');
mix.setResourceRoot('./');
mix.autoload({
  jquery: ['$', 'window.jQuery', 'jQuery'], // more than one
});

mix.sourceMaps(false, 'source-map');


mix.webpackConfig({
  module: {
    rules: [
      {
        test: [/.css$|.scss$/],
        use: [
          { 
            loader: "@epegzz/sass-vars-loader", 
            options: {
              syntax: 'scss',
              files: [
                // Option 2) Load vars from JSON file
                path.resolve(__dirname, 'themeConfig.json')
              ]
            }
          }
        ]
      },
    ]
  },
  plugins: [
    new StylelintPlugin({
      context: path.resolve(__dirname, 'src/styles'),
    }),
    new FaviconsWebpackPlugin({
      logo: path.resolve(__dirname, './src/favicon.png'),
      prefix: mix.inProduction() ? path.join('wp-content/themes', path.basename(__dirname), 'assets/icons') : './icons',
      outputPath: './icons/',
      inject: false,
      favicons: {
        appName: 'Ecran Noir',
        appDescription: 'Site Vitrine',
        developerName: null,
        developerURL: null, // prevent retrieving from the nearest package.json
        background: '#1D1D1B',
        theme_color: '#1D1D1B',
        icons: {
          coast: false,
          appleStartup: false,
          yandex: false,
          firefox: false
        }
      }
    })
  ]
});


if (mix.inProduction()) {
  mix.webpackConfig({
    plugins: [
      new CleanWebpackPlugin()
    ]
  })
}

mix.disableSuccessNotifications();


mix.browserSync({
  host: 'starter.localhost',
  open: 'external',
  proxy: {
    target: 'https://starter.localhost'
  },
  port: 3000,
  https: {
    key: path.resolve(process.env.HOME, 'Work/_tools/traefik-proxy/devcerts/starter.localhost+1-key.pem'),
    cert: path.resolve(process.env.HOME, 'Work/_tools/traefik-proxy/devcerts/starter.localhost+1.pem')
  },
  files: [
    "src/styles/**/*.scss",
    "src/scripts/",
    "src/blocks/",
    "template-parts/",
    "inc/*.php",
    "inc/**/*.php",
    "woocommerce/**/*.php",
    "classes/",
    "*.php"
  ]
});
