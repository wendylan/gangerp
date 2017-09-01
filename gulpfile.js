var elixir = require('laravel-elixir');
require('laravel-elixir-webpack');
require("vue");

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

// elixir(function(mix) {
//     mix.sass('app.scss')
//     .webpack('app.js');
// });

elixir(function(mix) {
    mix.sass('app.scss')
    .webpack('app.js', {
        module: {
          loaders: [
            // 解析.vue文件
            { test: /\.vue$/, loader: 'vue' },
        // 转化ES6的语法
            { test: /\.js$/, loader: 'babel', exclude: /node_modules/ },
        // 编译css并自动添加css前缀
            { test: /\.css$/, loader: 'style!css!autoprefixer'},
        //.scss 文件想要编译，scss就需要这些东西！来编译处理
        //install css-loader style-loader sass-loader node-sass --save-dev
            { test: /\.scss$/, loader: 'style!css!sass?sourceMap'},
        // 图片转化，小于8K自动转化为base64的编码
            { test: /\.(png|jpg|gif)$/, loader: 'url-loader?limit=8192'},
        //html模板编译？
            { test: /\.(html|tpl)$/, loader: 'html-loader' }
          ],
        },
        alias: {            
            'vue'  : 'vue/dist/vue.min'
        }
    });
});