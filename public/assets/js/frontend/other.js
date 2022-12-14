const getBaseUrl = () => {
    return window.location.origin
}

const loading = async(action) => {
    if(action == 'show'){
        if(!$('#loading-page').hasClass('loading'))
            $('#loading-page').addClass('loading');
    } else {
        if($('#loading-page').hasClass('loading'))
            $('#loading-page').removeClass('loading');
    }
}

const empty = (data) =>{
    if($.isArray(data)) {
        if(data.length < 1)
            return true;
    }
    else if($.type(data) === 'object'){
        if($.isEmptyObject(data))
            return true;
    }
    else if(data == '' || data === null || data === 'null' || data === undefined || data === 'undefined')
        return true;
    return false;
}

const api = async(setting) => {
    return new Promise(function(resolve, reject){
        let setAjax = {
            url: getBaseUrl()+setting.url,
            async: false,
        };

        switch(setting.method){
            case 'get':
                setAjax.type = 'get';
            break;
            case 'post':
            case 'action':
                setAjax.type = 'post',
                setAjax.data = setting.data,
                setAjax.dataType = 'json';

                if(setting.method == 'action'){
                    setAjax.contentType = false,
                    setAjax.processData = false;
                }
            break;
        }
        
        let request = $.ajax(setAjax);
        request.done(function(response){
            resolve(response);
        })
        .fail(function(jqXHR, textStatus){
            reject({
                result: 'error',
                message: 'Request failed: '+textStatus
            });
        })
        .error(function(jqXHR, textStatus){
            reject({
                result: 'error',
                message: 'Request failed: '+textStatus
            });
        });
    });
}

const setSpinner = (text = null) => {
    let html = '<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>';
    if(!empty(text))
        html += text;
    return html;
}

const convertYearThToEn = (date) => {
    let arrayDate;

    if(date.includes('/')){
        arrayDate = date.split('/')
    } 
    else if(date.includes('-')){
        arrayDate = date.split('-')
    } else {
        return '';
    }

    return (Number(arrayDate[0]) - 543)+'/'+arrayDate[1]+'/'+arrayDate[2];
}

const calcDate = (date1, date2) => {
    
    const dt_date1 = new Date(date1);
    const dt_date2 = new Date(date2);

    const date1_time_stamp = dt_date1.getTime();
    const date2_time_stamp = dt_date2.getTime();

    let calc;
    
    if (date1_time_stamp > date2_time_stamp) {
        calc = new Date(Math.abs(date1_time_stamp - date2_time_stamp));
    } else {
        calc = new Date(Math.abs(date2_time_stamp - date1_time_stamp));
    }
    
    const calcFormatTmp = calc.getDate() + '-' + (calc.getMonth() + 1) + '-' + calc.getFullYear();
    
    const calcFormat = calcFormatTmp.split("-");
    
    const days_passed = Number(Math.abs(calcFormat[0]) - 1);
    const months_passed = Number(Math.abs(calcFormat[1]) - 1);
    const years_passed = Number(Math.abs(calcFormat[2]) - 1970);
    
    const yrsTxt = ["year", "ปี"];
    const mnthsTxt = ["month", "เดือน"];
    const daysTxt = ["day", "วัน"];
    
    const total_days = (years_passed * 365) + (months_passed * 30.417) + days_passed;
    
    let result = '';

    if(years_passed >= 1){
        result += years_passed + ' ' + yrsTxt[1] + ' ';
    }

    if(months_passed >= 1){
        result += months_passed + ' ' + mnthsTxt[1] + ' ';
    }

    if(days_passed >= 1){
        result += days_passed + ' ' + daysTxt[1] + ' ';
    }
            
    return {
        "total_year": years_passed,
        "total_days": Math.round(total_days),
        "result": result.trim()
    }
}