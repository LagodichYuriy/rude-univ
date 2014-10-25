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
				<!-- CSS -->
				<?= html::css(RUDE_URL_SRC . '/css/report.css') ?>
			</head>
			<body contenteditable="true">
				<? $this->main() ?>
			</body>
		</html>
		<?
	}

	public function main()
	{
		template_reports_preview_header::html($this->report);
		template_reports_preview_calendar::html($this->report);
		template_reports_preview_plan::html();

		?>

		<?
	}
}