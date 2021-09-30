{strip}
<!DOCTYPE html>
<html>
<head>
    <title>{if $title}{$title}{if $up_category} - {$up_category}{/if} | {/if}Панель управления | {$_cfg.Sys_SiteName}</title>
    <meta name="keywords" content="{if $title}{$title}{if $up_category} - {$up_category}{/if} | {/if}Панель управления | {$_cfg.Sys_SiteName}" />
    <meta name="description" content="{if $title}{$title}{if $up_category} - {$up_category}{/if} | {/if}Панель управления | {$_cfg.Sys_SiteName}" />
    <meta http-equiv="X-UA-Compatible" content="IE=9" />

    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{$root_url}static/admin/img/favicon.ico" />
    <link rel="stylesheet" href="{$root_url}static/admin/css/style.css">
    <link rel="stylesheet" href="{$root_url}static/admin/css/jquery.datetimepicker.css">
    <link rel="stylesheet" href="{$root_url}static/admin/css/ydpicker.jquery.css">

    <script type="text/javascript" src="{$root_url}static/admin/js/jquery-1.11.1.js"></script>
    <script type="text/javascript" src="{$root_url}static/admin/js/script.js"></script>

    <link rel="stylesheet" href="{$root_url}static/admin/css/jquery.selectBox.css">
    <script type="text/javascript" src="{$root_url}static/admin/js/jquery.selectBox.js"></script>
    
    <script type="text/javascript" src="{$root_url}ckeditor/ckeditor.js"></script>

    <!--[if lt IE 9]>
        <script type="text/javascript">
            document.createElement('header');
            document.createElement('nav');
            document.createElement('section');
            document.createElement('article');
            document.createElement('aside');
            document.createElement('footer');
        </script>
    <![endif]-->
    <script>
      {literal}
      function add_to_fav_menu(url) {
          $.ajax({
              type: "GET",
              {/literal}
              url: '{$root_url}admin',
              {literal}
              data: 'action=add_to_menu&url=' + url,
              success: function(data) {
			            $("#menu_links").html(data);
                  if (active_cat_type == 1) {
                      {/literal}
                      $("#to_fav_menu_img").html('<a href="javascript:void(0);" onclick="add_to_fav_menu(\''+active_cat_url+'\', 0);"><img src="{$root_url}static/admin/img/star_empty.png" alt=""/></a>');
                      {literal}
                      active_cat_type=0;
                  }
                  else {
                      {/literal}
                      $("#to_fav_menu_img").html('<a href="javascript:void(0);" onclick="add_to_fav_menu(\''+active_cat_url+'\', 1);"><img src="{$root_url}static/admin/img/star.png" alt=""/></a>');
                      {literal}
                      active_cat_type=1;
                  }
			        }
          });
      }
      
      $( document ).ready(function() {

      });
      {/literal}
    </script>
