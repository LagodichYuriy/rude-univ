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

	add: function(name)
	{
		var subclass = '';


		subclass += '<li>';

		subclass += '	<div class="base">';
		subclass += '		<i class="icon triangle down"></i>';

		subclass += '		<span class="description">' + name + '</span>';

		subclass += '		<i class="delete icon right" onclick="$(this).closest(\'li\').fadeToggle(\'slow\', function() { $(this).closest(\'li\').remove(); buttons.update(); });"></i>';
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

		subclass += '		<div class="item ui button green" onclick="education.tip.add(this)">добавить</div>';

		subclass += '	</div>';

		subclass += '</li>';


		$(education.selector_ul).append(subclass);


		education.update();

		rude.semantic.init.dropdown();
	},

	update: function() // update sortable list
	{
		$(education.selector_ul).sortable();
	},

	tip:
	{
		add: function(selector)
		{
			var selector_tip = $(selector).closest('.tip');

			var selector_item = selector_tip.find('.item.active');

			var type = selector_item.attr('data-type');
			var name = selector_item.attr('data-name');
			var id   = selector_item.attr('data-id');

			console.log(type);
			console.log(name);
			console.log(id);

			selector_tip.find('ul').append('<li data-type="' + type + '" data-name="' + name + '" data-id="' + id + '">' + name + '<i class="icon angle up" onclick="$(this).parent().insertBefore($(this).parent().prev());"></i> <i class="icon angle down" onclick="$(this).parent().insertAfter($(this).parent().next());"></i></li>');
		},

		toggle: function(selector)
		{
			if (!$(selector).find('.tip').is(':empty'))
			{
				$(selector).find('i.triangle').toggleClass('down').toggleClass('right');

				$(selector).find('.tip').slideToggle('slow');
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