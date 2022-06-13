var Encore = require('@symfony/webpack-encore');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    //.addEntry('js/app', ['./assets/app.js', './node_modules/bootstrap/dist/js/bootstrap.min.js'])
    .copyFiles({
        from: './assets/images',
        to: 'images/[path][name].[ext]'
    })
    .addEntry('js/app', ['./assets/js/jquery-3.3.1.slim.min.js', './assets/js/popper.min.js', './node_modules/bootstrap/dist/js/bootstrap.min.js', './assets/owl-carousel/owl.carousel.min.js',  './assets/js/main.js'])
    .addStyleEntry('css/app', ['./assets/css/font-awesome.css', './assets/owl-carousel/assets/owl.carousel.min.css', './node_modules/bootstrap/dist/css/bootstrap.min.css', './assets/css/style.css']);

module.exports = Encore.getWebpackConfig();
