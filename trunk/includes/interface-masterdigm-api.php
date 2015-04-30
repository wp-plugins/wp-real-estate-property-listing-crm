<?php
interface iMasterdigm_API{
	public function get_property($property_id, $broker_id = null);
	public function get_properties($search_criteria_data);
	public function get_location();
}
class Masterdigm_CRM_Account{}
class Masterdigm_CRM_Push{}
/**
 * Use any API
 * */
class Masterdigm_Location{
}
/*$crm_api 		= new Masterdigm_CRM;
$md_property	= new Masterdigm_Property($crm_api);
var_dump($md_property->test_connection());
var_dump($md_property->get_properties());
exit();*/
