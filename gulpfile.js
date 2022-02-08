var gulp = require('gulp');
var imagemin = require('gulp-imagemin');
var changed = require('gulp-changed');
var sass = require('gulp-sass')(require('sass'));
var imagemingifsicle = require('imagemin-gifsicle');
// var imageminjpeg = require('imagemin-jpegtran');
var imageminopt = require('imagemin-optipng');
var mozjpeg = require("imagemin-mozjpeg"); 
var browserify = require('browserify');
const { src, dest, watch, series, parallel } = require('gulp');

//gulpタスクの作成
//gulp.task()を使っていく
//第一引数に任意の名前、第二引数に実行した処理を関数で書いていく
//関数の中はpipeで処理を繋げていく

const Build = (done) => {
  browserify({
    entries: ['./resources/js/*.js'] //ビルド元のファイル指定
  }).bundle()
    .pipe(source('dist.js'))//出力ファイル名 
    .pipe(gulp.dest('./public/js/'))//出力先
    done();
}
exports.Build = Build;

//sassのコンパイル
const compileSass = (done) => {
  gulp.src('./resources/sass/*.scss')
    .pipe(sass({
      outputStyle: 'expanded'
    })
    )
    .on('error', sass.logError)
    .pipe(gulp.dest('./public/css/'));
  done();
};
exports.compileSass = compileSass;



var path = {
  srcDir: 'storage/app/public/images/',
  dstDir: 'storage/app/public/min_images'
}
//画像圧縮
const imageMin = (done) => {
  var srcGlob = path.srcDir + '*.+(jpg|jpeg|png|gif)';
  var dstGlob = path.dstDir;
  gulp.src(srcGlob)
  .pipe(changed(dstGlob))
.pipe(imagemin([
  imagemingifsicle({interlaced: true}),
  // imageminjpeg({progressive:true}),
  imageminopt({optimizationLevel:5}),
  mozjpeg({ quality: 65 }), // 追加
]))
.pipe(gulp.dest(dstGlob));
done();
};

exports.imageMin = imageMin;

//監視ファイル
const watchFile = (done) => {
  gulp.watch('./resources/sass/*.scss', compileSass);
  gulp.watch(path.srcDir + '*.+(jpg|jpeg|png|gif)', imageMin);
  done();
}
exports.watchFile = watchFile;
//デフォルトで動かすタスクを指定
//設定するとターミナルでgulpと入力するだけで実行される
exports.default = gulp.series(
  watchFile,
);



