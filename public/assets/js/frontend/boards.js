const tblar = null;

const boards = {
    dtb: null,
    at: {},
    dt: {},
    init(){
        const ld = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
        $('#count-tab1').html(ld);
        $('#count-tab2').html(ld);
        $('#count-tab3').html(ld);
        $('#count-tab4').html(ld);

        api({method: 'get', url: '/inner-api/boards/count-stage'}).then(function(r){
            $('#count-tab1').html(r.pre_wait+' รายการ');
            $('#count-tab2').html(r.pre_comp+' รายการ');
            $('#count-tab3').html(r.inst_wait+' รายการ');
            $('#count-tab4').html(r.inst_comp+' รายการ');
        });

        api({method: 'get', url: '/inner-api/app/type-all'}).then(function(r){
            boards.at.main = r.main;
            boards.at.sub = r.sub;

            let opt;

            $.each(r.main, function(k,v){
                let temp = v.name.split('(');
                opt = '<option value="'+temp[0].trim()+'">'+temp[0].trim()+'</option>';
                $(mf.s[0].ip).append(opt);
            });

            $('#sat-main').prop('disabled',false);
            $('#sat-sub').prop('disabled',false);
            $('#sip').prop('disabled',false);
            boards.getData(); 
        });
    },
    getData(){   
        const vt = $('.btn-dashboard.active').attr('data-tab');
        const st = {
            method: 'post',
            url: '/inner-api/boards',
            data: boards.getStage()            
        };
        
        api(st).then(function(rs){
            $('#sat-main').val('');
            $('#sat-sub').val('');
            $('#sip').val('');
            if(rs.result == 'success'){
                boards.dt = rs.data;
                boards.setDataTable(rs.data);
            } else {
                boards.dt = [];
                boards.setDataTable([]);
            }
        })
    },  
    getStage(){
        const vt = $('.btn-dashboard.active').attr('data-tab');
        let st = {};
          
        switch(Number(vt)){
            case 1:
                st.stage = 'pre-screen';
                st.status = 'wait';
            break;
            case 2:
                st.stage = 'pre-screen';
                st.status = 'finish';
            break;
            case 3:
                st.stage = 'onsite';
                st.status = 'wait';
            break;
            case 4:
                st.stage = 'onsite';
                st.status = 'finish';
            break;
        }

        return st;
    },
    setShowStatus(stageSts,requestSts,showSts){
        const st = boards.getStage();

        if(st.stage == 'pre-screen'){
            if(st.status == 'wait'){
                if(requestSts != '' && requestSts != 0){
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
            if(st.status == 'wait'){
                if(showSts == ''){
                    return 1;
                } else {
                    return 2;
                }
            } else {
                return stageSts;
            }
        }
    },
    setDataTable(dt){
        if(!$.fn.DataTable.isDataTable('#tbl-boards')){
            this.dtb = $('#tbl-boards').DataTable({
                data: dt,
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
                            const hr = 'href="javascript:boards.show('+row.id+');"';
                            let content = '<a '+hr+'><span>';
                            content += '<i class="bi bi-arrow-right-square-fill text-success mr-2"></i>';
                            content += data+ '</span>';

                            switch(Number(boards.setShowStatus(row.status,row.request_status,row.show_status))){
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
                            switch(Number(boards.setShowStatus(row.status,row.request_status,row.show_status))){
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
                            let content, href, oc, round;

                            if($.inArray(Number(vt),[1,2]) !== -1){
                                round = 'pre-screen';
                            } else {
                                round = 'onsite';
                            }

                            href = getBaseUrl()+'/boards/estimate/'+round+'/'+row.id;
                            oc = "'tbl',"+row.id;

                            content = '<a href="javascript:boards.score('+oc+');">';
                            content += '<i class="bi bi-toggles"></i></a>';
                            content += '<a href="'+href+'">';
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
            this.dtb.clear().rows.add(dt).draw(); 
        }  

        this.dtb.on('order.dt search.dt', function() {
            let i = 1;

            boards.dtb.cells(null, 0, {
                search: 'applied',
                order: 'applied'
            }).every(function(cell) {
                this.data(i++);
            });
        }).draw();
    },
    searchAll(){
        if($.fn.DataTable.isDataTable('#tbl-boards')){
            const s1 = $('#sat-main');
            const s2 = $('#sat-sub');
            const s3 = $('#sip');
            this.dtb.columns(2).search(s1.val()).draw();
            this.dtb.columns(3).search(s2.val()).draw();
            this.dtb.search(s3.val()).draw();
        }   
    },
    show(id){
        const ref = this.dt.find(el => el.id == id);
        
        $('#modal-plate').html(ref.att_name);
        $('#modal-appt').html(ref.type);
        $('#modal-appts').html(ref.section);
        
        $('#modal-badge').removeClass('badge-wait, badge-estimate, badge-request, badge-estcon, badge-norecall, badge-pass, badge-notpass');
        switch(Number(boards.setShowStatus(ref.status,ref.request_status,ref.show_status))){
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

        let link;
        let stage = boards.getStage().stage;

        link = getBaseUrl()+'/boards/estimate/'+stage+'/'+ref.id;
        $('#btn-estimate').attr('onclick',"window.location.href='"+link+"'");

        $('#modal-detail').modal('show');
    },
    score(f, id){
        if(f == 'md'){
            $('#modal-detail').modal('hide');
            id = $('#modal-detail').attr('data-id');
        }
        
        const ref = this.dt.find(el => el.id == id);
        const taget = ref.targetEstimate;
        const lscore = ref.lowcarbon_score;
        const spre = ref.score_pre;
        const sons = ref.score_onsite;
        
        if(Number(taget) == 3){

            $('#score thead').html(
                `<tr>
                    <th class="text-center">คะแนนรวม<br>(Pre-screen)</th>
                    <th class="text-center">ผลการประเมินด้าน<br>Low Carbon</th>
                    <th class="text-center">คะแนนรวม<br>(รอบลงพื้นที่)</th>
                </tr>`
            );

            $('#score tbody').html(
                `<tr>
                    <td class="text-center">${spre}</td>
                    <td class="text-center">${lscore}</td>
                    <td class="text-center">${sons}</td>
                </tr>`
            );

        }
        else if(Number(taget) == 2){

            $('#score thead').html(
                `<tr>
                    <th class="text-center">ผลการประเมินด้าน Low Carbon</th>
                </tr>`
            );

            $('#score tbody').html(
                `<tr>
                    <td class="text-center">${lscore}</td>
                </tr>`
            );
        } 
        else {

            $('#score thead').html(
                `<tr>
                    <th class="text-center">คะแนนรวม<br>(Pre-screen)</th>
                    <th class="text-center">คะแนนรวม<br>(รอบลงพื้นที่)</th>
                </tr>`
            );

            $('#score tbody').html(
                `<tr>
                    <td class="text-center">${spre}</td>
                    <td class="text-center">${sons}</td>
                </tr>`
            );
        }

        $('#modal-score').modal('show');
    },
    closeScore(){
        $('#modal-score').modal('hide');
        const width = $(window).width();
        if(width <= 576){
            $('#modal-detail').modal('show');
        }
    }
}

$('#sat-main').on('change',function(){
    const val = $(this).val();
    let opt;
    opt = '<option value="" selected>ทั้งหมด</option>';

    if(!empty(val)){        
        $.each(boards.at.main, function(km,vm){
            let mtemp = vm.name.split('(');
            if(mtemp[0].trim() == val){
                $.each(boards.at.sub, function(ks,vs){
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
    $('.fs-title').html('รายการ '+$(this)[0].innerHTML);
    boards.getData();
});

const mf = {
    s: [
        { ip: '#sat-main', id: 'sat-main' },
        { ip: '#sat-sub', id: 'sat-sub' },
        { ip: '#sip', id: 'sip' },
    ],
}