'use strict';

//=======================================================
// Include node.js modules
//=======================================================
var fs          = require('fs');
var path        = require('path');

//=======================================================
// Include gulp and gulp modules
//=======================================================
var gulp        = require('gulp');
var babel       = require('gulp-babel');
var eslint      = require('gulp-eslint');
var include     = require('gulp-include');
var prefix      = require('gulp-autoprefixer');
var rename      = require('gulp-rename');
var sass        = require('gulp-sass');
var sassLint    = require('gulp-sass-lint');
var sourcemaps  = require('gulp-sourcemaps');

//=======================================================
// Include other modules
//=======================================================
var del         = require('del');
var kss         = require('kss');
var runSequence = require('run-sequence');
var yaml        = require('js-yaml');

//=======================================================
// Lint Sass and JS
//=======================================================
gulp.task('lint', ['lint:sass', 'lint:js']);

// Lint Sass
gulp.task('lint:sass', function () {
  return gulp.src([
    './src/kss/components/**/*.scss',
    './src/scss/**/*.scss',
    '!./src/scss/utils/*'
  ])
    .pipe(sassLint())
    .pipe(sassLint.format());
});

// Lint JS
gulp.task('lint:js', function () {
  return gulp.src([
    './src/kss/components/**/*.js',
    './src/scss/**/*.js'
  ])
    .pipe(eslint())
    .pipe(eslint.format());
});

//=======================================================
// Build Sass, JS and KSS
//=======================================================
gulp.task('build', function(callback) {
  runSequence(
    ['build:sass', 'build:js'],
    'build:kss',
    callback
  );
});

// Build Sass
gulp.task('build:sass', function() {
  return gulp.src([
    './src/kss/styleguide.scss',
    './src/kss/components/**/*.scss',
    './src/scss/**/*.scss'
  ])
    .pipe(sourcemaps.init())
    .pipe(sass({ outputStyle: 'nested' })
      .on('error', sass.logError))
    .pipe(prefix({
      browsers: ['last 2 versions'],
      cascade: false
    }))
    .pipe(rename(function (path) {
      path.dirname = '';
      return path;
    }))
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest('./dist/css'));
});

// Build JS
gulp.task('build:js', function() {
  return gulp.src([
    './src/kss/components/**/*.js',
    './src/js/**/*.js'
  ])
    .pipe(include())
    .pipe(sourcemaps.init())
    .pipe(babel({
      presets: ['es2015']
    }))
    .pipe(rename(function (path) {
      path.dirname = '';
      return path;
    }))
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest('./dist/js'));
});

// Build kss style guide
gulp.task('build:kss', function() {
  var options = {
    source: [
      'src/kss/components',
      'src/kss/pages'
    ],
    destination: 'dist/style-guide',
    builder: 'src/kss/builder',
    namespace: 'd8training:' + __dirname + '/src/kss/components/',
    homepage: '/../styleguide.md',
    title: 'Style Guide',
    'extend-drupal8': true
  };

  var config = yaml.safeLoad(fs.readFileSync('src/kss/styleguide.yml', 'utf8')) || {};
  var styles = config.styles || [];
  var scripts = config.scripts || [];

  if (fs.existsSync('./dist/css')) {
    styles = styles.concat(fs.readdirSync('./dist/css')
      .filter(function (file) {
        return file.substr(-4) === '.css';
      })
      .map(function (file) {
        return path.relative(
          __dirname + '/style-guide/',
          __dirname + '/css/' + file
        );
      }));
  }

  if (styles.length) {
    options.css = styles;
  }

  if (fs.existsSync('./dist/js')) {
    scripts = scripts.concat(fs.readdirSync('./dist/js')
      .filter(function (file) {
        return file.substr(-3) === '.js';
      })
      .map(function (file) {
        return path.relative(
          __dirname + '/style-guide/',
          __dirname + '/js/' + file
        );
      }));
  }

  if (scripts.length) {
    options.js = scripts;
  }

  return kss(options);
});

//=======================================================
// Clean all directories.
//=======================================================
gulp.task('clean', ['clean:css', 'clean:js', 'clean:styleguide']);

// Clean CSS files.
gulp.task('clean:css', function () {
  return del([
    './dist/css/*'
  ], {force: true});
});

// Clean JS files.
gulp.task('clean:js', function () {
  return del([
    './dist/js/*'
  ], {force: true});
});

// Clean style guide files.
gulp.task('clean:styleguide', function () {
  return del([
    './dist/style-guide/*'
  ], {force: true});
});

//=======================================================
// Watch and rebuild files.
//=======================================================
gulp.task('watch', ['watch:sass', 'watch:js']);

// Watch Sass files.
gulp.task('watch:sass', function () {
  gulp.watch(
    [
      './src/kss/styleguide.scss',
      './src/kss/components/**/*.scss',
      './src/scss/**/*.scss'
    ],
    ['lint:sass', 'build:sass']
  );
});

// Watch JS files.
gulp.task('watch:js', function () {
  gulp.watch(
    [
      './src/kss/components/**/*.js',
      './src/js/**/*.js'
    ],
    ['lint:js', 'build:js']
  );
});

//=======================================================
// Miscellaneous tasks to run after build.
//=======================================================
gulp.task('postbuild', function() {
  // delete unused files on styleguide.
  del([
    './dist/style-guide/section-pages.html'
  ], {force: true});
});

//=======================================================
// Default Task
//=======================================================
gulp.task('default', function(callback) {
  runSequence(
    'clean',
    ['lint', 'build'],
    'postbuild',
    callback
  );
});
