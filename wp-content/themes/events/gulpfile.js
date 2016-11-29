var gulp = require('gulp'),
    sass = require('gulp-sass');
    cleanCSS = require('gulp-clean-css');

var source = 'components/',
    dest = 'assets/';
    
var bootstrapSass = {
        in: './node_modules/bootstrap-sass/'
    };

var fonts = {
        in: [source + 'fonts/*.*', bootstrapSass.in + 'assets/fonts/**/*'],
        out: dest + 'fonts/'
    };

var scss = {
    in: source + 'scss/style.scss',
    out: dest + 'css/',
    watch: source + 'scss/**/*',
    sassOpts: {
        outputStyle: 'nested',
        precison: 3,
        errLogToConsole: true,
        includePaths: [bootstrapSass.in + 'assets/stylesheets']
    }
};

gulp.task('fonts', function () {
    return gulp.src(fonts.in)
        .pipe(gulp.dest(fonts.out));
});

gulp.task('sass', ['fonts'], function () {
    return gulp.src(scss.in)
        .pipe(sass(scss.sassOpts))
        .pipe(cleanCSS({compatibility: 'ie8'}))
        .pipe(gulp.dest(scss.out));
});

gulp.task('watch', ['sass'], function () {
     gulp.watch(scss.watch, ['sass']);
});