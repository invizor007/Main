<?php
function iip($a,$b)
{
	if ($a==0) return 0;
	else return $a+$b;
}

$db = mysqli_connect("localhost","pma","","bg1");
if (mysqli_connect_errno()) 
{
	echo "Connect failed: %s\n".mysqli_connect_error();
	exit();
}

for ($i=1;$i<=200;$i++)
{
	$c=0;$p=0;
	for ($j=0;$j<8;$j++)
	{
		$mas[$j] = rand(0,3);
		if ( ($i>100) and (rand(0,1)==1) )
			{$mas[$j]=0;}
		switch ($mas[$j])
		{
			case 1: $p+=4;break;
			case 2: $p+=7;break;
			case 3: $p+=10;break;
		}
		if ($mas[$j] != 0)
		{
			$c++;
		}
	}
	
	if ($c==0)
	{
		$mas[0] = rand(1,3);
	}
	
	$mas[8]=rand(1,4)*5;
	$p+=$mas[8]/2;
	
	$query = 'INSERT INTO t_neutral (id,m1,m2,m3,a1,a2,a3,c1,c2,t,res_n,res_v) VALUES ('.$i.','.iip($mas[0],1).','.iip($mas[1],1).','.iip($mas[2],1).
		','.iip($mas[3],4).','.iip($mas[4],4).','.iip($mas[5],4).','.iip($mas[6],7).','.iip($mas[7],7).','.($mas[8]).','.rand(1,4).','.$p.')';
	$result = mysqli_query($db,$query);
}
?>