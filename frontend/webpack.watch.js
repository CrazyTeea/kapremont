const path = require('path');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const VueLoaderPlugin = require('vue-loader/lib/plugin');

//console.log(path.resolve(__dirname, '../web/build/'), '11111111');
module.exports = {
    entry: './src/main.js',
    output: {

        path: path.resolve(__dirname, '../web/vue/'),
        filename: 'index.js',
        publicPath: `/vue/`,
    },
    mode: "development",
    devtool: 'source-map',
    module: {
        rules: [
            {
                test: /\.js/,
                exclude: /(node_modules|bower_components)/,
                use: [
                   // "source-map-loader",
                    'babel-loader'
                ],
               // enforce: "pre"
            },
            {
                test: /\.vue$/,
                loader: 'vue-loader'
            },
            {
                test: /\.css$/,
                use: [
                    'vue-style-loader',
                    'style-loader',
                    'css-loader',
                ]
            },
            {
                test: /\.scss$/,
                use: [
                    'style-loader',
                    {
                        loader: 'css-loader',
                        options: {
                            sourceMap: true,
                        },
                    },
                    {
                        loader: 'sass-loader',
                        options: {
                            sourceMap: true,
                        },
                    },
                ],
            },
        ],
    },

    plugins: [
        new ExtractTextPlugin('styles.css'),
        new BrowserSyncPlugin({
            // browse to http://localhost:3000/ during development,
            // ./public directory is being served
            host: 'localhost',
            port: 3000,
            proxy: 'http://localhost:8080/',
        }),
        new VueLoaderPlugin(),
    ],

    target: "web",
    resolve: {
        alias: {
            'vue$': 'vue/dist/vue.esm.js' // 'vue/dist/vue.common.js' для webpack 1
        },
        extensions: [
            '.css',
            '.js',
            '.jsx',
            '.scss',
        ],
    },
};