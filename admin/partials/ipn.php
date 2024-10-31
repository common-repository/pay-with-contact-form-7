<?php
include('../../../../../wp-load.php');

require_once plugin_dir_path(__FILE__) . 'wpcmscf7-paypalipn.php';
use PaypalIPN;
$ipn = new PaypalIPN();
// Use the sandbox endpoint during testing.
$options = get_option('wpcms_cf7pp_options');
foreach ($options as $k => $v ) { $value[$k] = $v; }

// live or test mode
if ($value['mode'] == "1") {
    $ipn->useSandbox();
}

$verified = $ipn->verifyIPN();
global $wpdb;
$table_name    = $wpdb->prefix.'cmscf7_forms';

$fp = fopen('PaypalResponse.txt', 'a');
fwrite($fp, print_r($_POST, TRUE));

if ($verified) {
    /*
     * Process IPN
     * A list of variables is available here:
     * https://developer.paypal.com/webapps/developer/docs/classic/ipn/integration-guide/IPNandPDTVariables/
     */
    $txn_id = $_POST['txn_id'];
    $last_insert_id_form = $_POST['custom'];
    //update transaction id in cmscf7_forms table
    $wpdb->update( 
                    $table_name, 
                    array( 
                        'form_transaction_id' => $txn_id // integer (number) 
                    ),
                    array( 'form_id' => $last_insert_id_form ), 
                    array( 
                        '%s'    // value1
                    ), 
                    array( '%d' ) 
                );

    $form_post_id = $wpdb->get_results( "SELECT * FROM $table_name WHERE form_id = $last_insert_id_form" );
    //store transaction details
    $table_name_trans = $wpdb->prefix.'cmscf7_forms_transaction';
    if ( 'completed' == strtolower( $_POST['payment_status'] ) ) {
        fwrite($fp, $verified);
        fwrite($fp, "  verified  ");
        
        //check if transaction id exist or not?
        $exist_trans_id = $wpdb->get_results( "SELECT * FROM $table_name_trans AS ft WHERE ft.form_transaction_id = $txn_id" );
        fwrite($fp, print_r($exist_trans_id, TRUE));
        if( isset($exist_trans_id) && !empty($exist_trans_id) ) {
            // Store PayPal Details
            $form_value   = serialize( $_POST );
            $trans_date    = current_time('Y-m-d H:i:s');

            // if txn_id available then just need to update that row.
            $update_row = $wpdb->update( 
                                        $table_name_trans, 
                                        array( 
                                            'trans_value' => $form_value, // string tansaction details
                                            'trans_date' => $trans_date   // DateTime 
                                        ),
                                        array( 'form_transaction_id' => $txn_id ), 
                                        array( 
                                            '%s',    // value1
                                            '%s'
                                        ), 
                                        array( '%s' ) 
                                    );
        }
        else{
            $form_value   = serialize( $_POST );
            $trans_date    = current_time('Y-m-d H:i:s');
            $wpdb->insert( $table_name_trans, array( 
                    'form_post_id' => $form_post_id[0]->form_post_id,
                    'form_transaction_id' => $txn_id,
                    'trans_value'   => $form_value,
                    'trans_date'    => $trans_date
                ) );
        }
        
    }
    elseif ( 'pending' == strtolower( $_POST['payment_status'] ) ) {
        fwrite($fp, "  pending  ");
        //check if transaction id exist or not?
        $exist_trans_id = $wpdb->get_results( "SELECT * FROM $table_name_trans AS ft WHERE ft.form_transaction_id = $txn_id" );
        if( isset($exist_trans_id) && !empty($exist_trans_id) ) {
            // Store PayPal Details
            $form_value   = serialize( $_POST );
            $trans_date    = current_time('Y-m-d H:i:s');

            // if txn_id available then just need to update that row.
            $update_row = $wpdb->update( 
                                        $table_name_trans, 
                                        array( 
                                            'trans_value' => $form_value, // string tansaction details
                                            'trans_date' => $trans_date   // DateTime 
                                        ),
                                        array( 'form_transaction_id' => $txn_id ), 
                                        array( 
                                            '%s',    // value1
                                            '%s'
                                        ), 
                                        array( '%s' ) 
                                    );
        }
        else{
            $form_value   = serialize( $_POST );
            $trans_date    = current_time('Y-m-d H:i:s');
            $wpdb->insert( $table_name_trans, array( 
                    'form_post_id' => $form_post_id[0]->form_post_id,
                    'form_transaction_id' => $txn_id,
                    'trans_value'   => $form_value,
                    'trans_date'    => $trans_date
                ) );
        }
    }
}
else{
    fwrite($fp, "not verified ipn inavalid.");
}
fclose($fp);
// Reply with an empty 200 response to indicate to paypal the IPN was received correctly.
header("HTTP/1.1 200 OK");