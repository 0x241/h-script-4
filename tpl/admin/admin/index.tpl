{if $defAction eq 'add_to_menu'}

   {section name=i loop=$admin_links}
      <a href="javascript:void(0);" onclick="add_to_fav_menu('{$admin_links[i].url}', 1);"><img src="{$root_url}static/admin/img/star.png" alt=""/></a>  <a href="{_link module=$admin_links[i].url}">{$admin_links[i].name}</a>  {if !$smarty.section.i.last}<br />{/if}
   {/section}

 {elseif $defAction eq 'get_common_graph_data'}

                  <div class="stat" id="gd-registration" {if $gd_registration_select ne 1}style="display: none;"{/if}>
                    <div class="stat-tools">
                        <i class="ico ico-edit"><div>{$_AT['Show growth per day']} <input type="checkbox" id="gd-registration-day" value="1" onclick="change_day_profit('gd-registration');" checked/></div></i><i class="ico ico-rm" onclick="$('#gd-registration').slideUp();$('#gd_registration_select').prop('checked', false);get_common_graph_data();"></i>
                    </div>
                    <div class="stat-users">
                        <div class="stat-nums-users-label"><b>{$_AT['Users']}</b></div>
                        <div class="stat-nums-users-label">{$_AT['Quantity']}</div>
                        <div class="stat-users-nums">{$stats_total_list.gd_registration.total} <b id="gd-registration-day-data">+{$stats_total_list.gd_registration.today}</b></div>
                    </div>
                    <div id="gd-registration-data" class="stat-graph-container-registration" data-source='[{foreach key=key item=item from=$stats_list name=outer}{literal}{{/literal}"date": "{$smarty.foreach.outer.iteration}","val": "{if $item.gd_registration gt 0}{$item.gd_registration}{else}0{/if}"{literal}}{/literal}{if !$smarty.foreach.outer.last},{/if}{/foreach}]'></div>
                </div>

                <div class="stat" id="gd-accrual" {if $gd_accrual_select ne 1}style="display: none;"{/if}>
                    <div class="stat-tools">
                        <i class="ico ico-edit"><div>{$_AT['Show growth per day']} <input type="checkbox" id="gd-accrual-day" value="1" onclick="change_day_profit('gd-accrual');"  checked/></div></i><i class="ico ico-rm" onclick="$('#gd-accrual').slideUp();$('#gd_accrual_select').prop('checked', false);get_common_graph_data();"></i>
                    </div>
                    <div class="stat-users">
                        <div class="stat-nums-users-label"><b>{$_AT['sAccrual']}</b></div>
                        <div class="stat-nums-users-label">{$_AT['Quantity']}</div>
                        <div class="stat-users-nums">{$stats_total_list.gd_accrual.total} <b id="gd-accrual-day-data">+{$stats_total_list.gd_accrual.today}</b></div>
                    </div>
                    <div id="gd-accrual-data" class="stat-graph-container-accrual" data-source='[{foreach key=key item=item from=$stats_list name=outer}{literal}{{/literal}"date": "{$smarty.foreach.outer.iteration}","val": "{if $item.gd_accrual gt 0}{$item.gd_accrual}{else}0{/if}"{literal}}{/literal}{if !$smarty.foreach.outer.last},{/if}{/foreach}]'></div>
                </div>

                <div class="stat" id="gd-deposit" {if $gd_deposit_select ne 1}style="display: none;"{/if}>
                    <div class="stat-tools">
                        <i class="ico ico-edit"><div>{$_AT['Show growth per day']} <input type="checkbox" id="gd-deposit-day" value="1" onclick="change_day_profit('gd-deposit');"  checked/></div></i><i class="ico ico-rm" onclick="$('#gd-deposit').slideUp();$('#gd_deposit_select').prop('checked', false);get_common_graph_data();"></i>
                    </div>
                    <div class="stat-users">
                        <div class="stat-nums-users-label"><b>{$_AT['sDeposit']}</b></div>
                        <div class="stat-nums-users-label">{$_AT['Quantity']}</div>
                        <div class="stat-users-nums">{$stats_total_list.gd_deposit.total} <b id="gd-deposit-day-data">+{$stats_total_list.gd_deposit.today}</b></div>
                    </div>
                    <div id="gd-deposit-data" class="stat-graph-container-deposit" data-source='[{foreach key=key item=item from=$stats_list name=outer}{literal}{{/literal}"date": "{$smarty.foreach.outer.iteration}","val": "{if $item.gd_deposit gt 0}{$item.gd_deposit}{else}0{/if}"{literal}}{/literal}{if !$smarty.foreach.outer.last},{/if}{/foreach}]'></div>
                </div>

                <div class="stat" id="gd-contribution" {if $gd_contribution_select ne 1}style="display: none;"{/if}>
                    <div class="stat-tools">
                        <i class="ico ico-edit"><div>{$_AT['Show growth per day']} <input type="checkbox" id="gd-contribution-day" value="1" onclick="change_day_profit('gd-contribution');"  checked/></div></i><i class="ico ico-rm" onclick="$('#gd-contribution').slideUp();$('#gd_contribution_select').prop('checked', false);get_common_graph_data();"></i>
                    </div>
                    <div class="stat-users">
                        <div class="stat-nums-users-label"><b>{$_AT['sContribution']}</b></div>
                        <div class="stat-nums-users-label">{$_AT['Quantity']}</div>
                        <div class="stat-users-nums">{$stats_total_list.gd_contribution.total} <b id="gd-contribution-day-data">+{$stats_total_list.gd_contribution.today}</b></div>
                    </div>
                    <div class="stat-graph-container-contribution" id="gd-contribution-data" data-source='[{foreach key=key item=item from=$stats_list name=outer}{literal}{{/literal}"date": "{$smarty.foreach.outer.iteration}","val": "{if $item.gd_contribution gt 0}{$item.gd_contribution}{else}0{/if}"{literal}}{/literal}{if !$smarty.foreach.outer.last},{/if}{/foreach}]'></div>
                </div>

                <div class="stat" id="gd-withdraw" {if $gd_withdraw_select ne 1}style="display: none;"{/if}>
                    <div class="stat-tools">
                        <i class="ico ico-edit"><div>{$_AT['Show growth per day']} <input type="checkbox" id="gd-withdraw-day" value="1"  onclick="change_day_profit('gd-withdraw');"  checked/></div></i><i class="ico ico-rm" onclick="$('#gd-withdraw').slideUp();$('#gd_withdraw_select').prop('checked', false);get_common_graph_data();"></i>
                    </div>
                    <div class="stat-users">
                        <div class="stat-nums-users-label"><b>{$_AT['sWithdraw']}</b></div>
                        <div class="stat-nums-users-label">{$_AT['Quantity']}</div>
                        <div class="stat-users-nums">{$stats_total_list.gd_withdraw.total} <b id="gd-withdraw-day-data">+{$stats_total_list.gd_withdraw.today}</b></div>
                    </div>
                    <div id="gd-withdraw-data" class="stat-graph-container-withdraw" data-source='[{foreach key=key item=item from=$stats_list name=outer}{literal}{{/literal}"date": "{$smarty.foreach.outer.iteration}","val": "{if $item.gd_withdraw gt 0}{$item.gd_withdraw}{else}0{/if}"{literal}}{/literal}{if !$smarty.foreach.outer.last},{/if}{/foreach}]'></div>
                </div>

                <div class="stat" id="gd-output" {if $gd_output_select ne 1}style="display: none;"{/if}>
                    <div class="stat-tools">
                        <i class="ico ico-edit"><div>{$_AT['Show growth per day']} <input type="checkbox" id="gd-output-day" value="1"  onclick="change_day_profit('gd-output');" checked/></div></i><i class="ico ico-rm" onclick="$('#gd-output').slideUp();$('#gd_output_select').prop('checked', false);get_common_graph_data();"></i>
                    </div>
                    <div class="stat-users">
                        <div class="stat-nums-users-label"><b>{$_AT['sOutput']}</b></div>
                        <div class="stat-nums-users-label">{$_AT['Quantity']}</div>
                        <div class="stat-users-nums">{$stats_total_list.gd_output.total} <b id="gd-output-day-data">+{$stats_total_list.gd_output.today}</b></div>
                    </div>
                    <div id="gd-output-data" class="stat-graph-container-output" data-source='[{foreach key=key item=item from=$stats_list name=outer}{literal}{{/literal}"date": "{$smarty.foreach.outer.iteration}","val": "{if $item.gd_output gt 0}{$item.gd_output}{else}0{/if}"{literal}}{/literal}{if !$smarty.foreach.outer.last},{/if}{/foreach}]'></div>
                </div>

                <div class="stat" id="gd-reffs" {if $gd_reffs_select ne 1}style="display: none;"{/if}>
                    <div class="stat-tools">
                        <i class="ico ico-edit"><div>{$_AT['Show growth per day']} <input type="checkbox" id="gd-reffs-day" value="1"   onclick="change_day_profit('gd-reffs');"  checked/></div></i><i class="ico ico-rm" onclick="$('#gd-reffs').slideUp();$('#gd_reffs_select').prop('checked', false);get_common_graph_data();"></i>
                    </div>
                    <div class="stat-users">
                        <div class="stat-nums-users-label"><b>{$_AT['sReffs']}</b></div>
                        <div class="stat-nums-users-label">{$_AT['Quantity']}</div>
                        <div class="stat-users-nums">{$stats_total_list.gd_reffs.total} <b id="gd-reffs-day-data">+{$stats_total_list.gd_reffs.today}</b></div>
                    </div>
                    <div id="gd-reffs-data" class="stat-graph-container-reffs" data-source='[{foreach key=key item=item from=$stats_list name=outer}{literal}{{/literal}"date": "{$smarty.foreach.outer.iteration}","val": "{if $item.gd_reffs gt 0}{$item.gd_reffs}{else}0{/if}"{literal}}{/literal}{if !$smarty.foreach.outer.last},{/if}{/foreach}]'></div>
                </div>

 {else}

  {strip}

       {include file='admin/admin/header.tpl' title=''}

     <script>
       var lang = 'ru';
     </script>

     <script type="text/javascript" src="{$root_url}static/admin/js/jquery.datetimepicker.js"></script>
     <script type="text/javascript" src="{$root_url}static/admin/js/ydpicker.jquery.js"></script>
     <script type="text/javascript" src="{$root_url}static/admin/js/date.format.js"></script>

     <script src="{$root_url}static/admin/js/knockout.js"></script>
     <script src="{$root_url}static/admin/js/globalize.js"></script>
     <script src="{$root_url}static/admin/js/dx.chartjs.js"></script>

                        <script>
                          {literal}
                          $(document).ready(function() {
                            jQuery('#ydpicker-input-from').ydpicker({
                                id: '#ydpicker',
                                coupleCalendarId: '#ydpicker-input-to',
                                directionCoupleCalendar: 'from',
                                startDate: new Date(),
                                headerTitle: 'C'
                            });
                            jQuery('#ydpicker-input-to').ydpicker({
                                id: '#ydpicker1',
                                coupleCalendarId: '#ydpicker-input-from',
                                directionCoupleCalendar: 'to',
                                startDate: new Date(),
                                headerTitle: 'По'
                            });


                            jQuery('.cap-plus-list-el input').click(function(){
                                get_main_graph_data();
                            });
                            jQuery('#ydpicker-accept').click(function() {
                                get_main_graph_data();
                            });
                            jQuery('#currency_select').change(function() {
                               get_main_graph_data();
                            });
                            jQuery('#payment_system_select').change(function() {
                               get_main_graph_data();
                            });
                            jQuery('.cdp-plus-list-el input').click(function(){

                               jQuery('#'+jQuery(this).attr('data-id')).slideToggle();
                               get_common_graph_data();
                            });
                            jQuery('#currency-common-select').change(function() {
                             get_common_graph_data();
                            });
                         });
                         function get_common_graph_data()
                         {
                           $.ajax
	                         (
		                        {
                                  type: "POST",
                             {/literal}
                                  url: '{$root_url}admin',
                             {literal}
                                  data: "action=get_common_graph_data&currency="+$("#currency-common-select").val()+'&gd_registration_select=' + ($('#gd_registration_select').is(":checked")?1:0)+'&gd_accrual_select=' + ($('#gd_accrual_select').is(":checked")?1:0)+'&gd_deposit_select=' + ($('#gd_deposit_select').is(":checked")?1:0)+'&gd_contribution_select=' + ($('#gd_contribution_select').is(":checked")?1:0)+'&gd_withdraw_select=' + ($('#gd_withdraw_select').is(":checked")?1:0)+'&gd_output_select=' + ($('#gd_output_select').is(":checked")?1:0)+'&gd_reffs_select=' + ($('#gd_reffs_select').is(":checked")?1:0),
                                  success: function(data)
			                      {
			                        jQuery('#common_graphs_data').html(data);

	                                chartSmallInit($('.stat-graph-container-registration'),smallGraph);
									chartSmallInit($('.stat-graph-container-accrual'),smallGraph);
									chartSmallInit($('.stat-graph-container-deposit'),smallGraph);
									chartSmallInit($('.stat-graph-container-contribution'),smallGraph);
									chartSmallInit($('.stat-graph-container-withdraw'),smallGraph);
									chartSmallInit($('.stat-graph-container-output'),smallGraph);
									chartSmallInit($('.stat-graph-container-reffs'),smallGraph);
									}
                                }
	                        );
                         }
                         function get_main_graph_data(url)
                         {
                             $.ajax
	                         (
		                        {
                                  type: "POST",
                                  {/literal}
                                  url: '{$root_url}admin',
                                  {literal}
                                  data: "action=get_main_graph_data&Graph[deposit]="+($('#graph_deposit').is(":checked")?1:0)+"&Graph[bonus]="+($('#graph_bonus').is(":checked")?1:0)+"&Graph[fine]="+($('#graph_fine').is(":checked")?1:0)+"&Graph[reffs]=" +($('#graph_reffs').is(":checked")?1:0)+"&Graph[contribution]=" + ($('#graph_contribution').is(":checked")?1:0)+"&Graph[withdraw]="+($('#graph_withdraw').is(":checked")?1:0) + "&Graph[accrual]=" + ($('#graph_accrual').is(":checked")?1:0)+"&Graph[write]="+($('#graph_write').is(":checked")?1:0)+"&Graph[wait]="+($('#graph_wait').is(":checked")?1:0)+"&Graph[output]=" + ($('#graph_output').is(":checked")?1:0)+"&currency_select="+$("#currency_select").val()+"&payment_system_select=" + $("#payment_system_select").val()+"&date_from=" + jQuery('#ydpicker-input-from').val() + "&date_to=" + jQuery('#ydpicker-input-to').val()+"&Graph[deposit_balance]="+($('#graph_deposit_balance').is(":checked")?1:0)+"&Graph[active_deposit]="+($('#graph_active_deposit').is(":checked")?1:0)+"&Graph[available_balance]="+($('#graph_available_balance').is(":checked")?1:0)+"&Graph[busy_balance]="+($('#graph_busy_balance').is(":checked")?1:0)+"&Graph[wait_balance]="+($('#graph_wait_balance').is(":checked")?1:0)+"&Graph[reg]="+($('#graph_reg').is(":checked")?1:0)+"&date_range=" + $("#ydpicker-input-range").val(),
                                  success: function(data)
			                      {

			                        $('.chart-stat-container').attr( 'data-source',data.data);

                                    var indexGraph = {
	                                                commonSeriesSettings: {
	                                             	        argumentField: 'date',
		                                                    point: {size: 5}
                                                    },
                                                   	series: indexGraphMass,
	                                                argumentAxis: {
                                                		valueMarginsEnabled: false,
	                                                 	discreteAxisDivisionMode: 'crossLabels',
	                                                 	label: {alignment: 'left'}
                                                 	},
                                                	valueAxis: {
	                                             	min: 0,
	                                              	max: data.max,
		                                            tickInterval: data.tickInterval,
	                                                label: {
			                                             precision: 5,
			                                             customizeText: function(){
				                                         return this.valueText/1000 + ' k';
		                                                	}
	                                             	},
	                                            	visible: true
                                                	},
                                                 	legend: {visible: false},
                                                    tooltip: {
	                                             	enabled: true,
	                                            	color: '#7f7f7f',
                                            		paddingLeftRight: 10,
                                              		paddingTopBottom: 4,
                                              		arrowLength: 5,
                                            		font: {
	                                         	          color: 'white',
	                                                      family: 'Arial',
	                                                      size: 12
	                                                     },
	                                              customizeText: function (e) {
	                                              return e.argumentText+' - '+e.originalValue;
	                                             }
                                            	},
                                               adjustOnZoom: true
                                                };

                                               chartInit($('.chart-stat-container'),indexGraph);
			                      }
                                }
	                        );
                        }
                        function change_day_profit(type)
                        {
                            if ($('#'+type+'-day').is(":checked"))
                            {
                               $('#'+type+'-day-data').show();
                            }
                            else
                            {
                               $('#'+type+'-day-data').hide();
                            }
                        }
                        {/literal}
                        </script>
