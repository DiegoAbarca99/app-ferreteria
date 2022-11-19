//Modulos de GULP
const { src, dest, watch, parallel } = require('gulp');


//Modulos para compilar SASS y eventualmente optimizar el CSS generado
const sass = require('gulp-sass')(require('sass'));
const autoprefixer = require('autoprefixer');
const postcss = require('gulp-postcss')
const cssnano = require('cssnano');


//Modulos para optimizar el JavaScript
const terser = require('gulp-terser-js');

//Modulos para minificar imagenes y obtenerlas en un formato más optimo
const imagemin = require('gulp-imagemin');
const cache = require('gulp-cache');
const webp = require('gulp-webp');
const avif = require('gulp-avif');

//Modulos para renombrar, concatenar y generar mapas de los archivos minificados
const rename = require('gulp-rename');
const sourcemaps = require('gulp-sourcemaps');

// Webpack 
const webpack = require('webpack-stream');


//Ruta de los archivos a monitorear
const paths = {
    scss: 'src/scss/**/*.scss',
    js: 'src/js/**/*.js',
    imagenes: 'src/img/**/*'
}

// Función que compila SASS y aplica los modulos de optimización del CSS generado.
function css() {
    return src(paths.scss)
        .pipe(sourcemaps.init())
        .pipe(sass())
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(rename({ suffix: '.min' }))
        .pipe(dest('public/build/css'));

}

//Función que minifica nuestros Scripts de JavaScript
function javascript() {
    return src(paths.js)
        .pipe(webpack({ //Webpack genera un bundle o empaqueta los archivos de configuración de nuestras librerias en un solo, para lanzarlo en producción
            module: {
                rules: [
                    {
                        test: /\.css$/i,  //Añade loaders a webpack para pueda identificar el código CSS en este caso importado en JS(css-loader styler-loader)
                        use: ['style-loader', 'css-loader']
                    }

                ]
            },
            watch: true,
            mode: 'production',
            entry: './src/js/app.js',
        }))
        .pipe(sourcemaps.init())
        .pipe(terser())
        .pipe(sourcemaps.write('.'))
        .pipe(rename({ suffix: '.min' }))
        .pipe(dest('public/build/js'));
}

//Función que minifica nuestras imagenes
function imagenes() {
    return src(paths.imagenes)
        .pipe(cache(imagemin({ optimizationLevel: 3 })))
        .pipe(dest('public/build/img'))
}

//Función que genera una versión .webp de nuestras imagenes
function versionWebp() {
    return src(paths.imagenes)
        .pipe(webp())
        .pipe(dest('public/build/img'))
}

//Función que genera una versión .avif de nuestras imagenes
function versionAvif() {
    return src(paths.imagenes)
        .pipe(avif())
        .pipe(dest('public/build/img'))
}

//Función que monitorea cambios en nuestras rutas
function watchArchivos() {
    watch(paths.scss, css);
    watch(paths.js, javascript);
    watch(paths.imagenes, imagenes);
    watch(paths.imagenes, versionWebp);
    watch(paths.imagenes, versionAvif);
}

//Exposición de nuestras funciones a la terminal de comandos de npx.
exports.watchArchivos = watchArchivos;
exports.default = parallel(css, javascript, imagenes, versionWebp, watchArchivos); 