<?php
class fcvSettings {
	
	/**
	 * The Unique Instance Of The Class
	 *
	 * @since  1.0
	 **/
	private static $instance = NULL;
	
	/**
	 * The Settings Field Name
	 *
	 * @var    String
	 * @since  1.0
	 **/
	private $fieldName;
	
	/**
	 * Settings
	 *
	 * @var    Array
	 * @since  1.0
	 **/
	private $settings = array();
	
	/**
	 * Loaded Files
	 *
	 * @var    Array
	 * @since  1.0
	 **/
	private $files;
	
	/**
	 * Shortname Theme
	 *
	 * @var    String
	 * @since  1.0
	 **/
	private $shortname;
	
	/**
	 * Var list
	 *
	 * @var    Array
	 * @since  1.0
	 **/
	private $white_list = array(
		//Directory
		'profile' => array(
			//Field: Type, Array Values

		),
		'social' => array(
			'facebook'   	=> array('url', NULL),
			'twitter'   	=> array('url', NULL),
			'linkedin'  	=> array('url', NULL),
			'googleplus'    => array('url', NULL),
            'pinterest'     => array('url', NULL),
            'dribbble'      => array('url', NULL)

        ),
        'metrodircompany' => array(
            'adress'        	=> array('string', NULL),
            'phone' 	        => array('string', NULL),
            'fax' 	            => array('string', NULL),
            'email' 	        => array('email', NULL),
            'website'       	=> array('url', NULL),
            'dayint1'       	=> array('string', NULL),
            'dayint2'       	=> array('string', NULL),
            'dayint3'       	=> array('string', NULL),
            'dayint4'       	=> array('string', NULL),
            'workhrs1'       	=> array('string', NULL),
            'workhrs2'       	=> array('string', NULL),
            'workhrs3'       	=> array('string', NULL),
            'workhrs4'       	=> array('string', NULL),
            'curency'   	=> array('string', NULL),
            '1pkgname'   	=> array('string', NULL),
            '2pkgname'  	=> array('string', NULL),
            '3pkgname'    => array('string', NULL),
            '1pkgprice'     => array('string', NULL),
            '2pkgprice'     => array('string', NULL),
            '3pkgprice'      => array('string', NULL)
        ),
		'options' => array(
			'boxed' 	=> array('string', array('yes', 'no', 'blue')),
            'structure' 	=> array('string', array('map', 'strv', 'slider')),
			'footerText' => array('string', NULL),
            'centermap' => array('string', NULL),
            'addrcenter' => array('string', NULL),
            'CopyrightText' => array('string', NULL)
		),
		'js' => array(
			'adipoliStart' 	=> array('string', array('transparent', 'normal', 'overlay', 'grayscale')),
			'adipoliHover' 	=> array('string', array('normal', 'sliceDown', 'sliceDownLeft', 'sliceUp', 'sliceUpLeft', 'sliceUpRandom', 'sliceUpDown', 'sliceUpDownLeft', 'fold', 'foldLeft', 'boxRandom', 'boxRain', 'boxRainReverse', 'boxRainGrow', 'boxRainGrowReverse'))
		),
		'smtp' => array(
			'protocol' 	=> array('string', array('tls', 'ssl')),
			'host' 	=> array('string', NULL),
			'port' 	=> array('int', NULL),
			'username' => array('string', NULL),
			'password' => array('string', NULL)
		),
		'contact' => array(
			'method' 	=> array('string', array('mail', 'smtp')),
			'email' 	=> array('email', NULL),
			'subject' 	=> array('string', NULL)
		)

	);

	/**
	 * Get a unique instance of the class
	 *
	 * @return  fcvSettings
	 * @since  1.0
	 **/
	public static function get_Instance() {
		if(self::$instance === NULL) {
			self::$instance = new fcvSettings();
		}
		return self::$instance;
	}

