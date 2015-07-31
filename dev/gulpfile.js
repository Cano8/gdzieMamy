// Variables
var targetPath = '../symfony2/web/bundles/canouekc/'

// Include gulp
var gulp = require('gulp');

// Include Our Plugins
var jshint = require('gulp-jshint');
var sass = require('gulp-sass');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');

// Error handler
function handleError(err) {
    console.log(err.toString());
    this.emit('end');
}

// Lint Task
gulp.task('lint', function() {
    return gulp.src('js/*.js')
        .pipe(jshint())
        .pipe(jshint.reporter('default'));
});

// Compile Our Sass
gulp.task('sass', function() {
    return gulp.src(['css/*.sass'])
        .pipe(sass())
        .on("error", handleError)
        .pipe(rename("css.css"))
        .pipe(gulp.dest(targetPath + 'css'));
});

// Concatenate & Minify JS
gulp.task('scripts', function() {
    return gulp.src('js/*.js')
        .pipe(concat('all.js'))
        .pipe(gulp.dest('../dist/js'))
        .pipe(rename('all.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('../dist/js'));
});

// Watch Files For Changes
gulp.task('watch', function() {
    gulp.watch('js/*.js', ['lint', 'scripts']);
    gulp.watch(['css/**/*.sass', 'css/**/*.scss', 'css/**/*.css'], ['sass']);
});

// Default Task
gulp.task('default', ['lint', 'sass', 'watch']);
