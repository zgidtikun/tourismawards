<!-- ห้ามแก้ไข!! ไฟล์นี้มีการเรียกใช้ทั้งระบบเพื่อลดการเขียนโค๊ดซ้ำๆทั้งที่ทำงานแบบเดิม -->
<script>
  const ENVIRONMENT = '<?php echo $_ENV['CI_ENVIRONMENT'] ?>';
  const BASE_URL = '<?php echo base_url() ?>';
  $(function() {
    <?php if (session('success')) { ?>
      toastr.success("<?php echo session('success'); ?>");
    <?php } else if (session('error')) {  ?>
      toastr.error("<?php echo session('error'); ?>");
    <?php } else if (session('warning')) {  ?>
      toastr.warning("<?php echo session('warning'); ?>");
    <?php } else if (session('info')) {  ?>
      toastr.info("<?php echo session('info'); ?>");
    <?php } ?>

    $('#main_datatable').DataTable({
      pageLength: 10,
      // pagingType: "numbers",
      // dom: 'plrtip',
      // dom: 'Bfrtip',
      // buttons: [
      //     'copy', 'csv', 'excel', 'pdf', 'print'
      // ],
      responsive: true,
      searching: true,
      lengthMenu: [10, 25, 50, 100],
      autoWidth: false,
      oLanguage: {
        sSearchPlaceholder: "ค้นหา",
        sLengthMenu: "แสดง _MENU_ รายการ",
        sSearch: "ค้นหา",
        sInfo: "แสดง _START_ ถึง _END_ ทั้งหมด _TOTAL_ รายการ",
        sInfoEmpty: "แสดง 0 ถึง 0 ทั้งหมด 0 รายการ",
        sInfoFiltered: "(ค้นหาจากทั้งหมด _MAX_ รายการ)",
        sZeroRecords: "ไม่มีข้อมูล",
        sProcessing: "Processing",
        semptyTable: "ไม่มีข้อมูล",
      }
    });

    $('[data-toggle="tooltip"]').tooltip();
    // init_selectpicker();
  });

  function F2C(number) {
    number = Number(Math.round(Number(number) * 100) / 100);
    number = number.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    return number;
  }

  function DF2C(number) {
    number = String(number);
    number = number.replace(/,/g, '');
    return number;
  }

  function cc(str) {
    console.log(str);
  }

  function ct(str) {
    console.table(str);
  }

  function al(str) {
    alert(str);
  }

  function view_img(elm) {
    var src = $(elm).attr('src');
    Swal.fire({
      imageUrl: src,
      width: 800,
      height: 800,
      imageWidth: 1100,
      confirmButtonColor: '#DD3342',
      confirmButtonText: '<i class="fas fa-times"></i> ปิด',
    })
  }

  function main_post(url, data = null) {
    var return_ = false;
    $.ajax({
      url: url,
      type: 'POST',
      data: data,
      dataType: 'json',
      async: false,
      success: function(res) {
        return_ = res;
      }
    });
    return return_;
  }

  function main_save(url, form) {
    let return_ = false;
    let formData = new FormData($(form)[0]);
    $.ajax({
      type: 'POST',
      url: url,
      data: formData,
      contentType: false,
      processData: false,
      dataType: 'json',
      async: false,
      success: function(res) {
        return_ = res;
      }
    });
    return return_;
  }

  function res_swal(option_use, reload = 0, fx = {}) {
    var option = {
      type: 'error',
      title: 'ผิดพลาด',
      text: 'กรุณาลองใหม่อีกครั้ง',
      html: null,
      footer: null,
      confirmButtonColor: '#01AE5C',
      confirmButtonText: '<i class="fas fa-check"></i> ตกลง',
      // onClose: {},
      customClass: {},
      outsideClose: true,
      showConfirmButton: true,
    }

    $.extend(option, option_use);

    Swal.fire({
      icon: option.type,
      title: option.title,
      text: option.text,
      html: option.html,
      footer: option.footer,
      showCloseButton: option.outsideClose,
      // closeOnConfirm: option.outsideClose,
      allowOutsideClick: option.outsideClose,
      confirmButtonColor: option.confirmButtonColor,
      confirmButtonText: option.confirmButtonText,
      showConfirmButton: option.showConfirmButton,
      allowOutsideClick: true,
    }).then((result) => {
      // cc(result)
      if (typeof fx == 'function') {
        fx(option); // ถ้ามีฟังก์ชั่นให้ทำก่อน
      }
      if (reload == 1) {
        if (option.type == 'success') {
          location.reload();
        }
      }
    });
  }

  function swal_confirm(option_use = {}) {
    var option = {
      type: 'warning',
      title: null,
      text: null,
      html: null,
      footer: null,
      confirmButtonColor: '#01AE5C',
      cancelButtonColor: '#DD3342',
      confirmButtonText: '<i class="fas fa-check"></i> ยืนยัน',
      cancelButtonText: '<i class="fas fa-times"></i> ยกเลิก',
      // onClose: {},
      customClass: {},
    }

    $.extend(option, option_use);

    var return_ = $.Deferred(function() {

      Swal.fire({
        title: option.title,
        text: option.text,
        html: option.html,
        icon: option.type,
        showCancelButton: true,
        showCloseButton: true,
        cancelButtonColor: option.cancelButtonColor,
        confirmButtonColor: option.confirmButtonColor,
        confirmButtonText: option.confirmButtonText,
        cancelButtonText: option.cancelButtonText,
        customClass: option.customClass,
        footer: option.footer,
        // timer: 50000,
        // timerProgressBar: true,
        // didOpen: () => {
        //   Swal.showLoading()
        //   const b = Swal.getHtmlContainer().querySelector('b')
        //   timerInterval = setInterval(() => {
        //     b.textContent = Swal.getTimerLeft()
        //   }, 100)
        // },
        // willClose: () => {
        //   clearInterval(timerInterval)
        // }
      }).then((result) => {
        Swal.showLoading();
        if (result.value) {
          return_.resolve();
        } else if (result.dismiss === Swal.DismissReason.cancel) {
          return_.reject();
        }
      });
    });
    return return_;
  }

  function main_validated(form_id) {
    let return_ = true;
    $('#' + form_id).addClass('was-validated');
    if (return_) {
      $('#' + form_id + ' input:text, #' + form_id + ' [type="datetime-local"], #' + form_id + ' [type="number"], #' + form_id + ' textarea, #' + form_id + ' .selectpicker').each(function(index) {
        $(this).val($.trim($(this).val()));
        if ($(this).is(':required') && $(this).val() == '') {
          if ($(this).hasClass('datepicker')) {
            // $(this).addClass('is-invalid');
          }
          $(this).focus();
          return_ = false;
          toastr.error('กรุณาตรวจสอบข้อมูลที่จำเป็นต้องระบุ');
          return false;
        }
      });
    }
    return return_;
  }

  /*
    //  วิธีใช้งาน JS Windows Alert เผื่ออนาคตมีการแจ้งเตือนทำไว้ใช้
    //  var data = {
    //    title: 'Mark Notification',
    //    body: 'Mark Body Notification',
    //    link: base_url + 'backend',
    //  }
    //  setNotification(data);
    // 
  */
  function setNotification(data_use = {}) {

    // เล่นเสียงเวลาที่มีข้อความเข้า
    // const audio = new Audio("https://freesound.org/data/previews/501/501690_1661766-lq.mp3");
    // audio.play();

    var data = {
      title: 'title',
      body: 'body',
      icon: base_url + "images/favicon.png",
      link: base_url,
    }

    $.extend(data, data_use);

    // console.log(Notification.permission);
    if (Notification.permission === "granted") {
      // console.log("we have permission");
      showNotification(data_use);
    } else if (Notification.permission !== "denied") {
      Notification.requestPermission().then(permission => {
        // console.log(permission);
      });
    }
  }

  function showNotification(data) {
    const notification = new Notification(data.title, {
      body: data.body,
      icon: data.icon,
    })
    notification.onclick = (e) => {
      window.location.href = data.link;
    };
  }


  // Enter จะเป็นเลขทศนิยม
  $('body').on('keypress keyup blur', '.f_number', function(event) {
    if (event.keyCode == 13) {
      var f_number = $(this).val();
      if (f_number == "") {
        $(this).val('');
      } else if (f_number == 0) {
        $(this).val('0.00');
      } else {
        $(this).val(F2(f_number));
      }
    }
  });

  // ห้ามกด Enter
  $('body').on('keypress keyup blur', '.not_enter', function(event) {
    if (event.keyCode == 13) {
      return false;
    }
  });

  // กรอกเลขจำนวนเต็ม
  $('body').on('keypress down keyup blur', '.i_number', function(event) {
    $(this).val($(this).val().replace(/[^\d].+/, ""));
    if ((event.which < 48 || event.which > 57)) {
      event.preventDefault();
    }
  });

  // กรอกเฉเพาะภาษาอังกฤษ
  $('body').on('keypress keyup', '.for_english', function(event) {
    //48-57(ตัวเลข) ,65-90(Eng ตัวพิมพ์ใหญ่ ) ,97-122(Eng ตัวพิมพ์เล็ก)
    if (event.keyCode >= 65 && event.keyCode <= 90 || event.keyCode >= 97 && event.keyCode <= 122) {
      return true;
    } else {
      toastr.warning('กรอกได้เฉพาะภาษาอังกฤษ')
      return false;
    }
  });

  function main_copy(text) {
    var temp = $("<textarea>");
    $("body").append(temp);
    $(temp).val(text).select();
    document.execCommand("copy");
    $(temp).remove();
    localStorage.setItem("clipboard", text);
  }

  function file_exists(url) {
    var http = new XMLHttpRequest();
    http.open('HEAD', url, false);
    http.send();
    return http.status != 404;
  }
</script>