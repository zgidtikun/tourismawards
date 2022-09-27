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

  
  /* Bootstrap Tagsinput */
  .select2-selection__choice__display {
    margin-right: 2px;
    color: white !important;
    background-color: #0d6efd;
    padding: 0.2rem;
  }

  .select2 {
    height: auto;
    /* min-height: 110px; */
    display: block;
    width: 100%;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
  }

  .select2-dropdown.select2-dropdown--below{
    width: 148px !important;
}

.select2-container--default .select2-selection--single{
    padding:6px;
    height: 37px;
    width: 148px; 
    font-size: 1.2em;  
    position: relative;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    background-image: -khtml-gradient(linear, left top, left bottom, from(#424242), to(#030303));
    background-image: -moz-linear-gradient(top, #424242, #030303);
    background-image: -ms-linear-gradient(top, #424242, #030303);
    background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #424242), color-stop(100%, #030303));
    background-image: -webkit-linear-gradient(top, #424242, #030303);
    background-image: -o-linear-gradient(top, #424242, #030303);
    background-image: linear-gradient(#424242, #030303);
    width: 40px;
    color: #fff;
    font-size: 1.3em;
    padding: 4px 12px;
    height: 27px;
    position: absolute;
    top: 0px;
    right: 0px;
    width: 20px;
}
</style>