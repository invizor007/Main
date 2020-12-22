var coloda=[];
var marker=0, cozyr = 0, YourHod = 1, HodNum = 0, YourAttack = 1;

function MakeColoda()
{
	var b = true, r=0;
	var used_cards = new Set();
	used_cards.clear();
	for (var i=0;i<36;i++)
	{
		do
		{
			r = Math.floor(Math.random()*36);
			b = used_cards.has(r);
		}
		while (b==true)

		used_cards.add(r);
		coloda.push(r);
		marker = 12;
    
		if (i==35)
			{ cozyr = r; }
	}
}
