<?

namespace rude;

class site
{
	public static function init()
	{
		template_session::init();


		switch (get('page'))
		{
			case 'registration':    ajax_registration::init();                  break;
			case 'authorization':   ajax_authorization::init();                 break;
			case 'logout':          ajax_logout::init();                        break;

			case 'calendar':        ajax_calendar_items::init();                break;

			case 'departments':     $template = new template_departments();     break;
			case 'faculties':       $template = new template_faculties();       break;
			case 'qualifications':  $template = new template_qualifications();  break;
			case 'specializations': $template = new template_specializations(); break;
			case 'specialties':     $template = new template_specialties();     break;
			case 'users':           $template = new template_users();           break;
			case 'users-roles':     $template = new template_users_roles();     break;

			case 'reports':         $template = new template_reports();         break;
			case 'reports-new':     $template = new template_reports_new();     break;
			case 'reports-edit':    $template = new template_reports_edit();    break;
			case 'reports-preview': $template = new template_reports_preview(); break;




			default:
				     if (!url::is_homepage()) { $template = new template_404();      }
				else                          { $template = new template_homepage(); }
		}

		if (isset($template) and !get('ajax'))
		{
			$template->html();
		}
	}
}

