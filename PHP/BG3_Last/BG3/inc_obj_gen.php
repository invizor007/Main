<?php

function clear_objs()
{
	$db = mysqli_connect("localhost","bg3user","","bg3");
	$query = 'DELETE FROM t_sector where 1=1';
	$result = mysqli_query($db,$query);
}

function init_objs()
{
	$db = mysqli_connect("localhost","bg3user","","bg3");
	$query2 = 'SELECT count(*) FROM t_sector where 1=1';
	$result2 = mysqli_query($db,$query2);
	$line2 = mysqli_fetch_row($result2);
	$currobjcount = $line2[0];
	
	for ($i=0;$i+$currobjcount<$_SESSION['objcount'];$i++)
	{
		$objid = rand(1,$_SESSION['objtypecount']);
		$tmpsec = rand(0,1599);
		$tmppoint = rand(0,1599);
		$query = 'INSERT INTO t_sector (objid,sectornum,pointnum) VALUES ('.$objid.','.$tmpsec.','.$tmppoint.')';
		$result = mysqli_query($db,$query);
	}
	return 0;
}

function update_objs()
{
	$db = mysqli_connect("localhost","bg3user","","bg3");
	$query2 = 'SELECT count(*) FROM t_sector where 1=1';
	$result2 = mysqli_query($db,$query2);
	$line2 = mysqli_fetch_row($result2);
	$currobjcount = $line2[0];
	
	$co=0;
	if ($currobjcount<$_SESSION['objcount']) {$co=1;}
	if (3*$currobjcount<2*$_SESSION['objcount']) {$co=2;}
	
	for ($i=0;$i<$co;$i++)
	{
		$objid = rand(1,$_SESSION['objtypecount']);
		$tmpsec = rand(0,1599);
		$tmppoint = rand(0,1599);
		
		$query = 'SELECT count(*) FROM t_sector where sectornum='.$tmpsec.' AND pointnum='.$tmppoint;
		$result = mysqli_query($db,$query);
		$line = mysqli_fetch_row($result);
		
		if ($line[0]==0)
		{
			$query = 'INSERT INTO t_sector (objid,sectornum,pointnum) VALUES ('.$objid.','.$tmpsec.','.$tmppoint.')';
			$result = mysqli_query($db,$query);	
		}
	
	}
}

function delete_obj($snum,$pnum)
{
	$db = mysqli_connect("localhost","bg3user","","bg3");
	$query = 'DELETE FROM t_sector where sectornum='.$snum.' AND pointnum='.$pnum;
	$result = mysqli_query($db,$query);	
}

?>