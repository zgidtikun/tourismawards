<?php $appRecapcha = new \Config\App(); ?>
<script src="https://www.google.com/recaptcha/api.js?render=<?=$appRecapcha->RECAPCHA_KEY?>"></script>
<script>
    function recapchaToken(){
        return new Promise(function(resolve, reject) {
            grecaptcha.ready(function() {
                grecaptcha.execute('<?=$appRecapcha->RECAPCHA_KEY?>', {}).then(function(token) {
                    resolve({ rccToken: token })
                });
            });  
        });      
    }
</script>
<!-- Excample call function gen recapcha token -->
<script>
    $(document).ready(function(){
        recapchaToken().then(function(data){                
            $('#recapcha_token').val(data.rccToken);
        });
    });
</script>
