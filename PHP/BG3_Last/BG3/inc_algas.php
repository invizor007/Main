<?php

class AlgAS
{
	public $a= array();//[];
	public $sx=4;
	public $sy=3;
	public $ex=2;
	public $ey=1;
	//0 - проверка на корректность старта и финиша
	public function bad_start_end()
	{
		if ($this->a[$this->sy][$this->sx]==1) return 1;
		if ($this->a[$this->ey][$this->ex]==1) return 1;	
		return 0;
	}
	//1-инициализация массива
	public function init_array()
	{
		for ($i=0;$i<40;$i++)
		{
			$this->a[$i]=array();
			for ($j=0;$j<40;$j++)
			{
				$this->a[$i][$j]=0;
			}
		}
	}
	//2-определение расстояния
	public function Dist($x1,$x2,$y1,$y2)
	{
		$dx = abs($x1-$x2);
		$dy = abs($y1-$y2);
	
		if ($dx>$dy)
		{
			return $dy*14+($dx-$dy)*10;
		}
		else
		{
			return $dx*14+($dy-$dx)*10;
		}
	}
	//3-подготовка к вычислениям
	public function alg_prep()
	{
		if (!isset($_SESSION['sect'])) 
		{
			$_SESSION['sect'] = -1;
		}
		$db = mysqli_connect("localhost","bg3user","","bg3");
		$query = 'SELECT objid,pointnum FROM t_sector where sectornum='.$_SESSION['sect'];
		$result = mysqli_query($db,$query);

		while ($line = mysqli_fetch_row($result))
		{
			$objid=$line[0];
			$pointnum = $line[1];
			$x = $pointnum % 40;
			$y = ($pointnum-$x) / 40;
	
			$this->a[$y][$x] = 1;
		}
		
		$this->a[$this->ey][$this->ex]=0;
		
		//$this->sx = 4;//$_SESSION['CSX'];
		//$this->sy = 3;//$_SESSION['CSY'];
		//$this->ex = 2;//$_SESSION['FSX'];
		//$this->ey = 1;//$_SESSION['FSY'];
	}
	//4-шаг алгоритма
	public function alg_step()
	{
		//4_1. Выбираем вершину с минимальной оценкой среди открытых
		$minv=1000; $xminv=-1; $yminv = -1;
		for ($i=0;$i<40;$i++)
		{
			for ($j=0;$j<40;$j++)
			{
				if ( ($this->a[$i][$j] % 10 == 0) and ( (floor($this->a[$i][$j]/10) % 10) == 1) )
				{
					$temp = floor($this->a[$i][$j]/100);
					if ($temp<$minv)
					{
						$yminv = $i;
						$xminv = $j;
						$minv = $temp;
					}
				}
			}
		}

		if ($minv==1000)
		{
			return false;
		}
	
		$af0=floor($this->a[$yminv][$xminv]/100);
		$ah0 = $this->Dist($xminv,$this->ex,$yminv,$this->ey);
		$ag0 = $af0 - $ah0;

		//4_2. Для соседей этой вершины рассчитываем коэффициенты и меняем статус open/close
		for ($i=-1;$i<=1;$i++)
		{
			for ($j=-1;$j<=1;$j++)
			{
				if (($xminv+$j>=0)and($xminv+$j<40)and($yminv+$i>=0)and($yminv+$i<40)and($i*$i+$j*$j>0))
				{
					$temp = $this->a[$yminv+$i][$xminv+$j];
					if ( (floor($temp/10) % 10 < 2) and ($temp % 10 == 0) )
					{
						$incr = 10;
						if ($i*$i+$j*$j==2)
						{
							$incr = 14;
						}
						$agtmp = $ag0+$incr;
						$aftmp = $agtmp+$this->Dist($xminv+$j,$this->ex,$yminv+$i,$this->ey);
						if ( ($temp==0)or($temp>$aftmp*100) )
						{
							$this->a[$yminv+$i][$xminv+$j] = $aftmp*100+10+0;
						}
					}
				}
			}
		}
		$this->a[$yminv][$xminv]+=10;

		if (($yminv==$this->ey)and($xminv==$this->ex))
		{
			return false;
		}
		return true;
	}
	//5-само вычисление
	public function alg_calc()
	{
		$this->init_array();
		$this->alg_prep();
		
		if ($this->bad_start_end()==1)
		{
			return -1;
		}
		
		$this->a[$this->sy][$this->sx] = $this->Dist($this->sx,$this->ex,$this->sy,$this->ey)*100+10; 
		
		$b = true;
		while ($b)
		{
			$b = $this->alg_step();
		}
	
		return $this->a[$this->ey][$this->ex];
	}
}

$obj = new AlgAS();
//echo $obj->alg_calc();

?>
