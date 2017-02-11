// Initialisation des modules
var gulp = require("gulp"),
    sass = require("gulp-sass");

var srcFolder = "asset-dev/",
    destFolder = "asset";

gulp.task("sass", function(){
    return gulp.src(srcFolder + "/scss/**/*.scss")
        .pipe(sass())
        .pipe(gulp.dest(destFolder + "/css"));
});

gulp.task("js", function(){
    return gulp.src(srcFolder + "/js/**/*.js")
        .pipe(gulp.dest(destFolder + "/js"));
});

gulp.task("default", function(){
    gulp.watch(srcFolder + "/scss/**/*.scss", ["sass"]);
    gulp.watch(srcFolder + "/js/**/*.js", ["js"]);
});