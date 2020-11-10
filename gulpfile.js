'use strict';

const gulp = require('gulp');

const sass = require('gulp-sass');
const autoprefixer = require('gulp-autoprefixer');
const cleanCSS = require('gulp-clean-css');

const concat = require('gulp-concat');
const terser = require('gulp-terser');

function cssTask() {
  return gulp
    .src('./sass/style.scss')
    .pipe(sass({outputStyle: 'expanded'}))
    .pipe(autoprefixer('last 2 versions'))
    .pipe(cleanCSS({
      compatibility: '*'
    }))
    .pipe(gulp.dest('./'));
}

function jsTask() {
  return gulp
    .src(['./js/**/*.js'])
    .pipe(concat('scripts.js'))
    .pipe(terser({
      keep_fnames: true,
      mangle: false
    }))
    .pipe(gulp.dest('./'));
}

function watchFiles() {
  gulp.watch(['./sass/**/*.scss'], cssTask);
  gulp.watch('./js/**/*.js', jsTask);
}

exports.build = gulp.series(jsTask, cssTask);
exports.watch = watchFiles;
exports.default = watchFiles;
