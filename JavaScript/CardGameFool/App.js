var currcard = -1;
var EndGame = false;

function cl_plcard(e)//Выбор карты игроком
{
	if (EndGame==true) {alert("Игра закончена. Чтобы начать новую, обновите страницу"); return;}
	if (YourHod == 0)
	{
		alert("Сейчас ходите не вы. Нажмите кнопку ход компьютера");
		return;
	}

	currcard = e.target.id;
	alert("Выбрана карта "+currcard);
}


function PlCards(props)//Вывод информации о массиве карт
{
	const plcards = props.plcards;
	const plcardItems = plcards.map( (onecard) =>
		<img src = {onecard.src} id={onecard.id}  key= {Math.random()} onClick={ (e) => cl_plcard(e) } />
	);
	return (<div>{plcardItems}</div>);
}


function ActCards(props)//Вывод информации о массиве карт
{
	const plcards = props.plcards;
	const plcardItems = plcards.map( (onecard) =>
		<img src = {onecard.src} id={onecard.id}  key= {Math.random()} />
	);
	return (<div>{plcardItems}</div>);
}


class App extends React.Component{//Основной компонент
	constructor(){
		super();
		this.state = {
			cozyrcard: "bmp\\6_0.bmp",
			colodacardc: 24,
			compcardc: 6,
			plcardsc: 6,
			plcards: [
				{id:0, num:0, src: "bmp\\6_0.bmp"},
				{id:1, num:0, src: "bmp\\6_0.bmp"},
				{id:2, num:0, src: "bmp\\6_0.bmp"},
				{id:3, num:0, src: "bmp\\6_0.bmp"},
				{id:4, num:0, src: "bmp\\6_0.bmp"},
				{id:5, num:0, src: "bmp\\6_0.bmp"}
				],
			compcards: [
				{id:0, num:0, src: "bmp\\6_0.bmp"},
				{id:1, num:0, src: "bmp\\6_0.bmp"},
				{id:2, num:0, src: "bmp\\6_0.bmp"},
				{id:3, num:0, src: "bmp\\6_0.bmp"},
				{id:4, num:0, src: "bmp\\6_0.bmp"},
				{id:5, num:0, src: "bmp\\6_0.bmp"}
				],				
			actplcards : [],
			actcocards: []
			};
		MakeColoda();
	}

	
	ImageSrc(index)//функция ( номер карты => строка bmp файла )
	{
		var mast = index % 4, num = Math.floor(index/4)+6;
		return "bmp\\"+num+'_'+mast+'.bmp';
	}
	
		
	componentDidMount()//загрузка компонента, происходит как раз после функции MakeColoda
	{
		var s=this.ImageSrc(cozyr);
		this.setState({ cozyrcard : s });
		this.setState({ colodacardc : 36-marker });
		this.setState({ compcardc : 6 });

		var TempArray = this.state.plcards;
		for (var i=0;i<6;i++)
		{
			const s = this.ImageSrc(coloda[i]);
			TempArray[i].num = coloda[i];
			TempArray[i].src = s;
		}
		this.setState( {plcards : TempArray } );

		TempArray = this.state.compcards;
		for (var i=0;i<6;i++)
		{
			const s = this.ImageSrc(coloda[i+6]);
			TempArray[i].num = coloda[i+6];
			TempArray[i].src = s;
		}
		this.setState( {compcards : TempArray } );
	}


