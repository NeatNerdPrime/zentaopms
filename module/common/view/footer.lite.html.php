<?php if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}?>
<iframe frameborder='0' name='hiddenwin' id='hiddenwin' scrolling='no' class='debugwin hidden'></iframe>
<?php if($this->loadModel('cron')->runnable()) js::execute('startCron()');?>
<script>
<?php if(isset($pageJS)) echo $pageJS;?>
</script>
</body>
</html>
