/**
 * General variables
 */

const gulp = require('gulp'),
    csso = require('gulp-csso'),
    browserSync = require('browser-sync'),
    autoprefixer = require('gulp-autoprefixer'),
    sass = require('gulp-sass'),
    tildeImporter = require('node-sass-tilde-importer'),
    del = require('del');

// Build settings

let srcPath = './scss';
let devPath = './catalog/view/theme/default/stylesheet';
let distPath = './catalog/view/theme/default/stylesheet';



/**
 * Browser Sync Init
 */

function browser() {
    browserSync.init({
        proxy: "localhost/shop"
    });
}



/**
 * Build styles
 */

function buildStyles() {

        return gulp.src(srcPath + '/stylesheet.scss')
            .pipe(sass({
                importer: tildeImporter
            }).on('error', onError))
            .pipe(autoprefixer({overrideBrowserslist: ['last 100 versions'], cascade: true}))
            .pipe(gulp.dest(distPath))
            .pipe(csso({
                comments: true
            }))
            // .pipe(rename({suffix: '.min', prefix: ''}))
            .pipe(gulp.dest(distPath))
            .pipe(browserSync.stream());

}



/**
 * Reload browser
 */



/**
 * General watcher
 */

function watch() {
    gulp.watch([srcPath + '/*.scss', srcPath + '/*.css'], gulp.series(buildStyles));
}


/**
 * Clean dist
 */
// function cleanDist(cb) {
//     del.sync([distPath]);
//     cb();
// }

/**
 * Clean dev
 */
function cleanDev(cb) {
    del.sync([devPath]);
    cb();
}

// Error handler

function onError(err) {
    console.log(err);
    this.emit('end');
}

/**
 * Gulp Start
 */

exports.default = gulp.series(cleanDev, buildStyles, gulp.parallel(browser, watch));
