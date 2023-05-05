const path = require('path');
const miniCss = require('mini-css-extract-plugin');

module.exports = {
    mode: "production",
    entry: './wordpress/wp-content/themes/myTheme/webpack/index.js',
    output: {
        path: path.resolve(__dirname, './wordpress/wp-content/themes/myTheme/assets'),
        filename: "js/main.js"
    },
    module: {
        rules: [
            {
                test: /\.(scss|css)$/,
                use: [
                    miniCss.loader,
                    {
                        loader : 'css-loader',
                        options: { url : false }
                    },
                    'sass-loader'
                ],
            },
        ],
    },
    plugins: [
        new miniCss({
            filename: 'css/my-theme.css',
        }),
    ]
}