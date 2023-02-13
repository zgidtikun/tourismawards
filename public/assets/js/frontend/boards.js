const boards = {
    dttb: null,
    assessment: null,
    appType: {},
    list: {},
}

const init = () => {
    setCountList();
    setSearcher();
}

const setCountList = async() => {
    const callback = await api({method: 'get', url: '/inner-api/boards/count-stage'});
    $('#count-tab1').html(`${callback.pre_wait} รายการ`);
    $('#count-tab2').html(`${callback.pre_comp} รายการ`);
    $('#count-tab3').html(`${callback.inst_wait} รายการ`);
    $('#count-tab4').html(`${callback.inst_comp} รายการ`);
}

const setSearcher = async() => {
    const callback = await api({method: 'get', url: '/inner-api/app/type-all'});
    boards.appType.main = callback.main;
    boards.appType.sub = callback.sub;

    $.each(callback.main, function(k,v){
        const temp = v.name.split('(');
        const opt = `<option value="${temp[0].trim()}">${temp[0].trim()}</option>`;
        $('#sat-main').append(opt);
    });

    $('#sat-main').prop('disabled',false);
    $('#sat-sub').prop('disabled',false);
    $('#sip').prop('disabled',false);
    getData(); 
}

const getData = async() => { 
    const setting = {
        method: 'post',
        url: '/inner-api/boards',
        data: getStage()            
    };

    const callback = await api(setting);

    $('#sat-main').val('');
    $('#sat-sub').val('');
    $('#sip').val('');

    if(callback.result == 'success'){
        boards.list = callback.data;
        boards.assessment = callback.assessment;
        setDataTable(callback.data);
    } else {
        boards.list = [];
        setDataTable([]);
    }
}

const getStage = () =>{
    const tab = $('.btn-dashboard.active').attr('data-tab');
    let setting = {};
      
    switch(Number(tab)){
        case 1:
            setting.stage = 'pre-screen';
            setting.status = 'wait';
        break;
        case 2:
            setting.stage = 'pre-screen';
            setting.status = 'finish';
        break;
        case 3:
            setting.stage = 'onsite';
            setting.status = 'wait';
        break;
        case 4:
            setting.stage = 'onsite';
            setting.status = 'finish';
        break;
    }

    return setting;
}

const setShowStatus = (stageSts,requestSts,showSts) => {
    const stage = getStage();
    
    if(stage.stage == 'pre-screen'){
        if(stage.status == 'wait'){
            if(requestSts != '' && $.inArray(Number(requestSts),[0,3]) === -1){
                return stageSts;
            } else {
                if(showSts == ''){
                    return 1;
                } else {
                    return 2;
                }
            }
        } else {
            return stageSts;
        }
    } else {
        if(stage.status == 'wait'){
            if(showSts == ''){
                return 1;
            } else {
                return 2;
            }
        } else {
            return stageSts;
        }
    }
}

