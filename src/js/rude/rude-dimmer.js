var dimmer =
{
	selector: '#dimmer',

	show: function()
	{
		$(dimmer.selector).dimmer('setting').dimmer('show');
	},

	hide: function()
	{
		$(dimmer.selector).dimmer('hide');
	},

	toggle: function()
	{
		$(dimmer.selector).dimmer('toggle');
	}
};