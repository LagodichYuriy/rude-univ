var report =
{
	classes:
	{
		table: 'plan',
		paper: 'paper'
	},

	selectors:
	{
		papers: '#papers',
		paper:  '.paper',

		origin: '#origin',

		hidden: '#hidden',

		page_break: '.page-break'
	},

	init: function()
	{
		for (var i = 1; i < 99; i++)
		{
			if (report.paper.get.height(i) > report.paper.get.max_height())
			{
				report.paper.format(i);
			}
			else
			{
				break;
			}
		}

		if ($('#origin tbody td').length == 0)
		{
			$('#origin').remove();
		}

		$(report.selectors.page_break).last().remove();
	},


	paper:
	{
		format: function(index)
		{
			var header = report.paper.header.get();
			var footer = report.paper.footer.get();

			report.paper.add(header + footer);


			var i = 0;

			console.log('0: max A3 page height: ' + report.paper.get.max_height());

			while (report.paper.get.height(index) > report.paper.get.max_height())
			{
				if (!report.paper.table.tr.is_exists(index))
				{
					break;
				}


				if (i++ == 0)
				{
					console.log('1: current A3 page height: ' + report.paper.get.height(index));
				}


				report.paper.table.tr.move(index);
			}

			console.log('2: final A3 page height: ' + report.paper.get.height(index));
		},

		get:
		{
			height: function(index)
			{
				return parseFloat($(report.selectors.paper + ':eq(' + (index - 1) +')').css('height'));
			},

			max_height: function()
			{
				return parseFloat($(report.selectors.hidden).css('height'));
			}
		},

		add: function(html)
		{
			$(report.selectors.papers).append(report.html.div(html, report.classes.paper));
		},

		table:
		{
			tr:
			{
				is_exists: function(index)
				{
					return $(report.selectors.paper + ':eq(' + (index - 1) + ') table.' + report.classes.table + ' tbody tr').length;
				},

				move: function(index)
				{
					var selector_from = report.selectors.paper + ':eq(' + (index - 1) + ') table.' + report.classes.table + ' tbody tr:last';
					var selector_to   = report.selectors.paper + ':eq(' + (index    ) + ') table.' + report.classes.table + ' tbody';

					$(selector_to).prepend($(selector_from).remove());
				},

				pop: function(index)
				{
					return $(report.selectors.paper + ':eq(' + (index - 1) + ') table.' + report.classes.table + ' tbody tr:last').remove();
				},

				push: function(index, html)
				{
					$(report.selectors.paper + ':eq(' + (index - 1) + ') table.' + report.classes.table + ' tbody').prepend(html);
				}
			},

			optional:
			{
				format: function()
				{
					var max_height = Math.max.apply(null, $('.optionals .optional').map(function ()
					{
						return $(this).height();
					}).get());

					$('.optionals .optional').height(max_height + 10);
				}
			}
		},

		page_break: function()
		{
			return report.html.div('&nbsp;', 'page-break');
		},

		header:
		{
			get: function()
			{
				return report.html.table($(report.selectors.origin + ' thead').html(), report.classes.table);
			}
		},

		footer:
		{
			get: function()
			{
				var html_left  = report.html.div('Заведующий кафедрой инженерной психологии и эргономики ___________ К.Д. Яшин', 'left');
				var html_right = report.html.div('Эксперт ___________ Д.А. Фецкович', 'right');

				return report.html.div(html_left + html_right, 'footer-small') + report.paper.page_break();
			}
		}
	},

	html:
	{
		div: function(html, class_name)
		{
			return '<div class="' + class_name + '">' + html + '</div>'
		},

		table: function(html_thead, class_name)
		{
			return '<table class="' + class_name + '"><thead>' + html_thead + '</thead><tbody></tbody></table>'
		}
	}
};