	/**
	 * Constructor
	 *
	 * @return  void
	 * @since  1.0
	 **/
	private function __construct() {
		global $shortname;

		$this->shortname = $shortname;
		$this->fieldName = 'metrodir_'.$shortname.'_settings';

		//Add Ajax Settings Save
		add_action('wp_ajax_metrodir_settings_save', array( &$this, 'save'));
		add_action('wp_ajax_metrodir_file_upload', array( &$this, 'upload'));
		add_action('wp_ajax_metrodir_file_delete', array( &$this, 'deleteFile'));
		add_action('wp_ajax_send_mail_metrodir', array( &$this, 'sendmail'));
        add_action('wp_ajax_send_single_mail_metrodir', array( &$this, 'sendsinglemail'));
		add_action('wp_ajax_metrodir_smtp_test', array( &$this, 'smtpTestConnection'));
		add_action('wp_ajax_metrodir_update_log', array( &$this, 'updateLog'));
		add_action('wp_ajax_metrodir_update_check', array( &$this, 'checkUpdate'));

		//Load Resume
		$this->settings = get_option($this->fieldName);
		if(!is_array($this->settings)) {
			$this->settings = array();
		}

	}


	/**
	 * General Settings
	 *
	 * @return  Array
	 * @since   1.0
	 **/
	public function &get($context = '') {
		if($context && isset($this->settings[$context])) {
			return $this->settings[$context];
		}
		return $this->settings;
	}


	/**
	 * Send mail
	 *
	 *
	 * @return  void
	 * @since   1.0
	 **/
    public function sendmail() {

        $response = array();

        if (isset($_POST['name'])) {$name = $_POST['name'];}
        if (isset($_POST['email'])) {$email = $_POST['email'];}
        if (isset($_POST['message'])) {$mess = $_POST['message'];}
        if (empty($name))
        {
            $response['success'] = 201;
            $response['message'] = __('Please enter your name.', 'metrodir' );
            echo json_encode($response);
            die();
        }
        $pattern = "^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$^";

        if (!preg_match($pattern, $email))
        {
            $response['success'] = 201;
            $response['message'] = __('Please enter valid e-mail.','metrodir' );

            echo json_encode($response);
            die();
        }
        if (empty($mess))
        {
            $response['success'] = 201;
            $response['message'] = __('Please enter your message.', 'metrodir' );
            echo json_encode($response);
            die();
        }

        $to = get_option('opt_metrodir_email');
        $subject = get_option('opt_metrodir_email_sbj');
        $chrst = get_option('opt_metrodir_email_chrst');
        if(!$chrst){
            $chrst = "UTF-8";
        }
        $headers = 'Content-type: text/plain; charset = '.$chrst. "\r\n";
        $from_name = get_bloginfo('name');
        $from_email = get_option('opt_metrodir_email');
        if ($from_email) {
            $headers .= 'From: '.$from_name.' <'.$from_email.'>'. "\r\n";
        } else {
            $headers .= 'From: '.$from_name. "\r\n";
        }
        $message = "Name: $name \nE-mail: $email \nMessage: $mess";
        $send = mail ($to, $subject, $message, $headers);
        if ($send == 'true')
        {
            $response['success'] = 200;
            $response['message'] = __('Your message has been sent. Thank you!', 'metrodir' );
            echo json_encode($response);
            die();
        }
        else
        {
            $response['success'] = 201;
            $response['message'] = __('Your message has been sent. Thank you!', 'metrodir' );
            echo json_encode($response);
            die();
        }
    }


