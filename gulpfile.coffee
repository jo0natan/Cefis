gulp = require 'gulp'
coffee = require 'gulp-coffee'
sass = require 'gulp-ruby-sass'
autoprefixer = require 'gulp-autoprefixer'
imagemin = require 'gulp-imagemin'
livereload = require 'gulp-livereload'
run = require 'gulp-run'

paths =
  coffee: 'assets/coffee/**/*.coffee'
  sass: 'assets/scss/**/*.scss'
  img: 'assets/img/**/*'
  fonts: 'assets/vendor/fontawesome/fonts/**/*'

gulp.task 'coffee', ->
  gulp.src paths.coffee
      .pipe coffee()
      .pipe gulp.dest 'public/js'

gulp.task 'sass', ->
  gulp.src paths.sass
      .pipe sass()
      .pipe autoprefixer('last 2 versions', 'ie > 8')
      .pipe gulp.dest 'public/css'

gulp.task 'img', ->
  gulp.src paths.img
      .pipe imagemin()
      .pipe gulp.dest 'public/img'

gulp.task 'fonts', ->
  gulp.src paths.fonts
      .pipe gulp.dest 'public/fonts'

gulp.task 'serve', ->
  run('php artisan serve').exec()

gulp.task 'watch', ->
  livereload.listen()
  gulp.watch paths.coffee, ['coffee']
  gulp.watch paths.sass, ['sass']
  gulp.watch paths.img, ['img']
  gulp.watch 'public/**'
      .on 'change', livereload.changed

gulp.task 'default', ['coffee', 'sass', 'img', 'fonts', 'serve', 'watch']