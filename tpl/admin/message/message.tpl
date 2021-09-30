{strip}
{include file='admin/admin/header.tpl' title=$_AT['Message']}

{if $el.mID}

	{include file='edit_admin.tpl'
		title=$_AT['Message']
		fields=[
			'uLogin'=>
				[
					'T',
					$_AT['Sender'],
					'skip'=>!$el.uLogin,
					'readonly'=>true
				],
			'mMail'=>
				[
					'T',
					$_AT['Sender`s e-mail'],
					'skip'=>!$el.mMail,
					'readonly'=>true
				],
			'To1'=>
				[
					'T',
					$_AT['Receiver'],
					'default'=>$el.mTo,
					'skip'=>($el.mToCnt != 1),
					'readonly'=>true
				],
			'mTo'=>
				[
					'A',
					$_AT['Receivers<br><<* - each>>']|html_entity_decode,
					'size'=>30,
					'skip'=>($el.mToCnt == 1),
					'readonly'=>true
				],
			'mAttn'=>
				[
					'CC',
					$_AT['Important'],
					'readonly'=>true
				],
			'mTopic'=>
				[
					'L',
					$_AT['Topic'],
					'size'=>50,
					'readonly'=>true
				],
			'mText'=>
				[
					'W',
					$_AT['Text'],
					'size'=>15,
					'readonly'=>true
				]
		]
		values=$el
		btn_text=' '
	}

	{if $el.mToCnt == 1}
		<a href="{_link module='message/admin/message'}?add&re={$el.mID}" class="button-blue">{$_AT['Answer']}</a><br>
	{/if}

{else}

	{include file='edit_admin.tpl'
		title=$_AT['New message']
		fields=[
			'Re'=>[],
			'uLogin'=>
				[
					'T',
					$_AT['Sebder'],
					[
						'user_not_found'=>$_AT['user not found']
					],
					'default'=>valueIf(!$el.mMail, exValue($user.uLogin, $smarty.get.from))
				],
			'mMail'=>
				[
					'T',
					$_AT['Sender`s e-mail'],
					[
						'mail_wrong'=>$_AT['wrong e-mail']
					]
				],
			'mTo'=>
				[
					'A',
					$_AT['Receivers!!<br><<To send to e-mail use prifix "mailto:">>']|html_entity_decode,
					[
						'to_empty'=>$_AT['input receivers'],
						'to_wrong'=>$_AT['receivers not found']|cat:": [$wrusrs]"
					],
					'size'=>30,
					'default'=>$smarty.get.to,
					'comment'=>$el.mLang
				],
			'mAttn'=>
				[
					'CC',
					$_AT['Important']
				],
			'Feed'=>
				[
					'CC',
					$_AT['Feed <<force text>>']|html_entity_decode
				],
			'mTopic'=>
				[
					'L',
					$_AT['Topic!!'],
					[
						'topic_empty'=>$_AT['input topic']
					],
					'size'=>50
				],
			'mText'=>
				[
					'Y',
					$_AT['Text!!'],
					[
						'text_empty'=>$_AT['input text']
					],
					'size'=>15
				]
		]
		values=$el
		btn_text=' '
		btns=['send'=>$_AT['Send']]
	}

{/if}

{include file='admin/admin/footer.tpl'}
{/strip}