    public function sendsinglemail() {

        $response = array();

        if (isset($_POST['name'])) {$name = $_POST['name'];}
        if (isset($_POST['email'])) {$email = $_POST['email'];}
        if (isset($_POST['message'])) {$mess = $_POST['message'];}
        if (isset($_POST['website'])) {$subj = $_POST['website'];}
        if (isset($_POST['mailto'])) {$to = $_POST['mailto'];}

        if (empty($name))
        {
            $response['success'] = 201;
            $response['message'] = __('Please enter your name.', 'metrodir' );
            echo json_encode($response);
            die();
        }
        $pattern = "^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$^";

        if (!preg_match($pattern, $email))
        {
            $response['success'] = 201;
            $response['message'] = __('Please enter valid e-mail.','metrodir' );

            echo json_encode($response);
            die();
        }
        if (empty($mess))
        {
            $response['success'] = 201;
            $response['message'] = __('Please enter your message.', 'metrodir' );
            echo json_encode($response);
            die();
        }

        $subject = get_option('opt_metrodir_email_sbj').' > '.$subj;
        $chrst = get_option('opt_metrodir_email_chrst');
        if(!$chrst){
            $chrst = "UTF-8";
        }
        $headers = 'Content-type: text/plain; charset = '.$chrst. "\r\n";
        $from_name = get_bloginfo('name');
        $from_email = get_option('opt_metrodir_email');
        if ($from_email) {
            $headers .= 'From: '.$from_name.' <'.$from_email.'>'. "\r\n";
        } else {
            $headers .= 'From: '.$from_name. "\r\n";
        }
        $message = "Name: $name \nE-mail: $email \nSubject: $subj \nMessage: $mess";
        $send = mail ($to, $subject, $message, $headers);
        if ($send == 'true')
        {
            $response['success'] = 200;
            $response['message'] = __('Your message has been sent. Thank you!', 'metrodir' );
            echo json_encode($response);
            die();
        }
        else
        {
            $response['success'] = 201;
            $response['message'] = __('Your message has been sent. Thank you!', 'metrodir' );
            echo json_encode($response);
            die();
        }
    }


	/**
	 * Unlink A File
	 *
	 * @return  void
	 * @since   1.0
	 **/
	private function unlink_File($file, $context) {

		if (empty($context) || empty($file))
			throw new InvalidArgumentException(__('Invalid arguments', 'metrodir' ), 105);

		$dir = '';

		if($dir == '')
			throw new ErrorException(__('Context don\'t exist',  'metrodir'), 500);

		if(!in_array($file, $this->files[$context]))
			throw new ErrorException(__('File don\'t exists in context',  'metrodir'), 500);

		if(unlink($dir)) {
			$this->files[$context] = array();
			throw new Exception(__('File deleted.', 'metrodir'), 200);
		}
		throw new ErrorException(__('System can\'t delete file',  'metrodir'), 500);
	}


	/**
	 * Delete File
	 *
	 * @return  void
	 * @since   1.0
	 **/

	public function deleteFile() {

		if(!is_admin())
			die(__('Access denided',  'metrodir'));

		if (!current_user_can('edit_theme_options'))
        	die(__('Access denided',  'metrodir'));

		$response = array();

		try {

			$this->unlink_File($_POST['file'], $_POST['context']);

		} catch(InvalidArgumentException $ia) {
			$response['success'] = $ia->getCode();
			$response['message'] = $ia->getMessage();

		} catch(ErrorException $ee) {
			$response['success'] = $ee->getCode();
			$response['message'] = $ee->getMessage();

		}  catch(Exception $e) {
			$response['success'] = $e->getCode();
			$response['message'] = $e->getMessage();
		}

		echo json_encode($response);
		die();
	}


	/**
	 * Get List Files From A Directory
	 *
	 * @return  void
	 * @since   1.0
	 **/
	private function getFiles($dir, $ext = array()) {

		if(!sizeof($ext))
			$ext = array('jpg', 'jpeg', 'gif', 'png', 'pdf');
		$files = array();
		if ($handle = opendir($dir)) {
			while (false !== ($file = readdir($handle))) {
				$fext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
				if ($file != "." && $file != ".." && is_file($dir.DIRECTORY_SEPARATOR.$file) && in_array($fext, $ext)) {
					$files[] =  $file;
				}
			}
			closedir($handle);
		}

		return $files;
	}

