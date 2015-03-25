/* globals __dirname:true */

var gulp = require('gulp');
var path = require("path");
var browserify = require('browserify');
var watchify = require('watchify');
var source = require('vinyl-source-stream');
var buffer = require('vinyl-buffer');
var main_bower_files = require('main-bower-files');
var browserSync = require('browser-sync');
var reload = browserSync.reload;

var config = require('./config.json');
var package_json = require('./package.json');

var plugins = require('gulp-load-plugins')({
    pattern: ['gulp-*', 'gulp.*'],
    replaceString: /\bgulp[\-.]/,
});

function getFilePath(target, type) {
    return config[type][target].folder + '/' + config[type][target].file;
}

var scripts = [
    "**/*.js",
    "!node_modules/**/*.js",
    "!public/**/*.js",
    "!js/**/*.js",
    "!bower_components/**/*.js"
];

gulp.task('stylesheets', function() {
    return gulp.src([getFilePath('src', 'stylesheets'), '!_scss/_reset.scss'])
        .pipe(plugins.plumber())
        .pipe(plugins.scssLint())
        .pipe(plugins.sass({
            includePaths: [config.stylesheets.src.folder]
        }))
        .pipe(plugins.autoprefixer({
            browsers: ['last 2 versions', 'ie 9'],
            cascade: false
        }))
        .pipe(plugins.util.env.type === 'production' ? plugins.minifyCss() : plugins.util.noop())
        .pipe(plugins.filesize())
        .pipe(gulp.dest(config.stylesheets.dest.folder))
        .pipe(reload({
            stream: true
        }));
});

function browserify_file(file) {
    function rebundle() {

        return bundler.bundle()
            .on('error', function(error) {
                console.log(error);
                this.emit("end");
            })
            .pipe(source(path.basename(file)))
            .pipe(buffer())
            .pipe(plugins.util.env.type === 'production' ? plugins.uglify() : plugins.util.noop())
            .pipe(plugins.filesize())
            .pipe(gulp.dest(config.scripts.dest.folder));
    }

    var bundler = watchify(browserify(file, watchify.args));
    bundler.on('update', rebundle);

    return rebundle();

}

gulp.task("scripts", function() {
    return gulp.src(getFilePath('src', 'scripts'))
        .pipe(plugins.tap(function(file) {
            return browserify_file("./" + path.relative(__dirname, file.path));
        }))
        .pipe(reload({
            stream: true
        }));
});

gulp.task("vendor", function() {
    var js_filter = plugins.filter(['*.js']);
    var css_filter = plugins.filter(['*.css']);
    var fonts_filter = plugins.filter(['*.ttf', '*.eot', '*.svg', '*.woff']);

    return gulp.src(main_bower_files())
        .pipe(js_filter)
        .pipe(plugins.uglify())
        .pipe(plugins.concat(config.vendor.dest.file))
        .pipe(gulp.dest(config.scripts.dest.folder))
        .pipe(js_filter.restore())
        .pipe(css_filter)
        .pipe(plugins.minifyCss())
        .pipe(gulp.dest(config.stylesheets.dest.folder))
        .pipe(css_filter.restore())
        .pipe(fonts_filter)
        .pipe(gulp.dest(config.fonts.dest.folder));

});

gulp.task("hinting", function() {
    return gulp.src(scripts)
        .pipe(plugins.plumber())
        .pipe(plugins.jshint())
        .pipe(plugins.jshint.reporter('jshint-stylish'))
        .pipe(plugins.jshint.reporter("fail"))
        .on('error', function(error) {
            this.emit("end");
        });
});

gulp.task('watch', function() {
    gulp.watch(getFilePath('src', 'vendor'), ['vendor']);
    gulp.watch(getFilePath('src', 'scripts'), ['scripts']);
    gulp.watch(getFilePath("src", "stylesheets"), ['stylesheets']);
    gulp.watch(scripts, ['hinting']);
});

gulp.task('browser-sync', function() {
    browserSync.init(["css/*.css", "js/*.js"]);
});

gulp.task('default', ['watch', 'stylesheets', 'hinting', 'scripts', 'vendor', 'browser-sync']);