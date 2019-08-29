const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

// Copy
const CopyWebpackPlugin = require('copy-webpack-plugin');
// Zip
const ImageminPlugin = require('imagemin-webpack-plugin').default;
const ImageminMozjpeg = require('imagemin-mozjpeg');
const ImageminPngquant = require('imagemin-pngquant');
const ImageminGifsicle = require('imagemin-gifsicle');
const ImageminSvgo = require('imagemin-svgo');

module.exports = {
    mode: "development",
    entry: './assets/index.js',
    output: {
        path: path.resolve(__dirname, 'public'),
        filename: 'dist/bundle.js'
    },
    module: {
        rules: [
            {
                test: /\.scss$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    {
                        loader: 'css-loader'
                    },
                    {
                        loader: 'sass-loader',
                        options: {
                            sourceMap: true,
                            // options...
                        }
                    }
                ]
            },
            {
                test: /\.(gif|png|jpg|eot|wof|woff|woff2|ttf|svg)$/,
                use: [
                    {
                        loader: 'url-loader'
                    }
                ]
            }
        ]
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: 'dist/bundle.css'
        }),
        new CopyWebpackPlugin([{
            from: './assets',
            to: 'public/dist'
        }]),
        new ImageminPlugin({
            test: /\.(jpe?g|png|gif|svg)$/i,
            plugins: [
                ImageminMozjpeg({ quality: 80 }),
                ImageminPngquant({ quality: '65-80' }),
                ImageminGifsicle(),
                ImageminSvgo()
            ]
        })
    ]
};