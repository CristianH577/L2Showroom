<section id="add">
  <div class="add_container">
  <button type="button" id="button_show" title="Open form to add item" data-action="open">
    <svg class="svg-form"><path d="M19 15v-3h-2v3h-3v2h3v3h2v-3h3v-2h-.937zM4 7h11v2H4zm0 4h11v2H4zm0 4h8v2H4z"></path></svg>
  </button>
  
  <form action="<?php echo constant('URL').$lenguage; ?>/items/newItem" method="POST" name="form_item" id="form_add" class="form1" enctype="multipart/form-data">
    <ol>
      <li>
        <?php 
          $previewID = "new_icon";
          $previewALT = "Icon preview";
          $previewSRC = constant('URL').'assets/items/default.svg';
          $previewCLASS = "icon";
          include 'includes/preview.php';
        ?>
      </li>
      <li>
        <select name="add_type" id="add_type" title="Type">
          <option value="">Type*</option>
          <?php $all = true; include 'includes/'.$lenguage.'/type_options.php'; ?>
        </select>
      </li>
      <li>
        <input type="text" name="add_name" id="add_name" placeholder="Item*" title="Item">
      </li>
      <li>
        <textarea name="add_description" cols="30" rows="3" id="add_description" placeholder="Description" title="Description"></textarea>
      </li>
      <input type="file" name="new_icon" id="new_icon" hidden>

      <li class="console">
        <button type="button" id="add_item" title="Add item">
          <svg class="svg-form"><path d="M19 11h-6V5h-2v6H5v2h6v6h2v-6h6z"></path></svg>
        </button>
        <button type="button" id="reset_form_add" title="Reset form">
          <svg class="svg-form svg-reset"><path d="M19.89 10.105a8.696 8.696 0 0 0-.789-1.456l-1.658 1.119a6.606 6.606 0 0 1 .987 2.345 6.659 6.659 0 0 1 0 2.648 6.495 6.495 0 0 1-.384 1.231 6.404 6.404 0 0 1-.603 1.112 6.654 6.654 0 0 1-1.776 1.775 6.606 6.606 0 0 1-2.343.987 6.734 6.734 0 0 1-2.646 0 6.55 6.55 0 0 1-3.317-1.788 6.605 6.605 0 0 1-1.408-2.088 6.613 6.613 0 0 1-.382-1.23 6.627 6.627 0 0 1 .382-3.877A6.551 6.551 0 0 1 7.36 8.797 6.628 6.628 0 0 1 9.446 7.39c.395-.167.81-.296 1.23-.382.107-.022.216-.032.324-.049V10l5-4-5-4v2.938a8.805 8.805 0 0 0-.725.111 8.512 8.512 0 0 0-3.063 1.29A8.566 8.566 0 0 0 4.11 16.77a8.535 8.535 0 0 0 1.835 2.724 8.614 8.614 0 0 0 2.721 1.833 8.55 8.55 0 0 0 5.061.499 8.576 8.576 0 0 0 6.162-5.056c.22-.52.389-1.061.5-1.608a8.643 8.643 0 0 0 0-3.45 8.684 8.684 0 0 0-.499-1.607z"></path></svg>
        </button>
      </li>
    </ol>
  </form>
  </div>
</section>