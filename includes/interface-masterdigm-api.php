<?php
interface iMasterdigm_API{
	public function get_property($property_id, $broker_id = null);
	public function get_properties($search_criteria_data);
	public function get_location();
}