	can_throw()//Проверка на то может ли игрок кинуть указанную карту
	{

		if ((YourAttack==1)&&(HodNum<2))
		{
			//если ничего нет среди активных карт то можно кидать любую карту, а иначе смотрим первую карту там и сравниваем и ним текущую карту
			if (this.state.actplcards.length == 0) 
				{ return true; }
			const num1 = this.state.plcards[currcard].num;
			const num2 = this.state.actplcards[0].num;
			if (Math.floor(num1/4)==Math.floor(num2/4))
				{ return true; }
			else
				{ return false; }
		}

		if ((YourAttack==1)&&(HodNum>=2))//мы смотрим совпадение нулевой карты активной своей+ все карты врага
		{
			var num1 = Math.floor(this.state.plcards[currcard].num/4);//num1 это текущая карта
			var TempArray = this.state.actcocards;
			var b=false;
			//если ничего нет среди активных карт то можно кидать любую карту, а иначе смотрим первую карту там и сравниваем и ним текущую карту
			if (num1==Math.floor(this.state.actplcards[0].num/4))
				{b=true;}
			for (var i=0;i<TempArray.length;i++)
			{
				if (Math.floor(TempArray[i].num/4)==num1)
					{b=true;}
			}

			return b;
		}

		if (YourAttack==0)//игрок должен отбить карту которая еще не отбита
		{
			var Index=this.state.actplcards.length;
			var num1 = this.state.actcocards[Index].num;//та карта которую нужно отбить
			var num2 = this.state.plcards[currcard].num;//та карта которой мы пытаемся отбить
			if ((num1 % 4)==(num2 % 4))
			{
				if (Math.floor(num1)<Math.floor(num2))
					{ return true;}
				else
					{ return false;}
			}

			if ((num2 % 4)==(cozyr % 4))
				{return true;}
			else
				{ return false;}

		}
	}

	
	cl_throw()
	{
		if (EndGame) {alert("Игра закончена. Чтобы начать новую, обновите страницу"); return;}
		if (currcard==-1)
		{
			alert("Выберите карту");
			return;
		}
		if (!this.can_throw()) 
		{
			alert("Указанную карту кинуть нельзя");
			return;
		}

		if ( (this.state.actplcards.length-this.state.actcocards.length)>=this.state.compcards.length )
		{
			alert("Карту кинуть нельзя. У компьютера нет столько карт чтобы отбить ваши");
			return;
		}

		var TempArray = this.state.plcards;
		const new_src = TempArray[currcard].src;
		const new_num = TempArray[currcard].num;
		TempArray.splice(currcard,1);

		for (var i=0;i<TempArray.length;i++)
		{
			
			TempArray[i].id = i;
		}
		this.setState( {plcards : TempArray } );

		var TempArray2=this.state.actplcards;
		var TempItem2 = {id : TempArray2.length, num: new_num, src: new_src};
		TempArray2.push(TempItem2);
		this.setState( {actplcards: TempArray2} );
		currcard = -1;
	}