const setDataTable = (data) => {
    if(!$.fn.DataTable.isDataTable('#tbl-boards')){
        boards.dttb = $('#tbl-boards').DataTable({
            data: data,
            pageLength: 10,
            procressing: true,
            info: true,
            filter: true,
            lengthChange: false,
            columns: [
                { data: 'no' },
                { 
                    data: 'att_name',
                    render: function(data, type, row, meta){
                        let content = `<a href="javascript:show(${row.id});"><span>`;
                        content += '<i class="bi bi-arrow-right-square-fill text-success mr-2"></i>';
                        content += `${data}</span>`;

                        switch(Number(setShowStatus(row.status,row.request_status,row.show_status))){
                            case 1:
                                content += '<span class="badge badge-wait ml-1">';
                                content += 'รอการประเมิน</span>';
                            break;
                            case 2:
                                content += '<span class="badge badge-estimate ml-1">';
                                content += 'กำลังประเมิน</span>';
                            break;
                            case 3:
                                content += '<span class="badge badge-request ml-1">';
                                content += 'ขอข้อมูลเพิ่มเติม</span>';
                            break;
                            case 4:
                                content += '<span class="badge badge-estcon ml-1">';
                                content += 'ตรวจข้อมูลเพิ่มเติม</span>';
                            break;
                            case 5:
                                content += '<span class="badge badge-norecall ml-1">';
                                content += 'ไม่มีการตอบรับ</span>';
                            break;
                            case 6:
                                content += '<span class="badge badge-pass ml-1">';
                                content += 'ประเมินเรียบร้อย</span>';
                            break;
                            case 7:
                                content += '<span class="badge badge-notpass ml-1">';
                                content += 'ไม่ผ่านประเมิน</span>';
                            break;
                        }
                        
                        content += '</a>';
                        return content;
                    }
                },
                { 
                    data: 'type',
                    render: function(data, type, row, meta){
                        let tmp = data.split('(');
                        let content = tmp[0].trim();
                        
                        if(tmp.length > 1){
                            content += '<br>('+tmp[1].trim();
                        }

                        return content;
                    } 
                },
                { 
                    data: 'section',
                    render: function(data, type, row, meta){
                        let tmp = data.split('(');
                        let content = tmp[0].trim();
                        
                        if(tmp.length > 1){
                            content += '<br>('+tmp[1].trim();
                        }

                        return content;
                    }  
                },
                { 
                    data: 'status',
                    render: function(data, type, row, meta){
                        let content;
                        
                        switch(Number(setShowStatus(row.status,row.request_status,row.show_status))){
                            case 1:
                                content = '<span class="userstatus wait">';
                                content += 'รอการประเมิน</span>';
                            break;
                            case 2:
                                content = '<span class="userstatus estimate">';
                                content += 'กำลังประเมิน</span>';
                            break;
                            case 3:
                                content = '<span class="userstatus request">';
                                content += 'ขอข้อมูลเพิ่มเติม</span>';
                            break;
                            case 4:
                                content = '<span class="userstatus estcon">';
                                content += 'ตรวจข้อมูลเพิ่มเติม</span>';
                            break;
                            case 5:
                                content = '<span class="userstatus norecall">';
                                content += 'ไม่มีการตอบรับ</span>';
                            break;
                            case 6:
                                content = '<span class="userstatus pass">';
                                content += 'ประเมินเรียบร้อย</span>';
                            break;
                            case 7:
                                content = '<span class="userstatus notpass">';
                                content += 'ไม่ผ่านประเมิน</span>';
                            break;
                        }

                        return content;
                    }
                },
                { data: 'updated_at' },
                { 
                    data: 'status',
                    render: function(data, type, row, meta){
                        const vt = $('.btn-dashboard.active').attr('data-tab');
                        let content, oc, round;

                        if($.inArray(Number(vt),[1,2]) !== -1){
                            round = 'pre-screen';
                        } else {
                            round = 'onsite';
                        }

                        const href = getBaseUrl()+'/boards/estimate/'+round+'/'+row.id;
                        oc = "'tbl',"+row.id;

                        content = `<a href="javascript:score('tbl',${row.id});">`;
                        content += '<i class="bi bi-toggles"></i></a>';
                        content += `<a href="${href}">`;
                        content += '<i class="bi bi-pencil-square"></i></a>';
                        return content;
                    }
                },
            ],
            columnDefs: [
                {
                    targets: 0,
                    className: 'text-center',
                    searchable: false,
                    orderable: false
                },
                { targets: 1, className: '' },
                { targets: 2, className: 'text-center' },
                { targets: 3, className: 'text-center' },
                { targets: 4, className: 'text-center' },
                { targets: 5, className: 'text-center' },
                { 
                    targets: 6, 
                    className: 'text-center edit',
                    searchable: false,
                    orderable: false
                },
            ],
            order: [[5,'asc']],
            language: {
                emptyTable: "ไม่มีรายการข้อมูล",
                info: "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
                infoEmpty: "",
                zeroRecords: "ไม่พบข้อมูลที่ค้นหา",
                infoFiltered: "(ค้นหาจากทั้งหมด _MAX_ รายการ)"
            },
            drawCallback: function(data, type, row, meta) {
                $('.dataTables_paginate ul').addClass('pagination-sm justify-content-end');
            }                
        });        
    } else {
        boards.dttb.clear().rows.add(data).draw(); 
    }  

    boards.dttb.on('order.dt search.dt', function() {
        let i = 1;

        boards.dttb.cells(null, 0, {
            search: 'applied',
            order: 'applied'
        }).every(function(cell) {
            this.data(i++);
        });
    }).draw();
}

