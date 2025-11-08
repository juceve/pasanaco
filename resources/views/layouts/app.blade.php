<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta name="description" content="Aplicación para gestión de sorteos y participantes en pasanacos" />
    <meta name="author" content="Pasanaco App" />
    <title>@yield('template_title') | {{ config('app.name') }}</title>
    
    <!-- PWA Meta Tags -->
    <meta name="theme-color" content="#1abc9c" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="default" />
    <meta name="apple-mobile-web-app-title" content="Pasanaco" />
    <meta name="mobile-web-app-capable" content="yes" />
    <meta name="application-name" content="Pasanaco" />
    
    <!-- Favicon and App Icons -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}" />
    <link rel="apple-touch-icon" href="{{ asset('images/icons/icon-192x192.png') }}" />
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('images/icons/icon-152x152.png') }}" />
    <link rel="apple-touch-icon" sizes="192x192" href="{{ asset('images/icons/icon-192x192.png') }}" />
    
    <!-- Web App Manifest -->
    <link rel="manifest" href="{{ asset('manifest.json') }}" />
    
    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Poppins Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

    <!-- DataTables con Bootstrap 5 -->
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    
    <!-- Select2 CSS con tema Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- Custom Styles for Glassmorphism Theme -->
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #0072ff, #00c6ff);
            --secondary-gradient: radial-gradient(circle at top, #0f2027, #203a43 60%, #2c5364 100%);
            --glass-bg: rgba(255, 255, 255, 0.08);
            --glass-border: rgba(255, 255, 255, 0.1);
            --text-primary: #ffffff;
            --text-secondary: rgba(255, 255, 255, 0.8);
            --accent-color: #00d2ff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            font-family: 'Poppins', sans-serif;
            background: var(--secondary-gradient);
            color: var(--text-primary);
            overflow-x: hidden;
            -webkit-text-size-adjust: 100%; /* Prevent text scaling on iOS */
            -webkit-touch-callout: none; /* Disable callout on touch */
            -webkit-tap-highlight-color: rgba(0, 210, 255, 0.1); /* Custom tap highlight */
            touch-action: manipulation; /* Fast taps, no double-tap zoom */
        }

        /* Glassmorphism Components */
        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(14px);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 255, 255, 0.1);
        }

        .glass-navbar {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--glass-border);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            min-height: 56px; /* Standard mobile navbar height */
        }

        /* Navbar Customization - Mobile First */
        .navbar-brand {
            color: var(--text-primary) !important;
            font-weight: 700;
            font-size: 1rem;
        }

        .navbar-nav .nav-link {
            color: var(--text-secondary) !important;
            font-weight: 500;
            padding: 0.6rem 0.8rem !important;
            border-radius: 8px;
            transition: all 0.3s ease;
            margin: 0 0.15rem;
            font-size: 0.9rem;
            min-height: 44px;
            display: flex;
            align-items: center;
        }

        .navbar-nav .nav-link:hover {
            color: var(--accent-color) !important;
            background: rgba(0, 210, 255, 0.1);
            transform: translateY(-1px);
        }

        .navbar-toggler {
            border: 1px solid var(--glass-border);
            border-radius: 8px;
            padding: 0.4rem 0.6rem;
            font-size: 0.9rem;
        }

        .navbar-toggler-icon {
            filter: invert(1);
        }

        /* Button Styles */
        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            border-radius: 12px;
            font-weight: 600;
            padding: 0.6rem 1.5rem;
            box-shadow: 0 4px 15px rgba(0, 210, 255, 0.3);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 210, 255, 0.5);
        }

        .btn-secondary {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            color: var(--text-primary);
            border-radius: 12px;
            font-weight: 500;
            backdrop-filter: blur(10px);
        }

        /* Card Styles - Mobile Optimized */
        .card {
            background: var(--glass-bg);
            backdrop-filter: blur(14px);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 255, 255, 0.1);
            color: var(--text-primary);
            margin-bottom: 1rem;
        }

        .card-header {
            background: rgba(0, 210, 255, 0.1);
            border-bottom: 1px solid var(--glass-border);
            border-radius: 12px 12px 0 0 !important;
            font-weight: 600;
            color: var(--accent-color);
            padding: 0.8rem 1rem;
            font-size: 0.9rem;
        }

        /* Form Controls */
        .form-control, .form-select {
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            color: var(--text-primary);
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.2rem rgba(0, 210, 255, 0.25);
            color: var(--text-primary);
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .form-label {
            color: var(--accent-color);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        /* Table Styles */
        .table {
            color: var(--text-primary);
        }

        .table-dark {
            --bs-table-bg: var(--glass-bg);
            backdrop-filter: blur(10px);
        }

        .table th {
            border-color: var(--glass-border);
            color: var(--accent-color);
            font-weight: 600;
            padding: 0.6rem 0.8rem;
            font-size: 0.85rem;
        }

        .table td {
            border-color: rgba(255, 255, 255, 0.1);
            padding: 0.6rem 0.8rem;
            font-size: 0.85rem;
        }

        /* Alert Styles */
        .alert {
            background: var(--glass-bg);
            backdrop-filter: blur(14px);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            color: var(--text-primary);
        }

        .alert-success {
            border-color: rgba(40, 167, 69, 0.3);
            background: rgba(40, 167, 69, 0.1);
        }

        .alert-danger {
            border-color: rgba(220, 53, 69, 0.3);
            background: rgba(220, 53, 69, 0.1);
        }

        .alert-warning {
            border-color: rgba(255, 193, 7, 0.3);
            background: rgba(255, 193, 7, 0.1);
            color: #ffc107;
        }

        .alert-info {
            border-color: rgba(23, 162, 184, 0.3);
            background: rgba(23, 162, 184, 0.1);
            color: #17a2b8;
        }

        /* Select2 Styling */
        .select2-container--bootstrap-5 .select2-selection {
            background: rgba(255, 255, 255, 0.08) !important;
            border: 2px solid rgba(255, 255, 255, 0.15) !important;
            border-radius: 12px !important;
            color: var(--text-primary) !important;
            min-height: calc(2.875rem + 2px) !important;
        }

        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
            color: var(--text-primary) !important;
            padding-left: 1rem !important;
            line-height: 2.875rem !important;
        }

        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__arrow {
            height: calc(2.875rem + 2px) !important;
            right: 1rem !important;
        }

        .select2-dropdown {
            background: rgba(44, 62, 80, 0.95) !important;
            backdrop-filter: blur(20px) !important;
            border: 1px solid var(--glass-border) !important;
            border-radius: 12px !important;
        }

        .select2-container--bootstrap-5 .select2-results__option {
            color: var(--text-primary) !important;
            padding: 0.75rem 1rem !important;
        }

        .select2-container--bootstrap-5 .select2-results__option--highlighted {
            background: rgba(0, 210, 255, 0.2) !important;
            color: var(--accent-color) !important;
        }

        .select2-container--bootstrap-5 .select2-results__option--selected {
            background: rgba(0, 210, 255, 0.3) !important;
            color: var(--accent-color) !important;
        }

        /* Badge Styling */
        .badge {
            border-radius: 8px !important;
            font-weight: 500;
            padding: 0.5rem 0.75rem;
        }

        .badge.bg-primary {
            background: var(--primary-gradient) !important;
        }

        .badge.bg-success {
            background: linear-gradient(135deg, #28a745, #20c997) !important;
        }

        .badge.bg-danger {
            background: linear-gradient(135deg, #dc3545, #e83e8c) !important;
        }

        .badge.bg-warning {
            background: linear-gradient(135deg, #ffc107, #fd7e14) !important;
            color: #212529 !important;
        }

        .badge.bg-info {
            background: linear-gradient(135deg, #17a2b8, #6f42c1) !important;
        }

        /* Progress Bar Styling */
        .progress {
            background: rgba(255, 255, 255, 0.1) !important;
            border-radius: 12px !important;
            height: 8px;
        }

        .progress-bar {
            background: var(--primary-gradient) !important;
            border-radius: 12px !important;
        }

        /* List Group Styling */
        .list-group-item {
            background: var(--glass-bg) !important;
            border: 1px solid var(--glass-border) !important;
            color: var(--text-primary) !important;
            backdrop-filter: blur(14px);
        }

        .list-group-item:hover {
            background: rgba(255, 255, 255, 0.12) !important;
        }

        .list-group-item.active {
            background: var(--primary-gradient) !important;
            border-color: var(--accent-color) !important;
        }

        /* Accordion Styling */
        .accordion-item {
            background: var(--glass-bg) !important;
            border: 1px solid var(--glass-border) !important;
            backdrop-filter: blur(14px);
        }

        .accordion-button {
            background: transparent !important;
            color: var(--text-primary) !important;
            border: none !important;
        }

        .accordion-button:focus {
            box-shadow: 0 0 0 0.2rem rgba(0, 210, 255, 0.25) !important;
        }

        .accordion-button:not(.collapsed) {
            color: var(--accent-color) !important;
            background: rgba(0, 210, 255, 0.1) !important;
        }

        .accordion-body {
            color: var(--text-primary) !important;
        }

        /* Breadcrumb Styling */
        .breadcrumb {
            background: var(--glass-bg) !important;
            backdrop-filter: blur(14px);
            border-radius: 12px !important;
            padding: 1rem 1.5rem;
        }

        .breadcrumb-item a {
            color: var(--accent-color) !important;
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: var(--text-secondary) !important;
        }

        /* DataTables Comprehensive Styling */
        .dataTables_wrapper {
            color: var(--text-primary) !important;
            font-family: 'Poppins', sans-serif !important;
        }

        /* DataTables Main Table Styling */
        table.dataTable {
            background: transparent !important;
            color: var(--text-primary) !important;
            border-collapse: separate !important;
            border-spacing: 0 !important;
        }

        table.dataTable thead th {
            background: rgba(0, 210, 255, 0.15) !important;
            color: var(--accent-color) !important;
            border: 1px solid var(--glass-border) !important;
            border-bottom: 2px solid var(--accent-color) !important;
            font-weight: 600 !important;
            padding: 1rem 0.75rem !important;
            text-align: left !important;
            position: relative !important;
        }

        table.dataTable thead th:first-child {
            border-top-left-radius: 12px !important;
        }

        table.dataTable thead th:last-child {
            border-top-right-radius: 12px !important;
        }

        table.dataTable tbody td {
            background: transparent !important;
            color: var(--text-primary) !important;
            border: 1px solid rgba(255, 255, 255, 0.05) !important;
            border-top: none !important;
            padding: 0.875rem 0.75rem !important;
            vertical-align: middle !important;
        }

        /* DataTables Striped Rows - Fixed */
        table.dataTable.table-striped > tbody > tr:nth-of-type(odd) > td {
            background: rgba(255, 255, 255, 0.025) !important;
        }

        table.dataTable.table-striped > tbody > tr:nth-of-type(even) > td {
            background: transparent !important;
        }

        /* DataTables Hover Effects - Fixed */
        table.dataTable.table-hover > tbody > tr:hover > td {
            background: rgba(0, 210, 255, 0.08) !important;
            color: var(--text-primary) !important;
            cursor: pointer !important;
        }

        /* DataTables Row Selection */
        table.dataTable > tbody > tr.selected > td {
            background: rgba(0, 210, 255, 0.2) !important;
            color: var(--accent-color) !important;
        }

        /* DataTables Sorting Icons */
        table.dataTable thead .sorting:after,
        table.dataTable thead .sorting_asc:after,
        table.dataTable thead .sorting_desc:after {
            color: var(--accent-color) !important;
            opacity: 0.7 !important;
        }

        table.dataTable thead .sorting:hover:after,
        table.dataTable thead .sorting_asc:hover:after,
        table.dataTable thead .sorting_desc:hover:after {
            opacity: 1 !important;
        }

        /* DataTables Controls Styling */
        .dataTables_filter input[type="search"] {
            background: rgba(255, 255, 255, 0.08) !important;
            border: 2px solid rgba(255, 255, 255, 0.15) !important;
            border-radius: 12px !important;
            color: var(--text-primary) !important;
            padding: 0.75rem 1rem !important;
            margin-left: 0.5rem !important;
            transition: all 0.3s ease !important;
        }

        .dataTables_filter input[type="search"]:focus {
            background: rgba(255, 255, 255, 0.12) !important;
            border-color: var(--accent-color) !important;
            box-shadow: 0 0 0 0.2rem rgba(0, 210, 255, 0.25) !important;
            outline: none !important;
        }

        .dataTables_filter input[type="search"]::placeholder {
            color: rgba(255, 255, 255, 0.5) !important;
        }

        .dataTables_length select {
            background: rgba(255, 255, 255, 0.08) !important;
            border: 2px solid rgba(255, 255, 255, 0.15) !important;
            border-radius: 8px !important;
            color: var(--text-primary) !important;
            padding: 0.5rem 0.75rem !important;
            margin: 0 0.5rem !important;
        }

        .dataTables_length select:focus {
            border-color: var(--accent-color) !important;
            outline: none !important;
        }

        .page-link {
            background: var(--glass-bg) !important;
            border: 1px solid var(--glass-border) !important;
            color: var(--text-primary) !important;
            backdrop-filter: blur(10px);
            border-radius: 8px !important;
            margin: 0 2px;
        }

        .page-link:hover {
            background: rgba(0, 210, 255, 0.2) !important;
            border-color: var(--accent-color) !important;
            color: var(--accent-color) !important;
        }

        .page-item.active .page-link {
            background: var(--primary-gradient) !important;
            border-color: var(--accent-color) !important;
            color: white !important;
        }

        /* DataTables Wrapper and Controls */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            color: var(--text-primary) !important;
            margin-bottom: 1rem !important;
        }

        .dataTables_wrapper .dataTables_length label,
        .dataTables_wrapper .dataTables_filter label {
            color: var(--text-secondary) !important;
            font-weight: 500 !important;
            font-size: 0.9rem !important;
        }

        .dataTables_wrapper .dataTables_info {
            color: var(--text-secondary) !important;
            font-size: 0.85rem !important;
            padding-top: 1rem !important;
        }

        /* DataTables Pagination */
        .dataTables_wrapper .dataTables_paginate {
            padding-top: 1rem !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            background: var(--glass-bg) !important;
            border: 1px solid var(--glass-border) !important;
            color: var(--text-primary) !important;
            border-radius: 8px !important;
            margin: 0 2px !important;
            padding: 0.5rem 0.75rem !important;
            transition: all 0.3s ease !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: rgba(0, 210, 255, 0.2) !important;
            border-color: var(--accent-color) !important;
            color: var(--accent-color) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: var(--primary-gradient) !important;
            border-color: var(--accent-color) !important;
            color: white !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            background: rgba(255, 255, 255, 0.05) !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
            color: rgba(255, 255, 255, 0.4) !important;
            cursor: not-allowed !important;
        }

        /* Bootstrap Table Overrides for DataTables */
        .table {
            color: var(--text-primary) !important;
            border-color: transparent !important;
            margin-bottom: 0 !important;
        }

        /* Remove conflicting Bootstrap table styles */
        .table > :not(caption) > * > * {
            border-bottom-width: 0 !important;
        }

        .table th {
            border-color: transparent !important;
            color: var(--accent-color) !important;
            font-weight: 600 !important;
            background: transparent !important;
        }

        .table td {
            border-color: transparent !important;
            color: var(--text-primary) !important;
            background: transparent !important;
        }

        /* Override Bootstrap striped and hover for DataTables */
        .table-striped > tbody > tr:nth-of-type(odd) > td,
        .table-striped > tbody > tr:nth-of-type(odd) > th {
            background: transparent !important;
        }

        .table-hover > tbody > tr:hover > td,
        .table-hover > tbody > tr:hover > th {
            background: transparent !important;
        }

        /* DataTables Processing Indicator */
        .dataTables_processing {
            background: var(--glass-bg) !important;
            color: var(--text-primary) !important;
            border: 1px solid var(--glass-border) !important;
            border-radius: 12px !important;
            backdrop-filter: blur(20px) !important;
        }

        /* DataTables Empty State */
        .dataTables_empty {
            color: var(--text-secondary) !important;
            font-style: italic !important;
            text-align: center !important;
            padding: 2rem !important;
        }

        /* Table Action Buttons - Mobile Optimized */
        .table .btn {
            padding: 0.3rem 0.6rem;
            font-size: 0.75rem;
            border-radius: 6px;
            margin: 0.1rem;
            min-height: 32px;
            min-width: 32px;
        }

        /* DataTables Specific Row Styling - Higher Specificity */
        table.dataTable tbody tr {
            background: transparent !important;
        }

        table.dataTable tbody tr:nth-child(odd) {
            background: rgba(255, 255, 255, 0.025) !important;
        }

        table.dataTable tbody tr:nth-child(even) {
            background: transparent !important;
        }

        table.dataTable tbody tr:hover {
            background: rgba(0, 210, 255, 0.08) !important;
        }

        /* Force DataTables cell colors */
        table.dataTable tbody tr td {
            color: var(--text-primary) !important;
            background: inherit !important;
        }

        table.dataTable tbody tr:hover td {
            color: var(--text-primary) !important;
            background: inherit !important;
        }

        /* DataTables responsive styling */
        table.dataTable.dtr-inline.collapsed > tbody > tr > td.dtr-control:before {
            background-color: var(--accent-color) !important;
        }

        table.dataTable.dtr-inline.collapsed > tbody > tr.parent > td.dtr-control:before {
            background-color: #d33 !important;
        }

        /* DataTables search highlighting */
        .dataTables_wrapper mark {
            background: rgba(255, 193, 7, 0.3) !important;
            color: var(--text-primary) !important;
            padding: 0.125rem 0.25rem !important;
            border-radius: 4px !important;
        }

        /* DataTables column visibility buttons */
        .dt-button {
            background: var(--glass-bg) !important;
            border: 1px solid var(--glass-border) !important;
            color: var(--text-primary) !important;
            border-radius: 8px !important;
            padding: 0.5rem 1rem !important;
            margin: 0 0.25rem !important;
        }

        .dt-button:hover {
            background: rgba(0, 210, 255, 0.2) !important;
            border-color: var(--accent-color) !important;
            color: var(--accent-color) !important;
        }

        .dt-button.active {
            background: var(--primary-gradient) !important;
            border-color: var(--accent-color) !important;
            color: white !important;
        }

        /* Modal Styling - Mobile First */
        .modal-content {
            background: var(--glass-bg) !important;
            backdrop-filter: blur(20px) !important;
            border: 1px solid var(--glass-border) !important;
            border-radius: 12px !important;
            color: var(--text-primary) !important;
            margin: 0.5rem;
        }

        .modal-header {
            border-bottom: 1px solid var(--glass-border) !important;
            padding: 0.8rem 1rem;
        }

        .modal-footer {
            border-top: 1px solid var(--glass-border) !important;
            padding: 0.8rem 1rem;
        }

        .modal-title {
            color: var(--accent-color) !important;
            font-size: 1rem;
            font-weight: 600;
        }

        .btn-close {
            filter: invert(1) !important;
        }

        /* Override Bootstrap white backgrounds */
        .bg-white {
            background: var(--glass-bg) !important;
            backdrop-filter: blur(14px);
            color: var(--text-primary) !important;
        }

        .card-body {
            padding: 1rem;
        }

        .card-body.bg-white {
            background: transparent !important;
        }

        /* Form Group Styling - Mobile Optimized */
        .form-group {
            margin-bottom: 1rem;
        }

        .form-group .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--accent-color);
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        /* Enhanced Form Controls - Mobile First */
        .form-control, .form-select {
            background: rgba(255, 255, 255, 0.08) !important;
            border: 2px solid rgba(255, 255, 255, 0.15) !important;
            border-radius: 10px !important;
            color: var(--text-primary) !important;
            padding: 0.7rem 0.8rem !important;
            transition: all 0.3s ease !important;
            font-size: 0.9rem;
            backdrop-filter: blur(10px);
            min-height: 44px; /* Minimum touch target size */
        }

        .form-control:focus, .form-select:focus {
            background: rgba(255, 255, 255, 0.12) !important;
            border-color: var(--accent-color) !important;
            box-shadow: 0 0 0 0.2rem rgba(0, 210, 255, 0.25) !important;
            color: var(--text-primary) !important;
            outline: none !important;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.6) !important;
            font-size: 0.9rem;
        }

        /* Select dropdown styling */
        .form-select option {
            background: #2c3e50;
            color: white;
            padding: 0.5rem;
        }

        /* Validation States */
        .form-control.is-invalid, .form-select.is-invalid {
            border-color: #ff6b7a !important;
            box-shadow: 0 0 0 0.2rem rgba(255, 107, 122, 0.25) !important;
        }

        .form-control.is-valid, .form-select.is-valid {
            border-color: #28a745 !important;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25) !important;
        }

        .invalid-feedback {
            color: #ff6b7a !important;
            font-size: 0.85rem;
            font-weight: 500;
            margin-top: 0.5rem;
            display: block;
        }

        .valid-feedback {
            color: #28a745 !important;
            font-size: 0.85rem;
            font-weight: 500;
            margin-top: 0.5rem;
        }

        /* Button Enhancements - Mobile First */
        .btn {
            border-radius: 8px !important;
            font-weight: 600;
            padding: 0.6rem 1.2rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.85rem;
            min-height: 44px;
            line-height: 1.2;
        }

        .btn-primary {
            background: var(--primary-gradient) !important;
            border: none !important;
            color: white !important;
            box-shadow: 0 4px 15px rgba(0, 210, 255, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 210, 255, 0.5) !important;
            color: white !important;
        }

        .btn-secondary {
            background: var(--glass-bg) !important;
            border: 1px solid var(--glass-border) !important;
            color: var(--text-primary) !important;
            backdrop-filter: blur(10px);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.15) !important;
            border-color: var(--accent-color) !important;
            color: var(--accent-color) !important;
            transform: translateY(-1px);
        }

        .btn-success {
            background: linear-gradient(135deg, #28a745, #20c997) !important;
            border: none !important;
            color: white !important;
            box-shadow: 0 2px 10px rgba(40, 167, 69, 0.3);
            font-size: 0.85rem;
        }

        .btn-danger {
            background: linear-gradient(135deg, #dc3545, #e83e8c) !important;
            border: none !important;
            color: white !important;
            box-shadow: 0 2px 10px rgba(220, 53, 69, 0.3);
            font-size: 0.85rem;
        }

        .btn-warning {
            background: linear-gradient(135deg, #ffc107, #fd7e14) !important;
            border: none !important;
            color: #212529 !important;
            box-shadow: 0 2px 10px rgba(255, 193, 7, 0.3);
            font-size: 0.85rem;
        }

        .btn-info {
            background: linear-gradient(135deg, #17a2b8, #6f42c1) !important;
            border: none !important;
            color: white !important;
            box-shadow: 0 2px 10px rgba(23, 162, 184, 0.3);
            font-size: 0.85rem;
        }

        .btn-sm {
            padding: 0.4rem 0.8rem;
            font-size: 0.75rem;
            min-height: 36px;
        }

        .btn-lg {
            padding: 0.8rem 1.6rem;
            font-size: 1rem;
            min-height: 52px;
        }

        /* Input Group Styling - Mobile Optimized */
        .input-group .form-control {
            border-right: none;
        }

        .input-group-text {
            background: rgba(255, 255, 255, 0.08);
            border: 2px solid rgba(255, 255, 255, 0.15);
            border-left: none;
            color: var(--accent-color);
            backdrop-filter: blur(10px);
            padding: 0.7rem 0.8rem;
            font-size: 0.9rem;
            min-height: 44px;
            display: flex;
            align-items: center;
        }

        /* Checkbox and Radio Styling - Mobile Touch Friendly */
        .form-check-input {
            background-color: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.2);
            width: 1.25rem;
            height: 1.25rem;
            min-width: 44px;
            min-height: 44px;
            cursor: pointer;
        }

        .form-check-input:checked {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
        }

        .form-check-label {
            color: var(--text-secondary);
            margin-left: 0.5rem;
            font-size: 0.9rem;
            cursor: pointer;
            padding: 0.5rem;
            min-height: 44px;
            display: flex;
            align-items: center;
        }

        .form-check {
            padding-left: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.75rem;
        }

        /* Textarea Styling - Mobile Optimized */
        textarea.form-control {
            min-height: 100px;
            resize: vertical;
            resize: vertical;
        }

        /* File Input Styling */
        .form-control[type="file"] {
            padding: 0.5rem;
        }

        .form-control[type="file"]::-webkit-file-upload-button {
            background: var(--primary-gradient);
            border: none;
            border-radius: 8px;
            color: white;
            padding: 0.5rem 1rem;
            margin-right: 1rem;
            cursor: pointer;
        }

        /* Main Content Area - Mobile Optimized */
        .main-content {
            min-height: calc(100vh - 80px);
            padding: 1rem 0;
        }

        /* Responsive adjustments - Mobile First Design */
        
        /* Small devices (landscape phones, less than 576px) */
        @media (max-width: 575.98px) {
            .container-fluid {
                padding-left: 0.75rem;
                padding-right: 0.75rem;
            }
            
            .main-content {
                padding: 0.75rem 0;
            }
            
            .card {
                margin-bottom: 0.75rem;
                border-radius: 10px;
            }
            
            .card-body {
                padding: 0.75rem;
            }

            .btn {
                padding: 0.5rem 1rem;
                font-size: 0.8rem;
                min-height: 42px;
            }
            
            .btn-sm {
                padding: 0.35rem 0.7rem;
                font-size: 0.7rem;
                min-height: 34px;
            }
            
            .table th, .table td {
                padding: 0.4rem 0.5rem;
                font-size: 0.8rem;
            }
            
            .navbar-brand {
                font-size: 0.9rem;
            }
            
            .navbar-nav .nav-link {
                padding: 0.5rem 0.6rem !important;
                font-size: 0.85rem;
            }
            
            .form-control, .form-select {
                font-size: 16px; /* Prevent zoom on iOS */
                padding: 0.6rem 0.7rem !important;
            }
            
            .modal-content {
                margin: 0.25rem;
            }
            
            .modal-header, .modal-footer {
                padding: 0.6rem 0.8rem;
            }
        }

        /* Medium devices (tablets, 576px and up) */
        @media (min-width: 576px) and (max-width: 767.98px) {
            .main-content {
                padding: 1rem 0;
            }
            
            .btn {
                padding: 0.6rem 1.1rem;
                font-size: 0.85rem;
            }
            
            .table th, .table td {
                padding: 0.5rem 0.7rem;
                font-size: 0.85rem;
            }
        }

        /* Large devices (desktops, 768px and up) */
        @media (min-width: 768px) and (max-width: 991.98px) {
            .btn {
                padding: 0.65rem 1.3rem;
                font-size: 0.9rem;
            }
            
            .navbar-brand {
                font-size: 1.05rem;
            }
            
            .navbar-nav .nav-link {
                padding: 0.65rem 0.9rem !important;
                font-size: 0.95rem;
            }
        }

        /* Extra large devices (large desktops, 992px and up) */
        @media (min-width: 992px) {
            .btn {
                padding: 0.7rem 1.4rem;
                font-size: 0.95rem;
            }
            
            .card-body {
                padding: 1.25rem;
            }
            
            .table th, .table td {
                padding: 0.75rem 1rem;
                font-size: 0.9rem;
            }
        }

        /* Touch-friendly improvements */
        .clickable, .btn, .nav-link, .table .btn, .form-check-label, .form-check-input {
            -webkit-tap-highlight-color: rgba(0, 210, 255, 0.2);
            user-select: none;
            -webkit-user-select: none;
        }

        /* Prevent zoom on input focus (mobile) */
        @media screen and (max-width: 767px) {
            input[type="text"], 
            input[type="email"], 
            input[type="password"], 
            input[type="number"], 
            input[type="tel"], 
            input[type="url"], 
            input[type="search"], 
            textarea, 
            select {
                font-size: 16px !important;
                transform: translateZ(0);
                -webkit-appearance: none;
                border-radius: 10px !important;
            }
        }

        /* Smooth scrolling for all devices */
        * {
            -webkit-overflow-scrolling: touch;
            scroll-behavior: smooth;
        }

        /* Improve form validation styling for mobile */
        .invalid-feedback {
            font-size: 0.8rem;
            margin-top: 0.25rem;
        }

        .is-invalid .form-control {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
        }

        .is-valid .form-control {
            border-color: #28a745 !important;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25) !important;
        }

        /* SweetAlert2 Dark Theme Customization */
        .swal2-popup {
            background: rgba(44, 62, 80, 0.98) !important;
            backdrop-filter: blur(20px) !important;
            border: 1px solid var(--glass-border) !important;
            border-radius: 16px !important;
            color: var(--text-primary) !important;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5) !important;
        }

        .swal2-title {
            color: var(--accent-color) !important;
            font-weight: 700 !important;
            font-size: 1.5rem !important;
        }

        .swal2-html-container {
            color: var(--text-secondary) !important;
            font-size: 1rem !important;
        }

        .swal2-confirm {
            background: linear-gradient(135deg, #1abc9c, #16a085) !important;
            border: none !important;
            border-radius: 10px !important;
            padding: 0.75rem 2rem !important;
            font-weight: 600 !important;
            box-shadow: 0 4px 15px rgba(26, 188, 156, 0.4) !important;
        }

        .swal2-confirm:hover {
            background: linear-gradient(135deg, #16a085, #1abc9c) !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 20px rgba(26, 188, 156, 0.6) !important;
        }

        .swal2-cancel {
            background: rgba(44, 62, 80, 0.8) !important;
            border: 1px solid var(--glass-border) !important;
            border-radius: 10px !important;
            padding: 0.75rem 2rem !important;
            font-weight: 600 !important;
            color: var(--text-primary) !important;
        }

        .swal2-cancel:hover {
            background: rgba(52, 73, 94, 0.9) !important;
            transform: translateY(-2px) !important;
        }

        .swal2-icon.swal2-success {
            border-color: #1abc9c !important;
        }

        .swal2-icon.swal2-success [class^='swal2-success-line'] {
            background-color: #1abc9c !important;
        }

        .swal2-icon.swal2-success .swal2-success-ring {
            border-color: rgba(26, 188, 156, 0.3) !important;
        }

        .swal2-icon.swal2-error {
            border-color: #e74c3c !important;
        }

        .swal2-icon.swal2-error [class^='swal2-x-mark-line'] {
            background-color: #e74c3c !important;
        }

        .swal2-icon.swal2-warning {
            border-color: #f39c12 !important;
            color: #f39c12 !important;
        }

        .swal2-icon.swal2-info {
            border-color: #3498db !important;
            color: #3498db !important;
        }

        .swal2-icon.swal2-question {
            border-color: #9b59b6 !important;
            color: #9b59b6 !important;
        }

        /* SweetAlert2 Input Fields */
        .swal2-input, .swal2-textarea, .swal2-select {
            background: rgba(255, 255, 255, 0.1) !important;
            border: 2px solid rgba(255, 255, 255, 0.2) !important;
            border-radius: 10px !important;
            color: var(--text-primary) !important;
            padding: 0.75rem 1rem !important;
        }

        .swal2-input:focus, .swal2-textarea:focus, .swal2-select:focus {
            border-color: var(--accent-color) !important;
            box-shadow: 0 0 0 3px rgba(0, 210, 255, 0.25) !important;
        }

        .swal2-input::placeholder, .swal2-textarea::placeholder {
            color: rgba(255, 255, 255, 0.5) !important;
        }

        .swal2-validation-message {
            background: rgba(231, 76, 60, 0.2) !important;
            color: #e74c3c !important;
            border-color: #e74c3c !important;
        }

        /* Toast Customization */
        .colored-toast.swal2-icon-success {
            background-color: rgba(26, 188, 156, 0.95) !important;
            backdrop-filter: blur(10px) !important;
        }

        .colored-toast.swal2-icon-error {
            background-color: rgba(231, 76, 60, 0.95) !important;
            backdrop-filter: blur(10px) !important;
        }

        .colored-toast.swal2-icon-info {
            background-color: rgba(52, 152, 219, 0.95) !important;
            backdrop-filter: blur(10px) !important;
        }

        .colored-toast.swal2-icon-warning {
            background-color: rgba(243, 156, 18, 0.95) !important;
            backdrop-filter: blur(10px) !important;
        }

        .colored-toast .swal2-title {
            color: white !important;
            font-size: 0.9rem !important;
        }

        .colored-toast .swal2-icon {
            color: white !important;
            border-color: white !important;
        }

        .colored-toast .swal2-timer-progress-bar {
            background: rgba(255, 255, 255, 0.7) !important;
        }
    </style>

    @yield('css')
    @livewireStyles
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg glass-navbar fixed-top">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="me-3" style="width: 45px; height: 45px; border-radius: 50%; object-fit: cover;">
                <a class="navbar-brand" href="{{ route('home') }}">
                    {{-- <i class="fas fa-coins me-2 text-warning"></i> --}}
                    {{ config('app.name') }}
                </a>
            </div>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">
                            <i class="fas fa-home me-2"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('sesiones.listado') }}">
                            <i class="fas fa-play-circle me-2"></i>Sesiones
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('participantes.index') }}">
                            <i class="fas fa-users me-2"></i>Participantes
                        </a>
                    </li>
             
                </ul>
                
                <div class="navbar-nav">
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" 
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-2 fs-5"></i>
                            <span>{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end glass-card border-0">
                          
                            <li><hr class="dropdown-divider border-secondary"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-light" 
                                            onclick="return confirm('¿Estás seguro de que deseas cerrar sesión?')">
                                        <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content" style="margin-top: 60px;">
        <div class="container-fluid px-4">
            {{-- <!-- Flash Messages -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('warning'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    {{ session('warning') }}
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('info'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    {{ session('info') }}
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif --}}

            <!-- Page Content -->
            @yield('content')
        </div>
    </main>

    @livewireScripts
    
    <!-- Bootstrap 5.3 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>
    
    <!-- DataTables with Bootstrap 5 -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        const esp = {
            "processing": "Procesando...",
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "emptyTable": "Ningún dato disponible en esta tabla",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "search": "Buscar:",
            "loadingRecords": "Cargando...",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "aria": {
                "sortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sortDescending": ": Activar para ordenar la columna de manera descendente"
            },
            "buttons": {
                "copy": "Copiar",
                "colvis": "Visibilidad",
                "collection": "Colección",
                "colvisRestore": "Restaurar visibilidad",
                "copyKeys": "Presione ctrl o u2318 + C para copiar los datos de la tabla al portapapeles del sistema. <br \/> <br \/> Para cancelar, haga clic en este mensaje o presione escape.",
                "copySuccess": {
                    "1": "Copiada 1 fila al portapapeles",
                    "_": "Copiadas %ds fila al portapapeles"
                },
                "copyTitle": "Copiar al portapapeles",
                "csv": "CSV",
                "excel": "Excel",
                "pageLength": {
                    "-1": "Mostrar todas las filas",
                    "_": "Mostrar %d filas"
                },
                "pdf": "PDF",
                "print": "Imprimir",
                "renameState": "Cambiar nombre",
                "updateState": "Actualizar",
                "createState": "Crear Estado",
                "removeAllStates": "Remover Estados",
                "removeState": "Remover",
                "savedStates": "Estados Guardados",
                "stateRestore": "Estado %d"
            },
            "autoFill": {
                "cancel": "Cancelar",
                "fill": "Rellene todas las celdas con <i>%d<\/i>",
                "fillHorizontal": "Rellenar celdas horizontalmente",
                "fillVertical": "Rellenar celdas verticalmente"
            },
            "decimal": ",",
            "searchBuilder": {
                "add": "Añadir condición",
                "button": {
                    "0": "Constructor de búsqueda",
                    "_": "Constructor de búsqueda (%d)"
                },
                "clearAll": "Borrar todo",
                "condition": "Condición",
                "conditions": {
                    "date": {
                        "before": "Antes",
                        "between": "Entre",
                        "empty": "Vacío",
                        "equals": "Igual a",
                        "notBetween": "No entre",
                        "not": "Diferente de",
                        "after": "Después",
                        "notEmpty": "No Vacío"
                    },
                    "number": {
                        "between": "Entre",
                        "equals": "Igual a",
                        "gt": "Mayor a",
                        "gte": "Mayor o igual a",
                        "lt": "Menor que",
                        "lte": "Menor o igual que",
                        "notBetween": "No entre",
                        "notEmpty": "No vacío",
                        "not": "Diferente de",
                        "empty": "Vacío"
                    },
                    "string": {
                        "contains": "Contiene",
                        "empty": "Vacío",
                        "endsWith": "Termina en",
                        "equals": "Igual a",
                        "startsWith": "Empieza con",
                        "not": "Diferente de",
                        "notContains": "No Contiene",
                        "notStartsWith": "No empieza con",
                        "notEndsWith": "No termina con",
                        "notEmpty": "No Vacío"
                    },
                    "array": {
                        "not": "Diferente de",
                        "equals": "Igual",
                        "empty": "Vacío",
                        "contains": "Contiene",
                        "notEmpty": "No Vacío",
                        "without": "Sin"
                    }
                },
                "data": "Data",
                "deleteTitle": "Eliminar regla de filtrado",
                "leftTitle": "Criterios anulados",
                "logicAnd": "Y",
                "logicOr": "O",
                "rightTitle": "Criterios de sangría",
                "title": {
                    "0": "Constructor de búsqueda",
                    "_": "Constructor de búsqueda (%d)"
                },
                "value": "Valor"
            },
            "searchPanes": {
                "clearMessage": "Borrar todo",
                "collapse": {
                    "0": "Paneles de búsqueda",
                    "_": "Paneles de búsqueda (%d)"
                },
                "count": "{total}",
                "countFiltered": "{shown} ({total})",
                "emptyPanes": "Sin paneles de búsqueda",
                "loadMessage": "Cargando paneles de búsqueda",
                "title": "Filtros Activos - %d",
                "showMessage": "Mostrar Todo",
                "collapseMessage": "Colapsar Todo"
            },
            "select": {
                "cells": {
                    "1": "1 celda seleccionada",
                    "_": "%d celdas seleccionadas"
                },
                "columns": {
                    "1": "1 columna seleccionada",
                    "_": "%d columnas seleccionadas"
                },
                "rows": {
                    "1": "1 fila seleccionada",
                    "_": "%d filas seleccionadas"
                }
            },
            "thousands": ".",
            "datetime": {
                "previous": "Anterior",
                "hours": "Horas",
                "minutes": "Minutos",
                "seconds": "Segundos",
                "unknown": "-",
                "amPm": [
                    "AM",
                    "PM"
                ],
                "months": {
                    "0": "Enero",
                    "1": "Febrero",
                    "10": "Noviembre",
                    "11": "Diciembre",
                    "2": "Marzo",
                    "3": "Abril",
                    "4": "Mayo",
                    "5": "Junio",
                    "6": "Julio",
                    "7": "Agosto",
                    "8": "Septiembre",
                    "9": "Octubre"
                },
                "weekdays": {
                    "0": "Dom",
                    "1": "Lun",
                    "2": "Mar",
                    "4": "Jue",
                    "5": "Vie",
                    "3": "Mié",
                    "6": "Sáb"
                },
                "next": "Próximo"
            },
            "editor": {
                "close": "Cerrar",
                "create": {
                    "button": "Nuevo",
                    "title": "Crear Nuevo Registro",
                    "submit": "Crear"
                },
                "edit": {
                    "button": "Editar",
                    "title": "Editar Registro",
                    "submit": "Actualizar"
                },
                "remove": {
                    "button": "Eliminar",
                    "title": "Eliminar Registro",
                    "submit": "Eliminar",
                    "confirm": {
                        "_": "¿Está seguro de que desea eliminar %d filas?",
                        "1": "¿Está seguro de que desea eliminar 1 fila?"
                    }
                },
                "error": {
                    "system": "Ha ocurrido un error en el sistema (<a target=\"\\\" rel=\"\\ nofollow\" href=\"\\\">Más información&lt;\\\/a&gt;).<\/a>"
                },
                "multi": {
                    "title": "Múltiples Valores",
                    "restore": "Deshacer Cambios",
                    "noMulti": "Este registro puede ser editado individualmente, pero no como parte de un grupo.",
                    "info": "Los elementos seleccionados contienen diferentes valores para este registro. Para editar y establecer todos los elementos de este registro con el mismo valor, haga clic o pulse aquí, de lo contrario conservarán sus valores individuales."
                }
            },
            "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
            "stateRestore": {
                "creationModal": {
                    "button": "Crear",
                    "name": "Nombre:",
                    "order": "Clasificación",
                    "paging": "Paginación",
                    "select": "Seleccionar",
                    "columns": {
                        "search": "Búsqueda de Columna",
                        "visible": "Visibilidad de Columna"
                    },
                    "title": "Crear Nuevo Estado",
                    "toggleLabel": "Incluir:",
                    "scroller": "Posición de desplazamiento",
                    "search": "Búsqueda",
                    "searchBuilder": "Búsqueda avanzada"
                },
                "removeJoiner": "y",
                "removeSubmit": "Eliminar",
                "renameButton": "Cambiar Nombre",
                "duplicateError": "Ya existe un Estado con este nombre.",
                "emptyStates": "No hay Estados guardados",
                "removeTitle": "Remover Estado",
                "renameTitle": "Cambiar Nombre Estado",
                "emptyError": "El nombre no puede estar vacío.",
                "removeConfirm": "¿Seguro que quiere eliminar %s?",
                "removeError": "Error al eliminar el Estado",
                "renameLabel": "Nuevo nombre para %s:"
            },
            "infoThousands": "."
        };

        $('.dataTable').DataTable({
            "destroy": true,
            order: [[0, 'desc']],
            language: esp,
        });
        $('.dataTableAsc').DataTable({
            "destroy": true,            
            language: esp,
        });
    </script>
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: '{{ session('success') }}',
                confirmButtonText: 'OK'
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                confirmButtonText: 'OK'
            });
        @endif
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const Toast = Swal.mixin({
                toast: true,
                position: 'bottom-end', // o 'center' si preferís
                iconColor: 'white',
                customClass: {
                    popup: 'colored-toast',
                },
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });

            // ✅ Éxito
            Livewire.on('success', msg => {
                Toast.fire({
                    icon: 'success',
                    title: msg || 'Operación exitosa',
                });
            });

            // ❌ Error
            Livewire.on('error', msg => {
                Toast.fire({
                    icon: 'error',
                    title: msg || 'Ocurrió un error',
                });
            });

            // ℹ️ Información / Alerta
            Livewire.on('info', msg => {
                Toast.fire({
                    icon: 'info',
                    title: msg || 'Información importante',
                });
            });

        });
    </script>


    <script>
        $('.delete').submit(function(e) {
            Swal.fire({
                title: 'Eliminar el Registro de la BD',
                text: "¿Está seguro de realizar esta operación?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, continuar!',
                cancelButtonText: 'No, cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            })
        });

        $('.anular').submit(function(e) {
            Swal.fire({
                title: 'Anular Venta',
                text: "¿Está seguro de realizar esta operación?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, continuar!',
                cancelButtonText: 'No, cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            })
        });

        $('.reset').submit(function(e) {
            Swal.fire({
                title: 'RESET PASSWORD',
                text: "¿Está seguro de realizar esta operación?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, continuar!',
                cancelButtonText: 'No, cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            })
        });
    </script>

    @yield('js')

    <!-- PWA Service Worker Registration -->
    <script>
        // Registrar Service Worker para PWA
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js', {
                    scope: '/'
                })
                .then(function(registration) {
                    console.log('Service Worker registrado con éxito:', registration.scope);
                    
                    // Verificar actualizaciones
                    registration.addEventListener('updatefound', () => {
                        console.log('Service Worker: Nueva versión disponible');
                        const newWorker = registration.installing;
                        newWorker.addEventListener('statechange', () => {
                            if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                                console.log('Service Worker: Actualización lista');
                            }
                        });
                    });

                    // Función global para limpiar cache PWA
                    window.clearPWACache = function() {
                        if ('serviceWorker' in navigator && navigator.serviceWorker.controller) {
                            const messageChannel = new MessageChannel();
                            messageChannel.port1.onmessage = function(event) {
                                if (event.data.success) {
                                    console.log('Cache PWA limpiado exitosamente');
                                    window.location.reload();
                                }
                            };
                            navigator.serviceWorker.controller.postMessage(
                                {type: 'CLEAR_CACHE'}, 
                                [messageChannel.port2]
                            );
                        } else {
                            // Fallback: limpiar storage del navegador
                            if ('caches' in window) {
                                caches.keys().then(names => {
                                    names.forEach(name => caches.delete(name));
                                }).then(() => {
                                    console.log('Cache limpiado manualmente');
                                    window.location.reload();
                                });
                            }
                        }
                    };
                })
                .catch(function(error) {
                    console.error('Error al registrar Service Worker:', error);
                });
            });
        }


    </script>
</body>

</html>