	cl_comphod()
	{
		if (EndGame) {alert("Игра закончена. Чтобы начать новую, обновите страницу"); return;}
		//Проверки на то что можно передавать ход компьютеру
		if ((YourHod==1)&&(YourAttack==1))
		{
			if (this.state.actplcards.length == 0)
			{
				alert("Сначала необходимо кинуть одну или несколько карт");
				return;
			}

			if (this.state.actplcards.length == this.state.actcocards.length)
			{
				alert("Компьютер уже походил. Ваша очередь");
				return;
			}			
		}


		if ((YourHod==1)&&(YourAttack==0))
		{
			if (this.state.actplcards.length < this.state.actcocards.length)
			{
				alert("Сначала необходимо отбить все кинутые компьютером карты");
				return;
			}
		}
		if ((YourAttack==1)||(HodNum>0))
			{HodNum++;}
		
		
		if (YourAttack == 1)
		{
			alert("Компьютер отбивает ваши карты");
			var TempArray = this.state.actplcards;
			for (var i=this.state.actcocards.length;i<TempArray.length;i++)
			{
				const num1 = TempArray[i].num;
				//стратегия такая - выбираем лучшую(самую минимальную) карту которой можно отбить указанную в порядке обычные карты 
				//- козыря+20 та же масть +0 , другая масть *0
				var TempArray2 = this.state.compcards;
				var imin = -1, vmin = 100;

				for (var j=0;j<TempArray2.length;j++)
				{
					const num2 = TempArray2[j].num;
					var tmp = 100;
					if ( (num2 % 4) == (num1 % 4) ) 
						{tmp = 6 + Math.floor(num2/4);}
					if ( (num2 % 4) == (cozyr % 4) ) 
						{tmp = 26 + Math.floor(num2/4);}
					if ( (tmp<6+Math.floor(num1/4)) && ((num1 % 4) != (cozyr % 4)) )
						{tmp = 100;}
					if ( (tmp<26+Math.floor(num1/4)) && ((num1 % 4) == (cozyr % 4)) )
						{tmp = 100;}					


					if (tmp<vmin)
					{
						vmin=tmp;
						imin=j;
					}
				}

				if (imin == -1)
				{
					alert("Компьютер не может отбить ваши карты. Он их забирает");
					this.comp_zabrat();
					return;
				}

				
				const new_src = TempArray2[imin].src;
				const new_num = TempArray2[imin].num;
				TempArray2.splice(imin,1);

				for (var j=0;j<TempArray2.length;j++)
					{ TempArray2[j].id = j; }
				this.setState( {compcards : TempArray2 } );
				this.setState( {compcardc : TempArray2.length } );

				var TempArray3=this.state.actcocards;
				var TempItem3 = {id : TempArray3.length, num: new_num, src: new_src};
				TempArray3.push(TempItem3);
				this.setState( {actcocards: TempArray3} );
				imin = -1;

			}
		} //далее не забыть что еще кроме обычного хода есть реагирование на то что у вас есть такая же карта компьютер будет кидать все кроме козырей
		else if ( (YourAttack == 0) && (HodNum<2) )
		{
			alert("Компьютер ходит");

			var TempArray = this.state.compcards;
			var repeat_bonus = new Set();
			var imin = -1, vmin = 100;
			//сначала определяем какую карту будет подкидывать
			for (var i=0;i<TempArray.length;i++)
			{
				var num1=6+Math.floor(TempArray[i].num/4);
				
				if ((TempArray[i].num % 4)==(cozyr % 4))
					{num1+=20;}
				if (repeat_bonus.has(TempArray[i].num))
					{ num1-=3;}
				if (num1<vmin)
				{
					imin=i;
					vmin=num1;
				} //alert("i="+i+"num1="+num1);
				repeat_bonus.add(TempArray[i].num);
			} //alert("imin="+imin+"vmin="+vmin);

			var num2 = TempArray[imin].num;
			var num3 = 0;
			if ((num2 % 4) == (cozyr % 4))
				{num3=1;}
			for (var i=TempArray.length-1;i>=0;i--)//специально в обратну сторону потому что может получится что иначе проскочим возможное значение
			{
				var num1 = TempArray[i].num;
				if ( (Math.floor(num1/4) == Math.floor(num2/4)) && ( (num1 % 4 != cozyr % 4) || (num3==1) ) )
				{
					//тогда мы эту карту отбираем в активные
					//alert("i="+i);
					var TempArray3=this.state.actcocards; //alert("length="+TempArray3.length);
					var TempItem3 = {id : TempArray3.length, num: num1, src: this.ImageSrc(num1)};
					TempArray3.push(TempItem3);
					this.setState( {actcocards: TempArray3} );

					TempArray.splice(i,1);
					for (var j=0;j<TempArray.length;j++)
						{ TempArray[j].id = j; }					
					this.setState( {compcards: TempArray} );
				}
			}
		}
		else if ( (YourAttack == 0) && (HodNum>=2) )
		{
			//здесь компьютер подкидывает карты
			alert("Компьютер подкидывает карты");
			var used_cards = new Set();
			var num1 = 6+(this.state.actcocards[0].num/4);
			var co = 0;
			used_cards.add(num1);
			var TempArray = this.state.actplcards;
			for (var i =0; i<TempArray.length;i++)
			{
				num1 = 6+Math.floor(TempArray[i].num/4);
				used_cards.add(num1);
			}

			TempArray = this.state.compcards;
			for (var i=TempArray.length-1;i>=0;i--)
			{
				num1=6+Math.floor(TempArray[i].num/4);
				var b = true;
				if ((TempArray[i].num % 4) == (cozyr % 4)) {b=false;}
				if (marker>=35) {b=true;}
				if ( (this.state.actcocards.length-this.state.actplcards.length)>=this.state.plcards.length )
					{b=false;}
				if ( used_cards.has(num1) && b )
				{//добавляем в активные карты компьютера, удаляем из колоды компьютера
					var TempArray2 = this.state.actcocards;
					var TempItem2 = {id: TempArray2.length, num : TempArray[i].num, src : TempArray[i].src};
					TempArray.splice(i,1);
					TempArray2.push(TempItem2);
					this.setState( {actcocards:TempArray2} );
					this.setState({compcards: TempArray});
					co++;
				}
			}
			

			if (co==0)
			{
				alert("Компьютер не может ничего подкинуть. Сбрасываем карты.");
				this.sbros();
				YourAttack=1;
				YourHod=1;
				HodNum=0;
				alert("Ход передается игроку");
				return;
			}
		}
		YourHod = 1;
		HodNum++;
	}
	