const searchAll = () =>{
    if($.fn.DataTable.isDataTable('#tbl-boards')){
        const s1 = $('#sat-main');
        const s2 = $('#sat-sub');
        const s3 = $('#sip');
        boards.dttb.columns(2).search(s1.val()).draw();
        boards.dttb.columns(3).search(s2.val()).draw();
        boards.dttb.search(s3.val()).draw();
    }   
}

const show = id => {
    const ref = boards.list.find(el => el.id == id);
    
    $('#modal-plate').html(ref.att_name);
    $('#modal-appt').html(ref.type);
    $('#modal-appts').html(ref.section);
    
    $('#modal-badge').removeClass('badge-wait, badge-estimate, badge-request, badge-estcon, badge-norecall, badge-pass, badge-notpass');
    switch(Number(setShowStatus(ref.status,ref.request_status,ref.show_status))){
        case 1: 
            $('#modal-badge').html('รอการประเมิน');
            $('#modal-badge').addClass('badge-wait');
        break;
        case 2: 
            $('#modal-badge').html('กำลังประเมิน');
            $('#modal-badge').addClass('badge-estimate');
        break;
        case 3: 
            $('#modal-badge').html('ขอข้อมูลเพิ่มเติม');
            $('#modal-badge').addClass('badge-request');
        break;
        case 4: 
            $('#modal-badge').html('ตรวจข้อมูลเพิ่มเติม');
            $('#modal-badge').addClass('badge-estcon');
        break;
        case 5: 
            $('#modal-badge').html('ไม่มีการตอบรับ');
            $('#modal-badge').addClass('badge-norecall');
        break;
        case 6: 
            $('#modal-badge').html('ประเมินเรียบร้อย');
            $('#modal-badge').addClass('badge-pass');
        break;
        case 7: 
            $('#modal-badge').html('ไม่ผ่านประเมิน');
            $('#modal-badge').addClass('badge-notpass');
        break;
    }

    $('#modal-date').html(ref.updated_at);
    $('#modal-detail').attr('data-id',ref.id);
    
    const stage = getStage().stage;
    const link = getBaseUrl()+'/boards/estimate/'+stage+'/'+ref.id;
    $('#btn-estimate').attr('onclick',"window.location.href='"+link+"'");
    $('#modal-detail').modal('show');
}

