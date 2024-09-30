import "./bootstrap";
import "bootstrap/dist/js/bootstrap.bundle.min.js";

import "laravel-datatables-vite";

import "./status-toggle";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

// DataTables
import "bootstrap-icons/font/bootstrap-icons.css";
import "datatables.net-bs5/css/dataTables.bootstrap5.min.css";
import "datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css";
import "datatables.net-select-bs5/css/select.bootstrap5.css";
