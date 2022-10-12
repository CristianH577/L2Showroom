<?php
if ($totalPages != 1) {
    echo '<ul>';
    
    if ($actualPage != 1) {
        echo '<li>';
        echo '<a href="'.constant("URL").$lenguage."/".$page.'/page?actualPage=1'.$searchText.'" title="First page">';
        echo '<svg class="svg1"><path d="m8.121 12 4.94-4.939-2.122-2.122L3.879 12l7.06 7.061 2.122-2.122z"></path><path d="M17.939 4.939 10.879 12l7.06 7.061 2.122-2.122L15.121 12l4.94-4.939z"></path></svg>';
        echo '</a>';
        echo '</li>';
        echo '<li>';
        echo '<a href="'.constant("URL").$lenguage."/".$page.'/page?actualPage='.($actualPage-1).$searchText.'" title="Previous page">';
        echo '<svg class="svg1"><path d="M13.939 4.939 6.879 12l7.06 7.061 2.122-2.122L11.121 12l4.94-4.939z"></path></svg>';
        echo '</a>';
        echo '</li>';
    }
    echo '<li>';
    echo $actualPage;
    echo ' Of ';
    echo $totalPages;
    echo '</li>';
    if ($actualPage != $totalPages) {
        echo '<li>';
        echo '<a href="'.constant("URL").$lenguage."/".$page.'/page?actualPage='.($actualPage+1).$searchText.'" title="Next page">';
        echo '<svg class="svg1"><path d="M10.061 19.061 17.121 12l-7.06-7.061-2.122 2.122L12.879 12l-4.94 4.939z"></path></svg>';
        echo '</a>';
        echo '</li>';
        echo '<li>';
        echo '<a href="'.constant("URL").$lenguage."/".$page.'/page?actualPage='.$totalPages.$searchText.'" title="Last page">';
        echo '<svg class="svg1"><path d="m13.061 4.939-2.122 2.122L15.879 12l-4.94 4.939 2.122 2.122L20.121 12z"></path><path d="M6.061 19.061 13.121 12l-7.06-7.061-2.122 2.122L8.879 12l-4.94 4.939z"></path></svg>';
        echo '</a>';
        echo '</li>';
    }
    
    echo '</ul>';
}
?>
