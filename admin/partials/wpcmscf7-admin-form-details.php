<?php 

if (!defined( 'ABSPATH')) exit;

class Wpcmscf7_Form_Details  
{
    private $form_id;
    private $form_post_id;


    public function __construct()
    {   
       $this->form_post_id = esc_sql( $_GET['fid'] );
       $this->form_id = esc_sql( $_GET['ufid'] );
       
       $this->form_details_page();
    }

    public function form_details_page(){
        global $wpdb;
        $table_name = $wpdb->prefix.'cmscf7_forms';
        $table_name_trans = $wpdb->prefix.'cmscf7_forms_transaction';
        $upload_dir    = wp_upload_dir();
        $cfdb7_dir_url = $upload_dir['baseurl'].'/wpcmscf7_uploads';
 
        if ( is_numeric($this->form_post_id) && is_numeric($this->form_id) ) {  
            $qry = "SELECT * FROM $table_name AS f, $table_name_trans AS ft 
                        WHERE f.form_post_id = $this->form_post_id 
                        AND f.form_id = $this->form_id 
                        AND f.form_post_id = ft.form_post_id
                        AND f.form_transaction_id = ft.form_transaction_id LIMIT 1";
           $results    = $wpdb->get_results( $qry, OBJECT );
        }

        if ( empty($results) ) {
            if ( is_numeric($this->form_post_id) && is_numeric($this->form_id) ) {

               $results    = $wpdb->get_results( "SELECT * FROM $table_name WHERE form_post_id = $this->form_post_id AND form_id = $this->form_id LIMIT 1", OBJECT );
            }

            if ( empty($results) ) {
                wp_die( $message = 'Not valid contact form' );
            }
        }
        ?>
        <div class="wrap">
            <div id="welcome-panel" class="welcome-panel">
                <?php if(isset($_GET['paged'])) { ?>
                    <a href="<?php echo admin_url('admin.php?page=wpcmscf7-list.php&fid='.$_GET['fid']).'&paged='.$_GET['paged']; ?>">Back</a>
                <?php } else { ?>
                    <a href="<?php echo admin_url('admin.php?page=wpcmscf7-list.php&fid='.$_GET['fid']); ?>">Back</a>
                <?php } ?>
                <div class="welcome-panel-content">
                    <div class="welcome-panel-column-container">
                        <?php do_action('wpcmscf7_before_formdetails_title',$this->form_post_id ); ?>
                        <h3><?php echo get_the_title( $this->form_post_id ); ?></h3>
                        <?php do_action('wpcmscf7_after_formdetails_title', $this->form_post_id ); ?>
                        <p></span><?php echo $results[0]->form_date; ?></p>
                        <?php $form_data  = unserialize( $results[0]->form_value );

                        foreach ($form_data as $key => $data):

                            if ( $key == 'wpcmscf7_status' )  continue;

                            if ( strpos($key, 'wpcmscf7_file') !== false ){
                                
                                $key_val = str_replace('wpcmscf7_file', '', $key);
                                $key_val = str_replace('your-', '', $key_val); 
                                $key_val = ucfirst( $key_val );
                                echo '<p><b>'.$key_val.'</b>: <a target="_blank" href="'.$cfdb7_dir_url.'/'.$data.'">'
                                .$data.'</a></p>'; 
                            }else{


                                if ( is_array($data) ) {

                                    $key_val = str_replace('your-', '', $key); 
                                    $key_val = ucfirst( $key_val );
                                    $arr_str_data =  implode(', ',$data);
                                    echo '<p><b>'.$key_val.'</b>: '. $arr_str_data .'</p>';

                                }else{

                                    $key_val = str_replace('your-', '', $key); 
                                    $key_val = ucfirst( $key_val );
                                    echo '<p><b>'.$key_val.'</b>: '.$data.'</p>';
                                }
                            }

                        endforeach;

                        $form_data['wpcmscf7_status'] = 'read';
                        $form_data = serialize( $form_data );
                        $form_id = $results[0]->form_id;

                        $wpdb->query( "UPDATE $table_name SET form_value = 
                            '$form_data' WHERE form_id = $form_id"
                        );

                        //Display payment details
                        if( isset($results[0]->trans_value) && !empty($results[0]->trans_value) ) {
                            echo "<h3>Payment Details</h3>";
                            $trans_data  = unserialize( $results[0]->trans_value );
                            if(isset($trans_data) && !empty($trans_data) && is_array($trans_data)){
                                echo "<p><b>"."Transaction Id"."</b>: ".$trans_data['txn_id']."</p>";
                                echo "<p><b>"."Item Name"."</b>: ".$trans_data['item_name']."</p>";
                                echo "<p><b>"."Item Number"."</b>: ".$trans_data['item_number']."</p>";
                                echo "<p><b>"."Price"."</b>: ".$trans_data['mc_gross']."</p>";
                                echo "<p><b>"."First Name"."</b>: ".$trans_data['first_name']."</p>";
                                echo "<p><b>"."Last Name"."</b>: ".$trans_data['last_name']."</p>";
                                echo "<p><b>"."Payer Status"."</b>: ".$trans_data['payer_status']."</p>";
                                echo "<p><b>"."Payment Status"."</b>: ".$trans_data['payment_status']."</p>";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
        do_action('wpcmscf7_after_formdetails', $this->form_post_id ); 
    }  

}