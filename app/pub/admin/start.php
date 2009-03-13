<div id="welcome_label" style="text-align:center;padding-top:200px;">
    <h1>Willkommen</h1>
</div>
<div id="welcome_label2" style="text-align:center;padding-top:200px;display:none; ">
    <img src="/admin/images/logo.png">
</div>




<script type="text/javascript">
    $('welcome_label2').hide();
    Effect.Fade('welcome_label', { duration: 3.0, queue: 'front'  });
    Effect.Appear('welcome_label2', { duration: 3.0,queue: 'end'  });
</script>


