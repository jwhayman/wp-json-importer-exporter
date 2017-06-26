'use strict';

const webpack = require('webpack');
const autoprefixer = require('autoprefixer');
const path = require('path');
const rootPath = process.cwd();

const BrowserSyncPlugin = require('browsersync-webpack-plugin');
const ExtractTextPlugin = require('extract-text-webpack-plugin');

let webpackConfig = {
    entry: {
        main: [
            "./assets/scripts/main.js",
            "./assets/styles/main.scss"
        ]
    },
    output: {
        filename: "./assets/dist/main.js"
    },
    module: {
        rules: [
            {
                test: /\.css$/,
                include: path.join(rootPath, "/assets/styles/"),
                use: ExtractTextPlugin.extract({
                    fallback: "style-loader",
                    use: [
                        "css-loader",
                        "postcss"
                    ]
                })
            },
            {
                test: /\.scss$/,
                include: path.join(rootPath, "/assets/styles/"),
                use: ExtractTextPlugin.extract({
                    fallback: "style-loader",
                    use: [
                        "css-loader",
                        //"postcss-loader",
                        "resolve-url-loader",
                        "sass-loader"
                    ]
                })
            }
        ]
    },
    plugins: [
        new ExtractTextPlugin({
            filename: "./assets/dist/main.css",
            allChunks: true
        }),
        new webpack.LoaderOptionsPlugin({
            test: /\.s?css$/,
            options: {
                output: {
                    path: "./assets/dist"
                },
                context: "./assets/styles",
                postcss: [
                    autoprefixer()
                ]
            }
        })
    ]

};

module.exports = webpackConfig;