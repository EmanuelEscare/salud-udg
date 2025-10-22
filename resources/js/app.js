import * as bootstrap from 'bootstrap'

import '@fortawesome/fontawesome-free/scss/fontawesome.scss';
import '@fortawesome/fontawesome-free/scss/brands.scss';
import '@fortawesome/fontawesome-free/scss/regular.scss';
import '@fortawesome/fontawesome-free/scss/solid.scss';
import '@fortawesome/fontawesome-free/scss/v4-shims.scss';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import './components/Test/index';
// import '../../calificador-pruebas/src/components/Test/index';


import 'select2/dist/css/select2.css';
import 'select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.min.css';
import $ from 'jquery';
window.$ = window.jQuery = $;

import select2 from "select2"
select2(); 
