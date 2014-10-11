<?

####################################################################
####################################################################
#                            main section                          #
####################################################################

define('RUDE_URL_SITE',        'http://rude-univ.me');

define('RUDE_DATABASE_USER',   'root');
define('RUDE_DATABASE_PASS',   '1234');
define('RUDE_DATABASE_HOST',   'localhost');
define('RUDE_DATABASE_PREFIX', '');
define('RUDE_DATABASE_NAME',   'univ');

define('RUDE_DEBUG',           true);

define('RUDE_THEME',           'univ');


####################################################################
####################################################################
#                            role section                          #
####################################################################

define('RUDE_ROLE_ADMIN',  1);
define('RUDE_ROLE_EDITOR', 2);
define('RUDE_ROLE_USER',   3);


####################################################################
####################################################################
#                         session section                          #
####################################################################

define('RUDE_SESSION_IS_ADMIN',      'is_admin');
define('RUDE_SESSION_IS_EDITOR',     'is_editor');
define('RUDE_SESSION_IS_USER',       'is_user');
define('RUDE_SESSION_IS_AUTHORIZED', 'is_authorized');

define('RUDE_SESSION_USER_ID',       'user_id');
define('RUDE_SESSION_USER_NAME',     'user_name');


####################################################################
####################################################################
#                            url section                           #
####################################################################

define('RUDE_URL_SRC', RUDE_URL_SITE . '/src');



####################################################################
####################################################################
#                        filesystem section                        #
####################################################################

define('RUDE_DIR_ROOT', __DIR__);


####################################################################
#                            file parts                            #
####################################################################

define('RUDE_FILE_PART_SITEMAP', DIRECTORY_SEPARATOR . 'sitemap.xml');


####################################################################
#                           file section                           #
####################################################################

define('RUDE_FILE_SITEMAP', __DIR__ . RUDE_FILE_PART_SITEMAP);


####################################################################
#                             dir parts                            #
####################################################################

define('RUDE_DIR_PART_SRC',    DIRECTORY_SEPARATOR . 'src');
define('RUDE_DIR_PART_THEME',  DIRECTORY_SEPARATOR . RUDE_THEME);
define('RUDE_DIR_PART_THEMES', DIRECTORY_SEPARATOR . 'themes');
define('RUDE_DIR_PART_IMAGES', DIRECTORY_SEPARATOR . 'img');



####################################################################
#                           directories                            #
####################################################################

define('RUDE_DIR_SRC',    RUDE_DIR_ROOT . RUDE_DIR_PART_SRC);
define('RUDE_DIR_IMAGES', RUDE_DIR_ROOT . RUDE_DIR_PART_IMAGES);
define('RUDE_DIR_THEME',  RUDE_DIR_SRC  . RUDE_DIR_PART_THEMES . DIRECTORY_SEPARATOR . RUDE_THEME);


####################################################################
#                           URL section                            #
####################################################################

define('RUDE_URL_IMAGES', RUDE_URL_SITE . RUDE_DIR_PART_SRC . '/' . RUDE_DIR_PART_IMAGES);


####################################################################
####################################################################
#                       date & time section                        #
####################################################################

define('RUDE_TIMEZONE', 'Europe/Minsk');

define('RUDE_TIME_SECOND', 1);         # 1 second
define('RUDE_TIME_MINUTE', 60);        # 1 minute = 60 seconds
define('RUDE_TIME_HOUR',   3600);      # 1 hour   = 3600 seconds
define('RUDE_TIME_DAY',    86400);     # 1 day    = 86400 seconds
define('RUDE_TIME_MONTH',  2592000);   # 1 month  = 2592000 seconds
define('RUDE_TIME_YEAR',   946080000); # 1 year   = 946080000 seconds


####################################################################
####################################################################
#                         database section                         #
####################################################################

define('RUDE_DATABASE_TABLE_DEPARTMENTS',     RUDE_DATABASE_PREFIX . 'departments');
define('RUDE_DATABASE_TABLE_FACULTIES',       RUDE_DATABASE_PREFIX . 'faculties');
define('RUDE_DATABASE_TABLE_QUALIFICATIONS',  RUDE_DATABASE_PREFIX . 'qualifications');
define('RUDE_DATABASE_TABLE_REPORTS',         RUDE_DATABASE_PREFIX . 'reports');
define('RUDE_DATABASE_TABLE_USERS_ROLES',     RUDE_DATABASE_PREFIX . 'users_roles');
define('RUDE_DATABASE_TABLE_SPECIALTIES',     RUDE_DATABASE_PREFIX . 'specialties');
define('RUDE_DATABASE_TABLE_TRAINING_FORM',   RUDE_DATABASE_PREFIX . 'training_forms');
define('RUDE_DATABASE_TABLE_SPECIALIZATIONS', RUDE_DATABASE_PREFIX . 'specializations');
define('RUDE_DATABASE_TABLE_USERS',           RUDE_DATABASE_PREFIX . 'users');


define('RUDE_DATABASE_FIELD_ID',                  'id');
define('RUDE_DATABASE_FIELD_NAME',                'name');
define('RUDE_DATABASE_FIELD_SHORTNAME',           'shortname');
define('RUDE_DATABASE_FIELD_HASH',                'hash');
define('RUDE_DATABASE_FIELD_SALT',                'salt');
define('RUDE_DATABASE_FIELD_ROLE_ID',             'role_id');
define('RUDE_DATABASE_FIELD_FACULTY_ID',          'faculty_id');
define('RUDE_DATABASE_FIELD_TRAINING_FORM_ID',    'training_form_id');
define('RUDE_DATABASE_FIELD_SPECIALTY_ID',        'specialty_id');
define('RUDE_DATABASE_FIELD_SPECIALIZATION_ID',   'specialization_id');
define('RUDE_DATABASE_FIELD_QUALIFICATION_ID',    'qualification_id');
define('RUDE_DATABASE_FIELD_YEAR',                'year');
define('RUDE_DATABASE_FIELD_DURATION',            'duration');
define('RUDE_DATABASE_FIELD_RECTOR',              'rector');
define('RUDE_DATABASE_FIELD_REGISTRATION_NUMBER', 'registration_number');
define('RUDE_DATABASE_FIELD_IS_TMP',              'is_tmp');


####################################################################
####################################################################
#                         database section                         #
####################################################################

define('RUDE_AJAX_ERROR',            "0");
define('RUDE_AJAX_OK',               "1");
define('RUDE_AJAX_ACCESS_VIOLATION', "2");