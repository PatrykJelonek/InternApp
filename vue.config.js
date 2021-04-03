const SentryWebpackPlugin = require("@sentry/webpack-plugin");

module.exports = {
    configureWebpack: {
        plugins: [
            new SentryWebpackPlugin({
                // sentry-cli configuration
                authToken: process.env.SENTRY_AUTH_TOKEN,
                org: "patryk-jelonek",
                project: "frontend",

                // webpack specific configuration
                include: "./public",
                ignore: ["node_modules", "webpack.config.js"],
            }),
        ],
    },
    "transpileDependencies": [
        "vuetify"
    ],
}
