const path = require('path');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const VueLoaderPlugin = require('vue-loader/lib/plugin');

//console.log(path.resolve(__dirname, '../web/build/'), '11111111');
module.exports = {
    entry: './src/main.js',
    output: {
        path: path.resolve(__dirname, '../web/vue/'),
        filename: 'index.js',
        publicPath: `/vue/`,
    },
    performance: {
        maxEntrypointSize: 512000,
        maxAssetSize: 512000
    },
    mode: "production",
    //devtool: 'source-map',
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
                            sourceMap: false,
                        },
                    },
                    {
                        loader: 'sass-loader',
                        options: {
                            sourceMap: false,
                        },
                    },
                ],
            },
        ],
    },

    plugins: [
        new ExtractTextPlugin('styles.css'),
        new VueLoaderPlugin()
    ],

    target: "web",
    resolve: {
        extensions: [
            '.css',
            '.js',
            '.jsx',
            '.scss',
        ],
    },
};