<form method="get">
<div class="content_white">
                <h1 class="cfix" style="position: relative;">
                    {$_AT['Statistics']}
                    <select name="payment_system_select" id="payment_system_select" class="payment-select">
                        <option value="">--все--</option>
                        {section name=i loop=$payment_system_list}
                          <option value="{$payment_system_list[i].cID}" {if $payment_system_select eq $payment_system_list[i].cID}selected{/if}>{$payment_system_list[i].cName}</option>
                        {/section}
                    </select>
                    <select name="currency_select" id="currency_select" class="currency-select">
                        <option value="USD" class="usd" {if $currency_select eq 'USD'}selected{/if}>USD</option>
                        <option value="RUB" class="rub" {if $currency_select eq 'RUB'}selected{/if}>RUB</option>
                        <option value="EUR" class="eur" {if $currency_select eq 'EUR'}selected{/if}>EUR</option>
                        <option value="BTC" class="btc" {if $currency_select eq 'BTC'}selected{/if}>BTC</option>
                        <option value="ETH" class="eth" {if $currency_select eq 'ETH'}selected{/if}>ETH</option>
                        <option value="XRP" class="xrp" {if $currency_select eq 'XRP'}selected{/if}>XRP</option>
                    </select>
                    <div class="index_block_date form_block_el_right date">
                        <input type="text" class="ydpicker_click" id="ydpicker-date-range" value="{$date_str}">
                        <div class="ydpicker-block">
                            <div id="ydpicker"></div><div id="ydpicker1"></div>
                            <div class="ydpicker-block_right">
                                <label for="">Временной отрезок:</label>
                                <select name="ydpicker-input-range" id="ydpicker-input-range">
                                    <option value="now" {if $date_range eq 'now'}selected{/if}>Cегодня</option>
                                    <option value="yesterday" {if $date_range eq 'yesterday'}selected{/if}>Вчера</option>
                                    <option value="lastweek" {if $date_range eq 'lastweek'}selected{/if}>Прошлая неделя</option>
                                    <option value="lastmonth" {if $date_range eq 'lastmonth'}selected{/if}>Прошлый месяц</option>
                                    <option value="last7days" {if $date_range eq 'last7days'}selected{/if}>Последние 7 дней</option>
                                    <option value="last30days" {if $date_range eq 'last30days'}selected{/if}>Последние 30 дней</option>
                                </select>
                                <label for="">Диапазон дат:</label>
                                <div class="ydpicker-block_right_range cfix">
                                    <input type="text" name="ydpicker-input-from" id="ydpicker-input-from" value="{$from_date}">
                                    <span>-</span>
                                    <input type="text" name="ydpicker-input-to" id="ydpicker-input-to" value="{$to_date}">
                                </div>
                                <div class="ydpicker-block_buttons cfix">
                                    <div href="" class="button-blue" id="ydpicker-accept">Применить</div>
                                    <a href="" class="button-gray" id="ydpicker-exit">Отменить</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </h1>
                <div class="chart-added-position cfix">
                    <div class="cap-plus">
                        <span>+</span>
                        <div class="cap-plus-list">
                            <div class="cap-plus-list-el cfix">
                                <input type="checkbox" name="Graph[deposit]" id="graph_deposit" value="1" {if $Graph.deposit eq 1}checked{/if}/>
                                <label for=""class="deposit"><span></span>{$_AT['sDeposit']}</label>
                            </div>
                            <div class="cap-plus-list-el cfix">
                                <input type="checkbox" name="Graph[bonus]" id="graph_bonus" value="1" {if $Graph.bonus eq 1}checked{/if}/>
                                <label for="" class="bonus"><span></span>Бонус</label>
                            </div>
                            <div class="cap-plus-list-el cfix">
                                <input type="checkbox" name="Graph[fine]" id="graph_fine" value="1" {if $Graph.fine eq 1}checked{/if}/>
                                <label for="" class="fine"><span></span>Штраф</label>
                            </div>
                            <div class="cap-plus-list-el cfix">
                                <input type="checkbox" name="Graph[reffs]" id="graph_reffs" value="1" {if $Graph.reffs eq 1}checked{/if}/>
                                <label for="" class="reffs"><span></span>{$_AT['sReffs']}</label>
                            </div>
                            <div class="cap-plus-list-el cfix">
                                <input type="checkbox" name="Graph[contribution]" id="graph_contribution" value="1"  {if $Graph.contribution eq 1}checked{/if}/>
                                <label for="" class="contribution"><span></span>{$_AT['sContribution']}</label>
                            </div>
                            <div class="cap-plus-list-el cfix">
                                <input type="checkbox" name="Graph[withdraw]" id="graph_withdraw" value="1"  {if $Graph.withdraw eq 1}checked{/if}/>
                                <label for="" class="withdraw"><span></span>{$_AT['sWithdraw']}</label>
                            </div>
                            <div class="cap-plus-list-el cfix">
                                <input type="checkbox" name="Graph[accrual]" id="graph_accrual" value="1"  {if $Graph.accrual eq 1}checked{/if}/>
                                <label for="" class="accrual"><span></span>{$_AT['sAccrual']}</label>
                            </div>
                            <div class="cap-plus-list-el cfix">
                                <input type="checkbox" name="Graph[write]" id="graph_write" value="1"  {if $Graph.write eq 1}checked{/if}/>
                                <label for="" class="write"><span></span>{$_AT['Calcout']}</label>
                            </div>
                            <div class="cap-plus-list-el cfix">
                                <input type="checkbox" name="Graph[wait]" id="graph_wait" value="1"  {if $Graph.wait eq 1}checked{/if}/>
                                <label for="" class="wait"><span></span>{$_AT['Pending']}</label>
                            </div>
                            <div class="cap-plus-list-el cfix">
                                <input type="checkbox" name="Graph[output]" id="graph_output" value="1"  {if $Graph.output eq 1}checked{/if}/>
                                <label for="" class="output"><span></span>{$_AT['sOutput']}</label>
                            </div>
                            <div class="cap-plus-list-el cfix">
                                <input type="checkbox" name="Graph[deposit_balance]" id="graph_deposit_balance" value="1"  {if $Graph.deposit_balance eq 1}checked{/if}/>
                                <label for="" class="deposit_balance"><span></span>{$_AT['sContribution with balance']}</label>
                            </div>
                            <div class="cap-plus-list-el cfix">
                                <input type="checkbox" name="Graph[active_deposit]" id="graph_active_deposit" value="1"  {if $Graph.active_deposit eq 1}checked{/if}/>
                                <label for="" class="active_deposit"><span></span>{$_AT['sActive deposits']}</label>
                            </div>
                            <div class="cap-plus-list-el cfix">
                                <input type="checkbox" name="Graph[available_balance]" id="graph_available_balance" value="1"  {if $Graph.available_balance eq 1}checked{/if}/>
                                <label for="" class="output"><span></span>{$_AT['sBalance (available)']}</label>
                            </div>
                            <div class="cap-plus-list-el cfix">
                                <input type="checkbox" name="Graph[busy_balance]" id="graph_busy_balance" value="1"  {if $Graph.graph_busy_balance eq 1}checked{/if}/>
                                <label for="" class="busy_balance"><span></span>{$_AT['sBalance (occupied)']}</label>
                            </div>
                            <div class="cap-plus-list-el cfix">
                                <input type="checkbox" name="Graph[wait_balance]" id="graph_wait_balance" value="1"  {if $Graph.wait_balance eq 1}checked{/if}/>
                                <label for="" class="wait_balance"><span></span>{$_AT['sBalance (pending)']}</label>
                            </div>
                            <div class="cap-plus-list-el cfix">
                                <input type="checkbox" name="Graph[reg]" id="graph_reg" value="1"  {if $Graph.reg eq 1}checked{/if}/>
                                <label for="" class="reg"><span></span>{$_AT['sRegistration']}</label>
                            </div>
                        </div>
                    </div>
                    <div class="cap-elements cfix">
                      {if $Graph.deposit eq 1}
                        <div class="cap-elements-el cfix">
                           <label class="deposit" for=""><span></span>{$_AT['sDeposit']}</label>
                        </div>
                      {/if}
                      {if $Graph.bonus eq 1}
                        <div class="cap-elements-el cfix">
                           <label class="bonus" for=""><span></span>{$_AT['sBonus']}</label>
                        </div>
                      {/if}
                      {if $Graph.fine eq 1}
                      <div class="cap-elements-el cfix">
                         <label class="fine" for=""><span></span>{$_AT['sPenalty']}</label>
                      </div>
                      {/if}
                      {if $Graph.reffs eq 1}
                      <div class="cap-elements-el cfix">
                        <label class="reffs" for=""><span></span>{$_AT['sReffs']}</label>
                      </div>
                      {/if}
                      {if $Graph.contribution eq 1}
                      <div class="cap-elements-el cfix">
                        <label class="contribution" for=""><span></span>{$_AT['sContribution']}</label>
                      </div>
                      {/if}
                      {if $Graph.withdraw eq 1}
                      <div class="cap-elements-el cfix">
                        <label class="withdraw" for=""><span></span>{$_AT['sWithdraw']}</label>
                      </div>
                      {/if}
                      {if $Graph.accrual eq 1}
                      <div class="cap-elements-el cfix">
                        <label class="accrual" for=""><span></span>{$_AT['sAccrual']}</label>
                      </div>
                      {/if}
                      {if $Graph.write eq 1}
                      <div class="cap-elements-el cfix">
                        <label class="write" for=""><span></span>{$_AT['sWrite']}</label>
                      </div>
                      {/if}
                      {if $Graph.wait eq 1}
                      <div class="cap-elements-el cfix">
                        <label class="wait" for=""><span></span>{$_AT['sWait']}</label>
                      </div>
                      {/if}
                      {if $Graph.output eq 1}
                      <div class="cap-elements-el cfix">
                        <label class="output" for=""><span></span>{$_AT['sOutput']}</label>
                      </div>
                      {/if}
                      {if $Graph.deposit_balance eq 1}
                      <div class="cap-elements-el cfix">
                        <label class="deposit_balance" for=""><span></span>{$_AT['sContribution with balance']}</label>
                      </div>
                      {/if}
                      {if $Graph.active_deposit eq 1}
                      <div class="cap-elements-el cfix">
                        <label class="active_deposit" for=""><span></span>{$_AT['sActive deposits']}</label>
                      </div>
                      {/if}
                      {if $Graph.available_balance eq 1}
                      <div class="cap-elements-el cfix">
                        <label class="available_balance" for=""><span></span>{$_AT['sBalance (available)']}</label>
                      </div>
                      {/if}
                      {if $Graph.busy_balance eq 1}
                      <div class="cap-elements-el cfix">
                        <label class="busy_balance" for=""><span></span>{$_AT['sBalance (occupied)']}</label>
                      </div>
                      {/if}
                      {if $Graph.wait_balance eq 1}
                      <div class="cap-elements-el cfix">
                        <label class="wait_balance" for=""><span></span>{$_AT['sBalance (pending)']}</label>
                      </div>
                      {/if}
                      {if $Graph.reg eq 1}
                      <div class="cap-elements-el cfix">
                        <label class="reg" for=""><span></span>{$_AT['sRegistration']}</label>
                      </div>
                      {/if}
                    </div>
                </div>
                <div style="clear:both"></div>
                <div class="chart-stat-container" id="chart-stat-container" width="100%" data-source='[{foreach key=key item=item from=$operation_list name=outer}{literal}{{/literal}"date": "{$key}"{foreach key=key2 item=item2 from=$operation_graph name=outer2}, "{$item2}": "{if $item.$item2 gt 0}{$item.$item2}{else}0{/if}"{/foreach}{literal}}{/literal}{if !$smarty.foreach.outer.last},{/if}{/foreach}]'></div>
            </div>
            </form>
            <br/>
            <div class="content_white cfix">
                <h1 class="cfix" style="position: relative;">
                    Общая статистика проекта
                    <select name="currency-common-select" id="currency-common-select" class="currency-select">
                        <option value="USD" class="usd" {if $gd_currency_select eq 'USD'}selected{/if}>USD</option>
                        <option value="RUB" class="rub" {if $gd_currency_select eq 'RUB'}selected{/if}>RUB</option>
                        <option value="EUR" class="eur" {if $gd_currency_select eq 'EUR'}selected{/if}>EUR</option>
                        <option value="BTC" class="btc" {if $gd_currency_select eq 'BTC'}selected{/if}>BTC</option>
                        <option value="ETH" class="eth" {if $gd_currency_select eq 'ETH'}selected{/if}>ETH</option>
                        <option value="XRP" class="xrp" {if $gd_currency_select eq 'XRP'}selected{/if}>XRP</option>
                    </select>
                </h1>

                <div class="chart-default-position cfix">
                    <div class="cdp-plus">
                        <span>+</span>
                        <div class="cdp-plus-list">
                            <div class="cdp-plus-list-el cfix">
                                <input type="checkbox" name="GraphDefault[registration]" data-id="gd-registration" id="gd_registration_select" value="1" {if $gd_registration_select eq 1}checked="checked"{/if}>
                                <label for=""><span></span>{$_AT['sRegistration']}</label>
                            </div>
                            <div class="cdp-plus-list-el cfix">
                                <input type="checkbox" name="GraphDefault[accrual]" data-id="gd-accrual"  value="1" id="gd_accrual_select" {if $gd_accrual_select eq 1}checked="checked"{/if}/>
                                <label for=""><span></span>{$_AT['sAccrual']}</label>
                            </div>
                            <div class="cdp-plus-list-el cfix">
                                <input type="checkbox" name="GraphDefault[deposit]" data-id="gd-deposit" value="1" id="gd_deposit_select" {if $gd_deposit_select eq 1}checked="checked"{/if}/>
                                <label for=""><span></span>{$_AT['sDeposit']}</label>
                            </div>
                            <div class="cdp-plus-list-el cfix">
                                <input type="checkbox" name="GraphDefault[contribution]" data-id="gd-contribution" value="1" id="gd_contribution_select" {if $gd_contribution_select eq 1}checked="checked"{/if}/>
                                <label for=""><span></span>{$_AT['sContribution']}</label>
                            </div>
                            <div class="cdp-plus-list-el cfix">
                                <input type="checkbox" name="GraphDefault[withdraw]" data-id="gd-withdraw" value="1" id="gd_withdraw_select" {if $gd_withdraw_select eq 1}checked="checked"{/if}/>
                                <label for=""><span></span>{$_AT['sWithdraw']}</label>
                            </div>
                            <div class="cdp-plus-list-el cfix">
                                <input type="checkbox" name="GraphDefault[output]" data-id="gd-output" value="1" id="gd_output_select" {if $gd_output_select eq 1}checked="checked"{/if}/>
                                <label for=""><span></span>{$_AT['sOutput']}</label>
                            </div>
                            <div class="cdp-plus-list-el cfix">
                                <input type="checkbox" name="GraphDefault[reffs]" data-id="gd-reffs" value="1" id="gd_reffs_select" {if $gd_reffs_select eq 1}checked="checked"{/if}/>
                                <label for=""><span></span>{$_AT['sReffs']}</label>
                            </div>
                        </div>
                    </div>
                    <div class="cfix"></div>
                    {*<div class="cap-elements cfix"></div>*}
                </div>
                <div style="clear:both"></div>

                <div id="common_graphs_data">
                   <div class="stat" id="gd-registration" {if $gd_registration_select ne 1}style="display:none;"{/if}>
                    <div class="stat-tools">
                        <i class="ico ico-edit"><div>{$_AT['Show growth per day']} <input type="checkbox" id="gd-registration-day" value="1" onclick="change_day_profit('gd-registration');" checked/></div></i><i class="ico ico-rm" onclick="$('#gd-registration').slideUp(); $('#gd_registration_select').prop('checked', false);get_common_graph_data();"></i>
                    </div>
                    <div class="stat-users">
                        <div class="stat-nums-users-label"><b>{$_AT['Users']}</b></div>
                        <div class="stat-nums-users-label">{$_AT['Quantity']}</div>
                        <div class="stat-users-nums">{$stats_total_list.gd_registration.total} <b id="gd-registration-day-data">+{$stats_total_list.gd_registration.today}</b></div>
                    </div>
                    <div id="gd-registration-data" class="stat-graph-container-registration" data-source='[{foreach key=key item=item from=$stats_list name=outer}{literal}{{/literal}"date": "{$smarty.foreach.outer.iteration}","val": "{if $item.gd_registration gt 0}{$item.gd_registration}{else}0{/if}"{literal}}{/literal}{if !$smarty.foreach.outer.last},{/if}{/foreach}]'></div>
                </div>

                <div class="stat" id="gd-accrual"  {if $gd_accrual_select ne 1}style="display:none;"{/if}>
                    <div class="stat-tools">
                        <i class="ico ico-edit"><div>{$_AT['Show growth per day']} <input type="checkbox" id="gd-accrual-day" value="1" onclick="change_day_profit('gd-accrual');"  checked/></div></i><i class="ico ico-rm" onclick="$('#gd-accrual').slideUp(); $('#gd_accrual_select').prop('checked', false);get_common_graph_data();"></i>
                    </div>
                    <div class="stat-users">
                        <div class="stat-nums-users-label"><b>{$_AT['sAccrual']}</b></div>
                        <div class="stat-nums-users-label">{$_AT['Quantity']}</div>
                        <div class="stat-users-nums">{$stats_total_list.gd_accrual.total} <b id="gd-accrual-day-data">+{$stats_total_list.gd_accrual.today}</b></div>
                    </div>
                    <div id="gd-accrual-data" class="stat-graph-container-accrual" data-source='[{foreach key=key item=item from=$stats_list name=outer}{literal}{{/literal}"date": "{$smarty.foreach.outer.iteration}","val": "{if $item.gd_accrual gt 0}{$item.gd_accrual}{else}0{/if}"{literal}}{/literal}{if !$smarty.foreach.outer.last},{/if}{/foreach}]'></div>
                </div>

                <div class="stat" id="gd-deposit" {if $gd_deposit_select ne 1}style="display:none;"{/if}>
                    <div class="stat-tools">
                        <i class="ico ico-edit"><div>{$_AT['Show growth per day']} <input type="checkbox" id="gd-deposit-day" value="1" onclick="change_day_profit('gd-deposit');"  checked/></div></i><i class="ico ico-rm" onclick="$('#gd-deposit').slideUp(); $('#gd_deposit_select').prop('checked', false);get_common_graph_data();"></i>
                    </div>
                    <div class="stat-users">
                        <div class="stat-nums-users-label"><b>{$_AT['sDeposit']}</b></div>
                        <div class="stat-nums-users-label">{$_AT['Quantity']}</div>
                        <div class="stat-users-nums">{$stats_total_list.gd_deposit.total} <b id="gd-deposit-day-data">+{$stats_total_list.gd_deposit.today}</b></div>
                    </div>
                    <div id="gd-deposit-data" class="stat-graph-container-deposit" data-source='[{foreach key=key item=item from=$stats_list name=outer}{literal}{{/literal}"date": "{$smarty.foreach.outer.iteration}","val": "{if $item.gd_deposit gt 0}{$item.gd_deposit}{else}0{/if}"{literal}}{/literal}{if !$smarty.foreach.outer.last},{/if}{/foreach}]'></div>
                </div>

                <div class="stat" id="gd-contribution" {if $gd_contribution_select ne 1}style="display:none;"{/if}>
                    <div class="stat-tools">
                        <i class="ico ico-edit"><div>{$_AT['Show growth per day']} <input type="checkbox" id="gd-contribution-day" value="1" onclick="change_day_profit('gd-contribution');"  checked/></div></i><i class="ico ico-rm" onclick="$('#gd-contribution').slideUp(); $('#gd_contribution_select').prop('checked', false);get_common_graph_data();"></i>
                    </div>
                    <div class="stat-users">
                        <div class="stat-nums-users-label"><b>{$_AT['sContribution']}</b></div>
                        <div class="stat-nums-users-label">{$_AT['Quantity']}</div>
                        <div class="stat-users-nums">{$stats_total_list.gd_contribution.total} <b id="gd-contribution-day-data">+{$stats_total_list.gd_contribution.today}</b></div>
                    </div>
                    <div class="stat-graph-container-contribution" id="gd-contribution-data" data-source='[{foreach key=key item=item from=$stats_list name=outer}{literal}{{/literal}"date": "{$smarty.foreach.outer.iteration}","val": "{if $item.gd_contribution gt 0}{$item.gd_contribution}{else}0{/if}"{literal}}{/literal}{if !$smarty.foreach.outer.last},{/if}{/foreach}]'></div>
                </div>

                <div class="stat" id="gd-withdraw" {if $gd_withdraw_select ne 1}style="display:none;"{/if}>
                    <div class="stat-tools">
                        <i class="ico ico-edit"><div>{$_AT['Show growth per day']} <input type="checkbox" id="gd-withdraw-day" value="1"  onclick="change_day_profit('gd-withdraw');"  checked/></div></i><i class="ico ico-rm" onclick="$('#gd-withdraw').slideUp();$('#gd_withdraw_select').prop('checked', false);get_common_graph_data();"></i>
                    </div>
                    <div class="stat-users">
                        <div class="stat-nums-users-label"><b>{$_AT['sWithdraw']}</b></div>
                        <div class="stat-nums-users-label">{$_AT['Quantity']}</div>
                        <div class="stat-users-nums">{$stats_total_list.gd_withdraw.total} <b id="gd-withdraw-day-data">+{$stats_total_list.gd_withdraw.today}</b></div>
                    </div>
                    <div id="gd-withdraw-data" class="stat-graph-container-withdraw" data-source='[{foreach key=key item=item from=$stats_list name=outer}{literal}{{/literal}"date": "{$smarty.foreach.outer.iteration}","val": "{if $item.gd_withdraw gt 0}{$item.gd_withdraw}{else}0{/if}"{literal}}{/literal}{if !$smarty.foreach.outer.last},{/if}{/foreach}]'></div>
                </div>

                <div class="stat" id="gd-output"  {if $gd_output_select ne 1}style="display:none;"{/if}>
                    <div class="stat-tools">
                        <i class="ico ico-edit"><div>{$_AT['Show growth per day']} <input type="checkbox" id="gd-output-day" value="1"  onclick="change_day_profit('gd-output');" checked/></div></i><i class="ico ico-rm" onclick="$('#gd-output').slideUp();$('#gd_output_select').prop('checked', false);get_common_graph_data();"></i>
                    </div>
                    <div class="stat-users">
                        <div class="stat-nums-users-label"><b>{$_AT['sOutput']}</b></div>
                        <div class="stat-nums-users-label">{$_AT['Quantity']}</div>
                        <div class="stat-users-nums">{$stats_total_list.gd_output.total} <b id="gd-output-day-data">+{$stats_total_list.gd_output.today}</b></div>
                    </div>
                    <div id="gd-output-data" class="stat-graph-container-output" data-source='[{foreach key=key item=item from=$stats_list name=outer}{literal}{{/literal}"date": "{$smarty.foreach.outer.iteration}","val": "{if $item.gd_output gt 0}{$item.gd_output}{else}0{/if}"{literal}}{/literal}{if !$smarty.foreach.outer.last},{/if}{/foreach}]'></div>
                </div>

                <div class="stat" id="gd-reffs" {if $gd_reffs_select ne 1}style="display:none;"{/if}>
                    <div class="stat-tools">
                        <i class="ico ico-edit"><div>{$_AT['Show growth per day']} <input type="checkbox" id="gd-reffs-day" value="1"   onclick="change_day_profit('gd-reffs');"  checked/></div></i><i class="ico ico-rm" onclick="$('#gd-reffs').slideUp();$('#gd_reffs_select').prop('checked', false);get_common_graph_data();"></i>
                    </div>
                    <div class="stat-users">
                        <div class="stat-nums-users-label"><b>{$_AT['sReffs']}</b></div>
                        <div class="stat-nums-users-label">{$_AT['Quantity']}</div>
                        <div class="stat-users-nums">{$stats_total_list.gd_reffs.total} <b id="gd-reffs-day-data">+{$stats_total_list.gd_reffs.today}</b></div>
                    </div>
                    <div id="gd-reffs-data" class="stat-graph-container-reffs" data-source='[{foreach key=key item=item from=$stats_list name=outer}{literal}{{/literal}"date": "{$smarty.foreach.outer.iteration}","val": "{if $item.gd_reffs gt 0}{$item.gd_reffs}{else}0{/if}"{literal}}{/literal}{if !$smarty.foreach.outer.last},{/if}{/foreach}]'></div>
                </div>
                </div>
            </div>
            <script src="{$root_url}static/admin/js/chartData.js"></script>
           <script src="{$root_url}static/admin/js/chartSmallData.js"></script>

           <script>
           {literal}
             var indexGraph = {
	commonSeriesSettings: {
		argumentField: 'date',
		point: {size: 5}
	},
	series: indexGraphMass,
	argumentAxis: {
		valueMarginsEnabled: false,
		discreteAxisDivisionMode: 'crossLabels',
		label: {alignment: 'left'}
	},
	valueAxis: {
		min: 0,
   {/literal}
		max: {if $max_summ_operation gt 0}{$max_summ_operation}{else}1000{/if},
		tickInterval: {if $max_summ_operation gt 0}{$summ_interval}{else}10{/if},
   {literal}
		label: {
			precision: 5,
			customizeText: function(){
				return this.valueText/1000 + ' k';
			}
		},
		visible: true
	},
	legend: {visible: false},
	tooltip: {
		enabled: true,
		color: '#7f7f7f',
		paddingLeftRight: 10,
		paddingTopBottom: 4,
		arrowLength: 5,
		font: {
	    	color: 'white',
	        family: 'Arial',
	        size: 12
	    },
	    customizeText: function (e) {
	    	return e.argumentText+' - '+e.originalValue;
	    }
	},
    adjustOnZoom: true
};

(function($){
	// Chart general
	chartInit($('.chart-stat-container'),indexGraph);

})(jQuery);
           {/literal}
           </script>

{include file='admin/admin/footer.tpl'}
{/strip}

{/if}