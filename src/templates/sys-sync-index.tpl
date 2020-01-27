{extends file="template-private.tpl"}

{block name="page_content"}
<script language="JavaScript" type="text/javascript">
$(function(){
});
</script>
<style>
    p { padding-top: 12px; }
    
    .source_value { border: 2px solid green; padding: 2px 10px; }
    .target_value { border: 2px solid red; padding: 2px 10px; }
</style>

<center>

    {foreach name="t" key="table" item="item" from=$differenze}
    <h2>{$table}</h2>
    
        {foreach name="c" key="key" item="diff" from=$item}
        
            {if $smarty.foreach.c.first}<table class="" border="1">
            <thead></thead>
            <tbody>
            {/if}
            
            {cycle values="#99ccff,#ffcc99" assign="bgcell"}
            
            <tr>
                <th rowspan="3" style="background:{$bgcell};">{$key}</th>
        
            {foreach key="col" item="value" from=$diff.new}
                <th>{$col}</th>
            {foreachelse}
                {foreach key="col" item="value" from=$diff.old}
                    <th>{$col}</th>
                {/foreach}
            {/foreach}
            </tr>
            
            
            <tr>
            {foreach key="col" item="value" from=$diff.new}
                <td class="source_value">{$value}</td>
            {/foreach}
            </tr>
            
            <tr>
            {foreach key="col" item="value" from=$diff.old}
                <td class="target_value">{$value}</td>
            {/foreach}
            </tr>
            
            {if $smarty.foreach.c.last}
            </tbody>
            </table>
            <p><span class="source_value">SORGENTE</span> <span class="target_value">LOCALE</span> {/if}
        {foreachelse}
        <p>Nessuna differenza.</p>
        {/foreach}
    {/foreach}






</center>
{/block}