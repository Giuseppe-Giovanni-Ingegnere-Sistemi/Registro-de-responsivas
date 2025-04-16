<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.html");
    exit;
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Registro de Dispositivos</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #3b82f6;
            --primary-hover: #2563eb;
            --success-color: #22c55e;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --info-color: #0ea5e9;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            --border-radius: 0.375rem;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --header-bg: #8bc34a;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--gray-50);
            color: var(--gray-900);
            line-height: 1.5;
        }

        .container {
            max-width: 100%;
            margin: 0 auto;
            padding: 1.5rem;
        }

        .header {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        @media (min-width: 768px) {
            .header {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
            }
        }

        .title {
            font-size: 1.875rem;
            font-weight: 700;
            line-height: 1.2;
        }

        .subtitle {
            color: var(--gray-500);
            margin-top: 0.25rem;
        }

        .search-container {
            display: flex;
            gap: 0.5rem;
            width: 100%;
            flex-wrap: wrap;
        }

        @media (min-width: 768px) {
            .search-container {
                width: auto;
            }
        }

        .search-box {
            position: relative;
            width: 100%;
        }

        @media (min-width: 768px) {
            .search-box {
                width: 16rem;
            }
        }

        .search-icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-500);
        }

        .search-input {
            width: 100%;
            padding: 0.5rem 0.75rem 0.5rem 2rem;
            border: 1px solid var(--gray-300);
            border-radius: var(--border-radius);
            font-size: 0.875rem;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.3);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: background-color 0.2s, border-color 0.2s, color 0.2s;
            border: 1px solid transparent;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
        }

        .btn-outline {
            background-color: transparent;
            border-color: var(--gray-300);
            color: var(--gray-700);
        }

        .btn-outline:hover {
            background-color: var(--gray-100);
        }

        .btn-danger {
            background-color: var(--danger-color);
            color: white;
        }

        .btn-danger:hover {
            background-color: #dc2626;
        }

        .btn-icon {
            margin-right: 0.5rem;
            width: 1rem;
            height: 1rem;
        }

        .card {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            margin-bottom: 1.5rem;
        }

        .card-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .card-description {
            color: var(--gray-500);
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .card-content {
            padding: 1.5rem;
        }

        .table-container {
            overflow-x: auto;
            max-width: 100%;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        th {
            text-align: left;
            padding: 0.75rem 1rem;
            font-size: 0.75rem;
            font-weight: 500;
            color: var(--gray-900);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            background-color: var(--header-bg);
            border-bottom: 1px solid var(--gray-200);
            border-right: 1px solid var(--gray-200);
            white-space: nowrap;
            min-width: 150px;
            position: sticky;
            top: 0;
        }

        th:last-child {
            border-right: none;
        }

        td {
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            border-bottom: 1px solid var(--gray-200);
            border-right: 1px solid var(--gray-200);
            vertical-align: middle;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        td:last-child {
            border-right: none;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.125rem 0.5rem;
            font-size: 0.75rem;
            font-weight: 500;
            border-radius: 9999px;
            color: white;
        }

        .badge-success {
            background-color: var(--success-color);
        }

        .badge-warning {
            background-color: var(--warning-color);
        }

        .badge-danger {
            background-color: var(--danger-color);
        }

        .badge-info {
            background-color: var(--info-color);
        }

        .actions {
            display: flex;
            justify-content: flex-end;
            gap: 0.5rem;
        }

        .btn-icon-only {
            padding: 0.375rem;
            color: var(--gray-500);
            background-color: transparent;
            border: none;
            cursor: pointer;
            transition: color 0.2s;
        }

        .btn-icon-only:hover {
            color: var(--gray-700);
        }

        /* Modal */
        .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 50;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.2s, visibility 0.2s;
        }

        .modal-backdrop.active {
            opacity: 1;
            visibility: visible;
        }

        .modal {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            width: 100%;
            max-width: 900px;
            max-height: 90vh;
            overflow-y: auto;
            transform: translateY(20px);
            transition: transform 0.2s;
        }

        .modal-backdrop.active .modal {
            transform: translateY(0);
        }

        .modal-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--gray-500);
        }

        .modal-close:hover {
            color: var(--gray-700);
        }

        .modal-description {
            color: var(--gray-500);
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid var(--gray-200);
            display: flex;
            justify-content: flex-end;
            gap: 0.5rem;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .form-label {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--gray-700);
        }

        .form-control {
            width: 100%;
            padding: 0.5rem 0.75rem;
            border: 1px solid var(--gray-300);
            border-radius: var(--border-radius);
            font-size: 0.875rem;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.3);
        }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.5rem center;
            background-size: 1rem;
            padding-right: 2rem;
        }

        .form-group-full {
            grid-column: span 3;
        }

        /* Loader */
        .loader-container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }

        .loader {
            border: 4px solid var(--gray-200);
            border-top: 4px solid var(--primary-color);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Toast notifications */
        .toast-container {
            position: fixed;
            top: 1rem;
            right: 1rem;
            z-index: 100;
        }

        .toast {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            padding: 1rem;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            min-width: 300px;
            transform: translateX(120%);
            transition: transform 0.3s ease-out;
        }

        .toast.show {
            transform: translateX(0);
        }

        .toast-success {
            border-left: 4px solid var(--success-color);
        }

        .toast-error {
            border-left: 4px solid var(--danger-color);
        }

        .toast-info {
            border-left: 4px solid var(--info-color);
        }

        .toast-icon {
            margin-right: 0.75rem;
            width: 1.5rem;
            height: 1.5rem;
        }

        .toast-success .toast-icon {
            color: var(--success-color);
        }

        .toast-error .toast-icon {
            color: var(--danger-color);
        }

        .toast-info .toast-icon {
            color: var(--info-color);
        }

        .toast-content {
            flex: 1;
        }

        .toast-title {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .toast-message {
            color: var(--gray-600);
            font-size: 0.875rem;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .pagination-btn {
            padding: 0.5rem 0.75rem;
            border: 1px solid var(--gray-300);
            border-radius: var(--border-radius);
            background-color: white;
            color: var(--gray-700);
            cursor: pointer;
            transition: all 0.2s;
        }

        .pagination-btn:hover:not(.active) {
            background-color: var(--gray-100);
        }

        .pagination-btn.active {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .pagination-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Debug Modal */
        .debug-info {
            font-family: monospace;
            white-space: pre-wrap;
            background-color: var(--gray-100);
            padding: 1rem;
            border-radius: var(--border-radius);
            max-height: 400px;
            overflow-y: auto;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .form-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .form-group-full {
                grid-column: span 2;
            }
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .form-group-full {
                grid-column: span 1;
            }
        }

        /* Mejoras para la tabla */
        .table-wrapper {
            position: relative;
            overflow-x: auto;
            max-width: 100%;
            border-radius: var(--border-radius);
            border: 1px solid var(--gray-300);
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        .table-fixed {
            table-layout: fixed;
        }

        .table-compact th,
        .table-compact td {
            padding: 0.5rem;
            font-size: 0.75rem;
        }

        /* Estilos para columnas específicas */
        .col-id { width: 60px; }
        .col-clave { width: 100px; }
        .col-nombre { width: 200px; }
        .col-puesto { width: 150px; }
        .col-departamento { width: 150px; }
        .col-ceco { width: 100px; }
        .col-nomina { width: 100px; }
        .col-empresa { width: 150px; }
        .col-ciudad { width: 150px; }
        .col-tipo { width: 150px; }
        .col-propio { width: 150px; }
        .col-codigo { width: 120px; }
        .col-marca { width: 120px; }
        .col-modelo { width: 120px; }
        .col-serie { width: 120px; }
        .col-imei { width: 120px; }
        .col-telefono { width: 120px; }
        .col-username { width: 150px; }
        .col-correo { width: 200px; }
        .col-contrasena { width: 120px; }
        .col-resguardo { width: 120px; }
        .col-responsiva { width: 120px; }
        .col-activo { width: 80px; }
        .col-observaciones { width: 200px; }
        .col-ubicacion { width: 200px; }
        .col-direccion { width: 200px; }
        .col-acciones { width: 100px; }

        /* Estilos para filas alternadas */
        tr:nth-child(even) {
            background-color: var(--gray-50);
        }

        /* Estilos para hover en filas */
        tr:hover td {
            background-color: var(--gray-100);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <h1 class="title">Sistema de Registro de Dispositivos</h1>
                <p class="subtitle">Gestión de dispositivos y equipos asignados a empleados</p>
            </div>
            <div class="search-container">
               <div class="search-box">
                    <svg class="search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <input type="search" id="search-input" class="search-input" placeholder="Buscar por nombre, clave, departamento...">
                </div> 
                <button id="add-btn" class="btn btn-primary">
                    <svg class="btn-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Añadir Registro
                </button>
                <button id="export-btn" class="btn btn-outline">
                    <svg class="btn-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21 15V19C21 19.5304 20.7893 20.0391 20.4142 20.4142C20.0391 20.7893 19.5304 21 19 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V15M17 8L12 3M12 3L7 8M12 3V15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Exportar
                </button>
                <button id="debug-btn" class="btn btn-outline" style="background-color: #f3f4f6;">
                    <svg class="btn-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 19L19 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Depurar
                </button>
            </div>
          
        <a href="logout.php" class="btn btn-danger">
    <svg class="btn-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M15 12H3M15 12L10 7M15 12L10 17M21 3V21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
    Cerrar sesión
</a>
        

        </div>


        <div class="card">
            <div class="card-header">
                <div>
                    <h2 class="card-title">Registros de Dispositivos</h2>
                    <p class="card-description">Lista de dispositivos y equipos asignados a empleados</p>
                </div>
                <div id="table-info"></div>
            </div>
            <div class="card-content">
                <div class="table-wrapper">
                    <div class="table-responsive">
                        <table class="table-compact">
                            <thead>
                                <tr>
                                    <th class="col-id">ID</th>
                                    <th class="col-clave">CLAVE</th>
                                    <th class="col-nombre">APELLIDOS Y NOMBRE</th>
                                    <th class="col-puesto">PUESTO</th>
                                    <th class="col-departamento">DEPARTAMENTO</th>
                                    <th class="col-ceco">CECO</th>
                                    <th class="col-nomina">NOMINA</th>
                                    <th class="col-empresa">EMPRESA</th>
                                    <th class="col-ciudad">CIUDAD O ESTADO</th>
                                    <th class="col-tipo">TIPO DE DISPOSITIVO</th>
                                    <th class="col-propio">PROPIO O ARRENDAMIENTO</th>
                                    <th class="col-codigo">CODIGO ALDESA</th>
                                    <th class="col-marca">MARCA</th>
                                    <th class="col-modelo">MODELO</th>
                                    <th class="col-serie">SERIE</th>
                                    <th class="col-imei">IMEI</th>
                                    <th class="col-telefono">No. DE TELEFONO</th>
                                    <th class="col-username">USERNAME</th>
                                    <th class="col-correo">CORREO</th>
                                    <th class="col-contrasena">CONTRASEÑA</th>
                                    <th class="col-resguardo">RESGUARDO</th>
                                    <th class="col-responsiva">RESPONSIVA CORREO</th>
                                    <th class="col-activo">ACTIVO</th>
                                    <th class="col-observaciones">OBSERVACIONES</th>
                                    <th class="col-ubicacion">UBICACION GOOGLE MAPS</th>
                                    <th class="col-direccion">DIRECCION IMPRESORAS</th>
                                    <th class="col-acciones">ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody id="registros-table">
                                <tr>
                                    <td colspan="27">
                                        <div class="loader-container">
                                            <div class="loader"></div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="pagination" id="pagination"></div>
            </div>
        </div>
    </div>

    <!-- Modal para añadir/editar registros -->
    <div class="modal-backdrop" id="form-modal">
        <div class="modal">
            <div class="modal-header">
                <h2 class="modal-title" id="modal-title">Añadir Registro</h2>
                <button class="modal-close" id="modal-close">&times;</button>
            </div>
            <form id="registro-form">
                <div class="modal-body">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="clave" class="form-label">CLAVE</label>
                            <input type="text" id="clave" name="clave" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="apellidos_nombre" class="form-label">APELLIDOS Y NOMBRE</label>
                            <input type="text" id="apellidos_nombre" name="apellidos_nombre" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="puesto" class="form-label">PUESTO</label>
                            <input type="text" id="puesto" name="puesto" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="departamento" class="form-label">DEPARTAMENTO</label>
                            <input type="text" id="departamento" name="departamento" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="ceco" class="form-label">CECO</label>
                            <input type="text" id="ceco" name="ceco" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="nomina" class="form-label">NOMINA</label>
                            <input type="text" id="nomina" name="nomina" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="empresa" class="form-label">EMPRESA</label>
                            <input type="text" id="empresa" name="empresa" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="ciudad_estado" class="form-label">CIUDAD O ESTADO</label>
                            <input type="text" id="ciudad_estado" name="ciudad_estado" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="tipo_dispositivo" class="form-label">TIPO DE DISPOSITIVO</label>
                            <select id="tipo_dispositivo" name="tipo_dispositivo" class="form-control">
                                <option value="">Seleccionar...</option>
                                <option value="Laptop">Laptop</option>
                                <option value="PC">PC</option>
                                <option value="Tablet">Tablet</option>
                                <option value="Celular">Celular</option>
                                <option value="Telefono">Telefono</option>
                                <option value="Impresora">Impresora</option>
                                <option value="Monitor">Monitor</option>
                                <option value="Mouse">Mouse</option>
                                <option value="Teclado">Teclado</option>
                                <option value="Software">Software</option>
                                <option value="Disco Duro">Disco Duro</option>
                                <option value="Switch">Switch</option>
                                <option value="Correo">Correo</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="propio_arrendamiento" class="form-label">PROPIO O ARRENDAMIENTO</label>
                            <select id="propio_arrendamiento" name="propio_arrendamiento" class="form-control">
                                <option value="">Seleccionar...</option>
                                <option value="Propio">Propio</option>
                                <option value="Arrendamiento">Arrendamiento</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="codigo_aldesa" class="form-label">CODIGO ALDESA</label>
                            <input type="text" id="codigo_aldesa" name="codigo_aldesa" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="marca" class="form-label">MARCA</label>
                            <input type="text" id="marca" name="marca" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="modelo" class="form-label">MODELO</label>
                            <input type="text" id="modelo" name="modelo" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="serie" class="form-label">SERIE</label>
                            <input type="text" id="serie" name="serie" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="imei" class="form-label">IMEI</label>
                            <input type="text" id="imei" name="imei" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="numero_telefono" class="form-label">No. DE TELEFONO</label>
                            <input type="text" id="numero_telefono" name="numero_telefono" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="username" class="form-label">USERNAME</label>
                            <input type="text" id="username" name="username" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="correo" class="form-label">CORREO</label>
                            <input type="email" id="correo" name="correo" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="contrasena" class="form-label">CONTRASEÑA</label>
                            <input type="password" id="contrasena" name="contrasena" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="resguardo" class="form-label">RESGUARDO</label>
                            <input type="text" id="resguardo" name="resguardo" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="responsiva_correo" class="form-label">RESPONSIVA CORREO</label>
                            <select id="responsiva_correo" name="responsiva_correo" class="form-control">
                                <option value="">Seleccionar...</option>
                                <option value="Sí">Sí</option>
                                <option value="No">No</option>
                                <option value="Pendiente">Pendiente</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="activo" class="form-label">ACTIVO</label>
                            <select id="activo" name="activo" class="form-control">
                                <option value="">Seleccionar...</option>
                                <option value="Sí">Sí</option>
                                <option value="No">No</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="direccion_impresoras" class="form-label">DIRECCION IMPRESORAS</label>
                            <input type="text" id="direccion_impresoras" name="direccion_impresoras" class="form-control">
                        </div>
                        <div class="form-group form-group-full">
                            <label for="ubicacion_maps" class="form-label">UBICACION GOOGLE MAPS</label>
                            <input type="text" id="ubicacion_maps" name="ubicacion_maps" class="form-control">
                        </div>
                        <div class="form-group form-group-full">
                            <label for="observaciones" class="form-label">OBSERVACIONES</label>
                            <textarea id="observaciones" name="observaciones" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <input type="hidden" id="registro-id" name="id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" id="cancel-btn">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal de confirmación para eliminar -->
    <div class="modal-backdrop" id="delete-modal">
        <div class="modal" style="max-width: 500px;">
            <div class="modal-header">
                <h2 class="modal-title">Confirmar Eliminación</h2>
                <button class="modal-close" id="delete-modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de que desea eliminar este registro? Esta acción no se puede deshacer.</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" id="delete-cancel-btn">Cancelar</button>
                <button class="btn btn-danger" id="delete-confirm-btn">Eliminar</button>
            </div>
        </div>
    </div>

    <!-- Modal de depuración -->
    <div class="modal-backdrop" id="debug-modal">
        <div class="modal" style="max-width: 800px;">
            <div class="modal-header">
                <h2 class="modal-title">Información de Depuración</h2>
                <button class="modal-close" id="debug-modal-close">&times;</button>
            </div>
            <div class="modal-body">
                
                <div class="debug-info" id="debug-info">
                    Cargando información de depuración...
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" id="debug-close-btn">Cerrar</button>
            </div>
        </div>
    </div>

    <!-- Contenedor de notificaciones toast -->
    <div class="toast-container" id="toast-container"></div>

    <script>

        
        // Variables globales
        const API_URL = 'dispositivos_api.php';
        let currentPage = 1;
        let totalPages = 1;
        let itemsPerPage = 10;
        let currentRegistros = [];
        let deleteId = null;

        // Elementos DOM
        const searchInput = document.getElementById('search-input');
        const addBtn = document.getElementById('add-btn');
        const exportBtn = document.getElementById('export-btn');
        const debugBtn = document.getElementById('debug-btn');
        const registrosTable = document.getElementById('registros-table');
        const paginationContainer = document.getElementById('pagination');
        const formModal = document.getElementById('form-modal');
        const modalClose = document.getElementById('modal-close');
        const cancelBtn = document.getElementById('cancel-btn');
        const registroForm = document.getElementById('registro-form');
        const modalTitle = document.getElementById('modal-title');
        const deleteModal = document.getElementById('delete-modal');
        const deleteModalClose = document.getElementById('delete-modal-close');
        const deleteCancelBtn = document.getElementById('delete-cancel-btn');
        const deleteConfirmBtn = document.getElementById('delete-confirm-btn');
        const toastContainer = document.getElementById('toast-container');
        const debugModal = document.getElementById('debug-modal');
        const debugModalClose = document.getElementById('debug-modal-close');
        const debugCloseBtn = document.getElementById('debug-close-btn');
        const debugInfo = document.getElementById('debug-info');
        const tableInfo = document.getElementById('table-info');

        // Cargar datos
        async function loadData(searchTerm = '') {
            try {
                let url = `${API_URL}?action=getAll`;
                
                if (searchTerm) {
                    url = `${API_URL}?action=search&term=${encodeURIComponent(searchTerm)}`;
                }
                
                const response = await fetch(url);
                
                if (!response.ok) {
                    throw new Error(`Error HTTP: ${response.status}`);
                }
                
                const result = await response.json();
                
                if (!result.success) {
                    throw new Error(result.error || 'Error al cargar datos');
                }
                
                currentRegistros = result.data;
                
                // Mostrar información de la tabla
                if (result.tableName) {
                    tableInfo.innerHTML = `<span style="font-size: 0.875rem; color: var(--gray-500);">Tabla: ${result.tableName}</span>`;
                }
                
                renderTable();
                renderPagination();
            } catch (error) {
                showToast('Error', error.message, 'error');
                registrosTable.innerHTML = `
                    <tr>
                        <td colspan="27" style="text-align: center; padding: 2rem;">
                            <p>Error al cargar datos: ${error.message}</p>
                            <button class="btn btn-primary" onclick="loadData()">Reintentar</button>
                        </td>
                    </tr>
                `;
            }
        }

        // Renderizar tabla
        function renderTable() {
            if (!currentRegistros || currentRegistros.length === 0) {
                registrosTable.innerHTML = `
                    <tr>
                        <td colspan="27" style="text-align: center; padding: 2rem;">
                            No hay registros para mostrar
                        </td>
                    </tr>
                `;
                return;
            }
            
            // Calcular paginación
            totalPages = Math.ceil(currentRegistros.length / itemsPerPage);
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = Math.min(startIndex + itemsPerPage, currentRegistros.length);
            const paginatedItems = currentRegistros.slice(startIndex, endIndex);
            
            registrosTable.innerHTML = '';
            
            paginatedItems.forEach(item => {
                const row = document.createElement('tr');
                
                row.innerHTML = `
                    <td>${item.id}</td>
                    <td>${item.clave || '-'}</td>
                    <td>${item.apellidos_nombre || '-'}</td>
                    <td>${item.puesto || '-'}</td>
                    <td>${item.departamento || '-'}</td>
                    <td>${item.ceco || '-'}</td>
                    <td>${item.nomina || '-'}</td>
                    <td>${item.empresa || '-'}</td>
                    <td>${item.ciudad_estado || '-'}</td>
                    <td>${item.tipo_dispositivo || '-'}</td>
                    <td>${item.propio_arrendamiento || '-'}</td>
                    <td>${item.codigo_aldesa || '-'}</td>
                    <td>${item.marca || '-'}</td>
                    <td>${item.modelo || '-'}</td>
                    <td>${item.serie || '-'}</td>
                    <td>${item.imei || '-'}</td>
                    <td>${item.numero_telefono || '-'}</td>
                    <td>${item.username || '-'}</td>
                    <td>${item.correo || '-'}</td>
                    <td>${item.contrasena ? '********' : '-'}</td>
                    <td>${item.resguardo || '-'}</td>
                    <td>${item.responsiva_correo || '-'}</td>
                    <td>${item.activo === 'Sí' ? 
                        '<span class="badge badge-success">Sí</span>' : 
                        item.activo === 'No' ? 
                        '<span class="badge badge-danger">No</span>' : '-'}</td>
                    <td>${item.observaciones || '-'}</td>
                    <td>${item.ubicacion_maps || '-'}</td>
                    <td>${item.direccion_impresoras || '-'}</td>
                    <td>
                        <div class="actions">
                            <button class="btn-icon-only edit-btn" data-id="${item.id}">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11 4H4C3.46957 4 2.96086 4.21071 2.58579 4.58579C2.21071 4.96086 2 5.46957 2 6V20C2 20.5304 2.21071 21.0391 2.58579 21.4142C2.96086 21.7893 3.46957 22 4 22H18C18.5304 22 19.0391 21.7893 19.4142 21.4142C19.7893 21.0391 20 20.5304 20 20V13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M18.5 2.50001C18.8978 2.10219 19.4374 1.87869 20 1.87869C20.5626 1.87869 21.1022 2.10219 21.5 2.50001C21.8978 2.89784 22.1213 3.4374 22.1213 4.00001C22.1213 4.56262 21.8978 5.10219 21.5 5.50001L12 15L8 16L9 12L18.5 2.50001Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                            <button class="btn-icon-only delete-btn" data-id="${item.id}">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3 6H5H21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M8 6V4C8 3.46957 8.21071 2.96086 8.58579 2.58579C8.96086 2.21071 9.46957 2 10 2H14C14.5304 2 15.0391 2.21071 15.4142 2.58579C15.7893 2.96086 16 3.46957 16 4V6M19 6V20C19 20.5304 18.7893 21.0391 18.4142 21.4142C18.0391 21.7893 17.5304 22 17 22H7C6.46957 22 5.96086 21.7893 5.58579 21.4142C5.21071 21.0391 5 20.5304 5 20V6H19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                    </td>
                `;
                
                registrosTable.appendChild(row);
            });
            
            // Agregar event listeners a los botones
            document.querySelectorAll('.edit-btn').forEach(btn => {
                btn.addEventListener('click', handleEdit);
            });
            
            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', handleDelete);
            });
        }

        // Renderizar paginación
        function renderPagination() {
            paginationContainer.innerHTML = '';
            
            if (totalPages <= 1) return;
            
            // Botón anterior
            const prevBtn = document.createElement('button');
            prevBtn.className = 'pagination-btn';
            prevBtn.innerHTML = '&laquo;';
            prevBtn.disabled = currentPage === 1;
            prevBtn.addEventListener('click', () => {
                if (currentPage > 1) {
                    currentPage--;
                    renderTable();
                    renderPagination();
                }
            });
            paginationContainer.appendChild(prevBtn);
            
            // Botones de página
            const maxButtons = 5;
            const startPage = Math.max(1, currentPage - Math.floor(maxButtons / 2));
            const endPage = Math.min(totalPages, startPage + maxButtons - 1);
            
            for (let i = startPage; i <= endPage; i++) {
                const pageBtn = document.createElement('button');
                pageBtn.className = `pagination-btn ${i === currentPage ? 'active' : ''}`;
                pageBtn.textContent = i;
                pageBtn.addEventListener('click', () => {
                    currentPage = i;
                    renderTable();
                    renderPagination();
                });
                paginationContainer.appendChild(pageBtn);
            }
            
            // Botón siguiente
            const nextBtn = document.createElement('button');
            nextBtn.className = 'pagination-btn';
            nextBtn.innerHTML = '&raquo;';
            nextBtn.disabled = currentPage === totalPages;
            nextBtn.addEventListener('click', () => {
                if (currentPage < totalPages) {
                    currentPage++;
                    renderTable();
                    renderPagination();
                }
            });
            paginationContainer.appendChild(nextBtn);
        }

        // Manejar edición
        async function handleEdit(e) {
            const id = e.currentTarget.dataset.id;
            
            try {
                const response = await fetch(`${API_URL}?action=getById&id=${id}`);
                const result = await response.json();
                
                if (!result.success) {
                    throw new Error(result.error || 'Error al obtener registro');
                }
                
                const item = result.data;
                
                // Configurar formulario para edición
                modalTitle.textContent = 'Editar Registro';
                document.getElementById('registro-id').value = item.id;
                
                // Llenar campos del formulario
                Object.keys(item).forEach(key => {
                    const input = document.getElementById(key);
                    if (input) {
                        input.value = item[key] || '';
                    }
                });
                
                // Mostrar modal
                formModal.classList.add('active');
            } catch (error) {
                showToast('Error', error.message, 'error');
            }
        }

        // Manejar eliminación
        function handleDelete(e) {
            deleteId = e.currentTarget.dataset.id;
            deleteModal.classList.add('active');
        }

        // Confirmar eliminación
        async function confirmDelete() {
            if (!deleteId) return;
            
            try {
                const response = await fetch(`${API_URL}?action=delete&id=${deleteId}`);
                const result = await response.json();
                
                if (!result.success) {
                    throw new Error(result.error || 'Error al eliminar registro');
                }
                
                showToast('Éxito', 'Registro eliminado correctamente', 'success');
                loadData(searchInput.value);
            } catch (error) {
                showToast('Error', error.message, 'error');
            } finally {
                deleteModal.classList.remove('active');
                deleteId = null;
            }
        }

        // Exportar a CSV
        function exportToCSV() {
            if (!currentRegistros || currentRegistros.length === 0) {
                showToast('Información', 'No hay datos para exportar', 'info');
                return;
            }
            
            // Obtener encabezados
            const headers = Object.keys(currentRegistros[0]);
            
            // Crear contenido CSV
            let csvContent = headers.join(',') + '\n';
            
            currentRegistros.forEach(item => {
                const row = headers.map(header => {
                    // Escapar comillas y formatear valores
                    const value = item[header] !== null && item[header] !== undefined ? item[header] : '';
                    return `"${String(value).replace(/"/g, '""')}"`;
                });
                csvContent += row.join(',') + '\n';
            });
            
            // Crear blob y descargar
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.setAttribute('href', url);
            link.setAttribute('download', `dispositivos_${new Date().toISOString().split('T')[0]}.csv`);
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            
            showToast('Éxito', 'Datos exportados correctamente', 'success');
        }

        // Mostrar información de depuración
        async function showDebugInfo() {
            debugInfo.textContent = 'Cargando información de depuración...';
            debugModal.classList.add('active');
            
            try {
                const response = await fetch(`${API_URL}?action=debug`);
                const result = await response.json();
                
                if (!result.success) {
                    throw new Error(result.error || 'Error al obtener información de depuración');
                }
                
                // Formatear la información de depuración
                let debugText = `INFORMACIÓN DE LA BASE DE DATOS\n`;
                debugText += `==========================\n\n`;
                debugText += `Conexión: ${result.success ? 'Exitosa' : 'Fallida'}\n`;
                debugText += `Tabla actual: ${result.currentTable}\n\n`;
                
                debugText += `TABLAS DISPONIBLES\n`;
                debugText += `=================\n`;
                result.tables.forEach(table => {
                    debugText += `- ${table}\n`;
                });
                
                debugText += `\nDETALLES DE LAS TABLAS\n`;
                debugText += `====================\n\n`;
                
                for (const [tableName, info] of Object.entries(result.tableInfo)) {
                    debugText += `Tabla: ${tableName}\n`;
                    debugText += `Registros: ${info.count}\n`;
                    debugText += `Columnas:\n`;
                    
                    info.columns.forEach(column => {
                        debugText += `  - ${column.Field} (${column.Type})\n`;
                    });
                    
                    debugText += `\n`;
                }
                
                debugInfo.textContent = debugText;
            } catch (error) {
                debugInfo.textContent = `Error al obtener información de depuración: ${error.message}`;
            }
        }

        // Mostrar notificaciones toast
        function showToast(title, message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            
            toast.innerHTML = `
                <div class="toast-icon">
                    ${type === 'success' 
                        ? '<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 13L9 17L19 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>'
                        : type === 'error'
                            ? '<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 8V12M12 16H12.01M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>'
                            : '<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13 16H12V12H11M12 8H12.01M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>'
                    }
                </div>
                <div class="toast-content">
                    <div class="toast-title">${title}</div>
                    <div class="toast-message">${message}</div>
                </div>
            `;
            
            toastContainer.appendChild(toast);
            
            // Mostrar el toast con un pequeño retraso para la animación
            setTimeout(() => {
                toast.classList.add('show');
            }, 10);
            
            // Eliminar el toast después de 5 segundos
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }, 5000);
        }

        // Event Listeners
        document.addEventListener('DOMContentLoaded', () => {
            loadData();
            
            searchInput.addEventListener('input', debounce(() => {
                currentPage = 1;
                loadData(searchInput.value);
            }, 300));
            
            addBtn.addEventListener('click', () => {
                // Resetear formulario
                registroForm.reset();
                document.getElementById('registro-id').value = '';
                modalTitle.textContent = 'Añadir Registro';
                formModal.classList.add('active');
            });
            
            modalClose.addEventListener('click', () => {
                formModal.classList.remove('active');
            });
            
            cancelBtn.addEventListener('click', () => {
                formModal.classList.remove('active');
            });
            
            deleteModalClose.addEventListener('click', () => {
                deleteModal.classList.remove('active');
                deleteId = null;
            });
            
            deleteCancelBtn.addEventListener('click', () => {
                deleteModal.classList.remove('active');
                deleteId = null;
            });
            
            deleteConfirmBtn.addEventListener('click', confirmDelete);
            
            exportBtn.addEventListener('click', exportToCSV);
            
            debugBtn.addEventListener('click', showDebugInfo);
            
            debugModalClose.addEventListener('click', () => {
                debugModal.classList.remove('active');
            });
            
            debugCloseBtn.addEventListener('click', () => {
                debugModal.classList.remove('active');
            });
            
            registroForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                
                // Recopilar datos del formulario
                const formData = new FormData(registroForm);
                const data = {};
                
                for (let [key, value] of formData.entries()) {
                    data[key] = value;
                }
                
                const isEditing = data.id !== '';
                
                try {
                    const url = `${API_URL}?action=${isEditing ? 'update' : 'create'}`;
                    
                    const response = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(data)
                    });
                    
                    const result = await response.json();
                    
                    if (!result.success) {
                        throw new Error(result.error || 'Error al procesar la solicitud');
                    }
                    
                    showToast('Éxito', isEditing ? 'Registro actualizado correctamente' : 'Registro añadido correctamente', 'success');
                    formModal.classList.remove('active');
                    loadData(searchInput.value);
                } catch (error) {
                    showToast('Error', error.message, 'error');
                }
            });
        });

        // Función debounce para evitar múltiples llamadas
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }
    </script>
</body>
</html>