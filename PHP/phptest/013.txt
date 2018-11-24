<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
  	  function random(){
	  $r=0.0;
	  $c=0;
	  for ($i=0;$i<14;$i++){
		$c=rand(0,9);
		$r=0.1*$r+$c;
		}
	  $r*=0.1;
	  return $r;
	  }

        class vect{
            var $x=0,$y=0,$z=0;
            function norm(){
                return sqrt(pow($this->x,2)+pow($this->y,2)+pow($this->z,2));
            }
            
            function vect(){
                $this->x=random();
                $this->y=random();
                $this->z=random();
            }
                        
            function out_norm(){
                echo "norm=",$this->norm();
            }
        }
        $a=new vect;
        $a->out_norm();
        ?>
    </body>
</html>
