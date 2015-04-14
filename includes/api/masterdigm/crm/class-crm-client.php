<?php
namespace Masterdigm;

class MD_Client{

    protected $endPoint;
    protected $key;
    protected $token;  // private token
    protected $etoken; // hashed token
    protected $authenticated = FALSE;
    protected $errors;
    protected $version = 'v2';

    protected $sourceid;
    protected $accountid;
    protected $lead_dat  = array();

    public function __construct( $key , $token, $endPoint , $version = 'v2' )
    {

        if( ! $key || ! $token ){
            return array(
              'result' => 'fail',
              'message' => ' Key or Token must not be empty'
            );
        }

        if( ! $endPoint ){
            return array(
              'result' => 'fail',
              'message' => ' Endpoint must not be empty'
            );
        }

        $endPoint = substr( $endPoint , -1 ) == '/' ? $endPoint : $endPoint.'/' ;

        $this->endPoint  =     $endPoint;
        $this->key	  	 =     $key;
        $this->token  	 =     $token;
        $this->version 	 =     $version;

    }
    /**
     * Just test if you can communicate with server
     * @return json decoded string
     */
    public function testConnection()
    {
        return $this->sendRequest( 'api/testConnection' );
    }

    public function addLead( $lead_data )
    {
        $this->lead_data[]  = $lead_data;
    }

    public function addPropertySearchCriteria( $data )
    {
        return $this->sendRequest( 'properties/addSearchCriteria' , $data );
    }

    /**
     * Saves all leads added to $client->addLead()
     *
     * @return string json decoded
     */
    public function saveMultipleLeads()
    {
        if( ! count( $this->lead_data ) ){
            $response['result']  = 'fail';
            $response['message']  = ' Lead data is empty. You need to add lead data through $client->addLead() ';
            return $response;
        }

        $data['lead_data']    = $this->lead_data;

        return $this->sendRequest( 'leads/saveMultiple' , $data );
    }

    /**
     * Saves a single lead record
     *
     * @param array $data
     * @return string json decoded string
     */
    public function saveLead( $data )
    {
        return $this->sendRequest( 'leads/saveSingle' , $data );
    }

    /**
     * Get the Manager's account details
     *
     * @param int $accountid - some API credetials are associated with multiple CRM account.
     *     By default though one API credetial can access only one account
     * @return string json
     */
    public function getAccountDetails( $accountid = NULL )
    {
        return $this->sendRequest( 'accounts/get/'.$accountid  , array() );
    }

    public function setAccountId( $accountid )
    {
        $this->accountid =  $accountid ;
    }

    /**
     *   Returns the coverage area where the brokerage operates
     */
    public function getAccountCoverage( )
    {
        return $this->sendRequest( 'accounts/coverage/'  , array() );
    }

    /**
     * Sets the sourceid to determine where the lead came from
     * Sourceid's are usually provided by the CRM Account Managers
     *
     * @param integer $sourceid
     *
     * returns void
     */
    public function setSourceId( $sourceid )
    {
        $this->sourceid = $sourceid;
    }

    public function getPropertyById( $id , $brokerid  )
    {
        $data['id']         = $id;
        $data['brokerid']   = $brokerid;

        return $this->sendRequest( 'properties/getPropertyById/'  , $data );
    }

    public function getProperties( $data = array() )
    {
        return $this->sendRequest( 'properties/getProperties/'  , $data );
    }

    public function getComparableProperties( $property_id  )
    {
        $data['property_id']     = $property_id;
        return $this->sendRequest( 'properties/getComparable/', $data );
    }

    public function getFeaturedProperties( $user_id , $zips = array() )
    {
        $data['user_id'] = $user_id;
        $data['zips']    = $zips;
        return $this->sendRequest( 'properties/getFeatured/'  , $data );
    }

    public function getFields( $data = array() )
    {
        return $this->sendRequest( 'properties/getFields/'  , $data );
    }

    public function getPhotosByPropertyId( $property_id )
    {
        $data['property_id'] = $property_id;
        return $this->sendRequest( 'properties/getPhotosByPropertyId/'  , $data );
    }

    public function getCitiesByStateid( $state_id )
    {
        $data['state_id'] = $state_id;
        return $this->sendRequest( 'location/getCitiesByStateid/'  , $data );
    }

    public function getStatesByCountryId( $country_id )
    {
        $data['country_id'] = $country_id;
        return $this->sendRequest( 'location/getStatesByCountryId/'  , $data );
    }

    public function getCoverageLookup( $data )
    {
        //$data['country_id'] = $country_id;
        return $this->sendRequest( 'location/getCoverageLookup/'  , $data );
    }

    public function getCommunitiesByCityId( $data )
    {
        // $data['city_id'] = $city_id;
        // or $data['city_id'] = array( $city_id1,$city_id2, $city_id3 );

        return $this->sendRequest( 'location/getCommunitiesByCityId/'  , $data );
    }

    private function sendRequest( $request , $data = array() )
    {
		$data['key'] = $this->key;
		$data['request'] = $request;
		$data['sourceid'] = $this->sourceid;

		if( $this->accountid ){
			$data['accountid'] = $this->accountid;
		}

        $uri    =   $this->endPoint.$this->version.'/'.$request;
        $ch     =   curl_init( $uri );
        $data	=	http_build_query( $data );
        $etoken =   hash_hmac( 'sha256' , $data , $this->token ) ;

        curl_setopt( $ch, CURLOPT_POSTFIELDS,  $data );
        curl_setopt( $ch, CURLOPT_POST, 1 );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
        curl_setopt( $ch, CURLOPT_USERPWD, "$this->key:$etoken" );

        $curl_output = curl_exec($ch);

        if( curl_errno( $ch ) ){
            $this->errors[] = curl_error( $ch );
            //throw new Exception( curl_error( $ch ) );
            return array(
              'result' => 'fail',
              'message' => curl_error( $ch ),
              'endPoint' =>   $this->endPoint
            );
        }

        curl_close($ch);

        if( ! $curl_output ){
            return array(
               'result' => 'fail',
               'message' => ' Application error. No output returned',
               'request' => $uri.'?'.$data
            );
        }

        $decode =  json_decode( $curl_output );

        if( $decode === null || !is_object( $decode ) ){
            return array(
               'result' => 'fail',
               'messsage' => ' No response from API server. Most probably an application Error ',
               'endpoint'=> $this->endPoint,
               'request' => $uri.'?'.$data
            );
        }

        $decode->request = $uri.'?'.$data;
		//echo $decode->request.'&debug=xHJkl52l0pet86dd9965b';
        //&debug=xHJkl52l0pet86dd9965b
        return $decode;
    }

}
