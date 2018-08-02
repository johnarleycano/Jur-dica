<div align="center" id="footer">
    <p>&copy;Todos los derechos reservados - <?php echo anchor_popup('http://www.devimed.com.co/','<b>Devimed S.A.</b>'); ?> | <i>Versión <b><?php echo version(); ?></b></p>
    <div class="clear"></div>

    <?php
	function version()
	{
	    foreach(array_reverse(glob('.git/refs/tags/*')) as $archivo) {
	        $contents = file_get_contents($archivo);

	        return basename($archivo);
	        exit();
	    }
	}
	?>
</div>