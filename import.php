<?php
use SimpleExcel\SimpleExcel;
if(isset($_POST['import']))
{
    if(move_uploaded_file($_FILES['excel_file']['tmp_name'],$_FILES['excel_file']['name']))
    {
        require_once('SimpleExcel/SimpleExcel.php'); 
        $excel = new SimpleExcel('csv');                    

        $excel->parser->loadFile($_FILES['excel_file']['name']);            

        $foo = $excel->parser->getField();                 
        $bar = $excel->parser->getRow(3);                   
        $baz = $excel->parser->getColumn(4);   
        //$qux = $excel->parser->getCell(2,1);                

        echo '<pre>';
        print_r($foo);                                      
        echo '</pre>';
    }

}
?>