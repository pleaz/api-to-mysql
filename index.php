<?php

$sql_server = 'localhost';
$sql_user = 'testing';
$sql_password = 'qGHBuJEKclAra9kZ';
$sql_db = 'testing';
$sql_table = 'test';

$data = file_get_contents('php://input');
$data_enc = json_decode($data, true);

if ($data) {

    $data_enc = json_decode($data, true);

    $mysqli = new mysqli($sql_server, $sql_user, $sql_password, $sql_db);

    if ($mysqli->connect_errno) {
        echo "Error: Failed to make a MySQL connection, here is why: \n";
        echo "Errno: " . $mysqli->connect_errno . "\n";
        echo "Error: " . $mysqli->connect_error . "\n";
        exit;
    }

    $custom_fields = [];
    foreach ($data_enc['data']['form_submission']['custom_fields'] as $custom_field) {
        $custom_fields[$custom_field['name']] = $custom_field['value'];
    }

    $sql_sel = "SELECT `data_tracking_id` FROM ".$sql_table." WHERE `data_tracking_id` = '".
        $mysqli -> real_escape_string($data_enc['data']['tracking_id'])."'";
    $result_sel = $mysqli->query($sql_sel);
    $array_sel = $result_sel->fetch_assoc();
    if($array_sel) {

        $sql_upd = "UPDATE " . $sql_table .
            " SET 
            `id` = '" . $mysqli->real_escape_string($data_enc['id']) .
            "', `object` = '" . $mysqli->real_escape_string($data_enc['object']) .
            "', `creation_time` = '" . $mysqli->real_escape_string(str_replace('T', ' ', str_replace('Z', '', $data_enc['creation_time']))) .
            "', `type` = '" . $mysqli->real_escape_string($data_enc['type']) .
            "', `api_version` = '" . $mysqli->real_escape_string($data_enc['api_version']) .
            "', `data_object` = '" . $mysqli->real_escape_string($data_enc['data']['object']) .
            "', `data_subject` = '" . $mysqli->real_escape_string($data_enc['data']['subject']) .
            "', `data_status` = '" . $mysqli->real_escape_string($data_enc['data']['status']) .
            "', `data_creation_time` = '" . $mysqli->real_escape_string(str_replace('T', ' ', str_replace('Z', '', $data_enc['data']['creation_time']))) .
            "', `data_starting_time` = '" . $mysqli->real_escape_string(str_replace('T', ' ', str_replace('Z', '', $data_enc['data']['starting_time']))) .
            "', `data_owner` = '" . $mysqli->real_escape_string($data_enc['data']['owner']) .
            "', `data_package_id` = '" . $mysqli->real_escape_string($data_enc['data']['package_id']) .
            "', `data_duration_minutes` = '" . $mysqli->real_escape_string($data_enc['data']['duration_minutes']) .
            "', `data_virtual_or_physical_location` = '" . $mysqli->real_escape_string($data_enc['data']['virtual_or_physical_location']) .
            "', `data_customer_time_zone_description` = '" . $mysqli->real_escape_string($data_enc['data']['customer_time_zone_description']) .
            "', `data_canceled_booking_tracking_id` = '" . $mysqli->real_escape_string($data_enc['data']['canceled_booking_tracking_id']) .
            "', `data_cancel_reschedule_link` = '" . $mysqli->real_escape_string($data_enc['data']['cancel_reschedule_link']) .
            "', `data_cancel_reschedule_reason` = '" . $mysqli->real_escape_string($data_enc['data']['cancel_reschedule_reason']) .
            "', `data_name_of_user_who_canceled_rescheduled` = '" . $mysqli->real_escape_string($data_enc['data']['name_of_user_who_canceled_rescheduled']) .
            "', `data_name_of_customer_who_canceled_rescheduled` = '" . $mysqli->real_escape_string($data_enc['data']['name_of_customer_who_canceled_rescheduled']) .
            "', `form_name` = '" . $mysqli->real_escape_string($data_enc['data']['form_submission']['name']) .
            "', `form_email` = '" . $mysqli->real_escape_string($data_enc['data']['form_submission']['email']) .
            "', `form_phone` = '" . $mysqli->real_escape_string($data_enc['data']['form_submission']['phone']) .
            "', `form_mobile_phone` = '" . $mysqli->real_escape_string($data_enc['data']['form_submission']['mobile_phone']) .
            "', `form_note` = '" . $mysqli->real_escape_string($data_enc['data']['form_submission']['note']) .
            "', `form_company` = '" . $mysqli->real_escape_string($data_enc['data']['form_submission']['company']) .
            "', `guests` = '" . $mysqli->real_escape_string(serialize($data_enc['data']['form_submission']['guests'])) .
            "', `custom_fields` = '" . $mysqli->real_escape_string(serialize($data_enc['data']['form_submission']['custom_fields'])) .
            "', `custom_casenumber` = '" . $mysqli->real_escape_string($custom_fields['casenumber']) .
            "', `custom_agentname` = '" . $mysqli->real_escape_string($custom_fields['agentname']) .
            "', `custom_agenttier` = '" . $mysqli->real_escape_string($custom_fields['agenttier']) .
            "', `booking_public_name` = '" . $mysqli->real_escape_string($data_enc['data']['booking_page']['public_name']) .
            "', `booking_internal_label` = '" . $mysqli->real_escape_string($data_enc['data']['booking_page']['internal_label']) .
            "', `booking_link` = '" . $mysqli->real_escape_string($data_enc['data']['booking_page']['link']) .
            "', `booking_category` = '" . $mysqli->real_escape_string($data_enc['data']['booking_page']['category']) .
            "', `booking_time_zone_description` = '" . $mysqli->real_escape_string($data_enc['data']['booking_page']['time_zone_description']) .
            "', `master_name` = '" . $mysqli->real_escape_string($data_enc['data']['master_page']['name']) .
            "', `master_label` = '" . $mysqli->real_escape_string($data_enc['data']['master_page']['label']) .
            "', `master_link` = '" . $mysqli->real_escape_string($data_enc['data']['master_page']['link']) .
            "', `event_name` = '" . $mysqli->real_escape_string($data_enc['data']['event_type']['name']) .
            "', `event_description` = '" . $mysqli->real_escape_string($data_enc['data']['event_type']['description']) .
            "', `event_category` = '" . $mysqli->real_escape_string($data_enc['data']['event_type']['category']) .
            "', `external_type` = '" . $mysqli->real_escape_string($data_enc['data']['external_calendar']['type']) .
            "', `external_name` = '" . $mysqli->real_escape_string($data_enc['data']['external_calendar']['name']) .
            "', `external_id` = '" . $mysqli->real_escape_string($data_enc['data']['external_calendar']['id']) .
            "', `external_event_id` = '" . $mysqli->real_escape_string($data_enc['data']['external_calendar']['event_id']) .
            "' WHERE `data_tracking_id` = '".$array_sel['data_tracking_id']."'";

        if(!$result_upd = $mysqli->query($sql_upd)){
            echo "Error: Our query failed to execute and here is why: \n";
            echo "Query: " . $sql_upd . "\n";
            echo "Errno: " . $mysqli->errno . "\n";
            echo "Error: " . $mysqli->error . "\n";
        } else {
            echo "Records were updated successfully.";
            $mysqli->close();
            return http_response_code(202);
        }

    } else {

        $sql = "INSERT INTO " . $sql_table .
            " (`id`, `object`, `creation_time`, `type`, `api_version`, `data_object`, `data_tracking_id`, `data_subject`, `data_status`, `data_creation_time`, `data_starting_time`, `data_owner`, `data_package_id`, `data_duration_minutes`, `data_virtual_or_physical_location`, `data_customer_time_zone_description`, `data_canceled_booking_tracking_id`, `data_cancel_reschedule_link`, `data_cancel_reschedule_reason`, `data_name_of_user_who_canceled_rescheduled`, `data_name_of_customer_who_canceled_rescheduled`, `form_name`, `form_email`, `form_phone`, `form_mobile_phone`, `form_note`, `form_company`, `guests`, `custom_fields`, `custom_casenumber`, `custom_agentname`, `custom_agenttier`, `booking_public_name`, `booking_internal_label`, `booking_link`, `booking_category`, `booking_time_zone_description`, `master_name`, `master_label`, `master_link`, `event_name`, `event_description`, `event_category`, `external_type`, `external_name`, `external_id`, `external_event_id`) VALUES ('" . $mysqli->real_escape_string($data_enc['id']) .
            "', '" . $mysqli->real_escape_string($data_enc['object']) .
            "', '" . $mysqli->real_escape_string(str_replace('T', ' ', str_replace('Z', '', $data_enc['creation_time']))) .
            "', '" . $mysqli->real_escape_string($data_enc['type']) .
            "', '" . $mysqli->real_escape_string($data_enc['api_version']) .
            "', '" . $mysqli->real_escape_string($data_enc['data']['object']) .
            "', '" . $mysqli->real_escape_string($data_enc['data']['tracking_id']) .
            "', '" . $mysqli->real_escape_string($data_enc['data']['subject']) .
            "', '" . $mysqli->real_escape_string($data_enc['data']['status']) .
            "', '" . $mysqli->real_escape_string(str_replace('T', ' ', str_replace('Z', '', $data_enc['data']['creation_time']))) .
            "', '" . $mysqli->real_escape_string(str_replace('T', ' ', str_replace('Z', '', $data_enc['data']['starting_time']))) .
            "', '" . $mysqli->real_escape_string($data_enc['data']['owner']) .
            "', '" . $mysqli->real_escape_string($data_enc['data']['package_id']) .
            "', '" . $mysqli->real_escape_string($data_enc['data']['duration_minutes']) .
            "', '" . $mysqli->real_escape_string($data_enc['data']['virtual_or_physical_location']) .
            "', '" . $mysqli->real_escape_string($data_enc['data']['customer_time_zone_description']) .
            "', '" . $mysqli->real_escape_string($data_enc['data']['canceled_booking_tracking_id']) .
            "', '" . $mysqli->real_escape_string($data_enc['data']['cancel_reschedule_link']) .
            "', '" . $mysqli->real_escape_string($data_enc['data']['cancel_reschedule_reason']) .
            "', '" . $mysqli->real_escape_string($data_enc['data']['name_of_user_who_canceled_rescheduled']) .
            "', '" . $mysqli->real_escape_string($data_enc['data']['name_of_customer_who_canceled_rescheduled']) .
            "', '" . $mysqli->real_escape_string($data_enc['data']['form_submission']['name']) .
            "', '" . $mysqli->real_escape_string($data_enc['data']['form_submission']['email']) .
            "', '" . $mysqli->real_escape_string($data_enc['data']['form_submission']['phone']) .
            "', '" . $mysqli->real_escape_string($data_enc['data']['form_submission']['mobile_phone']) .
            "', '" . $mysqli->real_escape_string($data_enc['data']['form_submission']['note']) .
            "', '" . $mysqli->real_escape_string($data_enc['data']['form_submission']['company']) .
            "', '" . $mysqli->real_escape_string(serialize($data_enc['data']['form_submission']['guests'])) .
            "', '" . $mysqli->real_escape_string(serialize($data_enc['data']['form_submission']['custom_fields'])) .
            "', '" . $mysqli->real_escape_string($custom_fields['casenumber']) .
            "', '" . $mysqli->real_escape_string($custom_fields['agentname']) .
            "', '" . $mysqli->real_escape_string($custom_fields['agenttier']) .
            "', '" . $mysqli->real_escape_string($data_enc['data']['booking_page']['public_name']) .
            "', '" . $mysqli->real_escape_string($data_enc['data']['booking_page']['internal_label']) .
            "', '" . $mysqli->real_escape_string($data_enc['data']['booking_page']['link']) .
            "', '" . $mysqli->real_escape_string($data_enc['data']['booking_page']['category']) .
            "', '" . $mysqli->real_escape_string($data_enc['data']['booking_page']['time_zone_description']) .
            "', '" . $mysqli->real_escape_string($data_enc['data']['master_page']['name']) .
            "', '" . $mysqli->real_escape_string($data_enc['data']['master_page']['label']) .
            "', '" . $mysqli->real_escape_string($data_enc['data']['master_page']['link']) .
            "', '" . $mysqli->real_escape_string($data_enc['data']['event_type']['name']) .
            "', '" . $mysqli->real_escape_string($data_enc['data']['event_type']['description']) .
            "', '" . $mysqli->real_escape_string($data_enc['data']['event_type']['category']) .
            "', '" . $mysqli->real_escape_string($data_enc['data']['external_calendar']['type']) .
            "', '" . $mysqli->real_escape_string($data_enc['data']['external_calendar']['name']) .
            "', '" . $mysqli->real_escape_string($data_enc['data']['external_calendar']['id']) .
            "', '" . $mysqli->real_escape_string($data_enc['data']['external_calendar']['event_id']) .
            "')";
        if (!$result = $mysqli->query($sql)) {
            echo "Error: Our query failed to execute and here is why: \n";
            echo "Query: " . $sql . "\n";
            echo "Errno: " . $mysqli->errno . "\n";
            echo "Error: " . $mysqli->error . "\n";
            exit;
        } else {
            $mysqli->close();
            return http_response_code(202);
        }

    }

}