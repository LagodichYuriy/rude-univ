var education =
{
	selector:    '#education-list',
	selector_ul: '#education-ul',

	disciplines:
	{
		database: null,

		set: function(database)
		{
			education.disciplines.database = database;
		},

		get: function()
		{
			return education.disciplines.database;
		}
	},

	filler:
	{
		database: null,
		data: [],
		id: null,
		report_id: null,

		popup: function(disciplines,data, id,report_id)
		{
			education.filler.database = disciplines;
			education.filler.id = id;
			education.filler.report_id = report_id;

			debug(data);

			for (var i = 0; i < data.length; i++)
			{
				if (typeof (education.filler.data[i])==='undefined'){
					education.filler.data[i]=[];
				}
				education.filler.data[i].push(data[i].split(','));
			}
			education.filler.update(education.filler.data);

			$('#filler-modal').modal('show').modal('cache sizes');

			setTimeout(function() {
				$('#filler-modal').modal('refresh');
			}, 750);
			education.filler.recount('input');
		},

		update: function(data)
		{
			var html = '';

			html += '<table class="ui basic table plan">';
			html += '<tbody>';
			html += '	<tr>';
			html += '		<td rowspan="4">';
			html += '		№ <nobr>п/п</nobr>';
			html += '		</td>';
			html += '		<td rowspan="4">Название цикла, интегрированного модуля, учебной дисциплины, курсовой работы (проекта)</td>';
			html += '		<td rowspan="4">Кафедра</td>';
				
			html += '		<td rowspan="1" colspan="9"><div>Количество академических часов</div></td>';
			html += '		<td rowspan="1" colspan="30"><div>Распределение по курсам и семестрам</div></td>';
			html += '	</tr>';
				
			html += '	<tr>';
			html += '		<td rowspan="3" class="rotate-box"><div class="rotate-270">Экзаменов</div></td>';
			html += '		<td rowspan="3" class="rotate-box"><div class="rotate-270">Зачётов</div></td>';
			html += '		<td rowspan="3" class="rotate-box"><div class="rotate-270">Курсовых проектов</div></td>';
			html += '		<td rowspan="3" class="rotate-box"><div class="rotate-270">Расчётных работ</div></td>';
			html += '		<td rowspan="3" class="rotate-box"><div class="rotate-270">Типовых расчётов / контрольных</div></td>';
			html += '		<td rowspan="3" class="rotate-box"><div class="rotate-270">Всего</div></td>';
				
			html += '		<td colspan="3">Из них</td>';
				
			html += '		<td colspan="6">I курс</td>';
			html += '		<td colspan="6">II курс</td>';
			html += '		<td colspan="6">III курс</td>';
			html += '		<td colspan="6">IV курс</td>';
			html += '		<td colspan="6">V курс</td>';

			html += '	</tr>';
			
			html += '	<tr>';
			html += '		<td rowspan="2" class="rotate-box medium"><div class="rotate-270">Лекции</div></td>';
			html += '		<td rowspan="2" class="rotate-box medium"><div class="rotate-270">Лабораторные</div></td>';
			html += '		<td rowspan="2" class="rotate-box medium"><div class="rotate-270">Семинары</div></td>';
				
			html += '		<td rowspan="2" colspan="3"><div>I семестр</div><div>17 недель</div></td>';
			html += '		<td rowspan="2" colspan="3"><div>II семестр</div><div>17 недель</div></td>';
			html += '		<td rowspan="2" colspan="3"><div>III семестр</div><div>17 недель</div></td>';
			html += '		<td rowspan="2" colspan="3"><div>IV семестр</div><div>17 недель</div></td>';
			html += '		<td rowspan="2" colspan="3"><div>V семестр</div><div>17 недель</div></td>';
			html += '		<td rowspan="2" colspan="3"><div>VI семестр</div><div>17 недель</div></td>';
			html += '		<td rowspan="2" colspan="3"><div>VII семестр</div><div>16 недель</div></td>';
			html += '		<td rowspan="2" colspan="3"><div>VIII семестр</div><div>16 недель</div></td>';
			html += '		<td rowspan="2" colspan="3"><div>IX семестр</div><div>16 недель</div></td>';
			html += '		<td rowspan="2" colspan="3"><div>X семестр</div><div>7 недель</div></td>';
			html += '	</tr>';

			html += '	<tr>';
			html += '	</tr>';

			html += '	<tr>';
			html += '		<td><b>1</b></td>';
			html += '		<td><b>2</b></td>';
			html += '		<td><b>3</b></td>';
			html += '		<td><b>4</b></td>';
			html += '		<td><b>5</b></td>';
			html += '		<td><b>6</b></td>';
			html += '		<td><b>7</b></td>';
			html += '		<td><b>8</b></td>';
			html += '		<td><b>9</b></td>';
			html += '		<td><b>10</b></td>';
			html += '		<td><b>11</b></td>';
			html += '		<td><b>12</b></td>';
			html += '		<td><b>13</b></td>';
			html += '		<td><b>14</b></td>';
			html += '		<td><b>15</b></td>';
			html += '		<td><b>16</b></td>';
			html += '		<td><b>17</b></td>';
			html += '		<td><b>18</b></td>';
			html += '		<td><b>19</b></td>';
			html += '		<td><b>20</b></td>';
			html += '		<td><b>21</b></td>';
			html += '		<td><b>22</b></td>';
			html += '		<td><b>23</b></td>';
			html += '		<td><b>24</b></td>';
			html += '		<td><b>25</b></td>';
			html += '		<td><b>26</b></td>';
			html += '		<td><b>27</b></td>';
			html += '		<td><b>28</b></td>';
			html += '		<td><b>29</b></td>';
			html += '		<td><b>30</b></td>';
			html += '		<td><b>31</b></td>';
			html += '		<td><b>32</b></td>';
			html += '		<td><b>33</b></td>';
			html += '		<td><b>34</b></td>';
			html += '		<td><b>35</b></td>';
			html += '		<td><b>36</b></td>';
			html += '		<td><b>37</b></td>';
			html += '		<td><b>38</b></td>';
			html += '		<td><b>39</b></td>';
			html += '		<td><b>40</b></td>';
			html += '		<td><b>41</b></td>';
			html += '		<td><b>42</b></td>';
			html += '	</tr>';


			for (var i = 0; i < education.filler.database.length; i++)
			{
				html += '<tr id="item-'+i+'">';

				html += '	<td>' + rude.romanize(i + 1) + '</td>';
				html += '	<td>' + education.filler.database[i] + '</td>';

				html += '	<td class="input item"><div class="ui form"><div class="inline field"><input class="20" type="text" maxlength="3" value="';
				html += data[i][0][0];

				html +='"></div></div></td>';

				for (var j = 0; j < 39; j++)
				{
					html += '	<td class="input item countable"><div class="ui form"><div class="inline field"><input onblur="education.filler.recount(this)" onkeyup="education.filler.recount(this)" class="20" type="text" maxlength="3" value="';
					html += data[i][0][j+1];

					html +='"></div></div></td>';
				}

				html += '</tr>';
			}


			html += '<tr class="empty no-border"><td class="no-border" colspan="42"></td></tr>';


			html += '<tr class="result">';

			html += '<td colspan="3">Итого:</td>';

			for (i = 0; i < 39; i++)
			{
				html += '<td>0</td>';
			}

			html += '</tr>';


			html += '</tbody>';
			html += '</table>';

			html += '<div class="ui divider"></div><div class="ui green submit button small" onclick="education.filler.save();">Сохранить</div>';


			$('#filler-modal .content').html(html);

			$('.rotate-270').rotate(270);
		},

		save: function()
		{

			var disciplines = education.filler.database;
			var id = education.filler.id;
			var report_id = education.filler.report_id;

			var values = [];
			var selector_table = $('input').closest('table');
			selector_table.find('td.item input').each(function() {
				values.push($(this).val());
			});

			debug(values);

			$.ajax(
				{
					url: '/?page=reports-edit&task=save_education&ajax=true',

					type: 'POST',

					data:
					{
						data: values,
						item_id: id,
						report_id: report_id
					},

					success: function (data)
					{
						console.log(data);
						window.location.reload();
					}
				});
			//debug(disciplines);

		},



		recount: function(selector)
		{
			var result = [];

			var selector_table = $(selector).closest('table');

			selector_table.find('td.countable input').each(function() {
					result.push($(this).val());
			});



			for (var i = 0; i < 39; i++)
			{
				var sum = 0;

				for (var j = 0; j < (result.length / 39); j++)
				{
					var val = parseInt(result[i + (j * 39)]);

					if (isNaN(val))
					{
						continue;
					}

					sum += val;
				}


				var selector_td = selector_table.find('tr.result td:eq(' + (i + 1) + ')');

				selector_td.html(sum);

				if (sum == 0)
				{
					selector_td.addClass('empty').removeClass('non-empty');
				}
				else
				{
					selector_td.addClass('non-empty').removeClass('empty');
				}
			}

			return result;
		},

		get: function(selector)
		{
			var result = [];

			$(selector).closest('.disciplines').find('li').each(function(){
				result.push($(this).attr('data-name'));

			});

			return result;
		},
		getdata: function(selector)
		{
			var result = [];

			$(selector).closest('.disciplines').find('li').each(function(){
				result.push($(this).attr('data-values'));

			});

			return result;
		},

		getid: function(selector)
		{
			var result = [];

			$(selector).closest('.disciplines').find('li').each(function(){
				result.push($(this).attr('data-id'));
			});

			return result;
		}
	},

	add: function(name,id)
	{
		var subclass = '';


		subclass += '<li class="disciplines" data-id='+id+'>';

		subclass += '<div class="actions">';
		subclass += '	<div class="ui button red tiny" onclick="$(this).closest(\'li\').fadeToggle(\'slow\', function() { $(this).closest(\'li\').remove(); buttons.update(); });">Удалить</div><div class="ui button blue tiny" onclick="education.filler.popup(education.filler.get(this), $(this).closest(\'.disciplines\').find(\'.description\').html());">Заполнить</div>';
		subclass += '</div>';

		subclass += '	<div class="base" onclick="$(this).parent(\'li\').find(\'.tip\').toggle(\'slow\'); $(this).find(\'i.icon.triangle\').toggleClass(\'down\').toggleClass(\'right\')">';
		subclass += '		<i class="icon triangle down"></i>';

		subclass += '		<span class="description">' + name + '</span>';
		subclass += '	</div>';

		subclass += '   <div class="tip">';


		subclass += '		<ul></ul>';


		subclass += '		<div class="ui selection dropdown">';
		subclass += '			<input type="hidden" name="selected">';
		subclass += '			<div class="default text">Выберите наименование</div>';
		subclass += '			<i class="dropdown icon"></i>';

		subclass += '			<div class="menu">';

		for (var i = 0; i < education.disciplines.database.length; i++)
		{
			var subclass_type = education.disciplines.database[i][0];
			var subclass_name = education.disciplines.database[i][1];
			var subclass_id   = education.disciplines.database[i][2];

			subclass += '			<div class="item" data-type="' + subclass_type + '" data-name="' + subclass_name + '" data-id="' + subclass_id + '" data-value="' + i + '">' + education.disciplines.database[i][1] + '</div>';
		}

		subclass += '			</div>';
		subclass += '		</div>';

		subclass += '		<div class="item ui button green" onclick="add_education_item('+id+',this);">добавить</div>';

		subclass += '	</div>';

		subclass += '</li>';


		$(education.selector_ul).append(subclass);


		rude.semantic.init.dropdown();
	},

	update: function() // update sortable list
	{
//		$(education.selector_ul).sortable();
	},

	tip:
	{
		add: function(selector,id)
		{
			var selector_tip = $(selector).closest('.tip');

			var selector_item = selector_tip.find('.item.active');

			var type = selector_item.attr('data-type');
			var name = selector_item.attr('data-name');
			//var id   = selector_item.attr('data-id');

			console.log(type);
			console.log(name);
			console.log(id);

			selector_tip.find('ul').append('<li data-type="' + type + '" data-name="' + name + '" data-id="' + id + '" data-values=",,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,">' + name + '<i class="icon angle up" onclick="education.tip.move.up(this);"></i> <i class="icon angle down" onclick="education.tip.move.down(this);"></i></li>').sortable();
		},

		toggle: function(selector)
		{
			if (!$(selector).find('.tip').is(':empty'))
			{
				$(selector).find('i.triangle').toggleClass('down').toggleClass('right');

				$(selector).find('.tip').slideToggle('slow');
			}
		},

		move:
		{
			up: function(selector)
			{
				var a = $.Deferred();
				var b = $.Deferred();

				var one = $(selector).parent();
				var two = $(selector).parent().prev();

				one.fadeOut('slow', function() { a.resolve(); });
				two.fadeOut('slow', function() { b.resolve(); });

				$.when(a, b).done(function()
				{
					one.insertBefore(two);

					one.fadeIn('slow');
					two.fadeIn('slow');
				});
			},

			down: function(selector)
			{
				var a = $.Deferred();
				var b = $.Deferred();

				var one = $(selector).parent();
				var two = $(selector).parent().next();

				one.fadeOut('slow', function() { a.resolve(); });
				two.fadeOut('slow', function() { b.resolve(); });

				$.when(a, b).done(function()
				{
					one.insertAfter(two);

					one.fadeIn('slow');
					two.fadeIn('slow');
				});
			}
		}
	}

//	buttons:
//	{
//		update: function()
//		{
//			$(function()
//			{
//				     if (list.get().length > 0) { $('#button-save').removeClass('disabled'); }
//				else                            { $('#button-save').addClass('disabled');    }
//			});
//		}
//	}
};