</head>
<body class="default show-menu">
    <div class="site"><div class="wrap">
        <header class="cfix">
            <div class="header_button" id="menu-button"><img src="{$root_url}static/admin/img/ico/menu.png" alt=""></div>
            <a href="{$root_url}" class="logo">Logotype</a>
            <div class="header_right cfix">
                {*<img src="{$root_url}static/admin/img/ava.png" alt="{$user.aName}"/>*}
                <div class="header_ava">
                    <b>{$user.aName}</b>
                    <a href="{$root_url}account">Личный кабинет</a>
                    <a href="{$root_url}login?out" class="close">Выход</a>
                </div>
            </div>
            <div class="header_time">Время сервера: <b>{include file='widget/clock/index.tpl'}</b>
                          {*{if $SiteInf ne "" && $SiteInfDisable ne 1}
                          <br/>
					{$SiteInf|html_entity_decode}

           {/if}*}
            </div>
            <div class="b1block">
            </div>
        </header>
        <nav class="menuLeft">
            <ul>
                <br />
                <div id="menu_links">
                {section name=i loop=$admin_links}
                    <a href="javascript:void(0);" onclick="add_to_fav_menu('{$admin_links[i].url}', 1);">
                      <img src="{$root_url}static/admin/img/star.png" alt=""/>
                    </a>
                    <a href="{_link module=$admin_links[i].url}">{$admin_links[i].name}</a> {if !$smarty.section.i.last}<br />{/if}
                {/section}
                </div>
                {assign var="active_cat" value=""}
                {assign var="active_cat_url" value=""}
                {foreach from=$admin_modules_links key=mc item=r}
                <li {if ($up_category eq $mc)} class="active"{/if}>
                    <a href="javascript:void(0);">
                      {if $mc eq 'Settings' || $mc eq 'Настройки'}<img src="{$root_url}static/admin/img/ico/ml/settings.png" alt="{$mc}"/>
                      {elseif $mc eq 'News' || $mc eq 'Новости'}<img src="{$root_url}static/admin/img/ico/ml/news.png" alt="{$mc}"/>
                      {elseif $mc eq 'Accounts'  || $mc eq 'Аккаунты'}<img src="{$root_url}static/admin/img/ico/ml/user.png" alt="{$mc}"/>
                      {elseif $mc eq 'Balance'  || $mc eq 'Баланс'}<img src="{$root_url}static/admin/img/ico/ml/balance.png" alt="{$mc}"/>
                      {elseif $mc eq 'Calendar'  || $mc eq 'Календарь'}<img src="{$root_url}static/admin/img/ico/ml/calendar.png" alt="{$mc}"/>
                      {elseif $mc eq 'Deposits'  || $mc eq 'Вклады'}<img src="{$root_url}static/admin/img/ico/ml/deposit.png" alt="{$mc}"/>
                      {elseif $mc eq 'FAQ'  || $mc eq 'FAQ'}<img src="{$root_url}static/admin/img/ico/ml/faq.png"  alt="{$mc}"/>
                      {elseif $mc eq 'Users pages'  || $mc eq 'Пользовательские страницы'}<img src="{$root_url}static/admin/img/ico/ml/pages.png"  alt="{$mc}"/>
                      {elseif $mc eq 'Messages and Support' ||  $mc eq 'Support'  || $mc eq 'Сообщения и Поддержка'  || $mc eq 'Поддержка'}<img src="{$root_url}static/admin/img/ico/ml/support.png"  alt="{$mc}"/>
                      {elseif $mc eq 'SMS'  || $mc eq 'SMS'}<img src="{$root_url}static/admin/img/ico/ml/sms.png"  alt="{$mc}"/>
                      {elseif $mc eq 'Reviews'  || $mc eq 'Отзывы'}<img src="{$root_url}static/admin/img/ico/ml/review.png"  alt="{$mc}"/>
                      {/if}
                      {$mc}
                    </a>
                    <ul>
                      {foreach from=$r key=key item=value}
                        <li {if $tpl_module eq $value} {assign var="active_cat" value="`$key`"}{assign var="active_cat_url" value="`$value`"}class="active"{/if}>{*<a href="javascript:void(0);" onclick="add_to_fav_menu('{$value}');"><img src="{$root_url}static/admin/img/star.png" alt=""/></a>*} <a href="{_link module=$value}">{$key}</a></li>
                      {/foreach}
                    </ul>
                </li>
               {/foreach}
            </ul>
        </nav>
        <section class="content">
           {if $up_category ne ""}
             <div class="content_white">
               <script>
                   var active_cat_url='{$active_cat_url}';
                   var active_cat_type={if in_array($active_cat_url, $admin_links_list)}1{else}0{/if};
               </script>
               {if $active_cat_url ne ""}
                 <p align="left" id="to_fav_menu_img">
                     {if in_array($active_cat_url, $admin_links_list)}<a href="javascript:void(0);" onclick="add_to_fav_menu('{$active_cat_url}', 1);"><img src="{$root_url}static/admin/img/star.png" alt=""/></a>{else}<a href="javascript:void(0);" onclick="add_to_fav_menu('{$active_cat_url}', 0);"><img src="{$root_url}static/admin/img/star_empty.png" alt=""/></a>{/if}
                  </p>
               {/if}
                        {*{if $SiteInf ne "" && $SiteInfDisable ne 1}
             <p class="note">
						<b>{$SiteInf}</b>
			  </p>
           {/if}*}
                            {if $needupdatedb}
					<p class="note">
						<b>ВНИМАНИЕ!</b><br>
						Необходимо обновить структуру базы данных через <a href="{$root_url}{$_cfg.cfg_link}">Конфигуратор</a>
					</p>
				{/if}
                <h1>{$active_cat}</h1>
                {else}
                             {*{if $SiteInf ne "" && $SiteInfDisable ne 1}
             <p class="note">
						<b>{$SiteInf}</b>
			  </p>
           {/if}*}
           {/if}
           {include file='info.tpl' _info=$tpl_info}
{/strip}