const score = (f, id) => {
    if(f == 'md'){
        $('#modal-detail').modal('hide');
        id = $('#modal-detail').attr('data-id');
    }
    
    const ref = boards.list.find(el => el.id == id);
    const stage = getStage();
    const lstatus = stage.stage == 'pre-screen' ? ref.lowcarbon_status : 2;
    // const taget = ref.targetEstimate;
    
    if(Number(lstatus) == 1){
        $('#modal-score .modal-dialog').removeClass('modal-lg');
        const lscore = ref.lowcarbon_score;
        
        $('#score thead').html(
            `<tr>
                <th class="text-center">
                    ด้าน Low Carbon (20 คะแนน)
                </th>
            </tr>`
        );

        $('#score tbody').html(
            `<tr>
                <td class="text-center">
                    <span class="score">${lscore}</span>
                </td>
            </tr>`
        );
    } 
    else {
        $('#modal-score .modal-dialog').addClass('modal-lg');
        $('#modal-score .modal-dialog').addClass('modal-lg');

        const screen_w = $(window).width();
        const assessment = boards.assessment;
        let thead = '';
        let tbody = '';

        if(screen_w > 767){   
            $('#modal-score').remove('top-0');    
            $('#score thead').html(
                `<tr>            
                    <th>หัวข้อที่ประเมิน</th>
                    <th class="text-center">
                        Pre-Screen<br>
                        <span class="header-score">(25 คะแนน)</span>
                    </th>
                    <th class="text-center">
                        ลงพื้นที่<br>
                        <span class="header-score">(75 คะแนน)</span>
                    </th>
                </tr>`
            );
        } else {
            $('#modal-score').addClass('top-0');  
            $('#score thead').html(
                `<tr>            
                    <th colspan="2">หัวข้อที่ประเมิน</th>
                </tr>`
            );
        }

        $.each(assessment,(key, ass) => {
            if(ass.id != 4){
                let pscore, oscore;

                if(ass.id == 1){
                    pscore = ref.score_pte;
                    oscore = ref.score_ote;
                }
                else if(ass.id == 2){
                    pscore = ref.score_psb;
                    oscore = ref.score_osb;
                }
                else {
                    pscore = ref.score_prs;
                    oscore = ref.score_ors;
                }

                pscore = Number(pscore) > 0 ? pscore : '';
                oscore = Number(oscore) > 0 ? oscore : '';

                if(screen_w > 767){ 
                    tbody += `
                        <tr>
                            <td>${ass.name}<br>
                                <span class="body-score">
                                    (คะแนนเต็ม Pre-Screen ${ass.score_prescreen} คะแนน, 
                                    ลงพื้นที่ ${ass.score_onsite} คะแนน)
                                <span>
                            </td>
                            <td class="text-center">
                                <span class="score">${pscore}<span>
                            </td>
                            <td class="text-center">
                                <span class="score">${oscore}<span>
                            </td>
                        </tr>
                    `;
                } else {
                    tbody += `
                        <tr>
                            <td colspan="2">
                                ${ass.name}<br>
                                <span class="body-score">
                                    (คะแนนเต็ม Pre-Screen ${ass.score_prescreen} คะแนน, 
                                    ลงพื้นที่ ${ass.score_onsite} คะแนน)
                                <span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Pre-Screen<br>
                                <span class="header-score">(25 คะแนน)</span>
                            </td>
                            <td>
                                <span class="score">${pscore}<span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                ลงพื้นที่<br>
                                <span class="header-score">(75 คะแนน)</span>
                            </td>
                            <td>
                                <span class="score">${oscore}<span>
                            </td>
                        </tr>
                    `;
                }
            }
        });

        $('#score tbody').html(tbody);
    }

    $('#modal-score').modal('show');
}

const closeScore = () => {
    $('#modal-score').modal('hide');
    const width = $(window).width();

    if(width <= 576){
        $('#modal-detail').modal('show');
    }
}

$('#sat-main').on('change',function(){
    const val = $(this).val();
    let opt;
    opt = '<option value="" selected>ทั้งหมด</option>';

    if(!empty(val)){        
        $.each(boards.appType.main, function(km,vm){
            let mtemp = vm.name.split('(');
            if(mtemp[0].trim() == val){
                $.each(boards.appType.sub, function(ks,vs){
                    if(vs.application_type_id == vm.id){                        
                        let stemp = vs.name.split('(');
                        opt += '<option value="'+stemp[0].trim()+'">'+stemp[0].trim()+'</option>';
                    }
                });

                return false;
            }
        });
    }
        
    $('#sat-sub').html(opt);
});

$('.btn-dashboard').click(function(){
    $('.btn-dashboard').removeClass('active');
    $(this).toggleClass('active');
    $('.fs-title').html(`รายการ ${$(this)[0].innerHTML}`);
    getData();
});