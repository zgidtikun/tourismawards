<?php $appRecapcha = new \Config\App(); ?>
<script src="https://www.google.com/recaptcha/api.js?render=<?=$appRecapcha->RECAPCHA_KEY?>"></script>
<script>
    function recapchaToken(){
        return new Promise(function(resolve, reject) {
            <?php if($appRecapcha->RECAPCHA_CK): ?>
                grecaptcha.ready(function() {
                    grecaptcha.execute('<?=$appRecapcha->RECAPCHA_KEY?>', {}).then(function(token) {
                        resolve({ rccToken: token });
                    });
                }); 
            <?php else :?>
                resolve({ rccToken: null });
            <?php endif;?>
        });      
    }

    function setRecapchaToken(){
        return new Promise(function(resolve, reject) {
            recapchaToken().then(function(data){ 
                
                $('#recapcha_token').val(data.rccToken);
                resolve({ status: true });
            });
        });
    }
</script>
<!-- Excample call function gen recapcha token -->
<!-- <script>
    $(document).ready(function(){
        recapchaToken().then(function(data){                
            $('#recapcha_token').val(data.rccToken);
        });
    });
</script> -->
