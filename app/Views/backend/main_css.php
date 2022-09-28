<style>
  .table thead,
  .table tfoot,
  .table th {
    text-align: center;
  }

  /* table.dataTable td button,
  table.dataTable td .btn {
    color: #fff;
  } */

  body {
    font-family: 'Prompt', sans-serif;
  }

  .nk-sidebar .metismenu>li:hover i,
  .nk-sidebar .metismenu>li:focus i,
  .nk-sidebar .metismenu>li.active i {
    color: #6993ff;
  }

  .gradient-4,
  .nk-sidebar .metismenu>li:hover span,
  .nk-sidebar .metismenu>li:focus span,
  .nk-sidebar .metismenu>li.active span,
  .sidebar-right .nav-tabs .nav-item .nav-link.active::after,
  .sidebar-right .nav-tabs .nav-item .nav-link.active span i::before,
  .header-right .dropdown-mega-menu ul a:hover,
  .header-right .dropdown-language ul li:hover a {
    background: #ffffff;
    background: -moz-linear-gradient(left, #f25521 0%, #f9c70a 100%);
    /* background: -webkit-linear-gradient(left, #f25521 0%, #f9c70a 100%); */
    /* background: linear-gradient(to right, #f25521 0%, #f9c70a 100%); */
    filter: progid: DXImageTransform.Microsoft.gradient(startColorstr='#f25521', endColorstr='#f9c70a', GradientType=1);
  }

  .card {
    /* border-radius: 0.25rem;  */
    border-radius: 1rem;
  }

  .card-header:first-child {
    border-radius: calc(1rem - 1px) calc(0.25rem - 1px) 0 0;
  }

  /* Tab Content */
  .tabs {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
  }

  .content.active {
    padding: 2rem;
    display: block;
  }

  .content {
    display: none;
  }

  .btn_nev {
    padding: 0.75rem 1.25rem;
    font-size: 1.2rem;
    cursor: pointer;
    border: none;
    color: #9b9b9b;
  }

  .btn_nev:hover {
    background-color: #ddd;
  }

  .btn_nev:focus {
    outline: 0;
  }

  .btn_nev.active {
    /* background-color: lightgreen; */
    border-bottom: 5px solid #6993ff;
    color: #6993ff;
  }

  .badge {
    padding: 0.4em 0.4em;
  }

  .nk-sidebar .metismenu>li.active ul a {
    color: #fff;
    font-size: 14px;
  }

  .badge-warning {
    color: #000000;
    background-color: #ffc107;
    font-size: 0.855rem;
  }

  .form-control:focus {
    border: 1px solid #34495e;
  }

  .select2.select2-container {
    width: 100% !important;
  }

  .select2.select2-container .select2-selection {
    border: 1px solid #ccc;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
    height: 34px;
    margin-bottom: 15px;
    outline: none !important;
    transition: all .15s ease-in-out;
  }

  .select2.select2-container .select2-selection .select2-selection__rendered {
    color: #333;
    line-height: 32px;
    padding-right: 33px;
  }

  .select2.select2-container .select2-selection .select2-selection__arrow {
    background: #f8f8f8;
    border-left: 1px solid #ccc;
    -webkit-border-radius: 0 3px 3px 0;
    -moz-border-radius: 0 3px 3px 0;
    border-radius: 0 3px 3px 0;
    height: 32px;
    width: 33px;
  }

  .select2.select2-container.select2-container--open .select2-selection.select2-selection--single {
    background: #f8f8f8;
  }

  .select2.select2-container.select2-container--open .select2-selection.select2-selection--single .select2-selection__arrow {
    -webkit-border-radius: 0 3px 0 0;
    -moz-border-radius: 0 3px 0 0;
    border-radius: 0 3px 0 0;
  }

  .select2.select2-container.select2-container--open .select2-selection.select2-selection--multiple {
    border: 1px solid #34495e;
  }

  .select2.select2-container .select2-selection--multiple {
    height: auto;
    min-height: 34px;
  }

  .select2.select2-container .select2-selection--multiple .select2-search--inline .select2-search__field {
    margin-top: 0;
    height: 32px;
  }

  .select2.select2-container .select2-selection--multiple .select2-selection__rendered {
    display: block;
    padding: 0 4px;
    line-height: 29px;
  }

  .select2.select2-container .select2-selection--multiple .select2-selection__choice {
    /* background-color: #f8f8f8; */
    /* border: 1px solid #ccc; */
    /* -webkit-border-radius: 3px; */
    /* -moz-border-radius: 3px; */
    /* border-radius: 3px; */
    /* margin: 4px 4px 0 0; */
    padding: 0 6px 0 22px;
    /* height: 24px; */
    /* line-height: 24px; */
    /* font-size: 12px; */
    /* position: relative; */
  }

  .select2.select2-container .select2-selection--multiple .select2-selection__choice .select2-selection__choice__remove {
    position: absolute;
    top: 0;
    left: 0;
    /* height: 30px; */
    /* width: 22px; */
    margin: 0;
    text-align: center;
    color: #e74c3c;
    font-weight: 100;
    font-size: 40px;
  }

  .select2-container .select2-dropdown {
    background: transparent;
    border: none;
    /* margin-top: -5px; */
  }

  /* .select2-container .select2-dropdown .select2-search {
    padding: 0;
  } */

  .select2-container .select2-dropdown .select2-search input {
    outline: none !important;
    border: 1px solid #34495e !important;
    border-bottom: none !important;
    /* padding: 4px 6px !important; */
  }

  .select2-container .select2-dropdown .select2-results {
    padding: 0;
  }

  .select2-container .select2-dropdown .select2-results ul {
    background: #fff;
    border: 1px solid #34495e;
  }

  .select2-container .select2-dropdown .select2-results ul .select2-results__option--highlighted[aria-selected] {
    background-color: #52BAFF;
  }
</style>