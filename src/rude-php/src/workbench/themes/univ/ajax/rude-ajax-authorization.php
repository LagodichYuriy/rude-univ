<?

namespace rude;

class ajax_authorization
{
	public static function init()
	{
		$username = get('username');
		$password = get('password');


		if (!$username)
		{
			exit('Пожалуйста, укажите имя для пользователя.');
		}

		if (!$password)
		{
			exit('Пожалуйста, укажите пароль пользователю.');
		}

		if (string::length($password) < 6)
		{
			exit('Ваш пароль не может быть менее 6 символов.');
		}


		$user = users::get_by_name($username);

		if (!$user)
		{
			exit('Данного пользователя не существует.');
		}


		if (!crypt::is_valid($password, $user->hash, $user->salt))
		{
			exit('Указанный вами пароль не совпадает с тем, что был указан при регистрации.');
		}


		$is_authorized = template_session::login($user->id);

		if (!$is_authorized)
		{
			exit('Нарушение логической цепи: авторизация не произведена.');
		}
	}
}