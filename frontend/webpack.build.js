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
    module: {
        rules: [
            {
                test: /\.js/,
                exclude: /(node_modules|bower_components)/,
                use: [{
                    loader: 'babel-loader',
                }],
            },
            {
                test: /\.vue$/,
                loader: 'vue-loader'
            },
            {
                test: /\.css$/,
                use: [
                    'vue-style-loader',
                    'css-loader'
                ]
            },
            {
                test: /\.scss$/,
                use: ExtractTextPlugin.extract({
                    fallback: 'style-loader',
                    use: [

                        {
                            loader: 'css-loader',
                            options: {
                                importLoaders: 1,
                                sourceMap: true,
                            },
                        },
                        {
                            loader: 'postcss-loader',
                            options: {
                                sourceMap: true,
                                config: {
                                    path: 'postcss.config.js',
                                },
                            },
                        },
                    ],
                }),
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