<!-- Block blogmodule -->
<div id="blogmodule_block_home" class="block">
  <h4>{l s='Blog!' mod='blogmodule'}</h4>
  <div class="block_content">
    <p>
      {if !isset($my_module_name) || !$my_module_name}
        {capture name='my_module_tempvar'}{l s='World' mod='blogmodule'}{/capture}
        {assign var='my_module_name' value=$smarty.capture.my_module_tempvar}
      {/if}
      {l s='%1$s!' sprintf=$my_module_name mod='blogmodule'}
    </p>
    <ul>
      <li><a href="{$my_module_link}"  title="{l s='Click this link' mod='blogmodule'}">{l s='Go to blog!' mod='blogmodule'}</a></li>
    </ul>
  </div>
</div>
<!-- /Block blogmodule -->
