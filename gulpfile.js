'use strict';

var gulp         = require('gulp');
var sass         = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var rename       = require('gulp-rename');
var uglify       = require('gulp-uglify');
var jshint       = require('gulp-jshint');
var stylish      = require('jshint-stylish');
var wpPot        = require('gulp-wp-pot');
var sort         = require('gulp-sort');
var gcmq         = require('gulp-group-css-media-queries');
var del          = require('del');
var zip          = require('gulp-zip');
var runSequence  = require('run-sequence');
var livereload   = require('gulp-livereload');

var dirs = {
	css: 'assets/css/',
	js: ['assets/js/**/*.js', '!assets/js/**/*.min.js', '!assets/js/**/lib/**/*.js'],
	php: ['lollum-page-builder.php', 'includes/**/*.php'],
}

var build_files = [
	'**',
	'!.sass-cache',
	'!.sass-cache/**',
	'!node_modules',
	'!node_modules/**',
	'!dist',
	'!dist/**',
	'!.git',
	'!.git/**',
	'!package.json',
	'!.gitignore',
	'!gulpfile.js',
	'!.editorconfig',
	'!.jshintrc',
	'!lollum-page-builder.sublime-project',
	'!lollum-page-builder.sublime-workspace'
];

gulp.task('sass', function() {
	gulp.src([dirs.css + '*.scss'])
		.pipe(sass({outputStyle: 'expanded'}))
		.pipe(autoprefixer(['last 2 versions']))
		.pipe(gcmq())
		.pipe(gulp.dest(dirs.css))
		.pipe(livereload());
});

gulp.task('lint', function() {
	return gulp.src(dirs.js)
		.pipe(jshint())
		.pipe(jshint.reporter(stylish));
});

gulp.task('compress', function() {
	return gulp.src(dirs.js, {base: '.'})
		.pipe(gulp.dest('.'))
		.pipe(uglify())
		.pipe(rename({extname: '.min.js'}))
		.pipe(gulp.dest('.'));
});

gulp.task('makepot', function() {
	return gulp.src(dirs.php)
		.pipe(sort())
		.pipe(wpPot({
			domain: 'lollum-page-builder',
			destFile: 'lollum-page-builder.pot',
			package: 'Lollum Page Builder',
			bugReport: 'http://lollum.com',
			team: 'Lollum <support@lollum.com>'
		}))
		.pipe(gulp.dest('languages'));
});

gulp.task('watch', function() {
	livereload.listen();

	gulp.watch(dirs.js, ['lint']);
	gulp.watch(dirs.js, ['compress']);
	gulp.watch(dirs.php, ['makepot']);
	gulp.watch(dirs.css + '*.scss', ['sass']);
});

gulp.task('build-clean', function() {
	del(['dist/**/*']);
});

gulp.task('build-copy', function() {
	return gulp.src(build_files)
		.pipe(gulp.dest('dist/lollum-page-builder'));
});

gulp.task('build-zip', function() {
	return gulp.src('dist/**/*')
		.pipe(zip('lollum-page-builder.zip'))
		.pipe(gulp.dest('dist'));
});

gulp.task('build-delete', function() {
	del(['dist/**/*', '!dist/lollum-page-builder.zip']);
});

gulp.task('build', function(callback) {
	runSequence('build-clean', 'build-copy', 'build-zip', 'build-delete');
});

gulp.task('default', ['sass', 'lint', 'compress', 'makepot', 'watch']);