	cl_zabrat()//кнопка забрать- если ее нажимает игрок
	{
		if (EndGame) {alert("Игра закончена. Чтобы начать новую, обновите страницу"); return;}

		if (YourAttack==1)
			{return;}
		
		var TempArray = this.state.plcards;
		var TempArray2 = this.state.actplcards;
		var TempArray3 = this.state.actcocards;
		var j=TempArray.length;

		for (var i=0;i<TempArray2.length;i++)
		{
			var TempItem = {id: j, num: TempArray2[i].num, src: TempArray2[i].src}
			TempArray.push(TempItem);
			j++;
		}
		for (var i=0;i<TempArray3.length;i++)
		{
			var TempItem = {id: j, num: TempArray3[i].num, src: TempArray3[i].src}
			TempArray.push(TempItem);
			j++;
		}
		TempArray2.splice(0,TempArray2.length);
		TempArray3.splice(0,TempArray3.length);

		this.setState({plcards:TempArray});
		this.setState({actplcards:TempArray2});
		this.setState({actcocards:TempArray3});

		this.sbros();
		HodNum = 0;
		YourHod = 0;
		YourAttack = 0;
		alert("Ход передается компьютеру");
	}


	comp_zabrat()
	{
		var TempArray = this.state.compcards;
		var TempArray2 = this.state.actplcards;
		var TempArray3 = this.state.actcocards;
		var j=TempArray.length;

		for (var i=0;i<TempArray2.length;i++)
		{
			var TempItem = {id: j, num: TempArray2[i].num, src: TempArray2[i].src}
			TempArray.push(TempItem);
			j++;
		}
		for (var i=0;i<TempArray3.length;i++)
		{
			var TempItem = {id: j, num: TempArray3[i].num, src: TempArray3[i].src}
			TempArray.push(TempItem);
			j++;
		}
		TempArray2.splice(0,TempArray2.length);
		TempArray3.splice(0,TempArray3.length);

		this.setState({compcards:TempArray});
		this.setState({actplcards:TempArray2});
		this.setState({actcocards:TempArray3});

		this.sbros();
		HodNum = 0;
		YourHod = 1;
		YourAttack = 1;
		alert("Ход передается игроку");
	}


	cl_sbros()
	{
		if (EndGame) {alert("Игра закончена. Чтобы начать новую, обновите страницу"); return;}
		if (YourAttack==0)
		{
			alert("Ходит компьютер. Только он может сбросить карты");
			return;
		}
		this.sbros();
		YourAttack=0;
		YourHod=0;
		HodNum=0;
		alert("Ход передается компьютеру");
	}


