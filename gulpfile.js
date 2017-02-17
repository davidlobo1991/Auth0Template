var argv = require('yargs').argv;
var isProduction = !(argv.production === undefined);

console.log('');
console.log('#################################');
console.log('Run gulp in ' + (isProduction ? 'PRODUCTION' : 'DEVELOPMENT') + ' mode');
console.log('#################################');
console.log('');

var gulp = require('gulp');
var clean = require('gulp-clean');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var sass = require('gulp-sass');
var rename = require('gulp-rename');
var filter = require('gulp-filter');
var sourcemaps = require('gulp-sourcemaps');
var exec = require('gulp-exec');
var strip = require('gulp-strip-comments');
var stripCssComments = require('gulp-strip-css-comments');
var subprocess = require('child_process').exec;
var runSequence = require('run-sequence');

var pathPublic = 'src/TrenkwalderBundle/Resources/public/';
var pathPrivate = 'src/TrenkwalderBundle/Resources/private/';
var pathNodeModules = 'node_modules/';
var pathToWeb = 'web/';
var pathToCache = 'var/cache/';

var reportOptions = {
    err: true, // default = true, false means don't write err
    stderr: true, // default = true, false means don't write stderr
    stdout: true // default = true, false means don't write stdout
}

gulp.task('composer-install', function() {

    if(isProduction) {
        return gulp.src('./')
                   .pipe(exec('composer install --optimize-autoloader'))
                   .pipe(exec.reporter(reportOptions));
    }

    return gulp.src('./')
               .pipe(exec('composer install'))
               .pipe(exec.reporter(reportOptions));

});

gulp.task('update-db', function() {

    return gulp.src('./')
        .pipe(exec('php bin/console doctrine:schema:update --force'))
        .pipe(exec.reporter(reportOptions));

});

gulp.task('server-start', function() {

    return subprocess('./bin/console server:start --force');

});

gulp.task('server-stop', function() {

    return subprocess('./bin/console server:stop');

});

gulp.task('clean', function() {

    var paths = [
        pathPublic + 'js/*',
        pathPublic + 'css/*',
        pathToWeb + 'bundles',
        pathToWeb + 'css',
        pathToWeb + 'js',
        pathToCache + 'dev',
        pathToCache + 'prod'
    ];
    return gulp.src(paths, {read: false}).pipe(clean());
});

gulp.task('js-vendor', function() {

    var files = [
        pathNodeModules + 'jquery/dist/jquery.min.js',
        pathNodeModules + 'fullpage.js/dist/jquery.fullpage.min.js',
        pathPrivate + 'vendor/bootstrap/js/bootstrap.min.js',
    ];

    return gulp.src(files)
        .pipe(strip())
        .pipe(concat('vendor.js'))
        .pipe(gulp.dest(pathPublic + 'js'));

});

gulp.task('js', function() {

    var files = [
        pathPrivate + 'js/trenkwalder.js',
        pathPrivate + 'js/trenkwalder.flash.js',
        pathPrivate + 'js/trenkwalder.auth0.js',
        pathPrivate + 'js/trenkwalder.form.js'
    ];

    if(isProduction) {
        return gulp.src(files)
            .pipe(strip())
            .pipe(concat('trenkwalder.js'))
            .pipe(uglify())
            .pipe(gulp.dest(pathPublic + 'js'));
    }

    return gulp.src(files)
        .pipe(strip())
        .pipe(concat('trenkwalder.js'))
        .pipe(gulp.dest(pathPublic + 'js'));
});

gulp.task('css-vendor', function() {

    var files = [
        pathNodeModules + 'fullpage.js/dist/jquery.fullpage.min.css',
        pathPrivate + 'vendor/bootstrap/css/bootstrap.min.css',
        pathPrivate + 'vendor/bootstrap/css/bootstrap-theme.min.css'
    ];

    return gulp.src(files)
        .pipe(stripCssComments())
        .pipe(concat('vendor.css'))
        .pipe(gulp.dest(pathPublic + 'css'));
});

gulp.task('scss', function () {

    if(isProduction) {
        return gulp.src(pathPrivate + 'scss/trenkwalder.scss')
            .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
            .pipe(gulp.dest(pathPublic + 'css'));
    }

    return gulp.src(pathPrivate + 'scss/trenkwalder.scss')
        .pipe(sourcemaps.init())
        .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
        .pipe(sourcemaps.write())
        .pipe(gulp.dest(pathPublic + 'css'));
});

gulp.task('copy-assets', function() {

    if(isProduction) {
        return gulp.src('./').pipe(exec('php bin/console assetic:dump --env=prod --no-debug'))
                             .pipe(exec.reporter(reportOptions));
    }

    return gulp.src('./').pipe(exec('php bin/console assets:install'))
                         .pipe(exec.reporter(reportOptions));
});

gulp.task('clear-cache', function() {

    if(isProduction) {
        return gulp.src('./')
                   .pipe(exec('php bin/console cache:clear --env=prod --no-debug'))
                   .pipe(exec.reporter(reportOptions));
    }

    return gulp.src('./').pipe(exec('php bin/console cache:clear'))
                         .pipe(exec.reporter(reportOptions));
});

gulp.task('watch', function() {
    gulp.watch(pathPrivate + 'js/*', function() {
        runSequence('js');
    });
    gulp.watch(pathPrivate + 'scss/*', function() {
        runSequence('scss');
    });
});

gulp.task('default', function() {

    if(isProduction) {
        return runSequence(
            'clean',
            'composer-install',
            ['js-vendor', 'js', 'css-vendor', 'scss'],
            'copy-assets',
            'clear-cache'
        );
    }

    return runSequence(
        'clean',
        'composer-install',
        'update-db',
        'server-stop',
        'server-start',
        ['js-vendor', 'js', 'css-vendor', 'scss'],
        'copy-assets',
        'clear-cache',
        'watch'
    );
});
