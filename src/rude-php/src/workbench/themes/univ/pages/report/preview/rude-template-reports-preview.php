<?

namespace rude;

class template_reports_preview
{
	private $report = null;

	public function __construct()
	{
		if (get('tmp'))
		{

		}
	}

	public function html()
	{
		if (get('is_tmp'))
		{
			$reports = new reports_preview();
		}
		else
		{
			$reports = new reports;
		}


		$this->report = $reports::get(get('report_id'));

		if (!$this->report)
		{
			return;
		}

		?>
		<html>
			<head>
				<!-- jQuery [JS]-->
				<?= html::js(RUDE_URL_SRC . '/js/jquery/jquery-1.11.1.min.js') ?>

				<!-- jQuery plugins [JS] -->
				<?= html::js(RUDE_URL_SRC . '/js/jqueryrotate/jQueryRotateCompressed.js') ?>

				<!-- CSS -->
				<?= html::css(RUDE_URL_SRC . '/css/report.css') ?>
			</head>
			<body contenteditable="true">
				<? $this->main() ?>
			</body>

			<script>
				$(function() {
					$('.rotate-270').rotate(270);
				});
			</script>
		</html>
		<?
	}

	public function main()
	{
		template_reports_preview_header::html($this->report);
		template_reports_preview_calendar::html($this->report);
		template_reports_preview_plan::html();


	}
}