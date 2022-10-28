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
</style>