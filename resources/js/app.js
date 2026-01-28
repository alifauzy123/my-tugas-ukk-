import './bootstrap';
import '@fortawesome/fontawesome-free/css/all.min.css';
import Swal from 'sweetalert2';
import qz from 'qz-tray';
import qzPrint from './utils/qzPrint';
window.Swal = Swal;
window.qz = qz;
window.qzPrint = qzPrint;