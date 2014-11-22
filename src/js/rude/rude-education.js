var education =
{
	selector: '#education-list',

	disciplines:
	{
		database: null,

		set: function(database)
		{
			education.disciplines.database = database;
		},

		get: function()
		{
			if (education.disciplines.database !== null)
			{
				return education.disciplines.database;
			}

			$.ajax(
			{
				url: '/?page=reports-edit&task=update&ajax=true',

				data:
				{
					report_id:           report_id,

					year:                report.year,
					duration:            report.duration,
					rector:              report.rector,
					registration_number: report.registration_number,
					training_form_id:    report.training_form_id,
					qualification_id:    report.qualification_id,
					specialty_id:        report.specialty_id,
					specialization_id:   report.specialization_id
				},

				success: function (data)
				{
					console.log(data);
				}
			});
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

		subclass += '   <div class="tip" style="display: none;"></div>';

		subclass += '</li>';


		$(education.selector + ' ul').append(subclass);


		education.update();
	},

	update: function() // update sortable list
	{
		$(education.selector + ' ul').sortable();
	},

	tip:
	{
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