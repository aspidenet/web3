{extends file="template-private.tpl"}

{block name="html_head_extra"}

<script language="JavaScript" type="text/javascript">
$(function(){
});
</script>
{/block}


{block name="content"}

<style>
	.panel_button {
		text-align:center;
		border: 0px solid white;
		font-size:1.2em;
		font-weight:bold;
	}
    a {
        color: black;
	}
    a:hover {
        color: teal;
	}
    p { padding-top: 12px; }
</style>

<br />
<br />
<br />
<br />
<center>

            


<div class="ui five column grid">
    {foreach key="key" item="item" from=$configurazione}
    <div class="column">
        <div class="ui segment panel_button">
            <a href="{$item.link}"><i class="{$item.icona} massive icon"></i><p>{$item.nome}</p></a>
        </div>
    </div>
    {/foreach}
</div>

</center>
<br />
<br />
<br />
<br />
{/block}