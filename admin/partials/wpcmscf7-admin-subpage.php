<?php // phpcs:ignore Generic.Files.LineEndings.InvalidEOLChar -- Can't change End of the line charcter.
/**
 * Wpcmscf7 Admin subpage 
 */

if (!defined( 'ABSPATH')) exit;

/**
 * Wpcmscf7_Wp_List_Table class will create the page to load the table
 */
class Wpcmscf7_Wp_Sub_Page
{   
    private $form_post_id;
    private $search;
	
	/**
	* Constructor start subpage 
	*/
    public function __construct()
    {   
        $this->form_post_id = (int) $_GET['fid'];
        $this->list_table_page();
        
    }
    /**
     * Display the list table page
     *
     * @return Void
     */
    public function list_table_page()
    {
    	$file = require_once plugin_dir_path(__FILE__) . '/WPCMSCF7-List-Table.php';
        $ListEntryTable = new WPCMSCF7_List_Table();
        $ListEntryTable->prepare_items();
        ?>
            <div class="wrap">
                <div id="icon-users" class="icon32"></div>
                <h2><?php echo get_the_title( $this->form_post_id ); ?></h2>
                <form method="post" action="">
                    <?php $ListEntryTable->search_box('Search', 'search'); ?>
                    <?php $ListEntryTable->display(); ?>
                </form>
            </div>
        <?php
    }
}