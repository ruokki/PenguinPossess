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

gulp.task("default", function(){
    gulp.watch(srcFolder + "/scss/**/*.scss", ["sass"]);
});