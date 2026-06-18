<div class="d-flex justify-content-center">
    <h1>ลบสำเร็จ</h1>
</div>

<?php
$js = <<<JS
      
   if (window.opener) {
    window.opener.location.reload();
    setTimeout(function(){
       window.close();  
   },3000);
    //window.close(); 
}

        
JS;
$this->registerJs($js);

