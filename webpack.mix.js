let mix = require('laravel-mix');

mix.setPublicPath('public');

mix.setResourceRoot('../');

mix.js('src/Boot.js', 'public/js/ninjalivechat-boot.js')
   .js('src/main.js', 'public/js/ninjalivechat-admin.js').vue()
   .sass('src/scss/common/livechat.scss', 'public/css/livechat.css')
   .sass('src/scss/admin/app.scss', 'public/css/ninjalivechat-admin.css')
   .copy('src/images', 'public/images')
   .copy('src/frontend', 'public/frontend');
