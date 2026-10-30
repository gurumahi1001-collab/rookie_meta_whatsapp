@extends('layouts/layoutMaster')

@section('title', 'Manage Candidate')

@section('vendor-style')
@vite([
'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
'resources/assets/vendor/libs/select2/select2.scss',
'resources/assets/vendor/libs/flatpickr/flatpickr.scss',
'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.scss'
])
@endsection

@section('vendor-script')
@vite([
'resources/assets/vendor/libs/select2/select2.js',
'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js',
'resources/assets/vendor/libs/flatpickr/flatpickr.js',
])
@endsection
@section('page-script')
@vite(['resources/assets/js/form_wizard_icons.js'])
@vite('resources/assets/js/forms-file-upload.js')
@vite('resources/assets/js/forms-pickers.js')
@vite(['resources/assets/js/forms_date_time_pickers.js'])

@endsection

@section('content')


<!-- Roles -->
 <style>
    #manageRolesModal .modal-content {
        border: 0;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 24px 80px rgba(15, 23, 42, .18);
    }

    #manageRolesModal .modal-header {
        
        color: #fff;
        padding: 20px 24px;
    }

    #manageRolesModal .modal-title {
        font-weight: 700;
        letter-spacing: -.02em;
    }

    #manageRolesModal .modal-subtitle {
        /* color: rgba(255, 255, 255, .68); */
        font-size: .83rem;
    }

    #manageRolesModal .btn-close {
        /* filter: invert(1) grayscale(1) brightness(2); */
        /* opacity: .85; */
    }

    .role-stat-card {
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        background: #fff;
        padding: 14px 16px;
        height: 100%;
        transition: transform .15s ease, box-shadow .15s ease;
    }

    .role-stat-card:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 24px rgba(15, 23, 42, .06);
    }

    .role-stat-label {
        color: #64748b;
        font-size: .75rem;
        text-transform: uppercase;
        letter-spacing: .07em;
        font-weight: 700;
    }

    .role-stat-value {
        font-size: 1.55rem;
        line-height: 1.1;
        font-weight: 800;
        color: #0f172a;
        margin-top: 4px;
    }

    .role-toolbar {
        /* background: #f8fafc;
        border: 1px solid #e2e8f0; */
        border-radius: 14px;
        padding: 12px;
    }

    .role-toolbar .form-control,
    .role-toolbar .form-select,
    #roleForm .form-control,
    #roleForm .form-select {
        min-height: 42px;
        border-color: #cbd5e1;
        border-radius: 10px;
    }

    #manageRolesModal .table-wrap {
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        overflow: hidden;
        background: #fff;
    }

    #manageRolesModal .table {
        margin-bottom: 0;
    }

    #manageRolesModal .table thead th {
        /* background: #f8fafc; */
        border-bottom: 1px solid #e2e8f0;
        /* color: #475569; */
        font-size: .72rem;
        text-transform: uppercase;
        letter-spacing: .06em;
        white-space: nowrap;
        font-weight: 800;
    }

    #manageRolesModal .table tbody td {
        vertical-align: middle;
        border-color: #eef2f7;
        color: #334155;
    }

    .role-code {
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
        font-size: .68rem;
        color: #64748b;
        word-break: break-word;
    }

    .role-name-text {
        color: #0f172a;
        font-weight: 700;
    }

    .role-description {
        max-width: 250px;
        color: #64748b;
        font-size: .78rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .role-chip {
        display: inline-flex;
        align-items: center;
        padding: 4px 9px;
        border-radius: 999px;
        font-size: .7rem;
        font-weight: 700;
        background: #f1f5f9;
        color: #334155;
        white-space: nowrap;
    }

    .role-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 9px;
        border-radius: 999px;
        font-size: .7rem;
        font-weight: 800;
        white-space: nowrap;
    }

    .role-status-badge::before {
        content: '';
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: currentColor;
    }

    .role-status-active { background: #ecfdf5; color: #047857; }
    .role-status-inactive { background: #fff7ed; color: #c2410c; }
    .role-status-deleted { background: #fef2f2; color: #b91c1c; }

    .role-match-badge {
        font-size: .68rem;
        padding: 4px 8px;
        border-radius: 7px;
        font-weight: 700;
    }

    .role-match-on { background: #eff6ff; color: #1d4ed8; }
    .role-match-off { background: #f1f5f9; color: #64748b; }

    .role-actions .btn {
        width: 34px;
        height: 34px;
        border-radius: 9px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .role-empty-state {
        padding: 50px 20px;
        text-align: center;
        color: #64748b;
    }

    .role-loading {
        padding: 50px 20px;
        text-align: center;
        color: #64748b;
    }

    .role-form-panel {
        border: 1px solid #dbeafe;
        background: linear-gradient(180deg, #f8fbff 0%, #ffffff 100%);
        border-radius: 14px;
        padding: 16px;
        display: none;
        margin-bottom: 14px;
    }

    .role-form-panel.is-open {
        display: block;
        animation: rolePanelIn .16s ease-out;
    }

    @keyframes rolePanelIn {
        from { opacity: 0; transform: translateY(-4px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .role-form-label {
        font-size: .76rem;
        font-weight: 800;
        color: #334155;
        margin-bottom: 6px;
    }

    .role-form-help {
        color: #64748b;
        font-size: .7rem;
        margin-top: 5px;
    }

    .role-switch .form-check-input {
        width: 2.5em;
        height: 1.35em;
        cursor: pointer;
    }

    #roleToast {
        z-index: 1090;
    }

    @media (max-width: 767.98px) {
        #manageRolesModal .modal-dialog {
            margin: .5rem;
        }

        #manageRolesModal .modal-header,
        #manageRolesModal .modal-body {
            padding-left: 14px;
            padding-right: 14px;
        }

        .role-toolbar .row > div {
            margin-bottom: 8px;
        }
    }
</style>

<style>
    .recurring-status-badge.lifetime {
        background: #ede9fe;
        color: #6d28d9;
    }

    .recurring-row.status-lifetime {
        background: linear-gradient(
            90deg,
            rgba(124,58,237,.2),
            transparent 45%
        );
    }

    .recurring-row .statusbar-lifetime {
        background: #7c3aed;
    }
    .candidate-history-timeline{
        position:relative;
        padding-left:40px;
    }

    .history-item{
        position:relative;
        margin-bottom:20px;
    }

    .history-line{
        position:absolute;
        left:-23px;
        top:35px;
        width:2px;
        height:100%;
        background:#e5e7eb;
    }

    .history-item:last-child .history-line{
        display:none;
    }

    .history-dot{
        position:absolute;
        left:-38px;
        top:15px;
        width:30px;
        height:30px;
        border-radius:50%;
        color:#fff;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:12px;
        font-weight:700;
        box-shadow:0 4px 10px rgba(0,0,0,.15);
    }

    .history-card{
        background:#fff;
        border-radius:12px;
        padding:16px;
        border:1px solid #eef2f7;
        box-shadow:0 3px 10px rgba(0,0,0,.05);
        transition:.2s;
    }

    .history-card:hover{
        transform:translateY(-2px);
        box-shadow:0 8px 18px rgba(0,0,0,.08);
    }

    .history-remarks{
        background:#f8fafc;
        border-left:4px solid #f59e0b;
        padding:12px;
        border-radius:8px;
        margin-top:12px;
    }
</style>
<style>
    .modal-title-ai {
        font-weight: 700;
        letter-spacing: 0.5px;
    }

    .ai-subtitle {
        font-size: 13px;
        color: #6c757d;
    }

    .ai-loading {
        height: 150px;
        background: linear-gradient(90deg, #eee, #f5f5f5, #eee);
        animation: shimmer 1.5s infinite;
    }

    @keyframes shimmer {
        0% {
            background-position: -200px 0;
        }

        100% {
            background-position: 200px 0;
        }
    }

    .dataTables_scroll {
        max-height: 200px;
    }

    .floating-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        /* animation: floatBounce 2.5s ease-in-out infinite; */
    }

    /*
    @keyframes floatBounce {
        0%   { transform: translateY(0px); }
        50%  { transform: translateY(-8px); }
        100% { transform: translateY(0px); }
    } */

    .bg-label-ug {
        background-color: #E8F1FF;
        color: #ab2b22;
    }

    .bg-label-pg {
        background-color: #E6F7EE;
        color: #198754;
    }

    .bg-label-doctorate {
        background-color: #F3E8FF;
        color: #6F42C1;
    }

    .bg-label-hsc {
        background-color: #E7F9FF;
        color: #0DCaf0;
    }

    .bg-label-sslc {
        background-color: #FFF4E5;
        color: #FF8C00;
    }

    .bg-label-below-sslc {
        background-color: #FFECEC;
        color: #DC3545;
    }

    .bg-label-others {
        background-color: #F1F3F5;
        color: #6C757D;
    }

    
    /* ADD CANDIDATE - UPLOADED RESUME VIEWER */
    .resume-file-viewer-trigger {
        display: none;
        align-items: center;
        gap: 6px;
        margin-top: 8px;
        padding: 7px 10px;
        border: 1px solid #e2e8f0;
        border-radius: 9px;
        background: #fff;
        color: #ab2b22;
        font-size: 12px;
        font-weight: 700;
        line-height: 1;
        transition: all .2s ease;
        box-shadow: 0 2px 7px rgba(15, 23, 42, .05);
    }

    .resume-file-viewer-trigger:hover {
        color: #fff;
        background: #ab2b22;
        border-color: #ab2b22;
        transform: translateY(-1px);
        box-shadow: 0 6px 14px rgba(171, 43, 34, .18);
    }

    .resume-file-viewer-trigger.is-visible {
        display: inline-flex;
    }

    .resume-file-viewer-card {
        border: 1px solid #e9edf3;
        border-radius: 14px;
        overflow: hidden;
        background: #f8fafc;
    }

    .resume-file-viewer-toolbar {
        min-height: 58px;
        padding: 10px 14px;
        background: #fff;
        border-bottom: 1px solid #e9edf3;
    }

    .resume-file-viewer-meta {
        min-width: 0;
    }

    .resume-file-viewer-name {
        display: block;
        max-width: min(58vw, 760px);
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-size: 13px;
        font-weight: 700;
        color: #1f2937;
    }

    .resume-file-viewer-info {
        font-size: 11px;
        color: #8a93a3;
    }

    .resume-file-viewer-stage {
        position: relative;
        min-height: 72vh;
        max-height: calc(100vh - 170px);
        overflow: auto;
        background:
            linear-gradient(45deg, #f1f5f9 25%, transparent 25%),
            linear-gradient(-45deg, #f1f5f9 25%, transparent 25%),
            linear-gradient(45deg, transparent 75%, #f1f5f9 75%),
            linear-gradient(-45deg, transparent 75%, #f1f5f9 75%);
        background-size: 22px 22px;
        background-position: 0 0, 0 11px, 11px -11px, -11px 0;
    }

    .resume-file-viewer-frame {
        width: 100%;
        height: 72vh;
        min-height: 520px;
        border: 0;
        display: none;
        background: #fff;
    }

    /* DOCX preview rendered locally in the modal (resume data is not sent to an online viewer). */
    #resumeFileViewerDocxWrap {
        display: none;
        min-height: 72vh;
        max-height: calc(100vh - 170px);
        overflow: auto;
        padding: 28px 18px;
        background: #eef2f7;
    }
    #resumeFileViewerDocxContent {
        width: min(850px, 100%);
        min-height: 900px;
        margin: 0 auto;
        padding: 54px 62px;
        background: #fff;
        color: #202938;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 14px;
        line-height: 1.7;
        overflow-wrap: anywhere;
        box-shadow: 0 8px 32px rgba(15,23,42,.12);
        border: 1px solid #e1e7ef;
    }
    #resumeFileViewerDocxContent h1, #resumeFileViewerDocxContent h2,
    #resumeFileViewerDocxContent h3, #resumeFileViewerDocxContent h4 {
        color: #172033; margin: 1.1em 0 .45em; font-weight: 700;
    }
    #resumeFileViewerDocxContent p { margin: 0 0 .75em; }
    #resumeFileViewerDocxContent ul, #resumeFileViewerDocxContent ol { padding-left: 1.6rem; }
    #resumeFileViewerDocxContent table { width: 100%; border-collapse: collapse; margin: 1rem 0; }
    #resumeFileViewerDocxContent td, #resumeFileViewerDocxContent th { border: 1px solid #d8dee8; padding: 6px 8px; vertical-align: top; }
    #resumeFileViewerDocxContent img { max-width: 100%; height: auto; }
    #resumeFileViewerDocxLoading { display: none; padding: 22px; text-align: center; color: #64748b; }
    @media (max-width: 767.98px) {
        #resumeFileViewerDocxWrap { padding: 10px; }
        #resumeFileViewerDocxContent { min-height: 70vh; padding: 24px 20px; font-size: 13px; }
    }

    .resume-file-viewer-image-wrap {
        display: none;
        min-height: 72vh;
        padding: 28px;
        align-items: flex-start;
        justify-content: center;
    }

    .resume-file-viewer-image {
        max-width: min(100%, 1200px);
        height: auto;
        transform: scale(1);
        transform-origin: top center;
        transition: transform .18s ease;
        border-radius: 10px;
        background: #fff;
        box-shadow: 0 14px 40px rgba(15, 23, 42, .14);
        user-select: none;
        -webkit-user-drag: none;
    }

    .resume-file-viewer-empty {
        display: none;
        min-height: 56vh;
        padding: 40px 20px;
        align-items: center;
        justify-content: center;
    }

    .resume-file-viewer-empty-inner {
        width: min(520px, 100%);
        padding: 28px;
        text-align: center;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 10px 35px rgba(15, 23, 42, .06);
    }

    .resume-file-viewer-empty-icon {
        width: 64px;
        height: 64px;
        margin: 0 auto 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 18px;
        background: #fef2f2;
        color: #ab2b22;
        font-size: 30px;
    }

    .resume-file-viewer-control {
        display: none;
    }

    #resumeFileViewerModal .modal-dialog {
        width: min(1400px, calc(100vw - 30px));
        max-width: none;
        margin: 15px auto;
    }

    #resumeFileViewerModal .modal-content {
        overflow: hidden;
        border: 0;
        border-radius: 18px;
        box-shadow: 0 24px 80px rgba(15, 23, 42, .24);
    }

    #resumeFileViewerModal .modal-header {
        background: #fff;
        border-bottom: 1px solid #eef2f7;
    }

    #resumeFileViewerModal .modal-footer {
        background: #fff;
        border-top: 1px solid #eef2f7;
    }

    @media (max-width: 767.98px) {
        .resume-file-viewer-toolbar {
            align-items: flex-start !important;
        }

        .resume-file-viewer-name {
            max-width: 60vw;
        }

        .resume-file-viewer-stage,
        .resume-file-viewer-image-wrap {
            min-height: 64vh;
        }

        .resume-file-viewer-frame {
            height: 64vh;
            min-height: 420px;
        }

        .resume-file-viewer-image-wrap {
            padding: 14px;
        }

        #resumeFileViewerModal .modal-dialog {
            width: calc(100vw - 10px);
            margin: 5px auto;
        }
    }
    
</style>
<style>
      #download_qr_code_name {
            overflow-x: auto;       /* enable horizontal scroll */
            overflow-y: hidden;     /* optional: hide vertical scroll */
            white-space: nowrap;    /* keep content in one line if needed */

            /* Hide scrollbar - Firefox */
            scrollbar-width: none;

            /* Hide scrollbar - IE & Edge */
            -ms-overflow-style: none;
        }

        /* Hide scrollbar - Chrome, Safari */
        #download_qr_code_name::-webkit-scrollbar {
            display: none;
        }
</style>
<style>
    /* QR Card */
        .qr-card {
            width:350px;
        background: #ffffff;
        border-radius: 14px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        transition: transform 0.3s ease;
        }

        .qr-card:hover {
        transform: translateY(-4px);
        }

        /* QR Image */
        /*.qr-image {*/
        /*  width: 220px;*/
        /*  height: 220px;*/
        /*  border-radius: 12px;*/
        /*  padding: 10px;*/
        /*  background: #f8f9fa;*/
        /*  border: 1px solid #e9ecef;*/
        /*}*/

        .qr-image {
            width: 140px;
            height: 140px;
            /* border-radius: 12px; */
            position: absolute;
            top: 24.5%;
            left: 28%;
            padding: 0px;
            /* background: #f8f9fa; */
            /* border: 1px solid #e9ecef; */
        }

        /* Modal animation */
        .modal.fade .modal-dialog {
        transform: scale(0.95);
        transition: transform 0.3s ease;
        }

        .modal.show .modal-dialog {
        transform: scale(1);
        }

</style>
<style>
    .mini-card {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px;
        border-radius: 12px;
        background: #ffffff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        transition: 0.3s;
        cursor: pointer;
    }

    .mini-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.15);
    }

    .mini-icon {
        width: 45px;
        height: 45px;
        object-fit: contain;
    }

    .mini-content h5 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
    }

    .mini-content span {
        font-size: 13px;
        color: #666;
    }

    /* Color Variants */
    .mini-card.primaryegc {
        border-left: 4px solid #ab2b22;
    }

    .mini-card.success {
        border-left: 4px solid #28c76f;
    }

    .mini-card.danger {
        border-left: 4px solid #ea5455;
    }

    .mini-card.walkincolor {
        border-left: 4px solid #182B46;
    }
    .mini-card.vipcandidatecolor {
        border-left: 4px solid #FFB80F;
    }

    .active-dashboard-filter{
        transform: translateY(-3px);
        border: 2px solid #f59e0b !important;
        box-shadow: 0 10px 25px rgba(245,158,11,.35);
        position: relative;
    }

    .active-dashboard-filter::after{
        content:'';
        position:absolute;
        top:8px;
        right:8px;
        width:10px;
        height:10px;
        background:#22c55e;
        border-radius:50%;
    }

    .mini-card.warning {
        border-left: 4px solid #ff9f43;
    }

    .mini-card.info {
        border-left: 4px solid #00cfe8;
    }

    .mini-card.primary {
        border-left: 4px solid #7367f0;
    }
</style>

<style>
    .vip-profile-card{
    background:#fff;
    border-radius:16px;
    padding:25px;
    box-shadow:0 3px 20px rgba(0,0,0,.08);
}

.vip-avatar{
    width:90px;
    height:90px;
    border-radius:50%;
    background:linear-gradient(
        135deg,
        #f59e0b,
        #f97316
    );
    color:#fff;
    font-size:36px;
    font-weight:700;
    display:flex;
    align-items:center;
    justify-content:center;
}

.vip-section{
    background:#fff;
    border-radius:12px;
    padding:20px;
    border:1px solid #eee;
}

.vip-remark-box{
    border-radius:12px;
    min-height:120px;
}
</style>
<style>
    .history-profile-card{
    background:#fff;
    border-radius:16px;
    padding:25px;
    box-shadow:0 3px 20px rgba(0,0,0,.08);
}

.history-avatar{
    width:90px;
    height:90px;
    border-radius:50%;
    background:linear-gradient(
        135deg,
        #f59e0b,
        #f97316
    );
    color:#fff;
    font-size:36px;
    font-weight:700;
    display:flex;
    align-items:center;
    justify-content:center;
}

.history-section{
    background:#fff;
    border-radius:12px;
    padding:20px;
    border:1px solid #eee;
}

.history-remark-box{
    border-radius:12px;
    min-height:120px;
}
</style>
@php

$helper = new \App\Helpers\Helpers();
$common_date_format = $helper->general_setting_data()->date_format ?? 'd-M-y';
$user_id = auth()->user()->user_id ;
$role_id = auth()->user()->role_id ;
$auth_id = auth()->user()->id ;
$canUseAtsRoleMatching = in_array($role_id, [1], true);
@endphp
<!-- Lead List Table -->
<div class="card card-action">
    <div class="card-header border-bottom pb-0 mb-0 d-flex align-items-center justify-content-between">
        <div class="d-flex flex-column align-items-start">
            <h5 class="card-title mb-1 text-black">Manage Candidate</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb custom-breadcrumb">
                    <!-- Home -->
                    <li class="breadcrumb-item">
                        <a href="{{ url('/dashboard') }}">
                            <i class="mdi mdi-home"></i> Home
                        </a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">
                        <a href="javascript:void(0);">
                            <i class="mdi mdi-account-group"></i> HR Management
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <a href="javascript:void(0);" class="active-link">
                            HR Recruitment
                        </a>
                    </li>
                </ol>
            </nav>
        </div>
        <div class="d-flex justify-content-end align-items-center mb-2 gap-2">
            <span class="cursor-pointer" data-bs-toggle="tooltip" data-bs-placement="bottom"
                title="Daily Check In QR Code">
                <a href="javascript:;" class="btn btn-sm fw-semibold btn-primary text-white generate-qr-btn" data-bs-toggle="modal" data-bs-target="#kt_modal_qr_generate" onclick="generateQr()">
                    <span>
                        <i class="mdi mdi-qrcode-scan fs-3 "></i>
                    </span>
                </a>

            </span>
            <a href="javascript:;" class="btn btn-sm fw-bold btn-primary text-white" id="branch_filter">
                <span><i class="mdi mdi-filter-outline" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Filter"></i></span>
            </a>
            <!--<a href="javascript:;" class="btn btn-sm fw-bold btn-primary text-white" data-bs-toggle="modal" data-bs-target="#kt_modal_create_candidate">-->
            <!--    <span class="me-2"><i class="mdi mdi-plus"></i></span>Add Candidate-->
            <!--</a>-->
          
            @if($role_id == 1 || $role_id == 2)
            <a href="javascript:;" class="btn btn-sm fw-bold btn-primary text-white" data-bs-toggle="modal" data-bs-target="#manageRolesModal" id="openManageRolesBtn">
                <span class="me-2"><i class="mdi mdi-tune-vertical"></i></span><span>Manage Roles</span>
            </a>
            @endif
            <a href="javascript:;" class="btn btn-sm fw-bold btn-primary text-white" data-bs-toggle="modal" data-bs-target="#kt_modal_add_paticipants">
                <span class="me-2"><i class="mdi mdi-plus"></i></span>Add Candidate
            </a>
            @if($canUseAtsRoleMatching)
            <button
                type="button"
                class="btn btn-primary"
                onclick="openBulkAiMatchingModal()"
                data-bs-toggle="tooltip"
                data-bs-placement="bottom"
                title="Run protected bulk ATS role matching">
                <i class="mdi mdi-robot-outline me-1"></i>
                Bulk AI Role Matching
            </button>
            @endif
        </div>
    </div>
    <div class="card-body">
        <div class="branch_filter mb-4" style="display: none;">
            <div class="row py-1">
                <div class="col-lg-3 mb-2">
                    <label class="text-dark mb-1 fs-6 fw-semibold">Keywords</label>
                    <input
                        type="text"
                        class="form-control"
                        id="resume_keywords_filt"
                        name="resume_keywords_filt"
                        placeholder="Type keywords and press Enter"
                        autocomplete="off"
                    />
                </div>
                <div class="col-lg-3 mb-2">
                    <label class="text-dark mb-1 fs-6 fw-semibold">Job Role</label>
                    <input type="text" class="form-control" id="job_role_fill" name="job_role_fill" placeholder="Enter Job Role" value="" oninput="this.value = this.value.replace(/^\w/, function(txt) { return txt.toUpperCase(); });" />
                </div>
                <div class="col-lg-3 mb-2">
                    <label class="text-dark mb-1 fs-6 fw-semibold">Type</label>
                    <select id="source_type_filt" name="source_type_filt" class="select3 form-select">
                        <option value="">All</option>
                        <option value="job_fair">Job Fair</option>
                        <option value="old_data">Recruiter Database</option>
                        <option value="resource">Resource Request</option>
                    </select>
                </div>
                <div class="col-lg-3 mb-2">
                    <label class="text-dark mb-1 fs-6 fw-semibold">Qualification</label>
                    <select id="qualification_filt" name="qualification_filt" class="select3 form-select" onchange="qualification_filter_change()">
                        <option value="">All</option>
                        <option value="4">HSC</option>
                        <option value="5">SSLC</option>
                        <option value="6">Below SSLC</option>
                        <option value="1">UG</option>
                        <option value="2">PG</option>
                        <option value="3">Doctorate</option>
                        <option value="Others">Others</option>
                    </select>
                </div>
                <div class="col-lg-3 mb-2">
                    <label class="text-dark mb-1 fs-6 fw-semibold">Major</label>
                    <select id="major_filt" name="major_filt" class="select3 form-select">
                        <option value="">All</option>

                    </select>
                </div>
                <div class="col-lg-3 mb-2">
                    <label class="text-dark mb-1 fs-6 fw-semibold">Experience</label>
                    <select id="exp_type_filt" name="exp_type_filt" class="select3 form-select">
                        <option value="">All</option>
                        <option value="1">Fresher</option>
                        <option value="2">Experience</option>
                    </select>
                </div>

                @if($user_id==0)
                <div class="col-lg-3 mb-2">
                    <label class="text-dark mb-1 fs-6 fw-semibold">Old Resume</label>
                    <select class="select3 form-select" name="old_resume_fill" id="old_resume_fill">
                        <option value="">All</option>
                        <option value="1">Import</option>
                        <option value="0">Not Import</option>
                    </select>
                </div>
                @endif

                <div class="col-lg-3 mb-2" id="">
                    <label class="text-dark mb-1 fs-6 fw-semibold">Status</label>
                    <select id="applicant_status_filt"  class="form-select select3">
                        <option value="">Select Status</option>
                        <option value="Selected">Selected</option>
                        <option value="Rejected">Rejected</option>
                        <option value="On Hold">On Hold</option>
                        <option value="Critical">Critical</option>
                        <option value="Not Joined">Not Joined</option>
                    </select>
                </div>

                

                <div class="col-lg-3 mb-2" id="">
                    <label class="text-dark mb-1 fs-6 fw-semibold">Source</label>
                    <select id="source_name_filt" name="source_name_filt" class="select3 form-select">
                        <option value="">All Source</option>
                        @if(isset($source_list))
                        @foreach($source_list as $source)
                        <option value="{{ $source->sno }}">{{ $source->source_name }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-lg-3 mb-2" id="">
                    <label class="text-dark mb-1 fs-6 fw-semibold">Applied Date</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="mdi mdi-calendar-month-outline fs-4"></i></span>
                        <input type="text" id="closing_date_filt" name="closing_date_filt" placeholder="Select Date" class="form-control common_datepicker" value="" />
                    </div>
                </div>
                <div class="col-lg-3 mb-2">
                    <label class="text-dark mb-1 fs-6 fw-semibold">Date</label>
                    <select class="form-select select3 " name="dt_fill_issue_rpt" id="dt_fill_issue_rpt" onchange="date_fill_issue_rpt();">
                        <option value="all">All</option>
                        <option value="today">Today</option>
                        <option value="week">This Week</option>
                        <option value="monthly">This Month</option>
                        <option value="custom_date">Custom Date</option>
                    </select>
                </div>
                <div class="col-lg-3 mb-2" id="today_dt_iss_rpt" style="display: none;">
                    <label class="text-dark mb-1 fs-6 fw-semibold">Today</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text bg-gray-200"><i class="mdi mdi-calendar-month-outline fs-4"></i></span>
                        <input type="text" id="cus_today_dt_fill" placeholder="Select Date" class="form-control" value="<?php echo date("d-M-Y"); ?>" disabled />
                    </div>
                </div>
                <div class="col-lg-3 mb-2" id="week_from_dt_iss_rpt" style="display: none;">
                    <label class="text-dark mb-1 fs-6 fw-semibold">Start Date</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text bg-gray-200"><i class="mdi mdi-calendar-month-outline fs-4"></i></span>
                        <input type="text" id="cus_week_st_dt_fill" placeholder="Select Date" class="form-control" value="<?php echo date("d-M-Y"); ?>" disabled />
                    </div>
                </div>
                <div class="col-lg-3 mb-2" id="week_to_dt_iss_rpt" style="display: none;">
                    <label class="text-dark mb-1 fs-6 fw-semibold">End Date</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text bg-gray-200"><i class="mdi mdi-calendar-month-outline fs-4"></i></span>
                        <input type="text" id="cus_week_ed_dt_fill" placeholder="Select Date" class="form-control" value="<?php echo date("d-M-Y"); ?>" disabled />
                    </div>
                </div>
                <div class="col-lg-3 mb-2" id="monthly_dt_iss_rpt" style="display: none;">
                    <label class="text-dark mb-1 fs-6 fw-semibold">This Month</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="mdi mdi-calendar-month-outline fs-4"></i></span>
                        <input type="text" id="cus_this_month_dt_fill" placeholder="Select Date" class="form-control this_month_dt_fill" value="<?php echo date("M-Y"); ?>" />
                    </div>
                </div>
                <div class="col-lg-3 mb-2" id="from_dt_iss_rpt" style="display: none;">
                    <label class="text-dark mb-1 fs-6 fw-semibold">From Date</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="mdi mdi-calendar-month-outline fs-4"></i></span>
                        <input type="text" id="cus_custom_from_dt_fill" placeholder="Select Date" class="form-control common_datepicker" value="<?php echo date("d-M-Y"); ?>" />
                    </div>
                </div>
                <div class="col-lg-3 mb-2" id="to_dt_iss_rpt" style="display: none;">
                    <label class="text-dark mb-1 fs-6 fw-semibold">To Date</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="mdi mdi-calendar-month-outline fs-4"></i></span>
                        <input type="text" id="cus_custom_to_dt_fill" placeholder="Select Date" class="form-control common_datepicker" value="<?php echo date("d-M-Y"); ?>" />
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-sm btn-primary fw-semibold fs-6 me-2" class="filterSubmit" id="filterSubmit">Go</button>
                <a href="{{ url('/hr_recruitment/manage_candidate') }}" class="btn btn-sm btn-secondary fw-semibold fs-6">Reset</a>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-3">
                <div class="mini-card primaryegc" onclick="clearDashboardFilter()">
                    <img src="{{asset('assets/egc_images/magic_menu/candidate.png')}}" class="mini-icon">
                    <div class="mini-content">
                        <h5 id="total_candidates">00</h5>
                        <span class="text-nowrap">Total Candidates</span>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-3">
                <div class="mini-card info dashboard-filter" onclick="applyDashboardFilter('today', this)">
                    <img src="{{asset('assets/egc_images/magic_menu/new_badge.png')}}" class="mini-icon">
                    <div class="mini-content">
                        <h5 id="today_candidates">00</h5>
                        <span class="text-nowrap">Today Applied</span>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-3">
                <div class="mini-card success dashboard-filter" onclick="applyDashboardFilter('month', this)">
                    <img src="{{asset('assets/egc_images/magic_menu/star_employee.png')}}" class="mini-icon">
                    <div class="mini-content">
                        <h5 id="month_candidates">00</h5>
                        <span class="text-nowrap">This Month</span>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-3">
                <div class="mini-card primary dashboard-filter" onclick="applyDashboardFilter('fresher', this)">
                    <img src="{{asset('assets/egc_images/magic_menu/newbie.png')}}" class="mini-icon">
                    <div class="mini-content">
                        <h5 id="fresher_count">00</h5>
                        <span class="text-nowrap">Freshers</span>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-3">
                <div class="mini-card warning dashboard-filter" onclick="applyDashboardFilter('experienced', this)">
                    <img src="{{asset('assets/egc_images/magic_menu/experience.png')}}" class="mini-icon">
                    <div class="mini-content">
                        <h5 id="experienced_count">00</h5>
                        <span class="text-nowrap">Experienced</span>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-3" >
                <div class="mini-card danger dashboard-filter" onclick="applyDashboardFilter('jobfair', this)">
                    <img src="{{asset('assets/egc_images/magic_menu/job_fair.png')}}" class="mini-icon">
                    <div class="mini-content">
                        <h5 id="job_fair_count">00</h5>
                        <span class="text-nowrap">Job Fair</span>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-3">
                <div class="mini-card walkincolor dashboard-filter" onclick="applyDashboardFilter('walkin', this)">
                    <img src="{{asset('assets/egc_images/magic_menu/walkinacandidate.png')}}" class="mini-icon">
                    <div class="mini-content">
                        <h5 id="walkin_candidates">00</h5>
                        <span class="text-nowrap">Walk-In</span>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-3">
                <div class="mini-card vipcandidatecolor dashboard-filter" onclick="applyDashboardFilter('vip', this)">
                    <img src="{{asset('assets/egc_images/magic_menu/vip_candidate.png')}}" class="mini-icon">
                    <div class="mini-content">
                        <h5 id="vip_candidates">00</h5>
                        <span class="text-nowrap">VIP</span>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-lg-12 mb-2 py-1 rounded bg-label-warning" style="border: 1px solid #fba919; display: none;" id="filter_div">
                <div class="row">
                    <div class="col-lg-4 border-end border-danger">
                        <div class="row">
                            <label class="col-5 fw-semibold fs-6 text-danger">Staff</label>
                            <label class="col-1 fw-semibold fs-6 text-danger">:</label>
                            <label class="col-6 fw-bold fs-6 text-danger">Kanimozhi</label>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-wrap align-items-center justify-content-end gap-3 py-2">
                    <a href="javascript:void(0)" onclick="clearFilter()"
                        class="btn btn-sm fw-bold text-white" style="background-color: #350501ff">
                        Clear Filter
                    </a>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="d-flex align-items-center justify-content-between mb-4 ">
                    <div>
                        <span>Show</span>
                        <select id="perpage" class="form-select form-select-sm w-75px"
                            onchange="loadThemes(1)">
                            @php $options = [5,10, 25, 100, 500]; @endphp
                            @foreach ($options as $option)
                            <option value="{{ $option }}" {{ $perpage == $option ? 'selected' : '' }}>
                                {{ $option }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex align-items-center justify-content-end flex-wrap gap-2">
                        <div class="searchBar">
                            <input type="text" id="search_filter" class="searchQueryInput"
                                placeholder="Search Job Role Name..."
                                value="{{ $search_filter }}" />

                            <div class="searchAction">
                                <div class="d-flex align-items-center">
                                    <a href="javascript:;" class="searchSubmit" id="searchSubmit">
                                        <span class="mdi mdi-magnify fs-4 fw-bold text-primary"></span>
                                    </a>
                                    <a href="javascript:;" class="refreshBar" id="refreshSearch">
                                        <span class="mdi mdi-refresh fs-4 fw-bold text-primary"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table class="table align-middle table-row-dashed  table-striped table-hover gy-0 gs-1 ">
                        <thead>
                            <tr class="text-start align-top  fw-bold fs-6 gs-0 bg-primary">
                                <th class="min-w-100px">Candidate/Mobile no</th>
                                <th class="min-w-100px">Job Role/Source</th>
                                <th class="min-w-100px">Qualification</th>
                                <th class="min-w-100px">Experience</th>
                                <th class="min-w-100px">Applied Date</th>
                                <th class="min-w-100px">Applicant Status</th>
                                <th class="min-w-80px text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-black fw-semibold fs-7" id="list-table-body">
                            <tr class="skeleton-loader" id="skeleton-loader" style="border-left: 5px solid #e2e2e2;">
                                <td class="skeleton-cell">
                                    <div class="skeleton"></div>
                                </td>
                                <td class="skeleton-cell">
                                    <div class="skeleton"></div>
                                </td>
                                <td class="skeleton-cell">
                                    <div class="skeleton"></div>
                                </td>
                                <td class="skeleton-cell">
                                    <div class="skeleton"></div>
                                </td>
                                <td class="skeleton-cell">
                                    <div class="skeleton"></div>
                                </td>
                                <td class="skeleton-cell">
                                    <div class="skeleton"></div>
                                </td>
                                <td class="skeleton-cell">
                                    <div class="skeleton"></div>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="text-center my-3" id="pagination-container">
                <!-- Pagination buttons will appear here -->
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="kt_modal_qr_generate" tabindex="-1" aria-hidden="true" data-bs-keyboard="false" data-bs-backdrop="static">
  <!--begin::Modal dialog-->
  <div class="modal-dialog modal-md">
    <!--begin::Modal content-->
    <div class="modal-content rounded">
      <!--begin::Modal header-->
      <div class="modal-header justify-content-end border-0 pb-0">
        <!--begin::Close-->
        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
          <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
          <span class="svg-icon svg-icon-1">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
              <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
            </svg>
          </span>
          <!--end::Svg Icon-->
        </div>
        <!--end::Close-->
      </div>
      <!--end::Modal header-->
      <!--begin::Modal body-->
        <div class="modal-body pt-0 pb-10 px-10 px-xl-20">

        <!-- Title -->
        <div class="text-center mb-6">
            <h3 class="fw-bold text-dark mb-1">Resume QR Code</h3>
            <p class="text-muted fs-7">
            Download this QR to apply for the job
            </p>
        </div>  
        
        <!-- QR Card -->
        <div class="d-flex justify-content-center mb-6">
            <div class="qr-card text-center p-4 ">
            <div id="qr_template" class="position-relative">
                <img  src="{{ asset('assets/egc_images/job/job_common_template.jpg') }}" id="poster_preview_img" class="w-100 object-fit-cover" />
                <img id="qrImage"
                src="{{ asset('assets/egc_images/qr_code.png') }}"
                class="qr-image mb-3">
            </div>
            <!-- Actions -->
            <div class="d-flex justify-content-center gap-3">
                
                 <button class="btn btn-sm btn-light-primary"
                        data-target="download_qr_code_name"
                        onclick="copyText(this)">
                    <i class="mdi mdi-content-copy me-1"></i>
                    Copy Link
                </button>
            </div>
            </div>
        </div>

        <div class="mb-2 d-flex text-center">
            <!-- Hidden Link -->
            <span id="download_qr_code_name" class="d-none bg-light p-1 w-100 rounded scroll-x"></span>
        </div>

        </div>
      <!--end::Modal body-->
    </div>
    <!--end::Modal content-->
  </div>
  <!--end::Modal dialog-->
</div>

<!--begin::Modal - Delete Staff-->
<div class=" modal fade" id="kt_modal_delete_candidate" tabindex="-1" aria-hidden="true" aria-hidden="true" data-bs-keyboard="false" data-bs-backdrop="static">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-m">
        <!--begin::Modal content-->
        <div class="modal-content rounded">
            <div class="swal2-icon swal2-danger swal2-icon-show" style="display: flex;">
                <!-- <div class="swal2-icon-content"><i class="mdi mdi-trash fs-2 text-danger"></i></div> -->
                <div>
                    <i class="fa-solid fa-trash text-danger" style="font-size: 35px;"></i>
                </div>
            </div>
            <div class="swal2-html-container mb-4" id="swal2-html-container" style="display: block;">
                <span id="delete_message">Are you sure you want to delete <br><b class="text-danger">Jayashree Ganesh </b> Candidate ?</span>
            </div>
            <div class="d-flex justify-content-center align-items-center py-8 mb-4">
                <button type="submit" class="btn btn-danger me-3" data-bs-dismiss="modal">Yes,delete!</button>
                <button type="reset" class="btn btn-secondary text-black" data-bs-dismiss="modal">No,cancel</button>
            </div>
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - Delete Staff-->

<!--begin::Modal - Approve Job Posting-->
<div class=" modal fade" id="kt_modal_select_candidate" tabindex="-1" aria-hidden="true" aria-hidden="true" data-bs-keyboard="false" data-bs-backdrop="static">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-m">
        <!--begin::Modal content-->
        <div class="modal-content rounded">
            <div class="swal2-icon swal2-success swal2-icon-show" style="display: flex;">
                <!-- <div class="swal2-icon-content"><i class="mdi mdi-trash fs-2 text-danger"></i></div> -->
                <div>
                    <i class="fa-solid fa-check text-success" style="font-size: 35px;"></i>
                </div>
            </div>
            <div class="swal2-html-container mb-4" id="swal2-html-container" style="display: block;">
                <span id="delete_message">Are you sure you want to select <br><b class="text-success">Jayashree Ganesh </b> Candidate ?</span>
            </div>
            <div class="d-flex justify-content-center align-items-center py-8 mb-4">
                <button type="submit" class="btn btn-success me-3" data-bs-dismiss="modal">Yes,Select!</button>
                <button type="reset" class="btn btn-secondary text-black" data-bs-dismiss="modal">No,cancel</button>
            </div>
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - Approve Job Posting-->

<!--begin::Modal - Reject Job Posting-->
<div class=" modal fade" id="kt_modal_reject_candidate" tabindex="-1" aria-hidden="true" aria-hidden="true" data-bs-keyboard="false" data-bs-backdrop="static">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-m">
        <!--begin::Modal content-->
        <div class="modal-content rounded">
            <div class="swal2-icon swal2-danger swal2-icon-show" style="display: flex;">
                <!-- <div class="swal2-icon-content"><i class="mdi mdi-trash fs-2 text-danger"></i></div> -->
                <div>
                    <i class="fa-solid fa-xmark text-danger" style="font-size: 35px;"></i>
                </div>
            </div>
            <div class="swal2-html-container mb-4" id="swal2-html-container" style="display: block;">
                <span id="delete_message">Are you sure you want to Reject <br><b class="text-danger">Jayashree Ganesh </b> Candidate ?</span>
            </div>
            <div class="d-flex justify-content-center align-items-center py-8 mb-4">
                <button type="submit" class="btn btn-danger me-3" data-bs-dismiss="modal">Yes,Reject!</button>
                <button type="reset" class="btn btn-secondary text-black" data-bs-dismiss="modal">No,cancel</button>
            </div>
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - Reject Job Posting-->


<style>
    /* Add Candidate: isolated UI layer. Existing form IDs and extraction hooks are unchanged. */
    #kt_modal_add_paticipants .modal-dialog { max-width: 1180px; margin: 1rem auto; }
    #kt_modal_add_paticipants .candidate-create-content { border: 0; border-radius: 20px; overflow: hidden; box-shadow: 0 24px 80px rgba(15,23,42,.22); }
    #kt_modal_add_paticipants .candidate-create-header { display:flex; align-items:center; justify-content:space-between; gap:18px; padding:20px 26px; border:0; background:linear-gradient(115deg,#fff 0%,#f7f9fd 100%); border-bottom:1px solid #e9edf4; }
    #kt_modal_add_paticipants .candidate-create-header-icon { width:48px; height:48px; flex:0 0 48px; display:flex; align-items:center; justify-content:center; border-radius:14px; color:#fff; background:linear-gradient(135deg,#ab2b22,#7f211b); font-size:25px; box-shadow:0 7px 16px rgba(171,43,34,.2); }
    #kt_modal_add_paticipants .candidate-create-eyebrow { color:#ab2b22; font-size:10px; letter-spacing:.12em; font-weight:800; margin-bottom:3px; }
    #kt_modal_add_paticipants .candidate-create-eyebrow span { padding:0 4px; color:#94a3b8; }
    #kt_modal_add_paticipants .candidate-create-header .modal-title { color:#172033; font-size:1.25rem; font-weight:800; letter-spacing:-.025em; }
    #kt_modal_add_paticipants .candidate-create-subtitle { color:#64748b; font-size:12px; line-height:1.5; }
    #kt_modal_add_paticipants .candidate-create-header-pill { align-items:center; padding:7px 11px; border:1px solid #f0d8d5; border-radius:999px; color:#8f2b24; background:#fff8f7; font-size:11px; font-weight:700; white-space:nowrap; }
    #kt_modal_add_paticipants .candidate-create-body { padding:20px 26px 24px; background:#f7f9fc; }
    #kt_modal_add_paticipants .candidate-intake-guide { display:flex; align-items:center; justify-content:center; gap:12px; padding:10px 14px; margin:0 0 17px; background:#fff; border:1px solid #e8edf4; border-radius:13px; }
    #kt_modal_add_paticipants .candidate-intake-step { display:flex; align-items:center; gap:9px; min-width:0; }
    #kt_modal_add_paticipants .candidate-intake-step > span { width:32px; height:32px; flex:0 0 32px; display:flex; align-items:center; justify-content:center; border-radius:10px; background:#f1f5f9; color:#64748b; font-size:17px; }
    #kt_modal_add_paticipants .candidate-intake-step.is-active > span { color:#fff; background:#ab2b22; box-shadow:0 4px 10px rgba(171,43,34,.16); }
    #kt_modal_add_paticipants .candidate-intake-step strong { display:block; color:#334155; font-size:11px; font-weight:800; line-height:1.25; }
    #kt_modal_add_paticipants .candidate-intake-step small { display:block; color:#94a3b8; font-size:10px; line-height:1.3; }
    #kt_modal_add_paticipants .candidate-intake-connector { width:48px; height:1px; flex:0 1 48px; background:#e2e8f0; }
    #kt_modal_add_paticipants .candidate-resume-section,
    #kt_modal_add_paticipants .candidate-details-section { padding:18px; border:1px solid #e3e9f1; border-radius:16px; background:#fff; box-shadow:0 3px 12px rgba(15,23,42,.035); }
    #kt_modal_add_paticipants .candidate-details-section { margin-top:16px; }
    #kt_modal_add_paticipants .candidate-panel-heading { display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom:14px; }
    #kt_modal_add_paticipants .candidate-panel-heading h5 { color:#1e293b; font-size:14px; font-weight:800; letter-spacing:-.01em; }
    #kt_modal_add_paticipants .candidate-panel-heading p { color:#8793a5; font-size:11px; margin-top:3px; }
    #kt_modal_add_paticipants .candidate-panel-icon { width:37px; height:37px; flex:0 0 37px; display:flex; align-items:center; justify-content:center; border-radius:11px; color:#ab2b22; background:#fff1ef; font-size:20px; }
    #kt_modal_add_paticipants .candidate-required-pill,
    #kt_modal_add_paticipants .candidate-review-pill { display:inline-flex; align-items:center; padding:5px 9px; border-radius:999px; font-size:10px; font-weight:800; white-space:nowrap; }
    #kt_modal_add_paticipants .candidate-required-pill { color:#b42318; background:#fff1f0; border:1px solid #ffe0dc; }
    #kt_modal_add_paticipants .candidate-review-pill { color:#475569; background:#f1f5f9; border:1px solid #e2e8f0; }

    #kt_modal_add_paticipants #resumeUploadCard { border:1px solid #dce5f0; border-radius:15px; background:linear-gradient(145deg,#fbfdff 0%,#f5f8fe 100%); overflow:hidden; }
    #kt_modal_add_paticipants #resumeDropzone { border:1.5px dashed #9bb8e8; border-radius:13px; margin:10px; padding:19px 18px; background:rgba(255,255,255,.9); transition:border-color .18s ease,background .18s ease,transform .18s ease,box-shadow .18s ease; cursor:pointer; }
    #kt_modal_add_paticipants #resumeDropzone:hover, #kt_modal_add_paticipants #resumeDropzone:focus-visible { border-color:#4678cb; box-shadow:0 5px 18px rgba(37,99,235,.08); outline:0; }
    #kt_modal_add_paticipants #resumeDropzone.is-dragover { border-color:#2563eb; background:#eff6ff; transform:translateY(-1px); }
    #kt_modal_add_paticipants #resumeUploadCard .resume-upload-symbol { width:54px; height:54px; display:inline-flex; align-items:center; justify-content:center; border-radius:15px; background:#e9f1ff; color:#2458bb; font-size:26px; flex-shrink:0; }
    #kt_modal_add_paticipants #resumeUploadCard .resume-format-chip { display:inline-flex; align-items:center; border:1px solid #e1e8f4; border-radius:999px; padding:4px 9px; background:#fff; color:#64748b; font-size:10px; font-weight:700; }
    #kt_modal_add_paticipants #resumeUploadCard .resume-file-summary { border-top:1px solid #e7edf7; padding:12px 15px 15px; }
    #kt_modal_add_paticipants #resumeUploadCard .resume-file-logo { width:42px; height:42px; object-fit:contain; border:1px solid #e2e8f0; border-radius:10px; background:#fff; padding:3px; }
    #kt_modal_add_paticipants #resumeUploadCard .resume-upload-hint { color:#64748b; font-size:11px; }
    #kt_modal_add_paticipants #resumeUploadCard .btn { border-radius:9px; }
    #kt_modal_add_paticipants #resume_file_name { font-size:12px; }
    #kt_modal_add_paticipants #resume_parse_status { font-size:11px; }
    #kt_modal_add_paticipants #resume_err { font-size:11px; font-weight:600; }
    #kt_modal_add_paticipants .candidate-resume-tip { display:flex; align-items:flex-start; gap:7px; margin:10px 2px 0; color:#64748b; font-size:11px; line-height:1.5; }
    #kt_modal_add_paticipants .candidate-resume-tip i { color:#b7791f; font-size:15px; flex:0 0 auto; }

    #kt_modal_add_paticipants .candidate-fields-panel { padding:0; border:0; border-radius:0; background:transparent; }
    #kt_modal_add_paticipants .candidate-fields-grid { margin-left:-.55rem; margin-right:-.55rem; }
    #kt_modal_add_paticipants .candidate-fields-grid > [class*="col-"] { padding-left:.55rem; padding-right:.55rem; }
    #kt_modal_add_paticipants .candidate-section-heading { display:flex; align-items:center; gap:10px; padding-top:7px; padding-bottom:3px; }
    #kt_modal_add_paticipants .candidate-section-heading-spaced { margin-top:9px; padding-top:14px; border-top:1px solid #edf1f5; }
    #kt_modal_add_paticipants .candidate-section-index { width:25px; height:25px; flex:0 0 25px; display:inline-flex; align-items:center; justify-content:center; border-radius:8px; background:#f8e9e7; color:#9c2a22; font-size:10px; font-weight:800; }
    #kt_modal_add_paticipants .candidate-section-heading h6 { margin:0; color:#334155; font-size:12px; font-weight:800; }
    #kt_modal_add_paticipants .candidate-section-heading p { margin:2px 0 0; color:#94a3b8; font-size:10px; }
    #kt_modal_add_paticipants .candidate-fields-grid label { color:#334155 !important; font-size:11px !important; font-weight:700 !important; margin-bottom:5px !important; }
    #kt_modal_add_paticipants .candidate-fields-grid .form-control,
    #kt_modal_add_paticipants .candidate-fields-grid .form-select,
    #kt_modal_add_paticipants .candidate-fields-grid .select2-selection { min-height:41px; border-color:#dce3ec; border-radius:9px; box-shadow:none; font-size:12px; }
    #kt_modal_add_paticipants .candidate-fields-grid .form-control:focus,
    #kt_modal_add_paticipants .candidate-fields-grid .form-select:focus { border-color:#9eb8e5; box-shadow:0 0 0 3px rgba(37,99,235,.08); }
    #kt_modal_add_paticipants .candidate-fields-grid .form-text,
    #kt_modal_add_paticipants .candidate-fields-grid .small.text-muted { font-size:10px; line-height:1.45; }
    #kt_modal_add_paticipants .candidate-fields-grid textarea.form-control { min-height:88px; }
    #kt_modal_add_paticipants .candidate-create-footer { position:sticky; bottom:-24px; z-index:4; display:flex; align-items:center; justify-content:space-between; gap:15px; margin:18px -26px -24px; padding:14px 26px; border-top:1px solid #e5eaf1; background:rgba(255,255,255,.97); box-shadow:0 -5px 18px rgba(15,23,42,.035); }
    #kt_modal_add_paticipants .candidate-footer-note { display:flex; align-items:center; gap:7px; color:#8390a2; font-size:10px; }
    #kt_modal_add_paticipants .candidate-footer-note i { color:#16a34a; font-size:16px; }
    #kt_modal_add_paticipants .candidate-create-footer .btn { min-height:39px; border-radius:9px; padding-left:16px; padding-right:16px; font-size:12px; font-weight:700; }
    #kt_modal_add_paticipants .candidate-submit-btn { min-width:155px; box-shadow:0 5px 12px rgba(171,43,34,.15); }
    #kt_modal_add_paticipants #candidate_name_assist { flex-wrap:wrap; line-height:1.45; font-size:10px; }
    #kt_modal_add_paticipants #candidate_name_assist .badge { font-weight:700; }

    @media (max-width:767.98px) {
        #kt_modal_add_paticipants .modal-dialog { margin:.35rem; }
        #kt_modal_add_paticipants .candidate-create-header { padding:15px; }
        #kt_modal_add_paticipants .candidate-create-body { padding:14px 14px 20px; }
        #kt_modal_add_paticipants .candidate-resume-section,
        #kt_modal_add_paticipants .candidate-details-section { padding:13px; }
        #kt_modal_add_paticipants .candidate-intake-guide { justify-content:space-between; gap:5px; padding:9px 7px; }
        #kt_modal_add_paticipants .candidate-intake-connector { width:12px; flex:0 1 12px; }
        #kt_modal_add_paticipants .candidate-intake-step { gap:5px; }
        #kt_modal_add_paticipants .candidate-intake-step > span { width:28px; height:28px; flex-basis:28px; font-size:15px; }
        #kt_modal_add_paticipants .candidate-intake-step strong { font-size:9px; }
        #kt_modal_add_paticipants .candidate-intake-step small { font-size:8px; }
        #kt_modal_add_paticipants .candidate-panel-heading { align-items:flex-start; }
        #kt_modal_add_paticipants .candidate-panel-heading p { max-width:230px; }
        #kt_modal_add_paticipants .candidate-create-footer { bottom:-20px; flex-direction:column; align-items:stretch; margin:16px -14px -20px; padding:12px 14px; }
        #kt_modal_add_paticipants .candidate-footer-note { justify-content:center; }
        #kt_modal_add_paticipants .candidate-create-footer > .d-flex { width:100%; }
        #kt_modal_add_paticipants .candidate-create-footer .btn { flex:1; }
    }
    @media (max-width:420px) {
        #kt_modal_add_paticipants .candidate-create-subtitle { display:none; }
        #kt_modal_add_paticipants .candidate-review-pill { display:none; }
        #kt_modal_add_paticipants .candidate-intake-step small { display:none; }
        #kt_modal_add_paticipants .candidate-intake-step { flex-direction:column; text-align:center; }
        #kt_modal_add_paticipants .candidate-intake-guide { padding:8px 4px; }
    }
</style>

<div class="modal fade candidate-create-modal" id="kt_modal_add_paticipants" tabindex="-1" aria-hidden="true" data-bs-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content candidate-create-content">
            <div class="modal-header candidate-create-header">
                <div class="d-flex align-items-center gap-3 min-w-0">
                    <div class="candidate-create-header-icon"><i class="mdi mdi-account-plus-outline"></i></div>
                    <div class="min-w-0">
                        <div class="candidate-create-eyebrow">HR MANAGEMENT <span>•</span> RECRUITMENT</div>
                        <h4 class="modal-title mb-1">Add Candidate</h4>
                        <p class="mb-0 candidate-create-subtitle">Start with the resume. Review the extracted details and complete the candidate profile.</p>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3 ms-2">
                    <span class="candidate-create-header-pill d-none d-sm-inline-flex"><i class="mdi mdi-file-search-outline me-1"></i> Resume-first intake</span>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body candidate-create-body">
                <form id="jobApplyForm" action="{{ route('add_new_candidate') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                    
                    @csrf
                    <input type="hidden" name="apply_job_request_id" id="apply_job_request_id">
                    <input type="hidden" name="apply_candidate_id" id="apply_candidate_id">
                    <input type="hidden" name="apply_applicant_id" id="apply_applicant_id">
                    <input type="hidden" name="resume_check" id="resume_check" value="0">
                    <input type="hidden" name="resume_extraction_token" id="resume_extraction_token" value="">
                    <input type="hidden" name="resume_source_sha256" id="resume_source_sha256" value="">
                    
                    <div class="candidate-intake-guide" aria-label="Candidate registration steps">
                        <div class="candidate-intake-step is-active"><span><i class="mdi mdi-file-upload-outline"></i></span><div><strong>Upload resume</strong><small>Start here</small></div></div>
                        <div class="candidate-intake-connector"></div>
                        <div class="candidate-intake-step"><span><i class="mdi mdi-account-edit-outline"></i></span><div><strong>Review details</strong><small>Verify suggestions</small></div></div>
                        <div class="candidate-intake-connector"></div>
                        <div class="candidate-intake-step"><span><i class="mdi mdi-check-circle-outline"></i></span><div><strong>Save profile</strong><small>Submit candidate</small></div></div>
                    </div>

                    <section class="candidate-resume-section" aria-labelledby="candidateResumeHeading">
                        <div class="candidate-panel-heading">
                            <div class="d-flex align-items-center gap-2">
                                <span class="candidate-panel-icon"><i class="mdi mdi-file-pdf-box"></i></span>
                                <div>
                                    <h5 id="candidateResumeHeading" class="mb-0">Resume upload <span class="text-danger">*</span></h5>
                                    <p class="mb-0">Upload the resume first to automatically suggest candidate details.</p>
                                </div>
                            </div>
                            <span class="candidate-required-pill">Required</span>
                        </div>
                        <div class="candidate-resume-upload mb-0" id="resume_div">
                                    <label class="text-black mb-1 fs-6 fw-semibold">Choose resume file <span class="text-danger">*</span></label>
                                    <div id="resumeUploadCard">
                                        <div id="resumeDropzone" class="text-center" role="button" tabindex="0" aria-label="Choose or drop a resume file">
                                            <div class="d-flex flex-column flex-md-row align-items-center justify-content-center gap-3">
                                                <div class="resume-upload-symbol"><i class="mdi mdi-file-upload-outline"></i></div>
                                                <div class="text-center text-md-start">
                                                    <h6 class="mb-1 fw-bold text-dark">Upload a resume to identify the candidate name</h6>
                                                    <p class="text-muted small mb-2">Drag and drop the file here, or choose it from your device.</p>
                                                    <div class="d-flex flex-wrap justify-content-center justify-content-md-start gap-1">
                                                        <span class="resume-format-chip">PDF</span><span class="resume-format-chip">DOC / DOCX</span><span class="resume-format-chip">ODT / RTF</span><span class="resume-format-chip">TXT / HTML</span><span class="resume-format-chip">PPT / XLS</span><span class="resume-format-chip">Images + OCR</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-center justify-content-md-start flex-wrap gap-2 mt-3">
                                                <label for="upload_resume" class="btn btn-primary btn-sm mb-0">
                                                    <i class="mdi mdi-folder-open-outline me-1"></i>Choose resume
                                                </label>
                                                <button type="button" class="btn btn-outline-secondary btn-sm file-reset" title="Remove selected resume">
                                                    <i class="mdi mdi-refresh me-1"></i>Reset
                                                </button>
                                                <span class="resume-upload-hint">Maximum 10 MB · Name extraction only · Recruiter review required</span>
                                            </div>
                                            <input type="file" id="upload_resume" name="upload_resume" class="file-in" hidden accept=".pdf,.doc,.docx,.docm,.odt,.rtf,.txt,.text,.md,.markdown,.html,.htm,.ppt,.pptx,.xls,.xlsx,.jpg,.jpeg,.png,.webp,.bmp,.gif,.tif,.tiff" data-max-size="10485760" />
                                        </div>
                                        <div id="resume_preview" class="resume-file-summary d-none">
                                            <div class="d-flex align-items-center gap-3">
                                                <img src="{{asset('assets/egc_images/docx_icon.png')}}" alt="Resume file type" class="resume-file-logo" id="uploadedlogo" />
                                                <div class="flex-grow-1 min-w-0">
                                                    <div class="small text-muted">Selected resume</div>
                                                    <div id="resume_file_name" class="fw-semibold text-dark text-break"></div>
                                                    <div id="resume_parse_status" class="small text-muted mt-1" aria-live="polite"></div>
                                                </div>
                                                <button type="button" id="resume_file_view_btn" class="resume-file-viewer-trigger" aria-label="View uploaded resume" title="View uploaded resume">
                                                    <i class="mdi mdi-eye-outline"></i><span>View file</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-danger small mt-1" id="resume_err" role="alert"></div>
                                </div>
                        <div class="candidate-resume-tip"><i class="mdi mdi-lightbulb-on-outline"></i><span>AI extraction provides suggestions only. Please verify the candidate’s details before saving.</span></div>
                    </section>

                    <section class="candidate-details-section" aria-labelledby="candidateDetailsHeading">
                        <div class="candidate-panel-heading candidate-details-heading">
                            <div class="d-flex align-items-center gap-2">
                                <span class="candidate-panel-icon"><i class="mdi mdi-account-details-outline"></i></span>
                                <div>
                                    <h5 id="candidateDetailsHeading" class="mb-0">Candidate information</h5>
                                    <p class="mb-0">Check and complete the information suggested from the resume.</p>
                                </div>
                            </div>
                            <span class="candidate-review-pill"><i class="mdi mdi-pencil-check-outline me-1"></i>Review before saving</span>
                        </div>
                        <div class="candidate-fields-panel">
                            <div class="row g-3 mb-0 candidate-fields-grid">
                                <div class="col-12 candidate-section-heading"><span class="candidate-section-index">01</span><div><h6>Personal information</h6><p>Review the details extracted from the uploaded resume.</p></div></div>
                                <div class="col-lg-4 mb-2">
                                    <label class="text-black mb-1 fs-6 fw-semibold">Candidate Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Enter Candidate Name" id="candidate_name" name="candidate_name" autocomplete="name" aria-describedby="candidate_name_assist candidate_name_err" oninput="this.value=this.value.replace(/^\w/, txt=>txt.toUpperCase());" />
                                    <div id="candidate_name_assist" class="form-text d-flex align-items-center gap-2 mt-1" aria-live="polite">
                                        <span class="badge bg-label-primary">AI name assist</span>
                                        <span>Upload a resume to suggest the candidate name, mobile and email. Verify every suggestion before saving.</span>
                                    </div>
                                    <div class="text-danger" id="candidate_name_err"></div>
                                </div>
                                <div class="col-lg-4 mb-2">
                                    <label class="text-black mb-1 fs-6 fw-semibold">Candidate Mobile Number<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Enter Candidate Mobile Number" id="candidate_mobile" name="candidate_mobile" maxlength="16" inputmode="tel" autocomplete="tel-national" aria-describedby="candidate_mobile_err" />
                                    <div class="text-danger" id="candidate_mobile_err"></div>
                                </div>
                                <div class="col-lg-4 mb-2">
                                    <label class="text-black mb-1 fs-6 fw-semibold">Candidate Email Id<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Enter Candidate Email Id" id="candidate_email" name="candidate_email" oninput="this.value=this.value.toLowerCase();" />
                                    <div class="text-danger" id="candidate_email_err"></div>
                                </div>
                                <div class="col-lg-4 mb-2">
                                    <label class="text-black mb-1 fs-6 fw-semibold">Gender <span class="text-muted small">(only when explicitly stated)</span></label>
                                    <select id="candidate_gender" name="candidate_gender" class="select3 form-select">
                                        <option value="">Select Gender</option>
                                        <option value="1">Male</option>
                                        <option value="2">Female</option>
                                        <option value="3">Others</option>
                                    </select>
                                    <div class="text-danger" id="candidate_gender_err"></div>
                                </div>
                                <div class="col-lg-4 mb-2">
                                    <label class="text-black mb-1 fs-6 fw-semibold">Marital Status <span class="text-muted small">(only when explicitly stated)</span></label>
                                    <select id="candidate_marital_status" name="candidate_marital_status" class="select3 form-select">
                                        <option value="">Select Marital Status</option>
                                        <option value="1">Married</option>
                                        <option value="2">Single</option>
                                    </select>
                                    <div class="text-danger" id="candidate_marital_status_err"></div>
                                </div>
                                <div class="col-12 candidate-section-heading candidate-section-heading-spaced"><span class="candidate-section-index">02</span><div><h6>Application preferences</h6><p>Choose the source and suitable job roles for this candidate.</p></div></div>
                                <div class="col-lg-4 mb-2">
                                    <label class="text-black mb-1 fs-6 fw-semibold">Source</label>
                                    <select id="source_name" name="source_name" class="select3 form-select">
                                        <option value="">Select Source</option>
                                        @if(isset($source_list))
                                        @foreach($source_list as $source)
                                        <option value="{{ $source->sno }}" data-detail="{{$source->detail_check ?? 0}}">{{ $source->source_name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <div class="text-danger" id="source_name_err"></div>
                                </div>
                                <div class="col-lg-4 mb-2">
                                    <label class="text-black mb-1 fs-6 fw-semibold">Job Roles <span class="text-muted small">(Optional)</span></label>
                                    <select id="candidate_role_ids" name="recruitment_role_ids[]" class="select3 form-select" multiple data-placeholder="Select one or more job roles" aria-label="Optional candidate job roles">
                                        @if(isset($recruitment_roles))
                                        @foreach($recruitment_roles as $recruitmentRole)
                                        <option value="{{ $recruitmentRole->sno }}">{{ $recruitmentRole->role_name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <div class="form-text">Choose any matching roles; this field can be left blank.</div>
                                    <div id="candidate_role_match_status" class="small text-muted mt-1" aria-live="polite">Upload a resume to suggest eligible roles using education, work history, internships and skills.</div>
                                </div>
                                <div class="col-12 candidate-section-heading candidate-section-heading-spaced"><span class="candidate-section-index">03</span><div><h6>Education & experience</h6><p>Add the candidate’s highest qualification, specialization and work experience.</p></div></div>
                                <div class="col-lg-4 mb-2">
                                    <label class="text-black mb-1 fs-6 fw-semibold">Qualification<span class="text-danger">*</span></label>
                                    <select id="candidate_qualification" name="candidate_qualification" class="select3 form-select" onchange="candidate_qualification_change()">
                                        <option value="">Select Qualification</option>
                                        <option value="1">UG</option>
                                        <option value="2">PG</option>
                                        <option value="3">Doctorate</option>
                                        <option value="4">HSC</option>
                                        <option value="5">SSLC</option>
                                        <option value="6">Below SSLC</option>
                                        <option value="7">Diploma</option>
                                        <option value="Others">Others</option>
                                    </select>
                                    <div class="text-danger" id="candidate_qualification_err"></div>
                                </div>
                                <div class="col-lg-4 mb-2" id="major_div">
                                    <label class="text-black mb-1 fs-6 fw-semibold">Major<span class="text-danger">*</span></label>
                                    <select id="candidate_major" name="candidate_major" class="select3 form-select" onchange="major_change_func()">
                                        <option value="">Select Major</option>

                                    </select>
                                    <div class="text-danger" id="candidate_major_err"></div>
                                </div>
                                <div class="col-lg-4 mb-2" id="candidate_other_qualify_div">
                                    <label class="text-black mb-1 fs-6 fw-semibold">Others<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Enter Other Qualification" id="candidate_other_qualify" name="candidate_other_qualify" oninput="this.value=this.value.replace(/^\w/, txt=>txt.toUpperCase());" />
                                    <div class="text-danger" id="candidate_other_qualify_err"></div>
                                </div>
                                <div class="col-lg-4 mb-2">
                                    <label class="text-black mb-1 fs-6 fw-semibold">Experience Type<span class="text-danger">*</span></label>
                                    <select id="candidate_exper_type" name="candidate_exper_type" class="select3 form-select" onchange="toggleExperience()">
                                        <option value="">Select Type</option>
                                        <option value="1">Fresher</option>
                                        <option value="2">Experience</option>
                                    </select>
                                    <div class="text-danger" id="candidate_exper_type_err"></div>
                                </div>
                                <div class="col-lg-4 mb-2" id="experience_div" style="display:none;">
                                    <label class="text-black mb-1 fs-6 fw-semibold">Experience<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="candidate_exper_count" name="candidate_exper_count" placeholder="Enter Experience (years)" maxlength="4" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                                    <div class="text-danger" id="candidate_exper_count_err"></div>
                                </div>
                                <div class="col-lg-12 mb-2" >
                                    <label class="text-black mb-1 fs-6 fw-semibold">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter Description" ></textarea>
                                </div>
                               
                                
                            </div>
                        </div>
                    </section>

                    <div class="candidate-create-footer">
                        <div class="candidate-footer-note"><i class="mdi mdi-shield-check-outline"></i><span>Candidate information is saved to your recruitment records.</span></div>
                        <div class="d-flex justify-content-end align-items-center gap-2">
                            <a href="javascript:;" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</a>
                            <button id="addApplicantBtn" type="button" class="btn btn-primary candidate-submit-btn" onclick="validation_func()">
                                <span id="yesBtnText"><i class="mdi mdi-content-save-check-outline me-1"></i>Save Candidate</span>
                                <span id="yesBtnLoader" style="display: none;" role="status" aria-hidden="true">
                                    <span class="spinner-border spinner-border-sm"></span>
                                    <span class="ms-2">Saving candidate...</span>
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ADD CANDIDATE - UPLOADED RESUME VIEWER -->
<div class="modal fade" id="resumeFileViewerModal" tabindex="-1" aria-labelledby="resumeFileViewerTitle"  aria-hidden="true"  data-bs-backdrop="static" data-bs-keyboard="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header px-3 px-md-4 py-3">
                <div class="d-flex align-items-center gap-3 min-w-0">
                    <div
                        class="d-flex align-items-center justify-content-center rounded-3"
                        style="width:42px;height:42px;background:#fef2f2;color:#ab2b22;flex:0 0 auto;">
                        <i class="mdi mdi-file-eye-outline fs-4"></i>
                    </div>

                    <div class="resume-file-viewer-meta">
                        <h5 id="resumeFileViewerTitle" class="modal-title fw-bold mb-0">
                            Uploaded Resume
                        </h5>
                        <div id="resumeFileViewerMeta" class="resume-file-viewer-info mt-1">
                            Verify the uploaded document before applying.
                        </div>
                    </div>
                </div>

                <button
                    type="button"
                    class="btn-close ms-2"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                </button>
            </div>

            <div class="modal-body p-0">
                <div class="resume-file-viewer-card">

                    <div class="resume-file-viewer-toolbar d-flex flex-wrap align-items-center justify-content-between gap-2">
                        <div class="d-flex align-items-center gap-2">
                            <span
                                id="resumeFileViewerTypeBadge"
                                class="badge rounded-pill bg-label-primary">
                                File
                            </span>
                            <span class="text-muted" style="font-size:11px;">
                                Manual verification
                            </span>
                        </div>

                        <div class="d-flex align-items-center gap-2">
                            <div id="resumeFileViewerImageControls" class="d-none align-items-center gap-1">
                                <button
                                    type="button"
                                    class="btn btn-sm btn-outline-secondary"
                                    id="resumeFileViewerZoomOut"
                                    title="Zoom out"
                                    aria-label="Zoom out">
                                    <i class="mdi mdi-minus"></i>
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-sm btn-outline-secondary"
                                    id="resumeFileViewerZoomReset"
                                    title="Reset zoom"
                                    aria-label="Reset zoom">
                                    <i class="mdi mdi-fit-to-screen-outline"></i>
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-sm btn-outline-secondary"
                                    id="resumeFileViewerZoomIn"
                                    title="Zoom in"
                                    aria-label="Zoom in">
                                    <i class="mdi mdi-plus"></i>
                                </button>
                            </div>

                            <a
                                href="#"
                                target="_blank"
                                rel="noopener"
                                id="resumeFileViewerOpenBtn"
                                class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1"
                                style="display:none;">
                                <i class="mdi mdi-open-in-new"></i>
                                <span>Open</span>
                            </a>
                        </div>
                    </div>

                    <div class="resume-file-viewer-stage">

                        <iframe
                            id="resumeFileViewerFrame"
                            class="resume-file-viewer-frame"
                            title="Uploaded resume document preview"
                            loading="eager"
                            referrerpolicy="no-referrer">
                        </iframe>

                        <div id="resumeFileViewerDocxWrap" aria-label="Word document preview">
                            <div id="resumeFileViewerDocxLoading"><span class="spinner-border spinner-border-sm me-2" role="status"></span>Preparing Word document preview…</div>
                            <article id="resumeFileViewerDocxContent" class="resume-word-document"></article>
                        </div>

                        <div
                            id="resumeFileViewerImageWrap"
                            class="resume-file-viewer-image-wrap">
                            <img
                                id="resumeFileViewerImage"
                                class="resume-file-viewer-image"
                                alt="Uploaded resume preview"
                                draggable="false">
                        </div>

                        <div
                            id="resumeFileViewerEmpty"
                            class="resume-file-viewer-empty">

                            <div class="resume-file-viewer-empty-inner">
                                <div class="resume-file-viewer-empty-icon">
                                    <i class="mdi mdi-file-alert-outline"></i>
                                </div>

                                <h5 id="resumeFileViewerEmptyTitle" class="fw-bold mb-2">
                                    Preview unavailable
                                </h5>

                                <p id="resumeFileViewerEmptyText" class="text-muted mb-4" style="font-size:13px;line-height:1.7;">
                                    This file type cannot be rendered directly inside the browser.
                                    You can still open the exact uploaded file in a new tab.
                                </p>

                                <a
                                    href="#"
                                    target="_blank"
                                    rel="noopener"
                                    id="resumeFileViewerEmptyOpenBtn"
                                    class="btn btn-primary btn-sm">
                                    <i class="mdi mdi-open-in-new me-1"></i>
                                    Open Uploaded File
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="modal-footer px-3 px-md-4 py-3 justify-content-between">
                <div class="small text-muted d-flex align-items-center gap-1">
                    <i class="mdi mdi-shield-check-outline text-success"></i>
                    <span>Preview uses the selected local file. It is not uploaded again.</span>
                </div>

                <button
                    type="button"
                    class="btn btn-secondary btn-sm"
                    data-bs-dismiss="modal">
                    Done
                </button>
            </div>

        </div>
    </div>
</div>

<!--begin::Modal Create Candidate--->

<div class="modal fade" id="kt_modal_edit_applicant" tabindex="-1" aria-hidden="true" data-bs-keyboard="false" data-bs-backdrop="static">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-xl">
        <!--begin::Modal content-->
        <div class="modal-content rounded">
            <!--begin::Modal header-->
            <div class="modal-header justify-content-end border-0 pb-0">
                <!--begin::Close-->
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                    <span class="svg-icon svg-icon-1">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body pt-0 pb-10 px-10 px-xl-20">
                <!--begin::Heading-->
                <div class="mb-4 text-center">
                    <h3 class="text-center mb-4 text-black">Update Candidate </h3>
                </div>

                <form id="jobApplyFormEdit" action="{{ route('update_candidate') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <input type="hidden" name="edit_candidate_id" id="edit_candidate_id">

                    <div class="row mt-2">
                        <div class="col-12 border rounded p-2 px-3">
                            <div class="row mb-3">
                                <div class="col-lg-4 mb-2">
                                    <label class="text-black mb-1 fs-6 fw-semibold">Candidate Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Enter Candidate Name" id="candidate_name_edit" name="candidate_name" oninput="this.value=this.value.replace(/^\w/, txt=>txt.toUpperCase());" />
                                    <div class="text-danger" id="candidate_name_edit_err"></div>
                                </div>
                                <div class="col-lg-4 mb-2">
                                    <label class="text-black mb-1 fs-6 fw-semibold">Candidate Mobile Number<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Enter Candidate Mobile Number" id="candidate_mobile_edit" name="candidate_mobile" maxlength="16" inputmode="tel" autocomplete="tel-national" aria-describedby="candidate_mobile_edit_err" />
                                    <div class="text-danger" id="candidate_mobile_edit_err"></div>
                                </div>
                                <div class="col-lg-4 mb-2">
                                    <label class="text-black mb-1 fs-6 fw-semibold">Candidate Email Id<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Enter Candidate Email Id" id="candidate_email_edit" name="candidate_email" oninput="this.value=this.value.toLowerCase();" />
                                    <div class="text-danger" id="candidate_email_edit_err"></div>
                                </div>
                                <div class="col-lg-4 mb-2">
                                    <label class="text-black mb-1 fs-6 fw-semibold">Gender <span class="text-muted small">(only when explicitly stated)</span></label>
                                    <select id="candidate_gender_edit" name="candidate_gender" class="select3 form-select">
                                        <option value="">Select Gender</option>
                                        <option value="1" selected>Male</option>
                                        <option value="2">Female</option>
                                        <option value="3">Others</option>
                                    </select>
                                    <div class="text-danger" id="candidate_gender_edit_err"></div>
                                </div>
                                <div class="col-lg-4 mb-2">
                                    <label class="text-black mb-1 fs-6 fw-semibold">Marital Status <span class="text-muted small">(only when explicitly stated)</span></label>
                                    <select id="candidate_marital_status_edit" name="candidate_marital_status" class="select3 form-select">
                                        <option value="">Select Marital Status</option>
                                        <option value="1">Married</option>
                                        <option value="2">Single</option>
                                    </select>
                                    <div class="text-danger" id="candidate_marital_status_edit_err"></div>
                                </div>
                                <div class="col-lg-4 mb-2">
                                    <label class="text-black mb-1 fs-6 fw-semibold">Source<span class="text-danger">*</span></label>
                                    <select id="source_name_edit" name="source_name" class="select3 form-select">
                                        <option value="">Select Source</option>
                                        @if(isset($source_list))
                                        @foreach($source_list as $source)
                                        <option value="{{ $source->sno }}" data-detail="{{$source->detail_check ?? 0}}">{{ $source->source_name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <div class="text-danger" id="source_name_edit_err"></div>
                                </div>
                                <div class="col-lg-4 mb-2">
                                    <label class="text-black mb-1 fs-6 fw-semibold">Job Roles <span class="text-muted small">(Optional)</span></label>
                                    <input type="hidden" name="recruitment_role_ids_present" value="1">
                                    <select id="candidate_role_ids_edit" name="recruitment_role_ids[]" class="select3 form-select" multiple data-placeholder="Select one or more job roles" aria-label="Optional candidate job roles">
                                        @if(isset($recruitment_roles))
                                        @foreach($recruitment_roles as $recruitmentRole)
                                        <option value="{{ $recruitmentRole->sno }}">{{ $recruitmentRole->role_name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <div class="form-text">Choose any matching roles; clear all selections to remove role tags.</div>
                                </div>
                                <div class="col-lg-4 mb-2">
                                    <label class="text-black mb-1 fs-6 fw-semibold">Qualification<span class="text-danger">*</span></label>
                                    <select id="qualification_id_edit" name="candidate_qualification" class="select3 form-select" onchange="qualification_change_edit()">
                                        <option value="">Select Qualification</option>
                                        <option value="1">UG</option>
                                        <option value="2">PG</option>
                                        <option value="3">Doctorate</option>
                                        <option value="4">HSC</option>
                                        <option value="5">SSLC</option>
                                        <option value="6">Below SSLC</option>
                                        <option value="Others">Others</option>
                                    </select>
                                    <div class="text-danger" id="candidate_qualification_edit_err"></div>
                                </div>
                                <div class="col-lg-4 mb-2" id="major_div_edit">
                                    <label class="text-black mb-1 fs-6 fw-semibold">Major<span class="text-danger">*</span></label>
                                    <select id="major_edit" name="candidate_major" class="select3 form-select">
                                        <option value="">Select Major</option>

                                    </select>
                                    <div class="text-danger" id="candidate_major_edit_err"></div>
                                </div>

                                <div class="col-lg-4 mb-2">
                                    <label class="text-black mb-1 fs-6 fw-semibold">Experience Type<span class="text-danger">*</span></label>
                                    <select id="candidate_exper_type_edit" name="candidate_exper_type" class="select3 form-select" onchange="toggleExperienceEdit()">
                                        <option value="">Select Type</option>
                                        <option value="1" selected>Fresher</option>
                                        <option value="2">Experience</option>
                                    </select>
                                    <div class="text-danger" id="candidate_exper_type_edit_err"></div>
                                </div>
                                <div class="col-lg-4 mb-2" id="experience_div_edit" style="display:none;">
                                    <label class="text-black mb-1 fs-6 fw-semibold">Experience<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="candidate_exper_count_edit" name="candidate_exper_count" placeholder="Enter Experience (years)" maxlength="4" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                                    <div class="text-danger" id="candidate_exper_count_edit_err"></div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end align-items-center mt-6">
                        <a href="javascript:;" class="btn btn-secondary me-3" data-bs-dismiss="modal">Cancel</a>
                        <button id="updateApplicantBtn" type="button" class="btn btn-primary" onclick="validation_edit_func()">
                            <span id="yesBtnTextEdit">Update</span>
                            <span id="yesBtnLoaderEdit" style="display: none;" role="status" aria-hidden="true">
                                <span class="spinner-border spinner-border-sm"></span>
                                <span class="ms-2">Updating...</span>
                            </span>

                        </button>
                    </div>
                </form>
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>

<!--begin::Modal Create Candidate--->

<!--end::Modal - Create Candidate-->



{{-- =========================================================
     BULK AI ROLE MATCHING MODAL
========================================================= --}}
@if($canUseAtsRoleMatching)
<div class="modal fade egc-ats-modal" id="kt_modal_bulk_ai_matching" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content egc-ats-bulk-modal">
            <div class="modal-header egc-ats-modal-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="egc-ats-head-icon"><i class="mdi mdi-robot-outline"></i></div>
                    <div>
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <h4 class="mb-0 fw-bold">Bulk ATS Role Matching</h4>
                            <span class="egc-ats-access-badge"><i class="mdi mdi-shield-account-outline me-1"></i>Super Admin / Developer</span>
                        </div>
                        <div class="small text-muted mt-1">Queue 20K+ candidates safely, analyse multiple company roles, and monitor progress live.</div>
                    </div>
                </div>
                <button type="button" class="btn btn-icon btn-sm btn-light" data-bs-dismiss="modal" aria-label="Close"><i class="mdi mdi-close fs-5"></i></button>
            </div>

            <div class="modal-body egc-ats-bulk-body">
                <div id="egcAtsBulkSetup">
                    <div class="egc-ats-info-banner mb-3">
                        <div class="egc-ats-info-icon"><i class="mdi mdi-information-outline"></i></div>
                        <div>
                            <div class="fw-bold">Production-safe queue processing</div>
                            <div class="small text-muted">Each candidate is analysed independently, saved to dedicated ATS tables, and can match zero, one, or multiple roles. Existing candidate <code>ai_response</code>, <code>job_role_id</code>, and <code>match_score</code> are not modified by this engine.</div>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-3">
                            <div class="egc-ats-stat-card"><div class="egc-ats-stat-icon bg-label-primary"><i class="mdi mdi-account-group-outline"></i></div><div><div class="egc-ats-stat-value" id="egcBulkTotal">—</div><div class="egc-ats-stat-label">Total Candidates</div></div></div>
                        </div>
                        <div class="col-md-3">
                            <div class="egc-ats-stat-card"><div class="egc-ats-stat-icon bg-label-warning"><i class="mdi mdi-clock-outline"></i></div><div><div class="egc-ats-stat-value" id="egcBulkPending">—</div><div class="egc-ats-stat-label">Pending ATS</div></div></div>
                        </div>
                        <div class="col-md-3">
                            <div class="egc-ats-stat-card"><div class="egc-ats-stat-icon bg-label-success"><i class="mdi mdi-briefcase-search-outline"></i></div><div><div class="egc-ats-stat-value" id="egcBulkRoles">—</div><div class="egc-ats-stat-label">Active ATS Roles</div></div></div>
                        </div>
                        <div class="col-md-3">
                            <div class="egc-ats-stat-card"><div class="egc-ats-stat-icon bg-label-info"><i class="mdi mdi-speedometer"></i></div><div><div class="egc-ats-stat-value" id="egcBulkThroughput">—</div><div class="egc-ats-stat-label">Recommended batch / request</div></div></div>
                        </div>
                    </div>

                    <div class="egc-ats-settings-card">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div>
                                <div class="fw-bold">Run configuration</div>
                                <div class="small text-muted">Each queued job analyses the candidate against the current active ATS role catalogue. The backend enforces hard safety limits.</div>
                            </div>
                            <span class="badge bg-light-primary text-primary">Queue: <span id="egcBulkQueueName">ats-role-matching</span></span>
                        </div>
                        <div class="row g-3">
                            <div class="col-lg-4">
                                <label class="form-label fw-semibold small">Applicants to analyse</label>
                                <input type="number" min="1" max="50000" class="form-control" id="egcBulkLimit" value="100">
                                <div class="form-text">Pending candidates by default. Maximum depends on server configuration.</div>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label fw-semibold small">AI batch size</label>
                                <select class="form-select" id="egcBulkBatchSize">
                                    <option value="1">1 candidate / request</option>
                                    <option value="2" selected>2 candidates / request</option>
                                    <option value="3">3 candidates / request</option>
                                </select>
                                <div class="form-text">Smaller batches give cleaner failures and easier recovery.</div>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label fw-semibold small">Concurrent workers</label>
                                <select class="form-select" id="egcBulkWorkers">
                                    <option value="1">1 worker</option>
                                    <option value="2">2 workers</option>
                                    <option value="3" selected>3 workers</option>
                                    <option value="4">4 workers</option>
                                    <option value="6">6 workers</option>
                                    <option value="8">8 workers</option>
                                </select>
                                <div class="form-text">Requires corresponding queue workers in production.</div>
                            </div>
                        </div>
                        <div class="form-check form-switch mt-3">
                            <input class="form-check-input" type="checkbox" id="egcBulkForce">
                            <label class="form-check-label" for="egcBulkForce"><strong>Force reprocess existing ATS analyses</strong><div class="small text-muted">Use this for a deliberate model/prompt refresh. It never changes the legacy AI analysis columns.</div></label>
                        </div>
                        <div class="egc-ats-warning mt-3"><i class="mdi mdi-alert-outline"></i><span>Bulk processing reads each candidate's stored resume source, uses your configured Hugging Face model and queue infrastructure. A score of 100 means maximum evidence alignment with the supplied role profile; it is not a guarantee of hiring suitability.</span></div>
                    </div>
                </div>

                <div id="egcAtsBulkProgress" class="d-none">
                    <div class="egc-ats-run-topbar mb-3">
                        <div>
                            <div class="small text-muted">ATS RUN</div>
                            <div class="fw-bold" id="egcBulkRunId">—</div>
                        </div>
                        <div class="text-end"><span class="egc-ats-live-badge"><span></span><span id="egcBulkRunStatus">Queued</span></span><div class="small text-muted mt-1" id="egcBulkHeartbeat">Waiting for workers...</div></div>
                    </div>

                    <div class="egc-ats-progress-shell mb-3">
                        <div class="d-flex justify-content-between align-items-end">
                            <div><div class="fw-bold">Overall progress</div><div class="small text-muted" id="egcBulkProgressText">Preparing queue...</div></div>
                            <div class="egc-ats-progress-percent" id="egcBulkPercent">0%</div>
                        </div>
                        <div class="progress egc-ats-progress mt-3"><div id="egcBulkProgressBar" class="progress-bar" style="width:0%"></div></div>
                        <div class="d-flex flex-wrap gap-3 small text-muted mt-2"><span>Throughput: <strong id="egcBulkRate">—</strong>/min</span><span>ETA: <strong id="egcBulkEta">—</strong></span><span>Cursor: <strong id="egcBulkCursor">0</strong></span></div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-6 col-lg-3"><div class="egc-ats-mini-stat"><div class="text-muted small">Processed</div><div class="fw-bold fs-4" id="egcBulkProcessed">0</div></div></div>
                        <div class="col-6 col-lg-3"><div class="egc-ats-mini-stat"><div class="text-muted small">Candidates with role match</div><div class="fw-bold fs-4 text-success" id="egcBulkMatched">0</div></div></div>
                        <div class="col-6 col-lg-3"><div class="egc-ats-mini-stat"><div class="text-muted small">No Suitable Role</div><div class="fw-bold fs-4 text-warning" id="egcBulkUnmatched">0</div></div></div>
                        <div class="col-6 col-lg-3"><div class="egc-ats-mini-stat"><div class="text-muted small">Failed</div><div class="fw-bold fs-4 text-danger" id="egcBulkFailed">0</div></div></div>
                    </div>

                    <div class="egc-ats-recent-card">
                        <div class="d-flex align-items-center justify-content-between border-bottom px-3 py-2"><div class="fw-bold small"><i class="mdi mdi-history me-1"></i>Recent candidates</div><div class="small text-muted" id="egcBulkWorkersLive">0 workers</div></div>
                        <div class="table-responsive"><table class="table table-sm align-middle mb-0"><thead><tr><th>Candidate</th><th>Status</th><th>Roles</th><th>Best Score</th><th>Error</th></tr></thead><tbody id="egcBulkRecentItems"><tr><td colspan="5" class="text-center py-4 text-muted">Waiting for first result...</td></tr></tbody></table></div>
                    </div>
                </div>

                <div id="egcAtsBulkComplete" class="d-none text-center py-5">
                    <div class="egc-ats-complete-icon"><i class="mdi mdi-check-circle-outline"></i></div>
                    <h3 class="fw-bold mt-3 mb-1" id="egcBulkCompleteTitle">Bulk ATS run completed</h3>
                    <p class="text-muted" id="egcBulkCompleteText">The queue run has finished.</p>
                    <div class="row g-3 justify-content-center mt-3">
                        <div class="col-6 col-lg-3"><div class="egc-ats-final-stat"><div class="value" id="egcBulkFinalProcessed">0</div><div>Processed</div></div></div>
                        <div class="col-6 col-lg-3"><div class="egc-ats-final-stat"><div class="value" id="egcBulkFinalMatched">0</div><div>With role match</div></div></div>
                        <div class="col-6 col-lg-3"><div class="egc-ats-final-stat"><div class="value" id="egcBulkFinalUnmatched">0</div><div>No suitable role</div></div></div>
                        <div class="col-6 col-lg-3"><div class="egc-ats-final-stat"><div class="value" id="egcBulkFinalFailed">0</div><div>Failed</div></div></div>
                    </div>
                </div>
            </div>

            <div class="modal-footer egc-ats-modal-footer">
                <button type="button" class="btn btn-light" id="egcBulkCloseBtn" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline-danger d-none" id="egcBulkCancelBtn"><i class="mdi mdi-stop-circle-outline me-1"></i> Stop after current batch</button>
                <button type="button" class="btn btn-primary" id="egcBulkStartBtn"><i class="mdi mdi-play-circle-outline me-1"></i> Start ATS Queue</button>
            </div>
        </div>
    </div>
</div>
@endif

<style>
    /* =========================================================
    BULK AI MATCHING
    ========================================================= */

    .bulk-ai-modal {
        border: 0;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 20px 70px rgba(0, 0, 0, .18);
    }

    .bulk-ai-header {
        background: #fff;
        border-bottom: 1px solid #edf0f4;
        padding: 18px 22px;
    }

    .bulk-ai-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #eef4ff;
        color: #ab2b22;
    }

    .bulk-ai-body {
        background: #f7f8fb;
        padding: 22px;
    }

    .bulk-ai-intro {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 14px;
        border: 1px solid #dce8ff;
        background: #f7faff;
        border-radius: 11px;
    }

    .bulk-ai-intro-icon {
        width: 30px;
        height: 30px;
        min-width: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: #e9f1ff;
        color: #ab2b22;
    }

    .bulk-stat-card {
        background: #fff;
        border: 1px solid #edf0f5;
        border-radius: 12px;
        padding: 14px;
        display: flex;
        align-items: center;
        gap: 11px;
    }

    .bulk-stat-icon {
        width: 38px;
        height: 38px;
        min-width: 38px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f1f5fb;
        color: #ab2b22;
    }

    .bulk-stat-value {
        font-size: 20px;
        font-weight: 800;
        line-height: 1.1;
    }

    .bulk-stat-label {
        color: #858c98;
        font-size: 11px;
        margin-top: 3px;
    }

    .bulk-ai-settings {
        background: #fff;
        border: 1px solid #edf0f5;
        border-radius: 13px;
        padding: 18px;
    }

    .bulk-setting-title {
        font-size: 14px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .bulk-setting-title i {
        color: #ab2b22;
        font-size: 18px;
    }

    .bulk-warning {
        display: flex;
        gap: 7px;
        align-items: flex-start;
        color: #8b6b00;
        background: #fff9e9;
        border: 1px solid #ffebae;
        border-radius: 8px;
        padding: 9px 11px;
        font-size: 11px;
    }

    .bulk-progress-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
    }

    .bulk-progress-percent {
        font-size: 24px;
        font-weight: 800;
    }

    .bulk-progress-bar {
        height: 9px;
        margin-top: 16px;
        border-radius: 20px;
        background: #e9edf3;
        overflow: hidden;
    }

    .bulk-progress-bar .progress-bar {
        border-radius: inherit;
        transition: width .4s ease;
    }

    .bulk-result-card {
        background: #fff;
        border: 1px solid #edf0f5;
        border-radius: 11px;
        padding: 14px;
        text-align: center;
    }

    .bulk-result-icon {
        font-size: 20px;
        margin-bottom: 4px;
    }

    .bulk-result-value {
        font-size: 21px;
        font-weight: 800;
    }

    .bulk-result-label {
        color: #858c98;
        font-size: 11px;
        margin-top: 2px;
    }

    .bulk-current-applicant {
        background: #fff;
        border: 1px solid #edf0f5;
        border-radius: 12px;
        padding: 14px;
    }

    .bulk-processing-spinner {
        width: 39px;
        height: 39px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #eef4ff;
    }

    .bulk-processing-spinner .spinner-border {
        width: 20px;
        height: 20px;
        color: #ab2b22;
    }

    .bulk-log-wrapper {
        border: 1px solid #e7ebf0;
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
    }

    .bulk-log-header {
        padding: 10px 13px;
        border-bottom: 1px solid #edf0f4;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 12px;
        font-weight: 700;
    }

    .bulk-ai-log {
        max-height: 170px;
        overflow-y: auto;
        padding: 8px;
    }

    .bulk-log-item {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        padding: 7px 6px;
        border-bottom: 1px solid #f2f3f5;
        font-size: 11px;
        color: #656c77;
    }

    .bulk-log-item:last-child {
        border-bottom: 0;
    }

    .bulk-log-icon {
        font-size: 16px;
    }

    .bulk-log-success .bulk-log-icon {
        color: #198754;
    }

    .bulk-log-warning .bulk-log-icon {
        color: #b58100;
    }

    .bulk-log-error .bulk-log-icon {
        color: #dc3545;
    }

    .bulk-completed-state {
        min-height: 440px;
        text-align: center;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .bulk-completed-icon {
        width: 72px;
        height: 72px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        background: #eaf8ef;
        color: #198754;
        font-size: 35px;
    }

    .bulk-final-stat {
        background: #fff;
        border: 1px solid #edf0f5;
        border-radius: 11px;
        padding: 13px;
        text-align: center;
        color: #777f8b;
        font-size: 11px;
    }

    .bulk-final-value {
        font-size: 23px;
        color: #212529;
        font-weight: 800;
        margin-bottom: 2px;
    }

    @media (max-width: 575.98px) {

        .bulk-ai-body {
            padding: 13px;
        }

        .bulk-progress-header {
            align-items: flex-start;
        }

        .bulk-progress-percent {
            font-size: 20px;
        }

    }
</style>


<!--begin::Modal view staff--->
<div class="modal fade" id="kt_modal_view_staff" tabindex="-1" aria-hidden="true" data-bs-keyboard="false" data-bs-backdrop="static" data-bs-focus="false">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-xl">
        <!--begin::Modal content-->
        <div class="modal-content rounded" style="background: linear-gradient(225deg, white 20%, #fba919 100%);">
            <!--begin::Close-->
            <div class="d-flex justify-content-end px-2 py-2">
                <div class="btn btn-sm btn-icon btn-active-color-primary rounded" style="border: 2px solid #000;" data-bs-dismiss="modal">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                    <span class="svg-icon svg-icon-1">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="#000" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="#000" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="#000" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </div>
            </div>
            <!--end::Close-->
            <!--begin::Modal header-->
            <div class="modal-header d-flex align-items-center justify-content-between border-bottom-1">
                <div class="d-flex flex-column">
                    <div class="row mb-2">
                        <div class="d-flex align-items-center mb-1">
                            <div class="avatar-stack">
                                <img src="{{ asset('assets/egc_images/auth/user_1.png') }}" alt="user-avatar" class="avatar-img" />
                                <img src="{{ asset('assets/egc_images/auth/user_2.png') }}" alt="user-avatar" class="avatar-img" />
                                <img src="{{ asset('assets/egc_images/auth/user_3.png') }}" alt="user-avatar" class="avatar-img" />
                            </div>
                        </div>
                        <h3 class="text-black">View Staff</h3>
                    </div>
                </div>
                <div class="d-flex flex-column">
                    <label class="fs-5 fw-semibold text-primary">Mahesh Kumar</label>
                    <label class="fs-6 fw-semibold text-black">9874587450</label>
                </div>
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body pt-0 pb-10 px-10 px-xl-20 bg-white">
                <input type="hidden" id="sts_change_id" name="sts_change_id" />
                <div class="row mb-3">
                    <div class="nav-align-top nav-tabs-shadow mb-3">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <button
                                    type="button"
                                    class="nav-link active"
                                    role="tab"
                                    data-bs-toggle="tab" data-bs-target="#basic_info" aria-controls="basic_info" aria-selected="true">
                                    Basic Details
                                </button>
                            </li>
                            <li class="nav-item">
                                <button
                                    type="button"
                                    class="nav-link"
                                    role="tab"
                                    data-bs-toggle="tab" data-bs-target="#contact_info" aria-controls="contact_info" aria-selected="false">
                                    Contact Details
                                </button>
                            </li>
                            <li class="nav-item">
                                <button
                                    type="button"
                                    class="nav-link" role="tab"
                                    data-bs-toggle="tab" data-bs-target="#work_info" aria-controls="work_info" aria-selected="false">
                                    Work Type
                                </button>
                            </li>
                            <li class="nav-item">
                                <button
                                    type="button"
                                    class="nav-link" role="tab"
                                    data-bs-toggle="tab" data-bs-target="#edu_info" aria-controls="edu_info" aria-selected="false">
                                    Education Details
                                </button>
                            </li>
                            <li class="nav-item">
                                <button
                                    type="button"
                                    class="nav-link" role="tab"
                                    data-bs-toggle="tab" data-bs-target="#Application" aria-controls="Application" aria-selected="false">
                                    Application Details
                                </button>
                            </li>
                            <li class="nav-item">
                                <button
                                    type="button"
                                    class="nav-link" role="tab"
                                    data-bs-toggle="tab" data-bs-target="#StaffCheckList" aria-controls="StaffCheckList" aria-selected="false">
                                    Staff Checklist
                                </button>
                            </li>
                            <li class="nav-item">
                                <button
                                    type="button"
                                    class="nav-link" role="tab"
                                    data-bs-toggle="tab" data-bs-target="#Orientation" aria-controls="Orientation" aria-selected="false">
                                    Orientation
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="basic_info" role="tabpanel">
                            <div class="row mb-2">
                                <div class="col-lg-8">
                                    <div class="row mb-2">
                                        <label class="col-5 fw-semibold fs-7 text-dark">Email Id</label>
                                        <label class="col-1 fw-semibold fs-7">:</label>
                                        <label class="col-6 fw-semibold fs-6 text-black">mahesh1602@gmail.com</label>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-5 fw-semibold fs-7 text-dark">Date Of Birth</label>
                                        <label class="col-1 fw-semibold fs-7">:</label>
                                        <label class="col-6 fw-semibold fs-6 text-black">09-Jan-2001</label>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-5 fw-semibold fs-7 text-dark">Gender</label>
                                        <label class="col-1 fw-semibold fs-7">:</label>
                                        <label class="col-6 fw-semibold fs-6 text-black">Male</label>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-5 fw-semibold fs-7 text-dark">Father Name</label>
                                        <label class="col-1 fw-semibold fs-7">:</label>
                                        <label class="col-6 fw-semibold fs-6 text-black">Saravanen</label>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-5 fw-semibold fs-7 text-dark">Father Occupation</label>
                                        <label class="col-1 fw-semibold fs-7">:</label>
                                        <label class="col-6 fw-semibold fs-6 text-black">Bank Manager</label>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-5 fw-semibold fs-7 text-dark">Mother Name</label>
                                        <label class="col-1 fw-semibold fs-7">:</label>
                                        <label class="col-6 fw-semibold fs-6 text-black">Nila</label>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-5 fw-semibold fs-7 text-dark">Mother Occupation</label>
                                        <label class="col-1 fw-semibold fs-7">:</label>
                                        <label class="col-6 fw-semibold fs-6 text-black">Developer</label>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-5 fw-semibold fs-7 text-dark">Mother Tongue</label>
                                        <label class="col-1 fw-semibold fs-7">:</label>
                                        <label class="col-6 fw-semibold fs-6 text-black">Tamil</label>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-5 fw-semibold fs-7 text-dark">Languages Known</label>
                                        <label class="col-1 fw-semibold fs-7">:</label>
                                        <label class="col-6 fw-semibold fs-6 text-black">Tamil , English</label>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-5 fw-semibold fs-7 text-dark">Marital Status</label>
                                        <label class="col-1 fw-semibold fs-7">:</label>
                                        <label class="col-6 fw-semibold fs-6 text-black">Married</label>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-5 fw-semibold fs-7 text-dark">Children</label>
                                        <label class="col-1 fw-semibold fs-7">:</label>
                                        <label class="col-6 fw-semibold fs-6 text-black">Yes, Studying 5th Grade</label>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-5 fw-semibold fs-7 text-dark">Siblings</label>
                                        <label class="col-1 fw-semibold fs-7">:</label>
                                        <label class="col-6 fw-semibold fs-6 text-black">No</label>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-5 fw-semibold fs-7 text-dark">Hobby</label>
                                        <label class="col-1 fw-semibold fs-7">:</label>
                                        <label class="col-6 fw-semibold fs-6 text-black">Drawing , Shooting ,Story Writing </label>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-5 fw-semibold fs-7 text-dark">Description</label>
                                        <label class="col-1 fw-semibold fs-7">:</label>
                                        <label class="col-6 fw-semibold fs-6 text-black">-</label>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="symbol symbol-35px me-2">
                                        <div class="image-input image-input-circle" data-kt-image-input="true">
                                            <img src="{{ asset('assets/egc_images/auth/user_2.png') }}"
                                                alt="user-avatar" class="w-px-150 h-auto rounded-circle"
                                                id="uploadedlogo" style="border: 2px solid #ab2b22;" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="row">

                                        <div class="divider text-start-center">
                                            <div class="divider-text fs-5 text-primary fw-semibold my-2">Company Details</div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">Company Details</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-black">Management</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">Department</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-black">HR Management</label>
                                            </div>
                                        </div>


                                        <div class="col-lg-6">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">Division</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-black">HR Operation</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">Job Role</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-black">HR Executive</label>
                                            </div>
                                        </div>

                                        <div class="divider text-start-center">
                                            <div class="divider-text fs-5 text-primary fw-semibold my-2">Designation Details</div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">Pseudo Name</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-black">Nick</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">Date Of Joining</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-black">07-Oct-2025</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">Basic Salary</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-danger">₹ 20,000</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">Per Hour Cost</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-danger">₹ 100</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">Skill Tag</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-black">Leadership , Management , Postive</label>
                                            </div>
                                        </div>

                                        <div class="divider text-start-center">
                                            <div class="divider-text fs-5 text-primary fw-semibold my-2">Login Credentials</div>
                                        </div>


                                        <div class="col-lg-6">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">Username</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-black">nick</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">Password</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-black">nick123</label>
                                            </div>
                                        </div>

                                        <div class="divider text-start-center">
                                            <div class="divider-text fs-5 text-primary fw-semibold my-2">Other Credentials</div>
                                        </div>

                                        <h5 class="title fw-bold mt-2 text-warning">Teams Credentials</h5>

                                        <div class="col-lg-6">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">Username</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-black">nick</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">Password</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-black">nick123</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">URL</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-black">
                                                    <a class="text-truncate max-w-150px" href="http://192.168.3.98:5080/hr_enroll/manage_staff/add_staff">-</a>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">Description</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-black">-</label>
                                            </div>

                                        </div>

                                        <h5 class="title fw-bold mt-2 text-warning">Firewall Credentials</h5>

                                        <div class="col-lg-6">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">Username</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-black">nick</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">Password</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-black">nick123</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">URL</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-black">
                                                    <a class="text-truncate max-w-150px" href="http://192.168.3.98:5080/hr_enroll/manage_staff/add_staff">-</a>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">Description</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-black">-</label>
                                            </div>

                                        </div>

                                        <h5 class="title fw-bold mt-2 text-warning">Firewall Credentials</h5>

                                        <div class="col-lg-6">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">Username</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-black">nick</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">Password</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-black">nick123</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">URL</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-black">
                                                    <a class="text-truncate max-w-150px" href="http://192.168.3.98:5080/hr_enroll/manage_staff/add_staff">-</a>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">Description</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-black">-</label>
                                            </div>

                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="contact_info" role="tabpanel">
                            <div class="row mb-2">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">Contact Person</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-black">Sibi Kumar</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">Contact Person Mobile Number</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-black">7485196785</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">Residential Address</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-black">18I Gandhi Nagar Happy Street Madurai</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">Permanent Address</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-black">122K K K Nagar D-block Madurai</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">Alternate Mobile Number</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-black">7584967821</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">Alternate Mobile Number 1</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-black">7721869435</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">Alternate Mobile Number 2</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-black">9978428965</label>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="work_info" role="tabpanel">
                            <div class="row mb-2">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">Type</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-black">Experience</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">Shifted Company Count</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-black">2</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">Total Years Of Experience</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6">
                                                    <span class="badge bg-primary text-white px-3 fs-7">3</span>
                                                </label>
                                            </div>
                                        </div>

                                        <h5 class="title fw-bold mt-2 text-warning">1st Company</h5>

                                        <div class="col-lg-6">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">Position</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-black">Developer</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">Experience Years</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-black">
                                                    <span class="badge bg-primary text-white px-3 fs-7">1</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">Company Name</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-black">TCS</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">Salary</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-danger">₹ 20,000 /-</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">Start Date</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-black">01-Oct-2021</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">End Date</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-black">18-Jul-2022</label>
                                            </div>
                                        </div>



                                        <h5 class="title fw-bold mt-2 text-warning">2nd Company</h5>

                                        <div class="col-lg-6">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">Position</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-black">Developer</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">Experience Years</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-black">
                                                    <span class="badge bg-primary text-white px-3 fs-7">2</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">Company Name</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-black">CTS</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">Salary</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-danger">₹ 15,000 /-</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">Start Date</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-black">27-Nov-2023</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">End Date</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-black">12-Feb-2024</label>
                                            </div>
                                        </div>

                                        <div class="divider text-start-center">
                                            <div class="divider-text fs-5 text-primary fw-semibold my-2">Attachment Details</div>
                                        </div>

                                        <div class="col-lg-12 d-flex align-items-center justify-content-start gap-3 flex-wrap py-3 px-1">

                                            <div class="d-flex flex-column gap-1 justify-content-center align-items-center">
                                                <label class=" fw-semibold fs-7 text-dark">Resume</label>
                                                <img src="{{ asset('assets/egc_images/auth/document.svg') }}"
                                                    style="width:100px; height:100px;" />
                                            </div>

                                            <div class="d-flex flex-column gap-1 justify-content-center align-items-center">
                                                <label class=" fw-semibold fs-7 text-dark">Aadhar card</label>
                                                <img src="{{ asset('assets/egc_images/auth/document.svg') }}"
                                                    style="width:100px; height:100px;" />
                                            </div>

                                            <div class="d-flex flex-column gap-1 justify-content-center align-items-center">
                                                <label class=" fw-semibold fs-7 text-dark">Pan Card</label>
                                                <img src="{{ asset('assets/egc_images/auth/document.svg') }}"
                                                    style="width:100px; height:100px;" />
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="edu_info" role="tabpanel">
                            <div class="row mb-2">

                                <div class="col-lg-12">
                                    <div class="row mb-2">
                                        <label class="col-3 fw-semibold fs-7 text-dark">Course Completed</label>
                                        <label class="col-1 fw-semibold fs-7">:</label>
                                        <label class="col-6 fw-semibold fs-6 text-black">Yes, Java , Python , C++ , C# , HTML , JS , CSS , REACT , SQL and Ruby</label>
                                    </div>
                                </div>


                                <div class="divider text-start-center">
                                    <div class="divider-text fs-5 text-primary fw-semibold my-2">Educational Details</div>
                                </div>

                                <h5 class="title fw-bold mt-2 text-warning text-warning">UG</h5>

                                <div class="col-lg-6">
                                    <div class="row mb-2">
                                        <label class="col-5 fw-semibold fs-7 text-dark">Qualification Type</label>
                                        <label class="col-1 fw-semibold fs-7">:</label>
                                        <label class="col-6 fw-semibold fs-6 text-black">Under Graduate</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-2">
                                        <label class="col-5 fw-semibold fs-7 text-dark">Degree</label>
                                        <label class="col-1 fw-semibold fs-7">:</label>
                                        <label class="col-6 fw-semibold fs-6">
                                            <span class="badge bg-label-danger text-danger fw-semibold fs-6 rounded">BBA</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-2">
                                        <label class="col-5 fw-semibold fs-7 text-dark">Major</label>
                                        <label class="col-1 fw-semibold fs-7">:</label>
                                        <label class="col-6 fw-semibold fs-6 text-black">Finance</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-2">
                                        <label class="col-5 fw-semibold fs-7 text-dark">University Name</label>
                                        <label class="col-1 fw-semibold fs-7">:</label>
                                        <label class="col-6 fw-semibold fs-6 text-black">MKU</label>
                                    </div>
                                </div>

                                <h5 class="title fw-bold mt-2 text-warning">PG</h5>

                                <div class="col-lg-6">
                                    <div class="row mb-2">
                                        <label class="col-5 fw-semibold fs-7 text-dark">Qualification Type</label>
                                        <label class="col-1 fw-semibold fs-7">:</label>
                                        <label class="col-6 fw-semibold fs-6 text-black">Post Graduate</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-2">
                                        <label class="col-5 fw-semibold fs-7 text-dark">Degree</label>
                                        <label class="col-1 fw-semibold fs-7">:</label>
                                        <label class="col-6 fw-semibold fs-6 ">
                                            <span class="badge bg-label-danger text-danger fw-semibold fs-6 rounded">MBA</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-2">
                                        <label class="col-5 fw-semibold fs-7 text-dark">Major</label>
                                        <label class="col-1 fw-semibold fs-7">:</label>
                                        <label class="col-6 fw-semibold fs-6 text-black">Finance And Application</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-2">
                                        <label class="col-5 fw-semibold fs-7 text-dark">University Name</label>
                                        <label class="col-1 fw-semibold fs-7">:</label>
                                        <label class="col-6 fw-semibold fs-6 text-black">SRM</label>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="tab-pane fade" id="Application" role="tabpanel">
                            <div class="row mb-2">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">Technical Position</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-black">Java , C# , .Net ,FullStack</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">Non Technical Position</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-black">Sales Management , SEO Analyst</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">Interview Attended Company</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-black">
                                                    <span class="badge bg-label-primary text-primary fw-semibold fs-6 rounded">EIBS</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">Already Attended Interview In Elysium Groups</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-black">Yes</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">Attended Date</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-black">07-10-2024 , 04-11-2024 , 12-01-2025</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">Accepted To Submit Original Certificate</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-black">Yes</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">Accepted To Travel For Official Purpose</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-black">Yes</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">Joining Status</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-black">Immediate Joining</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="row mb-2">
                                                <label class="col-5 fw-semibold fs-7 text-dark">Joining Date</label>
                                                <label class="col-1 fw-semibold fs-7">:</label>
                                                <label class="col-6 fw-semibold fs-6 text-black">07-10-2025</label>
                                            </div>
                                        </div>


                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="StaffCheckList" role="tabpanel">
                            <div class="row mb-2">
                                <div class="col-lg-12">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input checklist-item" type="checkbox" id="check1">
                                        <label class="fw-semibold fs-6 text-black" for="check1">Educational certificates verified (Degree, Diploma, Transcripts), experience/resume checked (previous employment verification)</label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input checklist-item" type="checkbox" id="check2" checked>
                                        <label class="fw-semibold fs-6 text-black" for="check2">Identity proof verified (Aadhaar, Passport, Driving License), address proof verified (Ration Card, Utility Bill),</label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input checklist-item" type="checkbox" id="check3" checked>
                                        <label class="fw-semibold fs-6 text-black" for="check3">Official documents submitted (Joining Letter, Form 16)</label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input checklist-item" type="checkbox" id="check4" checked>
                                        <label class="fw-semibold fs-6 text-black" for="check4">and alternate contact/emergency details provided (alternate mobile number, emergency contact).</label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input checklist-item" type="checkbox" id="check5">
                                        <label class="fw-semibold fs-6 text-black" for="check5">Verify identity proof, address proof, and educational certificates.</label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input checklist-item" type="checkbox" id="check6">
                                        <label class="fw-semibold fs-6 text-black" for="check6">Check previous experience/resume, submission of official documents, and provide alternate/emergency contact details.</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="Orientation" role="tabpanel">
                            <div class="row mb-2">
                                <h5 class="title fw-bold mt-2 text-warning">Staff Introduction</h5>

                                <div class="col-lg-6">
                                    <div class="row mb-2">
                                        <label class="col-5 fw-semibold fs-7 text-dark">Score</label>
                                        <label class="col-1 fw-semibold fs-7">:</label>
                                        <label class="col-6 fw-semibold fs-6 text-black">-</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-2">
                                        <label class="col-5 fw-semibold fs-7 text-dark">Department</label>
                                        <label class="col-1 fw-semibold fs-7">:</label>
                                        <label class="col-6 fw-semibold fs-6 text-black">HR Management</label>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="row mb-2">
                                        <label class="col-5 fw-semibold fs-7 text-dark">Job Role</label>
                                        <label class="col-1 fw-semibold fs-7">:</label>
                                        <label class="col-6 fw-semibold fs-6 text-black">HR Executive</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-2">
                                        <label class="col-5 fw-semibold fs-7 text-dark">Staff Name</label>
                                        <label class="col-1 fw-semibold fs-7">:</label>
                                        <label class="col-6 fw-semibold fs-6 text-black">Karthiga</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-2">
                                        <label class="col-5 fw-semibold fs-7 text-dark">Report</label>
                                        <label class="col-1 fw-semibold fs-7">:</label>
                                        <label class="col-6 fw-semibold fs-6 text-black">
                                            <img src="{{ asset('assets/egc_images/auth/document.svg') }}"
                                                style="width:70px; height:70px;" />
                                        </label>
                                    </div>
                                </div>

                                <h5 class="title fw-bold mt-2 text-warning">Company Introduction</h5>

                                <div class="col-lg-6">
                                    <div class="row mb-2">
                                        <label class="col-5 fw-semibold fs-7 text-dark">Score</label>
                                        <label class="col-1 fw-semibold fs-7">:</label>
                                        <label class="col-6 fw-semibold fs-6 text-black">-</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-2">
                                        <label class="col-5 fw-semibold fs-7 text-dark">Department</label>
                                        <label class="col-1 fw-semibold fs-7">:</label>
                                        <label class="col-6 fw-semibold fs-6 text-black">HR Management</label>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="row mb-2">
                                        <label class="col-5 fw-semibold fs-7 text-dark">Job Role</label>
                                        <label class="col-1 fw-semibold fs-7">:</label>
                                        <label class="col-6 fw-semibold fs-6 text-black">HR Executive</label>
                                    </div>
                                </div>

                                <h5 class="title fw-bold mt-2 text-warning">Department Introduction</h5>

                                <div class="col-lg-6">
                                    <div class="row mb-2">
                                        <label class="col-5 fw-semibold fs-7 text-dark">Score</label>
                                        <label class="col-1 fw-semibold fs-7">:</label>
                                        <label class="col-6 fw-semibold fs-6 text-black">-</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-2">
                                        <label class="col-5 fw-semibold fs-7 text-dark">Department</label>
                                        <label class="col-1 fw-semibold fs-7">:</label>
                                        <label class="col-6 fw-semibold fs-6 text-black">HR Management</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-2">
                                        <label class="col-5 fw-semibold fs-7 text-dark">Staff Name</label>
                                        <label class="col-1 fw-semibold fs-7">:</label>
                                        <label class="col-6 fw-semibold fs-6 text-black">Karthiga</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-2">
                                        <label class="col-5 fw-semibold fs-7 text-dark">Report</label>
                                        <label class="col-1 fw-semibold fs-7">:</label>
                                        <label class="col-6 fw-semibold fs-6 text-black">
                                            <img src="{{ asset('assets/egc_images/auth/document.svg') }}"
                                                style="width:70px; height:70px;" />
                                        </label>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - view staff-->


<!-- ai analyses -->
<div class="modal fade" id="kt_modal_ai_analyses_applicant" tabindex="-1" aria-hidden="true" data-bs-keyboard="false" data-bs-backdrop="static" data-bs-focus="false">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-xl">
        <!--begin::Modal content-->
        <div class="modal-content rounded">
            <!--begin::Modal header-->
            <div class="modal-header justify-content-end border-0 pb-0">
                <!--begin::Close-->
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                    <span class="svg-icon svg-icon-1">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body pt-0 pb-10 px-10 px-xl-20">
                <!--begin::Heading-->
                <div class="mb-4">
                    <h3 class="mb-4 text-dark text-center fw-bold modal-title-ai">
                        AI Candidate Intelligence
                    </h3>
                    <p class="text-center text-muted small ai-subtitle">
                        Smart resume evaluation powered by AI-driven hiring insights
                    </p>
                </div>
                <input type="hidden" name="" id="applicant_id_hidden">
                <div class="card mb-4 shadow-sm border-1 border-primary">
                    <div class="card-body d-flex align-items-center gap-4">

                        <div class="avatar bg-label-primary rounded-circle text-center m-0 p-0">
                            <i class="mdi mdi-account fs-2 mb-0 p-0 text-primary"></i>
                        </div>

                        <div class="flex-grow-1">
                            <h5 id="cand_name" class="mb-1 fw-bold"></h5>
                            <div class="text-muted small">
                                <span id="cand_email"></span> •
                                <span id="cand_mobile"></span>
                            </div>
                            <div class="mt-1">
                                <span class="badge bg-light-info text-dark" id="cand_exp"></span>
                                <span class="badge bg-light-success text-dark" id="cand_qualification"></span>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-4 mb-2">
                        <label class="text-black mb-1 fs-6 fw-semibold">Company Name<span class="text-danger">*</span></label>
                        <select id="company_fill" name="company_fill" class="select3 form-select" onchange="company_change_func()">
                            <option value="">Select Company Name</option>
                            <option value="egc">Elysium Groups</option>
                            @if(isset($company_list))
                            @foreach($company_list as $clist)
                            <option value="{{$clist->sno}}">{{$clist->company_name}}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-lg-4 mb-2" id="business_div">
                        <label class="text-black mb-1 fs-6 fw-semibold">Entity Name<span class="text-danger">*</span></label>
                        <select id="entity_fill" name="entity_fill" class="select3 form-select" onchange="entity_change_func()">
                            <option value="">Select Entity Name</option>
                        </select>
                    </div>
                    <div class="col-lg-4 mb-3">
                        <label class="text-dark mb-1 fs-6 fw-semibold">Job Role Name<span class="text-danger">*</span></label>
                        <select id="job_role_name" name="job_role_name" class="select3 form-select">
                            <option value="">Select Job Role</option>

                        </select>
                        <div class="text-danger" id="job_role_name_err"></div>
                    </div>

                    <div class="col-lg-12 mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <label class="text-dark mb-1 fs-6 fw-semibold">AI Analyse Preview<span class="text-danger">*</span></label>
                            <button type="button" id="aiBtn"
                                class="btn btn-sm btn-light-primary border rounded-pill px-3 fw-bold shadow-sm mb-1"
                                onclick="generateAiAnalyse()">
                                <span class="d-flex justify-content-center align-items-center gap-1">
                                    <i class="mdi mdi-robot-outline"></i>
                                    <span>AI</span>
                                </span>

                            </button>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <div id="ai_analyses_div" class="mt-3"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>



<div class="modal fade" id="kt_modal_vip_candidate" tabindex="-1" aria-hidden="true" data-bs-keyboard="false"
    data-bs-backdrop="static" data-bs-focus="false">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-xl">
        <!--begin::Modal content-->
        <div class="modal-content rounded" style="background: linear-gradient(225deg, white 20%, #fba919 100%);">
            <!--begin::Close-->
            <div class="d-flex justify-content-end px-2 py-2">
                <div class="btn btn-sm btn-icon btn-active-color-primary rounded" style="border: 2px solid #000;"
                    data-bs-dismiss="modal">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                    <span class="svg-icon svg-icon-1">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="#000"
                            xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                transform="rotate(-45 6 17.3137)" fill="#000" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                transform="rotate(45 7.41422 6)" fill="#000" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </div>
            </div>
            <!--end::Close-->
            <!--begin::Modal header-->
            <div class="modal-header d-flex align-items-center justify-content-between border-bottom-1">
                <div class="d-flex flex-column">
                    <div class="row mb-2">
                        <h3 class="text-black">⭐ Assign VIP Candidate</h3>
                    </div>
                </div>
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body pt-0 pb-10 px-10 px-xl-20 bg-white ">
                <div id="vip_loader" class="text-center py-5">
                    <div class="spinner-border text-warning"></div>
                    <div class="mt-3">
                        Loading Candidate Details...
                    </div>
                </div>
                <div class="row mb-2 mt-2">
                    
                    <div id="vip_content" class="d-none">
                        <div class="vip-profile-card">
                            <div class="d-flex align-items-center">

                                <div class="vip-avatar" id="vip_avatar">
                                    V
                                </div>

                                <div class="flex-grow-1 ms-4">

                                    <div class="d-flex align-items-center flex-wrap gap-2">

                                        <h3 class="mb-0 fw-bold" id="vip_name"></h3>
                                        <span id="vip_qualification_badge"></span>

                                    </div>

                                    <div class="mt-2">

                                        <span class="badge bg-label-primary me-2">
                                            ID : <span id="vip_applicant_id"></span>
                                        </span>

                                        <span class="badge bg-label-success me-2">
                                            <i class="mdi mdi-phone"></i>
                                            <span id="vip_mobile"></span>
                                        </span>

                                        <span class="badge bg-label-info me-2">
                                            <i class="mdi mdi-email"></i>
                                            <span id="vip_email"></span>
                                        </span>

                                    </div>

                                    <div class="row mt-3">

                                        <div class="col-lg-3">
                                            <small class="text-muted">Gender</small>
                                            <div class="fw-bold" id="vip_gender"></div>
                                        </div>

                                        <div class="col-lg-3">
                                            <small class="text-muted">Experience</small>
                                            <div class="fw-bold" id="vip_experience"></div>
                                        </div>

                                        <div class="col-lg-3">
                                            <small class="text-muted">Major</small>
                                            <div class="fw-bold" id="vip_major"></div>
                                        </div>

                                        <div class="col-lg-3">
                                            <small class="text-muted">Source</small>
                                            <div class="fw-bold" id="vip_source"></div>
                                        </div>

                                    </div>

                                </div>

                            </div>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label class="form-label fw-bold">VIP Remarks</label>
                            <textarea class="form-control" id="vip_remarks" rows="4" placeholder="Why is this candidate considered VIP?" ></textarea>
                        </div>

                    </div>
                    
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary" id="saveVipBtn">
                            <i class="mdi mdi-star"></i>Mark As VIP
                        </button>
                    </div>
                    
                </div>

            </div>
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>

<div class="modal fade" id="candidateHistoryModal" tabindex="-1" aria-hidden="true" data-bs-keyboard="false"
    data-bs-backdrop="static" data-bs-focus="false">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-xl">
        <!--begin::Modal content-->
        <div class="modal-content rounded" style="background: linear-gradient(225deg, white 20%, #fba919 100%);">
            <!--begin::Close-->
            <div class="d-flex justify-content-end px-2 py-2">
                <div class="btn btn-sm btn-icon btn-active-color-primary rounded" style="border: 2px solid #000;"
                    data-bs-dismiss="modal">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                    <span class="svg-icon svg-icon-1">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="#000"
                            xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                transform="rotate(-45 6 17.3137)" fill="#000" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                transform="rotate(45 7.41422 6)" fill="#000" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </div>
            </div>
            <!--end::Close-->
            <!--begin::Modal header-->
            <div class="modal-header d-flex align-items-center justify-content-between border-bottom-1">
                <div class="d-flex flex-column">
                    <div class="row mb-2">
                        <h3 class="text-black">Candidate Recruitment Update</h3>
                    </div>
                </div>
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body pt-0 pb-10 px-10 px-xl-20 bg-white ">
                <input type="hidden" id="history_applicant_id">
                <div id="history_loader" class="text-center py-5">
                    <div class="spinner-border text-warning"></div>
                    <div class="mt-3">
                        Loading Candidate Details...
                    </div>
                </div>
                <div class="row mb-2 mt-2">
                    
                    <div id="history_content" class="d-none">
                        <div class="history-profile-card">
                            <div class="d-flex align-items-center">
                                <div class="history-avatar" id="history_avatar">
                                    V
                                </div>

                                <div class="flex-grow-1 ms-4">
                                    <div class="d-flex align-items-center flex-wrap gap-2">
                                        <h3 class="mb-0 fw-bold" id="history_name"></h3>
                                        <span id="history_qualification_badge"></span>

                                    </div>

                                    <div class="mt-2">
                                        <span class="badge bg-label-primary me-2">
                                            ID : <span id="history_applicant_id"></span>
                                        </span>

                                        <span class="badge bg-label-success me-2">
                                            <i class="mdi mdi-phone"></i>
                                            <span id="history_mobile"></span>
                                        </span>

                                        <span class="badge bg-label-info me-2">
                                            <i class="mdi mdi-email"></i>
                                            <span id="history_email"></span>
                                        </span>

                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-lg-3">
                                            <small class="text-muted">Gender</small>
                                            <div class="fw-bold" id="history_gender"></div>
                                        </div>

                                        <div class="col-lg-3">
                                            <small class="text-muted">Experience</small>
                                            <div class="fw-bold" id="history_experience"></div>
                                        </div>

                                        <div class="col-lg-3">
                                            <small class="text-muted">Major</small>
                                            <div class="fw-bold" id="history_major"></div>
                                        </div>

                                        <div class="col-lg-3">
                                            <small class="text-muted">Source</small>
                                            <div class="fw-bold" id="history_source"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label"> Interview Date <span class="text-danger">*</span></label>
                            <input type="text" id="interview_date" class="form-control interviewdate_datepicker" placeholder="Select Interview Date" readonly>
                            <div id="interview_date_err" class="text-danger"></div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label"> Status<span class="text-danger">*</span></label>

                            <select id="applicant_status"  class="form-select select3" onchange="applicant_status_change()">
                                <option value="">Select Status</option>
                                <!-- <option value="Interview Attended">Interview Attended</option> -->
                                <option value="Selected">Selected</option>
                                <option value="Rejected">Rejected</option>
                                <option value="On Hold">On Hold</option>
                                <option value="Critical">Critical</option>
                                <option value="Not Joined">Not Joined</option>
                                <!-- <option value="Offer Released">Offer Released</option>
                                <option value="Offer Accepted">Offer Accepted</option>
                                <option value="Offer Rejected">Offer Rejected</option>
                                <option value="Joined">Joined</option> -->
                            </select>
                            <div id="applicant_status_err" class="text-danger"></div>
                        </div>

                  
                    </div>

                     <div id="selectedSection" class="row mt-3 d-none">
                        <div class="col-md-4">
                            <label>Selected Date</label>
                            <input type="text" id="selected_date" class="form-control common_datepicker" placeholder="Selected Date" readonly >
                        </div>

                        <div class="col-md-4">
                            <label>Entity</label>
                            <select id="selected_company"  class="form-select select3" onchange="histry_entity_change()">
                                <option value="" >Select Entity</option>
                                <option value="egc" >Elysium Groups</option>
                                @if(isset($entity_list))
                                    @foreach($entity_list as $elist)
                                        <option value="{{$elist->sno}}" >{{$elist->entity_name}}</option>
                                    @endforeach
                                @endif

                            </select>
                        </div>

                        <div class="col-md-4">
                            <label>Job Role</label>
                            <select id="selected_job_role" class="form-select select3">
                            </select>
                        </div>

                        <!-- <div class="col-md-4 mt-3">
                            <label>Expected Salary</label>
                            <input type="text" id="expected_salary" class="form-control">
                        </div>

                        <div class="col-md-4 mt-3">
                            <label>Offered Salary</label>
                            <input type="text" id="offered_salary" class="form-control">
                        </div>
                        <div class="col-md-4 mt-3">
                            <label>Joining Date</label>
                            <input type="text" id="joining_date" class="form-control common_datepicker">
                        </div> -->
                    </div>

                    <div class="mt-3 mb-2">
                        <label>Remarks</label>
                        <textarea id="history_remarks" rows="4" class="form-control" placeholder="Enter remarks">
                        </textarea>
                    </div>

                    <hr>

                    <h5>
                        Recruitment Timeline
                    </h5>

                    <div id="historyTimeline"></div>
                    
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary" id="saveHistoryBtn">
                            Update Candidate
                        </button>
                    </div>
                    
                </div>

            </div>
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>






{{-- =========================================================
     APPLICANT AI ANALYSIS MODAL
========================================================= --}}
@if($canUseAtsRoleMatching)
<div class="modal fade egc-ats-modal" id="kt_modal_ai_analyses_individual" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="true">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
        <div class="modal-content egc-ats-individual-modal">
            <div class="modal-header egc-ats-modal-header">
                <div class="d-flex align-items-center gap-3 min-w-0">
                    <div class="egc-ats-head-icon"><i class="mdi mdi-file-account-outline"></i></div>
                    <div class="min-w-0">
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <h4 class="mb-0 fw-bold">AI ATS Role Matching</h4>
                            <span class="egc-ats-access-badge"><i class="mdi mdi-shield-account-outline me-1"></i>Private ATS Console</span>
                        </div>
                        <div class="small text-muted mt-1">Deep resume analysis against every active, ATS-enabled company role.</div>
                    </div>
                </div>
                <button type="button" class="btn btn-icon btn-sm btn-light" data-bs-dismiss="modal" aria-label="Close"><i class="mdi mdi-close fs-5"></i></button>
            </div>

            <div class="modal-body egc-ats-individual-body">
                <div id="egcAtsIndividualLoading" class="egc-ats-state">
                    <div class="egc-ats-loader-ring"><span class="spinner-border"></span></div>
                    <h5 class="fw-bold mt-3 mb-1">Loading ATS profile</h5>
                    <p class="text-muted small mb-0">Reading the candidate and checking the latest saved ATS analysis.</p>
                </div>

                <div id="egcAtsIndividualError" class="egc-ats-state d-none">
                    <div class="egc-ats-state-icon error"><i class="mdi mdi-alert-circle-outline"></i></div>
                    <h5 class="fw-bold mt-3 mb-1">ATS analysis unavailable</h5>
                    <p class="text-muted small mb-3" id="egcAtsIndividualErrorText">Unable to load ATS analysis.</p>
                    <button type="button" class="btn btn-primary" id="egcAtsRetryBtn"><i class="mdi mdi-refresh me-1"></i> Try again</button>
                </div>

                <div id="egcAtsIndividualContent" class="d-none">
                    <div class="egc-ats-candidate-hero mb-3">
                        <div class="d-flex justify-content-between gap-3 align-items-start flex-wrap">
                            <div class="d-flex gap-3 align-items-center min-w-0">
                                <div class="egc-ats-avatar" id="egcAtsAvatar">A</div>
                                <div class="min-w-0">
                                    <div class="d-flex gap-2 align-items-center flex-wrap"><h3 class="mb-0 fw-bold text-truncate" id="egcAtsCandidateName">Candidate</h3><span class="badge rounded-pill bg-light-success text-success" id="egcAtsCandidateState">ATS Ready</span><span class="badge rounded-pill bg-light-warning text-warning d-none" id="egcAtsStaleBadge">Role catalogue changed</span></div>
                                    <div class="small text-muted mt-1" id="egcAtsCandidateMeta">—</div>
                                    <div class="d-flex flex-wrap gap-2 mt-2"><span class="egc-ats-chip"><i class="mdi mdi-file-document-outline me-1"></i><span id="egcAtsSourceLabel">Candidate resume</span></span><span class="egc-ats-chip"><i class="mdi mdi-text-box-outline me-1"></i><span id="egcAtsResumeChars">0</span> chars</span><span class="egc-ats-chip"><i class="mdi mdi-fingerprint me-1"></i><span id="egcAtsAnalysisId">#—</span></span></div>
                                </div>
                            </div>
                            <div class="text-end"><div class="small text-muted">Best role match</div><div class="egc-ats-hero-score" id="egcAtsBestScore">0%</div><div class="small text-muted" id="egcAtsMatchLabel">No accepted role</div></div>
                        </div>
                    </div>

                    <div class="egc-ats-source-card mb-3">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3"><div><div class="fw-bold"><i class="mdi mdi-file-refresh-outline me-1 text-primary"></i> Resume source</div><div class="small text-muted">Choose a source for this analysis. Stored uses the candidate's existing resume_text / Drive / attachment.</div></div><button class="btn btn-sm btn-light-primary" type="button" id="egcAtsReanalyseBtn"><i class="mdi mdi-refresh me-1"></i> Re-analyse</button></div>
                        <div class="egc-ats-source-pills" id="egcAtsSourcePills">
                            <button type="button" class="active" data-source="stored"><i class="mdi mdi-database-outline"></i><span>Candidate Record</span></button>
                            <button type="button" data-source="public_path"><i class="mdi mdi-folder-open-outline"></i><span>Public Path</span></button>
                            <button type="button" data-source="drive_link"><i class="mdi mdi-google-drive"></i><span>Drive Link</span></button>
                            <button type="button" data-source="resume_text"><i class="mdi mdi-text-box-outline"></i><span>Resume Text</span></button>
                        </div>
                        <div class="mt-3" id="egcAtsSourceFields">
                            <div id="egcAtsFieldPublicPath" class="d-none"><label class="form-label small fw-semibold">Server public path</label><input type="text" class="form-control" id="egcAtsPublicPath" placeholder="job_applications/resume_files/resume.pdf"><div class="form-text">Only files inside Laravel's public directory are accepted. Remote URLs are intentionally not fetched.</div></div>
                            <div id="egcAtsFieldDrive" class="d-none"><label class="form-label small fw-semibold">Google Drive file link</label><input type="text" class="form-control" id="egcAtsDriveLink" placeholder="https://drive.google.com/file/d/FILE_ID/view"><div class="form-text">The Drive file must be accessible to the configured service account/refresh-token account and be a supported resume document.</div></div>
                            <div id="egcAtsFieldText" class="d-none"><label class="form-label small fw-semibold">Resume text</label><textarea class="form-control" rows="7" id="egcAtsResumeText" maxlength="30000" placeholder="Paste the resume text here..."></textarea><div class="d-flex justify-content-between small text-muted mt-1"><span>Evidence-based parsing is used.</span><span id="egcAtsTextCount">0 / 30000</span></div></div>
                        </div>
                        <div class="form-check form-switch mt-3"><input class="form-check-input" type="checkbox" id="egcAtsSaveResume"><label class="form-check-label small" for="egcAtsSaveResume"><strong>Save this source as the candidate resume text</strong><span class="text-muted d-block">Recommended for manual public-path / Drive / pasted-text corrections.</span></label></div>
                    </div>

                    <div id="egcAtsNoAnalysis" class="d-none">
                        <div class="egc-ats-empty-analysis"><div class="egc-ats-state-icon"><i class="mdi mdi-robot-outline"></i></div><h5 class="fw-bold mt-3 mb-1">No ATS analysis yet</h5><p class="text-muted small mb-3">Start an evidence-based role matching run for this candidate.</p><button type="button" class="btn btn-primary" id="egcAtsAnalyseBtn"><i class="mdi mdi-robot-outline me-1"></i> Analyse Resume</button></div>
                    </div>

                    <div id="egcAtsAnalysisResult" class="d-none">
                        <div class="row g-3 mb-3">
                            <div class="col-xl-3 col-md-6"><div class="egc-ats-score-card primary"><div class="label">Best Role Match</div><div class="score" id="egcScoreOverall">0%</div><div class="bar"><span id="egcScoreOverallBar"></span></div></div></div>
                            <div class="col-xl-3 col-md-6"><div class="egc-ats-score-card"><div class="label">Resume Quality</div><div class="score" id="egcScoreResume">0%</div><div class="bar"><span id="egcScoreResumeBar"></span></div></div></div>
                            <div class="col-xl-3 col-md-6"><div class="egc-ats-score-card"><div class="label">Skills Alignment</div><div class="score" id="egcScoreSkills">0%</div><div class="bar"><span id="egcScoreSkillsBar"></span></div></div></div>
                            <div class="col-xl-3 col-md-6"><div class="egc-ats-score-card"><div class="label">Experience Relevance</div><div class="score" id="egcScoreExperience">0%</div><div class="bar"><span id="egcScoreExperienceBar"></span></div></div></div>
                        </div>

                        <div class="d-flex justify-content-between align-items-end mb-2"><div><h5 class="fw-bold mb-1"><i class="mdi mdi-briefcase-search-outline me-1 text-primary"></i> Role matches</h5><div class="small text-muted">Every accepted role is independently validated. Multiple roles are allowed.</div></div><span class="badge bg-light-primary text-primary" id="egcAtsMatchCountBadge">0 roles</span></div>
                        <div id="egcAtsRoleMatches" class="egc-ats-role-list mb-3"></div>

                        <div class="row g-3">
                            <div class="col-lg-6"><div class="egc-ats-insight-card h-100"><div class="title"><i class="mdi mdi-account-tie-outline"></i> Candidate profile</div><div class="item"><span>Current designation</span><strong id="egcProfileDesignation">—</strong></div><div class="item"><span>Experience</span><strong id="egcProfileExperience">—</strong></div><div class="item"><span>Seniority assessment</span><strong id="egcProfileSeniority">—</strong></div><div class="item"><span>Education</span><strong id="egcProfileEducation">—</strong></div><div class="item"><span>Previous designations</span><div id="egcProfilePrevious" class="egc-ats-tag-wrap"></div></div><div class="item"><span>Professional domains</span><div id="egcProfileDomains" class="egc-ats-tag-wrap"></div></div></div></div>
                            <div class="col-lg-6"><div class="egc-ats-insight-card h-100"><div class="title"><i class="mdi mdi-chart-box-outline"></i> ATS quality signals</div><div class="item"><span>ATS keyword score</span><strong id="egcScoreKeywords">0%</strong></div><div class="item"><span>Impact / achievements</span><strong id="egcScoreImpact">0%</strong></div><div class="item"><span>Responsibility match</span><strong id="egcScoreResponsibility">0%</strong></div><div class="item"><span>Accepted roles</span><strong id="egcAcceptedRoles">0</strong></div><div class="item"><span>Near matches</span><strong id="egcNearRoles">0</strong></div></div></div>
                        </div>

                        <div class="egc-ats-summary-card mt-3"><div class="d-flex justify-content-between align-items-center mb-2"><div class="title"><i class="mdi mdi-account-details-outline me-1 text-primary"></i> Candidate summary</div></div><div id="egcCandidateSummary" class="small text-muted"></div></div>

                        <div class="row g-3 mt-1">
                            <div class="col-lg-6"><div class="egc-ats-list-card"><div class="title"><i class="mdi mdi-check-decagram-outline text-success"></i> Strengths</div><div id="egcStrengths" class="egc-ats-bullet-list"></div></div></div>
                            <div class="col-lg-6"><div class="egc-ats-list-card"><div class="title"><i class="mdi mdi-alert-circle-outline text-warning"></i> Gaps / weaknesses</div><div id="egcWeaknesses" class="egc-ats-bullet-list"></div></div></div>
                            <div class="col-lg-6"><div class="egc-ats-list-card"><div class="title"><i class="mdi mdi-key-outline text-primary"></i> Missing keywords</div><div id="egcMissingKeywords" class="egc-ats-tag-wrap"></div></div></div>
                            <div class="col-lg-6"><div class="egc-ats-list-card"><div class="title"><i class="mdi mdi-lightbulb-on-outline text-info"></i> Resume improvements</div><div id="egcResumeImprovements" class="egc-ats-bullet-list"></div></div></div>
                            <div class="col-12"><div class="egc-ats-list-card"><div class="title"><i class="mdi mdi-database-alert-outline text-warning"></i> Data quality notes</div><div id="egcDataQualityNotes" class="egc-ats-bullet-list"></div></div></div>
                        </div>

                        <div class="egc-ats-summary-card mt-3"><div class="d-flex justify-content-between align-items-center mb-2"><div class="title"><i class="mdi mdi-text-box-check-outline me-1 text-primary"></i> Optimized summary</div><button type="button" class="btn btn-sm btn-light" id="egcCopySummaryBtn"><i class="mdi mdi-content-copy me-1"></i> Copy</button></div><div id="egcOptimizedSummary" class="small text-muted"></div></div>

                        <div class="egc-ats-near-card mt-3"><button type="button" class="egc-ats-collapse-button" id="egcNearMatchesToggle" aria-expanded="false"><span><i class="mdi mdi-eye-outline me-1"></i> Near matches / lower-confidence roles</span><i class="mdi mdi-chevron-down"></i></button><div id="egcNearMatches" class="d-none pt-2"></div></div>

                        <div class="egc-ats-meta-card mt-3"><div><span>Engine</span><strong id="egcMetaEngine">—</strong></div><div><span>Model</span><strong id="egcMetaModel">—</strong></div><div><span>Schema</span><strong id="egcMetaSchema">—</strong></div><div><span>Roles evaluated</span><strong id="egcMetaRoleCatalogSize">—</strong></div><div><span>Semantic candidates</span><strong id="egcMetaRetrievedRoleCount">—</strong></div><div><span>Data confidence</span><strong id="egcMetaCandidateConfidence">—</strong></div><div><span>Review</span><strong id="egcMetaReview">—</strong></div><div><span>Processed</span><strong id="egcMetaProcessed">—</strong></div></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer egc-ats-modal-footer"><div class="small text-muted me-auto" id="egcAtsFooterHint">ATS result is stored separately from legacy candidate AI data.</div><button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button></div>
        </div>
    </div>
</div>
@endif

<style>
    /* =========================================================
    APPLICANT AI ANALYSIS
    ========================================================= */

    .applicant-ai-modal {
        border: 0;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 20px 70px rgba(0, 0, 0, .18);
    }

    .applicant-ai-header {
        padding: 18px 22px;
        border-bottom: 1px solid #eef0f4;
        background: #fff;
    }

    .applicant-ai-header-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(13, 110, 253, .10);
        color: #ab2b22;
    }

    .applicant-ai-body {
        background: #f7f8fb;
        padding: 22px;
    }

    .applicant-ai-candidate-card {
        background: #fff;
        border: 1px solid #edf0f5;
        border-radius: 14px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .025);
    }

    .ai-applicant-avatar {
        width: 58px;
        height: 58px;
        min-width: 58px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 21px;
        font-weight: 700;
        background: #eef4ff;
        color: #ab2b22;
    }

    .ai-overall-score-wrapper {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 15px;
    }

    .ai-overall-score {
        font-size: 31px;
        line-height: 1;
        font-weight: 800;
    }

    .ai-score-ring {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background:
            conic-gradient(
                #ab2b22 0deg,
                #ab2b22 var(--score-angle, 0deg),
                #e9edf3 var(--score-angle, 0deg),
                #e9edf3 360deg
            );
        position: relative;
    }

    .ai-score-ring::before {
        content: "";
        position: absolute;
        inset: 6px;
        background: #fff;
        border-radius: 50%;
    }

    .ai-score-ring span {
        position: relative;
        z-index: 1;
        font-size: 13px;
        font-weight: 700;
    }


    /* =========================================================
    SCORE CARDS
    ========================================================= */

    .ai-score-card {
        background: #fff;
        border: 1px solid #edf0f5;
        border-radius: 13px;
        padding: 15px;
        min-height: 112px;
        transition: .2s ease;
    }

    .ai-score-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 7px 20px rgba(0, 0, 0, .06);
    }

    .ai-score-card-icon {
        width: 34px;
        height: 34px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f0f5ff;
        color: #ab2b22;
        margin-bottom: 8px;
    }

    .ai-score-value {
        font-size: 23px;
        font-weight: 800;
        line-height: 1.1;
    }

    .ai-score-label {
        margin-top: 4px;
        color: #7b8190;
        font-size: 12px;
        font-weight: 600;
    }


    /* =========================================================
    SECTIONS
    ========================================================= */

    .ai-section {
        background: #fff;
        border: 1px solid #edf0f5;
        border-radius: 14px;
        padding: 19px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .02);
    }

    .ai-section-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 15px;
        margin-bottom: 15px;
    }

    .ai-section-title {
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 700;
        font-size: 15px;
    }

    .ai-section-title i {
        font-size: 19px;
        color: #ab2b22;
    }

    .ai-section-subtitle {
        color: #8a909c;
        font-size: 12px;
        margin-top: 4px;
    }


    /* =========================================================
    ROLE MATCHES
    ========================================================= */

    .ai-role-matches {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .ai-role-card {
        border: 1px solid #e9edf3;
        border-radius: 12px;
        padding: 15px;
        transition: .2s ease;
    }

    .ai-role-card:hover {
        border-color: #b9d1ff;
        background: #fbfdff;
    }

    .ai-role-card-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 15px;
    }

    .ai-role-name {
        font-weight: 700;
        font-size: 15px;
    }

    .ai-role-id {
        color: #89909d;
        font-size: 11px;
        margin-top: 2px;
    }

    .ai-role-confidence {
        min-width: 65px;
        text-align: center;
        padding: 6px 9px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 800;
    }

    .ai-confidence-high {
        background: #e8f7ee;
        color: #198754;
    }

    .ai-confidence-medium {
        background: #fff5dc;
        color: #9a6700;
    }

    .ai-confidence-low {
        background: #fdeaea;
        color: #dc3545;
    }

    .ai-role-progress {
        height: 5px;
        margin-top: 12px;
        background: #edf0f4;
        border-radius: 10px;
        overflow: hidden;
    }

    .ai-role-progress-bar {
        height: 100%;
        border-radius: inherit;
        transition: width .5s ease;
    }

    .ai-role-reason {
        margin-top: 11px;
        color: #656c78;
        font-size: 13px;
        line-height: 1.6;
    }


    /* =========================================================
    NO ROLE
    ========================================================= */

    .ai-no-role-match {
        display: flex;
        align-items: center;
        gap: 13px;
        padding: 15px;
        border-radius: 11px;
        background: #fafbfc;
        border: 1px dashed #dfe3e9;
    }

    .ai-no-role-match > i {
        font-size: 27px;
        color: #8c94a2;
    }


    /* =========================================================
    BULLET LISTS
    ========================================================= */

    .ai-bullet-list {
        margin-top: 12px;
    }

    .ai-bullet-item {
        position: relative;
        padding-left: 25px;
        margin-bottom: 11px;
        color: #5f6672;
        font-size: 13px;
        line-height: 1.6;
    }

    .ai-bullet-item::before {
        content: "";
        position: absolute;
        left: 2px;
        top: 8px;
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #ab2b22;
    }

    .ai-bullet-item:last-child {
        margin-bottom: 0;
    }


    /* =========================================================
    KEYWORDS
    ========================================================= */

    .ai-keyword-list {
        display: flex;
        flex-wrap: wrap;
        gap: 7px;
        margin-top: 13px;
    }

    .ai-keyword {
        padding: 6px 10px;
        border-radius: 7px;
        background: #fff4e5;
        color: #a35d00;
        border: 1px solid #ffe1b7;
        font-size: 12px;
        font-weight: 600;
    }


    /* =========================================================
    SUMMARY
    ========================================================= */

    .ai-summary-box {
        margin-top: 13px;
        background: #f8faff;
        border-left: 4px solid #ab2b22;
        border-radius: 8px;
        padding: 15px;
        color: #505865;
        font-size: 13px;
        line-height: 1.7;
    }


    /* =========================================================
    REWRITTEN BULLETS
    ========================================================= */

    .ai-rewritten-bullets {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-top: 13px;
    }

    .ai-rewritten-item {
        background: #fafbfc;
        border: 1px solid #edf0f5;
        border-radius: 10px;
        padding: 13px;
        color: #555d69;
        font-size: 13px;
        line-height: 1.65;
    }

    .ai-rewritten-number {
        display: inline-flex;
        width: 25px;
        height: 25px;
        align-items: center;
        justify-content: center;
        border-radius: 7px;
        background: #eef4ff;
        color: #ab2b22;
        font-weight: 700;
        margin-right: 7px;
    }


    /* =========================================================
    STATES
    ========================================================= */

    .applicant-ai-state {
        min-height: 440px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
    }

    .applicant-ai-loader {
        width: 65px;
        height: 65px;
        border-radius: 16px;
        background: #eef4ff;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .applicant-ai-loader .spinner-border {
        width: 28px;
        height: 28px;
        color: #ab2b22;
    }

    .applicant-ai-error-icon,
    .applicant-ai-empty-icon {
        width: 68px;
        height: 68px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 31px;
    }

    .applicant-ai-error-icon {
        background: #fff0f0;
        color: #dc3545;
    }

    .applicant-ai-empty-icon {
        background: #f0f2f5;
        color: #747b88;
    }


    /* =========================================================
    FOOTER
    ========================================================= */

    .ai-analysis-footer {
        display: flex;
        justify-content: space-between;
        gap: 15px;
        color: #8b929e;
        font-size: 11px;
        padding: 3px 2px;
    }


    /* =========================================================
    RESPONSIVE
    ========================================================= */

    @media (max-width: 767.98px) {

        .applicant-ai-body {
            padding: 13px;
        }

        .ai-overall-score-wrapper {
            justify-content: flex-start;
            margin-top: 5px;
        }

        .ai-section {
            padding: 15px;
        }

        .ai-section-header {
            flex-direction: column;
        }

        .ai-role-card-top {
            flex-direction: column;
        }

        .ai-analysis-footer {
            flex-direction: column;
        }
    }
</style>



<div class="modal fade" id="applicantDetailedAiModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-fullscreen-xl-down modal-xl">
        <div class="modal-content applicant-modal">
            <!-- Header -->
            <div class="modal-header border-0 shadow-sm">
                <div>
                    <h3 class="mb-4 fw-bold">
                        Applicant Analysis
                    </h3>
                    
                </div>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <!-- Body -->
            <div class="modal-body p-0">
                
                <div class="row g-0">
                    <!-- LEFT -->
                    <div class="col-lg-4 applicant-sidebar">
                        <div id="candidateProfile"></div>
                        
                    </div>
                    <!-- RIGHT -->
                    <div class="col-lg-8">
                        <!-- Tabs -->
                        <ul class="nav nav-pills applicant-tabs">

                            <li class="nav-item">
                                <button
                                    class="nav-link active"
                                    data-bs-toggle="pill"
                                    data-bs-target="#overviewTab">
                                    <i class="mdi mdi-view-dashboard-outline me-1"></i>
                                    Overview
                                </button>
                            </li>

                            <li class="nav-item">
                                <button
                                    class="nav-link"
                                    data-bs-toggle="pill"
                                    data-bs-target="#aiTab">
                                    <i class="mdi mdi-brain me-1"></i>
                                    AI Analysis
                                </button>
                            </li>

                            <li class="nav-item">
                                <button
                                    class="nav-link"
                                    data-bs-toggle="pill"
                                    data-bs-target="#resumeTab">
                                    <i class="mdi mdi-file-document-outline me-1"></i>
                                    Resume
                                </button>
                            </li>

                            <!-- NEW -->

                            <!-- <li class="nav-item">

                                <button
                                    class="nav-link"
                                    data-bs-toggle="pill"
                                    data-bs-target="#customResumeTab">

                                    <i class="mdi mdi-file-eye-outline me-1"></i>

                                    Custom View

                                </button>

                            </li> -->
                            <li class="nav-item" role="presentation">
                                <button
                                    type="button"
                                    class="nav-link"
                                    id="applicationAnswersTabBtn"
                                    data-bs-toggle="pill"
                                    data-bs-target="#applicationAnswersTab"
                                    role="tab"
                                    aria-controls="applicationAnswersTab"
                                    aria-selected="false">

                                    <i class="mdi mdi-comment-question-outline me-1"></i>

                                    Application Answers

                                    <span
                                        id="applicationAnswersCount"
                                        class="badge bg-label-primary ms-1"
                                        style="display:none;">
                                        0
                                    </span>
                                </button>
                            </li>

                        </ul>
                        <!-- Tab Contents -->
                        <div class="tab-content p-4">
                            <div class="tab-pane fade show active" id="overviewTab"></div>
                            <div class="tab-pane fade" id="aiTab"></div>
                            <div class="tab-pane fade" id="resumeTab"></div>
                            <!-- <div class="tab-pane fade" id="timelineTab"></div> -->
                            <!-- <div class="tab-pane fade" id="documentsTab"></div> -->
                             <div
                                class="tab-pane fade"
                                id="applicationAnswersTab"
                                role="tabpanel">

                                <div id="applicationAnswersContent">

                                    <div class="text-center py-5">
                                        <i class="mdi mdi-comment-question-outline"
                                        style="font-size:48px;color:#c7cdd8;"></i>

                                        <h5 class="mt-3">
                                            Application Answers
                                        </h5>

                                        <p class="text-muted mb-0">
                                            Candidate responses will appear here.
                                        </p>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
        </div>
    </div>
</div>

<style>
    #applicantDetailedAiModal .modal-dialog {
        max-width: 1380px;
    }
    .resume-text{
        white-space:pre-wrap;
        font-size:14px;
        line-height:1.8;
        max-height:700px;
        overflow:auto;
        background:#fafafa;
        padding:20px;
        border-radius:10px;
    }

    .timeline-item{
        border-left:3px solid #ab2b22;
        padding-left:20px;
        margin-bottom:25px;
    }

    .timeline-item::before{

        content:"";

        width:14px;

        height:14px;

        background:#ab2b22;

        border-radius:50%;

        display:block;

        margin-left:-28px;

        margin-bottom:10px;

    }

    .timeline-card{

        display:flex;

        margin-bottom:30px;

        position:relative;

    }

    .timeline-card::before{

        content:"";

        position:absolute;

        left:25px;

        top:55px;

        bottom:-30px;

        width:2px;

        background:#dee2e6;

    }

    .timeline-card:last-child::before{

        display:none;

    }

    .timeline-icon{

        width:50px;

        height:50px;

        border-radius:50%;

        background:#ab2b22;

        color:#fff;

        display:flex;

        align-items:center;

        justify-content:center;

        font-size:22px;

        margin-right:20px;

        flex-shrink:0;

    }

    .timeline-content{

        background:#fff;

        padding:20px;

        border-radius:12px;

        width:100%;

        box-shadow:0 3px 10px rgba(0,0,0,.08);

    }
    .decision-panel{
        background:#fff;
        border-radius:16px;
        padding:30px;
        margin-bottom:25px;
        box-shadow:0 4px 16px rgba(0,0,0,.08);
    }

    .decision-score{
        width:120px;
        height:120px;
        border-radius:50%;
        background:#ab2b22;
        color:#fff;
        display:flex;
        justify-content:center;
        align-items:center;
        font-size:32px;
        font-weight:bold;
        margin-left:auto;
    }

    .metric-box{
        background:#f8f9fa;
        border-radius:12px;
        padding:18px;
        margin-top:15px;
    }

    .metric-title{
        color:#6c757d;
        font-size:13px;
    }

    .metric-value{
        font-size:18px;
        font-weight:600;
    }
        .progress{
        height:8px;
        border-radius:30px;
    }

    .progress-bar{
        transition:width 1.5s ease;
    }

    .card{
        border-radius:14px;
    }

    .badge{
        font-size:13px;
        padding:8px 12px;
    }

    .alert{
        border-radius:14px;
    }

    .list-group-item{
        border:none;
    }
    .candidate-card{

    padding:25px;

    }

    .candidate-header{

        text-align:center;

        padding-bottom:25px;

        border-bottom:1px solid #eee;

        margin-bottom:20px;

    }

    .candidate-avatar{

        width:90px;

        height:90px;

        margin:auto;

        border-radius:50%;

        background:#ab2b22;

        color:#fff;

        font-size:34px;

        font-weight:700;

        display:flex;

        align-items:center;

        justify-content:center;

        margin-bottom:15px;

    }

    .info-card{

        background:#fff;

        border-radius:12px;

        padding:18px;

        margin-bottom:20px;

        box-shadow:0 2px 8px rgba(0,0,0,.05);

    }

    .info-card h6{

        font-weight:700;

        margin-bottom:15px;

    }

    .score-circle{

        width:90px;

        height:90px;

        border-radius:50%;

        background:#e9f5ff;

        color:#ab2b22;

        font-size:24px;

        font-weight:bold;

        display:flex;

        align-items:center;

        justify-content:center;

        margin:auto;

        border:5px solid #ab2b22;

    }
    .applicant-modal{

        border-radius:18px;

        overflow:hidden;

    }

    .applicant-sidebar{

        background:#f8fafc;

        border-right:1px solid #e9ecef;

        min-height:82vh;

    }

    .applicant-tabs{

        background:#fff;

        padding:15px;

        border-bottom:1px solid #ececec;

    }

    .applicant-tabs .nav-link{

        border-radius:10px;

        font-weight:600;

        color:#6c757d;

        margin-right:10px;

    }

    .applicant-tabs .nav-link.active{

        background:#ab2b22;

        color:#fff;

    }

    .modal-header{

        background:#fff;

        position:sticky;

        top:0;

        z-index:99;

    }

    .modal-footer{

        position:sticky;

        bottom:0;

        z-index:99;

        border-top:1px solid #eee;

    }

    .tab-content{

        height:90vh;

        overflow:auto;

        background:#fcfcfc;

    }

    /* Applicant Overview  */

    .overview-hero-card {
        background: #fff;
        border: 1px solid #edf0f5;
        border-radius: 16px;
        padding: 22px;
        box-shadow: 0 4px 16px rgba(0,0,0,.04);
    }

    .overview-avatar {
        width: 72px;
        height: 72px;
        min-width: 72px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg,#ab2b22,#c17e42);
        color: #fff;
        font-size: 26px;
        font-weight: 700;
    }

    .overview-score-wrapper {
        margin-left: auto;
    }

    .overview-score-circle {
        width: 112px;
        height: 112px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;

        background:
            conic-gradient(
                #ab2b22 calc(var(--score) * 1%),
                #e9eef5 0
            );

        position: relative;
    }

    .overview-score-circle::before {
        content: "";
        position: absolute;
        width: 88px;
        height: 88px;
        border-radius: 50%;
        background: #fff;
    }

    .overview-score-circle > div {
        position: relative;
        z-index: 2;
        text-align: center;
    }

    .overview-score-circle strong {
        display: block;
        font-size: 24px;
        line-height: 1;
    }

    .overview-score-circle small {
        display: block;
        margin-top: 5px;
        color: #6c757d;
        font-size: 10px;
        font-weight: 600;
    }

    .overview-contact-chip {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #f5f7fa;
        padding: 6px 10px;
        border-radius: 8px;
        font-size: 12px;
        color: #495057;
    }

    .overview-metric-card {
        background: #fff;
        border: 1px solid #edf0f5;
        border-radius: 14px;
        padding: 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        height: 100%;
    }

    .overview-metric-icon {
        width: 44px;
        height: 44px;
        min-width: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 21px;
    }

    .overview-section-card {
        border: 1px solid #edf0f5;
        box-shadow: 0 3px 12px rgba(0,0,0,.035);
    }

    .overview-section-icon {
        width: 42px;
        height: 42px;
        border-radius: 11px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .overview-role-card {
        border: 1px solid #edf0f5;
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 12px;
        background: #fff;
        transition: .2s ease;
    }

    .overview-role-card:hover {
        transform: translateY(-1px);
        box-shadow: 0 5px 15px rgba(0,0,0,.06);
    }

    .overview-role-number {
        width: 38px;
        height: 38px;
        min-width: 38px;
        border-radius: 10px;
        background: #eef4ff;
        color: #ab2b22;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
    }

    .overview-empty-state {
        display: flex;
        align-items: center;
        gap: 15px;
        background: #f8f9fa;
        border: 1px dashed #dce1e7;
        border-radius: 12px;
        padding: 20px;
    }

    .overview-empty-icon {
        width: 45px;
        height: 45px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #eef0f3;
        color: #6c757d;
        font-size: 21px;
    }

    .overview-bullet-item {
        display: flex;
        gap: 9px;
        margin-bottom: 11px;
        font-size: 13px;
        line-height: 1.55;
    }

    .overview-info-item {
        background: #f8fafc;
        border-radius: 10px;
        padding: 12px;
        min-height: 68px;
    }


    /* Resume Workspace */

    .resume-workspace {
        min-height: 100%;
    }

    .resume-toolbar {
        background: #fff;
        border: 1px solid #e8edf3;
        border-radius: 14px;
        padding: 15px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        flex-wrap: wrap;
    }

    .resume-file-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 25px;
    }

    .resume-file-pdf {
        background: #fff0f0;
        color: #dc3545;
    }

    .resume-file-word {
        background: #eef4ff;
        color: #ab2b22;
    }

    .resume-file-image {
        background: #f0fff7;
        color: #198754;
    }

    .resume-file-text {
        background: #fff8e8;
        color: #b58105;
    }

    .resume-file-default {
        background: #f1f3f5;
        color: #6c757d;
    }

    .resume-viewer-card {
        margin-top: 15px;
        background: #e9edf2;
        border: 1px solid #dfe4ea;
        border-radius: 14px;
        overflow: hidden;
    }

    .resume-viewer-body {
        min-height: 680px;
        position: relative;
    }

    .resume-pdf-container {
        width: 100%;
        height: 680px;
        position: relative;
        background: #525659;
    }

    .resume-pdf-frame {
        width: 100%;
        height: 100%;
        border: 0;
        display: block;
    }

    .resume-pdf-loading {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        z-index: 3;
    }

    .resume-image-container {
        width: 100%;
        height: 680px;
        display: flex;
        flex-direction: column;
        background: #343a40;
    }

    .resume-image-toolbar {
        height: 48px;
        background: #212529;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        flex-shrink: 0;
    }

    .resume-image-stage {
        flex: 1;
        overflow: auto;
        display: flex;
        align-items: flex-start;
        justify-content: center;
        padding: 30px;
    }

    .resume-image-preview {
        max-width: 100%;
        height: auto;
        transform-origin: top center;
        transition: transform .2s ease;
        box-shadow: 0 8px 25px rgba(0,0,0,.35);
        background: #fff;
    }

    .resume-document-fallback,
    .resume-viewer-empty {
        min-height: 680px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 40px;
        background: #f8f9fa;
    }

    .resume-document-icon,
    .resume-empty-icon {
        width: 80px;
        height: 80px;
        border-radius: 20px;
        background: #eef4ff;
        color: #ab2b22;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 42px;
    }

    .resume-native-text-viewer {
        height: 680px;
        overflow: auto;
        white-space: pre-wrap;
        padding: 30px;
        background: #fff;
        font-size: 14px;
        line-height: 1.8;
    }

    .resume-extracted-card {
        border: 1px solid #e8edf3;
        box-shadow: 0 3px 12px rgba(0,0,0,.035);
    }

    .resume-section-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: #eef4ff;
        color: #ab2b22;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .resume-extracted-text {
        background: #f8fafc;
        border: 1px solid #edf0f5;
        border-radius: 10px;
        padding: 18px;
        white-space: pre-wrap;
        max-height: 500px;
        overflow: auto;
        font-size: 13px;
        line-height: 1.7;
    }

    .resume-empty-text {
        min-height: 150px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        color: #6c757d;
        text-align: center;
    }


    /* Mobile  */

    @media (max-width: 767.98px) {

        .overview-score-wrapper {
            width: 100%;
            margin-top: 15px;
            display: flex;
            justify-content: center;
        }

        .overview-hero-card {
            padding: 15px;
        }

        .resume-viewer-body,
        .resume-pdf-container,
        .resume-image-container,
        .resume-document-fallback,
        .resume-viewer-empty {
            min-height: 550px;
            height: 550px;
        }

        .resume-toolbar {
            align-items: flex-start;
        }

    }

    /*  CUSTOM RESUME VIEWER */

    .custom-resume-wrapper {
        width: 100%;
        background: #f4f6f9;
        border: 1px solid #e4e7ec;
        border-radius: 14px;
        overflow: hidden;
    }


    /* Toolbar */

    .custom-resume-toolbar {

        min-height: 64px;

        padding: 12px 16px;

        background: #ffffff;

        border-bottom: 1px solid #e5e7eb;

        display: flex;

        align-items: center;

        justify-content: space-between;

        gap: 15px;

        position: sticky;

        top: 0;

        z-index: 10;

    }


    /* File icon */

    .custom-file-icon {

        width: 42px;

        height: 42px;

        border-radius: 10px;

        display: inline-flex;

        align-items: center;

        justify-content: center;

        font-size: 23px;

        flex-shrink: 0;

    }

    .custom-file-icon.pdf {

        background: #fff0f0;

        color: #dc3545;

    }

    .custom-file-icon.word {

        background: #edf4ff;

        color: #ab2b22;

    }

    .custom-file-icon.image {

        background: #eefbf3;

        color: #198754;

    }

    .custom-file-icon.text {

        background: #f3f4f6;

        color: #6c757d;

    }


    /* Document information */

    .custom-doc-info {

        padding: 10px 16px;

        background: #fafbfc;

        border-bottom: 1px solid #e5e7eb;

        display: flex;

        align-items: center;

        justify-content: space-between;

        gap: 10px;

        font-size: 13px;

        color: #6b7280;

    }

    .custom-doc-info > div {

        display: flex;

        align-items: center;

        gap: 7px;

    }


    /* PDF */

    .custom-pdf-viewer {

        height: 75vh;

        min-height: 600px;

        background: #525659;

    }

    .custom-pdf-viewer iframe {

        width: 100%;

        height: 100%;

        border: 0;

        display: block;

    }


    /* Document stage */

    .custom-document-stage {

        min-height: 75vh;

        max-height: 78vh;

        overflow: auto;

        padding: 35px;

        background:

            linear-gradient(
                45deg,
                #eef1f5 25%,
                transparent 25%
            ),

            linear-gradient(
                -45deg,
                #eef1f5 25%,
                transparent 25%
            ),

            linear-gradient(
                45deg,
                transparent 75%,
                #eef1f5 75%
            ),

            linear-gradient(
                -45deg,
                transparent 75%,
                #eef1f5 75%
            );

        background-size: 24px 24px;

        background-position:
            0 0,
            0 12px,
            12px -12px,
            -12px 0;
    }


    /* Fake Word/PDF page */

    .custom-document-page {

        width: min(900px, 100%);

        margin: 0 auto;

        background: #ffffff;

        min-height: 1000px;

        box-shadow:
            0 5px 25px rgba(0,0,0,.12);

        border-radius: 2px;

        padding: 55px 65px;

    }


    /* Document header */

    .custom-document-header {

        padding-bottom: 20px;

        margin-bottom: 25px;

        border-bottom: 1px solid #e5e7eb;

    }

    .custom-document-title {

        font-size: 24px;

        font-weight: 700;

        color: #111827;

    }

    .custom-document-meta {

        margin-top: 5px;

        color: #6b7280;

        font-size: 13px;

    }


    /* Document content */

    .custom-document-content {

        color: #252b36;

        font-size: 14px;

        line-height: 1.8;

    }


    /* Resume headings */

    .resume-doc-heading {

        margin-top: 28px;

        margin-bottom: 12px;

        padding-bottom: 7px;

        border-bottom: 1px solid #e5e7eb;

        color: #111827;

        font-weight: 700;

        font-size: 16px;

        display: flex;

        align-items: center;

        gap: 5px;

    }

    .resume-doc-heading:first-child {

        margin-top: 0;

    }

    .resume-doc-heading i {

        color: #ab2b22;

    }


    /* Paragraph */

    .resume-doc-paragraph {

        margin-bottom: 8px;

        white-space: normal;

        word-break: break-word;

    }


    /* Bullet */

    .resume-doc-bullet {

        display: flex;

        align-items: flex-start;

        gap: 4px;

        margin-bottom: 6px;

        padding-left: 8px;

    }

    .resume-doc-bullet-icon {

        color: #ab2b22;

        line-height: 1.7;

    }

    .resume-doc-spacer {

        height: 8px;

    }


    /* Image viewer */

    .custom-image-stage {

        min-height: 650px;

        max-height: 78vh;

        overflow: auto;

        display: flex;

        align-items: flex-start;

        justify-content: center;

        padding: 30px;

        background: #f3f4f6;

    }

    .custom-image-preview {

        max-width: 100%;

        height: auto;

        transform-origin: top center;

        transition: transform .2s ease;

        box-shadow:
            0 8px 30px rgba(0,0,0,.15);

        background: #fff;

    }


    /* Empty */

    .custom-resume-empty {

        min-height: 450px;

        display: flex;

        flex-direction: column;

        justify-content: center;

        align-items: center;

        text-align: center;

        background: #f8fafc;

        border-radius: 14px;

        padding: 40px;

    }

    .custom-resume-empty-icon {

        width: 75px;

        height: 75px;

        border-radius: 50%;

        display: flex;

        align-items: center;

        justify-content: center;

        background: #eef2f7;

        color: #94a3b8;

        font-size: 35px;

    }


    /* Mobile */

    @media(max-width: 767px) {

        .custom-resume-toolbar {

            align-items: flex-start;

            flex-direction: column;

        }

        .custom-document-stage {

            padding: 10px;

            max-height: 75vh;

        }

        .custom-document-page {

            padding: 30px 22px;

            min-height: auto;

        }

        .custom-pdf-viewer {

            height: 70vh;

            min-height: 450px;

        }

    }
</style>


<style>
    .application-answers-wrapper {
        padding: 4px 2px 20px;
    }

    .application-answer-summary {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 18px 20px;
        margin-bottom: 20px;
        border: 1px solid #e8ebf0;
        border-radius: 14px;
        background: linear-gradient(
            135deg,
            #f8fbff,
            #ffffff
        );
    }

    .answer-summary-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #eaf4ff;
        color: #ab2b22;
        font-size: 23px;
    }

    .answer-summary-count {
        min-width: 44px;
        height: 44px;
        padding: 0 12px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #ab2b22;
        color: #fff;
        font-size: 17px;
        font-weight: 700;
    }

    .application-answer-list {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .application-answer-card {
        display: flex;
        gap: 16px;
        padding: 20px;
        background: #fff;
        border: 1px solid #e8ebf0;
        border-radius: 14px;
        transition: all .18s ease;
    }

    .application-answer-card:hover {
        border-color: #cfd8e3;
        box-shadow: 0 5px 18px rgba(20, 40, 80, .07);
    }

    .answer-number {
        flex: 0 0 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f1f4f8;
        color: #667085;
        font-size: 12px;
        font-weight: 700;
    }

    .answer-card-body {
        flex: 1;
        min-width: 0;
    }

    .answer-question {
        color: #172033;
        font-size: 15px;
        font-weight: 700;
        line-height: 1.5;
    }

    .answer-type {
        display: inline-block;
        margin-top: 5px;
        color: #98a2b3;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .4px;
        font-weight: 600;
    }

    .answer-value {
        margin-top: 14px;
    }

    .answer-text {
        padding: 12px 14px;
        border-radius: 10px;
        background: #f8fafc;
        color: #344054;
        font-size: 14px;
        line-height: 1.6;
        white-space: normal;
    }

    .answer-badge-list {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .answer-badge {
        display: inline-flex;
        align-items: center;
        padding: 7px 11px;
        border-radius: 8px;
        background: #eef5ff;
        color: #175cd3;
        font-size: 12px;
        font-weight: 600;
    }

    .answer-not-provided {
        color: #98a2b3;
        font-size: 13px;
        font-style: italic;
    }

    .application-answer-empty,
    .application-answer-error {
        padding: 60px 20px;
        text-align: center;
    }

    .application-answer-empty .empty-icon,
    .application-answer-error .empty-icon {
        width: 64px;
        height: 64px;
        margin: 0 auto 16px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f4f6f8;
        color: #98a2b3;
        font-size: 30px;
    }

    .application-answer-empty h5,
    .application-answer-error h5 {
        color: #344054;
        font-weight: 700;
    }

    .application-answer-empty p,
    .application-answer-error p {
        max-width: 500px;
        margin: 6px auto 0;
        color: #98a2b3;
        font-size: 13px;
    }

    @media (max-width: 576px) {

        .application-answer-card {
            padding: 15px;
            gap: 10px;
        }

        .answer-number {
            flex-basis: 32px;
            height: 32px;
        }

        .answer-question {
            font-size: 14px;
        }

        .application-answer-summary {
            padding: 14px;
        }
    }
</style>

<div class="modal fade"
     id="manageRolesModal"
     tabindex="-1"
     aria-labelledby="manageRolesModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header bg-label-primary">
                <div>
                    <h5 class="modal-title mb-1" id="manageRolesModalLabel">Manage Recruitment Roles</h5>
                    <!-- <div class="modal-subtitle">Control canonical roles used by recruitment and ATS matching.</div> -->
                </div>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-3 p-md-4">
                {{-- Summary cards --}}
                <!-- <div class="row g-3 mb-3">
                    <div class="col-6 col-lg-3">
                        <div class="role-stat-card">
                            <div class="role-stat-label">Active</div>
                            <div class="role-stat-value" id="roleCountActive">0</div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="role-stat-card">
                            <div class="role-stat-label">Inactive</div>
                            <div class="role-stat-value" id="roleCountInactive">0</div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="role-stat-card">
                            <div class="role-stat-label">Deleted</div>
                            <div class="role-stat-value" id="roleCountDeleted">0</div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="role-stat-card">
                            <div class="role-stat-label">Showing</div>
                            <div class="role-stat-value" id="roleShowingCount">0</div>
                        </div>
                    </div>
                </div> -->

                {{-- Toolbar --}}
                <div class="role-toolbar mb-0">
                    <div class="row g-2 align-items-center">
                        <div class="col-lg-5 d-grid">
                           
                        </div>
                        <div class="col-lg-2 d-grid">
                            <button type="button" class="btn btn-primary" id="addRoleBtn">
                                <i class="mdi mdi-plus me-1"></i> Add Role
                            </button>
                        </div>
                        <div class="col-lg-5">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0" style="border-color:#cbd5e1;border-radius:10px 0 0 10px;">
                                    <i class="mdi mdi-magnify text-dark"></i>
                                </span>
                                <input type="search"
                                       id="roleSearch"
                                       class="form-control border-start-0 ps-0"
                                       placeholder="Search role Name..."
                                       autocomplete="off"
                                       style="border-radius:0 10px 10px 0;">
                            </div>
                        </div>
                        <!-- <div class="col-sm-6 col-lg-3">
                            <select id="roleFamilyFilter" class="form-select">
                                <option value="">All families</option>
                            </select>
                        </div>
                        <div class="col-sm-6 col-lg-2">
                            <select id="roleStatusFilter" class="form-select">
                                <option value="">Active + Inactive</option>
                                <option value="0">Active only</option>
                                <option value="1">Inactive only</option>
                                <option value="2">Deleted only</option>
                            </select>
                        </div> -->
                        
                    </div>
                </div>

                {{-- Add/Edit form --}}
                <div class="role-form-panel" id="roleFormPanel">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <div class="fw-bold text-dark" id="roleFormTitle">Add New Role</div>
                            <div class="text-secondary small">Changes are saved through AJAX without leaving the candidate page.</div>
                        </div>
                        <button type="button" class="btn btn-sm btn-light border" id="cancelRoleFormBtn">Cancel</button>
                    </div>

                    <form id="roleForm" novalidate>
                        <input type="hidden" id="roleId" name="role_id" value="">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="role-form-label" for="roleName">Role Name <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control"
                                       id="roleName"
                                       name="role_name"
                                       maxlength="150"
                                       placeholder="e.g. Senior Laravel Developer"
                                       required>
                                <div class="role-form-help">This becomes the canonical role name used across ATS screens.</div>
                            </div>

                            <div class="col-md-3">
                                <label class="role-form-label" for="roleFamily">Role Family</label>
                                <input type="text"
                                       class="form-control"
                                       id="roleFamily"
                                       name="role_family"
                                       maxlength="100"
                                       list="roleFamilySuggestions"
                                       placeholder="e.g. Software Engineering">
                            </div>

                            <div class="col-md-3">
                                <label class="role-form-label" for="seniorityLevel">Seniority</label>
                                <select class="form-select" id="seniorityLevel" name="seniority_level" required>
                                    <option value="1">Entry</option>
                                    <option value="2">Senior</option>
                                    <option value="3">Team Lead</option>
                                    <option value="4">Manager</option>
                                    <option value="5">Head</option>
                                </select>
                            </div>

                            <div class="col-md-9">
                                <label class="role-form-label" for="roleDescription">Description</label>
                                <textarea class="form-control"
                                          id="roleDescription"
                                          name="description"
                                          maxlength="5000"
                                          rows="2"
                                          placeholder="Optional description, responsibilities, or ATS context..."></textarea>
                            </div>

                            <div class="col-md-3 d-flex align-items-end">
                                <div class="form-check form-switch role-switch mb-1">
                                    <input class="form-check-input" type="checkbox" id="roleMatchEnabled" name="match_enabled" checked>
                                    <label class="form-check-label ms-2" for="roleMatchEnabled">
                                        <span class="fw-bold d-block">ATS Matching</span>
                                        <span class="text-secondary small">Use this role for matching</span>
                                    </label>
                                </div>
                            </div>

                            <div class="col-12" id="roleCodeInfo" style="display:none;">
                                <div class="alert alert-light border mb-0 py-2 px-3">
                                    <span class="text-secondary small">Stable role code:</span>
                                    <code id="roleCodeText" class="ms-1"></code>
                                </div>
                            </div>

                            <div class="col-12 d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-light border" id="cancelRoleFormBtn2">Cancel</button>
                                <button type="submit" class="btn btn-primary" id="saveRoleBtn">
                                    <span class="save-role-label"><i class="mdi mdi-check-circle-outline me-1"></i> Save Role</span>
                                    <span class="save-role-loading d-none"><span class="spinner-border spinner-border-sm me-1"></span> Saving...</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <datalist id="roleFamilySuggestions"></datalist>

                {{-- Table --}}
                <div class="table-wrap">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="rolesTable">
                            <thead>
                                <tr class="text-start align-top  fw-bold fs-6 gs-0 bg-primary">
                                    <th style="width:30px;">#</th>
                                    <th>Role</th>
                                    <th>Family</th>
                                    <th>Level</th>
                                    <!-- <th>ATS</th> -->
                                    <!-- <th>Status</th> -->
                                    <!-- <th>Updated</th> -->
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="rolesTableBody">
                                <tr>
                                    <td colspan="5">
                                        <div class="role-loading">
                                            <div class="spinner-border spinner-border-sm text-primary mb-2"></div>
                                            <div>Loading roles...</div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Pagination --}}
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2 pt-3 mb-2">
                    <div class="small text-dark" id="rolesPaginationSummary">Showing 0 of 0</div>
                    <nav aria-label="Recruitment roles pagination">
                        <ul class="pagination pagination-sm mb-0" id="rolesPagination"></ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(".list_page").DataTable({
        "ordering": false,
        "pageLength": 25,
        // "aaSorting":[],
        "language": {
            "lengthMenu": "Show _MENU_",
        },
        "dom": "<'row mb-3'" +
            // "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
            // "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
            ">" +

            "<'table-responsive'tr>" +

            "<'row'" +
            // "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
            // "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
            ">"
    });
</script>



<script>
    // document.addEventListener("DOMContentLoaded", function () {
    //     // Show filter div on "Add Filter"
    //     document.getElementById('filter_btn').addEventListener('click', function () {
    //         document.getElementById('filter_div').style.display = 'block';
    //     });
    // });

    function clearFilter() {
        document.getElementById('filter_div').style.display = 'none';
        location.reload();
    }
</script>


<script>
    function date_fill_issue_rpt() {
        var dt_fill_issue_rpt = document.getElementById('dt_fill_issue_rpt').value;
        var today_dt_iss_rpt = document.getElementById('today_dt_iss_rpt');
        var week_from_dt_iss_rpt = document.getElementById('week_from_dt_iss_rpt');
        var week_to_dt_iss_rpt = document.getElementById('week_to_dt_iss_rpt');
        var monthly_dt_iss_rpt = document.getElementById('monthly_dt_iss_rpt');
        var from_dt_iss_rpt = document.getElementById('from_dt_iss_rpt');
        var to_dt_iss_rpt = document.getElementById('to_dt_iss_rpt');
        var from_date_fillter_iss_rpt = document.getElementById('from_date_fillter_iss_rpt');
        var to_date_fillter_iss_rpt = document.getElementById('to_date_fillter_iss_rpt');

        if (dt_fill_issue_rpt == "today") {
            today_dt_iss_rpt.style.display = "block";
            monthly_dt_iss_rpt.style.display = "none";
            from_dt_iss_rpt.style.display = "none";
            to_dt_iss_rpt.style.display = "none";
            week_from_dt_iss_rpt.style.display = "none";
            week_to_dt_iss_rpt.style.display = "none";
        } else if (dt_fill_issue_rpt == "week") {
            today_dt_iss_rpt.style.display = "none";
            week_from_dt_iss_rpt.style.display = "block";
            week_to_dt_iss_rpt.style.display = "block";
            monthly_dt_iss_rpt.style.display = "none";
            from_dt_iss_rpt.style.display = "none";
            to_dt_iss_rpt.style.display = "none";

            var curr = new Date; // get current date
            var first = curr.getDate() - curr.getDay(); // First day is the day of the month - the day of the week
            var last = first + 6; // last day is the first day + 6

            var firstday = new Date(curr.setDate(first)).toISOString().slice(0, 10);
            firstday = firstday.split("-").reverse().join("-");
            var lastday = new Date(curr.setDate(last)).toISOString().slice(0, 10);
            lastday = lastday.split("-").reverse().join("-");
            $('#week_from_date_fil').val(firstday);
            $('#week_to_date_fil').val(lastday);

        } else if (dt_fill_issue_rpt == "monthly") {
            today_dt_iss_rpt.style.display = "none";
            monthly_dt_iss_rpt.style.display = "block";
            from_dt_iss_rpt.style.display = "none";
            to_dt_iss_rpt.style.display = "none";
            week_from_dt_iss_rpt.style.display = "none";
            week_to_dt_iss_rpt.style.display = "none";
        } else if (dt_fill_issue_rpt == "custom_date") {
            today_dt_iss_rpt.style.display = "none";
            monthly_dt_iss_rpt.style.display = "none";
            from_dt_iss_rpt.style.display = "block";
            to_dt_iss_rpt.style.display = "block";
            week_from_dt_iss_rpt.style.display = "none";
            week_to_dt_iss_rpt.style.display = "none";
        } else {
            today_dt_iss_rpt.style.display = "none";
            monthly_dt_iss_rpt.style.display = "none";
            from_dt_iss_rpt.style.display = "none";
            to_dt_iss_rpt.style.display = "none";
            week_from_dt_iss_rpt.style.display = "none";
            week_to_dt_iss_rpt.style.display = "none";
        }
    }
</script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css">
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>

<script>
    let resumeKeywordsTagify = null;

    document.addEventListener('DOMContentLoaded', function () {

        const keywordInput = document.getElementById('resume_keywords_filt');

        if (keywordInput) {
            resumeKeywordsTagify = new Tagify(keywordInput, {
                maxTags: 15,
                trim: true,
                duplicates: false,
                editTags: false,
                dropdown: {
                    enabled: 0
                }
            });
        }

    });
</script>

<script>
    let currentPage = 1;
    let isLoading = false;
    let abortController = new AbortController();
    let auth_user_id = @json($user_id);
    let auth_role_id = @json($role_id);
    let vipCheckFilter = 0;
    let walkinCheckFilter = 0;
    let dashboardFilter = '';
    

    function formatDate(dateString) {
        const date = new Date(dateString);

        // Check if the date is valid
        if (isNaN(date.getTime())) {
            return '-'; // Return '-' if the date is invalid
        }

        // Get the day, month (abbreviated), and year
        const day = String(date.getDate()).padStart(2, '0'); // Get day and pad with leading zero
        const month = date.toLocaleString('default', {
            month: 'short'
        }); // Get abbreviated month
        const year = date.getFullYear(); // Get full year

        // Construct and return the formatted date string
        return `${day}-${month}-${year}`; // Format as DD-MMM-YYYY
    }

    function safeJsonParse(str) {
        try {
            return JSON.parse(str);
        } catch (e) {
            return str;
        }
    }

    // Always use the authenticated ERP resolver. It chooses Wasabi first, then Drive, then local.
    const candidateResumeOpenUrlTemplate = @json(url('/hr-recruiter/applicants/__APPLICANT_ID__/resume/open'));

    function candidateResumeOpenUrl(applicantId, disposition = 'inline') {
        const id = Number(applicantId || 0);
        if (!Number.isSafeInteger(id) || id < 1) return '';
        const safeDisposition = disposition === 'attachment' ? 'attachment' : 'inline';
        return candidateResumeOpenUrlTemplate
            .replace('__APPLICANT_ID__', encodeURIComponent(String(id)))
            + '?disposition=' + safeDisposition;
    }

    function candidateResumeUrlsUrl(applicantId) {
        const openUrl = candidateResumeOpenUrl(applicantId, 'inline');
        return openUrl ? openUrl.replace(/\/resume\/open\?disposition=inline$/, '/resume/urls') : '';
    }

    function statusInfo(row) {

        if (row.career_portal == '1') {
            return {
                key: 'lifetime',
                label: 'Lifetime',
                icon: 'mdi-infinity',
                textClass: 'text-primary'
            };
        }else{
            return {
                key: 'upcoming',
                label: 'Upcoming',
                icon: 'mdi-calendar-clock-outline',
                textClass: 'text-info'
            };
        }
        
    }

    

    function buildRow(item, index) {

        var data = typeof item.data === 'string' ? JSON.parse(item.data) : item.data;
        var old_data = typeof item.old_data === 'string' ? JSON.parse(item.old_data) : item.old_data;
        var old_status = old_data ? 1 : 0;
        let statuBadge = '';
        let genderIcon = '';
        let status = item.status;

        // These authenticated routes resolve the current source server-side: Wasabi -> Drive -> local.
        var resumeViewUrl = item.resume_view_url || candidateResumeOpenUrl(item.sno, 'inline');
        var resumeDownloadUrl = item.resume_download_url || candidateResumeOpenUrl(item.sno, 'attachment');

        if (data.gender == '2') {
            genderIcon = '<i class="mdi mdi-face-woman text-info"></i>';
        } else {
            genderIcon = '<i class="mdi mdi-face-man text-danger"></i>';
        }
        
        if (!data.interview_status) {
            statuBadge = `
                    <span class="badge rounded bg-label-warning text-black fw-semibold fs-7">New Applicant</span>
                `;
        } else {
                const color = getStatusColor(
                    data.interview_status
                );
            statuBadge = `
                    <span class="badge rounded bg-label-${color} text-black fw-semibold fs-7">${data.interview_status}</span>
                `;
        }
        


        let badgeClass = '';
        let qualification = '-';
        if (data.qualification_id == '1') {
            qualification = 'UG';
            badgeClass = 'bg-label-ug';
        } else if (data.qualification_id == '2') {
            qualification = 'PG';
            badgeClass = 'bg-label-pg';
        } else if (data.qualification_id == '3') {
            qualification = 'Doctorate';
            badgeClass = 'bg-label-doctorate';
        } else if (data.qualification_id == '4') {
            qualification = 'HSC';
            badgeClass = 'bg-label-hsc';
        } else if (data.qualification_id == '5') {
            qualification = 'SSLC';
            badgeClass = 'bg-label-sslc';
        } else if (data.qualification_id == '6') {
            qualification = 'Below SSLC';
            badgeClass = 'bg-label-below-sslc';
        } else {
            qualification = 'Others';
            badgeClass = 'bg-label-others';
        }
        let qualificationId = '';
        if (parseInt(data.recruitment_id) > 0 && data.old_data) {
            try {
                const oldData = JSON.parse(data.old_data);
                qualificationId = oldData.qualification_id ?? qualificationId;

                if (qualificationId == '5') {
                    qualification = 'UG';
                    badgeClass = 'bg-label-ug';
                } else if (qualificationId == '4') {
                    qualification = 'PG';
                    badgeClass = 'bg-label-pg';
                } else if (qualificationId == '3') {
                    qualification = 'Professional Degree';
                    badgeClass = 'bg-label-pg';
                } else if (qualificationId == '2') {
                    qualification = 'Doctorate';
                    badgeClass = 'bg-label-doctorate';
                } else {
                    qualification = 'Others';
                    badgeClass = 'bg-label-others';
                }

                // console.log(qualificationId)
            } catch (e) {
                badgeClass = 'bg-label-others';
                qualification = 'Others';
            }
        }
        const carreerCheck = statusInfo(data);

        return `
            <tr id="webhook-${item.sno}" class="recurring-row status-${carreerCheck.key}">
                <td style="position:relative;">
                     <div style="position:absolute; left:0; top:0; bottom:0; width:5px;" class="statusbar-${carreerCheck.key}"></div>
                    <div class="d-flex align-items-start justify-content-between ">
                        <div class="d-flex start gap-1">
                            <div class="align-self-center">
                                <span class="">
                                    ${item.vip_check == 1
                                        ? `<img src="{{asset('assets/egc_images/magic_menu/vip_badge.png')}}" style="width:40px;height:40px;object-fit: contain;">
                                        `
                                        : ''
                                    }
                                </span>
                            </div>
                            <div class="d-flex align-items-start justify-content-center flex-column">
                                <div class="d-flex align-items-start justify-content-between gap-4" >
                                    <div class="d-flex align-items-start justify-content-center  gap-1 cursor-pointer" >
                                        <label class="fs-7">${data.applicant_name}</label>
                                        <label class="fs-7 me-1">
                                                ${genderIcon}
                                        </label>
                                    </div>
                                    
                                </div>
                                <label class="fs-7 text-dark">${data.mobile}</label>
                            </div>
                        </div>
                        <span class="mdi mdi-badge-account cursor-pointer text-black fs-4" onclick="viewApplicantAI(${item.sno })"></span>
                    </div>


                </td>
                <td>
                    <div class="d-flex align-items-start justify-content-center flex-column">
                            <span class="d-block text-truncate max-w-150px fw-semibold text-black fs-7" title="${old_status == 1 ? (old_data.job_role_names || (data.display_job_role_name ?? '-')) : (data.job_fair_id > 0 ? (data.display_job_role_name ?? '-') :(data.job_role_name ? data.job_role_name : (data.display_job_role_name ?? '-')))}">
                            ${old_status == 1 ? (old_data.job_role_names || (data.display_job_role_name ?? 'Not Defined')) : (data.job_fair_id > 0 ? (data.display_job_role_name ?? 'Not Defined') :(data.job_role_name ? data.job_role_name : (data.display_job_role_name ?? 'Not Defined')))}
                            </span>
                       
                        <label class="fw-semibold fs-7 text-truncate badge bg-label-slack">
                         ${old_status == 1 ? (old_data.source_name || '-') :(data.job_fair_id > 0 ? 'Job Fair' : data.applicant_source_name)}
                        </label>
                    </div>
                </td>
                <td class="text-center">
                        <span class="fs-7 badge ${badgeClass}">${qualification || '-'}</span>
                        ${old_status == 1 ? 
                        `<span class="d-block text-truncate max-w-150px fs-8" title="${old_data.major_name || '-'}">
                            ${old_data.major_name || '-'}
                            </span>`
                        :
                        (
                            data.major !='0' && data.major ?
                            `<span class="d-block text-truncate max-w-150px fs-8" title="${data.major_name || '-'}">
                                ${data.major_name || '-'}
                            </span>`
                            :
                            ''
                            
                        )
                        
                        } 
                    
                </td>
                <td>
                    ${data.experience_id == '2' ?
                        `<label class="fs-7 fw-semibold">${old_status == 1 ? (old_data.experience_name || '-') : data.experience_count +' Years'}</label>`:
                        '<label class="fs-7 fw-semibold">Fresher</label>'
                    }
                    
                </td>

                <td>
                   <label class="fs-7 text-black fw-semibold d-flex align-items-center justify-content-start gap-1 text-nowrap">
                        <span><i class="mdi mdi-calendar-outline"></i></span>
                        ${data.created_at ? formatDate(data.created_at) : '-'}
                    </label>
                </td>
               
                <td class ="position-relative">
                    <div class="d-flex  align-items-center gap-2" >
                        ${statuBadge}
                        <span class="badge bg-primary rounded cursor-pointer fs-7" data-bs-toggle="tooltip" title="Candidate History Update" onclick="openCandidateHistory(${item.sno})">
                                <i class="mdi mdi-clipboard-text-clock fs-7"></i>
                        </span>
                    </div>
                    
                </td>
                <td>
                    <div class="d-flex gap-1">
                        ${item.vip_check == 1
                            ? `
                                <i class="mdi mdi-star text-success fs-3"></i>
                            `
                            : `<span data-bs-toggle="tooltip" title="Assign VIP Candidate">
                                <button type="button" class="btn btn-icon btn-sm btn-light-warning" onclick="openVipModal(${item.sno})">
                                    <i class="mdi mdi-star text-warning fs-3"></i>
                                </button>
                            </span>`
                        }
                    

                        <button type="button"
                            class="btn btn-icon btn-sm"
                            onclick="viewApplicantResume(${Number(item.sno)})"
                            data-bs-toggle="tooltip"
                            data-bs-placement="bottom"
                            title="Preview Resume in Candidate Modal">
                            <span><i class="mdi mdi-eye-outline fs-3 text-black"></i></span>
                        </button>
                        <a href="${escapeAttribute(resumeViewUrl)}"
                            target="_blank"
                            rel="noopener"
                            class="btn btn-icon btn-sm"
                            data-bs-toggle="tooltip"
                            data-bs-placement="bottom"
                            title="Open Resume in New Tab">
                            <span><i class="mdi mdi-open-in-new fs-3 text-black"></i></span>
                        </a>
                        <a href="${escapeAttribute(resumeDownloadUrl)}"
                            target="_blank"
                            rel="noopener"
                            class="btn btn-icon btn-sm"
                            data-bs-toggle="tooltip"
                            data-bs-placement="bottom"
                            title="Download Resume">
                            <span><i class="mdi mdi-tray-arrow-down fs-3 text-black"></i></span>
                        </a>

                        ${auth_user_id == 0 ?
                        `<button type="button" class="btn btn-icon btn-sm" data-bs-toggle="modal" data-bs-target="#kt_modal_edit_applicant" onclick="openEditModal('${item.sno}')">
                            <span><i class="mdi mdi-pencil-outline fs-3"></i></span>
                        </button>`:
                        ''
                        }
                        <button type="button" class="btn btn-icon btn-sm" data-bs-toggle="modal" data-bs-target="#kt_modal_ai_analyses_applicant" onclick="openAiAnalysesModal('${item.sno}')">
                            <span><i class="mdi mdi-robot fs-3"></i></span>
                        </button>
                        @if($canUseAtsRoleMatching)
                            <button type="button" class="btn btn-icon btn-sm" onclick="openAiRoleMatchModal('${item.sno}')">
                                <span><i class="mdi mdi-account-search fs-3"></i></span>
                            </button>
                        @endif
                    </div>
                    
                </td>
            </tr>
        `;
    }

    function loadThemes(page = 1) {
        const perpage = document.getElementById('perpage').value;
        const search = document.getElementById('search_filter').value;
        const closing_date_filt = document.getElementById('closing_date_filt').value;
        const to_dt_iss_rpt = document.getElementById('cus_custom_to_dt_fill').value;
        const from_dt_iss_rpt = document.getElementById('cus_custom_from_dt_fill').value;
        const dt_fill_issue_rpt = document.getElementById('dt_fill_issue_rpt').value;
        const job_role_fill = document.getElementById('job_role_fill').value;
        const exp_type_filt = document.getElementById('exp_type_filt').value;
        const source_name_filt = document.getElementById('source_name_filt').value;
        const source_type_filt = document.getElementById('source_type_filt').value;
        const qualification_filt = document.getElementById('qualification_filt').value;
        const major_filt = document.getElementById('major_filt').value;
        const applicant_status_filt = document.getElementById('applicant_status_filt').value;
        const resume_keywords_filt = resumeKeywordsTagify
                                ? resumeKeywordsTagify.value
                                    .map(item => item.value.trim())
                                    .filter(value => value !== '')
                                : [];
        let old_resume_fill = "";
        if (auth_user_id == 0) {
            old_resume_fill = document.getElementById('old_resume_fill').value;
        }
        $('#total_candidates').text('00');
        $('#today_candidates').text('00');
        $('#month_candidates').text('00');
        $('#fresher_count').text('00');
        $('#experienced_count').text('00');
        $('#job_fair_count').text('00');
        $('#walkin_candidates').text('00');
        $('#vip_candidates').text('00');

      


        const params = new URLSearchParams({
            page: page,
            sorting_filter: perpage,
            search_filter: search,
            closing_date_filt: closing_date_filt,
            exp_type_filt: exp_type_filt,
            source_type_filt: source_type_filt,
            source_name_filt: source_name_filt,
            qualification_filt: qualification_filt,
            major_filt: major_filt,
            job_role_fill: job_role_fill,
            dt_fill_issue_rpt: dt_fill_issue_rpt,
            from_dt_iss_rpt: from_dt_iss_rpt,
            to_dt_iss_rpt: to_dt_iss_rpt,
            old_resume_fill: old_resume_fill,
            applicant_status_filt: applicant_status_filt,
            dashboard_filter: dashboardFilter,

            // Tagify keywords
            resume_keywords_filt: JSON.stringify(resume_keywords_filt)
        });

        const url = `/hr_recruitment/manage_candidate?${params.toString()}`;
        // Show skeleton loader and clear old data before fetching new data
        isLoading = true;
        document.getElementById('list-table-body').innerHTML = ''; // Clear old data
        document.getElementById('list-table-body').insertAdjacentHTML('beforeend', skeletenRow()); // Clear old data
        $('#skeleton-loader').show(); // Show skeleton loader

        if (abortController.signal) {
            abortController.abort(); // Abort the previous request
        }
        abortController = new AbortController();

        fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                signal: abortController.signal
            })
            .then(res => res.json())
            .then(res => {
                // Insert new data into the table
                if (res.data.length > 0) {
                    res.data.forEach((item, index) => {
                        document.getElementById('list-table-body').insertAdjacentHTML('beforeend', buildRow(item, index + 1));
                    });

                } else {
                    document.getElementById('list-table-body').insertAdjacentHTML('beforeend', NoDataFound());
                }
                $('[data-bs-toggle="tooltip"]').tooltip();

                $('#total_candidates').text(res.total);
                $('#today_candidates').text(res.today_candidates);
                $('#month_candidates').text(res.month_candidates);
                $('#fresher_count').text(res.fresher_candidates);
                $('#experienced_count').text(res.experience_candidates);
                $('#job_fair_count').text(res.job_fair_candidates);
                $('#walkin_candidates').text(res.walkin_candidates);
                $('#vip_candidates').text(res.vip_candidates || 0);
                // Update pagination and results info
                updatePagination(res.current_page, res.last_page, res.total, perpage);

                // Hide skeleton loader after data is fetched
                isLoading = false;
                $('#skeleton-loader').hide();
            })
            .catch(error => {
                if (error.name !== 'AbortError') { // Only handle abort error
                    console.error('Error loading data:', error);
                }
                // Hide skeleton loader in case of error
                $('#skeleton-loader').hide();
                isLoading = false;
            });
    }

    function skeletenRow() {
        return `
            <tr class="skeleton-loader" id="skeleton-loader">
                <td class="skeleton-cell">
                    <div class="skeleton"></div>
                </td>
                <td class="skeleton-cell">
                    <div class="skeleton"></div>
                </td>
                <td class="skeleton-cell">
                    <div class="skeleton"></div>
                </td>
                <td class="skeleton-cell">
                    <div class="skeleton"></div>
                </td>
                <td class="skeleton-cell">
                    <div class="skeleton"></div>
                </td>
                <td class="skeleton-cell">
                    <div class="skeleton"></div>
                </td>
                <td class="skeleton-cell">
                    <div class="skeleton"></div>
                </td>
            </tr>
            `;
    }

    function NoDataFound() {
        return `
             <tr class="no-data-found">
                <td colspan="7" class="text-center">No Data Found</td>
            </tr>
            `;
    }

    function updatePagination(currentPage, lastPage, total, perpage) {
        let paginationContainer = document.getElementById('pagination-container');
        paginationContainer.innerHTML = ''; // Clear old pagination

        // Set the pagination container style
        paginationContainer.style.display = "flex";
        paginationContainer.style.justifyContent = "space-between";
        paginationContainer.style.alignItems = "center";

        // Showing result count info (e.g., Showing 1 to 25 of 3556 results)
        let start = (currentPage - 1) * perpage + 1;
        let end = Math.min(currentPage * perpage, total);
        let showingInfo = `Showing ${start} to ${end} of ${total} results`;
        paginationContainer.insertAdjacentHTML('beforeend', showingInfo);

        // Create Pagination Buttons

        // << First button
        let firstButton = `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}" data-bs-toggle="tooltip" data-bs-placement="top" title="First Page"><button class=" page-link" onclick="loadThemes(1)" >«</button> </li>`;

        // < Previous button
        let prevButton = `<li class="page-item ${currentPage > 1 ? '' : 'disabled'}" data-bs-toggle="tooltip" data-bs-placement="top" title="Previous"><button class=" page-link" onclick="loadThemes(${currentPage - 1})" >‹</button> </li>`;

        // Next button
        let nextButton = `<li class="page-item ${currentPage < lastPage ? '' : 'disabled'}" data-bs-toggle="tooltip" data-bs-placement="top" title="Next"><button class="page-link" onclick="loadThemes(${currentPage + 1})" >›</button> </li>`;

        // >> Last button
        let lastButton = `<li class="page-item ${currentPage === lastPage ? 'disabled' : ''}" data-bs-toggle="tooltip" data-bs-placement="top" title="Last Page"><button class=" page-link" onclick="loadThemes(${lastPage})" >»</button> </li>`;

        // Page Number Buttons (Dynamically show a range of pages around the current page)
        let pageButtons = '';
        let range = 2; // Show 2 pages before and after the current page
        let startPage = Math.max(1, currentPage - range);
        let endPage = Math.min(lastPage, currentPage + range);

        // Generate page numbers
        for (let i = startPage; i <= endPage; i++) {
            pageButtons += `<li class="page-item ${i === currentPage ? 'active' : ''}"><button class="page-link " onclick="loadThemes(${i})">${i}</button> </li>`;
        }

        // Add the pagination buttons and page numbers
        paginationContainer.insertAdjacentHTML('beforeend', `
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    ${firstButton}
                    ${prevButton}
                    ${pageButtons}
                    ${nextButton}
                    ${lastButton}
                </ul>
            </nav>
        `);

        // Update perpage dropdown if changed
        document.getElementById('perpage').value = perpage;
    }

    function debounceSearch(e) {
        if (e.keyCode === 13) {
            loadThemes(1); // Trigger the search when the user presses enter
        }
    }

    // Debounce function to handle input changes
    let debounceTimeout;

    function debounce(fn, delay) {
        return function() {
            clearTimeout(debounceTimeout);
            debounceTimeout = setTimeout(fn, delay);
        };
    };



    // SearchBar
    document.getElementById('search_filter').addEventListener('input', function() {
        const searchValue = document.getElementById('search_filter').value;
        if (searchValue) {
            document.getElementById('refreshSearch').style.display = 'inline-block'; // Show the refresh button
        } else {
            document.getElementById('refreshSearch').style.display = 'none'; // Hide the refresh button
        }
    });

    // Listen for changes in the perpage dropdown and reload data
    document.getElementById('perpage').addEventListener('change', () => loadThemes(1));

    // Listen for Enter key in the search filter and reload data
    document.getElementById('search_filter').addEventListener('keyup', debounceSearch);

    document.getElementById('refreshSearch').addEventListener('click', function() {
        document.getElementById('search_filter').value = ''; // Clear the search input
        loadThemes(1); // Reload the table data without the search filter
    });

    document.getElementById('searchSubmit').addEventListener('click', function() {
        loadThemes(1); // Reload the table data without the search filter
    });

    document.getElementById('filterSubmit').addEventListener('click', function() {
        loadThemes(1); // Reload the table data without the search filter
    });

    // Initial load
    loadThemes(1);
</script>
<script>
    $('#branch_filter').click(function() {
        $('.branch_filter').slideToggle('slow');
    });
</script>
<script>
    function qualification_filter_change() {
        var qualification_id = $('#qualification_filt').val();
        let hideMajorFor = ['4', '5', '6', 'Others'];

        // if (hideMajorFor.includes(qualification_id)) {
        //     $('#major_div').hide();
        //     $('#major_filt').val("").trigger("change");
        //     return; // stop ajax call
        // } else {
        //     $('#major_div').show();
        // }

        var majorDropdown = $('#major_filt');
        majorDropdown.empty().append('<option value="">All</option>');

        if (qualification_id) {
            $.ajax({
                url: "{{ route('major_list_by_qualification') }}",
                type: "GET",
                data: {
                    qualification_id: qualification_id
                },
                success: function(response) {
                    if (response.status === 200 && response.data) {
                        response.data.forEach(function(state) {
                            majorDropdown.append($('<option></option>').attr(
                                'value', state.sno).text(state
                                .major_name));
                        });
                        majorDropdown.append('<option value="Others">Others</option>');

                    }
                },
                error: function(error) {
                    console.error('Error fetching major:', error);
                }
            });

        }
    }
</script>
<script>
    $(document).ready(function() {
        $('.common_datepicker').datepicker({
            todayHighlight: true,
            autoclose: true,
            format: 'dd-M-yyyy'
        });
    });
</script>

<script>
    // Realtime mobile duplicate state is shared by Add/Edit forms. Server-side checks
    // remain authoritative when saving; this state only provides immediate feedback.
    const candidateMobileDuplicateState = {
        add: { timer: null, xhr: null, sequence: 0, value: '', checkedValue: '', duplicate: false, pending: false, failed: false },
        edit: { timer: null, xhr: null, sequence: 0, value: '', checkedValue: '', duplicate: false, pending: false, failed: false }
    };

    function normalizeCandidateMobileForInput(value) {
        let digits = String(value || '').replace(/\D/g, '');
        if (digits.startsWith('0091') && digits.length >= 14) {
            digits = digits.slice(4);
            if (digits.length > 10) digits = digits.slice(-10);
        } else if (digits.startsWith('91') && digits.length >= 12) {
            digits = digits.slice(2);
            if (digits.length > 10) digits = digits.slice(-10);
        } else if (digits.startsWith('0') && digits.length === 11) {
            digits = digits.slice(1);
        }
        // Do not strip a partially typed +91 prefix before its tenth local digit arrives.
        return digits;
    }

    function scheduleCandidateMobileDuplicateCheck(mode, immediate) {
        const isEdit = mode === 'edit';
        const inputSelector = isEdit ? '#candidate_mobile_edit' : '#candidate_mobile';
        const errorSelector = isEdit ? '#candidate_mobile_edit_err' : '#candidate_mobile_err';
        const $input = $(inputSelector);
        const $error = $(errorSelector);
        const state = candidateMobileDuplicateState[mode];
        let mobile = normalizeCandidateMobileForInput($input.val());
        const currentRaw = String($input.val() || '');
        const currentDigits = currentRaw.replace(/\D/g, '');

        if (currentDigits.length >= 12 && (currentDigits.startsWith('91') || currentDigits.startsWith('0091'))) {
            $input.val(mobile);
        } else if (currentDigits.length === 11 && currentDigits.startsWith('0')) {
            $input.val(mobile);
        }

        state.sequence++;
        const sequence = state.sequence;
        if (state.timer) clearTimeout(state.timer);
        if (state.xhr && state.xhr.readyState !== 4) state.xhr.abort();
        state.xhr = null;
        state.value = mobile;
        state.duplicate = false;
        state.pending = false;
        state.failed = false;

        if (!/^[6-9]\d{9}$/.test(mobile)) {
            state.checkedValue = '';
            if ($error.text().indexOf('already exists') !== -1 || $error.text().indexOf('Checking mobile') !== -1 || $error.text().indexOf('Could not verify') !== -1) {
                $error.text('');
            }
            return;
        }

        state.pending = true;
        state.checkedValue = '';
        $error.removeClass('text-success').addClass('text-danger').text('Checking mobile number…');

        const runCheck = function () {
            state.xhr = $.ajax({
                url: "{{ route('check_candidate_mobile') }}",
                type: 'POST',
                dataType: 'json',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content') || "{{ csrf_token() }}",
                    mobile: mobile,
                    exclude_applicant_id: isEdit ? ($('#edit_candidate_id').val() || '') : ''
                }
            }).done(function (response) {
                if (sequence !== state.sequence || normalizeCandidateMobileForInput($input.val()) !== mobile) return;
                state.pending = false;
                state.failed = false;
                state.checkedValue = mobile;
                state.duplicate = !!(response && response.data && response.data.exists);
                if (state.duplicate) {
                    $error.removeClass('text-success').addClass('text-danger').text('This mobile number already exists for another candidate.');
                } else {
                    $error.text('').removeClass('text-danger text-success');
                }
            }).fail(function (xhr, status) {
                if (status === 'abort' || sequence !== state.sequence) return;
                state.pending = false;
                state.failed = true;
                state.checkedValue = '';
                state.duplicate = false;
                $error.removeClass('text-success').addClass('text-danger').text('Could not verify mobile duplication right now. It will be checked again when saving.');
            });
        };

        state.timer = setTimeout(runCheck, immediate ? 0 : 350);
    }

    function validation_func() {
        let err = false;

        // The resume parser is responsible for filling candidate fields.
        // Client-side validation only blocks clearly invalid required values;
        // optional resume facts are never fabricated just to satisfy the form.
        const name = $('#candidate_name').val().trim();
        if (!name) {
            $('#candidate_name_err').text('Candidate name is required.');
            err = true;
        } else {
            $('#candidate_name_err').text('');
        }

        const mobile = normalizeCandidateMobileForInput($('#candidate_mobile').val());
        const mobilePattern = /^[6-9]\d{9}$/;
        if (!mobile) {
            $('#candidate_mobile_err').text('Indian mobile number is required.');
            err = true;
        } else if (!mobilePattern.test(mobile)) {
            $('#candidate_mobile_err').text('Enter a valid Indian 10-digit mobile number.');
            err = true;
        } else {
            $('#candidate_mobile').val(mobile);
            const mobileState = candidateMobileDuplicateState.add;
            if (mobileState.duplicate) {
                $('#candidate_mobile_err').text('This mobile number already exists for another candidate.');
                err = true;
            } else if (mobileState.pending || (!mobileState.failed && mobileState.checkedValue !== mobile)) {
                scheduleCandidateMobileDuplicateCheck('add', true);
                $('#candidate_mobile_err').text('Checking mobile number for duplicates. Please try saving again after the check completes.');
                err = true;
            } else if (!mobileState.failed) {
                $('#candidate_mobile_err').text('');
            }
        }

        const email = $('#candidate_email').val().trim();
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;
        if (!email) {
            $('#candidate_email_err').text('Candidate email is required.');
            err = true;
        } else if (!emailPattern.test(email)) {
            $('#candidate_email_err').text('Enter a valid email address.');
            err = true;
        } else {
            $('#candidate_email_err').text('');
        }

        $('#candidate_gender_err').text('');
        $('#candidate_marital_status_err').text('');
        $('#candidate_qualification_err').text('');
        $('#candidate_major_err').text('');
        $('#candidate_other_qualify_err').text('');
        $('#candidate_exper_type_err').text('');
        $('#candidate_exper_count_err').text('');

        const major = $('#candidate_major').val();
        const otherMajor = $('#candidate_other_qualify').val().trim();
        if (major === 'Others' && !otherMajor) {
            $('#candidate_other_qualify_err').text('Enter the resume education/specialization text for Other.');
            err = true;
        }

        const experType = $('#candidate_exper_type').val();
        const experCount = $('#candidate_exper_count').val().trim();
        if (experType === '2' && experCount !== '') {
            const exp = Number(experCount);
            if (!Number.isFinite(exp) || exp < 0 || exp > 60) {
                $('#candidate_exper_count_err').text('Experience must be between 0 and 60 years.');
                err = true;
            }
        }

        const hasResume = !!$('#upload_resume').val() || $('#resume_check').val() === '1';
        if (!hasResume && !$('#apply_applicant_id').val()) {
            $('#resume_err').text('Resume is required for a new candidate.');
            err = true;
        } else {
            $('#resume_err').text('');
        }

        // Never submit while the parser is still working.
        if (resumeParseInProgress) {
            toastr.info('Resume is still being read. Please wait a moment.');
            return false;
        }

        if (!err) {
            submit_form();
            return true;
        }

        return false;
    }
</script>
<script>
    let resumeParsedmajor = null;

    document.getElementById('kt_modal_add_paticipants')?.addEventListener('shown.bs.modal', function () {
        // Reset only transient mobile-check status; field values remain intact if the
        // modal is being used to attach an existing candidate to a request.
        candidateMobileDuplicateState.add.duplicate = false;
        candidateMobileDuplicateState.add.pending = false;
        candidateMobileDuplicateState.add.checkedValue = '';
        candidateMobileDuplicateState.add.failed = false;
        if ($('#candidate_mobile').val()) scheduleCandidateMobileDuplicateCheck('add', true);
        // The modal may be reused for multiple candidates in the same page session.
        // Clear only transient resume-parser state; linked applicant/job fields are preserved.
        resumeParsedmajor = null;
        $('#resume_check').val('0');
        $('#resume_extraction_token').val('');
        $('#resume_source_sha256').val('');
        $('#resume_parse_status').text('');
    });

    function submit_form() {
        const form = document.getElementById("jobApplyForm");
        const submitBtn = document.getElementById("addApplicantBtn");
        const submitBtnText = document.getElementById("yesBtnText");
        const submitBtnLoader = document.getElementById("yesBtnLoader");

        if (form) {
            submitBtn.disabled = true;
            submitBtnText.style.display = "none"; // Hide "Yes"
            submitBtnLoader.style.display = "inline-block"; // Show loader

            // Create FormData manually
            const formData = new FormData(form);

            $.ajax({
                url: form.action,
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // console.log("Success:", response);
                    if (response.status == '200') {
                        window.location.href = '/hr_recruitment/manage_candidate/';
                        submitBtn.disabled = true;
                        submitBtnText.style.display = "inline-block"; // Show "Yes" again
                        submitBtnLoader.style.display = "none"; // Hide loader
                    } else {
                        toastr.error(response.message);
                        // Re-enable the button and reset the text
                        submitBtn.disabled = false;
                        submitBtnText.style.display = "inline-block"; // Show "Yes" again
                        submitBtnLoader.style.display = "none"; // Hide loader
                    }
                },
                error: function(err) {
                    console.error("Error:", err);
                    toastr.error(err.responseJSON.message || 'An error occurred while submitting the form.');
                    // In case of an error, re-enable the button and reset the text
                    submitBtn.disabled = false;
                    submitBtnText.style.display = "inline-block"; // Show "Yes" again
                    submitBtnLoader.style.display = "none"; // Hide loader
                }
            });
        }
    }

    function candidate_qualification_change(){
        var qualification_id= $('#candidate_qualification').val();

        var majorDropdown = $('#candidate_major');
        majorDropdown.empty().append('<option value="">Select Major</option>');

        if (qualification_id) {
            $.ajax({
                url: "{{ route('major_list_by_qualification') }}",
                type: "GET",
                data: {
                    qualification_id: qualification_id
                },
                success: function(response) {
                    if (response.status === 200 && response.data) {
                        response.data.forEach(function(state) {
                            majorDropdown.append($('<option></option>').attr(
                                'value', state.sno).text(state
                                .major_name));
                        });
                        majorDropdown.append('<option value="Others">Others</option>');

                        if(resumeParsedmajor) {
                            $('#candidate_major').val(resumeParsedmajor).trigger('change');
                        }
                        
                    }
                },
                error: function(error) {
                    console.error('Error fetching major:', error);
                }
            });

        }
    }
    major_change_func()

    function major_change_func() {
        var candidate_major = $('#candidate_major').val();
        if (candidate_major == 'Others') {
            $('#candidate_other_qualify_div').show();
        } else {
            $('#candidate_other_qualify_div').hide();
        }

    }

    
    let resumeParseInProgress = false;
    let resumeParseRequest = null;

    function setResumeParsingState(isBusy, message = 'Reading resume…') {
        const btn = $('#addApplicantBtn');
        const text = $('#yesBtnText');
        const loader = $('#yesBtnLoader');

        if (isBusy) {
            btn.prop('disabled', true);
            text.hide();
            loader.html(
                '<span class="spinner-border spinner-border-sm"></span>' +
                '<span class="ms-2">' + escapeHtml(message) + '</span>'
            ).show();
        } else {
            btn.prop('disabled', false);
            text.show();
            loader.hide();
        }
    }

    function setSelectValueSafe(selector, value) {
        if (value === null || value === undefined || value === '') return false;
        const el = $(selector);
        const exists = el.find('option').filter(function () {
            return String($(this).val()) === String(value);
        }).length > 0;

        if (exists) {
            el.val(String(value)).trigger('change');
            return true;
        }

        return false;
    }

    function formatCandidateNameTitleCase(value) {
        const name = String(value || '').normalize('NFKC')
            .replace(/^(?:mr\.?|mrs\.?|ms\.?|miss\.?|dr\.?|prof\.?|shri|sri|smt\.?|kumari|thiru|selvi)\s+/iu, '')
            .replace(/\s+/gu, ' ').trim();
        if (!name) return '';

        // Format each name component, retaining Indian initials (R., S.K.) and
        // handling apostrophe/hyphen-separated names without changing the token order.
        const titleCased = name.toLocaleLowerCase('en-IN').replace(/(^|[\s.'’\-])(\p{L})/gu, function (match, separator, letter) {
            return separator + letter.toLocaleUpperCase('en-IN');
        });
        return titleCased.replace(/\bMc([a-z])/gu, function (match, letter) {
            return 'Mc' + letter.toLocaleUpperCase('en-IN');
        });
    }

    function setCandidateNameAssistStatus(source, candidateName) {
        const assist = $('#candidate_name_assist');
        const badge = assist.find('.badge');
        const message = assist.find('span').last();

        if (!candidateName) {
            badge.removeClass('bg-label-success bg-label-info bg-label-primary').addClass('bg-label-warning').text('Review needed');
            message.text('No reliable name was detected. Enter the candidate name manually before saving.');
            return;
        }

        if (String(source || '').indexOf('huggingface_') === 0) {
            badge.removeClass('bg-label-warning bg-label-info bg-label-primary').addClass('bg-label-success').text('AI suggestion');
            message.text('A name was suggested by Hugging Face and checked against resume text. Verify spelling and initials.');
        } else if (source === 'local_parser') {
            badge.removeClass('bg-label-warning bg-label-success bg-label-primary').addClass('bg-label-info').text('Parser suggestion');
            message.text('Hugging Face was unavailable or produced no verifiable name, so local resume rules were used. Please verify spelling.');
        } else if (source === 'manual_edit') {
            badge.removeClass('bg-label-warning bg-label-success bg-label-primary').addClass('bg-label-info').text('Manual edit');
            message.text('You edited the suggested name. Verify spelling and initials before saving.');
        } else {
            badge.removeClass('bg-label-warning bg-label-success bg-label-primary').addClass('bg-label-info').text('Resume suggestion');
            message.text('A name was extracted using the local parser fallback. Please verify spelling and initials.');
        }
    }

    let resumeNameAutoSuggestion = '';
    let resumeMobileAutoSuggestion = '';
    let resumeEmailAutoSuggestion = '';
    let resumeRoleAutoSuggestionIds = [];

    function normalizeCandidateRoleIds(ids) {
        if (!Array.isArray(ids)) return [];
        return Array.from(new Set(ids.map(function (id) {
            return String(id == null ? '' : id).trim();
        }).filter(function (id) { return /^[0-9]+$/.test(id); })));
    }

    function sameCandidateRoleIds(left, right) {
        const a = normalizeCandidateRoleIds(left).sort();
        const b = normalizeCandidateRoleIds(right).sort();
        return a.length === b.length && a.every(function (id, index) { return id === b[index]; });
    }

    let resumeQualificationAutoSuggestion = '';
    let resumeMajorAutoSuggestion = '';
    let resumeExperienceAutoSuggestionType = '';
    let resumeExperienceAutoSuggestionCount = '';
    let applyingResumeExperienceSuggestion = false;

    function normalizeCandidateExperienceCount(value) {
        const raw = String(value == null ? '' : value).trim();
        if (raw === '') return '';
        const number = Number(raw);
        if (!Number.isFinite(number) || number < 0 || number > 60) return '';
        return String(Math.round(number * 10) / 10);
    }

    function applyResumeExperienceSuggestion(data) {
        const suggestedType = String(data.candidate_experience_type == null ? '' : data.candidate_experience_type).trim();
        if (suggestedType !== '1' && suggestedType !== '2') return;

        const oldSuggestedType = resumeExperienceAutoSuggestionType;
        const oldSuggestedCount = resumeExperienceAutoSuggestionCount;
        const currentType = String($('#candidate_exper_type').val() || '').trim();
        const currentCount = normalizeCandidateExperienceCount($('#candidate_exper_count').val());
        const canReplaceType = currentType === '' || (oldSuggestedType !== '' && currentType === oldSuggestedType);
        const canReplaceCount = currentCount === '' || (oldSuggestedCount !== '' && currentCount === oldSuggestedCount);

        // Never override a populated type that no longer equals the prior parser
        // suggestion: it is treated as recruiter-edited input.
        if (!canReplaceType) {
            resumeExperienceAutoSuggestionType = '';
            if (!canReplaceCount) resumeExperienceAutoSuggestionCount = '';
            return;
        }

        applyingResumeExperienceSuggestion = true;
        resumeExperienceAutoSuggestionType = suggestedType;
        $('#candidate_exper_type').val(suggestedType).trigger('change');

        if (suggestedType === '1') {
            // Fresher means no professional years; toggleExperience hides and clears it.
            resumeExperienceAutoSuggestionCount = '';
        } else {
            const rawYears = data.candidate_experience_years;
            const parsedYears = rawYears === null || rawYears === undefined || rawYears === ''
                ? null : Number(rawYears);
            if (parsedYears !== null && Number.isFinite(parsedYears) && parsedYears > 0 && parsedYears <= 60 && canReplaceCount) {
                const count = normalizeCandidateExperienceCount(parsedYears.toFixed(1));
                $('#candidate_exper_count').val(count);
                resumeExperienceAutoSuggestionCount = count;
            } else if (parsedYears === null && oldSuggestedCount !== '' && currentCount === oldSuggestedCount) {
                // An experienced classification without trustworthy dates should not
                // leave the previous resume's year count behind.
                $('#candidate_exper_count').val('');
                resumeExperienceAutoSuggestionCount = '';
            } else if (!canReplaceCount) {
                resumeExperienceAutoSuggestionCount = '';
            }
        }
        applyingResumeExperienceSuggestion = false;
    }

    $('#candidate_exper_type').on('change.resumeExperienceAutomation', function () {
        if (applyingResumeExperienceSuggestion) return;
        const currentType = String($(this).val() || '').trim();
        if (resumeExperienceAutoSuggestionType !== '' && currentType !== resumeExperienceAutoSuggestionType) {
            resumeExperienceAutoSuggestionType = '';
        }
    });

    $('#candidate_exper_count').on('input.resumeExperienceAutomation change.resumeExperienceAutomation', function () {
        if (applyingResumeExperienceSuggestion) return;
        const currentCount = normalizeCandidateExperienceCount($(this).val());
        if (resumeExperienceAutoSuggestionCount !== '' && currentCount !== resumeExperienceAutoSuggestionCount) {
            resumeExperienceAutoSuggestionCount = '';
        }
    });

    function applyResumeQualificationMajorSuggestions(data) {
        const qualification = String(data.candidate_qualification || '').trim();
        const major = String(data.candidate_major || '').trim();
        const currentQualification = String($('#candidate_qualification').val() || '').trim();
        const canReplaceQualification = currentQualification === '' || currentQualification === resumeQualificationAutoSuggestion;
        if (qualification && canReplaceQualification) {
            $('#candidate_qualification').val(qualification).trigger('change');
            resumeQualificationAutoSuggestion = qualification;
            if (major) {
                // Existing onchange loads the database-backed major options asynchronously.
                resumeParsedmajor = major;
                let attempts = 0;
                const selectMajorWhenLoaded = function () {
                    attempts++;
                    const optionExists = $('#candidate_major option').filter(function () { return String(this.value) === major; }).length > 0;
                    if (optionExists) {
                        const currentMajor = String($('#candidate_major').val() || '').trim();
                        if (currentMajor === '' || currentMajor === resumeMajorAutoSuggestion) {
                            $('#candidate_major').val(major).trigger('change');
                            resumeMajorAutoSuggestion = major;
                        }
                    } else if (attempts < 20) {
                        setTimeout(selectMajorWhenLoaded, 150);
                    }
                };
                selectMajorWhenLoaded();
            }
        }
        // A qualification may be confidently detected even when no database major
        // matches. Do not invent a major; leave it for recruiter selection.
    }

    function applyResumeRoleSuggestions(data) {
        const select = $('#candidate_role_ids');
        const status = $('#candidate_role_match_status');
        if (!select.length || !status.length) return;

        const matches = Array.isArray(data.candidate_role_matches) ? data.candidate_role_matches : [];
        const suggestedIds = normalizeCandidateRoleIds(
            Array.isArray(data.suggested_job_role_ids) && data.suggested_job_role_ids.length
                ? data.suggested_job_role_ids
                : matches.map(function (match) { return match.role_id; })
        );
        const currentIds = normalizeCandidateRoleIds(select.val() || []);
        const previousSuggestionIds = normalizeCandidateRoleIds(resumeRoleAutoSuggestionIds);
        const currentIsPreviousSuggestion = previousSuggestionIds.length > 0 && sameCandidateRoleIds(currentIds, previousSuggestionIds);
        const canApplyAutomatically = currentIds.length === 0 || currentIsPreviousSuggestion;
        let applied = false;

        if (canApplyAutomatically) {
            // Replace only an empty role selection or this script's previous suggestion.
            // If a recruiter changed the selection manually, leave it untouched.
            select.val(suggestedIds).trigger('change');
            resumeRoleAutoSuggestionIds = suggestedIds.slice();
            applied = suggestedIds.length > 0;
        } else {
            resumeRoleAutoSuggestionIds = [];
        }

        if (matches.length) {
            const preview = matches.slice(0, 5).map(function (match) {
                const roleName = String(match.role_name || 'Role');
                const score = Number(match.match_score || 0);
                return roleName + ' (' + (Number.isFinite(score) ? Math.max(0, Math.min(100, Math.round(score))) : 0) + '%)';
            }).join(', ');
            const suffix = applied
                ? ' These roles were selected automatically; review them before saving.'
                : ' Your current selections were preserved; review the suggestions above.';
            status.removeClass('text-muted text-warning').addClass('text-success')
                .text('Eligible role matches: ' + preview + '.' + suffix);
        } else {
            if (currentIsPreviousSuggestion && currentIds.length) {
                select.val(null).trigger('change');
            }
            resumeRoleAutoSuggestionIds = [];
            status.removeClass('text-success').addClass('text-muted')
                .text('No reliable role match was found from the available resume details. Choose roles manually; no role is required.');
        }
    }

    function populateResumeData(data) {
        data = data || {};

        const extractedCandidateName = formatCandidateNameTitleCase(data.candidate_name || '');
        const currentName = String($('#candidate_name').val() || '').trim();
        const currentWasPreviousSuggestion = currentName !== '' && resumeNameAutoSuggestion !== '' && currentName === resumeNameAutoSuggestion;

        // Candidate name, Indian mobile and email are suggested from resume evidence.
        // Never replace a value that a recruiter manually entered.
        if (extractedCandidateName && (currentName === '' || currentWasPreviousSuggestion)) {
            $('#candidate_name').val(extractedCandidateName);
            resumeNameAutoSuggestion = extractedCandidateName;
            setCandidateNameAssistStatus(data.candidate_name_source || 'local_parser', extractedCandidateName);
        } else if (currentName !== '') {
            setCandidateNameAssistStatus('manual_edit', currentName);
        } else {
            resumeNameAutoSuggestion = '';
            setCandidateNameAssistStatus('not_found', '');
        }

        const extractedMobile = normalizeCandidateMobileForInput(data.candidate_mobile || '');
        const currentMobile = String($('#candidate_mobile').val() || '').trim();
        const currentWasPreviousMobileSuggestion = currentMobile !== '' && resumeMobileAutoSuggestion !== '' && currentMobile === resumeMobileAutoSuggestion;
        if (/^[6-9][0-9]{9}$/.test(extractedMobile) && (currentMobile === '' || currentWasPreviousMobileSuggestion)) {
            $('#candidate_mobile').val(extractedMobile);
            resumeMobileAutoSuggestion = extractedMobile;
            scheduleCandidateMobileDuplicateCheck('add', true);
        } else if (currentMobile !== '') {
            scheduleCandidateMobileDuplicateCheck('add', true);
        }

        // Email is extracted locally from resume text/OCR. Do not replace a value
        // manually entered by the recruiter; only refresh an empty/previous suggestion.
        const extractedEmail = String(data.candidate_email || '').trim().toLowerCase().replace(/\s+/g, '');
        const currentEmail = String($('#candidate_email').val() || '').trim().toLowerCase();
        const currentWasPreviousEmailSuggestion = currentEmail !== '' && resumeEmailAutoSuggestion !== '' && currentEmail === resumeEmailAutoSuggestion;
        const plausibleEmail = /^[^\s@]+@[^\s@.]+(?:\.[^\s@.]{2,})+$/.test(extractedEmail);
        if (plausibleEmail && (currentEmail === '' || currentWasPreviousEmailSuggestion)) {
            $('#candidate_email').val(extractedEmail);
            resumeEmailAutoSuggestion = extractedEmail;
        } else if (currentEmail !== '') {
            // Keep the recruiter's current value untouched.
        } else if (!plausibleEmail) {
            resumeEmailAutoSuggestion = '';
        }

        applyResumeRoleSuggestions(data);
        applyResumeQualificationMajorSuggestions(data);
        applyResumeExperienceSuggestion(data);

        $('#resume_check').val('1');
        $('#resume_extraction_token').val(data.resume_extraction_token || '');
        $('#resume_source_sha256').val(data.resume_source_sha256 || '');

        const statusElement = $('#resume_parse_status');
        const engine = String(data.text_extraction_engine || 'text parser');
        const suggestedFields = [];
        if (extractedCandidateName) suggestedFields.push('name');
        if (/^[6-9][0-9]{9}$/.test(extractedMobile)) suggestedFields.push('mobile');
        if (plausibleEmail) suggestedFields.push('email');
        if (Array.isArray(data.candidate_role_matches) && data.candidate_role_matches.length) suggestedFields.push('job roles');
        if (data.candidate_qualification) suggestedFields.push('qualification');
        if (data.candidate_major) suggestedFields.push('major');
        if (data.candidate_experience_type) suggestedFields.push('experience type');
        if (data.candidate_experience_years !== null && data.candidate_experience_years !== undefined) suggestedFields.push('experience years');
        if (data.text_extraction_status === 'unreadable') {
            statusElement.removeClass('text-primary text-success').addClass('text-warning')
                .text('File selected • Text could not be read • You can still attach it and enter the fields manually.');
        } else if (suggestedFields.length > 0) {
            statusElement.removeClass('text-warning text-primary').addClass('text-success')
                .text('Resume text read (' + engine + ') • Suggested: ' + suggestedFields.join(', ') + ' • Verify before saving.');
        } else {
            statusElement.removeClass('text-success text-primary').addClass('text-warning')
                .text('Resume text read (' + engine + ') • No reliable name, mobile or email found • Enter the fields manually.');
        }
    }

    function handleResumeParseError(xhr) {
        $('#resume_extraction_token').val('');
        $('#resume_source_sha256').val('');
        const message =
            xhr?.responseJSON?.message ||
            'Resume text could not be fully read. Continue entering the fields manually.';

        if (!$('#resume_parse_status').length) {
            $('#resume_preview').append(
                '<div id="resume_parse_status" class="small text-warning mt-1"></div>'
            );
        }

        $('#resume_parse_status').html(
            '<i class="mdi mdi-alert-outline me-1"></i>' +
            escapeHtml(message)
        );
        $('#candidate_name_assist').find('.badge')
            .removeClass('bg-label-success bg-label-info bg-label-primary')
            .addClass('bg-label-warning')
            .text('Manual review');
        $('#candidate_name_assist').find('span').last()
            .text('No reliable name suggestion is available. Enter the candidate name manually; the file can still be attached.');

        toastr.warning('Resume selected. Please review the candidate-name suggestion and enter other fields manually.');
    }


    /* ============================================================
       Uploaded Resume Viewer
       - PDF: inline iframe/blob preview
       - Images: inline image preview + zoom controls
       - DOCX: locally rendered Word-style document inside the modal
       - Legacy DOC: safe fallback with Open button
       - Blob URL is revoked on reset/modal close to avoid leaks
    ============================================================ */
    let resumeViewerObjectUrl = null;
    let resumeViewerCurrentFile = null;
    let resumeViewerImageScale = 1;

    function resumeViewerFormatBytes(bytes) {
        const value = Number(bytes || 0);

        if (value < 1024) {
            return value + ' B';
        }

        if (value < 1024 * 1024) {
            return (value / 1024).toFixed(1) + ' KB';
        }

        return (value / (1024 * 1024)).toFixed(2) + ' MB';
    }

    function resumeViewerExtension(file) {
        return (file?.name?.split('.').pop() || '').toLowerCase();
    }

    function resumeViewerIsImage(ext) {
        return ['jpg', 'jpeg', 'png', 'webp', 'tif', 'tiff'].includes(ext);
    }

    function resumeViewerIsPdf(ext) {
        return ext === 'pdf';
    }

    function resumeViewerResetVisualState() {
        $('#resumeFileViewerFrame').hide().attr('src', 'about:blank');
        $('#resumeFileViewerDocxWrap').hide();
        $('#resumeFileViewerDocxLoading').hide();
        $('#resumeFileViewerDocxContent').empty();
        $('#resumeFileViewerImageWrap').hide();
        $('#resumeFileViewerEmpty').hide();

        $('#resumeFileViewerImageControls')
            .addClass('d-none')
            .removeClass('d-flex');

        $('#resumeFileViewerOpenBtn').hide();
        $('#resumeFileViewerTypeBadge').text('File');

        resumeViewerImageScale = 1;
        $('#resumeFileViewerImage').css('transform', 'scale(1)').removeAttr('src');
    }

    function resumeViewerRevokeObjectUrl() {
        if (resumeViewerObjectUrl) {
            try {
                URL.revokeObjectURL(resumeViewerObjectUrl);
            } catch (e) {
                // Ignore browser cleanup errors.
            }
            resumeViewerObjectUrl = null;
        }
    }

    function resumeViewerSetImageScale(scale) {
        resumeViewerImageScale = Math.max(0.4, Math.min(2.5, scale));

        $('#resumeFileViewerImage').css(
            'transform',
            'scale(' + resumeViewerImageScale + ')'
        );
    }

    function resumeViewerLoadMammoth() {
        if (window.mammoth) return Promise.resolve(window.mammoth);
        if (window.resumeMammothLoadPromise) return window.resumeMammothLoadPromise;

        window.resumeMammothLoadPromise = new Promise(function (resolve, reject) {
            const script = document.createElement('script');
            script.src = 'https://cdnjs.cloudflare.com/ajax/libs/mammoth/1.8.0/mammoth.browser.min.js';
            script.async = true;
            script.onload = function () {
                if (window.mammoth) resolve(window.mammoth);
                else reject(new Error('Word preview library did not initialize.'));
            };
            script.onerror = function () { reject(new Error('Could not load the Word preview component.')); };
            document.head.appendChild(script);
        });
        return window.resumeMammothLoadPromise;
    }

    function resumeViewerSanitizeWordHtml(html) {
        const parser = new DOMParser();
        const parsed = parser.parseFromString('<div>' + String(html || '') + '</div>', 'text/html');
        const root = parsed.body.firstElementChild;
        const allowed = new Set(['P','BR','STRONG','B','EM','I','U','S','H1','H2','H3','H4','H5','H6','UL','OL','LI','TABLE','THEAD','TBODY','TR','TD','TH','BLOCKQUOTE','PRE','CODE','A','IMG','SPAN','DIV']);

        function clean(node) {
            Array.from(node.children || []).forEach(function (child) {
                if (!allowed.has(child.tagName)) {
                    child.replaceWith(parsed.createTextNode(child.textContent || ''));
                    return;
                }
                Array.from(child.attributes || []).forEach(function (attr) {
                    const name = attr.name.toLowerCase();
                    if (child.tagName === 'A' && name === 'href') {
                        const value = attr.value.trim();
                        if (!/^(https?:|mailto:)/i.test(value)) child.removeAttribute(attr.name);
                    } else if (child.tagName === 'IMG' && name === 'src') {
                        if (!/^data:image\/(png|jpeg|gif|webp);base64,/i.test(attr.value)) child.removeAttribute(attr.name);
                    } else if (!(child.tagName === 'IMG' && ['alt','width','height'].includes(name))) {
                        child.removeAttribute(attr.name);
                    }
                });
                if (child.tagName === 'A') {
                    child.setAttribute('target', '_blank');
                    child.setAttribute('rel', 'noopener noreferrer');
                }
                clean(child);
            });
            return node;
        }
        return clean(root);
    }

    async function resumeViewerRenderDocx(file) {
        $('#resumeFileViewerDocxWrap').css('display', 'block');
        $('#resumeFileViewerDocxLoading').show();
        $('#resumeFileViewerDocxContent').empty();
        try {
            const mammoth = await resumeViewerLoadMammoth();
            const arrayBuffer = await file.arrayBuffer();
            const result = await mammoth.convertToHtml({ arrayBuffer: arrayBuffer });
            const safeContent = resumeViewerSanitizeWordHtml(result.value || '<p>No readable text was found in this document.</p>');
            $('#resumeFileViewerDocxContent').empty().append(safeContent);
            if (result.messages && result.messages.length) {
                $('#resumeFileViewerMeta').text($('#resumeFileViewerMeta').text() + ' • Some Word formatting may not be shown exactly.');
            }
        } catch (error) {
            $('#resumeFileViewerDocxWrap').hide();
            $('#resumeFileViewerEmptyTitle').text('Word preview unavailable');
            $('#resumeFileViewerEmptyText').text('This DOCX could not be rendered in the modal. You can still open or download the original file.');
            $('#resumeFileViewerEmpty').css('display', 'flex');
            console.warn('Resume DOCX preview failed:', error);
        } finally {
            $('#resumeFileViewerDocxLoading').hide();
        }
    }

    function openResumeFileViewer(file) {
        if (!file) return;

        resumeViewerRevokeObjectUrl();
        resumeViewerCurrentFile = file;
        const ext = resumeViewerExtension(file);
        // Treat uploaded HTML as plain text; do not execute untrusted HTML in the viewer.
        const viewerBlob = ['html', 'htm'].includes(ext)
            ? new Blob([file], { type: 'text/plain;charset=UTF-8' })
            : file;
        resumeViewerObjectUrl = URL.createObjectURL(viewerBlob);

        const size = resumeViewerFormatBytes(file.size);
        const type = file.type || 'Unknown';
        $('#resumeFileViewerTitle').text(file.name);
        $('#resumeFileViewerMeta').text((ext ? ext.toUpperCase() : 'FILE') + ' • ' + size + (type ? ' • ' + type : ''));
        resumeViewerResetVisualState();

        if (resumeViewerIsPdf(ext)) {
            $('#resumeFileViewerTypeBadge').text('PDF');
            $('#resumeFileViewerFrame').attr('src', resumeViewerObjectUrl).css('display', 'block');
        } else if (resumeViewerIsImage(ext)) {
            $('#resumeFileViewerTypeBadge').text('IMAGE');
            $('#resumeFileViewerImage').attr('src', resumeViewerObjectUrl).one('load', function () { resumeViewerSetImageScale(1); });
            $('#resumeFileViewerImageWrap').css('display', 'flex');
            $('#resumeFileViewerImageControls').removeClass('d-none').addClass('d-flex');
        } else if (ext === 'docx') {
            $('#resumeFileViewerTypeBadge').text('WORD · DOCX');
            $('#resumeFileViewerOpenBtn').attr('href', resumeViewerObjectUrl).css('display', 'inline-flex');
            // Render locally in this modal. The candidate's resume is not sent to Microsoft or another document service.
            resumeViewerRenderDocx(file);
        } else {
            $('#resumeFileViewerTypeBadge').text(ext ? ext.toUpperCase() : 'DOCUMENT');
            $('#resumeFileViewerEmptyTitle').text(ext === 'doc' ? 'Legacy Word format' : 'Preview unavailable');
            $('#resumeFileViewerEmptyText').text(ext === 'doc'
                ? 'This older .DOC format cannot be rendered reliably in the browser. Open or download the original file to review it in Microsoft Word.'
                : 'This file type cannot be rendered directly inside the browser. You can still open the exact selected file using the button below.');
            $('#resumeFileViewerEmpty').css('display', 'flex');
        }

        $('#resumeFileViewerOpenBtn').attr('href', resumeViewerObjectUrl).css('display', 'inline-flex');
        $('#resumeFileViewerEmptyOpenBtn').attr('href', resumeViewerObjectUrl);
        const modalElement = document.getElementById('resumeFileViewerModal');
        bootstrap.Modal.getOrCreateInstance(modalElement).show();
    }

    $('#resume_file_view_btn').on('click', function () {
        const input = document.getElementById('upload_resume');
        const file = input?.files?.[0];

        if (!file) {
            toastr.info('Please upload a resume first.');
            return;
        }

        openResumeFileViewer(file);
    });

    $('#resumeFileViewerZoomIn').on('click', function () {
        resumeViewerSetImageScale(resumeViewerImageScale + 0.2);
    });

    $('#resumeFileViewerZoomOut').on('click', function () {
        resumeViewerSetImageScale(resumeViewerImageScale - 0.2);
    });

    $('#resumeFileViewerZoomReset').on('click', function () {
        resumeViewerSetImageScale(1);
    });

    $('#resumeFileViewerModal').on('hidden.bs.modal', function () {
        $('#resumeFileViewerFrame').attr('src', 'about:blank');
        $('#resumeFileViewerImage').removeAttr('src');
        resumeViewerRevokeObjectUrl();
        resumeViewerCurrentFile = null;
        resumeViewerResetVisualState();
    });

    $('#candidate_mobile').on('input keyup change', function () {
        const before = String($(this).val() || '');
        const normalized = normalizeCandidateMobileForInput(before);
        const digits = before.replace(/\D/g, '');
        const partialCountryPrefix = (digits.startsWith('91') && digits.length < 12) || (digits.startsWith('0091') && digits.length < 14);
        if (before !== normalized && digits.length >= 11 && !partialCountryPrefix) $(this).val(normalized);
        if (String($(this).val() || '').trim() !== resumeMobileAutoSuggestion) resumeMobileAutoSuggestion = '';
        scheduleCandidateMobileDuplicateCheck('add', false);
    });

    $('#candidate_mobile_edit').on('input keyup change', function () {
        const before = String($(this).val() || '');
        const normalized = normalizeCandidateMobileForInput(before);
        const digits = before.replace(/\D/g, '');
        const partialCountryPrefix = (digits.startsWith('91') && digits.length < 12) || (digits.startsWith('0091') && digits.length < 14);
        if (before !== normalized && digits.length >= 11 && !partialCountryPrefix) $(this).val(normalized);
        scheduleCandidateMobileDuplicateCheck('edit', false);
    });

    $('#candidate_email').on('input change', function () {
        const current = String($(this).val() || '').trim().toLowerCase();
        if (current !== resumeEmailAutoSuggestion) resumeEmailAutoSuggestion = '';
    });

    $('#candidate_name').on('input', function () {
        const current = String($(this).val() || '').trim();
        if (current !== resumeNameAutoSuggestion) resumeNameAutoSuggestion = '';
        setCandidateNameAssistStatus('manual_edit', current);
    });

    $('#candidate_name').on('blur', function () {
        const formattedName = formatCandidateNameTitleCase($(this).val());
        if (formattedName) $(this).val(formattedName);
    });

    $('#upload_resume').on('change', function () {
        const input = this;
        const file = input.files && input.files[0];

        if (!file) return;

        const maxSize = 10 * 1024 * 1024;
        const ext = (file.name.split('.').pop() || '').toLowerCase();
        const allowedExtensions = ['pdf','doc','docx','docm','odt','rtf','txt','text','md','markdown','html','htm','ppt','pptx','xls','xlsx','jpg','jpeg','png','webp','bmp','gif','tif','tiff'];

        if (!allowedExtensions.includes(ext)) {
            $(input).val('');
            $('#resume_err').text('Unsupported resume format.');
            toastr.error('Please upload a supported PDF, Word, ODT, RTF, text/HTML, PowerPoint, Excel or image resume.');
            return;
        }

        if (file.size > maxSize) {
            $(input).val('');
            $('#resume_err').text('Resume must be 10MB or smaller.');
            $('#resume_file_view_btn').removeClass('is-visible');
            resumeViewerRevokeObjectUrl();
            toastr.error('Resume file is too large. Maximum size is 10MB.');
            return;
        }

        // When a new resume replaces the previous one, clear only the old
        // auto-suggestion. Never clear a name the recruiter typed or edited.
        const currentCandidateName = String($('#candidate_name').val() || '').trim();
        if (resumeNameAutoSuggestion !== '' && currentCandidateName === resumeNameAutoSuggestion) {
            $('#candidate_name').val('');
            resumeNameAutoSuggestion = '';
            setCandidateNameAssistStatus('not_found', '');
        }
        const currentCandidateMobile = String($('#candidate_mobile').val() || '').trim();
        if (resumeMobileAutoSuggestion !== '' && currentCandidateMobile === resumeMobileAutoSuggestion) {
            $('#candidate_mobile').val('');
            resumeMobileAutoSuggestion = '';
            candidateMobileDuplicateState.add.sequence++;
            if (candidateMobileDuplicateState.add.xhr && candidateMobileDuplicateState.add.xhr.readyState !== 4) candidateMobileDuplicateState.add.xhr.abort();
            candidateMobileDuplicateState.add.checkedValue = '';
            candidateMobileDuplicateState.add.duplicate = false;
            candidateMobileDuplicateState.add.pending = false;
            $('#candidate_mobile_err').text('');
        }
        const currentCandidateEmail = String($('#candidate_email').val() || '').trim().toLowerCase();
        if (resumeEmailAutoSuggestion !== '' && currentCandidateEmail === resumeEmailAutoSuggestion) {
            $('#candidate_email').val('');
            resumeEmailAutoSuggestion = '';
        }
        const currentRoleIdsBeforeReplacement = normalizeCandidateRoleIds($('#candidate_role_ids').val() || []);
        if (resumeRoleAutoSuggestionIds.length && sameCandidateRoleIds(currentRoleIdsBeforeReplacement, resumeRoleAutoSuggestionIds)) {
            $('#candidate_role_ids').val(null).trigger('change');
        }
        resumeRoleAutoSuggestionIds = [];

        const experienceTypeBeforeReplacement = String($('#candidate_exper_type').val() || '').trim();
        const experienceCountBeforeReplacement = normalizeCandidateExperienceCount($('#candidate_exper_count').val());
        if (resumeExperienceAutoSuggestionType !== '' && experienceTypeBeforeReplacement === resumeExperienceAutoSuggestionType) {
            $('#candidate_exper_type').val('').trigger('change');
        }
        if (resumeExperienceAutoSuggestionCount !== '' && experienceCountBeforeReplacement === resumeExperienceAutoSuggestionCount) {
            $('#candidate_exper_count').val('');
        }
        resumeExperienceAutoSuggestionType = '';
        resumeExperienceAutoSuggestionCount = '';
        $('#candidate_role_match_status').removeClass('text-success text-warning').addClass('text-muted')
            .text('Analysing education, work history, internships and skills for eligible roles…');

        $('#resume_err').text('');
        $('#resume_file_name').text(file.name);
        $('#resume_preview').removeClass('d-none');
        $('#resume_file_view_btn').addClass('is-visible');

        const pdfIcon = "{{asset('assets/egc_images/pdf_icon.png')}}";
        const wordIcon = "{{asset('assets/egc_images/docx_icon.png')}}";
        $('#uploadedlogo').attr('src', ext === 'pdf' ? pdfIcon : wordIcon);

        if (resumeParseRequest && resumeParseRequest.readyState !== 4) {
            resumeParseRequest.abort();
        }

        const formData = new FormData();
        formData.append('upload_resume', file);
        formData.append('_token', '{{ csrf_token() }}');
        $('#resume_extraction_token').val('');
        $('#resume_source_sha256').val('');
        $('#resume_check').val('0');

        resumeParseInProgress = true;
        setResumeParsingState(true, 'Reading resume…');
        $('#candidate_name_assist').find('.badge')
            .removeClass('bg-label-success bg-label-warning bg-label-info')
            .addClass('bg-label-primary')
            .text('Reading resume');
        $('#candidate_name_assist').find('span').last()
            .text('Reading resume text and identifying candidate details and eligible job roles…');

        $('#resume_parse_status').remove();
        $('#resume_preview').append(
            '<div id="resume_parse_status" class="small text-primary mt-1" aria-live="polite">' +
            '<span class="spinner-border spinner-border-sm me-1"></span>' +
            'Reading supported file formats and suggesting candidate details and eligible job roles…</div>'
        );

        resumeParseRequest = $.ajax({
            url: "{{ route('extract_resume') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            timeout: 120000,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        .done(function (response) {
            if (response && Number(response.status) === 200 && response.data) {
                populateResumeData(response.data);
                $('#resume_check').val('1');
                $('#resume_extraction_token').val(response.data.resume_extraction_token || '');
                $('#resume_source_sha256').val(response.data.resume_source_sha256 || '');

                const resumeSuggestionLabels = [];
                if (response.data.candidate_name) resumeSuggestionLabels.push('name');
                if (response.data.candidate_mobile) resumeSuggestionLabels.push('mobile');
                if (response.data.candidate_email) resumeSuggestionLabels.push('email');
                if (Array.isArray(response.data.candidate_role_matches) && response.data.candidate_role_matches.length) resumeSuggestionLabels.push('eligible job roles');
                if (resumeSuggestionLabels.length) {
                    toastr.success('Resume suggestions ready: ' + resumeSuggestionLabels.join(', ') + '. Verify before saving.');
                } else {
                    toastr.info(response.message || 'Resume selected. Enter candidate details manually if no suggestions appear.');
                }
            } else {
                handleResumeParseError({ responseJSON: response || {} });
            }
        })
        .fail(function (xhr, status) {
            if (status !== 'abort') {
                console.error('Resume extraction error:', xhr);
                handleResumeParseError(xhr);
            }
        })
        .always(function () {
            resumeParseInProgress = false;
            resumeParseRequest = null;
            setResumeParsingState(false);
        });
    });


    // Drag-and-drop uses the same validation and asynchronous extraction pathway as Browse.
    $('#resumeDropzone').on('dragenter dragover', function (event) {
        event.preventDefault();
        event.stopPropagation();
        $(this).addClass('is-dragover');
    });
    $('#resumeDropzone').on('dragleave dragend', function (event) {
        event.preventDefault();
        event.stopPropagation();
        $(this).removeClass('is-dragover');
    });
    $('#resumeDropzone').on('drop', function (event) {
        event.preventDefault();
        event.stopPropagation();
        $(this).removeClass('is-dragover');
        const files = event.originalEvent?.dataTransfer?.files;
        if (!files || !files.length) return;
        try {
            const transfer = new DataTransfer();
            transfer.items.add(files[0]);
            document.getElementById('upload_resume').files = transfer.files;
            $('#upload_resume').trigger('change');
        } catch (error) {
            toastr.info('Use Choose resume if drag-and-drop is not supported by this browser.');
        }
    });
    $('#resumeDropzone').on('click', function (event) {
        if ($(event.target).closest('button, label, a, input').length) return;
        $('#upload_resume').trigger('click');
    });
    $('#resumeDropzone').on('keydown', function (event) {
        if (event.key === 'Enter' || event.key === ' ') {
            event.preventDefault();
            $('#upload_resume').trigger('click');
        }
    });

    $('.file-reset').on('click', function () {
        if (resumeParseRequest && resumeParseRequest.readyState !== 4) {
            resumeParseRequest.abort();
        }

        resumeParseInProgress = false;
        $('#upload_resume').val('');
        $('#resume_preview').addClass('d-none');
        $('#resume_file_view_btn').removeClass('is-visible');
        $('#resume_file_name').text('');
        $('#resume_parse_status').text('').removeClass('text-warning text-success').addClass('text-muted');
        resumeViewerRevokeObjectUrl();
        resumeViewerCurrentFile = null;
        resumeViewerResetVisualState();
        $('#resume_err').text('');
        $('#resume_check').val('0');
        $('#resume_extraction_token').val('');
        $('#resume_source_sha256').val('');

        const nameInput = String($('#candidate_name').val() || '').trim();
        if (resumeNameAutoSuggestion !== '' && nameInput === resumeNameAutoSuggestion) {
            $('#candidate_name').val('');
            setCandidateNameAssistStatus('not_found', '');
        }
        resumeNameAutoSuggestion = '';
        const mobileInput = String($('#candidate_mobile').val() || '').trim();
        if (resumeMobileAutoSuggestion !== '' && mobileInput === resumeMobileAutoSuggestion) {
            $('#candidate_mobile').val('');
        }
        resumeMobileAutoSuggestion = '';
        const emailInput = String($('#candidate_email').val() || '').trim().toLowerCase();
        if (resumeEmailAutoSuggestion !== '' && emailInput === resumeEmailAutoSuggestion) {
            $('#candidate_email').val('');
        }
        resumeEmailAutoSuggestion = '';
        const roleIdsOnResumeReset = normalizeCandidateRoleIds($('#candidate_role_ids').val() || []);
        if (resumeRoleAutoSuggestionIds.length && sameCandidateRoleIds(roleIdsOnResumeReset, resumeRoleAutoSuggestionIds)) {
            $('#candidate_role_ids').val(null).trigger('change');
        }
        resumeRoleAutoSuggestionIds = [];
        const experienceTypeOnReset = String($('#candidate_exper_type').val() || '').trim();
        const experienceCountOnReset = normalizeCandidateExperienceCount($('#candidate_exper_count').val());
        if (resumeExperienceAutoSuggestionType !== '' && experienceTypeOnReset === resumeExperienceAutoSuggestionType) {
            $('#candidate_exper_type').val('').trigger('change');
        }
        if (resumeExperienceAutoSuggestionCount !== '' && experienceCountOnReset === resumeExperienceAutoSuggestionCount) {
            $('#candidate_exper_count').val('');
        }
        resumeExperienceAutoSuggestionType = '';
        resumeExperienceAutoSuggestionCount = '';
        $('#candidate_role_match_status').removeClass('text-success text-warning').addClass('text-muted')
            .text('Upload a resume to suggest eligible roles using education, work history, internships and skills.');
        candidateMobileDuplicateState.add.sequence++;
        if (candidateMobileDuplicateState.add.xhr && candidateMobileDuplicateState.add.xhr.readyState !== 4) candidateMobileDuplicateState.add.xhr.abort();
        candidateMobileDuplicateState.add.checkedValue = '';
        candidateMobileDuplicateState.add.duplicate = false;
        candidateMobileDuplicateState.add.pending = false;
        $('#candidate_mobile_err').text('');

        $('#uploadedlogo').attr('src', "{{asset('assets/egc_images/docx_icon.png')}}");
        $('#resumeDropzone').removeClass('is-dragover');
    });

    function toggleExperience() {
        var experType = document.getElementById('candidate_exper_type').value;
        var experienceDiv = document.getElementById('experience_div');

        if (experType === '2') { // Experience selected
            experienceDiv.style.display = 'block';
        } else {
            experienceDiv.style.display = 'none';
            document.getElementById('candidate_exper_count').value = ''; // Clear experience input
        }
    }

    function toggleExperienceEdit() {
        var experType = document.getElementById('candidate_exper_type_edit').value;
        var experienceDiv = document.getElementById('experience_div_edit');

        if (experType === '2') { // Experience selected
            experienceDiv.style.display = 'block';
        } else {
            experienceDiv.style.display = 'none';
            document.getElementById('candidate_exper_count_edit').value = ''; // Clear experience input
        }
    }
</script>
<script>
    let edit_major = null;

    // egc_applicant.job_role_id is an existing text column containing JSON role IDs.
    // Accept JSON arrays and legacy single numeric IDs without changing older records.
    function parseCandidateRoleIds(rawRoleIds) {
        if (Array.isArray(rawRoleIds)) {
            return [...new Set(rawRoleIds.map(String).filter(value => /^\d+$/.test(value)))];
        }

        if (rawRoleIds === null || rawRoleIds === undefined || String(rawRoleIds).trim() === '') {
            return [];
        }

        const rawValue = String(rawRoleIds).trim();
        try {
            const decoded = JSON.parse(rawValue);
            const values = Array.isArray(decoded) ? decoded : (decoded !== null && decoded !== '' ? [decoded] : []);
            return [...new Set(values.map(String).filter(value => /^\d+$/.test(value)))];
        } catch (error) {
            return /^\d+$/.test(rawValue) ? [rawValue] : [];
        }
    }

    function openEditModal(id) {
        $('#edit_candidate_id').val(id);
        if (id) {
            $.ajax({
                url: '/candidate_details_by_id',
                type: "GET",
                data: {
                    applicant_id: id
                },
                success: function(res) {
                    if (res.status == 200) {
                        let applicant = res.data;
                        console.log(applicant)
                        $('#candidate_name_edit').val(applicant.applicant_name);
                        $('#candidate_mobile_edit').val(normalizeCandidateMobileForInput(applicant.mobile));
                        scheduleCandidateMobileDuplicateCheck('edit', true);
                        $('#candidate_email_edit').val(applicant.email);
                        $('#candidate_gender_edit').val(applicant.gender).change();
                        $('#candidate_marital_status_edit').val(applicant.marital_status_id || '').change();
                        $('#source_name_edit').val(applicant.source_id).change();
                        $('#candidate_role_ids_edit').val(parseCandidateRoleIds(applicant.job_role_id)).trigger('change');
                        $('#qualification_id_edit').val(applicant.qualification_id).change();
                        edit_major = applicant.major;
                        $('#candidate_exper_type_edit').val(applicant.experience_id).change();
                        $('#candidate_exper_count_edit').val(applicant.experience_count);
                    }
                },
                error: function(err) {

                }
            })
        }
    }

    function qualification_change_edit() {
        var qualification_id = $('#qualification_id_edit').val();

        let majorWrapper = $('#major_edit_div');
        var majorDropdown = $('#major_edit');
        majorDropdown.empty().append('<option value="">Select Major</option>');

        let hideMajorFor = ['4', '5', '6', 'Others'];

        if (hideMajorFor.includes(qualification_id)) {
            majorWrapper.hide();
            majorDropdown.val("").trigger("change");

            return; // stop ajax call
        } else {
            majorWrapper.show();
        }



        if (qualification_id) {
            $.ajax({
                url: "{{ route('major_list_by_qualification') }}",
                type: "GET",
                data: {
                    qualification_id: qualification_id
                },
                success: function(response) {
                    if (response.status === 200 && response.data) {
                        response.data.forEach(function(state) {
                            majorDropdown.append($('<option></option>').attr(
                                'value', state.sno).text(state
                                .major_name));
                        });
                        majorDropdown.append('<option value="Others">Others</option>');

                        if (edit_major) {
                            $('#major_edit').val(edit_major).trigger('change');
                        }

                    }
                },
                error: function(error) {
                    console.error('Error fetching major:', error);
                }
            });

        }
    }

    function validation_edit_func() {
        let err = false;

        // Full Name
        if (!$('#candidate_name_edit').val().trim()) {
            $('#candidate_name_edit_err').text('Full Name is required.');
            err = true;
        } else {
            $('#candidate_name_edit_err').text('');
        }

        // Gender
        if (!$('#candidate_gender_edit').val()) {
            $('#candidate_gender_edit_err').text('Gender is required.');
            err = true;
        } else {
            $('#candidate_gender_edit_err').text('');
        }

        // Indian mobile must be canonical 10 digits and unique across other applicants.
        const mobile = normalizeCandidateMobileForInput($('#candidate_mobile_edit').val());
        const mobilePattern = /^[6-9][0-9]{9}$/;
        const mobileState = candidateMobileDuplicateState.edit;

        if (!mobile) {
            $('#candidate_mobile_edit_err').text('Mobile Number is required.');
            err = true;
        } else if (!mobilePattern.test(mobile)) {
            $('#candidate_mobile_edit_err').text('Enter a valid Indian 10-digit mobile number.');
            err = true;
        } else {
            $('#candidate_mobile_edit').val(mobile);
            if (mobileState.duplicate) {
                $('#candidate_mobile_edit_err').text('This mobile number already exists for another candidate.');
                err = true;
            } else if (mobileState.pending || (!mobileState.failed && mobileState.checkedValue !== mobile)) {
                scheduleCandidateMobileDuplicateCheck('edit', true);
                $('#candidate_mobile_edit_err').text('Checking mobile number for duplicates. Please try saving again after the check completes.');
                err = true;
            } else if (!mobileState.failed) {
                $('#candidate_mobile_edit_err').text('');
            }
        }

        // Email
        const email = $('#candidate_email_edit').val().trim();
        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

        if (!email) {
            $('#candidate_email_edit_err').text('Email ID is required.');
            err = true;
        } else if (!emailPattern.test(email)) {
            $('#candidate_email_edit_err').text('Enter a valid Email ID.');
            err = true;
        } else {
            $('#candidate_email_edit_err').text('');
        }

        // Marital Status
        if (!$('#candidate_marital_status_edit').val()) {
            $('#candidate_marital_status_edit_err').text('Marital Status is required.');
            err = true;
        } else {
            $('#candidate_marital_status_edit_err').text('');
        }

        // Qualification
        if (!$('#qualification_id_edit').val()) {
            $('#candidate_qualification_edit_err').text('Qualification is required.');
            err = true;
        } else {
            $('#candidate_qualification_edit_err').text('');
        }
        if (!$('#major_edit').val()) {
            $('#candidate_major_edit_err').text('Major is required.');
            err = true;
        }

        // Experience Type
        const experType = $('#candidate_exper_type_edit').val();
        if (!experType) {
            $('#candidate_exper_type_edit_err').text('Please select Fresher or Experience.');
            err = true;
        } else {
            $('#candidate_exper_type_edit_err').text('');
        }

        // Experience Count (only if Experience selected)
        if (experType === '2') {
            const experCount = $('#candidate_exper_count_edit').val().trim();
            if (!experCount) {
                $('#candidate_exper_count_edit_err').text('Experience is required.');
                err = true;
            } else {
                $('#candidate_exper_count_edit_err').text('');
            }
        } else {
            $('#candidate_exper_count_edit_err').text('');
        }

        // Source
        if (!$('#source_name_edit').val()) {
            $('#source_name_edit_err').text('Source is required.');
            err = true;
        } else {
            $('#source_name_edit_err').text('');
        }

        // Submit if no errors
        if (!err) {
            edit_submit_form();
        }
    }

    function edit_submit_form() {
        const form = document.getElementById("jobApplyFormEdit");
        const submitBtn = document.getElementById("updateApplicantBtn");
        const submitBtnText = document.getElementById("yesBtnTextEdit");
        const submitBtnLoader = document.getElementById("yesBtnLoaderEdit");

        console.log('working');

        if (form) {
            submitBtn.disabled = true;
            submitBtnText.style.display = "none"; // Hide "Yes"
            submitBtnLoader.style.display = "inline-block"; // Show loader

            // Create FormData manually
            const formData = new FormData(form);

            $.ajax({
                url: form.action,
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // console.log("Success:", response);
                    if (response.status == '200') {
                        window.location.href = '/hr_recruitment/manage_candidate/';
                        submitBtn.disabled = false;
                        submitBtnText.style.display = "inline-block"; // Show "Yes" again
                        submitBtnLoader.style.display = "none"; // Hide loader
                         toastr.success(response.message);
                    } else {
                        toastr.error(response.message);
                        // Re-enable the button and reset the text
                        submitBtn.disabled = false;
                        submitBtnText.style.display = "inline-block"; // Show "Yes" again
                        submitBtnLoader.style.display = "none"; // Hide loader
                    }
                },
                error: function(err) {
                    console.error("Error:", err);
                    toastr.error(err.message || 'An error occurred while submitting the form.');
                    // In case of an error, re-enable the button and reset the text
                    submitBtn.disabled = false;
                    submitBtnText.style.display = "inline-block"; // Show "Yes" again
                    submitBtnLoader.style.display = "none"; // Hide loader
                }
            });
        }
    }
</script>
<script>
    function openAiAnalysesModal(id) {

        $('#applicant_id_hidden').val(id);

        if (id) {
            $.ajax({
                url: '/candidate_details_by_id',
                type: "GET",
                data: {
                    applicant_id: id
                },
                success: function(res) {
                    if (res.status == 200) {
                        let a = res.data;
                        $('#cand_name').text(a.applicant_name);
                        $('#cand_email').text(a.email);
                        $('#cand_mobile').text(a.mobile);

                        let expText = a.experience_id == '1' ?
                            'Fresher' :
                            a.experience_count + ' Years Experience';

                        $('#cand_exp').text(expText);
                        // $('#cand_qualification').text(a.qualification ?? '-');
                    }
                },
                error: function(err) {

                }
            })
        }

    }
    var aiInProgress = false;

    function generateAiAnalyse() {

        if (aiInProgress) return;
        // 1. Get Form Data
        let jobRoleName = $('#job_role_name option:selected').text(); // Get the text (e.g. "Software Engineer")
        let applicant_id = $('#applicant_id_hidden').val(); // Get the ID

        if (!jobRoleName) {
            $('#job_role_name_err').text("Select Job Role before generating AI.");
            return;
        } else {
            $('#job_role_name_err').text("");
        }

        aiInProgress = true;
        $('#ai_analyses_div').html('<div class="ai-loading rounded"></div>');

        $("#aiBtn")
            .prop("disabled", true)
            .html(`<span class="spinner-border spinner-border-sm me-1"></span>Generating...`);



        $.ajax({
            url: "{{ route('generate_ai_anlyse_by_resume') }}",
            type: 'POST',
            data: {
                job_role_name: jobRoleName.trim(),
                applicant_id: applicant_id,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            success: function(response) {

                if (response.status === 200 && response.data) {
                    let aiData = response.data;

                    if (typeof aiData === "string") {
                        try {
                            aiData = JSON.parse(aiData);
                        } catch (e) {
                            console.error("Invalid JSON fallback", e);
                            return;
                        }
                    }

                    renderAIResult(aiData);
                }
            },

            error: function(error) {
                console.error('AI Error:', error);
            },

            complete: function() {
                aiInProgress = false;

                $("#aiBtn")
                    .prop("disabled", false)
                    .html(`<span class="d-flex justify-content-center align-items-center gap-1">
                                <i class="mdi mdi-robot-outline"></i><span>AI</span>
                            </span>`);
            }
        });
    }
</script>
<script>
    function company_change_func() {
        var countryId = $('#company_fill').val();
        var stateDropdown = $('#entity_fill');
        var jobRoleDropdown = $('#job_role_name');
        stateDropdown.empty().append('<option value="">Select Entity</option>');
        jobRoleDropdown.empty().append('<option value="">Select Job Role</option>');

        if (countryId == 'egc') {
            let entity_id = 0;
            $('#business_div').addClass('d-none');

            $.ajax({
                url: "{{ route('get_job_role_by_entity') }}",
                type: "GET",
                data: {
                    entity_id: entity_id
                },
                success: function(response) {
                    if (response.status === 200 && response.data) {
                        response.data.forEach(function(state) {
                            jobRoleDropdown.append($('<option></option>').attr(
                                    'value', state.sno)
                                .text(state.job_position_name));
                        });

                    }
                },
                error: function(error) {
                    console.error('Error fetching Job Role:', error);
                }
            });

        } else {
            $('#business_div').removeClass('d-none');
            if (countryId != '') {
                // Fetch and populate states based on selected country
                $.ajax({
                    url: "{{ route('entity_list') }}",
                    type: "GET",
                    data: {
                        company_id: countryId
                    },
                    success: function(response) {
                        if (response.status === 200 && response.data) {
                            response.data.forEach(function(state) {
                                stateDropdown.append($('<option></option>').attr(
                                    'value', state.sno).text(state
                                    .entity_name));
                            });

                        }
                    },
                    error: function(error) {
                        console.error('Error fetching states:', error);
                    }
                });
            }
        }


    }

    function entity_change_func() {
        var entity_id = $('#entity_fill').val();

        var jobRoleDropdown = $('#job_role_name');

        jobRoleDropdown.empty().append('<option value="">Select Job Role</option>');
        if (entity_id) {
            // Fetch and populate states based on selected country
            // Job role dropdown
            $.ajax({
                url: "{{ route('get_job_role_by_entity') }}",
                type: "GET",
                data: {
                    entity_id: entity_id
                },
                success: function(response) {
                    if (response.status === 200 && response.data) {
                        response.data.forEach(function(state) {
                            jobRoleDropdown.append($('<option></option>').attr(
                                    'value', state.sno)
                                .text(state.job_position_name));
                        });

                    }
                },
                error: function(error) {
                    console.error('Error fetching Job Role:', error);
                }
            });
        }
    }
</script>

<script>
    function renderAIResult(data) {

        let html = `
    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <div class="row text-center mb-4">

                ${scoreBox('Overall Match', data.overall_match_score, 'primary')}
                ${scoreBox('ATS Score', data.ats_keyword_match_score, 'info')}
                ${scoreBox('Skills', data.skills_alignment_score, 'success')}
                ${scoreBox('Experience', data.experience_relevance_score, 'warning')}
                ${scoreBox('Impact', data.impact_metrics_score, 'danger')}

            </div>

            <div class="row">

                <div class="col-md-6">
                    ${listCard('Strengths', data.strengths, 'success')}
                    ${listCard('Missing Skills', data.missing_keywords, 'warning')}
                </div>

                <div class="col-md-6">
                    ${listCard('Weaknesses', data.weaknesses, 'danger')}
                    ${listCard('Improvements', data.resume_improvements, 'primary')}
                </div>

            </div>

            <div class="mt-4">
                <h6 class="fw-bold">Optimized Summary</h6>
                <div class="p-3 bg-light rounded">${data.optimized_summary}</div>
            </div>

        </div>
    </div>`;

        $('#ai_analyses_div').html(html);
    }

    function scoreBox(title, value, color) {
        return `
    <div class="col">
        <div class="p-3 border rounded bg-light">
            <h6>${title}</h6>
            <h4 class="text-${color}">${value}%</h4>
        </div>
    </div>`;
    }

    function listCard(title, items, color) {
        let list = items.map(i => `<li>${i}</li>`).join('');
        return `
    <div class="mb-3">
        <h6 class="text-${color} fw-bold">${title}</h6>
        <ul class="small">${list}</ul>
    </div>`;
    }
</script>
<script>
        function generateQr() {
            // Reset UI
            $('#download_qr_code_name').addClass('d-none').text('');
            $('#qrImage').attr('src', '{{ asset("assets/egc_images/qr_code.png") }}');

            fetch(`/gen_job_common_qr/generate-qr`)
                .then(res => res.json())
                .then(data => {

                    if (data.status !== 200 || !data.qr_base64) {
                        toastr.error('QR generation failed');
                        return;
                    }

                    // Show QR
                    $('#qrImage')
                        .attr('src', data.qr_base64)
                        .fadeIn(200);

                    // Store link for copy
                    $('#download_qr_code_name')
                        .removeClass('d-none')
                        .text(data.link);
                      downloadFullPoster(data.qr_base64, 'Resume_OR_Code');
                    // Auto download (optional UX)
                    // setTimeout(() => {
                    //     const link = document.createElement('a');
                    //     link.href = data.qr_base64;
                    //     link.download = `${event_name}-qr-code.png`;
                    //     document.body.appendChild(link);
                    //     link.click();
                    //     document.body.removeChild(link);
                    // }, 400);
                })
                .catch(err => {
                    console.error(err);
                    toastr.error('Something went wrong');
                });
        }

        function downloadFullPoster(qrBase64, event_name) {

            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');

            canvas.width = 3508;
            canvas.height = 4961;

            const template = new Image();
            const qr = new Image();

            template.crossOrigin = "anonymous";
            qr.crossOrigin = "anonymous";

            template.src = "{{ asset('assets/egc_images/job/job_common_template.jpg') }}";
            qr.src = qrBase64;

            // Wait until BOTH images are loaded
            Promise.all([
                new Promise(resolve => template.onload = resolve),
                new Promise(resolve => qr.onload = resolve)
            ]).then(() => {

                // Draw template
                ctx.drawImage(template, 0, 0, canvas.width, canvas.height);

                // 🔥 Adjust these values if needed
                const qrWidth = 1468;
                const qrHeight = 1468;

                const qrX = 1014;    // adjust if needed
                const qrY = 1254;    // adjust if needed

                ctx.drawImage(qr, qrX, qrY, qrWidth, qrHeight);

                // Convert to blob (better than toDataURL for large images)
                canvas.toBlob(function(blob) {

                    const url = URL.createObjectURL(blob);

                    const a = document.createElement("a");
                    a.href = url;
                    a.download = `${event_name}-job-fair-poster.png`;
                    document.body.appendChild(a);
                    a.click();

                    document.body.removeChild(a);
                    URL.revokeObjectURL(url);

                }, "image/png");

            }).catch(err => {
                console.error(err);
                toastr.error("Poster generation failed");
            });
        }



        function copyText(element) {

            const targetId = element.getAttribute('data-target');
            const targetEl = document.getElementById(targetId);

            if (!targetEl || !targetEl.textContent.trim()) {
                toastr.warning('Nothing to copy');
                return;
            }

            const text = targetEl.textContent.trim();

            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text)
                    .then(() => successCopy(element))
                    .catch(() => fallbackCopy(text, element));
            } else {
                fallbackCopy(text, element);
            }
        }

        function fallbackCopy(text, element) {
            const textarea = document.createElement('textarea');
            textarea.value = text;
            textarea.style.position = 'fixed';
            textarea.style.opacity = '0';

            document.body.appendChild(textarea);
            textarea.select();

            try {
                document.execCommand('copy');
                successCopy(element);
            } catch {
                toastr.error('Copy failed');
            }

            document.body.removeChild(textarea);
        }

        function successCopy(element) {
            toastr.success('Link copied');

            // Small UX feedback
            const icon = element.querySelector('i');
            icon.classList.replace('mdi-content-copy', 'mdi-check');
            icon.classList.add('text-success');

            setTimeout(() => {
                icon.classList.replace('mdi-check', 'mdi-content-copy');
                icon.classList.remove('text-success');
            }, 1200);
        }
</script>
<script>
    let vipApplicantId = null;

    function openVipModal(id)
    {
        vipApplicantId = id;

        $('#kt_modal_vip_candidate').modal('show');

        $('#vip_loader').removeClass('d-none');
        $('#vip_content').addClass('d-none');

        $.ajax({
            url: "{{ route('candidate.vip.details') }}",
            method: "GET",
            data: {
                sno: id
            },

            beforeSend:function(){

                $('#vip_loader').removeClass('d-none');
                $('#vip_content').addClass('d-none');

            },

            success:function(res){

                if(!res.status){
                    toastr.error('Candidate not found');
                    return;
                }

                renderVipCandidate(res.data);

                $('#vip_loader').addClass('d-none');
                $('#vip_content').removeClass('d-none');
            },

            error:function(){

                toastr.error(
                    'Unable to load candidate details'
                );

                $('#vip_loader').addClass('d-none');
            }
        });
    }

    function renderVipCandidate(d)
    {
        // Avatar
        $('#vip_avatar').html(
            d.applicant_name
            ? d.applicant_name.charAt(0).toUpperCase()
            : 'C'
        );

        // Basic Details
        $('#vip_name').text(d.applicant_name || '-');
        $('#vip_applicant_id').text(d.applicant_id || '-');
        $('#vip_mobile').text(d.mobile || '-');
        $('#vip_email').text(d.email || '-');
        $('#vip_source').text(d.source_name || '-');

        // Gender
        let gender = 'Unknown';

        if (d.gender == 1 || d.gender == '1') {
            gender = 'Male';
        } else if (d.gender == 2 || d.gender == '2') {
            gender = 'Female';
        }

        $('#vip_gender').html(`
            <span class="badge bg-light-primary text-primary">
                ${gender}
            </span>
        `);

        // Qualification Badge
        let qualification = 'Others';
        let badgeClass = 'bg-secondary';

        if (d.qualification_id == '1') {
            qualification = 'UG';
            badgeClass = 'bg-success';
        } else if (d.qualification_id == '2') {
            qualification = 'PG';
            badgeClass = 'bg-primary';
        } else if (d.qualification_id == '3') {
            qualification = 'Doctorate';
            badgeClass = 'bg-dark';
        } else if (d.qualification_id == '4') {
            qualification = 'HSC';
            badgeClass = 'bg-info';
        } else if (d.qualification_id == '5') {
            qualification = 'SSLC';
            badgeClass = 'bg-warning text-dark';
        } else if (d.qualification_id == '6') {
            qualification = 'Below SSLC';
            badgeClass = 'bg-danger';
        }

        // Old Recruitment Data Override
        if (parseInt(d.recruitment_id) > 0 && d.old_data) {

            try {

                const oldData = JSON.parse(d.old_data);

                switch(oldData.qualification_id){

                    case '5':
                        qualification = 'UG';
                        badgeClass = 'bg-success';
                        break;

                    case '4':
                        qualification = 'PG';
                        badgeClass = 'bg-primary';
                        break;

                    case '3':
                        qualification = 'Professional Degree';
                        badgeClass = 'bg-info';
                        break;

                    case '2':
                        qualification = 'Doctorate';
                        badgeClass = 'bg-dark';
                        break;

                    default:
                        qualification = 'Others';
                        badgeClass = 'bg-secondary';
                }

            } catch (e) {
                console.log(e);
            }
        }

        $('#vip_qualification_badge').html(`
            <span class="badge ${badgeClass}">
                ${qualification}
            </span>
        `);

        // Major
        let majorName = '-';

        if (
            d.major &&
            d.major != '0' &&
            d.major_name
        ) {
            majorName = d.major_name;
        }

        $('#vip_major').text(majorName);

        // Experience
        let experienceText = 'Fresher';

        if (
            d.experience_id == '2' ||
            d.experience_id == 2
        ) {
            experienceText =
                (d.experience_count || 0) + ' Years';
        }

        $('#vip_experience').html(`
            <span class="badge bg-light-success text-success">
                ${experienceText}
            </span>
        `);

        // VIP Remarks
        $('#vip_remarks').val(
            d.vip_remarks || ''
        );

    }


    $('#saveVipBtn').click(function () {

        $.ajax({

            url: "{{ route('candidate.mark.vip') }}",

            type: "POST",

            data: {

                _token: "{{ csrf_token() }}",

                applicant_id: vipApplicantId,

                remarks: $('#vip_remarks').val()

            },

            beforeSend: function () {

                $('#saveVipBtn')
                    .prop('disabled', true);

            },

            success: function (res) {

                toastr.success(res.message);

                $('#kt_modal_vip_candidate')
                    .modal('hide');

                loadThemes();

            },

            complete: function () {

                $('#saveVipBtn')
                    .prop('disabled', false);

            }
        });

    });
</script>
<script>
    function applyDashboardFilter(type, element)
    {
        if (dashboardFilter === type)
        {
            dashboardFilter = '';

            $('.dashboard-filter').removeClass(
                'active-dashboard-filter'
            );
        }
        else
        {
            dashboardFilter = type;

            $('.dashboard-filter').removeClass(
                'active-dashboard-filter'
            );

            $(element).addClass(
                'active-dashboard-filter'
            );
        }

        loadThemes(1);
    }

    function clearDashboardFilter()
    {
        dashboardFilter = '';

        $('.dashboard-filter').removeClass(
            'active-dashboard-filter'
        );

        loadThemes(1);
    }
</script>
<script>
    function openCandidateHistory(id)
    {
        $('#candidateHistoryModal').modal('show');

        $('#history_applicant_id').val(id);

        $('#history_loader').removeClass('d-none');
        $('#history_content').addClass('d-none');

        

        $('#historyTimeline').html('');

        $.ajax({
            url: "{{ route('candidate.history.details') }}",
            type: "GET",
            data: {
                applicant_id: id
            },
            beforeSend:function(){
                $('#history_loader').removeClass('d-none');
                $('#history_content').addClass('d-none');

            },
            success: function(res)
            {
                if(!res.status){
                    toastr.error('Candidate not found');
                    return;
                }

                renderHistoryCandidate(res.candidate);
                renderHistoryTimeline(res.history);
              

                $('#history_loader').addClass('d-none');
                $('#history_content').removeClass('d-none');
            },
            error:function(){
                toastr.error('Unable to load candidate details');
                $('#history_loader').addClass('d-none');
            }
        });
    }

    function applicant_status_change(){

        let status = $('#applicant_status').val();

        if( status === 'Selected' || status === 'Offer Released' || status === 'Offer Accepted' || status === 'Joined'){
            $('#selectedSection')
                .removeClass('d-none');
        }else{
            $('#selectedSection')
                .addClass('d-none');
        }
    }


    $('#saveHistoryBtn').click(function(){

        let btn = $(this);

        btn.prop('disabled',true);
        let interview_date = $('#interview_date').val();
        let applicant_status = $('#applicant_status').val();

        if (!interview_date) {
            $('#interview_date_err').text("Interview Date is Required.");
            btn.prop('disabled',false);
            return;
        } else {
            $('#interview_date_err').text("");
        }

        if (!applicant_status) {
            $('#applicant_status_err').text("Interview Status is Required.");
            btn.prop('disabled',false);
            return;
        } else {
            $('#applicant_status_err').text("");
        }

        $.ajax({
            url:"{{ route('candidate.history.store') }}",
            type:"POST",
            data:{
                _token:"{{ csrf_token() }}",
                applicant_id:$('#history_applicant_id').val(),
                interview_date:$('#interview_date').val(),
                applicant_status:$('#applicant_status').val(),
                selected_date:$('#selected_date').val(),
                entity_id:$('#selected_company').val(),
                job_role_id:$('#selected_job_role').val(),
                expected_salary: $('#expected_salary').val(),
                offered_salary:$('#offered_salary').val(),
                joining_date:$('#joining_date').val(),
                followup_date: $('#followup_date').val(),
                remarks:$('#history_remarks').val()
            },
            success:function(res){
                toastr.success(res.message);
                openCandidateHistory($('#history_applicant_id').val());
                loadThemes(currentPage);
            },
            complete:function(){
                btn.prop('disabled',false);
            }
        });

    });

    function getStatusColor(status)
    {
        switch(status)
        {
            case 'Selected':
            case 'Joined':
                return 'success';

            case 'Rejected':
            case 'Offer Rejected':
            case 'Not Joined':
                return 'danger';

            case 'On Hold':
                return 'warning';

            case 'Critical':
                return 'dark';

            default:
                return 'primary';
        }
    }

    function renderHistoryTimeline(history)
    {
        if(!history || history.length === 0)
        {
            $('#historyTimeline').html(`
                <div class="text-center py-5">
                    <span class="mdi mdi-clipboard-text-off fs-2"></span>
                    <div class="mt-3 text-muted">
                        No recruitment updates available
                    </div>
                </div>
            `);
            return;
        }

        let html = `<div class="candidate-history-timeline">`;

        history.forEach((item,index)=>{

            const color = getStatusColor(
                item.applicant_status
            );

            html += `
            <div class="history-item">

                <div class="history-line"></div>

                <div class="history-dot bg-${color}">
                    ${index + 1}
                </div>

                <div class="history-card">

                    <div class="d-flex justify-content-between align-items-start mb-2">

                        <div>

                            <span class="badge bg-${color}">
                                ${item.applicant_status}
                            </span>

                            ${
                                item.interview_date
                                ?
                                `
                                <div class="small text-muted mt-2">
                                    <i class="mdi mdi-calendar"></i>
                                    Interview :
                                    ${item.interview_date}
                                </div>
                                `
                                :
                                ''
                            }

                        </div>

                        <div class="text-end">
                            <small class="text-muted">
                                ${item.created_at}
                            </small>
                        </div>

                    </div>

                    ${
                        item.remarks
                        ?
                        `
                        <div class="history-remarks">
                            <i class="mdi mdi-note-text-outline me-1"></i>
                            ${item.remarks}
                        </div>
                        `
                        :
                        ''
                    }

                    <div class="row mt-3">

                        ${
                            item.company_name
                            ?
                            `
                            <div class="col-md-4 mb-2">
                                <small class="text-muted d-block">
                                    Company
                                </small>
                                <strong>
                                    ${item.company_name}
                                </strong>
                            </div>
                            `
                            :
                            ''
                        }

                        ${
                            item.job_position_name
                            ?
                            `
                            <div class="col-md-4 mb-2">
                                <small class="text-muted d-block">
                                    Job Role
                                </small>
                                <strong>
                                    ${item.job_position_name}
                                </strong>
                            </div>
                            `
                            :
                            ''
                        }

                        ${
                            item.offered_salary
                            ?
                            `
                            <div class="col-md-4 mb-2">
                                <small class="text-muted d-block">
                                    Offered Salary
                                </small>
                                <strong class="text-success">
                                    ₹ ${parseFloat(item.offered_salary).toLocaleString()}
                                </strong>
                            </div>
                            `
                            :
                            ''
                        }

                    </div>

                    ${
                        item.followup_date
                        ?
                        `
                        <div class="mt-3">
                            <span class="badge bg-light-warning text-warning">
                                Follow-up :
                                ${item.followup_date}
                            </span>
                        </div>
                        `
                        :
                        ''
                    }

                </div>

            </div>
            `;
        });

        html += `</div>`;

        $('#historyTimeline').html(html);
    }

    function profileSkeleton()
    {
        return `
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">

                <div class="d-flex align-items-center">

                    <div
                        class="placeholder-glow me-4">
                        <span
                            class="placeholder rounded-circle"
                            style="width:80px;height:80px;display:block;">
                        </span>
                    </div>

                    <div class="flex-grow-1">

                        <div class="placeholder-glow mb-2">
                            <span class="placeholder col-4"></span>
                        </div>

                        <div class="placeholder-glow mb-2">
                            <span class="placeholder col-3"></span>
                        </div>

                        <div class="placeholder-glow">
                            <span class="placeholder col-6"></span>
                        </div>

                    </div>

                </div>

            </div>
        </div>

        <div class="row">

            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">

                        <div class="placeholder-glow mb-3">
                            <span class="placeholder col-5"></span>
                        </div>

                        <div class="placeholder-glow mb-2">
                            <span class="placeholder col-8"></span>
                        </div>

                        <div class="placeholder-glow mb-2">
                            <span class="placeholder col-7"></span>
                        </div>

                        <div class="placeholder-glow">
                            <span class="placeholder col-6"></span>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">

                        <div class="placeholder-glow mb-3">
                            <span class="placeholder col-5"></span>
                        </div>

                        <div class="placeholder-glow mb-2">
                            <span class="placeholder col-9"></span>
                        </div>

                        <div class="placeholder-glow mb-2">
                            <span class="placeholder col-7"></span>
                        </div>

                        <div class="placeholder-glow">
                            <span class="placeholder col-5"></span>
                        </div>

                    </div>
                </div>
            </div>

        </div>
        `;
    }

    function renderHistoryCandidate(d)
    {
        // Avatar
        $('#history_avatar').html(
            d.applicant_name
            ? d.applicant_name.charAt(0).toUpperCase()
            : 'C'
        );

        // Basic Details
        $('#history_name').text(d.applicant_name || '-');
        $('#history_applicant_id').text(d.applicant_id || '-');
        $('#history_mobile').text(d.mobile || '-');
        $('#history_email').text(d.email || '-');
        $('#history_source').text(d.source_name || '-');

        // Gender
        let gender = 'Unknown';

        if (d.gender == 1 || d.gender == '1') {
            gender = 'Male';
        } else if (d.gender == 2 || d.gender == '2') {
            gender = 'Female';
        }

        $('#history_gender').html(`
            <span class="badge bg-light-primary text-primary">
                ${gender}
            </span>
        `);

        // Qualification Badge
        let qualification = 'Others';
        let badgeClass = 'bg-secondary';

        if (d.qualification_id == '1') {
            qualification = 'UG';
            badgeClass = 'bg-success';
        } else if (d.qualification_id == '2') {
            qualification = 'PG';
            badgeClass = 'bg-primary';
        } else if (d.qualification_id == '3') {
            qualification = 'Doctorate';
            badgeClass = 'bg-dark';
        } else if (d.qualification_id == '4') {
            qualification = 'HSC';
            badgeClass = 'bg-info';
        } else if (d.qualification_id == '5') {
            qualification = 'SSLC';
            badgeClass = 'bg-warning text-dark';
        } else if (d.qualification_id == '6') {
            qualification = 'Below SSLC';
            badgeClass = 'bg-danger';
        }

        // Old Recruitment Data Override
        if (parseInt(d.recruitment_id) > 0 && d.old_data) {
            try {
                const oldData = JSON.parse(d.old_data);
                switch(oldData.qualification_id){
                    case '5':
                        qualification = 'UG';
                        badgeClass = 'bg-success';
                        break;
                    case '4':
                        qualification = 'PG';
                        badgeClass = 'bg-primary';
                        break;
                    case '3':
                        qualification = 'Professional Degree';
                        badgeClass = 'bg-info';
                        break;
                    case '2':
                        qualification = 'Doctorate';
                        badgeClass = 'bg-dark';
                        break;
                    default:
                        qualification = 'Others';
                        badgeClass = 'bg-secondary';
                }
            } catch (e) {
                console.log(e);
            }
        }

        $('#history_qualification_badge').html(`
            <span class="badge ${badgeClass}">
                ${qualification}
            </span>
        `);

        // Major
        let majorName = '-';

        if (
            d.major &&
            d.major != '0' &&
            d.major_name
        ) {
            majorName = d.major_name;
        }

        $('#history_major').text(majorName);

        // Experience
        let experienceText = 'Fresher';

        if (
            d.experience_id == '2' ||
            d.experience_id == 2
        ) {
            experienceText =
                (d.experience_count || 0) + ' Years';
        }

        $('#history_experience').html(`
            <span class="badge bg-light-success text-success">
                ${experienceText}
            </span>
        `);

        // history Remarks
        $('#history_remarks').val('');

    }


</script>
<script>
    function histry_entity_change() {
        var entity_id = $('#selected_company').val();
        let entityID =0;

        var jobRoleDropdown = $('#selected_job_role');

        jobRoleDropdown.empty().append('<option value="">Select Job Role</option>');
        if (entity_id) {
            // Fetch and populate states based on selected country
            // Job role dropdown
            if(entity_id =='egc'){
                entityID =0;
            }else{
                entityID =entity_id;
            }
            $.ajax({
                url: "{{ route('get_job_role_by_entity') }}",
                type: "GET",
                data: {
                    entity_id: entityID
                },
                success: function(response) {
                    if (response.status === 200 && response.data) {
                        response.data.forEach(function(state) {
                            jobRoleDropdown.append($('<option></option>').attr(
                                    'value', state.sno)
                                .text(state.job_position_name));
                        });

                    }
                },
                error: function(error) {
                    console.error('Error fetching Job Role:', error);
                }
            });
        }
    }
</script>
<script>
     
    function viewApplicantAI(id){
        $('#applicantDetailedAiModal').modal('show');
        loadApplicant(id);
    }

    // List-page Resume action opens the existing applicant modal directly on its Resume tab.
    function viewApplicantResume(id) {
        $('#applicantDetailedAiModal').modal('show');
        loadApplicant(id, true);
    }
</script>

<script>

    let applicationAnswersLoadedFor = null;
    let applicationAnswersLoading = false;
    let currentCandidateData = null;

    function loadApplicationAnswers() {

        if (!currentCandidateData) {
            renderApplicationAnswersEmpty(
                'Applicant information is not loaded.'
            );
            return;
        }

        const applicationAnswers = currentCandidateData.application_answers || {};

        renderApplicationAnswers(applicationAnswers);
    }

    function renderApplicationAnswers(data = {}) {

        const answers = Array.isArray(data.answers)
            ? data.answers
            : [];

        const count = Number.isFinite(
            Number(data.answer_count)
        )
            ? parseInt(data.answer_count, 10)
            : answers.length;

        $('#applicationAnswersCount')
            .text(count)
            .toggle(count > 0);

        if (!data.has_answers || !answers.length) {

            renderApplicationAnswersEmpty(
                'This applicant did not submit any additional questions.'
            );

            return;
        }

        let html = `
            <div class="application-answers-wrapper">

                <div class="application-answer-summary">

                    <div class="answer-summary-icon">
                        <i class="mdi mdi-check-circle-outline"></i>
                    </div>

                    <div class="flex-grow-1">

                        <div class="fw-bold fs-6">
                            Application Questions Completed
                        </div>

                        <div class="text-muted fs-7">
                            Candidate submitted
                            ${count}
                            ${count === 1 ? 'answer' : 'answers'}
                            with the application.
                        </div>

                    </div>

                    <div class="answer-summary-count">
                        ${count}
                    </div>

                </div>

                <div class="application-answer-list">
        `;

        answers.forEach((item, index) => {

            html += renderApplicationAnswerCard(
                item,
                index
            );

        });

        html += `
                </div>

            </div>
        `;

        $('#applicationAnswersContent').html(html);
    }

    function renderApplicationAnswerCard(item,index) {

        const question =
            escapeHtml(
                item.question ||
                'Question'
            );

        const type =
            String(
                item.type || ''
            ).toLowerCase();

        const answerHtml =
            renderApplicationAnswerValue(
                item.answer,
                type
            );

        return `

            <div class="application-answer-card">

                <div class="answer-number">
                    ${String(index + 1).padStart(2, '0')}
                </div>

                <div class="answer-card-body">

                    <div class="answer-question">
                        ${question}
                    </div>

                    <div class="answer-type">
                        ${formatQuestionType(type)}
                    </div>

                    <div class="answer-value">
                        ${answerHtml}
                    </div>

                </div>

            </div>

        `;
    }

    function renderApplicationAnswerValue(answer,type) {

        if (
            answer === null ||
            answer === undefined ||
            answer === '' ||
            (
                Array.isArray(answer) &&
                answer.length === 0
            )
        ) {

            return `
                <span class="answer-not-provided">
                    Not answered
                </span>
            `;
        }

        if (Array.isArray(answer)) {

            return `

                <div class="answer-badge-list">

                    ${answer.map(value => `

                        <span class="answer-badge">
                            <i class="mdi mdi-check me-1"></i>
                            ${escapeHtml(value)}
                        </span>

                    `).join('')}

                </div>

            `;
        }

        return `

            <div class="answer-text">

                ${escapeHtml(String(answer))
                    .replace(/\n/g, '<br>')}

            </div>

        `;
    }

    function formatQuestionType(type) {

        switch (type) {

            case 'text_field':
                return 'Text Response';

            case 'check_box':
                return 'Multiple Selection';

            case 'list_box':
                return 'Dropdown Selection';

            case 'radio_button':
                return 'Single Selection';

            default:
                return 'Application Question';
        }
    }

    function renderApplicationAnswersEmpty(message) {

        $('#applicationAnswersCount')
            .hide();

        $('#applicationAnswersContent').html(`

            <div class="application-answer-empty">

                <div class="empty-icon">
                    <i class="mdi mdi-comment-question-outline"></i>
                </div>

                <h5>
                    No Application Answers
                </h5>

                <p>
                    ${escapeHtml(message)}
                </p>

            </div>

        `);
    }

    function renderApplicationAnswersError(message) {

        $('#applicationAnswersContent').html(`
            <div class="application-answer-error">

                <div class="empty-icon">
                    <i class="mdi mdi-alert-circle-outline"></i>
                </div>

                <h5>
                    Unable to Display Answers
                </h5>

                <p>
                    ${escapeHtml(message)}
                </p>

                <button
                    type="button"
                    class="btn btn-sm btn-primary"
                    onclick="loadApplicationAnswers()">

                    <i class="mdi mdi-refresh me-1"></i>
                    Try Again

                </button>

            </div>
        `);
    }

    // $(document).on(
    //     'shown.bs.tab',
    //     '#applicationAnswersTabBtn',
    //     function () {

    //         console.log(
    //             'Application Answers tab activated'
    //         );

    //         loadApplicationAnswers();

    //     }
    // );

    function renderApplicationAnswersLoading() {

        $('#applicationAnswersContent').html(`

            <div class="text-center py-5">

                <div
                    class="spinner-border text-primary mb-3"
                    role="status">
                </div>

                <h6 class="mb-1">
                    Loading Application Answers
                </h6>

                <p class="text-muted mb-0">
                    Fetching candidate responses...
                </p>

            </div>

        `);
    }
   
    function loadApplicant(id, showResumeTab = false)
    {
        currentCandidateData = null;
        $("#candidateProfile").html(loader());
        $("#overviewTab").html(loader());
        $("#aiTab").html(loader());
        $("#resumeTab").html(loader());


        $.ajax({
            url: "/hr-recruitment/applicant/"+id+"/ai-analysis",
            type:"GET",
            success:function(res){
                const applicantData = res?.data || {};
                // Keep the requested row id available even if the analysis payload omits it.
                if (!applicantData.applicant_id) applicantData.applicant_id = Number(id);

                renderCandidate(applicantData);
                renderOverview(applicantData);
                renderAI(applicantData);
                renderResume(applicantData);

                currentCandidateData = applicantData;
                renderApplicationAnswers(currentCandidateData.application_answers || {});

                if (showResumeTab) {
                    const resumeTabButton = document.querySelector('#applicantDetailedAiModal [data-bs-target="#resumeTab"]');
                    if (resumeTabButton && window.bootstrap && bootstrap.Tab) {
                        bootstrap.Tab.getOrCreateInstance(resumeTabButton).show();
                    }
                }
            },
            error:function(){
                toastr.error("Unable to load applicant.");
            }
        });
    }

    function loader()
    {
        return `
            <div class="placeholder-glow p-4">
                <span class="placeholder col-8 mb-3"></span>
                <span class="placeholder col-12 mb-2"></span>
                <span class="placeholder col-10 mb-2"></span>
                <span class="placeholder col-7 mb-2"></span>
                <span class="placeholder col-12"></span>
            </div>
        `;
    }

    function renderCandidate(data)
    {

        let c = data.candidate;
        let ai = data.ai;

        let match =ai.matches ? (ai.matches.length
            ? ai.matches[0]
            : null ) : null;

        let score = 0;

        if(ai.ai_response){
            score = ai.ai_response.overall_match_score;
        }

        let badge = `
            <span class="badge bg-secondary">
                Not Matched
            </span>
        `;

        if(match){
            badge = `
            <span class="badge bg-success">
                AI Matched
            </span>
            `;
        }

        $("#candidateProfile").html(`
            ${candidateCard(c,badge,score)}
        `);

    }

    function candidateCard(c,badge,score)
    {
        return `
            <div class="candidate-card">
                <div class="candidate-header">
                    <div class="candidate-avatar">
                        ${avatar(c.name)}
                    </div>
                    <h4>
                        ${c.name ?? '-'}
                    </h4>
                    <div class="text-muted">
                        ${c.current_designation ?? '-'}
                    </div>
                    <div class="mt-3">
                        ${badge}
                    </div>
                    <div class="score-circle mt-4">
                        ${score}%
                    </div>
                </div>
                
                ${contactCard(c)}
                ${professionalCard(c)}
               <!-- ${companyCard(c)}
                ${resumeCard(c)} -->
            </div>
        `;
    }

    function contactCard(c)
    {
        return `
            <div class="info-card">
                <h6>
                    <i class="mdi mdi-account-circle"></i>
                    Contact
                </h6>
                <div>
                    <i class="mdi mdi-email-outline"></i>
                    ${c.email ?? '-'}
                </div>
                <div>
                    <i class="mdi mdi-phone-outline"></i>
                    ${c.mobile ?? '-'}
                </div>
                <div>
                    <i class="mdi mdi-map-marker"></i>
                    ${c.location ?? '-'}
                </div>
            </div>
        `;
    }

    function professionalCard(c)
    {
        return `
            <div class="info-card">
                <h6>
                    <i class="mdi mdi-briefcase"></i>
                    Professional
                </h6>
                <table class="table table-sm">
                    <tr>
                        <td>Experience</td>
                        <td>${c.experience ? (c.experience >= 2 ? (c.experience +' Years') : (c.experience +' Year') ) : 'Fresher'}</td>
                    </tr>
                    <tr>
                        <td>Qualification</td>
                        <td>${c.qualification ?? '-'}</td>
                    </tr>
                    <tr>
                        <td>Major</td>
                        <td>${c.major_name ?? '-'}</td>
                    </tr>
                  <!-- <tr>
                        <td>Current CTC</td>
                        <td>${c.current_ctc ?? '-'}</td>
                    </tr>
                    <tr>
                        <td>Expected CTC</td>
                        <td>${c.expected_ctc ?? '-'}</td>
                    </tr>
                    <tr>
                        <td>Notice</td>
                        <td>${c.notice_period ?? '-'}</td>
                    </tr> -->
                </table>
            </div>
        `;
    }

    function companyCard(c)
    {
        return `
            <div class="info-card">
                <h6>
                    <i class="mdi mdi-office-building"></i>
                    Current Company
                </h6>
                <div class="fw-bold">
                    ${c.current_company ?? '-'}
                </div>
                <div class="text-muted">
                    ${c.current_designation ?? '-'}
                </div>
            </div>
        `;

    }

    function resumeCard(c)
    {
        const applicantId = Number(c?.sno || c?.id || c?.applicant_id || 0);
        const downloadUrl = candidateResumeOpenUrl(applicantId, 'attachment');
        return `
            <div class="info-card">
                <h6>Resume</h6>
                ${downloadUrl
                    ? `<a href="${escapeAttribute(downloadUrl)}" target="_blank" rel="noopener" class="btn btn-primary btn-sm w-100"><i class="mdi mdi-download"></i> Download Resume</a>`
                    : `<span class="text-muted small">Resume link is unavailable.</span>`
                }
            </div>
        `;
    }

    function avatar(name)
    {

        if(!name)
            return "?";

        let arr = name.trim().split(" ");

        if(arr.length==1)
            return arr[0][0].toUpperCase();

        return arr[0][0].toUpperCase()+arr[1][0].toUpperCase();

    }

    function renderAI(data)
    {
        let ai = data.ai;

        if (!ai || !ai.ai_response) {
            $("#aiTab").html(noAnalysis());
            return;
        }

        let analysis = ai.ai_response;
        let matches = ai.matches ?? [];

        $("#aiTab").html(`
            ${recommendationBanner(matches,analysis)}
            ${scoreCards(analysis)}
            ${matchedRole(matches)}

            <div class="row">
                <div class="col-lg-6">
                    ${strengthCard(analysis)}
                </div>
                <div class="col-lg-6">
                    ${weaknessCard(analysis)}
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-lg-12">
                    ${keywordCard(analysis)}
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-lg-6">
                    ${summaryCard(analysis)}
                </div>
                <div class="col-lg-6">
                    ${improvementCard(analysis)}
                </div>
            </div>
            <div class="mt-4">
                ${rewriteCard(analysis)}
            </div>
        `);

    }

    function recommendationBanner(matches,ai)
    {

        let score = ai.overall_match_score;
        let color="danger";
        let text="Not Recommended";
        let icon="mdi-close-circle";

        if(score>=90){
            color="success";
            text="Highly Recommended";
            icon="mdi-check-decagram";
        }else if(score>=75){
            color="primary";
            text="Recommended";
            icon="mdi-thumb-up";
        }else if(score>=60){
            color="warning";
            text="Needs Review";
            icon="mdi-alert";
        }

        return `
            <div class="alert alert-${color} shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4>
                            <i class="mdi ${icon}"></i>
                            ${text}
                        </h4>
                        <div>
                            Overall AI Evaluation
                        </div>
                    </div>
                    <h1>
                        ${score}%
                    </h1>
                </div>
            </div>
        `;

    }

    function scoreCards(ai)
    {
        return `
            <div class="row g-3">
                ${scoreCard("Overall",ai.overall_match_score,"primary")}
                ${scoreCard("ATS",ai.ats_keyword_match_score,"success")}
                ${scoreCard("Skills",ai.skills_alignment_score,"info")}
                ${scoreCard("Experience",ai.experience_relevance_score,"warning")}
                ${scoreCard("Impact",ai.impact_metrics_score,"danger")}
                ${scoreCard("Role",ai.role_responsibility_match_score,"secondary")}
            </div>
        `;
    }

    function scoreCard(title,value,color)
    {
        return `
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="text-muted">
                            ${title}
                        </div>
                        <h2 class="fw-bold">
                            ${value}%
                        </h2>
                        <div class="progress">
                            <div class="progress-bar bg-${color}" style="width:${value}%"></div>
                        </div>
                    </div>
                </div>
            </div>

        `;

    }

    function matchedRole(matches)
    {

        if(matches.length==0){

            return `
                <div class="card mt-4 border-danger">
                    <div class="card-body">
                        <h5>
                            No Matching Company Role
                        </h5>
                        <div>
                            Candidate does not closely match any existing company role.
                        </div>
                    </div>
                </div>

            `;

        }

        let role=matches[0];

        return `
            <div class="card mt-4 shadow-sm">
                <div class="card-body">
                    <h5>
                        Matched Role
                    </h5>
                    <div class="fs-4 fw-bold">
                        Role ID
                        ${role.role_id}
                    </div>
                    <div>
                        Confidence
                        ${role.confidence}%
                    </div>
                    <div class="mt-2 text-muted">
                        ${role.reason}
                    </div>
                </div>
            </div>
        `;

    }


    function strengthCard(ai){

        return listCard(
            "Strengths",
            "success",
            ai.strengths
        );

    }

    function weaknessCard(ai){

        return listCard(
            "Weaknesses",
            "danger",
            ai.weaknesses
        );

    }

    function listCard(title,color,list)
    {

        let html="";

        (list||[]).forEach(item=>{
            html+=`
                <li class="list-group-item">
                    ${item}
                </li>
            `;
        });

        return `
            <div class="card border-${color}">
                <div class="card-header bg-${color} text-white">
                    ${title}
                </div>
                <ul class="list-group list-group-flush">
                    ${html}
                </ul>
            </div>
        `;

    }

    function keywordCard(ai)
    {

        let html="";

        (ai.missing_keywords||[]).forEach(x=>{
            html+=`
                <span class="badge bg-danger me-2 mb-2">
                    ${x}
                </span>
            `;
        });

        return `
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>
                        Missing Keywords
                    </h5>
                    ${html}
                </div>
            </div>
        `;

    }

    function summaryCard(ai)
    {
        return `
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5>
                        Optimized Summary
                    </h5>
                    <p>
                        ${ai.optimized_summary}
                    </p>
                </div>
            </div>
        `;
    }

    function improvementCard(ai)
    {

        let html="";

        (ai.resume_improvements||[]).forEach(x=>{
            html+=`
                <li>
                    ${x}
                </li>
            `;
        });

        return `
            <div class="card h-100">
                <div class="card-body">
                    <h5>
                        Resume Improvements
                    </h5>
                    <ol>
                        ${html}
                    </ol>
                </div>
            </div>
        `;

    }

    function rewriteCard(ai)
    {

        let html="";

        (ai.rewritten_bullets||[]).forEach(x=>{

            html+=`
                <div class="alert alert-light border">
                    ${x}
                </div>
            `;

        });

        return `
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>
                     AI Rewritten Resume Bullets
                    </h5>
                    ${html}
                </div>
            </div>

        `;

    }


    function noAnalysis(){

        return `
            <div class="text-center py-5">
                <i class="mdi mdi-robot-outline display-1 text-muted"></i>
                <h3 class="mt-3">
                    AI Analysis Not Available
                </h3>
                <p>
                    Run AI Resume Analysis to generate recruiter insights.
                </p>
            </div>
        `;

    }

    function decisionPanel(ai,matches)
    {

        let role="-";
        let confidence="-";

        if(matches.length){

        role=matches[0].role_name;

        confidence=matches[0].confidence+"%";

        }

        return `
            <div class="decision-panel">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        ${recommendationBadge(ai)}
                        <h3>
                            ${ai.overall_hiring_recommendation}
                        </h3>
                        <div class="text-muted">
                            Candidate is recommended by AI.
                        </div>
                    </div>
                    <div class="col-lg-4 text-end">
                        <div class="decision-score">
                            ${ai.overall_match_score}%
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        ${metric("Matched Role",role)}
                    </div>
                    <div class="col-md-4">
                        ${metric("Confidence",confidence)}
                    </div>
                    <div class="col-md-4">
                        ${metric("Career Level",ai.career_level)}
                    </div>
                    <div class="col-md-4">
                        ${metric("Priority",ai.hiring_priority)}
                    </div>
                    <div class="col-md-4">
                        ${metric("Experience",ai.estimated_experience_years+" Years")}
                    </div>
                    <div class="col-md-4">
                        ${metric("Interview Readiness",ai.interview_readiness+"%")}
                    </div>
                </div>
            </div>
        `;

    }

    function metric(title,value)
    {
        return `
            <div class="metric-box">
                <div class="metric-title">
                    ${title}
                </div>
                <div class="metric-value">
                    ${value}
                </div>
            </div>
        `;
    }

    function recommendationBadge(ai)
    {

        let cls="secondary";

        switch(ai.overall_hiring_recommendation){
            case "Highly Recommended":
                cls="success";
                break;
            case "Recommended":
                cls="primary";
                break;
            case "Needs Review":
                cls="warning";
                break;
            default:
                cls="danger";

        }

        return `
            <span class="badge bg-${cls} px-3 py-2">
                ${ai.overall_hiring_recommendation}
            </span>
        `;

    }

    function recruiterActions(id)
    {
        return `
            <div class="card shadow-sm mt-4">
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2">
                        <button class="btn btn-success">
                            <i class="mdi mdi-account-check"></i>
                            Shortlist
                        </button>
                        <button class="btn btn-warning">
                            <i class="mdi mdi-calendar"></i>
                            Interview
                        </button>
                        <button class="btn btn-primary">
                            <i class="mdi mdi-account-plus"></i>
                            Assign Recruiter
                        </button>
                        <button class="btn btn-info">
                            <i class="mdi mdi-download"></i>
                            Download AI Report
                        </button>
                    </div>
                </div>
            </div>
        `;

    }

    function aiDecision(ai)
    {
        return `
            <div class="card shadow-sm mt-4">
                <div class="card-body">
                    <h5>
                        AI Decision
                    </h5>
                    <p>
                        ${ai.ai_decision}
                    </p>
                </div>
            </div>
        `;
    }

    function riskCard(ai)
    {

        let color="success";

        if(ai.risk_level=="Medium")
            color="warning";

        if(ai.risk_level=="High")
            color="danger";

        return `
            <div class="card border-${color} mt-4">
                <div class="card-body">
                    <h5>
                        Risk Assessment
                    </h5>
                    <div class="display-6 text-${color}">
                        ${ai.risk_level}
                    </div>
                    <div class="mt-2">
                        Technical Strength
                        <strong>
                            ${ai.technical_strength}
                        </strong>
                    </div>
                    <div>
                        Communication
                        <strong>
                            ${ai.communication_assessment}

                        </strong>
                    </div>
                </div>
            </div>
        `;

    }

    function renderResume(data)
    {
        const candidate = data?.candidate || {};
        const resume = data?.resume || {};
        const rawAttachment = resume.attachment || candidate.attachment || candidate.resume || '';
        const existingName = typeof rawAttachment === 'string'
            ? rawAttachment
            : (rawAttachment.attachment || rawAttachment.original_name || '');
        const applicantId = Number(candidate.sno || candidate.id || candidate.applicant_id || resume.applicant_sno || data?.applicant_id || 0);

        // Cloud-only records may not have a legacy attachment name. Ask the resolver for the current source name.
        if (applicantId > 0 && !existingName) {
            $("#resumeTab").html(loader());
            $.ajax({
                url: candidateResumeUrlsUrl(applicantId),
                type: 'GET',
                dataType: 'json',
                cache: false
            }).done(function (metadata) {
                renderResumeContent(data, metadata?.original_name || '');
            }).fail(function () {
                renderResumeContent(data, '');
            });
            return;
        }

        renderResumeContent(data, existingName);
    }

    function renderResumeContent(data, resolvedOriginalName = '')
    {
        const candidate = data?.candidate || {};
        const resume = data?.resume || {};
        const rawAttachment = resume.attachment || candidate.attachment || candidate.resume || resolvedOriginalName || '';
        const attachment = typeof rawAttachment === 'string'
            ? rawAttachment
            : (rawAttachment.attachment || rawAttachment.original_name || resolvedOriginalName || '');
        const applicantId = Number(candidate.sno || candidate.id || candidate.applicant_id || resume.applicant_sno || data?.applicant_id || 0);
        const fileUrl = applicantId ? candidateResumeOpenUrl(applicantId, 'inline') : '';
        const downloadUrl = applicantId ? candidateResumeOpenUrl(applicantId, 'attachment') : '';
        const fileInfo = getResumeFileInfo(attachment);

        $("#resumeTab").html(`
            <div class="resume-workspace">
                <!-- Resume Header -->
                <div class="resume-toolbar">
                    <div class="d-flex align-items-center">
                        <div class="resume-file-icon ${fileInfo.colorClass}">
                            <i class="mdi ${fileInfo.icon}"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-1 fw-bold text-dark text-break">
                                ${escapeHtml(
                                    attachment || 'Resume'
                                )}
                            </h5>
                            <div class="small text-muted">
                                ${fileInfo.extension.toUpperCase()}
                                &nbsp;•&nbsp;
                                Candidate Resume
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        ${
                            fileUrl
                                ? `
                                    <a
                                        href="${escapeAttribute(fileUrl)}"
                                        target="_blank"
                                        rel="noopener"
                                        class="btn btn-sm btn-warning">

                                        <i class="mdi mdi-open-in-new me-1"></i>
                                        Open

                                    </a>
                                    <a
                                        href="${escapeAttribute(downloadUrl)}"
                                        class="btn btn-sm btn-primary">

                                        <i class="mdi mdi-download-outline me-1"></i>
                                        Download
                                    </a>
                                `
                                : ''
                        }

                    </div>
                </div>

                <!-- Viewer -->
                <div class="resume-viewer-card">
                    <div class="resume-viewer-body">
                        ${renderResumeViewer(
                            fileUrl,
                            downloadUrl,
                            fileInfo,
                            resume
                        )}
                    </div>
                </div>

                <!-- Extracted Text -->
                <!--
                <div class="card resume-extracted-card mt-4">
                    <div class="card-header bg-white">
                        <div class="d-flex align-items-center">
                            <div class="resume-section-icon">
                                <i class="mdi mdi-text-box-search-outline"></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-1 fw-bold">
                                    Extracted Resume Text
                                </h6>
                                <small class="text-muted">
                                    Text extracted from the uploaded resume
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        ${
                            resume.text
                                ? `
                                    <div class="resume-extracted-text">
                                        ${escapeHtml(
                                            resume.text
                                        )}
                                    </div>
                                `
                                : `
                                    <div class="resume-empty-text">
                                        <i class="mdi mdi-text-box-remove-outline fs-1"></i>

                                        <div class="mt-2">
                                            Extracted resume text is not available.
                                        </div>
                                    </div>
                                `
                        }
                    </div>
                </div> -->
            </div>
        `);

        initializeResumeViewer();
    }

    function getResumeFileInfo(filename)
    {
        const extension = String(filename || '')
            .split('.')
            .pop()
            .toLowerCase();

        switch (extension) {

            case 'pdf':

                return {
                    extension: 'pdf',
                    type: 'pdf',
                    icon: 'mdi-file-pdf-box',
                    colorClass: 'resume-file-pdf'
                };

            case 'doc':

                return {
                    extension: 'doc',
                    type: 'document',
                    icon: 'mdi-file-word-box',
                    colorClass: 'resume-file-word'
                };

            case 'docx':

                return {
                    extension: 'docx',
                    type: 'document',
                    icon: 'mdi-file-word-box',
                    colorClass: 'resume-file-word'
                };

            case 'jpg':
            case 'jpeg':

                return {
                    extension: extension,
                    type: 'image',
                    icon: 'mdi-file-image-box',
                    colorClass: 'resume-file-image'
                };

            case 'png':

                return {
                    extension: 'png',
                    type: 'image',
                    icon: 'mdi-file-image-box',
                    colorClass: 'resume-file-image'
                };

            case 'webp':

                return {
                    extension: 'webp',
                    type: 'image',
                    icon: 'mdi-file-image-box',
                    colorClass: 'resume-file-image'
                };

            case 'txt':

                return {
                    extension: 'txt',
                    type: 'text',
                    icon: 'mdi-file-document-outline',
                    colorClass: 'resume-file-text'
                };

            default:

                return {
                    extension: extension || 'file',
                    type: 'unknown',
                    icon: 'mdi-file-outline',
                    colorClass: 'resume-file-default'
                };
        }
    }

    function buildResumeUrl(attachment, applicantId, disposition = 'inline')
    {
        // Compatibility helper: do not build public-folder URLs from filenames.
        return applicantId ? candidateResumeOpenUrl(applicantId, disposition) : '';
    }

    function renderResumeViewer(fileUrl, downloadUrl, fileInfo, resume)
    {
        if (!fileUrl) {

            return `
                <div class="resume-viewer-empty">
                    <div class="resume-empty-icon">
                        <i class="mdi mdi-file-alert-outline"></i>
                    </div>
                    <h5 class="fw-bold mt-3">
                        Resume File Not Available
                    </h5>
                    <p class="text-muted mb-0">
                        The candidate record does not contain a valid resume attachment.
                    </p>
                </div>
            `;
        }


        /*
        |--------------------------------------------------------------------------
        | PDF
        |--------------------------------------------------------------------------
        */

        if (fileInfo.type === 'pdf') {

            return `

                <div class="resume-pdf-container">

                    <div class="resume-pdf-loading"
                        id="resumePdfLoading">

                        <div class="spinner-border text-primary"></div>

                        <div class="mt-2 text-muted">
                            Loading resume...
                        </div>

                    </div>

                    <iframe
                        id="resumePdfFrame"
                        src="${escapeAttribute(fileUrl)}#toolbar=1&navpanes=0&view=FitH"
                        class="resume-pdf-frame"
                        title="Candidate Resume">
                    </iframe>

                </div>

            `;
        }


        /*
        |--------------------------------------------------------------------------
        | Image
        |--------------------------------------------------------------------------
        */

        if (fileInfo.type === 'image') {

            return `

                <div class="resume-image-container">

                    <div class="resume-image-toolbar">

                        <button
                            type="button"
                            class="btn btn-sm btn-light"
                            onclick="resumeImageZoom(-0.1)">

                            <i class="mdi mdi-minus"></i>

                        </button>

                        <span id="resumeImageZoomValue">
                            100%
                        </span>

                        <button
                            type="button"
                            class="btn btn-sm btn-light"
                            onclick="resumeImageZoom(0.1)">

                            <i class="mdi mdi-plus"></i>

                        </button>

                        <button
                            type="button"
                            class="btn btn-sm btn-light"
                            onclick="resumeImageReset()">

                            <i class="mdi mdi-refresh"></i>

                        </button>

                    </div>

                    <div
                        class="resume-image-stage"
                        id="resumeImageStage">

                        <img
                            id="resumeImagePreview"
                            src="${escapeAttribute(fileUrl)}"
                            alt="Candidate Resume"
                            class="resume-image-preview"
                        />

                    </div>

                </div>

            `;
        }


        /*
        |--------------------------------------------------------------------------
        | TXT
        |--------------------------------------------------------------------------
        */

        if (fileInfo.type === 'text') {

            return `

                <div class="resume-native-text-viewer">

                    ${escapeHtml(
                        resume.text || 'No text available.'
                    )}

                </div>

            `;
        }


        /*
        |--------------------------------------------------------------------------
        | DOC / DOCX
        |--------------------------------------------------------------------------
        |
        | Browsers do not consistently render DOC/DOCX natively.
        | Show an intelligent production fallback.
        |--------------------------------------------------------------------------
        */

        if (fileInfo.type === 'document') {

            return `

                <div class="resume-document-fallback">

                    <div class="resume-document-icon">

                        <i class="mdi mdi-file-word-outline"></i>

                    </div>

                    <h5 class="fw-bold mt-3">
                        ${fileInfo.extension.toUpperCase()} Resume
                    </h5>

                    <p class="text-muted text-center">

                        This document format cannot be reliably rendered
                        directly by every browser.

                    </p>

                    <div class="d-flex justify-content-center gap-2 mt-3">

                        <a
                            href="${escapeAttribute(fileUrl)}"
                            target="_blank"
                            rel="noopener"
                            class="btn btn-primary">

                            <i class="mdi mdi-open-in-new me-1"></i>

                            Open Document

                        </a>

                        <a
                            href="${escapeAttribute(downloadUrl || fileUrl)}"
                            class="btn btn-light-primary">

                            <i class="mdi mdi-download-outline me-1"></i>

                            Download

                        </a>

                    </div>
                    <!--
                    ${
                        resume.text
                            ? `
                                <div class="mt-4 w-100">

                                    <div class="alert alert-light-primary">

                                        <i class="mdi mdi-information-outline me-1"></i>

                                        Extracted resume text is available below
                                        for recruiter review.

                                    </div>

                                </div>
                            `
                            : ''
                    }
                    -->
                </div>

            `;
        }


        /*
        |--------------------------------------------------------------------------
        | Unknown
        |--------------------------------------------------------------------------
        */

        return `

            <div class="resume-document-fallback">

                <div class="resume-document-icon">

                    <i class="mdi mdi-file-question-outline"></i>

                </div>

                <h5 class="fw-bold mt-3">
                    Unsupported Resume Format
                </h5>

                <p class="text-muted">
                    Please open or download the original file.
                </p>

                <a
                    href="${escapeAttribute(fileUrl)}"
                    target="_blank"
                    rel="noopener"
                    class="btn btn-primary">

                    <i class="mdi mdi-open-in-new me-1"></i>

                    Open Resume

                </a>

            </div>

        `;
    }

    function escapeAttribute(value)
    {
        return String(value ?? '')
            .replace(/&/g, '&amp;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');
    }

    let resumeImageScale = 1;

    function initializeResumeViewer()
    {
        resumeImageScale = 1;

        const pdfFrame = document.getElementById('resumePdfFrame' );

        if (pdfFrame) {
            pdfFrame.addEventListener(
                'load',
                function() {
                    $('#resumePdfLoading').fadeOut(200);
                }
            );
        }
    }

    function resumeImageZoom(change)
    {
        const image = document.getElementById('resumeImagePreview');

        if (!image) {
            return;
        }

        resumeImageScale += change;

        resumeImageScale =
            Math.max(
                0.5,
                Math.min(
                    3,
                    resumeImageScale
                )
            );

        image.style.transform = `scale(${resumeImageScale})`;
        $('#resumeImageZoomValue').text(
            Math.round(resumeImageScale * 100) + '%'
        );
    }

    function resumeImageReset()
    {
        const image = document.getElementById('resumeImagePreview' );

        if (!image) {
            return;
        }

        resumeImageScale = 1;

        image.style.transform = 'scale(1)';

        $('#resumeImageZoomValue').text('100%');
    }

    function resumeHeader(resume)
    {
        const applicantId = Number(resume?.applicant_sno || resume?.sno || resume?.candidate_id || 0);
        const downloadUrl = candidateResumeOpenUrl(applicantId, 'attachment');
        return `
            <div class="card shadow-sm">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <h4>Resume Intelligence</h4>
                        <div class="text-muted">AI Extracted Resume</div>
                    </div>
                    ${downloadUrl ? `<a href="${escapeAttribute(downloadUrl)}" target="_blank" rel="noopener" class="btn btn-primary"><i class="mdi mdi-download"></i> Download Resume</a>` : ''}
                </div>
            </div>
        `;
    }

    function resumeSummary(resume)
    {
        return `
            <div class="card mt-4">
                <div class="card-body">
                    <h5>
                        Professional Summary
                    </h5>
                    <p>
                        ${resume.summary}
                    </p>
                </div>
            </div>
        `;
    }

    function skillsSection(resume)
    {

        let html="";

        (resume.skills||[]).forEach(skill=>{

            html+=`
                <span class="badge bg-success m-1">
                    ${skill}
                </span>
            `;

        });

        return `
            <div class="card mt-4">
                <div class="card-body">
                    <h5>
                        Detected Skills
                    </h5>
                    ${html}
                </div>
            </div>
        `;

    }

    function experienceSection(resume)
    {

        let html="";

        (resume.experience||[]).forEach(job=>{
            html+=`
                <div class="timeline-item">
                    <h5>
                        ${job.company}
                    </h5>
                    <div>
                        ${job.designation}
                    </div>
                    <div class="text-muted">
                        ${job.duration}
                    </div>
                    <ul>
                        ${job.responsibilities.map(x=>`<li>${x}</li>`).join("")}
                    </ul>
                </div>
            `;
        });

        return `
            <div class="card mt-4">
                <div class="card-body">
                    <h5>
                        Experience
                    </h5>
                    ${html}
                </div>
            </div>
        `;

    }

    function educationSection(resume)
    {

        let html="";

        (resume.education||[]).forEach(x=>{
            html+=`
                <div class="mb-3">
                    <strong>
                        ${x.degree}
                    </strong>
                    <div>
                        ${x.college}
                    </div>
                    <div>
                        ${x.year}
                    </div>
                </div>
            `;
        });

        return `
            <div class="card mt-4">
                <div class="card-body">
                    <h5>
                        Education
                    </h5>
                    ${html}
                </div>
            </div>
        `;

    }

    function keywordSection(ai)
    {

        let positive="";

        (ai.ai_response.detected_keywords||[]).forEach(x=>{
            positive+=`
                <span class="badge bg-primary me-2 mb-2">
                    ${x}
                </span>
            `;
        });

        let missing="";

        (ai.ai_response.missing_keywords||[]).forEach(x=>{

            missing+=`
                <span class="badge bg-danger me-2 mb-2">
                    ${x}
                </span>
            `;

        });

        return `
            <div class="row mt-4">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5>
                                Detected Keywords
                            </h5>
                            ${positive}
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5>
                                Missing Keywords
                            </h5>
                            ${missing}
                        </div>
                    </div>
                </div>
            </div>
        `;

    }

    function resumeTextViewer(resume)
    {
        return `
            <div class="card mt-4">
                <div class="card-header">
                    <h5>Extracted Resume</h5>
                </div>
                <div class="card-body">
                    <pre class="resume-text">
                        ${resume.text}
                    </pre>
                </div>
            </div>
        `;
    }

    function renderTimeline(data)
    {
        let html="";
        (data.timeline || []).forEach(item=>{
            html+=timelineCard(item);
        });
        $("#timelineTab").html(html);

    }

    function timelineCard(item)
    {
        return `
            <div class="timeline-card">
                <div class="timeline-icon">
                    ${timelineIcon(item.type)}
                </div>
                <div class="timeline-content">
                    <div class="d-flex justify-content-between">
                        <h5>
                            ${item.title}
                        </h5>
                        <small>
                            ${item.date}
                        </small>
                    </div>
                    <div>
                        ${item.description}
                    </div>
                    <small class="text-muted">
                        ${item.user}
                    </small>
                </div>
            </div>
        `;
    }

    function timelineIcon(type)
    {
        switch(type){
            case "application":
                return `<i class="mdi mdi-file-document-outline"></i>`;
            case "ai":
                return `<i class="mdi mdi-robot"></i>`;
            case "shortlist":
                return `<i class="mdi mdi-account-check"></i>`;
            case "interview":
                return `<i class="mdi mdi-calendar"></i>`;
            case "offer":
                return `<i class="mdi mdi-briefcase-check"></i>`;
            case "reject":
                return `<i class="mdi mdi-close-circle"></i>`;
            default:
                return `<i class="mdi mdi-circle"></i>`;
        }

    }

    function timelineColor(status)
    {
        switch(status){
            case "completed":
                return "success";
            case "pending":
                return "warning";
            case "rejected":
                return "danger";
            case "scheduled":
                return "primary";
            default:
                return "secondary";
        }
    }

    function renderOverviewOld(data)
    {
        const candidate = data?.candidate || {};
        const ai = data?.ai || {};
        const aiResponse = ai?.ai_response || {};

        const matches = Array.isArray(ai.matches)
            ? ai.matches
            : [];

        const score = clampScore(
            aiResponse.overall_match_score
        );

        const atsScore = clampScore(
            aiResponse.ats_keyword_match_score
        );

        const skillsScore = clampScore(
            aiResponse.skills_alignment_score
        );

        const experienceScore = clampScore(
            aiResponse.experience_relevance_score
        );

        const impactScore = clampScore(
            aiResponse.impact_metrics_score
        );

        const responsibilityScore = clampScore(
            aiResponse.role_responsibility_match_score
        );

        const candidateName =
            candidate.name ||
            candidate.email ||
            'Unnamed Candidate';

        const initials = getCandidateInitials(candidateName);

        /*
        |--------------------------------------------------------------------------
        | Hiring Signal
        |--------------------------------------------------------------------------
        */

        let signal = 'Review Required';
        let signalClass = 'warning';
        let signalIcon = 'mdi-eye-outline';

        if (matches.length === 0) {

            signal = 'No Company Role Match';
            signalClass = 'secondary';
            signalIcon = 'mdi-briefcase-remove-outline';

        } else if (score >= 85) {

            signal = 'Strong Candidate';
            signalClass = 'success';
            signalIcon = 'mdi-check-decagram-outline';

        } else if (score >= 70) {

            signal = 'Good Potential';
            signalClass = 'info';
            signalIcon = 'mdi-account-check-outline';

        } else if (score >= 50) {

            signal = 'Needs Recruiter Review';
            signalClass = 'warning';
            signalIcon = 'mdi-account-search-outline';

        } else {

            signal = 'Low Match';
            signalClass = 'danger';
            signalIcon = 'mdi-alert-circle-outline';
        }

        /*
        |--------------------------------------------------------------------------
        | Role Match Cards
        |--------------------------------------------------------------------------
        */

        let roleHtml = '';

        if (matches.length) {

            matches.forEach((role, index) => {

                const confidence = clampScore(
                    role.confidence
                );

                const confidenceClass =
                    confidence >= 80
                        ? 'success'
                        : confidence >= 60
                            ? 'info'
                            : 'warning';

                roleHtml += `
                    <div class="overview-role-card">

                        <div class="d-flex align-items-center">

                            <div class="overview-role-number">
                                ${index + 1}
                            </div>

                            <div class="flex-grow-1 ms-3">

                                <div class="fw-bold text-dark">
                                    Role ID ${escapeHtml(
                                        role.role_id ?? '-'
                                    )}
                                </div>

                                <div class="small text-muted mt-1">
                                    ${escapeHtml(
                                        role.reason ||
                                        'AI identified this role as a potential match.'
                                    )}
                                </div>

                            </div>

                            <div class="text-end">

                                <div class="fw-bold text-${confidenceClass}">
                                    ${confidence}%
                                </div>

                                <small class="text-muted">
                                    Confidence
                                </small>

                            </div>

                        </div>

                        <div class="progress mt-3"
                            style="height:6px;">

                            <div
                                class="progress-bar bg-${confidenceClass}"
                                style="width:${confidence}%">
                            </div>

                        </div>

                    </div>
                `;
            });

        } else {

            roleHtml = `
                <div class="overview-empty-state">

                    <div class="overview-empty-icon">
                        <i class="mdi mdi-briefcase-remove-outline"></i>
                    </div>

                    <div>
                        <h6 class="fw-bold mb-1">
                            No Suitable Company Role Found
                        </h6>

                        <p class="text-muted mb-0 small">
                            AI did not find a sufficiently strong match
                            against the currently available company roles.
                        </p>
                    </div>

                </div>
            `;
        }

        /*
        |--------------------------------------------------------------------------
        | Overview HTML
        |--------------------------------------------------------------------------
        */

        $('#overviewTab').html(`

            <!-- Candidate Summary -->
            <div class="overview-hero-card">

                <div class="d-flex flex-wrap align-items-center">

                    <div class="overview-avatar">
                        ${escapeHtml(initials)}
                    </div>

                    <div class="ms-3 flex-grow-1">

                        <div class="d-flex flex-wrap align-items-center gap-2">

                            <h4 class="mb-0 fw-bold text-dark">
                                ${escapeHtml(candidateName)}
                            </h4>

                            <span class="badge bg-${signalClass}">
                                <i class="mdi ${signalIcon} me-1"></i>
                                ${signal}
                            </span>

                        </div>

                        <div class="text-muted mt-2">

                            ${
                                candidate.current_designation
                                    ? escapeHtml(
                                        candidate.current_designation
                                    )
                                    : 'Designation not provided'
                            }

                        </div>

                        <div class="d-flex flex-wrap gap-2 mt-3">

                            ${
                                candidate.email
                                    ? `
                                        <span class="overview-contact-chip">
                                            <i class="mdi mdi-email-outline"></i>
                                            ${escapeHtml(candidate.email)}
                                        </span>
                                    `
                                    : ''
                            }

                            ${
                                candidate.mobile
                                    ? `
                                        <span class="overview-contact-chip">
                                            <i class="mdi mdi-phone-outline"></i>
                                            ${escapeHtml(candidate.mobile)}
                                        </span>
                                    `
                                    : ''
                            }

                            ${
                                candidate.location
                                    ? `
                                        <span class="overview-contact-chip">
                                            <i class="mdi mdi-map-marker-outline"></i>
                                            ${escapeHtml(candidate.location)}
                                        </span>
                                    `
                                    : ''
                            }

                        </div>

                    </div>

                    <!-- Overall Score -->
                    <div class="overview-score-wrapper">

                        <div
                            class="overview-score-circle"
                            style="--score:${score}"
                        >

                            <div>
                                <strong>
                                    ${score}%
                                </strong>

                                <small>
                                    ATS Match
                                </small>
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <!-- Key Metrics -->
            <div class="row g-3 mt-1">

                ${overviewMetricCard(
                    'Matched Roles',
                    matches.length,
                    'mdi-briefcase-check-outline',
                    'primary'
                )}

                ${overviewMetricCard(
                    'ATS Keywords',
                    atsScore + '%',
                    'mdi-key-outline',
                    'info'
                )}

                ${overviewMetricCard(
                    'Skills Alignment',
                    skillsScore + '%',
                    'mdi-code-tags-check',
                    'success'
                )}

                ${overviewMetricCard(
                    'Experience',
                    experienceScore + '%',
                    'mdi-briefcase-clock-outline',
                    'warning'
                )}

            </div>


            <!-- Role Matching -->
            <div class="card overview-section-card mt-4">

                <div class="card-header bg-white border-0 pt-4 px-4">

                    <div class="d-flex align-items-center">

                        <div class="overview-section-icon bg-primary-subtle text-primary">
                            <i class="mdi mdi-briefcase-search-outline"></i>
                        </div>

                        <div class="ms-3">

                            <h5 class="mb-1 fw-bold">
                                Company Role Matching
                            </h5>

                            <small class="text-muted">
                                AI matched this candidate against your available roles
                            </small>

                        </div>

                    </div>

                </div>

                <div class="card-body px-4 pt-2">

                    ${roleHtml}

                </div>

            </div>


            <!-- ATS Score Breakdown -->
            <div class="card overview-section-card mt-4">

                <div class="card-header bg-white border-0 pt-4 px-4">

                    <div class="d-flex align-items-center">

                        <div class="overview-section-icon bg-success-subtle text-success">
                            <i class="mdi mdi-chart-box-outline"></i>
                        </div>

                        <div class="ms-3">

                            <h5 class="mb-1 fw-bold">
                                ATS Evaluation
                            </h5>

                            <small class="text-muted">
                                Overall resume quality and role suitability indicators
                            </small>

                        </div>

                    </div>

                </div>

                <div class="card-body px-4">

                    ${overviewScoreRow(
                        'ATS Keyword Match',
                        atsScore,
                        'mdi-key-outline'
                    )}

                    ${overviewScoreRow(
                        'Skills Alignment',
                        skillsScore,
                        'mdi-code-tags'
                    )}

                    ${overviewScoreRow(
                        'Experience Relevance',
                        experienceScore,
                        'mdi-briefcase-outline'
                    )}

                    ${overviewScoreRow(
                        'Impact & Achievements',
                        impactScore,
                        'mdi-chart-line'
                    )}

                    ${overviewScoreRow(
                        'Responsibility Match',
                        responsibilityScore,
                        'mdi-account-check-outline'
                    )}

                </div>

            </div>


            <!-- Recruiter Snapshot -->
            <div class="row g-3 mt-1">

                <div class="col-lg-6">

                    <div class="card overview-section-card h-100">

                        <div class="card-body">

                            <div class="d-flex align-items-center mb-3">

                                <div class="overview-section-icon bg-success-subtle text-success">
                                    <i class="mdi mdi-star-check-outline"></i>
                                </div>

                                <h6 class="fw-bold mb-0 ms-3">
                                    Candidate Strengths
                                </h6>

                            </div>

                            ${overviewBulletList(
                                aiResponse.strengths,
                                'success',
                                'mdi-check-circle-outline'
                            )}

                        </div>

                    </div>

                </div>


                <div class="col-lg-6">

                    <div class="card overview-section-card h-100">

                        <div class="card-body">

                            <div class="d-flex align-items-center mb-3">

                                <div class="overview-section-icon bg-danger-subtle text-danger">
                                    <i class="mdi mdi-alert-circle-outline"></i>
                                </div>

                                <h6 class="fw-bold mb-0 ms-3">
                                    Recruiter Attention Points
                                </h6>

                            </div>

                            ${overviewBulletList(
                                aiResponse.weaknesses,
                                'danger',
                                'mdi-alert-outline'
                            )}

                        </div>

                    </div>

                </div>

            </div>


            <!-- Candidate Information -->
            <div class="card overview-section-card mt-4">

                <div class="card-body">

                    <h6 class="fw-bold mb-4">
                        <i class="mdi mdi-account-details-outline me-2 text-primary"></i>
                        Candidate Information
                    </h6>

                    <div class="row g-4">

                        ${overviewInfo(
                            'Experience',
                            candidate.experience
                        )}

                        ${overviewInfo(
                            'Qualification',
                            candidate.qualification
                        )}

                        ${overviewInfo(
                            'Current Company',
                            candidate.current_company
                        )}

                        ${overviewInfo(
                            'Current Designation',
                            candidate.current_designation
                        )}

                      /*  ${overviewInfo(
                            'Current CTC',
                            candidate.current_ctc
                        )}

                        ${overviewInfo(
                            'Expected CTC',
                            candidate.expected_ctc
                        )}

                        ${overviewInfo(
                            'Notice Period',
                            candidate.notice_period
                        )}

                        ${overviewInfo(
                            'Location',
                            candidate.location
                        )} 
                        */

                    </div>

                </div>

            </div>

        `);
    }

    function renderOverview(data)
    {
        const candidate = data?.candidate || {};
        const ai = data?.ai || {};
        const aiResponse = ai?.ai_response || {};
        const matches = Array.isArray(ai?.matches) ? ai.matches : [];

        const score = clampScore(aiResponse.overall_match_score);
        const atsScore = clampScore(aiResponse.ats_keyword_match_score);
        const skillsScore = clampScore(aiResponse.skills_alignment_score);
        const experienceScore = clampScore(aiResponse.experience_relevance_score);
        const impactScore = clampScore(aiResponse.impact_metrics_score);
        const responsibilityScore =
            clampScore(aiResponse.role_responsibility_match_score);

        const candidateName =
            candidate.name ||
            candidate.email ||
            'Unnamed Candidate';

        const initials = getCandidateInitials(candidateName);

        /*
        |--------------------------------------------------------------------------
        | Hiring Signal
        |--------------------------------------------------------------------------
        */

        let signal = 'Recruiter Review Required';
        let signalClass = 'warning';
        let signalIcon = 'mdi-account-search-outline';

        if (!matches.length) {

            signal = 'No Suitable Company Role';
            signalClass = 'secondary';
            signalIcon = 'mdi-briefcase-remove-outline';

        } else if (score >= 85) {

            signal = 'Strong Candidate';
            signalClass = 'success';
            signalIcon = 'mdi-check-decagram-outline';

        } else if (score >= 70) {

            signal = 'Good Potential';
            signalClass = 'info';
            signalIcon = 'mdi-account-check-outline';

        } else if (score >= 50) {

            signal = 'Needs Review';
            signalClass = 'warning';
            signalIcon = 'mdi-account-search-outline';

        } else {

            signal = 'Low ATS Match';
            signalClass = 'danger';
            signalIcon = 'mdi-alert-circle-outline';

        }

        /*
        |--------------------------------------------------------------------------
        | Score helper
        |--------------------------------------------------------------------------
        */

        function scoreColor(value)
        {
            if (value >= 80) return 'success';
            if (value >= 60) return 'info';
            if (value >= 40) return 'warning';

            return 'danger';
        }

        function scoreLabel(value)
        {
            if (value >= 85) return 'Excellent';
            if (value >= 70) return 'Strong';
            if (value >= 50) return 'Moderate';

            return 'Needs Improvement';
        }

        function scoreCard(
            label,
            value,
            icon
        ) {

            const color = scoreColor(value);

            return `
                <div class="col-xl-4 col-md-6 mb-3">

                    <div class="ai-score-card">

                        <div class="d-flex align-items-center justify-content-between">

                            <div class="d-flex align-items-center gap-2">

                                <div class="ai-score-icon text-${color}">
                                    <i class="mdi ${icon}"></i>
                                </div>

                                <div>

                                    <div class="small text-muted">
                                        ${escapeHtml(label)}
                                    </div>

                                    <div class="fw-bold text-dark">
                                        ${scoreLabel(value)}
                                    </div>

                                </div>

                            </div>

                            <div class="ai-score-number text-${color}">
                                ${value}%
                            </div>

                        </div>

                        <div
                            class="progress mt-3"
                            style="height:6px;"
                        >
                            <div
                                class="progress-bar bg-${color}"
                                style="width:${value}%"
                            ></div>
                        </div>

                    </div>

                </div>
            `;
        }

        /*
        |--------------------------------------------------------------------------
        | Role Matches
        |--------------------------------------------------------------------------
        */

        let roleHtml = '';

        if (matches.length > 0) {

            matches.forEach(function(role, index) {

                const confidence =
                    clampScore(role?.confidence);

                const color =
                    scoreColor(confidence);

                roleHtml += `
                    <div class="overview-role-card">

                        <div class="d-flex align-items-start">

                            <div class="overview-role-number">
                                ${index + 1}
                            </div>

                            <div class="flex-grow-1 ms-3">

                                <div class="d-flex align-items-center gap-2">

                                    <span class="fw-bold text-dark">
                                        Company Role
                                    </span>

                                    <span class="badge bg-light-primary text-primary">
                                        Role :
                                        ${escapeHtml(
                                            role?.role_name ?? '-'
                                        )}
                                    </span>

                                </div>

                                <div class="small text-muted mt-2">
                                    ${escapeHtml(
                                        role?.reason ||
                                        'AI identified a relevant match based on the candidate profile.'
                                    )}
                                </div>

                            </div>

                            <div class="text-end ms-3">

                                <div class="fw-bold text-${color} fs-5">
                                    ${confidence}%
                                </div>

                                <small class="text-muted">
                                    Confidence
                                </small>

                            </div>

                        </div>

                        <div
                            class="progress mt-3"
                            style="height:6px;"
                        >
                            <div
                                class="progress-bar bg-${color}"
                                style="width:${confidence}%"
                            ></div>
                        </div>

                    </div>
                `;

            });

        } else {

            roleHtml = `
                <div class="overview-empty-state">

                    <div class="overview-empty-icon">
                        <i class="mdi mdi-briefcase-remove-outline"></i>
                    </div>

                    <div>

                        <h6 class="fw-bold mb-1">
                            No Suitable Company Role Found
                        </h6>

                        <p class="text-muted mb-0 small">
                            The AI did not identify a sufficiently strong
                            match against the company's available roles.
                        </p>

                        <div class="mt-2 small text-muted">
                            Recruiter can still review the candidate's
                            complete resume and AI evaluation.
                        </div>

                    </div>

                </div>
            `;

        }

        /*
        |--------------------------------------------------------------------------
        | Strengths
        |--------------------------------------------------------------------------
        */

        const strengths =
            Array.isArray(aiResponse.strengths)
                ? aiResponse.strengths
                : [];

        const weaknesses =
            Array.isArray(aiResponse.weaknesses)
                ? aiResponse.weaknesses
                : [];

        const missingKeywords =
            Array.isArray(aiResponse.missing_keywords)
                ? aiResponse.missing_keywords
                : [];

        const improvements =
            Array.isArray(aiResponse.resume_improvements)
                ? aiResponse.resume_improvements
                : [];

        function renderList(
            items,
            emptyText,
            icon,
            color
        ) {

            if (!items.length) {

                return `
                    <div class="text-muted small">
                        ${escapeHtml(emptyText)}
                    </div>
                `;

            }

            return items.map(function(item) {

                return `
                    <div class="ai-insight-item">

                        <i class="mdi ${icon} text-${color}"></i>

                        <span>
                            ${escapeHtml(item)}
                        </span>

                    </div>
                `;

            }).join('');

        }

        /*
        |--------------------------------------------------------------------------
        | Candidate Information
        |--------------------------------------------------------------------------
        */

        const information = [

            {
                label: 'Email',
                value: candidate.email,
                icon: 'mdi-email-outline'
            },

            {
                label: 'Mobile',
                value: candidate.mobile,
                icon: 'mdi-phone-outline'
            },

            {
                label: 'Experience',
                value: candidate.experience,
                icon: 'mdi-briefcase-outline'
            },

            {
                label: 'Qualification',
                value: candidate.qualification,
                icon: 'mdi-school-outline'
            },

            {
                label: 'Current Company',
                value: candidate.current_company,
                icon: 'mdi-domain'
            },

            {
                label: 'Current Designation',
                value: candidate.current_designation,
                icon: 'mdi-account-tie-outline'
            },

            {
                label: 'Location',
                value: candidate.location,
                icon: 'mdi-map-marker-outline'
            },

            {
                label: 'Notice Period',
                value: candidate.notice_period,
                icon: 'mdi-calendar-clock-outline'
            }

        ];

        const informationHtml =
            information
                .filter(item => item.value)
                .map(item => `
                    <div class="col-xl-3 col-md-6 mb-3">

                        <div class="candidate-info-item">

                            <div class="candidate-info-icon">
                                <i class="mdi ${item.icon}"></i>
                            </div>

                            <div>

                                <div class="small text-muted">
                                    ${escapeHtml(item.label)}
                                </div>

                                <div class="fw-semibold text-dark text-break">
                                    ${escapeHtml(item.value)}
                                </div>

                            </div>

                        </div>

                    </div>
                `)
                .join('');

        /*
        |--------------------------------------------------------------------------
        | Main Overview
        |--------------------------------------------------------------------------
        */

        $('#overviewTab').html(`

            <!-- Candidate Header -->

            <div class="overview-hero-card mb-4">

                <div class="d-flex flex-wrap align-items-center">

                    <div class="overview-avatar">
                        ${escapeHtml(initials)}
                    </div>

                    <div class="ms-3 flex-grow-1">

                        <div class="d-flex flex-wrap align-items-center gap-2">

                            <h4 class="mb-0 fw-bold text-dark">
                                ${escapeHtml(candidateName)}
                            </h4>

                            <span class="badge bg-${signalClass}">
                                <i class="mdi ${signalIcon} me-1"></i>
                                ${escapeHtml(signal)}
                            </span>

                        </div>

                        <div class="text-muted mt-2">

                            ${
                                candidate.current_designation
                                    ? escapeHtml(
                                        candidate.current_designation
                                    )
                                    : 'Designation not provided'
                            }

                        </div>

                        <div class="d-flex flex-wrap gap-2 mt-3">

                            ${
                                candidate.email
                                    ? `
                                        <span class="overview-contact-chip">
                                            <i class="mdi mdi-email-outline"></i>
                                            ${escapeHtml(candidate.email)}
                                        </span>
                                    `
                                    : ''
                            }

                            ${
                                candidate.mobile
                                    ? `
                                        <span class="overview-contact-chip">
                                            <i class="mdi mdi-phone-outline"></i>
                                            ${escapeHtml(candidate.mobile)}
                                        </span>
                                    `
                                    : ''
                            }

                            ${
                                candidate.location
                                    ? `
                                        <span class="overview-contact-chip">
                                            <i class="mdi mdi-map-marker-outline"></i>
                                            ${escapeHtml(candidate.location)}
                                        </span>
                                    `
                                    : ''
                            }

                        </div>

                    </div>

                    <div class="text-center mt-3 mt-lg-0">

                        <div class="overview-main-score">

                            <div class="overview-main-score-value">
                                ${score}%
                            </div>

                            <div class="small text-muted">
                                Overall ATS
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <!-- Candidate Information -->

            <div class="card border-0 shadow-sm mb-4">

                <div class="card-header bg-transparent">

                    <h5 class="mb-0 fw-bold">
                        <i class="mdi mdi-account-details-outline me-2 text-primary"></i>
                        Candidate Information
                    </h5>

                </div>

                <div class="card-body">

                    <div class="row">
                        ${informationHtml || `
                            <div class="col-12">
                                <div class="text-muted">
                                    Candidate information is not available.
                                </div>
                            </div>
                        `}
                    </div>

                </div>

            </div>


            <!-- AI Score Dashboard -->

            <div class="card border-0 shadow-sm mb-4">

                <div class="card-header bg-transparent">

                    <div class="d-flex align-items-center justify-content-between">

                        <div>

                            <h5 class="mb-1 fw-bold">
                                <i class="mdi mdi-chart-box-outline me-2 text-primary"></i>
                                Recruiter AI Scorecard
                            </h5>

                            <small class="text-muted">
                                Resume-level evaluation generated by the AI screening engine
                            </small>

                        </div>

                        <span class="badge bg-light-primary text-primary">
                            AI Evaluation
                        </span>

                    </div>

                </div>

                <div class="card-body">

                    <div class="row">

                        ${scoreCard(
                            'ATS Keyword Match',
                            atsScore,
                            'mdi-text-search'
                        )}

                        ${scoreCard(
                            'Skills Alignment',
                            skillsScore,
                            'mdi-tools'
                        )}

                        ${scoreCard(
                            'Experience Relevance',
                            experienceScore,
                            'mdi-briefcase-check-outline'
                        )}

                        ${scoreCard(
                            'Impact & Achievements',
                            impactScore,
                            'mdi-trending-up'
                        )}

                        ${scoreCard(
                            'Role Responsibility Match',
                            responsibilityScore,
                            'mdi-clipboard-check-outline'
                        )}

                        ${scoreCard(
                            'Overall Match',
                            score,
                            'mdi-star-check-outline'
                        )}

                    </div>

                </div>

            </div>


            <!-- Company Role Matches -->

            <div class="card border-0 shadow-sm mb-4">

                <div class="card-header bg-transparent">

                    <h5 class="mb-1 fw-bold">

                        <i class="mdi mdi-briefcase-search-outline me-2 text-primary"></i>

                        Company Role Matching

                    </h5>

                    <small class="text-muted">
                        Only roles supplied by the company's recruitment database are displayed.
                    </small>

                </div>

                <div class="card-body">

                    ${roleHtml}

                </div>

            </div>


            <!-- Recruiter Insights -->

            <div class="row">

                <div class="col-lg-6 mb-4">

                    <div class="card border-0 shadow-sm h-100">

                        <div class="card-header bg-transparent">

                            <h5 class="mb-0 fw-bold">
                                <i class="mdi mdi-thumb-up-outline text-success me-2"></i>
                                Candidate Strengths
                            </h5>

                        </div>

                        <div class="card-body">

                            ${renderList(
                                strengths,
                                'No major strengths were identified.',
                                'mdi-check-circle-outline',
                                'success'
                            )}

                        </div>

                    </div>

                </div>


                <div class="col-lg-6 mb-4">

                    <div class="card border-0 shadow-sm h-100">

                        <div class="card-header bg-transparent">

                            <h5 class="mb-0 fw-bold">
                                <i class="mdi mdi-alert-circle-outline text-danger me-2"></i>
                                Candidate Weaknesses
                            </h5>

                        </div>

                        <div class="card-body">

                            ${renderList(
                                weaknesses,
                                'No significant weaknesses were identified.',
                                'mdi-alert-outline',
                                'danger'
                            )}

                        </div>

                    </div>

                </div>


                <div class="col-lg-6 mb-4">

                    <div class="card border-0 shadow-sm h-100">

                        <div class="card-header bg-transparent">

                            <h5 class="mb-0 fw-bold">
                                <i class="mdi mdi-key-remove-outline text-warning me-2"></i>
                                Missing Keywords
                            </h5>

                        </div>

                        <div class="card-body">

                            ${
                                missingKeywords.length
                                    ? missingKeywords.map(keyword => `
                                        <span class="badge bg-label-warning me-1 mb-2">
                                            ${escapeHtml(keyword)}
                                        </span>
                                    `).join('')
                                    : `
                                        <div class="text-muted small">
                                            No important missing keywords identified.
                                        </div>
                                    `
                            }

                        </div>

                    </div>

                </div>


                <div class="col-lg-6 mb-4">

                    <div class="card border-0 shadow-sm h-100">

                        <div class="card-header bg-transparent">

                            <h5 class="mb-0 fw-bold">
                                <i class="mdi mdi-file-edit-outline text-info me-2"></i>
                                Resume Improvement Recommendations
                            </h5>

                        </div>

                        <div class="card-body">

                            ${renderList(
                                improvements,
                                'No specific resume improvements were identified.',
                                'mdi-lightbulb-outline',
                                'info'
                            )}

                        </div>

                    </div>

                </div>

            </div>

        `);
    }

    function clampScore(value)
    {
        value = Number(value || 0);

        return Math.max(
            0,
            Math.min(100, Math.round(value))
        );
    }

    function getCandidateInitials(name)
    {
        const parts = String(name || 'A')
            .trim()
            .split(/\s+/)
            .filter(Boolean);

        if (!parts.length) {
            return 'A';
        }

        if (parts.length === 1) {
            return parts[0].charAt(0).toUpperCase();
        }

        return (
            parts[0].charAt(0) +
            parts[parts.length - 1].charAt(0)
        ).toUpperCase();
    }

    function overviewMetricCard(label, value, icon, color)
    {
        return `
            <div class="col-xl-3 col-md-6">
                <div class="overview-metric-card">
                    <div class="overview-metric-icon bg-${color}-subtle text-${color}">
                        <i class="mdi ${icon}"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="small text-muted">
                            ${label}
                        </div>
                        <div class="fs-4 fw-bold text-dark mt-1">
                            ${escapeHtml(String(value))}
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    function overviewScoreRow(label,score, icon)
    {
        score = clampScore(score);

        const color =
            score >= 80
                ? 'success'
                : score >= 60
                    ? 'info'
                    : score >= 40
                        ? 'warning'
                        : 'danger';

        return `
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="d-flex align-items-center">
                        <i class="mdi ${icon} text-muted me-2"></i>
                        <span class="fw-semibold">
                            ${label}
                        </span>
                    </div>
                    <strong class="text-${color}">
                        ${score}%
                    </strong>
                </div>
                <div class="progress" style="height:8px;">
                    <div class="progress-bar bg-${color}"
                        style="width:${score}%">
                    </div>
                </div>
            </div>
        `;
    }

    function overviewBulletList(items, color,icon)
    {
        if (!Array.isArray(items) || !items.length) {

            return `
                <div class="text-muted small py-3">
                    No information available.
                </div>
            `;
        }

        return `
            <div class="overview-bullet-list">
                ${items.map(item => `
                    <div class="overview-bullet-item">
                        <i class="mdi ${icon} text-${color}"></i>
                        <span>
                            ${escapeHtml(String(item))}
                        </span>
                    </div>
                `).join('')}
            </div>
        `;
    }

    function overviewInfo(label, value)
    {
        return `
            <div class="col-md-6 col-xl-3">
                <div class="overview-info-item">
                    <div class="small text-muted mb-1">
                        ${escapeHtml(label)}
                    </div>
                    <div class="fw-semibold text-dark text-break">
                        ${escapeHtml(
                            value !== null &&
                            value !== undefined &&
                            String(value).trim() !== ''
                                ? String(value)
                                : 'Not provided'
                        )}
                    </div>
                </div>
            </div>
        `;
    }

    function escapeHtml(value)
    {
        return String(value ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function renderCustomResumeViewer( fileUrl, fileInfo, resume, candidate) {

        const resumeText = String(resume?.text || '').trim();

        const attachment = String(resume?.attachment || '').trim();

        /* No Resume */
        if (!attachment && !resumeText) {
            return `
                <div class="custom-resume-empty">
                    <div class="custom-resume-empty-icon">
                        <i class="mdi mdi-file-alert-outline"></i>
                    </div>
                    <h5 class="fw-bold mt-3">
                        Resume Not Available
                    </h5>
                    <p class="text-muted mb-0">
                        No resume file or extracted resume content is available.
                    </p>
                </div>
            `;
        }

        /*PDF*/
        if (fileInfo?.type === 'pdf') {
            return `
                <div class="custom-resume-wrapper">
                    <div class="custom-resume-toolbar">
                        <div class="d-flex align-items-center gap-2">
                            <span class="custom-file-icon pdf">
                                <i class="mdi mdi-file-pdf-box"></i>
                            </span>
                            <div>
                                <div class="fw-bold">
                                    Resume Preview
                                </div>
                                <small class="text-muted">
                                    PDF document
                                </small>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="${escapeAttribute(fileUrl)}"
                                target="_blank"
                                rel="noopener"
                                class="btn btn-sm btn-warning">
                                <i class="mdi mdi-open-in-new me-1"></i>
                                Open
                            </a>
                            <a
                                href="${escapeAttribute(fileUrl)}"
                                download
                                class="btn btn-sm btn-primary">
                                <i class="mdi mdi-download-outline me-1"></i>
                                Download
                            </a>
                        </div>
                    </div>
                    <div class="custom-pdf-viewer">
                        <iframe
                            src="${escapeAttribute(fileUrl)}#toolbar=1&navpanes=0&view=FitH"
                            title="Candidate Resume"
                            loading="lazy">
                        </iframe>
                    </div>
                </div>
            `;

        }

        /*DOC / DOCX */
        if (fileInfo?.type === 'document' || fileInfo?.extension === 'doc' || fileInfo?.extension === 'docx') {

            return `
                <div class="custom-resume-wrapper">
                    <!-- Toolbar -->
                    <div class="custom-resume-toolbar">
                        <div class="d-flex align-items-center gap-2">
                            <span class="custom-file-icon word">
                                <i class="mdi mdi-file-word-box"></i>
                            </span>
                            <div>
                                <div class="fw-bold">
                                    Resume Document
                                </div>
                                <small class="text-muted">
                                    ${escapeHtml(
                                        fileInfo?.extension?.toUpperCase() || 'DOCUMENT'
                                    )}
                                    • Recruiter View
                                </small>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <a
                                href="${escapeAttribute(fileUrl)}"
                                target="_blank"
                                rel="noopener"
                                class="btn btn-sm btn-warning">
                                <i class="mdi mdi-open-in-new me-1"></i>
                                Original
                            </a>
                            <a
                                href="${escapeAttribute(fileUrl)}"
                                download
                                class="btn btn-sm btn-primary">
                                <i class="mdi mdi-download-outline me-1"></i>
                                Download
                            </a>
                        </div>
                    </div>

                    <!-- Document information -->
                    <div class="custom-doc-info">
                        <div>
                            <i class="mdi mdi-file-document-outline"></i>
                            <span>
                                ${escapeHtml(
                                    attachment || 'Resume document'
                                )}
                            </span>
                        </div>
                        <span class="badge bg-label-primary">
                            Recruiter Document View
                        </span>
                    </div>

                    <!-- Document -->
                    <div class="custom-document-stage">
                        <div class="custom-document-page">
                            <di class="custom-document-header">
                                <div class="custom-document-title">
                                    Candidate Resume
                                </div>
                                <div class="custom-document-meta">
                                    ${escapeHtml(
                                        candidateSafeName()
                                    )}
                                </div>
                            </div>
                            <div class="custom-document-content">
                                ${
                                    resumeText
                                        ? formatResumeText(
                                            resumeText
                                        )
                                        : `
                                            <div class="text-center py-5">
                                                <i class="mdi mdi-file-alert-outline fs-1 text-muted"></i>
                                                <h6 class="mt-3 fw-bold">
                                                    Resume text unavailable
                                                </h6>
                                                <p class="text-muted">
                                                    Please use the Original button
                                                    to open the DOC/DOCX file.
                                                </p>
                                            </div>
                                        `
                                }
                            </div>
                        </div>
                    </div>
                </div>
            `;

        }

        /*IMAGE*/
        if (fileInfo?.type === 'image') {

            return `
                <div class="custom-resume-wrapper">
                    <div class="custom-resume-toolbar">
                        <div class="d-flex align-items-center gap-2">
                            <span class="custom-file-icon image">
                                <i class="mdi mdi-file-image-box"></i>
                            </span>
                            <div>
                                <div class="fw-bold">
                                    Resume Image
                                </div>
                                <small class="text-muted">
                                    Image preview
                                </small>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button
                                type="button"
                                class="btn btn-sm btn-light"
                                onclick="resumeImageZoom(-0.1)">
                                <i class="mdi mdi-minus"></i>
                            </button>
                            <span id="resumeImageZoomValue"  class="px-2 align-self-center">
                                100%
                            </span>
                            <button
                                type="button"
                                class="btn btn-sm btn-light"
                                onclick="resumeImageZoom(0.1)">
                                <i class="mdi mdi-plus"></i>
                            </button>
                            <button
                                type="button"
                                class="btn btn-sm btn-light"
                                onclick="resumeImageReset()">
                                <i class="mdi mdi-refresh"></i>
                            </button>
                            <a
                                href="${escapeAttribute(fileUrl)}"
                                download
                                class="btn btn-sm btn-primary">
                                <i class="mdi mdi-download-outline"></i>
                            </a>
                        </div>
                    </div>
                    <div class="custom-image-stage" id="resumeImageStage">
                        <img id="resumeImagePreview"
                            src="${escapeAttribute(fileUrl)}"
                            alt="Candidate Resume"
                            class="custom-image-preview">
                    </div>
                </div>
            `;

        }

        /* TXT / Extracted Text */

        return `
            <div class="custom-resume-wrapper">
                <div class="custom-resume-toolbar">
                    <div class="d-flex align-items-center gap-2">
                        <span class="custom-file-icon text">
                            <i class="mdi mdi-file-document-outline"></i>
                        </span>
                        <div>
                            <div class="fw-bold">
                                Resume Text
                            </div>
                            <small class="text-muted">
                                Recruiter reading view
                            </small>
                        </div>
                    </div>
                    ${
                        fileUrl
                            ? `
                                <a href="${escapeAttribute(fileUrl)}"
                                    download
                                    class="btn btn-sm btn-primary">
                                    <i class="mdi mdi-download-outline me-1"></i>
                                    Download
                                </a>
                            `
                            : ''
                    }

                </div>
                <div class="custom-document-stage">
                    <div class="custom-document-page">
                        <div class="custom-document-content">
                            ${
                                resumeText
                                    ? formatResumeText(
                                        resumeText
                                    )
                                    : `
                                        <div class="text-muted text-center py-5">
                                            Resume content unavailable.
                                        </div>
                                    `
                            }

                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    function formatResumeText(text)
    {
        if (!text) {
            return '';
        }

        let clean = String(text)
            .replace(/\r\n/g, '\n')
            .replace(/\r/g, '\n');

        /* Remove excessive duplicate whitespace*/

        clean = clean
            .replace(/[ \t]+/g, ' ')
            .replace(/\n{3,}/g, '\n\n')
            .trim();

        const lines = clean.split('\n');

        let html = '';

        lines.forEach(function(line) {

            line = line.trim();

            if (!line) {

                html += `
                    <div class="resume-doc-spacer"></div>
                `;

                return;
            }

            /* Detect common resume headings */

            const headingPatterns = [

                /^professional summary$/i,
                /^summary$/i,
                /^profile$/i,
                /^objective$/i,
                /^education$/i,
                /^experience$/i,
                /^work experience$/i,
                /^professional experience$/i,
                /^employment history$/i,
                /^technical skills$/i,
                /^skills$/i,
                /^certifications$/i,
                /^projects$/i,
                /^languages$/i,
                /^achievements$/i,
                /^awards$/i,
                /^responsibilities$/i,
                /^personal information$/i

            ];

            const isHeading = headingPatterns.some( pattern => pattern.test(line) );

            if (isHeading) {
                html += `
                    <div class="resume-doc-heading">
                        <i class="mdi mdi-chevron-right"></i>
                        ${escapeHtml(line)}
                    </div>
                `;
                return;
            }

            /*Bullet points */

            if (/^[•●▪◦\-*]\s*/.test(line) ) {

                const bullet =
                    line.replace(
                        /^[•●▪◦\-*]\s*/,
                        ''
                    );

                html += `
                    <div class="resume-doc-bullet">
                        <span class="resume-doc-bullet-icon">
                            <i class="mdi mdi-circle-small"></i>
                        </span>

                        <span>
                            ${escapeHtml(bullet)}
                        </span>
                    </div>
                `;

                return;
            }

            /*
            |--------------------------------------------------------------------------
            | Normal paragraph
            |--------------------------------------------------------------------------
            */

            html += `
                <p class="resume-doc-paragraph">
                    ${escapeHtml(line)}
                </p>
            `;

        });

        return html;
    }

    function candidateSafeName()
    {
        /*
        * renderCustomResumeViewer does not receive candidate directly.
        * Keep this intentionally generic.
        */

        return 'Candidate';
    }
</script>

<script>
    /* Individual APPLICANT AI ANALYSIS  */

    (function () {

        'use strict';

        let currentApplicantSno = null;
        let currentAnalysis = null;
       

        /* DOM HELPERS  */
        function el(id) {
            return document.getElementById(id);
        }

        function show(id) {
            const element = el(id);
            if (element) {
                element.classList.remove('d-none');
            }
        }

        function hide(id) {
            const element = el(id);
            if (element) {
                element.classList.add('d-none');
            }
        }

        function text(id, value) {

            const element = el(id);
            if (element) {
                element.textContent = value ?? '';
            }

        }

        /* STATE  */
        function showLoading() {
            hide('applicantAiContent');
            hide('applicantAiError');
            hide('applicantAiEmpty');

            show('applicantAiLoading');

            const button = el('aiRunAnalysisButton');

            if (button) {
                button.disabled = true;
                button.innerHTML = `<span class="spinner-border spinner-border-sm me-1" role="status"></span>Analysing... `;
            }
        }

        function showContent() {

            hide('applicantAiLoading');
            hide('applicantAiError');
            hide('applicantAiEmpty');

            show('applicantAiContent');

            const button =  el('aiRunAnalysisButton');

            if (button) {
                button.disabled = false;
                button.innerHTML = `<i class="mdi mdi-refresh me-1"></i>Re-run AI Analysis
                `;
            }
        }

        function showError(message) {

            hide('applicantAiLoading');
            hide('applicantAiContent');
            hide('applicantAiEmpty');

            text('applicantAiErrorMessage',  message || 'Unable to load AI analysis.' );

            show('applicantAiError');

            const button = el('aiRunAnalysisButton');

            if (button) {
                button.disabled = false;
                button.innerHTML = `<i class="mdi mdi-robot me-1"></i>Run AI Analysis
                `;
            }
        }

        function showEmpty(message) {

            hide('applicantAiLoading');
            hide('applicantAiContent');
            hide('applicantAiError');

            text('applicantAiEmptyMessage',message ||'AI analysis is not available.' );

            show('applicantAiEmpty');

            const button =  el('aiRunAnalysisButton');

            if (button) {
                button.disabled = false;
                button.innerHTML = `<i class="mdi mdi-robot me-1"></i>Run AI Analysis
                `;
            }
        }


        /* OPEN MODAL */
        window.openAiRoleMatchModal =
            async function (sno) {
                currentApplicantSno = parseInt(sno, 10);
                currentAnalysis = null;
                resetAnalysisUI();
                showLoading();

                const modalElement = el('kt_modal_ai_analyses_individual');
                const modal =bootstrap.Modal.getOrCreateInstance(modalElement);

                modal.show();
                await loadApplicantAnalysis();

            };

        /* LOAD STORED ANALYSIS */

        async function loadApplicantAnalysis() {
            if (!currentApplicantSno) {
                showError('Invalid applicant identifier.');
                return;
            }

            try {
                const response =
                    await fetch( getAnalysisUrl(currentApplicantSno),
                        {
                            method: 'GET',
                            headers: {
                                'Accept':'application/json',
                                'X-Requested-With':'XMLHttpRequest'
                            },
                            credentials: 'same-origin'
                        }
                    );

                const result = await parseJsonResponse( response );

                if (!response.ok || !result.status ) {

                    /* Analysis doesn't exist yet */
                    if (response.status === 404 ) {
                        showEmpty( result.message || 'This applicant has not been analysed yet.' );
                        return;
                    }
                    throw new Error( result.message ||'Unable to load analysis.');
                }
                currentAnalysis = result.data;

                
                renderAnalysis(currentAnalysis);
                

                showContent();

            } catch (error) {
                console.error( 'AI Analysis Load Error:',error);
                showError(error.message );
            }
        }


        /* RUN AI ANALYSIS */
        window.runApplicantAiAnalysis =
            async function () {
                if (!currentApplicantSno) {
                    showError('Applicant information is missing.');
                    return;
                }

                showLoading();
                try {

                    const response =
                        await fetch( getMatchUrl(currentApplicantSno ),
                            {
                                method: 'POST',
                                headers: {
                                    'Accept':'application/json',
                                    'Content-Type':'application/json',
                                    'X-CSRF-TOKEN': getCsrfToken(),
                                    'X-Requested-With': 'XMLHttpRequest'
                                },
                                credentials:'same-origin',
                                body: JSON.stringify({})
                            }
                        );

                    const result = await parseJsonResponse(response );

                    if (!response.ok || !result.status) {
                        throw new Error(result.message ||'AI analysis failed.');
                    }

                    /*
                    * The matching endpoint returns
                    * the newly generated analysis.
                    */
                    

                   
                    
                    currentAnalysis = result.data;

                    renderAnalysis(currentAnalysis);
                   
                    showContent();

                    refreshApplicantTable();

                } catch (error) {
                    console.error('AI Matching Error:', error);
                    showError(error.message);
                }
            };


        /* RENDER  */
        function renderAnalysis(data) {

            if (!data) {
                showEmpty('No analysis data available.');
                return;
            }

            renderApplicant(data.applicant);
            renderScores(data.ai_response || {} );
            renderRoles( data.matches || [], data.job_role_ids || [] );
            renderList('aiStrengths', data.ai_response?.strengths );
            renderList('aiWeaknesses', data.ai_response?.weaknesses );
            renderKeywords( data.ai_response?.missing_keywords);
            renderList('aiResumeImprovements', data.ai_response?.resume_improvements);
            renderSummary(data.ai_response?.optimized_summary);
            renderRewrittenBullets( data.ai_response?.rewritten_bullets);
            text('aiAnalysisTimestamp', data.updated_at ? `Updated ${data.updated_at}` : '' );
        }

        /*  APPLICANT  */
        function renderApplicant(applicant) {

            if (!applicant) {
                return;
            }

            const name = applicant.name || 'Applicant';

            text('aiApplicantName', name );
            text('aiApplicantMeta', buildApplicantMeta(applicant ));
            text('aiApplicantAvatar',getInitials(name));
            text( 'aiApplicantStatus', 'AI Analysed');
        }

        function buildApplicantMeta( applicant) {
            const parts = [];
            if (applicant.email) {
                parts.push(applicant.email);
            }
            if (applicant.mobile) {
                parts.push(applicant.mobile );
            }

            if (applicant.sno) {
                parts.push(`Applicant #${applicant.sno}`);
            }
            return parts.join(' • ');
        }

        function getInitials(name) {

            return String(name)
                .trim()
                .split(/\s+/)
                .slice(0, 2)
                .map( word => word.charAt(0))
                .join('')
                .toUpperCase();
        }

        /*  SCORES */
        function renderScores(ai) {
            const overall = safeScore(ai.overall_match_score);
            text('aiOverallScore', `${overall}%` );
            text('aiScoreOverall',overall );
            text('aiScoreKeywords', safeScore( ai.ats_keyword_match_score ) );
            text('aiScoreSkills',safeScore( ai.skills_alignment_score) );
            text('aiScoreExperience', safeScore( ai.experience_relevance_score ) );
            text('aiScoreImpact',safeScore(ai.impact_metrics_score ));
            text('aiScoreResponsibility', safeScore(ai.role_responsibility_match_score) );

            const ring = el('aiOverallScoreRing' );
            if (ring) {
                ring.style.setProperty( '--score-angle',`${overall * 3.6}deg`);

                const span = ring.querySelector('span');
                if (span) {
                    span.textContent = `${overall}%`;
                }
            }
        }

        function safeScore(value) {

            let score = parseInt(value, 10);

            if ( Number.isNaN(score) ) {
                score = 0;
            }

            return Math.max( 0, Math.min( 100, score ) );
        }

        /*  ROLE MATCHES */
        function renderRoles( matches, roleIds ) {

            const container = el('aiRoleMatches');
            const empty = el('aiNoRoleMatch');

            if (!container) {
                return;
            }

            container.innerHTML = '';

            const validMatches =
                Array.isArray(matches)
                    ? matches
                    : [];

            text( 'aiRoleMatchCount',
                `${validMatches.length} ${
                    validMatches.length === 1
                        ? 'Role'
                        : 'Roles'
                }`
            );

            if (validMatches.length === 0 ) {
                show( 'aiNoRoleMatch');
                return;
            }

            hide( 'aiNoRoleMatch' );

            validMatches
                .forEach(
                    (match, index) => {
                        container.appendChild(
                            createRoleCard( match, index )
                        );

                    }
                );
        }

        function createRoleCard(match, index ) {

            const wrapper =  document.createElement( 'div');
            wrapper.className = 'ai-role-card';

            const confidence = safeScore(match.confidence );

            const confidenceClass =
                confidence >= 90
                    ? 'ai-confidence-high'
                    : confidence >= 80
                        ? 'ai-confidence-medium'
                        : 'ai-confidence-low';

            const roleName =  match.role_name || `Company Role #${escapeHtml( match.role_id )}`;

            wrapper.innerHTML = `
                <div class="ai-role-card-top">
                    <div>
                        <div class="ai-role-name">
                            ${escapeHtml( roleName )}
                        </div>
                        <div class="ai-role-id">
                            Role ID:
                            ${escapeHtml( match.role_id )}
                        </div>
                    </div>
                    <div class="ai-role-confidence ${confidenceClass}" >
                        ${confidence}%
                    </div>
                </div>
                <div class="ai-role-progress">
                    <div class="ai-role-progress-bar" style="width:${confidence}%" ></div>
                </div>
                <div class="ai-role-reason">
                    <i class="mdi mdi-check-circle-outline me-1"></i>
                    ${escapeHtml(  match.reason || 'No matching reason provided.' )}
                </div>
            `;

            return wrapper;
        }

        /* LISTS */
        function renderList( id, values) {

            const container = el(id);

            if (!container) {
                return;
            }

            container.innerHTML = '';

            const items = normalizeArray( values);

            if (!items.length) {
                container.innerHTML = `
                    <div class="text-muted small">
                        No specific items identified.
                    </div>
                `;
                return;
            }

            items.forEach(
                item => {
                    const div =  document.createElement('div');
                    div.className = 'ai-bullet-item';
                    div.textContent =  item;
                    container.appendChild( div );
                }
            );
        }

        /*  KEYWORDS  */
        function renderKeywords( values) {

            const container = el( 'aiMissingKeywords' );

            if (!container) {
                return;
            }

            container.innerHTML = '';

            const items = normalizeArray(values );

            if (!items.length) {
                container.innerHTML = `
                    <span class="text-muted small">
                        No major missing keywords identified.
                    </span>
                `;

                return;
            }

            items.forEach(
                item => {
                    const span = document.createElement( 'span' );
                    span.className = 'ai-keyword';
                    span.textContent = item;
                    container.appendChild( span);
                }
            );
        }

        /* SUMMARY  */
        function renderSummary( summary ) {

            const container = el('aiOptimizedSummary');

            if (!container) {
                return;
            }

            const value = String( summary || '' ).trim();

            container.textContent =  value || 'No optimized summary was generated.';
        }

        /* REWRITTEN BULLETS */
        function renderRewrittenBullets( values) {

            const container = el( 'aiRewrittenBullets');

            if (!container) {
                return;
            }

            container.innerHTML = '';
            const items = normalizeArray(  values );

            if (!items.length) {
                container.innerHTML = `
                    <div class="text-muted small">
                        No bullet rewrites were generated.
                    </div>
                `;

                return;
            }

            items.forEach(
                (item, index) => {
                    const div =  document.createElement('div' );
                    div.className = 'ai-rewritten-item';
                    div.innerHTML = `
                        <span class="ai-rewritten-number">
                            ${index + 1}
                        </span>
                        ${escapeHtml(item)}
                    `;
                    container.appendChild( div );
                }
            );
        }

        /* COPY SUMMARY */
        window.copyApplicantAiSummary =
            async function () {
                const summary =  el('aiOptimizedSummary')?.textContent?.trim();

                if (!summary) {
                    return;
                }

                try {
                    await navigator.clipboard.writeText( summary );
                    showToast('Summary copied successfully.', 'success' );

                } catch (error) {
                    console.error( 'Clipboard error:',error );
                    showToast('Unable to copy summary.','error');
                }
            };

        /* RETRY */
        window.retryApplicantAiAnalysis =
            async function () {
                await loadApplicantAnalysis();
            };

        /* RESET */
        function resetAnalysisUI() {
            hide( 'applicantAiContent' );
            hide( 'applicantAiError' );
            hide( 'applicantAiEmpty' );
            hide('applicantAiLoading' );
            text('aiApplicantName','Applicant' );
            text( 'aiApplicantMeta','' );
            text('aiApplicantAvatar', 'A' );
            text( 'aiOverallScore', '0%');
            [
                'aiScoreOverall',
                'aiScoreKeywords',
                'aiScoreSkills',
                'aiScoreExperience',
                'aiScoreImpact',
                'aiScoreResponsibility'
            ].forEach(
                id => text(id, '0')
            );

            const roleContainer =  el('aiRoleMatches');

            if (roleContainer) {
                roleContainer.innerHTML = '';
            }

            [
                'aiStrengths',
                'aiWeaknesses',
                'aiResumeImprovements',
                'aiRewrittenBullets'
            ].forEach(
                id => {
                    const element = el(id);

                    if (element) {
                        element.innerHTML = '';
                    }
                }
            );

            const keywordContainer = el('aiMissingKeywords' );

            if (keywordContainer) {
                keywordContainer.innerHTML = '';
            }

            text('aiOptimizedSummary', '' );

            const button = el('aiRunAnalysisButton' );

            if (button) {
                button.disabled = false;
                button.innerHTML = `<i class="mdi mdi-robot me-1"></i> Run AI Analysis`;
            }
        }

        /* URL HELPERS */
        function getAnalysisUrl(sno) {
            return `/hr-recruiter/applicants/${encodeURIComponent(
                sno
            )}/ai-analysis`;
        }

        function getMatchUrl(sno) {

            return `/hr-recruiter/applicants/${encodeURIComponent(
                sno
            )}/ai-match`;
        }


        /* CSRF */
        function getCsrfToken() {
            const meta = document.querySelector('meta[name="csrf-token"]');
            return meta ? meta.getAttribute('content') : '';
        }


        /* JSON  */
        async function parseJsonResponse( response ) {

            const text = await response.text();

            try {
                return JSON.parse( text  );
            } catch (error) {
                console.error( 'Invalid server JSON:',  text );
                throw new Error( 'Server returned an invalid response.' );
            }
        }

        /* HELPERS  */
        function normalizeArray( value ) {
            if ( !Array.isArray(value) ) {
                return [];
            }

            return value
                .map(item =>  String(item ?? '' ).trim())
                .filter( item => item !== '');
        }

        function escapeHtml(value ) {

            const div = document.createElement('div');

            div.textContent = String(value ?? '' );

            return div.innerHTML;
        }


        function refreshApplicantTable() {

            if (typeof window.reloadApplicantTable === 'function' ) {
                window.reloadApplicantTable();
                return;
            }
            if (typeof window.loadApplicants === 'function') {
                window.loadApplicants();
                return;
            }
        }

        function showToast( message, type = 'success') {

            if (typeof window.showNotification === 'function') {
                window.showNotification( message, type );
                return;
            }
            if (typeof window.toastr !=='undefined' ) {
                if (type === 'success' ) {
                    toastr.success( message);
                } else {
                    toastr.error( message);
                }
                return;
            }
            console.log( `[${type}] ${message}` );
        }

    })();

</script>
<!-- Bulk Role Ai Matching -->
<script>
    (function () {

        'use strict';


        let bulkRunning = false;
        let bulkStopRequested = false;
        let bulkCurrentOffset = 0;
        let bulkTotal = 0;
        let bulkBatchSize = 5;
        let bulkLimit = 100;
        let bulkProcessed = 0;
        let bulkMatched = 0;
        let bulkUnmatched = 0;
        let bulkFailed = 0;

        /* OPEN MODAL */
        window.openBulkAiMatchingModal =
            async function () {

                resetBulkUI();

                const modalElement = document.getElementById('kt_modal_bulk_ai_matching');
                const modal = bootstrap.Modal.getOrCreateInstance( modalElement);

                modal.show();
                await loadBulkStatistics();
            };

        /*  LOAD STATISTICS */
        async function loadBulkStatistics() {
            try {
                const response =
                    await fetch(
                        getBulkStatsUrl(),
                        {
                            method: 'GET',
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            credentials: 'same-origin'
                        }
                    );

                const result = await parseJsonResponse( response);
                if (!response.ok || !result.status ) {
                    throw new Error( result.message || 'Unable to load bulk statistics.');
                }

                const data = result.data || {};
                text('bulkPendingCount', formatNumber( data.pending_count ?? 0) );
                text('bulkRoleCount', formatNumber( data.active_role_count ?? 0) );
                text( 'bulkRecommendedBatch', data.recommended_batch_size ?? 5 );
            
                const input = document.getElementById('bulkAiApplicantLimit' );

                if (input) {
                    const pending = parseInt( data.pending_count ?? 0, 10);
                    input.max = Math.min( 500,  Math.max( 1, pending ) );

                    if (pending > 0) {
                        input.value = Math.min( 100, pending );
                    }
                }

            } catch (error) {
                console.error( 'Bulk statistics error:', error );
                text( 'bulkPendingCount','—');
                text( 'bulkRoleCount', '—');
                showToast( error.message, 'error');
            }
        }

        /* START BULK PROCESS  */
        window.startBulkAiMatching =
            async function () {
                if (bulkRunning) {
                    return;
                }
                bulkBatchSize = parseInt(document.getElementById('bulkAiBatchSize' )?.value || 5, 10 );
                bulkLimit = parseInt(document.getElementById('bulkAiApplicantLimit')?.value || 100, 10 );

                const forceReprocess = document.getElementById('bulkAiForceReprocess' )?.checked || false;

                if (bulkBatchSize < 1 || bulkBatchSize > 10 ) {
                    showToast( 'Invalid batch size.', 'error' );
                    return;
                }

                if ( bulkLimit < 1 || bulkLimit > 500 ) {
                    showToast('Applicant limit must be between 1 and 500.','error');
                    return;
                }


                if (forceReprocess) {
                    const confirmed = window.confirm('Re-processing will replace existing AI analysis. Continue?');

                    if (!confirmed) {
                        return;
                    }
                }

                bulkRunning = true;
                bulkStopRequested = false;
                bulkCurrentOffset = 0;
                bulkTotal = bulkLimit;
                bulkProcessed = 0;
                bulkMatched = 0;
                bulkUnmatched = 0;
                bulkFailed = 0;

                showBulkProgress();
                appendBulkLog('info','Bulk AI processing started.');

                try {
                    await processNextBulkBatch(forceReprocess);
                } catch (error) {
                    console.error('Bulk AI processing error:',error);
                    bulkRunning = false;
                    appendBulkLog('error', error.message );
                    showToast(error.message,'error');
                }
            };

        /* PROCESS NEXT BATCH */
        async function processNextBulkBatch(forceReprocess ) {

            if (!bulkRunning) {
                return;
            }

            /* Stop only between batches.Current batch is allowed to finish.  */
            if (bulkStopRequested) {
                finishBulkProcess( true);
                return;
            }

            /*Reached requested limit. */
            if (bulkProcessed >= bulkLimit) {
                finishBulkProcess(false);
                return;
            }

            const remaining = bulkLimit - bulkProcessed;
            const currentBatchSize = Math.min( bulkBatchSize,remaining);

            updateBulkProgressMessage(`Processing applicants ${bulkProcessed + 1}–${bulkProcessed + currentBatchSize}...`);

            try {
                const response =
                    await fetch(
                        getBulkMatchUrl(),
                        {
                            method: 'POST',
                            headers: {
                                'Accept':'application/json',
                                'Content-Type':'application/json',
                                'X-CSRF-TOKEN': getCsrfToken(),
                                'X-Requested-With':'XMLHttpRequest'
                            },
                            credentials: 'same-origin',
                            body: JSON.stringify({
                                batch_size:currentBatchSize,
                                limit: currentBatchSize,
                                offset: bulkCurrentOffset,
                                force_reprocess:forceReprocess
                            })
                        }
                    );


                const result =  await parseJsonResponse( response );

                if (!response.ok || !result.status) {
                    throw new Error(result.message || 'Bulk AI batch failed.');
                }

                const data = result.data || {};
                const processed = parseInt(data.processed ?? 0, 10);
                const matched = parseInt( data.matched ?? 0, 10);

                const unmatched = parseInt( data.unmatched ?? 0, 10 );
                const failed = parseInt( data.failed ?? 0,10);

                bulkProcessed +=  processed;
                bulkMatched +=  matched;
                bulkUnmatched +=  unmatched;
                bulkFailed += failed;

                /* Advance offset only by applicants actually consumed by backend.*/
                bulkCurrentOffset +=  processed;

                updateBulkCounters();

                /* Add batch result to log.*/
                appendBulkLog( processed > 0 ? 'success' : 'warning', data.message || `Batch completed: ${processed} applicant(s).` );

                /*Backend can tell us there is nothing remaining. */
                if (data.has_more === false) {
                    finishBulkProcess(false);
                    return;
                }

                /*Protect against a backend response that processed nothing.*/
                if (processed <= 0) {
                    throw new Error('The server returned zero processed applicants. Processing stopped to prevent an infinite loop.');
                }


                /* Continue next batch. */
                await processNextBulkBatch( forceReprocess );

            } catch (error) {
                console.error('Bulk batch error:', error);

                /* Don't silently continue after a failed batch.*/
                bulkFailed += currentBatchSize;
                updateBulkCounters();
                appendBulkLog('error', `Batch failed: ${error.message}`);

                bulkRunning = false;
                showToast( error.message, 'error' );
            }
        }

        /*  STOP */
        window.stopBulkAiMatching =
            function () {
                if (!bulkRunning) {
                    return;
                }

                bulkStopRequested = true;
                const button = document.getElementById( 'bulkAiStopButton' );

                if (button) {
                    button.disabled = true;
                    button.innerHTML = `
                        <span
                            class="spinner-border spinner-border-sm me-1"
                        ></span>
                        Finishing current batch...
                    `;
                }

                updateBulkProgressMessage('Stop requested. Finishing the current AI batch...');
            };

        /* COMPLETE */
        function finishBulkProcess(stopped) {

            bulkRunning = false;
            updateBulkCounters();
            updateBulkProgress();

            hide('bulkAiProgress' );
            show('bulkAiCompleted' );
            text('bulkFinalProcessed', formatNumber(bulkProcessed));
            text('bulkFinalMatched',formatNumber(bulkMatched));
            text('bulkFinalUnmatched', formatNumber(bulkUnmatched));
            text('bulkFinalFailed',formatNumber(bulkFailed));

            if (stopped) {
                appendBulkLog('warning', 'Processing stopped after the current batch.' );
            } else {
                appendBulkLog('success','All requested applicants have been processed.');
            }

            /* Refresh main applicant table. */
            refreshApplicantTable();

            /* Restore close button. */

            const closeButton = document.getElementById('bulkAiCloseButton');

            if (closeButton) {
                closeButton.disabled = false;
            }

            const stopButton = document.getElementById('bulkAiStopButton');

            if (stopButton) {
                stopButton.disabled = false;
                stopButton.innerHTML = `
                    <i class="mdi mdi-stop-circle-outline me-1"></i>
                    Stop After Current Batch
                `;
            }
        }

        /* PROGRESS */
        function updateBulkCounters() {
            text('bulkProcessedCount',formatNumber(bulkProcessed) );
            text('bulkMatchedCount',formatNumber(bulkMatched));
            text('bulkUnmatchedCount',formatNumber(bulkUnmatched));
            text('bulkFailedCount',formatNumber(bulkFailed));

            updateBulkProgress();
        }

        function updateBulkProgress() {
            let percentage = 0;
            if (bulkLimit > 0 ) {
                percentage = Math.round( (bulkProcessed / bulkLimit ) * 100);
            }

            percentage = Math.max( 0, Math.min( 100, percentage ));

            text('bulkProgressPercent',`${percentage}%`);

            const bar = document.getElementById('bulkProgressBar');

            if (bar) {
                bar.style.width =`${percentage}%`;
            }
        }

        function updateBulkProgressMessage(message ) {
            text('bulkProgressMessage',message);
            text('bulkCurrentApplicant',message );
        }

        /* LOG */
        function appendBulkLog(type, message ) {

            const container = document.getElementById('bulkAiLog');

            if (!container) {
                return;
            }


            const item = document.createElement('div' );
            item.className = `bulk-log-item bulk-log-${type}`;
            let icon = 'mdi-information-outline';

            if (type === 'success') {
                icon = 'mdi-check-circle-outline';
            } else if (type === 'warning' ) {
                icon ='mdi-alert-outline';
            } else if (type === 'error') {
                icon = 'mdi-alert-circle-outline';
            }

            item.innerHTML = `
                <i class="mdi ${icon} bulk-log-icon"></i>
                <div>
                    ${escapeHtml(message)}
                </div>
            `;

            container.appendChild( item );
            container.scrollTop = container.scrollHeight;

            const count = container.children.length;
            text('bulkLogCount', count);
        }

        /* RESET */
        function resetBulkUI() {

            bulkRunning = false;
            bulkStopRequested = false;
            bulkCurrentOffset = 0;
            bulkTotal = 0;
            bulkProcessed = 0;
            bulkMatched = 0;
            bulkUnmatched = 0;
            bulkFailed = 0;


            show('bulkAiConfiguration');
            hide('bulkAiProgress');
            hide('bulkAiCompleted');
            text('bulkPendingCount', '—');
            text('bulkRoleCount','—');
            text('bulkProcessedCount','0');
            text('bulkMatchedCount','0');
            text('bulkUnmatchedCount', '0');
            text('bulkFailedCount','0' );
            text('bulkProgressPercent','0%' );
            text('bulkCurrentApplicant','Preparing...' );

            const bar = document.getElementById('bulkProgressBar');
            if (bar) {
                bar.style.width = '0%';
            }

            const log = document.getElementById('bulkAiLog' );
            if (log) {
                log.innerHTML = '';
            }

            text( 'bulkLogCount','0');

            const start = document.getElementById('bulkAiStartButton');

            if (start) {
                start.disabled = false;
                start.innerHTML = `
                    <i class="mdi mdi-robot-outline me-1"></i>
                    Start AI Matching
                `;
            }


            const stop = document.getElementById('bulkAiStopButton');
            if (stop) {
                stop.disabled = false;
                stop.innerHTML = `
                    <i class="mdi mdi-stop-circle-outline me-1"></i>
                    Stop After Current Batch
                `;
            }

            const force = document.getElementById('bulkAiForceReprocess');
            if (force) {
                force.checked = false;
            }
        }

        /* SHOW PROGRESS */
        function showBulkProgress() {

            hide('bulkAiConfiguration');
            hide('bulkAiCompleted');
            show( 'bulkAiProgress');

            const start =document.getElementById('bulkAiStartButton');
            if (start) {
                start.disabled = true;
            }
        }

        /* URLS */
        function getBulkStatsUrl() {
            return '/hr-recruiter/ai/bulk-role-matching/stats';
        }

        function getBulkMatchUrl() {
            return '/hr-recruiter/ai/bulk-role-matching';
        }


        /*  CSRF */
        function getCsrfToken() {
            const meta = document.querySelector( 'meta[name="csrf-token"]');

            return meta ? meta.getAttribute('content'): '';
        }

        /* JSON */
        async function parseJsonResponse(response ) {

            const body = await response.text();

            try {
                return JSON.parse(body);
            } catch (error) {
                console.error('Invalid JSON response:', body );
                throw new Error('Server returned an invalid response.' );
            }
        }

        /* HELPERS */
        function text(id,value) {

            const element = document.getElementById(id);

            if (element) {
                element.textContent = value ?? '';
            }
        }


        function show(id) {
            const element = document.getElementById(id);
            if (element) {
                element.classList.remove( 'd-none' );
            }
        }

        function hide(id) {
            const element = document.getElementById(id);
            if (element) {
                element.classList.add('d-none');
            }
        }

        function formatNumber(value ) {
            return Number(value || 0 ).toLocaleString();
        }

        function escapeHtml(value) {

            const div =document.createElement( 'div');
            div.textContent = String( value ?? '' );

            return div.innerHTML;
        }

        function refreshApplicantTable() {

            if (typeof window.reloadApplicantTable === 'function') {

                window.reloadApplicantTable();

                return;
            }

            if (typeof window.loadApplicants ==='function' ) {

                window.loadApplicants();
            }
        }


        function showToast( message,type) {

            if (typeof window.showNotification ==='function' ) {

                window.showNotification( message,type);

                return;
            }

            if (typeof toastr !=='undefined') {

                type === 'success'
                    ? toastr.success(message)
                    : toastr.error(message);

                return;
            }

            console.log(`[${type}] ${message}`);
        }

    })();
</script>
<script>
    $('#interview_date').datepicker({
        todayHighlight: true,
        autoclose: true,
        format: 'dd-M-yyyy'
    });
    $('#selected_date').datepicker({
        todayHighlight: true,
        autoclose: true,
        format: 'dd-M-yyyy'
    });
</script>
<script>
    
(function ($) {
    'use strict';

    const roleRoutes = {
        index: @json(route('recruitment.roles.index')),
        meta: @json(route('recruitment.roles.meta')),
        store: @json(route('recruitment.roles.store')),
        edit: @json(route('recruitment.roles.edit', ['role' => '__ROLE__'])),
        update: @json(route('recruitment.roles.update', ['role' => '__ROLE__'])),
        toggle: @json(route('recruitment.roles.toggleStatus', ['role' => '__ROLE__'])),
        destroy: @json(route('recruitment.roles.destroy', ['role' => '__ROLE__']))
    };

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || @json(csrf_token());

    let currentPage = 1;
    let searchTimer = null;
    let roleRequest = null;

    const $modal = $('#manageRolesModal');
    const $formPanel = $('#roleFormPanel');
    const $form = $('#roleForm');
    const $tbody = $('#rolesTableBody');

    // $.ajaxSetup({
    //     headers: {
    //         'X-CSRF-TOKEN': csrfToken,
    //         'X-Requested-With': 'XMLHttpRequest',
    //         'Accept': 'application/json'
    //     }
    // });
    

    function url(template, id) {
        return template.replace('__ROLE__', encodeURIComponent(id));
    }

    function roleAjax(options) {
        options = options || {};

        options.headers = Object.assign({}, options.headers || {}, {
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        });

        options.timeout = options.timeout || 15000;

        return $.ajax(options);
    }

    function escapeHtml(value) {
        return $('<div>').text(value == null ? '' : String(value)).html();
    }

    function showToast(message, type) {

        const toastEl = document.getElementById('roleToast');

        if (toastEl && window.bootstrap?.Toast) {

            const $toast = $('#roleToast');

            $toast
                .removeClass(
                    'text-bg-success text-bg-danger text-bg-warning text-bg-info'
                )
                .addClass(
                    'text-bg-' + (type || 'success')
                );

            $('#roleToastBody').text(
                message || 'Done.'
            );

            bootstrap.Toast
                .getOrCreateInstance(toastEl, {
                    delay: 2800
                })
                .show();

            return;
        }

        // Use existing application toastr if available.
        if (typeof window.toastr !== 'undefined') {

            if (type === 'success') {
                toastr.success(message);
            } else if (type === 'warning') {
                toastr.warning(message);
            } else {
                toastr.error(message);
            }

            return;
        }

        console[type === 'success' ? 'log' : 'error'](
            '[Manage Roles]',
            message
        );
    }

    function showValidationErrors(xhr) {
        const errors = xhr.responseJSON?.errors || {};
        const messages = Object.values(errors).flat();
        if (messages.length) {
            showToast(messages[0], 'danger');
            return;
        }
        showToast(xhr.responseJSON?.message || 'Something went wrong. Please try again.', 'danger');
    }

    function setSaveLoading(isLoading) {
        $('#saveRoleBtn').prop('disabled', isLoading);
        $('#saveRoleBtn .save-role-label').toggleClass('d-none', isLoading);
        $('#saveRoleBtn .save-role-loading').toggleClass('d-none', !isLoading);
    }

    function resetRoleForm() {
        $form[0].reset();
        $('#roleId').val('');
        $('#roleName').val('');
        $('#roleFamily').val('');
        $('#roleDescription').val('');
        $('#seniorityLevel').val('1');
        $('#roleMatchEnabled').prop('checked', true);
        $('#roleCodeInfo').hide();
        $('#roleCodeText').text('');
        $('#roleFormTitle').text('Add New Role');
    }

    function openAddForm() {
        resetRoleForm();
        $formPanel.addClass('is-open');
        setTimeout(() => $('#roleName').trigger('focus'), 50);
    }

    function closeRoleForm() {
        $formPanel.removeClass('is-open');
        resetRoleForm();
    }

    function renderLoading() {
        $tbody.html(`
            <tr>
                <td colspan="5">
                    <div class="role-loading">
                        <div class="spinner-border spinner-border-sm text-primary mb-2"></div>
                        <div>Loading roles...</div>
                    </div>
                </td>
            </tr>
        `);
    }

    function renderEmpty() {
        $tbody.html(`
            <tr>
                <td colspan="5">
                    <div class="role-empty-state">
                        <div class="fs-2 mb-2"><span class="mdi mdi-account-remove-outline fs-2"></span></div>
                        <div class="fw-bold text-dark mb-1">No roles found</div>
                        <div class="small">Try another search/filter or create a new role.</div>
                    </div>
                </td>
            </tr>
        `);
    }

    function statusHtml(status, label) {
        const classes = {
            0: 'role-status-active',
            1: 'role-status-inactive',
            2: 'role-status-deleted'
        };
        return `<span class="role-status-badge ${classes[status] || ''}">${escapeHtml(label)}</span>`;
    }

    function actionHtml(role) {
        if (Number(role.status) === 2) {
            return `<span class="small text-muted">No actions</span>`;
        }

        const toggleTitle = Number(role.status) === 0 ? 'Deactivate role' : 'Activate role';
        const toggleIcon = Number(role.status) === 0 ? 'bi-pause-circle' : 'bi-play-circle';
        const toggleClass = Number(role.status) === 0 ? 'btn-outline-warning' : 'btn-outline-success';

        return `
            <div class="role-actions d-flex justify-content-end gap-1">
                <button type="button"
                        class="btn btn-white border btn-edit-role shadow-none border-none"
                        data-id="${escapeHtml(role.id)}"
                        title="Edit role"
                        aria-label="Edit role">
                    <i class="mdi mdi-square-edit-outline"></i>
                </button>
                <!-- <button type="button"
                        class="btn ${toggleClass} btn-toggle-role"
                        data-id="${escapeHtml(role.id)}"
                        data-status="${escapeHtml(role.status)}"
                        title="${escapeHtml(toggleTitle)}"
                        aria-label="${escapeHtml(toggleTitle)}">
                    <i class="bi ${toggleIcon}"></i>
                </button> -->
                ${auth_user_id == 0 ? 
                `<button type="button"
                        class="btn btn-outline-danger btn-delete-role shadow-none border-none"
                        data-id="${escapeHtml(role.id)}"
                        title="Delete role"
                        aria-label="Delete role">
                    <i class="mdi mdi-trash-can-outline"></i>
                </button>` : ''}
            </div>
        `;
    }

    function renderRows(response) {
        const roles = response.data || [];
        const meta = response.meta || {};

        // $('#roleShowingCount').text(meta.total ?? 0);
        $('#rolesPaginationSummary').text(
            meta.total
                ? `Showing ${meta.from}–${meta.to} of ${meta.total}`
                : 'Showing 0 of 0'
        );

        if (!roles.length) {
            renderEmpty();
            renderPagination(meta);
            return;
        }

        const start = Number(meta.from || 1);
        $tbody.html(roles.map((role, index) => `
            <tr>
                <td class="small text-muted">${start + index}</td>
                <td>
                    <div class="role-name-text">${escapeHtml(role.role_name)}</div>
                    <div class="role-code mt-1">${escapeHtml(role.role_code)}</div>
                    ${role.description ? `<div class="role-description mt-1">${escapeHtml(role.description)}</div>` : ''}
                </td>
                <td><span class="role-chip">${escapeHtml(role.role_family || '—')}</span></td>
                <td><span class="small fw-semibold">${escapeHtml(role.seniority_label)}</span></td>
                <!--<td>
                    <span class="role-match-badge ${role.match_enabled ? 'role-match-on' : 'role-match-off'}">
                        ${role.match_enabled ? 'Enabled' : 'Disabled'}
                    </span>
                </td>-->
                <!--<td>${statusHtml(Number(role.status), role.status_label)}</td> -->
                <!-- <td><span class="small text-muted">${escapeHtml(role.updated_at || '—')}</span></td> -->
                <td class="text-end">${actionHtml(role)}</td>
            </tr>
        `).join(''));

        renderPagination(meta);
    }

    function renderPagination(meta) {
        const current = Number(meta.current_page || 1);
        const last = Number(meta.last_page || 1);
        const $pagination = $('#rolesPagination');

        if (last <= 1) {
            $pagination.empty();
            return;
        }

        const items = [];
        const addItem = (page, label, disabled, active) => {
            items.push(`
                <li class="page-item ${disabled ? 'disabled' : ''} ${active ? 'active' : ''}">
                    <button type="button" class="page-link btn-role-page" data-page="${page}" ${disabled ? 'disabled' : ''}>${label}</button>
                </li>
            `);
        };

        addItem(Math.max(1, current - 1), '<span aria-hidden="true">&lsaquo;</span>', current === 1, false);

        let start = Math.max(1, current - 2);
        let end = Math.min(last, current + 2);

        if (start > 1) {
            addItem(1, '1', false, current === 1);
            if (start > 2) {
                items.push('<li class="page-item disabled"><span class="page-link">…</span></li>');
            }
        }

        for (let page = start; page <= end; page++) {
            addItem(page, String(page), false, page === current);
        }

        if (end < last) {
            if (end < last - 1) {
                items.push('<li class="page-item disabled"><span class="page-link">…</span></li>');
            }
            addItem(last, String(last), false, current === last);
        }

        addItem(Math.min(last, current + 1), '<span aria-hidden="true">&rsaquo;</span>', current === last, false);
        $pagination.html(items.join(''));
    }

    // function loadMeta() {
    //     return $.get(roleRoutes.meta)
    //         .done(function (response) {
    //             const counts = response.counts || {};
    //             // $('#roleCountActive').text(counts.active ?? 0);
    //             // $('#roleCountInactive').text(counts.inactive ?? 0);
    //             // $('#roleCountDeleted').text(counts.deleted ?? 0);

    //             const currentFamily = $('#roleFamilyFilter').val();
    //             const families = response.families || [];
    //             $('#roleFamilyFilter').html('<option value="">All families</option>');
    //             $('#roleFamilySuggestions').empty();

    //             families.forEach(function (family) {
    //                 $('#roleFamilyFilter').append(
    //                     `<option value="${escapeHtml(family)}">${escapeHtml(family)}</option>`
    //                 );
    //                 $('#roleFamilySuggestions').append(
    //                     `<option value="${escapeHtml(family)}"></option>`
    //                 );
    //             });

    //             if (families.includes(currentFamily)) {
    //                 $('#roleFamilyFilter').val(currentFamily);
    //             }
    //         });
    // }
    function loadMeta() {

        return roleAjax({
            url: roleRoutes.meta,
            type: 'GET'
        })
        .done(function (response) {

            const counts = response.counts || {};

            const families = response.families || [];

            const $familyFilter = $('#roleFamilyFilter');
            const $familySuggestions = $('#roleFamilySuggestions');

            if ($familyFilter.length) {

                const currentFamily = $familyFilter.val();

                $familyFilter.html(
                    '<option value="">All families</option>'
                );

                families.forEach(function (family) {

                    $familyFilter.append(
                        $('<option>', {
                            value: family,
                            text: family
                        })
                    );

                });

                if (families.includes(currentFamily)) {
                    $familyFilter.val(currentFamily);
                }
            }

            if ($familySuggestions.length) {

                $familySuggestions.empty();

                families.forEach(function (family) {

                    $familySuggestions.append(
                        $('<option>', {
                            value: family
                        })
                    );

                });

            }

        })
        .fail(function (xhr, textStatus, errorThrown) {

            console.error(
                '[Manage Roles] Meta request failed:',
                {
                    status: xhr.status,
                    textStatus: textStatus,
                    error: errorThrown,
                    response: xhr.responseText
                }
            );

            showValidationErrors(xhr);
        });
    }

    // function loadRoles(page) {
    //     currentPage = Number(page || 1);

    //     if (roleRequest && roleRequest.readyState !== 4) {
    //         roleRequest.abort();
    //     }

    //     renderLoading();

    //     roleRequest = $.ajax({
    //         url: roleRoutes.index,
    //         type: 'GET',
    //         data: {
    //             page: currentPage,
    //             per_page: 15,
    //             search: $.trim($('#roleSearch').val()),
    //             // family: $('#roleFamilyFilter').val(),
    //             // status: $('#roleStatusFilter').val()
    //         }
    //     })
    //     .done(function (response) {
    //         if (!response.success) {
    //             showToast(response.message || 'Unable to load roles.', 'danger');
    //             return;
    //         }

    //         if (Number(response.meta?.current_page || 1) > Number(response.meta?.last_page || 1)) {
    //             loadRoles(Number(response.meta?.last_page || 1));
    //             return;
    //         }

    //         renderRows(response);
    //     })
    //     .fail(function (xhr, textStatus) {
    //         if (textStatus === 'abort') return;
    //         showValidationErrors(xhr);
    //     });
    // }

    function loadRoles(page) {

        currentPage = Number(page || 1);

        if (roleRequest && roleRequest.readyState !== 4) {
            roleRequest.abort();
        }

        renderLoading();

        console.log(
            '[Manage Roles] Loading:',
            roleRoutes.index,
            'page:',
            currentPage
        );

        roleRequest = roleAjax({
            url: roleRoutes.index,
            type: 'GET',
            data: {
                page: currentPage,
                per_page: 25,
                search: $.trim($('#roleSearch').val())
            }
        })
        .done(function (response) {

            console.log(
                '[Manage Roles] List response:',
                response
            );

            if (!response || !response.success) {

                showToast(
                    response?.message || 'Unable to load roles.',
                    'danger'
                );

                renderEmpty();

                return;
            }

            const current = Number(
                response.meta?.current_page || 1
            );

            const last = Number(
                response.meta?.last_page || 1
            );

            if (current > last) {

                loadRoles(last);

                return;
            }

            renderRows(response);

        })
        .fail(function (xhr, textStatus, errorThrown) {

            if (textStatus === 'abort') {
                return;
            }

            console.error(
                '[Manage Roles] List request failed:',
                {
                    url: roleRoutes.index,
                    status: xhr.status,
                    textStatus: textStatus,
                    error: errorThrown,
                    response: xhr.responseText
                }
            );

            showValidationErrors(xhr);

            $tbody.html(`
                <tr>
                    <td colspan="8">
                        <div class="role-empty-state">

                            <div class="fs-2 mb-2">
                                <i class="mdi mdi-alert-circle-outline text-danger"></i>
                            </div>

                            <div class="fw-bold text-danger mb-1">
                                Unable to load roles
                            </div>

                            <div class="small text-muted mb-3">
                                Please check the server response and try again.
                            </div>

                            <button
                                type="button"
                                class="btn btn-sm btn-primary"
                                id="retryRolesBtn">

                                <i class="mdi mdi-refresh me-1"></i>
                                Retry

                            </button>

                        </div>
                    </td>
                </tr>
            `);

        });
    }

    function openEditRole(id) {
        $.get(url(roleRoutes.edit, id))
            .done(function (response) {
                const role = response.data;

                $('#roleFormTitle').text('Edit Role');
                $('#roleId').val(role.id);
                $('#roleName').val(role.role_name || '');
                $('#roleFamily').val(role.role_family || '');
                $('#seniorityLevel').val(String(role.seniority_level || 1));
                $('#roleDescription').val(role.description || '');
                $('#roleMatchEnabled').prop('checked', Boolean(role.match_enabled));
                $('#roleCodeText').text(role.role_code || '');
                $('#roleCodeInfo').show();
                $formPanel.addClass('is-open');

                setTimeout(() => $('#roleName').trigger('focus'), 50);
            })
            .fail(showValidationErrors);
    }

    function saveRole() {
        const id = $.trim($('#roleId').val());
        const data = {
            role_name: $.trim($('#roleName').val()),
            role_family: $.trim($('#roleFamily').val()) || null,
            seniority_level: $('#seniorityLevel').val(),
            description: $.trim($('#roleDescription').val()) || null,
            match_enabled: $('#roleMatchEnabled').is(':checked') ? 1 : 0
        };

        if (!data.role_name) {
            $('#roleName').trigger('focus');
            showToast('Role name is required.', 'warning');
            return;
        }

        const endpoint = id ? url(roleRoutes.update, id) : roleRoutes.store;
        setSaveLoading(true);

       roleAjax({
            url: endpoint,
            type: 'POST',
            data: data
        })
        .done(function (response) {
            showToast(response.message || 'Role saved successfully.', 'success');
            closeRoleForm();
            loadMeta().always(function () {
                loadRoles(1);
            });
        })
        .fail(showValidationErrors)
        .always(function () {
            setSaveLoading(false);
        });
    }

    function toggleRole(id, currentStatus) {
        const action = Number(currentStatus) === 0 ? 'deactivate' : 'activate';
        const roleText = Number(currentStatus) === 0
            ? 'This role will stop being used for active role selection/matching.'
            : 'This role will become active again.';

        if (!window.confirm(`Are you sure you want to ${action} this role?\n\n${roleText}`)) {
            return;
        }

        roleAjax({
            url: url(roleRoutes.toggle, id),
            type: 'POST'
        })
        .done(function (response) {
            showToast(response.message || 'Status updated.', 'success');
            loadMeta().always(function () {
                loadRoles(currentPage);
            });
        })
        .fail(showValidationErrors);
    }

    function deleteRole(id) {
        if (!window.confirm('Delete this role?\n\nThe record will be soft-deleted and retained for historical ATS data.')) {
            return;
        }

        roleAjax({
            url: url(roleRoutes.destroy, id),
            type: 'POST'
        })
        .done(function (response) {
            showToast(response.message || 'Role deleted successfully.', 'success');
            loadMeta().always(function () {
                loadRoles(currentPage);
            });
        })
        .fail(showValidationErrors);
    }

    // Modal opened.
   function openManageRoles() {

        console.log('[Manage Roles] Button clicked');

        closeRoleForm();

        loadRoles(1);
        loadMeta();
    }


    // Direct button click.
    // This does NOT depend on Bootstrap's modal event.
    $(document).on('click', '#openManageRolesBtn', function () {

        openManageRoles();

    });

    $('#addRoleBtn').on('click', openAddForm);
    $('#cancelRoleFormBtn, #cancelRoleFormBtn2').on('click', closeRoleForm);
    $form.on('submit', function (event) {
        event.preventDefault();
        saveRole();
    });

    // $('#roleFamilyFilter, #roleStatusFilter').on('change', function () {
    //     loadRoles(1);
    // });

    $(document).on('click', '#retryRolesBtn', function () {
        loadRoles(currentPage);
    });
    
    $('#roleSearch').on('input', function () {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(function () {
            loadRoles(1);
        }, 350);
    });

    $(document).on('click', '.btn-role-page', function () {
        if ($(this).prop('disabled')) return;
        loadRoles(Number($(this).data('page')));
    });

    $(document).on('click', '.btn-edit-role', function () {
        openEditRole($(this).data('id'));
    });

    $(document).on('click', '.btn-toggle-role', function () {
        toggleRole($(this).data('id'), $(this).data('status'));
    });

    $(document).on('click', '.btn-delete-role', function () {
        deleteRole($(this).data('id'));
    });
})(jQuery);
</script>

<style>
/* =====================================================================
   EGC ATS ROLE MATCHING V3 — isolated styles
   All selectors are prefixed to avoid changing existing candidate UI.
===================================================================== */
.egc-ats-modal .modal-content { border: 0; border-radius: 18px; overflow: hidden; box-shadow: 0 24px 90px rgba(15,23,42,.22); }
.egc-ats-modal-header { background: linear-gradient(180deg,#fff,#fbfcfe); border-bottom:1px solid #e9edf3; padding:18px 22px; }
.egc-ats-head-icon { width:46px;height:46px;border-radius:13px;display:flex;align-items:center;justify-content:center;background:rgba(171,43,34,.10);color:#ab2b22;font-size:24px; }
.egc-ats-access-badge { display:inline-flex;align-items:center;padding:4px 9px;border-radius:999px;font-size:10px;font-weight:800;letter-spacing:.04em;background:#fff4ed;color:#9a3412;border:1px solid #fed7aa; }
.egc-ats-bulk-body,.egc-ats-individual-body { background:#f6f8fb; padding:20px; }
.egc-ats-info-banner { display:flex;gap:12px;padding:13px 14px;background:#f7fbff;border:1px solid #dbeafe;border-radius:13px; }
.egc-ats-info-icon { width:34px;height:34px;flex:0 0 34px;border-radius:10px;display:flex;align-items:center;justify-content:center;background:#eaf3ff;color:#2563eb;font-size:18px; }
.egc-ats-stat-card { height:100%;display:flex;align-items:center;gap:12px;padding:14px;border-radius:14px;background:#fff;border:1px solid #e7ebf1;box-shadow:0 4px 14px rgba(15,23,42,.035); }
.egc-ats-stat-icon { width:40px;height:40px;display:flex;align-items:center;justify-content:center;border-radius:11px;font-size:19px; }
.egc-ats-stat-value { font-size:21px;font-weight:800;line-height:1.1;color:#111827; }
.egc-ats-stat-label { margin-top:3px;font-size:11px;color:#6b7280; }
.egc-ats-settings-card,.egc-ats-progress-shell,.egc-ats-recent-card { background:#fff;border:1px solid #e6ebf1;border-radius:15px;box-shadow:0 5px 18px rgba(15,23,42,.035); }
.egc-ats-settings-card { padding:18px; }
.egc-ats-warning { display:flex;gap:8px;align-items:flex-start;padding:10px 11px;border-radius:10px;background:#fffaf0;border:1px solid #fde68a;color:#92400e;font-size:11px; }
.egc-ats-run-topbar { padding:14px 16px;background:#fff;border:1px solid #e6ebf1;border-radius:14px;display:flex;justify-content:space-between;gap:12px;align-items:center; }
.egc-ats-live-badge { display:inline-flex;align-items:center;gap:7px;padding:5px 9px;border-radius:999px;background:#ecfdf5;color:#047857;font-size:11px;font-weight:800; }
.egc-ats-live-badge span:first-child { width:7px;height:7px;border-radius:50%;background:currentColor;animation:egcAtsPulse 1.4s infinite; }
@keyframes egcAtsPulse { 0%,100%{opacity:.35;transform:scale(.8)} 50%{opacity:1;transform:scale(1)} }
.egc-ats-progress-shell { padding:17px; }
.egc-ats-progress { height:10px;border-radius:999px;background:#e8edf3;overflow:hidden; }
.egc-ats-progress .progress-bar { border-radius:inherit;background:linear-gradient(90deg,#ab2b22,#d15447);transition:width .4s ease; }
.egc-ats-progress-percent { font-size:25px;font-weight:900;color:#0f172a; }
.egc-ats-mini-stat { background:#fff;border:1px solid #e8ecf1;border-radius:13px;padding:13px 14px; }
.egc-ats-recent-card { overflow:hidden; }
.egc-ats-recent-card .table th { font-size:10px;text-transform:uppercase;letter-spacing:.05em;color:#6b7280;background:#fafbfc;white-space:nowrap; }
.egc-ats-recent-card .table td { font-size:12px; }
.egc-ats-complete-icon { width:76px;height:76px;margin:auto;border-radius:22px;display:flex;align-items:center;justify-content:center;font-size:38px;color:#047857;background:#ecfdf5; }
.egc-ats-final-stat { padding:14px;border:1px solid #e7ebf1;background:#fff;border-radius:13px; }
.egc-ats-final-stat .value { font-size:25px;font-weight:900;color:#111827; }
.egc-ats-modal-footer { background:#fff;border-top:1px solid #e9edf3; }
.egc-ats-state { min-height:420px;display:flex;align-items:center;justify-content:center;flex-direction:column;text-align:center; }
.egc-ats-loader-ring { width:74px;height:74px;border-radius:20px;display:flex;align-items:center;justify-content:center;background:#fff;box-shadow:0 10px 30px rgba(15,23,42,.07); }
.egc-ats-loader-ring .spinner-border { width:34px;height:34px;color:#ab2b22; }
.egc-ats-state-icon { width:66px;height:66px;border-radius:18px;display:flex;align-items:center;justify-content:center;background:#fff;color:#ab2b22;box-shadow:0 10px 30px rgba(15,23,42,.06);font-size:30px; }
.egc-ats-state-icon.error { background:#fff1f2;color:#b91c1c; }
.egc-ats-candidate-hero { padding:16px;background:linear-gradient(135deg,#fff 25%,#fbfcff 100%);border:1px solid #e4eaf1;border-radius:15px; }
.egc-ats-avatar { width:58px;height:58px;flex:0 0 58px;border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:22px;font-weight:900;color:#fff;background:linear-gradient(135deg,#ab2b22,#d56256);box-shadow:0 8px 20px rgba(171,43,34,.22); }
.egc-ats-hero-score { font-size:36px;line-height:1;font-weight:950;color:#ab2b22; }
.egc-ats-chip { display:inline-flex;align-items:center;padding:5px 9px;border-radius:999px;background:#f1f5f9;color:#475569;font-size:10px;font-weight:700; }
.egc-ats-source-card { padding:15px;background:#fff;border:1px solid #e4e9ef;border-radius:15px; }
.egc-ats-source-pills { display:grid;grid-template-columns:repeat(4,1fr);gap:8px; }
.egc-ats-source-pills button { border:1px solid #e2e8f0;background:#fff;border-radius:12px;padding:10px 9px;display:flex;align-items:center;justify-content:center;gap:7px;font-size:11px;font-weight:800;color:#475569;transition:.18s; }
.egc-ats-source-pills button:hover { border-color:#b7c0cc;transform:translateY(-1px); }
.egc-ats-source-pills button.active { border-color:#ab2b22;background:#fff5f3;color:#ab2b22;box-shadow:0 6px 16px rgba(171,43,34,.10); }
.egc-ats-score-card { background:#fff;border:1px solid #e4e9ef;border-radius:14px;padding:14px; }
.egc-ats-score-card.primary { background:linear-gradient(145deg,#fff7f5,#fff);border-color:#ffd9d4; }
.egc-ats-score-card .label { font-size:11px;color:#6b7280;font-weight:700; }
.egc-ats-score-card .score { margin-top:5px;font-size:27px;font-weight:950;color:#111827; }
.egc-ats-score-card.primary .score { color:#ab2b22; }
.egc-ats-score-card .bar { height:6px;margin-top:9px;border-radius:999px;background:#edf1f5;overflow:hidden; }
.egc-ats-score-card .bar span { display:block;height:100%;border-radius:inherit;background:linear-gradient(90deg,#ab2b22,#d15447);width:0%;transition:width .35s ease; }
.egc-ats-role-list { display:grid;gap:10px; }
.egc-ats-role-card { background:#fff;border:1px solid #e3e9ef;border-radius:14px;padding:14px;transition:.18s; }
.egc-ats-role-card:hover { transform:translateY(-1px);box-shadow:0 9px 25px rgba(15,23,42,.06); }
.egc-ats-role-card .role-title { font-weight:850;color:#0f172a; }
.egc-ats-role-score { font-size:25px;font-weight:950;color:#ab2b22; }
.egc-ats-role-score.high { color:#047857; }
.egc-ats-role-meta { display:flex;flex-wrap:wrap;gap:6px;margin-top:5px; }
.egc-ats-role-meta span { font-size:9px;font-weight:800;padding:4px 7px;border-radius:999px;background:#f1f5f9;color:#475569; }
.egc-ats-component-grid { display:grid;grid-template-columns:repeat(3,1fr);gap:7px;margin-top:10px; }
.egc-ats-component { font-size:9px;color:#64748b; }
.egc-ats-component strong { float:right;color:#334155;font-size:10px; }
.egc-ats-component .line { margin-top:4px;height:4px;background:#eef2f7;border-radius:999px;overflow:hidden; }
.egc-ats-component .line span { display:block;height:100%;border-radius:inherit;background:#94a3b8; }
.egc-ats-role-facts { display:flex;flex-wrap:wrap;gap:6px;margin-top:9px; }
.egc-ats-role-facts span { display:inline-flex;align-items:center;gap:4px;padding:5px 8px;border-radius:8px;background:#f8fafc;border:1px solid #edf1f5;color:#526070;font-size:9px;font-weight:750; }
.egc-ats-role-facts i { font-size:12px;color:#64748b; }
.egc-ats-role-body { margin-top:11px;padding-top:10px;border-top:1px solid #eef2f6; }
.egc-ats-evidence-grid { display:grid;grid-template-columns:1fr 1fr;gap:10px; }
.egc-ats-evidence-box { padding:10px;border-radius:10px;background:#f8fafc; }
.egc-ats-evidence-box .heading { font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.05em;color:#64748b;margin-bottom:6px; }
.egc-ats-evidence-box ul { margin:0;padding-left:17px; }
.egc-ats-evidence-box li { font-size:11px;color:#475569;margin-bottom:4px; }
.egc-ats-insight-card,.egc-ats-list-card,.egc-ats-summary-card,.egc-ats-near-card,.egc-ats-meta-card { background:#fff;border:1px solid #e4e9ef;border-radius:14px; }
.egc-ats-insight-card,.egc-ats-list-card { padding:14px; }
.egc-ats-insight-card .title,.egc-ats-list-card .title,.egc-ats-summary-card .title { font-weight:850;color:#111827;margin-bottom:10px; }
.egc-ats-insight-card .item { display:flex;justify-content:space-between;gap:12px;padding:8px 0;border-top:1px solid #eef2f6; }
.egc-ats-insight-card .item span { color:#64748b;font-size:10px; }
.egc-ats-insight-card .item strong { color:#334155;font-size:11px;text-align:right; }
.egc-ats-tag-wrap { display:flex;flex-wrap:wrap;gap:6px; }
.egc-ats-tag { display:inline-flex;padding:5px 8px;border-radius:8px;background:#eff6ff;color:#1d4ed8;font-size:10px;font-weight:700; }
.egc-ats-bullet-list { display:grid;gap:7px; }
.egc-ats-bullet { display:flex;gap:7px;font-size:11px;color:#475569;line-height:1.45; }
.egc-ats-bullet i { color:#94a3b8;margin-top:2px; }
.egc-ats-summary-card { padding:14px; }
.egc-ats-summary-card #egcOptimizedSummary { line-height:1.7;color:#475569; }
.egc-ats-collapse-button { width:100%;display:flex;justify-content:space-between;align-items:center;border:0;background:transparent;padding:13px 14px;font-weight:800;font-size:12px;color:#334155; }
.egc-ats-near-card > #egcNearMatches { border-top:1px solid #eef2f6;padding:12px 14px; }
.egc-ats-near-item { padding:9px 0;border-bottom:1px dashed #e5e7eb; }
.egc-ats-near-item:last-child { border-bottom:0; }
.egc-ats-meta-card { padding:11px 13px;display:grid;grid-template-columns:repeat(4,1fr);gap:8px; }
.egc-ats-meta-card div { display:flex;flex-direction:column;gap:2px; }
.egc-ats-meta-card span { font-size:9px;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em; }
.egc-ats-meta-card strong { font-size:10px;color:#475569;word-break:break-word; }
.egc-ats-empty-analysis { padding:28px 15px;text-align:center;background:#fff;border:1px dashed #d5dce5;border-radius:14px; }
.egc-ats-role-card.near { opacity:.92;background:#fbfcfd; }
@media(max-width:767.98px){
    .egc-ats-source-pills{grid-template-columns:1fr 1fr;}
    .egc-ats-component-grid{grid-template-columns:1fr 1fr;}
    .egc-ats-evidence-grid{grid-template-columns:1fr;}
    .egc-ats-meta-card{grid-template-columns:1fr 1fr;}
    .egc-ats-bulk-body,.egc-ats-individual-body{padding:13px;}
}
</style>

@if($canUseAtsRoleMatching)
<script>
    (function () {
        'use strict';

        const Ats = {
            routes: {
                individualShow: @json(route('hr-recruiter.ai.ats-role-matching.individual.show', ['sno' => '__SNO__'])),
                individualMatch: @json(route('hr-recruiter.ai.ats-role-matching.individual.match', ['sno' => '__SNO__'])),
                bulkStats: @json(route('hr-recruiter.ai.ats-role-matching.bulk.stats')),
                bulkStart: @json(route('hr-recruiter.ai.ats-role-matching.bulk.start')),
                bulkStatus: @json(route('hr-recruiter.ai.ats-role-matching.bulk.status', ['run' => '__RUN__'])),
                bulkCancel: @json(route('hr-recruiter.ai.ats-role-matching.bulk.cancel', ['run' => '__RUN__']))
            },
            csrf: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || @json(csrf_token()),
            individual: { sno: null, source: 'stored', polling: null, loading: false },
            bulk: { runUuid: null, polling: null, starting: false, cancelling: false }
        };

        const individualUrl = (tpl, sno) => tpl.replace('__SNO__', encodeURIComponent(sno));
        const runUrl = (tpl, run) => tpl.replace('__RUN__', encodeURIComponent(run));
        const esc = (value) => $('<div>').text(value == null ? '' : String(value)).html();
        const arr = (value) => Array.isArray(value) ? value : [];
        const fmt = (value) => Number(value || 0).toLocaleString();

        function notify(message, type = 'error') {
            if (typeof window.toastr !== 'undefined') {
                if (type === 'success') toastr.success(message); else if (type === 'warning') toastr.warning(message); else toastr.error(message);
                return;
            }
            if (typeof window.showNotification === 'function') { window.showNotification(message, type); return; }
            console[type === 'success' ? 'log' : 'error']('[ATS]', message);
        }

        async function request(urlValue, options = {}) {
            const headers = Object.assign({
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': Ats.csrf
            }, options.headers || {});
            const response = await fetch(urlValue, Object.assign({ credentials: 'same-origin', headers }, options));
            const text = await response.text();
            let json;
            try { json = text ? JSON.parse(text) : {}; } catch (e) { throw new Error('Server returned an invalid response.'); }
            if (!response.ok || json.success === false) {
                const first = json?.errors ? Object.values(json.errors).flat()[0] : null;
                throw new Error(first || json.message || `Request failed (${response.status}).`);
            }
            return json;
        }

        function setVisible(id, visible) { const el = document.getElementById(id); if (!el) return; el.classList.toggle('d-none', !visible); }
        function text(id, value) { const el = document.getElementById(id); if (el) el.textContent = value == null ? '' : value; }
        function percent(value) { return Math.max(0, Math.min(100, Number(value || 0))); }
        function initials(name) { return String(name || 'A').trim().split(/\s+/).slice(0,2).map(v => v.charAt(0).toUpperCase()).join('') || 'A'; }
        function formatEta(seconds) {
            if (seconds == null || !isFinite(Number(seconds))) return '—';
            const s = Math.max(0, Math.round(Number(seconds)));
            if (s < 60) return `${s}s`;
            const m = Math.floor(s / 60), r = s % 60;
            if (m < 60) return `${m}m ${r}s`;
            const h = Math.floor(m / 60);
            return `${h}h ${m % 60}m`;
        }

        function resetIndividual() {
            clearInterval(Ats.individual.polling);
            Ats.individual.polling = null;
            Ats.individual.loading = false;
            setVisible('egcAtsIndividualLoading', true);
            setVisible('egcAtsIndividualError', false);
            setVisible('egcAtsIndividualContent', false);
            setVisible('egcAtsNoAnalysis', false);
            setVisible('egcAtsAnalysisResult', false);
            ['egcAtsRoleMatches','egcNearMatches','egcStrengths','egcWeaknesses','egcResumeImprovements','egcProfileDomains','egcProfilePrevious','egcMissingKeywords','egcDataQualityNotes'].forEach(id => { const el=document.getElementById(id); if(el) el.innerHTML=''; });
        }

        function setSource(source) {
            Ats.individual.source = source;
            document.querySelectorAll('#egcAtsSourcePills button').forEach(btn => btn.classList.toggle('active', btn.dataset.source === source));
            setVisible('egcAtsFieldPublicPath', source === 'public_path');
            setVisible('egcAtsFieldDrive', source === 'drive_link');
            setVisible('egcAtsFieldText', source === 'resume_text');
        }

        function renderEmptyMessage(targetId, message) {
            const el = document.getElementById(targetId);
            if (!el) return;
            el.innerHTML = `<div class="egc-ats-bullet"><i class="mdi mdi-minus-circle-outline"></i><span>${esc(message || 'Not available.')}</span></div>`;
        }

        function renderTags(targetId, values) {
            const el = document.getElementById(targetId); if (!el) return;
            const items = arr(values);
            if (!items.length) { el.innerHTML = '<span class="text-muted small">None identified</span>'; return; }
            el.innerHTML = items.map(v => `<span class="egc-ats-tag">${esc(v)}</span>`).join('');
        }

        function renderBullets(targetId, values, empty = 'None identified.') {
            const el = document.getElementById(targetId); if (!el) return;
            const items = arr(values);
            if (!items.length) { renderEmptyMessage(targetId, empty); return; }
            el.innerHTML = items.map(v => `<div class="egc-ats-bullet"><i class="mdi mdi-check-circle-outline"></i><span>${esc(v)}</span></div>`).join('');
        }

        function renderScore(id, barId, value) {
            const score = percent(value);
            text(id, `${score.toFixed(0)}%`);
            const bar = document.getElementById(barId); if (bar) bar.style.width = `${score}%`;
        }

        function renderRoleCard(match, near = false) {
            const score = percent(match.match_score);
            const cls = score >= 85 ? 'high' : '';
            const components = [
                ['Semantic', match.semantic_fit_score],
                ['Title', match.title_alignment_score],
                ['Skills', match.skill_alignment_score],
                ['Experience', match.experience_alignment_score],
                ['Responsibilities', match.responsibility_alignment_score],
                ['Education', match.education_alignment_score],
                ['Seniority', match.seniority_alignment_score],
                ['Evidence', match.evidence_quality_score]
            ];
            const componentHtml = components.map(([label, value]) => `<div class="egc-ats-component"><span>${esc(label)}</span><strong>${percent(value).toFixed(0)}%</strong><div class="line"><span style="width:${percent(value)}%"></span></div></div>`).join('');
            const requirementHtml = `
                <div class="egc-ats-role-facts">
                    <span><i class="mdi mdi-star-check-outline"></i> Mandatory skills ${percent(match.mandatory_skill_coverage).toFixed(0)}%</span>
                    <span><i class="mdi mdi-school-outline"></i> Education ${percent(match.education_requirement_coverage).toFixed(0)}%</span>
                    <span><i class="mdi mdi-briefcase-clock-outline"></i> Experience ${Number(match.candidate_experience_years || 0).toFixed(1)} / ${Number(match.required_experience_years || 0).toFixed(1)} yrs</span>
                    <span><i class="mdi mdi-shield-check-outline"></i> Confidence ${percent(match.confidence_score).toFixed(0)}%</span>
                </div>`;
            const evidence = arr(match.evidence);
            const gaps = arr(match.gaps);
            return `
                <div class="egc-ats-role-card ${near ? 'near' : ''}">
                    <div class="d-flex justify-content-between gap-3 align-items-start">
                        <div class="min-w-0">
                            <div class="d-flex align-items-center gap-2 flex-wrap"><span class="role-title">${esc(match.role_name || 'Role')}</span><span class="badge bg-light-secondary">${esc(match.role_code || '—')}</span>${near ? '<span class="badge bg-light-warning text-warning">Near match</span>' : ''}</div>
                            <div class="role-meta"></div>
                            <div class="egc-ats-role-meta"><span>${esc(match.role_family || 'Unclassified')}</span><span>${esc(match.seniority_level ? ['','Entry','Senior','Team Lead','Manager','Head'][Number(match.seniority_level)] || match.seniority_level : 'Entry')}</span><span>Role ID ${esc(match.role_id)}</span></div>
                        </div>
                        <div class="text-end"><div class="egc-ats-role-score ${cls}">${score.toFixed(0)}%</div><div class="small text-muted">match score</div></div>
                    </div>
                    <div class="egc-ats-component-grid">${componentHtml}</div>
                    ${requirementHtml}
                    <div class="egc-ats-role-body">
                        <div class="small text-muted mb-2"><strong class="text-dark">Why this role:</strong> ${esc(match.reason || 'Evidence-based role alignment identified from the resume.')}</div>
                        <div class="egc-ats-evidence-grid">
                            <div class="egc-ats-evidence-box"><div class="heading">Resume evidence</div>${evidence.length ? `<ul>${evidence.slice(0,6).map(v=>`<li>${esc(v)}</li>`).join('')}</ul>` : '<div class="small text-muted">No explicit evidence returned.</div>'}</div>
                            <div class="egc-ats-evidence-box"><div class="heading">Gaps / risks</div>${gaps.length ? `<ul>${gaps.slice(0,6).map(v=>`<li>${esc(v)}</li>`).join('')}</ul>` : '<div class="small text-muted">No material gaps returned.</div>'}</div>
                        </div>
                    </div>
                </div>`;
        }

        function renderIndividual(data) {
            const candidate = data.applicant || {};
            const analysis = data.analysis || {};
            const a = analysis.analysis || {};
            text('egcAtsCandidateName', candidate.name || 'Candidate');
            text('egcAtsCandidateMeta', [candidate.applicant_id, candidate.email, candidate.mobile].filter(Boolean).join(' • ') || `Candidate #${candidate.sno || '—'}`);
            text('egcAtsAvatar', initials(candidate.name));
            text('egcAtsSourceLabel', data.source?.label || 'Candidate resume');
            text('egcAtsResumeChars', fmt(data.source?.resume_chars || 0));
            text('egcAtsAnalysisId', `#${data.analysis_sno || '—'}`);
            text('egcAtsBestScore', `${percent(data.best_role_score).toFixed(0)}%`);
            text('egcAtsMatchLabel', Number(data.match_count || 0) ? `${data.match_count} accepted role${Number(data.match_count) === 1 ? '' : 's'}` : 'No accepted role');
            setVisible('egcAtsCandidateState', true);
            setVisible('egcAtsStaleBadge', data.is_current === false);
            renderScore('egcScoreOverall','egcScoreOverallBar',data.best_role_score);
            renderScore('egcScoreResume','egcScoreResumeBar',a.resume_quality_score);
            renderScore('egcScoreSkills','egcScoreSkillsBar',a.skills_alignment_score);
            renderScore('egcScoreExperience','egcScoreExperienceBar',a.experience_relevance_score);
            text('egcScoreKeywords', `${percent(a.ats_keyword_match_score).toFixed(0)}%`);
            text('egcScoreImpact', `${percent(a.impact_metrics_score).toFixed(0)}%`);
            text('egcScoreResponsibility', `${percent(a.role_responsibility_match_score).toFixed(0)}%`);
            text('egcAcceptedRoles', fmt(data.matches?.length || 0));
            text('egcNearRoles', fmt(data.near_matches?.length || 0));
            text('egcProfileDesignation', a.current_designation || 'Not identified');
            text('egcProfileExperience', a.experience_summary || 'Not identified');
            text('egcProfileSeniority', a.seniority_assessment || 'Not identified');
            text('egcProfileEducation', a.education_summary || 'Not identified');
            renderTags('egcProfilePrevious', a.previous_designations);
            renderTags('egcProfileDomains', a.professional_domains);
            text('egcCandidateSummary', a.candidate_summary || 'No candidate summary returned.');
            renderBullets('egcStrengths', a.strengths, 'No major strengths were identified.');
            renderBullets('egcWeaknesses', a.weaknesses, 'No major weaknesses were identified.');
            renderTags('egcMissingKeywords', a.missing_keywords);
            renderBullets('egcResumeImprovements', a.resume_improvements, 'No additional improvements returned.');
            renderBullets('egcDataQualityNotes', a.data_quality_notes, 'No data-quality concerns returned.');
            text('egcOptimizedSummary', a.optimized_summary || 'No optimized summary returned.');
            text('egcMetaEngine', data.meta?.engine || '—');
            text('egcMetaModel', data.meta?.model || '—');
            text('egcMetaSchema', data.meta?.schema_version || '—');
            text('egcMetaRoleCatalogSize', fmt(data.meta?.role_catalog_size || 0));
            text('egcMetaRetrievedRoleCount', fmt(data.meta?.retrieved_role_count || 0));
            text('egcMetaCandidateConfidence', data.meta?.candidate_data_confidence != null ? `${percent(data.meta.candidate_data_confidence).toFixed(0)}%` : '—');
            text('egcMetaReview', data.meta?.candidate_data_review_required ? 'Manual review' : 'Validated');
            text('egcMetaProcessed', data.meta?.processed_at ? new Date(data.meta.processed_at).toLocaleString() : '—');

            const matchesEl = document.getElementById('egcAtsRoleMatches');
            const matches = arr(data.matches);
            matchesEl.innerHTML = matches.length ? matches.map(m => renderRoleCard(m,false)).join('') : `<div class="egc-ats-empty-analysis"><div class="small text-muted">No supplied company role reached the configured acceptance threshold. The resume was still analysed successfully.</div></div>`;

            const nearEl = document.getElementById('egcNearMatches');
            nearEl.innerHTML = arr(data.near_matches).length ? arr(data.near_matches).map(m=>renderRoleCard(m,true)).join('') : '<div class="small text-muted">No meaningful near matches were identified.</div>';
            text('egcAtsMatchCountBadge', `${matches.length} role${matches.length === 1 ? '' : 's'}`);
            setVisible('egcAtsIndividualLoading', false);
            setVisible('egcAtsIndividualError', false);
            setVisible('egcAtsIndividualContent', true);
            setVisible('egcAtsNoAnalysis', false);
            setVisible('egcAtsAnalysisResult', true);
        }

        async function loadIndividual(sno) {
            try {
                const result = await request(individualUrl(Ats.routes.individualShow, sno));
                if (!result.data?.analysis) {
                    const candidate = result.data?.applicant || {};
                    text('egcAtsCandidateName', candidate.name || 'Candidate');
                    text('egcAtsCandidateMeta', [candidate.applicant_id, candidate.email, candidate.mobile].filter(Boolean).join(' • '));
                    text('egcAtsAvatar', initials(candidate.name));
                    setVisible('egcAtsCandidateState', true);
                    setVisible('egcAtsIndividualLoading', false);
                    setVisible('egcAtsIndividualError', false);
                    setVisible('egcAtsIndividualContent', true);
                    setVisible('egcAtsNoAnalysis', true);
                    setVisible('egcAtsAnalysisResult', false);
                    text('egcAtsFooterHint','No current ATS analysis is saved for this candidate.');
                    return;
                }
                renderIndividual(result.data.analysis);
                text('egcAtsFooterHint', result.data.analysis.is_current === false ? 'Role catalogue changed since this result was generated. Re-analyse to refresh role matching.' : 'ATS result is stored separately from legacy candidate AI data.');
            } catch (error) {
                setVisible('egcAtsIndividualLoading', false);
                setVisible('egcAtsIndividualContent', false);
                setVisible('egcAtsIndividualError', true);
                text('egcAtsIndividualErrorText', error.message);
            }
        }

        function collectSourcePayload() {
            const source = Ats.individual.source;
            return {
                source_type: source,
                public_path: $('#egcAtsPublicPath').val()?.trim() || null,
                drive_link: $('#egcAtsDriveLink').val()?.trim() || null,
                resume_text: $('#egcAtsResumeText').val() || null,
                save_resume_text: $('#egcAtsSaveResume').is(':checked') ? 1 : 0
            };
        }

        async function analyseIndividual() {
            if (!Ats.individual.sno || Ats.individual.loading) return;
            Ats.individual.loading = true;
            setVisible('egcAtsIndividualError', false);
            setVisible('egcAtsNoAnalysis', false);
            setVisible('egcAtsAnalysisResult', false);
            setVisible('egcAtsIndividualLoading', true);
            try {
                const result = await request(individualUrl(Ats.routes.individualMatch, Ats.individual.sno), {
                    method:'POST', 
                    headers:{
                        'Content-Type':'application/json',
                        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                    }, body:JSON.stringify(collectSourcePayload())
                });
                renderIndividual(result.data);
                notify(result.message || 'ATS analysis completed.','success');
            } catch (error) {
                setVisible('egcAtsIndividualLoading', false);
                setVisible('egcAtsIndividualError', true);
                text('egcAtsIndividualErrorText', error.message);
            } finally { Ats.individual.loading = false; }
        }

        window.openAiRoleMatchModal = async function (sno) {
            Ats.individual.sno = Number(sno);
            Ats.individual.source = 'stored';
            $('#egcAtsSaveResume').prop('checked', false);
            $('#egcAtsPublicPath').val(''); $('#egcAtsDriveLink').val(''); $('#egcAtsResumeText').val(''); $('#egcAtsTextCount').text('0 / 30000');
            setSource('stored');
            resetIndividual();
            const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('kt_modal_ai_analyses_individual'));
            modal.show();
            await loadIndividual(Ats.individual.sno);
        };

        $('#egcAtsSourcePills button').on('click', function(){ setSource(this.dataset.source); });
        $('#egcAtsResumeText').on('input', function(){ text('egcAtsTextCount', `${this.value.length} / 30000`); });
        $('#egcAtsAnalyseBtn,#egcAtsReanalyseBtn').on('click', analyseIndividual);
        $('#egcAtsRetryBtn').on('click', function(){ if(Ats.individual.sno){ resetIndividual(); loadIndividual(Ats.individual.sno); } });
        $('#egcNearMatchesToggle').on('click', function(){ const open=$(this).attr('aria-expanded')==='true'; $(this).attr('aria-expanded',String(!open)); $('#egcNearMatches').toggleClass('d-none',open); $(this).find('.mdi-chevron-down').toggleClass('mdi-rotate-180',!open); });
        $('#egcCopySummaryBtn').on('click', async function(){ const value=$('#egcOptimizedSummary').text().trim(); if(!value) return; try{ await navigator.clipboard.writeText(value); notify('Optimized summary copied.','success'); }catch(e){ notify('Unable to copy summary.','error'); } });

        function resetBulk() {
            clearInterval(Ats.bulk.polling); Ats.bulk.polling=null; Ats.bulk.runUuid=null; Ats.bulk.starting=false; Ats.bulk.cancelling=false;
            setVisible('egcAtsBulkSetup', true); setVisible('egcAtsBulkProgress', false); setVisible('egcAtsBulkComplete', false);
            $('#egcBulkStartBtn').prop('disabled',false); $('#egcBulkCancelBtn').addClass('d-none'); $('#egcBulkCloseBtn').prop('disabled',false);
            text('egcBulkRunId','—'); text('egcBulkRunStatus','Queued'); text('egcBulkHeartbeat','Waiting for workers...');
            $('#egcBulkProgressBar').css('width','0%'); text('egcBulkPercent','0%'); text('egcBulkProcessed','0'); text('egcBulkMatched','0'); text('egcBulkUnmatched','0'); text('egcBulkFailed','0'); text('egcBulkRate','—'); text('egcBulkEta','—'); text('egcBulkCursor','0'); text('egcBulkWorkersLive','0 workers');
            $('#egcBulkRecentItems').html('<tr><td colspan="5" class="text-center py-4 text-muted">Waiting for first result...</td></tr>');
        }

        async function loadBulkStats() {
            try {
                const result = await request(Ats.routes.bulkStats);
                const d=result.data||{};
                text('egcBulkTotal',fmt(d.total_candidates)); text('egcBulkPending',fmt(d.pending_count)); text('egcBulkRoles',fmt(d.active_role_count));
                text('egcBulkThroughput',`${d.recommended_batch_size || 2}`); text('egcBulkQueueName', 'ats-role-matching');

                if (d.active_run && d.active_run.run_uuid) {
                    Ats.bulk.runUuid = d.active_run.run_uuid;
                    setVisible('egcAtsBulkSetup', false);
                    setVisible('egcAtsBulkProgress', true);
                    setVisible('egcAtsBulkComplete', false);
                    $('#egcBulkStartBtn').addClass('d-none');
                    $('#egcBulkCancelBtn').removeClass('d-none');
                    applyBulkStatus(d.active_run);
                    clearInterval(Ats.bulk.polling);
                    Ats.bulk.polling=setInterval(pollBulk,2000);
                }
                const input=document.getElementById('egcBulkLimit'); if(input){ input.max=d.max_bulk_limit||50000; const pending=Number(d.pending_count||0); input.value=Math.min(Math.max(1,pending),100); if(pending>0) input.value=Math.min(100,pending); }
            } catch(e) { notify(e.message,'error'); text('egcBulkPending','—'); text('egcBulkRoles','—'); }
        }

        function renderBulkRecent(items) {
            const tbody=$('#egcBulkRecentItems');
            if(!items || !items.length){ tbody.html('<tr><td colspan="5" class="text-center py-4 text-muted">Waiting for first result...</td></tr>'); return; }
            tbody.html(items.map(item=>{
                const status=item.status; const badge=status==='matched'?'bg-light-success text-success':status==='unmatched'?'bg-light-warning text-warning':status==='failed'?'bg-light-danger text-danger':'bg-light-secondary text-secondary';
                return `<tr><td><div class="fw-semibold">${esc(item.applicant_name)}</div><div class="small text-muted">#${esc(item.applicant_sno)}</div></td><td><span class="badge ${badge}">${esc(status)}</span></td><td>${fmt(item.match_count)}</td><td>${item.best_match_score ? `${Number(item.best_match_score).toFixed(0)}%` : '—'}</td><td class="text-danger small">${esc(item.error_message || '')}</td></tr>`;
            }).join(''));
        }

        function applyBulkStatus(d) {
            const statusLabel=d.status==='completed'?'Completed':d.status==='cancelled'?'Stopped':'Running';
            text('egcBulkRunStatus',statusLabel); text('egcBulkHeartbeat',d.last_heartbeat_at?new Date(d.last_heartbeat_at).toLocaleTimeString():'—'); text('egcBulkPercent',`${d.percent||0}%`); $('#egcBulkProgressBar').css('width',`${d.percent||0}%`); text('egcBulkProcessed',fmt(d.processed_count)); text('egcBulkMatched',fmt(d.matched_count)); text('egcBulkUnmatched',fmt(d.unmatched_count)); text('egcBulkFailed',fmt(d.failed_count)); text('egcBulkRate',d.throughput_per_minute?Number(d.throughput_per_minute).toFixed(1):'—'); text('egcBulkEta',formatEta(d.eta_seconds)); text('egcBulkCursor',fmt(d.cursor_sno)); text('egcBulkWorkersLive',`${d.active_workers||0} worker${Number(d.active_workers)===1?'':'s'}`); text('egcBulkProgressText',`${fmt(d.processed_count)} of ${fmt(d.target_count)} processed • ${fmt(d.queued_count)} queued`); renderBulkRecent(d.recent_items||[]);
            if(d.status==='running'){ setVisible('egcAtsBulkProgress',true); $('#egcBulkCancelBtn').removeClass('d-none'); $('#egcBulkStartBtn').addClass('d-none'); }
            else { clearInterval(Ats.bulk.polling); Ats.bulk.polling=null; setVisible('egcAtsBulkProgress',true); $('#egcBulkCancelBtn').addClass('d-none'); $('#egcBulkStartBtn').addClass('d-none'); setVisible('egcAtsBulkComplete',true); text('egcBulkCompleteTitle',d.status==='cancelled'?'ATS bulk run stopped':'Bulk ATS run completed'); text('egcBulkCompleteText',d.status==='cancelled'?'No new candidates will be claimed after the stop request.':'All queued candidates have been processed.'); text('egcBulkFinalProcessed',fmt(d.processed_count)); text('egcBulkFinalMatched',fmt(d.matched_count)); text('egcBulkFinalUnmatched',fmt(d.unmatched_count)); text('egcBulkFinalFailed',fmt(d.failed_count)); refreshApplicantTable(); }
        }

        async function pollBulk() {
            if(!Ats.bulk.runUuid) return;
            try { const result=await request(runUrl(Ats.routes.bulkStatus,Ats.bulk.runUuid)); applyBulkStatus(result.data||{}); } catch(e){ console.error('[ATS bulk poll]',e); }
        }

        window.openBulkAiMatchingModal = async function(){
            resetBulk();
            const modal=bootstrap.Modal.getOrCreateInstance(document.getElementById('kt_modal_bulk_ai_matching')); modal.show();
            await loadBulkStats();
        };

        $('#egcBulkStartBtn').on('click', async function(){
            if(Ats.bulk.starting) return;
            const limit=Math.max(1,parseInt($('#egcBulkLimit').val()||'100',10));
            const batch=Math.max(1,parseInt($('#egcBulkBatchSize').val()||'2',10));
            const workers=Math.max(1,parseInt($('#egcBulkWorkers').val()||'3',10));
            const force=$('#egcBulkForce').is(':checked');
            if(force && !window.confirm('Force reprocess will analyse candidates that already have ATS results. Continue?')) return;
            Ats.bulk.starting=true; $(this).prop('disabled',true);
            try{
                const result=
                await request(Ats.routes.bulkStart,
                    {
                        method:'POST',
                        headers:{
                            'Content-Type':'application/json',
                            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                        },
                        body:JSON.stringify({limit,batch_size:batch,workers,force_reprocess:force?1:0})
                    });
                Ats.bulk.runUuid=result.data.run_uuid; setVisible('egcAtsBulkSetup',false); setVisible('egcAtsBulkComplete',false); setVisible('egcAtsBulkProgress',true); text('egcBulkRunId',Ats.bulk.runUuid); $('#egcBulkCancelBtn').removeClass('d-none'); $('#egcBulkStartBtn').addClass('d-none');
                notify(result.message||'ATS bulk queue started.','success'); await pollBulk(); Ats.bulk.polling=setInterval(pollBulk,2000);
            }catch(e){ notify(e.message,'error'); $('#egcBulkStartBtn').prop('disabled',false); } finally { Ats.bulk.starting=false; }
        });

        $('#egcBulkCancelBtn').on('click', async function(){
            if(!Ats.bulk.runUuid || Ats.bulk.cancelling) return;
            if(!window.confirm('Stop claiming new candidates after the current AI batch finishes?')) return;
            Ats.bulk.cancelling=true; $(this).prop('disabled',true).html('<span class="spinner-border spinner-border-sm me-1"></span>Stopping...');
            try{ 
                const result=
                await request(
                    runUrl(Ats.routes.bulkCancel,Ats.bulk.runUuid),
                    {
                        method:'POST'
                    }
                ); applyBulkStatus(result.data||{}); notify(result.message||'Stop requested.','success'); }catch(e){ notify(e.message,'error'); }finally{ Ats.bulk.cancelling=false; $(this).prop('disabled',false).html('<i class="mdi mdi-stop-circle-outline me-1"></i> Stop after current batch'); }
        });

        document.getElementById('kt_modal_bulk_ai_matching')?.addEventListener('hidden.bs.modal', function(){ if(Ats.bulk.polling){clearInterval(Ats.bulk.polling);Ats.bulk.polling=null;} });
        document.getElementById('kt_modal_ai_analyses_individual')?.addEventListener('hidden.bs.modal', function(){ if(Ats.individual.polling){clearInterval(Ats.individual.polling);Ats.individual.polling=null;} });
    })();
</script>
@endif
@endsection