	/**
	 * Upload Files
	 *
	 * @return  void
	 * @since   1.0
	 **/
	public function upload() {

		if (!current_user_can('edit_theme_options') || !is_admin())
        	die(__('Access denided', 'metrodir'));

		$file = NULL;
		$destination = '';
		$allowedExt = array();

		//Profile Photo
        if(isset($_FILES['photo'])) {

			$file = &$_FILES['photo'];
			$allowedExt = array('jpg', 'png', 'jpeg', 'gif');
			$destination = metrodir_IMAGES.DS.'logo.jpg';

		//Favicon
		}else if(isset($_FILES['favicon'])) {

			$file = &$_FILES['favicon'];
			$allowedExt = array('ico');
			$destination =  get_template_directory().'/favicon.ico';
		//Update File
		}else if(isset($_FILES['update'])) {

			$file = &$_FILES['update'];
			$allowedExt = array('zip');
			$destination = metrodir_TMP.DS.'latest_update.zip';
		}

		if($file == NULL)
        	die(__('No file !',  'metrodir'));

		if(!in_array(strtolower(pathinfo($file['name'], PATHINFO_EXTENSION)), $allowedExt))
			die(__('Extension not allowed, allowed extentions : ',  'metrodir').print_r($allowedExt, true));

        //Error List
		if (!is_uploaded_file($file['tmp_name'])) {
			switch($file['error']){
				case 0: //no error;
				  die(__("There was a problem with your upload.",  'metrodir'));
				case 1: //uploaded file exceeds the upload_max_filesize directive in php.ini
				  die(__("The file you are trying to upload is too big.",  'metrodir'));
				case 2: //uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the html form
				  die(__("The file you are trying to upload is too big.",  'metrodir'));
				case 3: //uploaded file was only partially uploaded
				  die(__("The file you are trying upload was only partially uploaded.",  'metrodir'));
				case 4: //no file was uploaded
				  die(__("You must select an image for upload.",  'metrodir'));
				default: //a default error, just in case!  :)
				  die(__("There was a problem with your upload.",  'metrodir'));
			}
		}

		if (!move_uploaded_file($file['tmp_name'], $destination))
			die(__("Unknown error",  'metrodir'));

		if(isset($_FILES['bgfile'])) {
			//Refresh Background List
			unset($this->files['backgrounds']);

		}else if(isset($_FILES['update'])) {
			// Set correct file permissions
			@ chmod( $destination, 0755);

			$this->runUpdate();
		}

		die('200');
	}

	/**
	 * Validate Fields
	 *
	 * @return  boolean
	 * @since   1.0
	 */
	private function validate(&$value, $type) {
		if(empty($value)) return true;
		switch($type) {
			case 'backgrounds':
				return in_array($value, $this->getBackgroundImages());
			case 'email':
				return filter_var($value, FILTER_VALIDATE_EMAIL);
			case 'url':
    			return filter_var($value, FILTER_VALIDATE_URL);
			case 'color':
    			return preg_match('/^[a-f0-9]{6}$/i', $value);
			case 'js':
				$value = str_replace("'", '"', $value);
				return true;
			case 'date':
    			return true;

		}
		return true;
	}

