<!Doctype html>
<html>

<head>
<meta charset="utf-8">
<title>Search</title>
<style>

.menu > li {
list-style-type: none;
border: 1px solid black;
width: 240px;
height: 40px;
text-align: center;
float: left;
line-height: 40px;
}

.menu li ul li {
list-style-type: none;
border: 1px solid black;
width: 240px;
height: 40px;
}

.menu li ul {
display: none;
padding: 0;
}

.menu > li:hover ul {
display: block;
}

</style>
</head>
<body>
<ul class="menu">
<li>Малый Бизнес
<ul>
<li>Ларёк</li>
<li>Доставка по городу</li>
</ul>
</li>
<li>Средний бизнес
<ul>
<li>Склад</li>
<li>Доставка по региону</li>
</ul>
</li>
<li>Предприятия
<ul>
<li>Промышленные предприятия</li>
<li>Доставка по стране и миру</li>
</ul>
</li>
</ul>

<br/><br/><br/><br/><br/><br/><br/><br/><br/>


<form action="select.php">

<p>Обьём печати</p><br/>
<input class="56mm" type="radio" name="tips" value="min">от 1 до 3 000 маркировок 56mm<br/>
<input class="56mm" type="radio" name="tips" value="mid">от 3 000 до 10 000 маркировок 56mm<br/>
<input class="56mm" type="radio" name="tips" value="max">от 10 000 маркировок и больше 56mm<br/>
<input class="120mm" type="radio" name="tips" value="min">от 1 до 3 000 маркировок 120mm<br/>
<input class="120mm" type="radio" name="tips" value="mid">от 3 000 до 10 000 маркировок 120mm<br/>
<input class="120mm" type="radio" name="tips" value="max">от 10 000 маркировок и больше 120mm<br/>

<p>Какая температура в месте исспользования принтера:</p><br/>
<input type="radio" name="temp" value="cold">от -25 до 0<br/>
<input type="radio" name="temp" value="mid">от -0 до 25<br/>
<input type="radio" name="temp" value="hot">от 25 до 45<br/>
<input type="radio" name="temp" value="shot">от 45 до 75<br/>
<p>Доп Функционал</p><br/>
<input type="radio" name="temp" value="cold">от -25 до 0<br/>
<input type="radio" name="temp" value="mid">от -0 до 25<br/>
<input type="radio" name="temp" value="hot">от 25 до 45<br/>
<input type="radio" name="temp" value="shot">от 45 до 75<br/>
</form>

</body>

 

</html>

 

<!--
Ориентированость на средний и малый бизнес
подготовить УТП на Них

Малый бизнес
Обьём печати в день : от 1 до 1000 в размере 120 мм или до 3000 в размере 56 мм
Оптимальный выбор : Класс E Mark III или Workstation



Средний бизнес
Обьём печати в день : от 1000 до 10000 в размере 56 и 120 мм



Крупный бизнес
Обьём печати в день : от 10000 до NaN




Доп Опции

Температура в помещении : (радиобатоны)
Для работы в Холодных помещениях : от -25 до 0 (вариант 1)
Для работы в Провертиваемых помещениях : от -0 до 25 (вариант 2)
Для работы в Горячих помещениях от 25 до 45 (вариант 3)
Для маркировки Горячей продукции(кондитерка и т д ) От 45 до 75 (Вариант 4)

Если температура в помещении - 
вариант 1 , то учитывать принтеры с рабочей температурой по варианту 1 (И т д по всем вариантам)

Требуется ли ускоренная печать ? ЕСЛИ-ДА!{ТО предложить принтеры с этой возможностью} ЕСЛИ-НЕТ!{null}
-->
