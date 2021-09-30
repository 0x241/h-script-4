<?php

error_reporting(0);
//error_reporting(65535);

$_smode = intval(@$_smode); // show mode: 0-user / 1-ajax / 2-bot (cron, captcha..)
$_auth = intval(@$_auth); // required access level

// Anti-DDoS

//if ($_smode < 2)
//	@include('a-ddos/a-ddos.php');

global $_user, $_currs;
$_user = array(); // guest
$_currs = array();
function _uid()
{
    return intval(@$_SESSION['_uid']);
}

// Connect DB

require_once('module/dbinit.php');

// Load config

foreach ($db->fetchRows($db->select('Cfg')) as $c)
{
    if (substr($c['Prop'], 0, 1) == '_') // array
        $c['Val'] = asArray($c['Val'], HS2_NL);
    if ($c['Module'])
        $c['Prop'] = $c['Module'] . '_' . $c['Prop'];
    $_cfg[$c['Prop']] = $c['Val'];
}
$_GS['site_name'] = $_cfg['Sys_SiteName'];
if (!$_cfg['UI__Langs'])
    $_cfg['UI__Langs'] = array($_GS['default_lang']);

require_once('module/lib.php');

if ($_smode < 2) // user mode
{
    session_start(); // ??? deadlock

    if (($_cfg['Sec_HTTPSMode'] == 1) and !$_GS['https'])
        goToURL(fullURL('*', true));

    $login_link = moduleToLink('account/login');
    if ($_smode < 1)
    {
        if (!isset($_SESSION['_uid'])) // first time or new session
        {
            $_SESSION['_sid'] = $_cfg['sys_id'];
            $_SESSION['new_session'] = true;
            $_SESSION['_uid'] = 0;
            $_SESSION['show_intro'] = true;
            if ($sess = _COOKIE('sess'))
            {
                if ($uid = $db->fetch1($db->select('Users', 'uID', 'uLSess=? and uLevel=1', array($sess))))
                {
                    useLib('account/login');
                    opLogin($uid, fullURL('*'), false, false, true);
                }
                setcookie('sess', '', time() - HS2_UNIX_DAY, '/');
            }
        }
        else
        {
            if ($_SESSION['_sid'] != $_cfg['sys_id']) // wrong systemID
            {
                session_destroy();
                goToURL();
            }
            unset($_SESSION['new_session']);
        }

        // Language (Interface)

        $_SESSION['_lang'] = @reset($_cfg['UI__Langs']); // default primary
        $a = explode(',', str_replace(';', ',', $_SERVER['HTTP_ACCEPT_LANGUAGE'])); // detect from browser
        if (_COOKIE('lang'))
            array_unshift($a, _COOKIE('lang'));
        foreach ($a as $s)
            if (@in_array($l = Get1ElemL($s, '-'), $_cfg['UI__Langs']))
            {
                $_SESSION['_lang'] = $l;
                break;
            }

        // Reflink

        if ($_cfg['Ref_Word'] and (($ref = _GET($_cfg['Ref_Word']) or !_SESSION('_ref'))))
        {
            if (!_SESSION('_ref'))
                $ref = exValue(_COOKIE('ref'), $ref);
            elseif (!$_cfg['Ref_Force'])
                $ref = '';
            if ($ref)
                if ($db->count('Users', 'uLogin=? and uState=1', array($ref))) // only active inviter
                {
                    setcookie('ref', $ref, time() + 14 * HS2_UNIX_DAY, '/');
                    $_SESSION['_ref'] = $ref;
                }
        }

        if (($_GS['module'] != 'account/login') and !_uid() and ($_auth > 0)) // auth required!
            goToURL($login_link . '?url=' . urlencode($_GS['uri']));

        if (!$_cfg['Cron_ByHost'] and $_GS['is_local'])
            @include_once('cron.php');
    }
    list($h, $m) = explode(':', $_cfg['UI_DefaultTZ'], 2);
    $_GS['TZ'] = $h * HS2_UNIX_HOUR + $m * HS2_UNIX_MINUTE;

    if (_uid()) // already logged
    {
        $lt = _SESSION('_lts'); // last time
        $_SESSION['_lts'] = time();
        if (isset($_COOKIE['tz'])) // auto timezone
        {
            $db->update('AddInfo', array('aTZ' => -_COOKIEN('tz')), '', 'auID=?d', array(_uid()));
            setcookie('tz', '', time() - HS2_UNIX_DAY, '/');
        }
        $_user = $db->fetch1Row($db->select('Users LEFT JOIN AddInfo ON auID=uID', '*', 'uID=?d', array(_uid())));
        if (subStamps($_user['uLTS']) > HS2_UNIX_MINUTE)
            $db->update('Users', array('uLTS' => timeToStamp()), '', 'uID=?d', array(_uid()));
        if ($_GS['module'] != 'account/login')
        {
            if (!$_user)
                goToURL($login_link . '?out=not_found');
            if ($_user['aSessIP'] and (_SESSION('_lip') != $_GS['client_ip']))  // !!!IP changed!!!
                goToURL($login_link . '?out=ip_changed');
            if ($_user['aSessUniq'] and (_SESSION('_lsess') != $_user['uLSess'])) // !!!session changed!!!
                goToURL($login_link . '?out=session_changed');
            $t = exValue($_cfg['Sec_TimeOut'], $_user['aTimeOut']);
            if (!$_GS['is_local'] and ($t > 0)) // !!!auto logout (sess exp)!!!
            {
                $t = $lt + ($t * HS2_UNIX_MINUTE) - time();
                if ($t <= 0)
                    goToURL($login_link . '?out=time_out');
            }
            if (($_cfg['Sec_PassTime'] > 0) and (subStamps($_user['uPTS']) > (0 + $_cfg['Sec_PassTime']) * HS2_UNIX_DAY))
            {
                if ($_GS['module'] != 'account/change_pass')
                    goToURL(moduleToLink('account/change_pass') . '?need_change');
            }
            elseif ($_cfg['Sec_ForceReConfig'] and $_user['aNeedReConfig'])
            {
                if ($_GS['module'] != 'account')
                    goToURL(moduleToLink('account'));
            }
            elseif ($_cfg['Sys_NeedReConfig'] and ($_user['uLevel'] >= 90))
            {
                if ($_GS['module'] != 'system/admin/setup_main')
                    goToURL(moduleToLink('system/admin/setup_main'));
            }
        }

        $_SESSION['_lang'] = $_user['uLang'];
        if ($_auth >= 50)
        {
            if ($_cfg['Sec__IPs'])
                if (!in_array($_GS['client_ip'], $_cfg['Sec__IPs']))
                    showInfo('*Denied', $login_link); // !!!Access denied!!!
            $_GS['TZ'] = 0; // In Admin panel time zone = 0!!!
        }
        else
            $_GS['TZ'] = $_user['aTZ'] * HS2_UNIX_MINUTE;
    }
    if ($_auth > $_user['uLevel'])
        showInfo('*Denied', $login_link); // !!!Access denied!!!
    if ($_cfg['Sys_LockSite'] and ($_user['uLevel'] < 90) and ($_GS['module'] != 'account/login'))
        goToURL($login_link . valueIf(_uid(), '?out=site_locked'));
    setPage('user', $_user);

    $_currs = array();
    foreach (array('USD', 'EUR', 'RUB', 'BTC', 'ETH', 'XRP') as $cn)
        foreach (array('Bal', 'Lock', 'Out') as $p)
//			if (($z = $_user["u$p$cn"]) != 0)
            $_currs[$cn][$p] = $_user["u$p$cn"];
    setPage('currs', $_currs);
    $_currs2 = $db->fetchIDRows($db->select('Currs LEFT JOIN Wallets ON wcID=cID and wuID=?d','*', 'cDisabled=0', array(_uid()), 'cID'), false, 'cID');

    // Main vars

    $_GS['lang'] = getLang($_SESSION['_lang']); // lang
    $_GS['lang_dir'] = 'tpl/'; // tpl lang dir

    $_TRANS = require_once('lib/trans/'.$_GS['lang'].'.php');

    setPage('_TRANS', $_TRANS, 0);

    setPage('_auth', $_auth);
    setPage('_cfg', $_cfg);
    setPage('root_url', $_GS['root_url']);
    setPage('current_lang', $_GS['lang']);
    setPage('img_path', 'images/' . $_GS['lang'] . '/');
    setPage('css_path', 'css/' . $_GS['lang'] . '/');

    @include_once($_GS['module_dir'] . 'udf.php');

    if ($_auth >= 90)
        $_onstart['admin'] = 90;

    // onStart init

    foreach ($_onstart as $m => $l)
        if ($_auth >= $l)
            if (file_exists($f = $_GS['module_dir'] . $m . '/onstart.php'))
                @include_once($f);

    if ($_smode < 1)
    {
        updateUserCounters();

        // Intro

        if ($_cfg['UI_ShowIntro'] and ($_GS['module'] == 'index') and !get1ElemL($_GS['uri'], '?'))
            if (($_cfg['UI_ShowIntro'] == 2) or _SESSION('show_intro'))
                if ($i = moduleToLink('udp/intro'))
                {
                    unset($_SESSION['show_intro']);
                    goToURL($i);
                }
    }

}
else // non-user mode
{
    $_currs = array();
    foreach (array('USD', 'EUR', 'RUB', 'BTC', 'ETH', 'XRP') as $cn)
        foreach (array('Bal', 'Lock', 'Out') as $p)
            $_currs[$cn][$p] = 0;
    $_currs2 = $db->fetchIDRows($db->select('Currs', '*', 'cDisabled=0', null, 'cID'), false, 'cID');
}

$_vcurrs = array(
    'USD' => array(),
    'EUR' => array(),
    'RUB' => array(),
    'BTC' => array(),
    'ETH' => array(),
    'XRP' => array()
);
foreach ($_currs2 as $cid => $c)
    $_vcurrs[$c['cCurrID']][] = $cid;
SetPage('vcurrs', $_vcurrs);

?>