	/**
	 * Save Submited Settings
	 *
	 *
	 * @return  void
	 * @since   1.0
	 */
	public function save() {

		if (!current_user_can('edit_theme_options') || !is_admin())
        	die(__('Access denided',  'metrodir'));

		$response = array();
		$invalidInputs = array();

		try {

			// Verify And Proper Authorization
			if ( !wp_verify_nonce( $_POST['noncename_metrodir'], 'metrodir_settings_save'))
				throw new InvalidArgumentException(__('Invalid security code',  'metrodir'), 300);

			/************************
			*	     Profile        *
			************************/
			if(isset($_POST['profile']) && is_array($_POST['profile'])) {
				$this->settings['profile'] = array();
				foreach($_POST['profile'] as $name => $value) {
					$possibleFields = array_keys($this->white_list['profile']);
					if(in_array($name, $possibleFields)) {
						$fieldType = $this->white_list['profile'][$name][0];
						$possibleValues = $this->white_list['profile'][$name][1];
						if(($possibleValues === NULL || in_array($value, $possibleValues)) && $this->validate($value, $fieldType))
							$this->settings['profile'][$name] = esc_attr(stripslashes($value));
						else
							$invalidInputs[] = array($name, $fieldType);
					}
				}
			}
				
			/************************
			*	     Social         *
			************************/
			if(isset($_POST['social']) && is_array($_POST['social'])) {
				$this->settings['social'] = array();
				foreach($_POST['social'] as $name => $value) {
					$possibleFields = array_keys($this->white_list['social']);
					if(in_array($name, $possibleFields)) {
						$fieldType = $this->white_list['social'][$name][0];
						$possibleValues = $this->white_list['social'][$name][1];
						if(($possibleValues === NULL || in_array($value, $possibleValues)) && $this->validate($value, $fieldType))
							$this->settings['social'][$name] = esc_attr(stripslashes($value));
						else
							$invalidInputs[] = array($name, $fieldType);
					}
				}
			}

            /************************
             *	     metrodir CO      *
             ************************/
            if(isset($_POST['metrodircompany']) && is_array($_POST['metrodircompany'])) {
                $this->settings['metrodircompany'] = array();
                foreach($_POST['metrodircompany'] as $name => $value) {
                    $possibleFields = array_keys($this->white_list['metrodircompany']);
                    if(in_array($name, $possibleFields)) {
                        $fieldType = $this->white_list['metrodircompany'][$name][0];
                        $possibleValues = $this->white_list['metrodircompany'][$name][1];
                        if(($possibleValues === NULL || in_array($value, $possibleValues)) && $this->validate($value, $fieldType))
                            $this->settings['metrodircompany'][$name] = esc_attr(stripslashes($value));
                        else
                            $invalidInputs[] = array($name, $fieldType);
                    }
                }
            }


				
			/************************
			*	         JS         *
			************************/
			if(isset($_POST['js']) && is_array($_POST['js'])) {
				$this->settings['js'] = array();
				foreach($_POST['js'] as $name => $value) {
					$possibleFields = array_keys($this->white_list['js']);
					if(in_array($name, $possibleFields)) {
						$fieldType = $this->white_list['js'][$name][0];
						$possibleValues = $this->white_list['js'][$name][1];
						if(($possibleValues === NULL || in_array($value, $possibleValues)) && $this->validate($value, $fieldType))
							$this->settings['js'][$name] = esc_attr(stripslashes($value));
						else
							$invalidInputs[] = array($name, $fieldType);
					}
				}
			}
				
			/************************
			*	     Options        *
			************************/
			if(isset($_POST['options']) && is_array($_POST['options'])) {
				$this->settings['options'] = array();
				foreach($_POST['options'] as $name => $value) {
					$possibleFields = array_keys($this->white_list['options']);
					if(in_array($name, $possibleFields)) {
						$fieldType = $this->white_list['options'][$name][0];
						$possibleValues = $this->white_list['options'][$name][1];
						if($possibleValues === NULL || in_array($value, $possibleValues)) {
							if($this->validate($value, $fieldType))
								$this->settings['options'][$name] = esc_attr(stripslashes($value));
							else {
								$this->settings['options'][$name] = '';
								$invalidInputs[] = array($name, $fieldType);
							}
						} 
					}
				}
			}
			
			/************************
			*	     SMTP           *
			************************/
			if(isset($_POST['smtp']) && is_array($_POST['smtp'])) {
				$this->settings['smtp'] = array();
				foreach($_POST['smtp'] as $name => $value) {
					$possibleFields = array_keys($this->white_list['smtp']);
					if(in_array($name, $possibleFields)) {
						$fieldType = $this->white_list['smtp'][$name][0];
						$possibleValues = $this->white_list['smtp'][$name][1];
						if($possibleValues === NULL || in_array($value, $possibleValues)) {
							if($this->validate($value, $fieldType))
								$this->settings['smtp'][$name] = esc_attr(stripslashes($value));
							else {
								$this->settings['smtp'][$name] = '';
								$invalidInputs[] = array($name, $fieldType);
							}
						} 
					}
				}
			}
			
			/************************
			*	     Contact        *
			************************/
			if(isset($_POST['contact']) && is_array($_POST['contact'])) {
				$this->settings['contact'] = array();
				foreach($_POST['contact'] as $name => $value) {
					$possibleFields = array_keys($this->white_list['contact']);
					if(in_array($name, $possibleFields)) {
						$fieldType = $this->white_list['contact'][$name][0];
						$possibleValues = $this->white_list['contact'][$name][1];
						if($possibleValues === NULL || in_array($value, $possibleValues)) {
							if($this->validate($value, $fieldType))
								$this->settings['contact'][$name] = esc_attr(stripslashes($value));
							else {
								$this->settings['contact'][$name] = '';
								$invalidInputs[] = array($name, $fieldType);
							}
						} 
					}
				}
			}
				
			/************************
			*	     Skills         *
			************************/
			if(isset($_POST['skills-sections']) && is_array($_POST['skills-sections'])) {
				$this->settings['skills'] = array();
				$i = 0;
				
				//Fill Sections
				foreach($_POST['skills-sections'] as $key => $section) {
					$this->settings['skills'][$i] 			= array();
					$this->settings['skills'][$i]['title'] 	= esc_attr(stripslashes($section['title']));

                    if(isset($section['display']))
                        $this->settings['skills'][$i]['display'] = ($section['display']== 'on') ? 1 : 0;
					else
                        $this->settings['skills'][$i]['display'] = 0;

                            //Fill Skills
					$this->settings['skills'][$i]['skills'] = array();
					if(is_array($section['skills'])) {
						$j = 0;
						foreach($section['skills'] as $sKey => $skill) {
							$this->settings['skills'][$i]['skills'][$j] = array();
							$this->settings['skills'][$i]['skills'][$j]['title'] = esc_attr($skill['title']);
                            $this->settings['skills'][$i]['skills'][$j]['description'] = esc_attr($skill['description']);
							$this->settings['skills'][$i]['skills'][$j]['rats'] = intval(stripslashes($skill['rats']));
							$j++;
						}
					}
					$i++;
				}
			}
			
			/************************
			*	     Resume         *
			************************/
			if(isset($_POST['resume']) && is_array($_POST['resume'])) {
				$this->settings['resume'] = array();
				$i = 0;
				
				//Fill Sections
				foreach($_POST['resume'] as $key => $section) {
					$this->settings['resume'][$i] 			= array();
					$this->settings['resume'][$i]['title'] 	= esc_attr(stripslashes($section['title']));
					
					//Fill Resume Section
					$this->settings['resume'][$i]['items'] = array();
					if(is_array($section['items'])) {
						$j = 0;
						foreach($section['items'] as $iKey => $item) {
							$this->settings['resume'][$i]['items'][$j] = array();
							$this->settings['resume'][$i]['items'][$j]['title'] = esc_attr(stripslashes($item['title']));
							$this->settings['resume'][$i]['items'][$j]['date'] 	= esc_attr(stripslashes($item['date']));
							$this->settings['resume'][$i]['items'][$j]['place'] = esc_attr(stripslashes($item['place']));
							$this->settings['resume'][$i]['items'][$j]['desc'] 	= esc_attr(stripslashes($item['desc']));
							$j++;
						}
					}
					$i++;
				} 
			}

			throw new Exception(__('Your all changes have been saved.',  'metrodir'), 200);
			
		} catch(InvalidArgumentException $ia) {
			$response['success'] = $ia->getCode();
			$response['message'] = $ia->getMessage();
			
		} catch(Exception $e) {
			$response['success'] = $e->getCode();
			$response['message'] = $e->getMessage();
			
			update_option($this->fieldName, $this->settings);	
		}
		
		$response['inputs'] = &$invalidInputs;
		echo json_encode($response);
		
		
		die();
	}	
	
}