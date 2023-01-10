<style>
  body {
    background: rgb(204, 204, 204);
  }

  #btn_print {
    display: block;
    margin: 0 auto;
    margin-bottom: 0.5cm;
  }

  .button {
    background-color: #4CAF50;
    /* Green */
    border: none;
    color: white;
    padding: 16px 32px;
    text-align: center;
    text-decoration: none;
    /* display: inline-block; */
    font-size: 16px;
    margin: 4px 2px;
    transition-duration: 0.4s;
    cursor: pointer;
  }

  .button1 {
    background-color: white;
    color: black;
    border: 2px solid #4CAF50;
  }

  .button1:hover {
    background-color: #4CAF50;
    color: white;
  }

  page {
    background: white;
    display: block;
    margin: 0 auto;
    margin-bottom: 0.5cm;
    box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
  }

  page[size="A4"] {
    width: 21cm;
    height: 29.7cm;
  }

  page[size="A4"][layout="landscape"] {
    width: 29.7cm;
    height: 21cm;
  }

  @media print {

    body,
    page {
      margin: 0;
      box-shadow: 0;
    }

    #btn_print {
      display: none;
    }
  }

  table {
    border-collapse: collapse;
  }

  tbody>tr>td {
    font-size: small;
  }
</style>
<?php //pp($estimate) 
?>
<button id="btn_print" class="button button1" onclick="window.print()">Print</button>

<page size="A4" style="padding: 10px;">
  <h2>คะแนน Low Carbon</h2>
  <h4>ชื่อสถานประกอบการ : <?= $result->attraction_name_th ?></h4>
  <h4>ชื่อคณะกรรมการ : <?= $user_name ?></h4>
  <h4>เกณฑ์การให้คะแนน : 0. ไม่มีคุณสมบัติ, 1. มีคุณสมบัติตามเกณฑ์</h4>

  <table border="1" width="100%">
    <thead>
      <tr>
        <th width="5%" rowspan="2">ข้อ</th>
        <th width="65%" rowspan="2">คำถาม</th>
        <th width="15%" colspan="2">คะแนน</th>
      </tr>
      <tr>
        <th width="15%">รอบ Pre-Screen</th>
        <th width="15%">รอบลงพื้นที่</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $sum_score_pre = [];
      if (!empty($estimate)) {
        foreach ($estimate as $key => $value) {
          $sum_score_pre[] = $value->score_pre;
      ?>
          <tr>
            <td align="center"><?= ($key + 1) ?></td>
            <td align="left"><?= $value->question ?></td>
            <td align="center"><?= $value->score_pre ?></td>
            <td align="center"></td>
          </tr>
      <?php
        }
      }
      ?>
      <tr>
        <td align="center"></td>
        <td align="center">คะแนนรวม</td>
        <td align="center"><?= array_sum($sum_score_pre) ?></td>
        <td align="center"></td>
      </tr>
    </tbody>
  </table>
</page>