	sbros()
	{
		//очищаем активные карты
		var EmptyArray = this.state.actplcards;
		EmptyArray.splice(0,EmptyArray.length);
		this.setState( {actplcards: EmptyArray} );
		EmptyArray = this.state.actcocards;
		EmptyArray.splice(0,EmptyArray.length);
		this.setState({actcocards: EmptyArray});
		//добавляем игроку и компьютеру карт
		var TempArray = this.state.plcards;
		var TempArray2 = this.state.compcards;
		var i=TempArray.length,j=TempArray2.length;
		//alert("i="+i+" j="+j+" marker="+marker);
		
		while ( ((i<6)||(j<6)) && (marker<36) )
		{  //alert("i="+i+" j="+j+" marker="+marker);

			if ((i<6)&&(marker<35)&&(YourAttack==1))
			{
				var num1 = coloda[marker];
				marker++;
				var TempItem = {id:i , num: num1, src: this.ImageSrc(num1)};
				TempArray.push(TempItem);
				i++;
			}

			if ((j<6)&&(marker<36))
			{
				var num2 = coloda[marker];
				marker++;
				var TempItem2 = {id:j , num: num2, src: this.ImageSrc(num2)};
				TempArray2.push(TempItem2);
				j++;
			}

			if ((i<6)&&(marker<36)&&(YourAttack==0))
			{
				var num1 = coloda[marker];
				marker++;
				var TempItem = {id:i , num: num1, src: this.ImageSrc(num1)};
				TempArray.push(TempItem);
				i++;
			}			
		}
		this.setState( {plcards: TempArray} );
		this.setState( {compcards: TempArray2} );
		this.setState({ colodacardc : 36-marker });
		this.setState( {compcardc: TempArray2.length} );

		this.wincheck();
	}

	wincheck()//проверка на победу, вызывается после кнопки сброс
	{
		if (marker!=36) {return;}
		if ((this.state.plcards.length>0)&&(this.state.compcards.length>0)) {return;}
		if ((this.state.plcards.length==0)&&(this.state.compcards.length==0))
		{
			alert("Ничья");
			EndGame=true;
			return;
		}
		if (this.state.plcards.length==0)
		{
			alert("Вы победили");
			EndGame=true;
			return;
		}
		if (this.state.compcards.length==0)
		{
			alert("Вы проиграли");
			EndGame=true;
			return;
		}		
	}


//				<p> Для читерства и тестирования - карты компьютера</p>
//				<ActCards plcards = {this.state.compcards} />

	
	render(){//условимся что игрок отбивает карты по очереди, отбил нажимает ок, далее компьютер принимает ход и подбрасывает карты
		return (
			<div className = "App">
				<p>Количество карт в колоде = {this.state.colodacardc}</p>
				Козырь - <img src={this.state.cozyrcard} />
				<p>Количество карт у компьютера = {this.state.compcardc}</p>
				<p>У вас на руке следующие карты</p>
				<PlCards plcards = {this.state.plcards} />
				<button id="btn_throw" onClick={ () => this.cl_throw() }>Кинуть карту</button>
				<button id="btn-comphod" onClick={ () => this.cl_comphod() }>Ход компьютера</button>
				<button id="btn-sbros" onClick={ () => this.cl_sbros() }>Сбросить</button>
				<button id="btn-zabrat" onClick={ () => this.cl_zabrat() }>Забрать</button>
				
				<p>Ваши активные карты</p>
				<ActCards plcards = {this.state.actplcards} />
				<p>Активные карты компьютера</p>
				<ActCards plcards = {this.state.actcocards} />

				<p> Для читерства и тестирования - карты компьютера</p>
				<ActCards plcards = {this.state.compcards} />
			</div>
		)
	}
}

	
ReactDOM.render(<App />, document.getElementById('root'));
