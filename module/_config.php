<?php

$_rwlinks = array(
	'index' => array('home'), // main home page
	'cabinet' => array('cabinet'), // user home page
	
	'system' => array('interface'), // select interface
	'ajax' => array('ajax'),
	
	// Admin panel
	
	'admin' => array('admin'),

    // Global setup

    'system/admin/setup_main' => array('admin/setup/main', 'admin' => '{!ru!}Настройки{!en!}Settings{!!}/{!ru!}Основные{!en!}Main'),
    'system/admin/setup_sec' => array('admin/setup/security', 'admin' => '{!ru!}Настройки{!en!}Settings{!!}/{!ru!}Безопасность{!en!}Security'),
    'system/admin/setup_ui' => array('admin/setup/ui', 'admin' => '{!ru!}Настройки{!en!}Settings{!!}/{!ru!}Интерфейс{!en!}Interface'),
    'system/admin/setup_mail' => array('admin/setup/mail', 'admin' => '{!ru!}Настройки{!en!}Settings{!!}/{!ru!}Почта{!en!}Mail'),

    // Scheduler

    'cron' => array('cron'),
    'cron/admin/setup' => array('admin/cron', 'admin' => '{!ru!}Настройки{!en!}Settings{!!}/{!ru!}Планировщик{!en!}Cron'),

    // News

    'news' => array('news'),
    'news/show' => array('show'),
    'news/admin/newses' => array('admin/newses', 'admin' => '{!ru!}Новости{!en!}News{!!}/{!ru!}Публикации{!en!}Publications'),
    'news/admin/news' => array('admin/news', 'admin' => '{!ru!}Новости{!en!}News{!!}/-'),
    'news/admin/setup' => array('admin/news/setup', 'admin' => '{!ru!}Новости{!en!}News{!!}/{!ru!}Настройки{!en!}Settings'),

    // Account

    'account' => array('account', 'https' => 0),
    'account/register' => array('registration', 'https' => 0),
    'account/login' => array('login', 'https' => 0),
    'account/reset_pass' => array('resetpass', 'https' => 0),
    'account/change_pass' => array('changepass', 'https' => 0),
    'account/change_mail' => array('changemail', 'https' => 0),
    'account/admin/users' => array('admin/account/users', 'admin' => '{!ru!}Аккаунты{!en!}Accounts{!!}/{!ru!}Пользователи{!en!}Users'),
    'account/admin/user' => array('admin/account/user', 'admin' => '{!ru!}Аккаунты{!en!}Accounts{!!}/-'),
    'account/admin/user2' => array('admin/account/user/addinfo', 'admin' => '{!ru!}Аккаунты{!en!}Accounts{!!}/-'),
    'account/admin/ip_stat' => array('admin/account/ip_stat', 'admin' => '{!ru!}Аккаунты{!en!}Accounts{!!}/{!ru!}IP статистика{!en!}IP statistics'),
    'account/admin/ip' => array('admin/account/ip', 'admin' => '{!ru!}Аккаунты{!en!}Accounts{!!}/-'),
    'account/admin/setup' => array('admin/account/setup', 'admin' => '{!ru!}Аккаунты{!en!}Accounts{!!}/{!ru!}Настройки{!en!}Settings'),
    //'account/loginza' => array('loginza'), // Loginza
    'account/ulogin' => array('ulogin'), // uLogin
    'account/isp' => array('login/isp'), // ISP

    // Balance

    'balance' => array('operations'),
    'balance/oper' => array('operation'),
    'balance/status' => array('balance/status'),
    'balance/wallets' => array('balance/wallets'),
    'balance/admin/currs' => array('admin/currs', 'admin' => '{!ru!}Баланс{!en!}Balance{!!}/{!ru!}Платежные системы{!en!}Payment systems'),
    'balance/admin/curr' => array('admin/curr', 'admin' => '{!ru!}Баланс{!en!}Balance{!!}/-'),
    'balance/admin/opers' => array('admin/opers', 'admin' => '{!ru!}Баланс{!en!}Balance{!!}/{!ru!}Операции{!en!}Operations'),
    'balance/admin/oper' => array('admin/oper', 'admin' => '{!ru!}Баланс{!en!}Balance{!!}/-'),
    'balance/admin/setup' => array('admin/balance/setup', 'admin' => '{!ru!}Баланс{!en!}Balance{!!}/{!ru!}Настройки{!en!}Settings'),
    'balance/admin/keeper' => array('admin/keeper', 'admin' => '{!ru!}Баланс{!en!}Balance{!!}/{!ru!}Онлайн keeper{!en!}Online keeper'),
    'balance/admin/ym_api_token' => array('admin/balance/ym_api_token'),

    // Ref. system

    'refsys' => array('refsys'),
    'refsys/admin/setup' => array('admin/refsys', 'admin' => '{!ru!}Настройки{!en!}Settings{!!}/{!ru!}Реф.система{!en!}Referral system'),

    // Calendar

    'calendar/admin/days' => array('admin/days', 'admin' => '{!ru!}Календарь{!en!}Calendar{!!}/{!ru!}Дни{!en!}Days'),
    'calendar/admin/day' => array('admin/day', 'admin' => '{!ru!}Календарь{!en!}Calendar{!!}/-'),

    // Deposits

    'depo' => array('deposits'),
    'depo/depo' => array('deposit'),
    'depo/admin/plans' => array('admin/plans', 'admin' => '{!ru!}Вклады{!en!}Deposits{!!}/{!ru!}Планы{!en!}Plans'),
    'depo/admin/plan' => array('admin/plan', 'admin' => '{!ru!}Вклады{!en!}Deposits{!!}/-'),
    'depo/admin/depos' => array('admin/depos', 'admin' => '{!ru!}Вклады{!en!}Deposits{!!}/{!ru!}Депозиты{!en!}Deposits'),
    'depo/admin/depo' => array('admin/depo', 'admin' => '{!ru!}Вклады{!en!}Deposits{!!}/-'),
    'depo/admin/charge' => array('admin/charge', 'admin' => '{!ru!}Вклады{!en!}Deposits{!!}/{!ru!}Начисление{!en!}Accrual'),
    'depo/admin/setup' => array('admin/depo/setup', 'admin' => '{!ru!}Вклады{!en!}Deposits{!!}/{!ru!}Настройки{!en!}Setting'),
    'depo/admin/stat' => array('admin/depo/info', 'admin' => '{!ru!}Вклады{!en!}Deposits{!!}/{!ru!}Статистика{!en!}Statistics'),
    'depo/top' => array('top'),
    'depo/topin' => array('topin'),
    'depo/lastin' => array('lastin'),
    'depo/lastout' => array('lastout'),
    'depo/calc' => array('calc'),

    // FAQ

    'faq' => array('faq'),
    'faq/admin/faqs' => array('admin/faqs', 'admin' => '{!ru!}FAQ{!en!}FAQ{!!}/{!ru!}Список{!en!}List'),
    'faq/admin/faq' => array('admin/faq', 'admin' => 'FAQ/-'),
    'faq/admin/setup' => array('admin/faq/setup', 'admin' => '{!ru!}FAQ{!en!}FAQ{!!}/{!ru!}Настройки{!en!}Settings'),

    // Custom pages

    'custom' => array('page'),
    'custom/admin/pages' => array('admin/pages', 'admin' => '{!ru!}Пользовательские страницы{!en!}Users pages{!!}/{!ru!}Список{!en!}List'),
    'custom/admin/page' => array('admin/page', 'admin' => '{!ru!}Пользовательские страницы{!en!}Users pages{!!}/-'),

    // Messages & Support

    'message' => array('messages'),
    'message/outbox' => array('messages/outbox'),
    'message/show' => array('message'),
    'message/admin/messages' => array('admin/messages', 'admin' => '{!ru!}Сообщения и Поддержка{!en!}Messages and Support{!!}/{!ru!}Список{!en!}List'),
    'message/admin/message' => array('admin/message', 'admin' => '{!ru!}Сообщения и Поддержка{!en!}Messages and Support{!!}/-'),
    'message/admin/setup' => array('admin/message/setup', 'admin' => '{!ru!}Сообщения и Поддержка{!en!}Messages and Support{!!}/{!ru!}Настройки{!en!}Settings'),
    'message/support' => array('support'),
	
	// Tickets
	
	'tickets' => array('tickets'),
	'tickets/ticket' => array('ticket'),
//	'tickets/newticket' => array('newticket'),
	'tickets/admin' => array('admin/tickets', 'admin' => '{!ru!}Поддержка{!en!}Support{!!}/{!ru!}Тикеты{!en!}Tickets'),
	'tickets/admin/ticket' => array('admin/ticket', 'admin' => '{!ru!}Поддержка{!en!}Support{!!}/-'),
	'tickets/admin/setup' => array('admin/tickets/setup', 'admin' => '{!ru!}Поддержка{!en!}Support{!!}/{!ru!}Настройки{!en!}Settings'),
	
	// SMS
	
	'sms/admin' => array('admin/sms', 'admin' => 'SMS/{!ru!}Очередь{!en!}Queue'),
	'sms/admin/send' => array('admin/sms/send', 'admin' => 'SMS/{!ru!}Отправить{!en!}Send'),
	'sms/admin/setup' => array('admin/sms/setup', 'admin' => 'SMS/{!ru!}Настройки{!en!}Settings'),

    // Reviews

    'review' => array('reviews'),
    'review/admin' => array('admin/reviews', 'admin' => '{!ru!}Отзывы{!en!}Reviews{!!}/{!ru!}Список{!en!}List'),
    'review/admin/setup' => array('admin/reviews/setup', 'admin' => '{!ru!}Отзывы{!en!}Reviews{!!}/{!ru!}Настройки{!en!}Settings'),

    // Confirm

    'confirm' => array('confirm'),
    'confirm/admin/setup' => array('admin/confirm', 'admin' => '{!ru!}Настройки{!en!}Settings{!!}/{!ru!}Подтверждение{!en!}Evidence'),

    // User Defined Pages
    // !!! Insert NEW ADDITIONAL pages here !!!

    'udp/intro' => array('intro'),
    'udp/rules' => array('rules'),
    'udp/about' => array('about'),


    // Captcha

    'captcha' => array('captcha'),
    'captcha/setup' => array('admin/captcha', 'admin' => '{!ru!}Настройки{!en!}Settings{!!}/Captcha')
);

$_onload = array(
	'balance' => 0,
	'refsys' => 0,
	'depo' => 0
);

$_onstart = array( // access level (_auth)
	'captcha' => 0,
	'system' => 0,
	'widget/clock' => 0,
	'geoip2' => 0,
	'news' => 0,
	'faq' => 0,
	'review' => 0,
	'depo' => 0
);

$_oncron = array( // once in N minutes
	'balance' => 5,
	'depo' => 1,
	'sms' => 1
);

?>