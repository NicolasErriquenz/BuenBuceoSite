var gulp = require("gulp");
var usemin = require('gulp-usemin');
var uglify = require('gulp-uglify');
var minifyHtml = require('gulp-minify-html');
var minifyCss = require('gulp-minify-css');
var clean = require('gulp-clean');
var htmlmin = require('gulp-htmlmin');
var rename = require('gulp-rename');

var deployDirectory = "./gulp/deploy/";
var buildDirectory = "./gulp/build/";

var jsFilesToMinify = [
    buildDirectory + 'Scripts/vendor.min.js',
    buildDirectory + 'Scripts/mainapp.min.js',
    buildDirectory + 'Scripts/controllers.min.js',
    buildDirectory + 'Scripts/servicios.min.js',
    buildDirectory + 'Scripts/components.min.js',
    buildDirectory + 'Scripts/pdf.min.js'];

var jsFilesToCopy = [buildDirectory + 'Scripts/oidc-client.js', buildDirectory + 'Scripts/site.js'];


//Copia todos los archivos
gulp.task('copyFiles', function () {
    //copia todas las vistas
    gulp.src('views/**/*.html')
        .pipe(gulp.dest(buildDirectory + 'views/'));
    //copia templates de components
    gulp.src('components/templates/**/*.html')
       .pipe(gulp.dest(deployDirectory + 'components/templates/'));

    
   
    //copia los html de raiz
    gulp.src('notAuthorized.html')
        .pipe(gulp.dest(buildDirectory));
    gulp.src('notFound.html')
       .pipe(gulp.dest(buildDirectory));
    //copia el icono png
    //gulp.src('./content/icons/*.png')
    //    .pipe(gulp.dest(deployDirectory));
    //copia las fuentes de fontAwesome y Bootstrap
    gulp.src('./node_modules/font-awesome/fonts/**/*.{woff2,ttf,woff,eof,svg}')
        .pipe(gulp.dest(deployDirectory + 'fonts/'));
    //gulp.src('./node_modules/bootstrap/fonts/**/*.{woff2,ttf,woff,eof,svg}')
    //    .pipe(gulp.dest(deployDirectory + 'fonts/'));

});


gulp.task('copyRelease', function () {

    return gulp.src('config/env.release.js')
        .pipe(rename('config/env.js'))
        .pipe(gulp.dest(deployDirectory));

});

//publica
gulp.task('publishTesting', ['copyFiles','copyRelease'], function () {

    

    gulp.src('./*.html')
      .pipe(usemin({
          cssmin: minifyCss(),
          htmlmin: minifyHtml(),
          jsmin: uglify()
      }))
      .pipe(gulp.dest(buildDirectory));
});

gulp.task('publishRelease', ['copyFiles', 'copyRelease'], function () {
    gulp.src('./*.html')
        .pipe(usemin({
            cssmin: minifyCss(),
            htmlmin: minifyHtml(),
            jsmin: uglify()
        }))
        .pipe(gulp.dest(buildDirectory));

});

var gutil = require('gulp-util');

//minifica
gulp.task('minifyDeploy', function () {
    gulp.src(jsFilesToMinify)
        //.pipe(uglify({ mangle: false }))
        .on('error', function (err) { gutil.log(gutil.colors.red('[Error]'), err.toString()); })
        .pipe(gulp.dest(deployDirectory + 'Scripts/'));

    gulp.src(jsFilesToCopy)
    .on('error', function (err) { gutil.log(gutil.colors.red('[Error]'), err.toString()); })
    .pipe(gulp.dest(deployDirectory + 'Scripts/'));

    gulp.src(buildDirectory + 'config/env.js')
    .on('error', function (err) { gutil.log(gutil.colors.red('[Error]'), err.toString()); })
    .pipe(gulp.dest(deployDirectory + 'config/'));

    //copia contenido
    gulp.src('_recursos/**/*.*')
        .on('error', function (err) { gutil.log(gutil.colors.red('[Error]'), err.toString()); })
        .pipe(gulp.dest(deployDirectory + '_recursos/'));

    gulp.src('content/icons/**/*.*')
        .on('error', function (err) { gutil.log(gutil.colors.red('[Error]'), err.toString()); })
        .pipe(gulp.dest(deployDirectory + 'content/icons/'));

    gulp.src(buildDirectory + '**/*.css')
        .pipe(minifyCss())
        .on('error', function (err) { gutil.log(gutil.colors.red('[Error]'), err.toString()); })
        .pipe(gulp.dest(deployDirectory));

    gulp.src(buildDirectory + '**/*.html')
        //.pipe(htmlmin({ collapseWhitespace: true }))
        .on('error', function (err) { gutil.log(gutil.colors.red('[Error]'), err.toString()); })
        .pipe(gulp.dest(deployDirectory));

    //copia contenido
    gulp.src('images/**/*.*')
        .on('error', function (err) { gutil.log(gutil.colors.red('[Error]'), err.toString()); })
        .pipe(gulp.dest(deployDirectory + 'images/'));

    gulp.src('content/icons/**/*.*')
        .on('error', function (err) { gutil.log(gutil.colors.red('[Error]'), err.toString()); })
        .pipe(gulp.dest(deployDirectory + 'content/icons/'));

    gulp.src('styles/**/*.*')
        .on('error', function (err) { gutil.log(gutil.colors.red('[Error]'), err.toString()); })
        .pipe(gulp.dest(deployDirectory + 'styles/'));

    //gulp.src('services/**/*.*')
    //    .on('error', function (err) { gutil.log(gutil.colors.red('[Error]'), err.toString()); })
    //    .pipe(gulp.dest(deployDirectory + 'services/'));
    
    //gulp.src('gulp/build/app/**/*.html'),
    //    minifyHtml(),
    //    gulp.dest('gulp/deploy/');
});

