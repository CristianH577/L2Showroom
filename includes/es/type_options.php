
<option value="Character">Personaje</option>
<optgroup label="Equipo">
    <?php if (!isset($all)) { ?>
    <option value="Equip">Todo</option>
    <?php } ?>
    <option value="Accessory_Equip">Accessory</option>
    <option value="Armor_Equip">Armor</option>
    <option value="Jewelry_Equip">Jewelry</option>
    <option value="Weapon_Equip">Weapon</option>
    <option value="Misc_Equip">Misc.</option>
</optgroup>

<optgroup label="Encantamiento">
    <?php if (!isset($all)) { ?>
    <option value="Enchant">Todo</option>
    <?php } ?>
    <option value="Dyes_Enchant">Dyes</option>
    <option value="Life Stone_Enchant">Life Stone</option>
    <option value="Scroll_Enchant">Scroll</option>
    <option value="Soul Crystal_Enchant">Soul Crystal</option>
    <option value="Spellbook_Enchant">Spellbook</option>
    <option value="Misc_Enchant">Misc.</option>
</optgroup>

<optgroup label="Misc.">
    <?php if (!isset($all)) { ?>
    <option value="Misc">Todo</option>
    <?php } ?>
    <option value="BoxCrafting_Misc">Box/Crafting</option>
    <option value="Material_Misc">Material</option>
    <option value="PotionScroll_Misc">Potion/Scroll</option>
    <option value="Recipe_Misc">Recipe</option>
    <option value="Tickets_Misc">Tickets</option>
</optgroup>