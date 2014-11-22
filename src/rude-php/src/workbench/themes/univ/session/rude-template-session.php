<?

namespace rude;

class template_session
{
	public static function init()
	{
		session::start();
	}

	public static function login($user_id = null)
	{
		if ($user_id === null)
		{
			$user_id = template_session::get_user_id();
		}

		if (!$user_id)
		{
			return false;
		}


		$user = users::get($user_id);

		if (!$user)
		{
			return false;
		}


		template_session::set_user_id($user->id);
		template_session::set_user_name($user->name);
		$setting_popup = settings::get_popup($user->id);
		template_session::set_use_popup($setting_popup->value);


		switch ($user->role_id)
		{
			case RUDE_ROLE_ADMIN:
				template_session::set_authorized();

				template_session::set_admin();
				template_session::set_editor();
				template_session::set_user();
				break;

			case RUDE_ROLE_EDITOR:
				template_session::set_authorized();

				template_session::set_editor();
				template_session::set_user();
				break;

			case RUDE_ROLE_USER:
				template_session::set_authorized();

				template_session::set_user();
				break;
		}

		return true;
	}

	public static function logout()
	{
		return session::destroy();
	}

	public static function set_user_id($user_id)
	{
		session::set(RUDE_SESSION_USER_ID, (int) $user_id);
	}

	public static function set_user_name($username)
	{
		session::set(RUDE_SESSION_USER_NAME, $username);
	}

	public static function set_use_popup($setting_value)
	{
		session::set(RUDE_SESSION_USER_SETTING_POPUP, $setting_value);
	}

	public static function set_admin()      { session::set(RUDE_SESSION_IS_ADMIN,      true); }
	public static function set_editor()     { session::set(RUDE_SESSION_IS_EDITOR,     true); }
	public static function set_user()       { session::set(RUDE_SESSION_IS_USER,       true); }
	public static function set_authorized() { session::set(RUDE_SESSION_IS_AUTHORIZED, true); }

	public static function unset_admin()      { session::set(RUDE_SESSION_IS_ADMIN,      false); }
	public static function unset_editor()     { session::set(RUDE_SESSION_IS_EDITOR,     false); }
	public static function unset_user()       { session::set(RUDE_SESSION_IS_USER,       false); }
	public static function unset_authorized() { session::set(RUDE_SESSION_IS_AUTHORIZED, false); }

	public static function is_admin()      { return session::is_equals(RUDE_SESSION_IS_ADMIN,      true); }
	public static function is_editor()     { return session::is_equals(RUDE_SESSION_IS_EDITOR,     true); }
	public static function is_user()       { return session::is_equals(RUDE_SESSION_IS_USER,       true); }
	public static function is_authorized() { return session::is_equals(RUDE_SESSION_IS_AUTHORIZED, true); }

	public static function get_user_name() { return session::get(RUDE_SESSION_USER_NAME); }
	public static function get_user_id()   { return session::get(RUDE_SESSION_USER_ID);   }
}