<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php        
        class money{
            private $cnum=0;
            private $value=0;
            private $currency=Array("dollar"=>30.9,"euro"=>43.8,"grivna"=>4.23);
            
            public function make_money($_cnum,$_value){
                $this->cnum=$_cnum;
                $this->value=$_value;
            }
            public function convert($_cnum){
                $this->value=($this->currency[$this->cnum])*($this->value)/($this->currency[$_cnum]);
                $this->cnum=$_cnum;               
            }
            
            public function add_money($_cnum,$_value){
                $d=$_value*$this->currency[$_cnum]/$this->currency[$this->cnum];
                $this->value+=$d;
            }
            
            public function sub_money($_cnum,$_value){
                $d=$_value*$this->currency[$_cnum]/$this->currency[$this->cnum];
                $this->value-=$d;
            }
            
            public function print_valuta(){
                echo $this->value," ",$this->cnum;
            }
            
            public function get_rouble(){
                return ($this->currency[$this->cnum])*$this->value;
            }
        }
        
        $mn=new money();
        $mn->make_money("grivna", 40.2);
        $mn->add_money("euro", 39.2);
        $mn->sub_money("dollar",22.3);
        $mn->convert("euro");
        echo "valuta:";
        $mn->print_valuta();
        echo "&ltbr>roubles:",$mn->get_rouble()," roubles";
        
        ?>
    </body>
</html>
