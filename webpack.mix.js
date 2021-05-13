let mix = require('laravel-mix');

mix.setPublicPath('public');

mix.setResourceRoot('../');

mix.js('src/Boot.js', 'public/js/ninjawhatsappchat-boot.js')
   .js('src/main.js', 'public/js/ninjawhatsappchat-admin.js').vue()
   .sass('src/scss/common/whatsappchat.scss', 'public/css/whatsappchat.css')
   .sass('src/scss/admin/app.scss', 'public/css/ninjawhatsappchat-admin.css')
   .copy('src/images', 'public/images')
   .copy('src/frontend', 'public/js');
