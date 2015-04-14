<?php
class PDF_MD{
	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	public $print_pdf_property_id;

	public function __construct(){
		$this->init_wp_hook();
	}

	public function init_wp_hook(){
		add_action('init', array( $this, 'rewrite_url_pdf' ) );
		add_action('parse_request', array($this,'http_request_print'));
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function rewrite_url_pdf(){
		add_rewrite_rule(
			'printpdf/(\d*)$',
			'index.php?printpdf=$matches[1]',
			'top'
		);
	}

	public function build_property_photos($photos){
		$i = 1;
		$per_row = 3;
		$total_photos = count($photos);
		$body_photos = '';
		$body_photos .= '<table border="0"><tr>';
		if( $total_photos > 0 ){
			foreach( $photos as $key_photo => $val_photo ){
				$check = ($i % $per_row);
				$body_photos .= '<td><img src="'.$val_photo.'"></td>';
				if($check == 0 && $i > 0 ) {
					$body_photos .= '</tr><tr>';
				}else{
				}
				$i++;
			}
		}
		$body_photos .= '</tr></table>';

		if( has_filter('print_pdf_body_photos') ){
			$body_photos = apply_filters('print_pdf_body_photos', $photos);
		}
		return $body_photos;
	}

	public function build_property_details(){
		$details = '<table>';
		$details .= '<tr><td>Price : '.md_property_price().'</td><td>Bath : '.md_property_bathrooms().'</td></tr>';
		$details .= '<tr><td>Bed : '.md_property_beds().'</td><td>Area : '.md_property_area().md_property_area_unit().'</td></tr>';
		$details .= '<tr><td>Yr Built : '.md_property_yr_built().'</td><td>MLS# : '.md_get_mls().'</td></tr>';
		$details .= '<tr><td colspan="2"></td></tr>';
		$details .= '<tr><td colspan="2">'.md_get_description().'</td></tr>';
		$details .= '</table>';
		if( has_filter('print_pdf_body_details') ){
			$details = apply_filters('print_pdf_body_details', $details_string);
		}
		return $details;
	}

	public function http_request_print(){
		$property_id = $this->get_print_pdf_property_id();

		$property 	= \MD_Single_Property::get_instance()->getSinglePropertyData($property_id);
		\MD_Single_Property::get_instance()->setPropertyData($property);
		if( $property ){
			$data 		= \MD_Single_Property::get_instance()->getPropertyData($property);
			\MD\Property::get_instance()->set_properties($data['property'],$data['source']);
			\MD\Property::get_instance()->set_loop($data['property']);
		}
		if( $property_id && have_properties() ){
			$name 		= get_account_data('company').'-'.get_account_data('manager_first_name').' '.get_account_data('manager_last_name')."\n";
			$address 	= "Address: ".get_account_data('street_address').', '.get_account_data('state').', '.get_account_data('country')."\n";
			$contact 	= "Phone: ".get_account_data('work_phone')."\n"."Email : ".get_account_data('manager_email')."\n";
			$website 	= get_account_data('website')."\n\n";

			$header_details = $name . $address . $contact . $website;
			// hook filter
			if( has_filter('print_pdf_header') ){
				$header_details = apply_filters('print_pdf_header', $header_details_string);
			}

			// create new PDF document
			// create new PDF document
			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			//$pdf->SetPrintHeader(false);
			//$pdf->SetPrintFooter(false);
			// set document information
			$pdf->SetCreator('Masterdigm');
			$pdf->SetAuthor('Name');
			$pdf->SetTitle('Property');
			$pdf->SetSubject('Masterdigm Print Flyer');
			$pdf->SetKeywords('TCPDF, PDF, masterdigm');
			// set default header data

			$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, get_option('blogname'),$header_details);

			// set header and footer fonts
			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

			// set margins
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

			// set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

			// set some language-dependent strings (optional)
			if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
				require_once(dirname(__FILE__).'/lang/eng.php');
				$pdf->setLanguageArray($l);
			}

			// ---------------------------------------------------------

			// set font
			$pdf->SetFont('dejavusans', '', 10);

			// add a page
			$pdf->AddPage();

			$body_photos = $this->build_property_photos(get_single_property_photos());
			$body_details = $this->build_property_details();

			// create some HTML content
			$html = '<p></p><img src="'.get_account_data('company_logo').'" width="130px">
			<h2>'.md_property_address().'</h2>
			'.$body_details.'
			<p></p>
			'.$body_photos.'
			';
			// output the HTML content
			$pdf->writeHTML($html, true, false, true, false, '');

			//Close and output PDF document
			$filename = strtolower(str_replace(' ','_',\helpers\Text::remove_non_alphanumeric(md_property_address())));
			$pdf->Output($filename.'.pdf', 'I');
		}
	}
	public function get_print_pdf_property_id(){
		if(!empty($_SERVER['REQUEST_URI']))
		{
			$urlvars = explode('/', $_SERVER['REQUEST_URI']);
			$printpdf = array_search('printpdf',$urlvars);
			if( $printpdf ){
				return $urlvars[$printpdf+1];
			}
		}
	}
}
