/* eslint-disable */
const fs = require('fs');
const { resolve } = require('path');
const webpack = require('webpack');

/**
 * Plugins
 */
const EventHooksPlugin = require('event-hooks-webpack-plugin');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const TerserPlugin = require('terser-webpack-plugin');
const RemovePlugin = require('remove-files-webpack-plugin');

module.exports = () => {
    const inProduction = process.env.NODE_ENV === 'production';
    const siteUrl = process.env.SITE_URL;
    const assetPath = 'assets';
    const themePath = 'wp-content/themes/stationfive';

    let config = {
        resolve: {
            extensions: ['.js'],
            alias: {
                moment$: 'moment/moment.js',
            },
        },

        context: resolve(__dirname, `./${assetPath}`),

        module: {
            rules: [
                {
                    test: /\.(js)$/,
                    exclude: /node_modules/,
                    use: {
                        loader: 'babel-loader',
                    },
                },

                {
                    test: /\.(scss|sass)$/,
                    use: [
                        MiniCssExtractPlugin.loader,
                        'css-loader',
                        'sass-loader'
                    ]
                },

                {
                    test: /\.(jpe?g|png|gif|svg)$/i,
                    loaders: [
                        `file-loader?hash=sha512&digest=hex&name=/${
                            assetPath
                        }/public/images/webpack/[hash].[ext]`,
                        'image-webpack-loader?bypassOnDebug&optipng.optimizationLevel=7&gifsicle.interlaced=false'
                    ]
                },

                {
                    test: /\.(woff|woff2)$/,
                    loader: `url-loader?limit=10000&name=/${
                        assetPath
                    }/public/fonts/[hash].[ext]`
                },

                {
                    test: /\.(ttf|eot)$/,
                    loader: `file-loader?name=/${
                        assetPath
                    }/public/fonts/[hash].[ext]`
                },

                {
                    test: /\.css$/,
                    use: ['style-loader', 'css-loader']
                },

                // resolve jQuery/$ plugin to all
                {
                    test: require.resolve('jquery'),
                    use: [
                        {
                            loader: 'expose-loader',
                            options: 'jQuery'
                        },

                        {
                            loader: 'expose-loader',
                            options: '$'
                        }
                    ]
                }
            ]
        },

        performance: {
            hints: false
        },

        mode: `${process.env.NODE_ENV}`,
        entry: {
            'main': ['@babel/polyfill', './script.js', './style.scss'],
        },

        output: {
            path: resolve(__dirname, ''),
            publicPath: `/${themePath}`,
            filename: `${assetPath}/public/js/[name].bundle.js`,
            chunkFilename: `${assetPath}/public/js/[name].bundle.js`
        },

        optimization: {
            minimize: true,
            minimizer: [
                new TerserPlugin({
                    test: /\.js(\?.*)?$/i,
                    sourceMap: true,
                    extractComments: false,
                    terserOptions: {
                        output: {
                            comments: false
                        }
                    }
                }),

                new OptimizeCSSAssetsPlugin({
                    cssProcessorPluginOptions: {
                        preset: [
                            'default',
                            { discardComments: { removeAll: true } }
                        ]
                    }
                })
            ],
            splitChunks: {
                automaticNameDelimiter: '-',
                cacheGroups: {
                    vendor: {
                        test: /[\\/]node_modules[\\/]/,
                        name: 'vendor',
                        chunks: 'all',
                        enforce: true
                    }
                }
            }
        },

        plugins: [
            new RemovePlugin({
                /**
                 * Before compilation removes entire `public` folder.
                 */ 
                before: {
                    include: [`${assetPath}/public`]
                },
            }),

            new webpack.ProvidePlugin({
                $: 'jquery',
                jQuery: 'jquery',
                'window.jQuery': 'jquery'
            }),

            new MiniCssExtractPlugin({
                // define where to save the file
                filename: `${assetPath}/public/css/[name].bundle.css`,
                disable: false,
                allChunks: true
            }),
        ]
    };

    if (!inProduction) {
        // Use source maps
        config.devtool = 'sourcemap';

        config.plugins.push(
            new BrowserSyncPlugin({
                proxy: siteUrl,
                open: true,
                notify: false,
            }),
        );
    }

    return config;
};
