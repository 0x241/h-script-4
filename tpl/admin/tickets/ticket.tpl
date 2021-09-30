{strip}
{include file='admin/admin/header.tpl' title=$_AT['Ticket']}

{include file='tickets/_states.tpl'}

{if $el.tID}

	{include file='edit_admin.tpl'
		form='ticket'
		title=$_AT['Ticket']
		fields=[
			'tID'=>[],
			'tState'=>
				[
					'X',
					$_AT['State'],
					0,
					$_tstates[$el.tState]
				],
			'uLogin'=>
				[
					'T',
					$_AT['Sender'],
					'skip'=>!$el.uLogin,
					'readonly'=>true
				],
			'tMail'=>
				[
					'T',
					$_AT['sender e-mail'],
					'skip'=>!$el.mMail,
					'readonly'=>true
				],
			'tTopic'=>
				[
					'L',
					$_AT['Subject'],
					'size'=>50,
					'readonly'=>true
				],
			'tText'=>
				[
					'W',
					$_AT['Text'],
					'size'=>10,
					'readonly'=>true
				]
		]
		values=$el
		btn_text=' '
		btns=valueIf($el.tState < 8, ['close'=>$_AT['Close ticket']])
	}

	<table class="FromatTable">
	{foreach $list as $l}
		<tr><td width="250px"><td width="250px"><td width="250px"></tr>
		<tr>
			{if $l.muID == $el.tuID}
				<td colspan="2">
			{else}
				<td><td colspan="2">
			{/if}
			<fieldset>
			{$l.mTS} [{$l.aName}]<br>
			<br>
			{$l.mText}
			</fieldset>
			</td>
		</tr>
	{/foreach}
	</table><br>

	{if $el.tState < 8}

		{include file='edit_admin.tpl'
			fields=[
				'tID'=>$el.tID,
				'mText'=>
					[
						'W',
						$_AT['Response!!'],
						[
							'text_empty'=>$_AT['fill text']
						],
						'size'=>10
					]
			]
			values=$el
			btn_text=' '
			btns=['answer'=>$_AT['Answer']]
		}

	{/if}

{else}

	{include file='edit_admin.tpl'
		title=$_AT['New ticket']
		fields=[
			'uLogin'=>
				[
					'T',
					$_AT['Sender'],
					[
						'user_not_found'=>$_AT['user not found']
					],
					'default'=>valueIf(!$el.mMail, exValue($user.uLogin, $smarty.get.from))
				],
			'tMail'=>
				[
					'T',
					$_AT['sender e-mail'],
					[
						'mail_wrong'=>$_AT['wrong e-mail']
					],
					'skip'=>true
				],
			'tTopic'=>
				[
					'L',
					$_AT['Subject!!'],
					[
						'topic_empty'=>$_AT['type subject']
					],
					'size'=>50
				],
			'tText'=>
				[
					'W',
					$_AT['Text!!'],
					[
						'text_empty'=>$_AT['type text']
					],
					'size'=>15
				]
		]
		values=$el
		btn_text=' '
		btns=['create'=>$_AT['Create']]
	}

{/if}

{include file='admin/admin/footer.tpl'}
{/strip}