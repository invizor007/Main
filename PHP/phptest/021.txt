<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        $i=1;
        $ii=& $i;
        $ii++;
        //echo $i;
        
        $var1 = "Example variable";
        $var2 = "";

        function global_references($use_globals)
        {
            global $var1, $var2;
            if (!$use_globals) {
                $var2 =& $var1; // only local
            } else {
                $GLOBALS["var2"] =& $var1; // global
            }
        }

        global_references(false);
        echo "value of var1: '$var1'\n"; // value of var2: ''
        global_references(true);
        echo "value of var2: '$var2'\n"; // value of var2: 'Example variable'
        ?>
    </body>
</html>
