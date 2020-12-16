const path = require("path");
const autoprefixer = require("autoprefixer");
const ExtractTextPlugin = require("extract-text-webpack-plugin");
const BrowserSyncPlugin = require("browser-sync-webpack-plugin");
const UglifyJSPlugin = require('uglifyjs-webpack-plugin');

// Extract style.css for both editor and frontend styles.
const frontCSSPlugin = new ExtractTextPlugin({
	filename: "./assets/dist/css/front.build.css",
});

// Extract admin.css for admin styles.
const adminCSSPlugin = new ExtractTextPlugin({
	filename: "./assets/dist/css/admin.build.css",
});

// Extract blocks.css for blocks styles.
const blocksCSSPlugin = new ExtractTextPlugin({
	filename: "./assets/dist/css/blocks.build.css",
});

const SITE_NAME = "mana-booking";
const HOST = "localhost";
const PORT = 80;
const PROXY = `http://${HOST}/${SITE_NAME}`;

const browserSync = new BrowserSyncPlugin({
	host: HOST,
	port: PORT,
	proxy: PROXY,
	open: false
});

// Source maps are resource heavy and can cause out of memory issue for large source files.
// const shouldUseSourceMap = process.env.SOURCEMAP === "true";
const shouldUseSourceMap = false;
const devPlugins = [frontCSSPlugin, adminCSSPlugin, blocksCSSPlugin, browserSync];

const prodPlugins = [frontCSSPlugin, adminCSSPlugin, blocksCSSPlugin, browserSync];

// Configuration for the ExtractTextPlugin — DRY rule.
const extractConfig = {
	use: [
		// "postcss" loader applies autoprefixer to our CSS.
		{
			loader: "raw-loader"
		},
		{
			loader: "postcss-loader",
			options: {
				ident: "postcss",
				plugins: [
					autoprefixer({
						overrideBrowserslist: [
							">1%",
							"last 4 versions",
							"Firefox ESR",
							"not ie < 9", // React doesn't support IE8 anyway
						],
						flexbox: "no-2009",
					}),
				],
			},
		},
		// "sass" loader converts SCSS to CSS.
		{
			loader: "sass-loader",
			options: {
				outputStyle: "production" === process.env.MODE ? "compressed" : "nested",
			},
		},
	],
};

// Export configuration.
module.exports = {
	entry: {
		"./assets/dist/js/admin.build": path.resolve("assets/src/js/admin.js"),
		"./assets/dist/js/blocks.build": path.resolve("assets/src/js/blocks.js"),
		"./assets/dist/js/front.build": path.resolve("assets/src/js/front.js"),
	},
	mode: process.env.MODE,
	output: {
		pathinfo: true,
		// The dist folder.
		path: path.resolve(__dirname),
		filename: "[name].js", // [name] = './assets/dist/blocks.build' as defined above.
	},
	resolve: {
		extensions: ['.json', '.jsx', '.js']
	},
	optimization: {
		minimizer: [
			new UglifyJSPlugin({
				cache: true,
				parallel: true,
				uglifyOptions: {
					compress: {
						drop_console: true,
					},
					output: {
						comments: false,
					}
				}
			})
		]
	},
	devtool: shouldUseSourceMap ? "source-map" : "",
	// You may want 'eval' instead if you prefer to see the compiled output in DevTools.
	module: {
		rules: [{
				test: /\.(js|jsx)$/,
				exclude: /node_modules/,
				use: ["babel-loader"]
			},
			{
				test: /front\.s?css$/,
				exclude: /(node_modules|bower_components)/,
				use: frontCSSPlugin.extract(extractConfig),
			},
			{
				test: /admin\.s?css$/,
				exclude: /(node_modules|bower_components)/,
				use: adminCSSPlugin.extract(extractConfig),
			},
			{
				test: /blocks\.s?css$/,
				exclude: /(node_modules|bower_components)/,
				use: blocksCSSPlugin.extract(extractConfig),
			},
		],
	},
	resolve: {
		extensions: ["*", ".js", ".jsx", ".json"]
	},
	// Add plugins.
	plugins: "production" === process.env.MODE ? prodPlugins : devPlugins,
};