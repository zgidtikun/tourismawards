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
</style>