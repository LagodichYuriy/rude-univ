<?

namespace rude;

class site
{
	public static function init()
	{
		template_session::init();


		switch (get('page'))
		{
			case 'registration':  ajax_registration::init();  break;
			case 'authorization': ajax_authorization::init(); break;

			case 'logout':        ajax_logout::init();        break;

			case 'departments':     $template = new template_departments();     $template->html(); break;
			case 'faculties':       $template = new template_faculties();       $template->html(); break;
			case 'qualifications':  $template = new template_qualifications();  $template->html(); break;
			case 'specializations': $template = new template_specializations(); $template->html(); break;
			case 'specialties':     $template = new template_specialties();     $template->html(); break;
			case 'users':           $template = new template_users();           $template->html(); break;
			case 'users_roles':     $template = new template_users_roles();     $template->html(); break;

			default:
				if (!url::is_homepage())
				{
					$template = new template_404();
					$template->html();

					die;
				}

				$template = new template_homepage();
				$template->html();
		}
	}
}

