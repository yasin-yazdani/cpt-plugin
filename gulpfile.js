var gulp = require("gulp");

var srcStyle = './src/scss/admin.style.scss';
var srcJs = 'admin.script.js';
var srcJsFolder = './src/js/';

var distStyle = './assets/css/';
var distJs = './assets/js/';

var jsFiles = [srcJs];

var rename = require("gulp-rename");
var sass = require('gulp-sass')(require('sass'));
var autoprefixer = require('gulp-autoprefixer');
var sourcemaps = require('gulp-sourcemaps');
var uglify = require('gulp-uglify');
var browserify = require('browserify');
var babelify = require('babelify');
var source = require('vinyl-source-stream');
var buffer = require('vinyl-buffer');

var styleWatch = './src/scss/**/*.scss';
var jsWatch = './src/js/**/*.js';

gulp.task('style', done => {
    gulp.src([srcStyle]).pipe(sourcemaps.init()).pipe(sass({
        errLogToConsole: true,
        outputStyle: 'compressed'
    })).on('error', console.error.bind(console)).pipe(autoprefixer({
        cascade: false
    })).pipe(rename({ suffix: '.min' })).pipe(sourcemaps.write('./')).pipe(gulp.dest(distStyle));
    done();
});

gulp.task('js', done => {
    //steps of job :::

    //browserify
    //transform babelify
    //bundle
    //source
    //rename .min
    //buffer
    //init sourcemap
    //uglify
    //write sourcemap
    //dist
    jsFiles.map(function (entry) {
        return browserify(srcJsFolder + entry, { debug: true })
            .transform(babelify, ({ presets: ['@babel/preset-env'] }))
            .bundle()
            .pipe(source(entry))
            .pipe(rename({ extname: '.min.js' }))
            .pipe(buffer())
            .pipe(sourcemaps.init({ loadMaps: true }))
            .pipe(uglify())
            .pipe(sourcemaps.write('./'))
            .pipe(gulp.dest(distJs));
    });
    done();
});

gulp.task('default', gulp.series('js', 'style')); // esme task haiee ke meikhaim ejra beshe daroone taske default

gulp.task('watch', gulp.series('default', done => {
    gulp.watch(styleWatch, gulp.series('style'));
    gulp.watch(jsWatch, gulp.series('js'));
    done();
}));