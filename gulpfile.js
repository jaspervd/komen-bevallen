/* globals __filename:true */

var gulp = require("gulp");
var browserify = require('browserify');
var source = require('vinyl-source-stream');
var buffer = require('vinyl-buffer');
var browserifyHandlebars = require('browserify-handlebars');
var package_json = require('./package.json');

var config = require('./config.json');

var plugins = require("gulp-load-plugins")({
    pattern: ['gulp-*', 'gulp.*'],
    replaceString: /\bgulp[\-.]/,
});

function getFilePath(target, type) {
    return config[type][target].folder + "/" + config[type][target].file;
}

var scripts = [getFilePath("src", "scripts"), getFilePath("src", "shared"), package_json.main, __filename];

//alias for size(), errors on .size.
plugins.filesize = plugins.size;

gulp.task('stylesheets', function() {
    return gulp.src(getFilePath("src", "stylesheets"))
        .pipe(plugins.plumber())
        .pipe(plugins.scssLint({
            'config': '.scss-lint.yml'
        }))
        .pipe(plugins.compass({
            css: config.stylesheets.dest.folder,
            sass: config.stylesheets.src.folder,
        }))
        .pipe(plugins.autoprefixer({
            browsers: ['last 2 versions', 'ie 9'],
            cascade: false
        }))
        .pipe(plugins.util.env.type === 'production' ? plugins.minifyCss() : plugins.util.noop())
        .pipe(plugins.filesize())
        .pipe(gulp.dest(config.stylesheets.dest.folder));
});

function jshint(paths) {
    return gulp.src(paths)
        .pipe(plugins.plumber())
        .pipe(plugins.jshint("./.jshintrc"))
        .pipe(plugins.jshint.reporter('jshint-stylish'))
        .pipe(plugins.jshint.reporter("fail"))
        .on('error', function(error) {
            plugins.util.beep();
        });
}

gulp.task("scripts", function() {
    jshint(scripts);
    return browserify("./" + config.scripts.src.folder + "/" + config.scripts.src.entry_file)
        .transform(browserifyHandlebars)
        .bundle()
        .on('error', function(error) {
            this.emit("end");
        })
        .pipe(source(config.scripts.dest.file))
        .pipe(buffer())
        .pipe(plugins.util.env.type === 'production' ? plugins.uglify() : plugins.util.noop())
        .pipe(plugins.filesize())
        .pipe(gulp.dest(config.scripts.dest.folder));
});

gulp.task('watch', function() {
    gulp.watch(getFilePath("src", "stylesheets"), ['stylesheets']);
    gulp.watch(getFilePath("src", "templates"), ['scripts']);
    gulp.watch(scripts, ['scripts']);
});

gulp.task('default', ['watch', 'stylesheets', 'scripts']);