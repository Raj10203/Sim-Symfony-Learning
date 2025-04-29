import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */
// any CSS you import will output into a single css file (app.css in this case)
// css
import './styles/app.css';
import $ from 'jquery';
import Swal from 'sweetalert2';
window.Swal = Swal;
window.$ = $;

// js files
import 'select2/dist/css/select2.min.css';
import 'select2';
import './libs/perfect-scrollbar/perfect-scrollbar'
import 'bootstrap';
import './js/menu';
import './js/main';
