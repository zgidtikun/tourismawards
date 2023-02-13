<style>
  #main_datatable_length {
    display: none;
  }

  .note-btn {
    min-width: unset !important;
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
    margin: 0;
    border-bottom: 3px solid transparent;
    border-radius: 0;
    position: relative;
    min-width: initial;
    line-height: 20px;
    display: flex;
    padding: 0 20px 15px 10px;
    margin: 0 5px;
    position: relative;
    scroll-snap-align: start;
    flex: none;
    color: #222;
    align-content: flex-start;
    width: auto;
    text-align: center;
  }

  .btn_nev:hover {
    background-color: #ddd;
  }

  .btn_nev:focus {
    outline: 0;
  }

  .btn_nev.active {
    color: #152a54;
    border-bottom: 3px solid #152a54;
  }

  .inpcomment {
    color: #CCC;
    font-size: 16px;
  }

  .selectaddress {
    display: flex;
    margin: 0 -10px;
  }

  .hide-address {
    display: flex;
    flex-wrap: wrap;
  }

  .selectaddresscol {
    padding: 0 10px;
  }

  .pointer {
    cursor: pointer;
  }

  .row {
    height: unset;
  }

  button.swal2-close {
    min-width: 60px !important;
  }

  /* table.dataTable.display tbody td img {
    position: unset;
  } */

  input:invalid,
  textarea:invalid {
    background-color: #FFFFFF;
  }

  .modal-header .btn-close {
    width: auto !important;
    min-width: 10px !important;
    padding: calc(var(--bs-modal-header-padding-y) * 0.5) calc(var(--bs-modal-header-padding-x) * 0.5);
    margin: calc(-0.5 * var(--bs-modal-header-padding-y)) calc(-0.5 * var(--bs-modal-header-padding-x)) calc(-0.5 * var(--bs-modal-header-padding-y)) auto;
  }

  .btn-close {
    box-sizing: content-box;
    width: 1em;
    height: 1em;
    padding: 0.25em 0.25em;
    color: #000;
    background: transparent url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23000'%3e%3cpath d='M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z'/%3e%3c/svg%3e") center/1em auto no-repeat;
    border: 0;
    border-radius: 0.25rem;
    opacity: 0.5;
  }

  .note-modal-content .close {
    width: auto !important;
    min-width: 10px !important;
    padding: calc(var(--bs-modal-header-padding-y) * 0.5) calc(var(--bs-modal-header-padding-x) * 0.5);
    margin: calc(-0.5 * var(--bs-modal-header-padding-y)) calc(-0.5 * var(--bs-modal-header-padding-x)) calc(-0.5 * var(--bs-modal-header-padding-y)) auto;
    background: transparent url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23000'%3e%3cpath d='M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z'/%3e%3c/svg%3e") center/1em auto no-repeat;
  }

  .ablum-img:hover,
  .ablum-img:focus {
    border: 5px solid #86b7fe;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
  }

  .note-image-btn {
    margin-top: -23px;
  }

  /* คำถาม */
  .regis-form-data-col1 ol {
    padding-left: 25px;
    font-size: 18px;
    font-weight: normal;
    color: #c6923a;
  }

  .regis-form-data-col1 div#qRemark ol {
    margin-top: 0;
    padding-left: 40px;
    color: #000;
  }

  .regis-form-data-col1 h4#question_name_1 ol {
    /* margin-top: 0.5rem; */
    padding: 0;
    padding-left: 40px;
    color: #000;
  }

  .regis-form-data-col1 h4#question_name_2 ol {
    /* margin-top: 0.5rem; */
    padding: 0;
    padding-left: 40px;
    color: #000;
  }

  .regis-form-data-col1 h4#question_name_3 ol {
    /* margin-top: 0.5rem; */
    padding: 0;
    padding-left: 40px;
    color: #000;
  }

  .regis-form-data-col1 h4 {
    margin-bottom: 1rem;
  }

  .download_pdf {
    border-left: 1px solid #ccc;
    padding: 0 10px;
  }

  .attachinp .card.card-body .col-12 .fs-file-name {
    padding-right: 20px;
    flex: auto;
  }

  /* ---------------tooltip----------------- */
  .tooltip_c .top {
    min-width: 350px;
    top: -20px;
    left: 50%;
    transform: translate(-50%, -100%);
    padding: 10px 20px;
    color: #444444;
    background-color: #EEEEEE;
    font-weight: normal;
    font-size: 13px;
    border-radius: 8px;
    position: absolute;
    z-index: 99999999;
    box-sizing: border-box;
    box-shadow: 0 1px 8px rgba(0, 0, 0, 0.5);
    visibility: hidden;
    opacity: 0;
    transition: opacity 0.8s;
    text-align: left;
  }

  .tooltip_c:hover .top {
    visibility: visible;
    opacity: 1;
  }

  .tooltip_c .top i {
    position: absolute;
    top: 100%;
    left: 50%;
    margin-left: -12px;
    width: 24px;
    height: 12px;
    overflow: hidden;
  }

  .tooltip_c .top p {
    margin-bottom: 0;
  }

  .tooltip_c .top i::after {
    content: '';
    position: absolute;
    width: 12px;
    height: 12px;
    left: 50%;
    transform: translate(-50%, -50%) rotate(45deg);
    background-color: #EEEEEE;
    box-shadow: 0 1px 8px rgba(0, 0, 0, 0.5);
  }

  /* ----------------- slim scrollbar ----------------- */
  /* width */
  ::-webkit-scrollbar {
    width: 7px;
  }

  /* Track */
  ::-webkit-scrollbar-track {
    background: #f1f1f1;
  }

  /* Handle */
  ::-webkit-scrollbar-thumb {
    background: #888888;
    border-radius: 7px;
  }

  /* Handle on hover */
  ::-webkit-scrollbar-thumb:hover {
    background: #555555;
  }

  .comment-score {
    font-size: 12px;
  }
</style>