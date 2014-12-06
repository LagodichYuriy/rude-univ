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
		popup: function(disciplines)
		{
			$('.content').html('');
			for (var i=0; i<disciplines.length; i++){
				$('.content').append(disciplines[i]);
			}
			$('#filler-modal').modal('show');


		},
		get: function(selector)
		{
			var result = [];

			$(selector).closest('.disciplines').find('li').each(function(){
				result.push($(this).attr('data-name'));
			});

			return result;
		}
	},

	add: function(name)
	{
		var subclass = '';


		subclass += '<li class="disciplines">';

		subclass += '<div class="actions">';
		subclass += '	<div class="ui button red tiny" onclick="$(this).closest(\'li\').fadeToggle(\'slow\', function() { $(this).closest(\'li\').remove(); buttons.update(); });">Удалить</div><div class="ui button blue tiny" onclick="education.filler.popup(education.filler.get(this));">Заполнить</div>';
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

		subclass += '		<div class="item ui button green" onclick="education.tip.add(this)">добавить</div>';

		subclass += '	</div>';

		subclass += '</li>';


		$(education.selector_ul).append(subclass);


//		education.update();

		rude.semantic.init.dropdown();
	},

	update: function() // update sortable list
	{
//		$(education.selector_ul).sortable();
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

			selector_tip.find('ul').append('<li data-type="' + type + '" data-name="' + name + '" data-id="' + id + '">' + name + '<i class="icon angle up" onclick="$(this).parent().insertBefore($(this).parent().prev());"></i> <i class="icon angle down" onclick="$(this).parent().insertAfter($(this).parent().next());"></i></li>').sortable();


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