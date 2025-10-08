import axios from 'axios';
import { route } from 'ziggy-js';
import { Ziggy } from './ziggy'; // généré par "php artisan ziggy:generate"

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
