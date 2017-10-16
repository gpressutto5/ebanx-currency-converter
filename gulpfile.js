let gulp = require('gulp');
let sass = require('gulp-sass');
let minifyCss = require('gulp-minify-css');
let concat = require('gulp-concat');
let rename = require('gulp-rename');
let browserSync = require('browser-sync').create();

let browserify = require('browserify');
let babelify = require('babelify');
let source = require('vinyl-source-stream');
let buffer = require('vinyl-buffer');
let uglify = require('gulp-uglify');

const PUBLIC_PATH = 'ebanx-currency-converter/Front/';
const ADMIN_PATH = 'ebanx-currency-converter/Admin/';
const SASS_PATH = 'src/scss/';
const CSS_PATH = 'dist/css/';
const JS_PATH = 'src/js/';
const JS_DIST_PATH = 'dist/js/';


let getPath = function (area) {
    switch (area) {
        case 'admin':
            return ADMIN_PATH;
        case 'public':
            return PUBLIC_PATH;
        default:
            return false;
    }
};

let transpileSass = function (area) {
    let path = getPath(area);
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

let transpileJs = function (area) {
    let path = getPath(area);
    if (path) {
        return browserify({entries: './' + path + JS_PATH + 'ebanx-currency-converter-' + area + '.js', debug: true})
            .transform("babelify", {presets: ["es2015"]})
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

gulp.task('public-sass', function () {
    transpileSass('public')
});

gulp.task('admin-sass', function () {
    transpileSass('admin')
});

gulp.task('public-js', function () {
    transpileJs('public')
});

gulp.task('admin-js', function () {
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

gulp.task('serve', function () {
    browserSync.init({
        proxy: "wordpress.dev",
        browser: "google chrome"
    });

    gulp.run('watch');
    gulp.watch('ebanx-currency-converter/**/{dist/**/*.{css,js},*.template.php}').on('change', browserSync.reload);
});
