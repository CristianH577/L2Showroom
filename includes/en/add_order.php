<section id="add">
  <div class="add_container">
    <button type="button" id="button_show" title="Open form to add order" data-action="open">
        <svg class="svg-form"><path d="M19 15v-3h-2v3h-3v2h3v3h2v-3h3v-2h-.937zM4 7h11v2H4zm0 4h11v2H4zm0 4h8v2H4z"></path></svg>
    </button>
  
  <form action="<?php echo constant('URL').$lenguage; ?>/mystore/newOrder" method="POST" enctype="multipart/form-data" name="form_order" id="form_add" class="form1">
    <ol>
      <input type="number" name="id_user" id="id_user" value="<?php echo $user->getId(); ?>" hidden>

      <li class="radio">
        <div>
          <label>Item</label>
          <input type="radio" name="type" value="item" title="Item" checked>
        </div>
        <div>
          <label>Character</label>
          <input type="radio" name="type" value="char" title="Character">
        </div>
      </li>

      <li>
        <select name="wt" id="wt" title="Want">
          <option value="">WT*</option>
          <option value="S">Sell</option>
          <option value="B">Buy</option>
          <option value="S/T">Sell/Trade</option>
          <option value="B/T">Buy/Trade</option>
        </select>
      </li>

      <div id="itemForm">
        <li id="pre_view_item">
          <div class="center">
            <img src="<?php echo constant('URL'); ?>assets/items/default.svg" class="icon" alt="Object icon" title="Object icon">
          </div>
        </li>
        <li>
          <input type="text" list="add_datalist" id="add_search" placeholder="Search item*" autocomplete="off" title="Search item">
          <input type="text" name="id_item" id="id_item" hidden>
          <datalist id="add_datalist">
          </datalist>
        </li>
        <li>
          <input type="text" name="quantity" id="quantity" placeholder="Quantity*" class="verifyNumber" title="Quantity">
        </li>
      </div>

      <div id="charForm">
        <li>
          <select name="race" id="race" title="Race">
            <option value="">Race*</option>
            <option value="Human">Human</option>
            <option value="Elf">Elf</option>
            <option value="DarkElf">Dark Elf</option>
            <option value="Orc">Orc</option>
            <option value="Dwarf">Dwarf</option>
            <option value="Kamael">Kamael</option>
          </select>
        </li>
        <li>
          <select name="occupation" id="occupation" title="Occupation">
            <option value="">Occupation*</option>
            <option value="Fighter">Fighter</option>
            <option value="Mystic" id="mystic">Mystic</option>
          </select>
        </li>
        <li>
          <select name="class" id="class" title="Class">  
            <option value="">Class*</option>

            <optgroup label="Humano Guerrero" id="HumanFighter">
              <option value="Phoenix Knight">Phoenix Knight</option>
              <option value="Hell Knight">Hell Knight</option>
              <option value="Dreadnought">Dreadnought</option>
              <option value="Duelist">Duelist</option>
              <option value="Adventurer">Adventurer</option>
              <option value="Sagittarius">Sagittarius</option>
            </optgroup> 

            <optgroup label="Humano Mago" id="HumanMystic">
              <option value="Archmage">Archmage</option>
              <option value="Soultaker">Soultaker</option>
              <option value="Arcana Lord">Arcana Lord</option>
              <option value="Cardinal">Cardinal</option>
              <option value="Hierophant">Hierophant</option>
            </optgroup>


            <optgroup label="Elfo Guerrero" id="ElfFighter">
              <option value="Eva's Templar">Eva's Templar</option>
              <option value="Sword Muse">Sword Muse</option>
              <option value="Wind Rider">Wind Rider</option>
              <option value="Moonlight Sentinel">Moonlight Sentinel</option>
            </optgroup>

            <optgroup label="Elfo Mago" id="ElfMystic">
              <option value="Mystic Muse">Mystic Muse</option>
              <option value="Elemental Master">Elemental Master</option>
              <option value="Eva's Saint">Eva's Saint</option>
            </optgroup>


            <optgroup label="Elfo Oscuro Guerrero" id="DarkElfFighter">
              <option value="Shillien Templar">Shillien Templar</option>
              <option value="Spectral Dancer">Spectral Dancer</option>
              <option value="Ghost Hunter">Ghost Hunter</option>
              <option value="Ghost Sentinel">Ghost Sentinel</option>
            </optgroup>

            <optgroup label="Elfo Oscuro Mago" id="DarkElfMystic">
              <option value="Storm Screamer">Storm Screamer</option>
              <option value="Spectral Master">Spectral Master</option>
              <option value="Shillien's Saint">Shillien's Saint</option>
            </optgroup>


            <optgroup label="Orco Guerrero" id="OrcFighter">
              <option value="Titan">Titan</option>
              <option value="Grand Khavatari">Grand Khavatari</option>
            </optgroup>

            <optgroup label="Orco Mago" id="OrcMystic">
              <option value="Dominator">Dominator</option>
              <option value="Doomcryer">Doomcryer</option>
            </optgroup>


            <optgroup label="Enano Guerrero" id="DwarfFighter">
              <option value="Maestro">Maestro</option>
              <option value="Fortune Seeker">Fortune Seeker</option>
            </optgroup>


            <optgroup label="Kamael Guerrero" id="KamaelFighter">
              <option value="Doombringer">Doombringer</option>
              <option value="Soul Hound">Soul Hound</option>
              <option value="Judicator">Judicator</option>
              <option value="Trickster">Trickster</option>
            </optgroup>
          </select>
        </li>
        <li>
          <input type="text" name="level" id="level" placeholder="Level*" class="verifyNumber" title="Level">
        </li>

        <li id="images">
          <?php 
          for ($i=1; $i < 5; $i++) { 
            $previewID = "img".$i;
            $previewALT = "Preview ".$i;
            $previewSRC = constant('URL').'assets/profiles/default.jpg';
            $previewCLASS = "img";
            include 'includes/preview.php';
          }
          ?>
        </li>

        <input type="file" name="img1" id="img1" hidden>
        <input type="file" name="img2" id="img2" hidden>
        <input type="file" name="img3" id="img3" hidden>
        <input type="file" name="img4" id="img4" hidden>

      </div>

      <li>
        <input type="text" name="price" id="price" placeholder="Price*" class="verifyNumber" title="Price">
      </li>
      
      <li class="console">
        <button type="button" title="Add order" id="send_order">
          <svg class="svg-form"><path d="M19 11h-6V5h-2v6H5v2h6v6h2v-6h6z"></path></svg>
        </button>
        <button type="button" id="resetFormAdd" title="Reset form">
          <svg class="svg-form svg-reset"><path d="M19.89 10.105a8.696 8.696 0 0 0-.789-1.456l-1.658 1.119a6.606 6.606 0 0 1 .987 2.345 6.659 6.659 0 0 1 0 2.648 6.495 6.495 0 0 1-.384 1.231 6.404 6.404 0 0 1-.603 1.112 6.654 6.654 0 0 1-1.776 1.775 6.606 6.606 0 0 1-2.343.987 6.734 6.734 0 0 1-2.646 0 6.55 6.55 0 0 1-3.317-1.788 6.605 6.605 0 0 1-1.408-2.088 6.613 6.613 0 0 1-.382-1.23 6.627 6.627 0 0 1 .382-3.877A6.551 6.551 0 0 1 7.36 8.797 6.628 6.628 0 0 1 9.446 7.39c.395-.167.81-.296 1.23-.382.107-.022.216-.032.324-.049V10l5-4-5-4v2.938a8.805 8.805 0 0 0-.725.111 8.512 8.512 0 0 0-3.063 1.29A8.566 8.566 0 0 0 4.11 16.77a8.535 8.535 0 0 0 1.835 2.724 8.614 8.614 0 0 0 2.721 1.833 8.55 8.55 0 0 0 5.061.499 8.576 8.576 0 0 0 6.162-5.056c.22-.52.389-1.061.5-1.608a8.643 8.643 0 0 0 0-3.45 8.684 8.684 0 0 0-.499-1.607z"></path></svg>
        </button>
      </li>
    </ol>
  </form>
  </div>
</section>