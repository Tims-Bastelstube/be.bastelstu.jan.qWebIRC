{include file='documentHeader'}

<head>
	<title>{lang}wcf.qwebirc.title{/lang} - {PAGE_TITLE|language}</title>
	
	{include file='headInclude'}
	
	<link rel="canonical" href="{link controller='qWebIRC'}{/link}" />
	
</head>

<body id="tpl{$templateName|ucfirst}">



{include file='header' sidebarOrientation='right'}

<header class="boxHeadline">
	<h1>{lang}wcf.qwebirc.title{/lang}</h1>
</header>

{include file='userNotice'}

<div class="contentNavigation">
	{hascontent}
		<nav>
			<ul>
				{content}
					{event name='contentNavigationButtonsTop'}
				{/content}
			</ul>
		</nav>
	{/hascontent}
</div>

<div class="border qWebIRC">
	<iframe style="width: 100%; border: 0 none; display: block; height: {$chat_height}px;" class="container-1" src="{$qwebirc_url}"></iframe>
</div>

<div class="contentNavigation">
	{hascontent}
		<nav>
			<ul>
				{content}
					{event name='contentNavigationButtonsBottom'}
				{/content}
			</ul>
		</nav>
	{/hascontent}
</div>

{include file='footer'}

</body>
</html>
