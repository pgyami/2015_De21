<?php
    
    function load_header(){
        require('site/widget/header.php');
    }
    
    function load_lsidebar(){
        require('site/widget/lsidebar.php');
    }
    
    function load_rsidebar(){
        require('site/widget/rsidebar.php');
    }
    
    function load_footer(){
        require('site/widget/footer.php');
    }
    
    function load_widget($widget){
        require('site/widget/'.$widget.'.php');
    }
?>