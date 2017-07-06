var gulp = require('gulp');
var sass = require('gulp-sass');
var minifyCss = require('gulp-minify-css');
var concat = require('gulp-concat');
var rename = require('gulp-rename');
var browserSync = require('browser-sync').create();

var browserify  = require('browserify');
var babelify    = require('babelify');
var source      = require('vinyl-source-stream');
var buffer      = require('vinyl-buffer');
var uglify      = require('gulp-uglify');

var PUBLIC_PATH = 'ebanx-currency-converter/public/';
var ADMIN_PATH = 'ebanx-currency-converter/admin/';
var SASS_PATH = 'src/scss/';
var CSS_PATH = 'dist/css/';
var JS_PATH = 'src/js/';
var JS_DIST_PATH = 'dist/js/';


var getPath = function (area) {
    switch (area) {
        case 'admin':
            return ADMIN_PATH;
        case 'public':
            return PUBLIC_PATH;
        default:
            return false;
    }
};

var transpileSass = function (area) {
    var path = getPath(area);
    if (path) {
        gulp.src(path + SASS_PATH + '*.scss')                          //reads all the SASS files
            .pipe(sass().on('error', sass.logError))  //compiles SASS to CSS and logs errors
            .pipe(minifyCss())                        //minifies the CSS files
            .pipe(concat('style.css'))  //concatenates all the CSS files into one
            .pipe(rename({              //renames the concatenated CSS file
                basename: 'ebanx-currency-converter-' + area,       //the base name of the renamed CSS file
                extname: '.min.css'      //the extension fo the renamed CSS file
            }))
            .pipe(gulp.dest(path + CSS_PATH)) //writes the renamed file to the destination
    }
};

var transpileJs = function (area) {
    var path = getPath(area);
    if (path) {
        return browserify({entries: './' + path + JS_PATH + 'ebanx-currency-converter-' + area + '.js', debug: true})
            .transform("babelify", { presets: ["es2015"] })
            .bundle()
            .pipe(source('ebanx-currency-converter-' + area + '.js'))
            .pipe(buffer())
            .pipe(uglify())
            .pipe(rename({
                extname: '.min.js'
            }))
            .pipe(gulp.dest(path + JS_DIST_PATH));
    }
};

gulp.task('default', ['sass', 'js']);

gulp.task('public-sass', function() {
    transpileSass('public')
});

gulp.task('admin-sass', function() {
    transpileSass('admin')
});

gulp.task('public-js', function() {
    transpileJs('public')
});

gulp.task('admin-js', function() {
    transpileJs('admin')
});

gulp.task('sass', ['public-sass', 'admin-sass']);
gulp.task('js', ['public-js', 'admin-js']);

gulp.task('public', ['public-sass', 'public-js']);
gulp.task('admin', ['admin-sass', 'admin-js']);

gulp.task('watch', function () {
    gulp.watch(PUBLIC_PATH + SASS_PATH + '*.scss', ['public-sass']);
    gulp.watch(ADMIN_PATH + SASS_PATH + '*.scss', ['admin-sass']);
    gulp.watch(PUBLIC_PATH + JS_PATH + '*.js', ['public-js']);
    gulp.watch(ADMIN_PATH + JS_PATH + '*.js', ['admin-js']);
});

gulp.task('serve', function() {
    browserSync.init({
        proxy: "wordpress.dev"
    });

    gulp.run('watch');
    gulp.watch('ebanx-currency-converter/**/{dist/**/*.{css,js},*.template.php}').on('change', browserSync.reload);
});
