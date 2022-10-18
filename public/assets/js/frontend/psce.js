var appid, tycoon, dataset;
const pointer = { cate: -1, seg: -1 };

const setPage = (id) => {
    appid = id;
    init();
}

const getPointer = () => {
    return pointer;
}

const init = () =>{
    loading('show');

    api({ method: 'get', url: '/inner-api/boards/estimate/'+appid })
    .then((rs) => {
        tycoon = rs.tycoon;     
        dataset = rs.data;
        
        let tmp = tycoon.t_name.split(' ');
        tycoon.t_name = tmp[0];

        tmp = tycoon.ts_name.split(' ');
        tycoon.ts_name = tmp[0];

        $('#tyCode').html(tycoon.code);      
        $('#tyType').html(tycoon.t_name);    
        $('#tyName').html(tycoon.knitter_name);    
        $('#tyAttnTh').html(tycoon.attn_th);    
        $('#tyTSbu').html(tycoon.ts_name);    
        $('#tyEmail').html(tycoon.knitter_email);    
        $('#tyAttnEn').html(tycoon.attn_en);    
        $('#tyUdat').html(tycoon.updated_at);    
        $('#tyTel').html(tycoon.knitter_tel);
        
        loading('hide');
    });
}