<?php
/**
 * Created by PhpStorm.
 * User: Daniel Eaton
 * Date: 10/18/2016
 * Time: 10:44 PM
 *
 *The Profile Class is made to hold all values needed to accurately produce reddit content while showing information about the users who make reddit comments.
 *
 */
class Profile {
	/**
	 * Global Variables
	 * @var string $profileUsername reddit Username
	 * @var string $profileTeam reddit User's Favorite NFL team
	 * @var string profileFirstName reddit User's First Name
	 * @var string profileLastName reddit Users Last Name
	 * @var string profileEmail reddit User's Email Address
	 * @var int profileId  reddit User's Profile Identification Number
	 *
	 */
	private $profileUsername;
	private $profileTeam;
	private $profileFirstName;
	private $profileLastName;
	private $profileEmail;
	private $profileId;


	/**
	 * Profile constructor.
	 * @param $profileUsername String to identify a user by his reddit Username
	 * @param $profileTeam String to get information of a user's favorite team for team flair
	 * @param $profileFirstName String User's first name
	 * @param $profileLastName String user's last name
	 * @param $profileEmail String user's email address
	 * @param $profileId int User's database Identification Number
	 */
	public function __construct($profileUsername, $profileTeam, $profileFirstName, $profileLastName, $profileEmail, $profileId) {
		$this->profileUsername = $this->setProfileUsername($profileUsername);
		$this->profileTeam = $this->setProfileTeam($profileTeam);
		$this->profileFirstName = $this->setProfileFirstName($profileFirstName);
		$this->profileLastName = $this->setProfileLastName($profileLastName);
		$this->profileEmail = $this->setProfileEmail($profileEmail);
		$this->profileId = $this->setprofileId($profileId);
	}

		/**Returns the Value of profileTeam
	 *
	 * @return String $profileTeam the users favorite team flair
	 */
	public function getProfileTeam() {
		return $this->profileTeam;
	}

	/**
	 * Sets the value of profileTeam and validates it using the static method validateFlair().
	 * @param $userInput string Must be two characters in length, will be validated before input. The user input will be sent to $profileTeam
	 * @throws Exception if $userInput is not set to a String value
	 */
	public function setProfileTeam($userInput) {
		if(!is_string($userInput)){
			throw new Exception('The value submitted is not a String');
		}
		try{
			$userInput = filter_var($userInput, FILTER_SANITIZE_STRING);
			if(Profile::validateProfileTeam($userInput)) {
				$this->profileTeam = $userInput;
			}
			else {
				$this->profileTeam = Profile::setProfileTeam($userInput);
			}}
		catch(Exception $e){
			$e->getMessage();
		}
	}


	/**
	 * Returns the profileUsername string value
	 * @return String profileUsername the users reddit username
	 */
	public function getProfileUsername(){
		return $this->profileUsername;
	}

	/**
	 *
	 * Sets the value of profileUsername()
	 * @param $inputUsername string  Is used to change the input of Profile Username, sanitized before passed.
	 * @throws Exception if $inputUsername is not set to a String
	 */
	private function setProfileUsername($inputUsername){
		if(!is_string($inputUsername)){
			throw new Exception('The value for inputUsername is not a String');
		}
		try {
			$this->profileUsername = filter_var($inputUsername, FILTER_SANITIZE_STRING);
		}
		catch(Exception $e){
			$e->getMessage();
		}
	}

	/**
	 * Returns the integer value of profileId
	 *
	 * @return int profileId() the users profileId set by mySQL
	 */
	public function getProfileId() {
		return $this->profileId;
	}

	/**
	 * Sets the value of setProfileId
	 * @param $userProfileId int used to set profileId to a new number, sanitized before passing
	 * @throws Exception if value of $userProfileId is not an integer
	 */
	private function setprofileId($userProfileId) {
		if(!is_int($userProfileId)) {
			throw new Exception('The value of $userProfileId is not an integer');
		}
		try {
			$this->profileId = filter_var($userProfileId, FILTER_SANITIZE_NUMBER_INT);
		} catch(Exception $e){
			$e->getMessage();
		}
	}

	/**
	 * Returns the string value of firstName
	 *
	 * @return String returns The user's first name.
	 */
	public function getProfileFirstName(){
		return $this->profileFirstName;
	}

	/**
	 * Sets the value of profileFirstName
	 * @param $inputFirstName string The parameter used to change profileFirstName
	 * @throws Exception if value of inputFirstName has not been set to a String
	 */
	public function setProfileFirstName($inputFirstName){
		if(!is_string($inputFirstName)){
			throw new Exception("inputFirstName has not been set to a String");
		}
		try{
		$this->profileFirstName = filter_var($inputFirstName);
		}catch(Exception $e){
			$e->getMessage();
		}
	}

	/**
	 * Returns the value of profileLastName
	 * @return String returns the user's last name.
	 */
	public function getProfileLastName() {
		return $this->profileLastName;
	}

	/**
	 * Sets the value of profileLastName
	 * @param $inputLastName string The parameter used to change profileFirstName
	 * @throws Exception if value of inputFirstName has not been set to a String
	 */
	public function setProfileLastName($inputLastName){
		if(!is_string($inputLastName)){
			throw new Exception("inputLastName has not been set to a String");
		}
		try{
			$this->profileFirstName = filter_var($inputLastName);
		}catch(Exception $e){
			$e->getMessage();
		}
	}


	/**
	 * Returns the value of profileEmail
	 * @return String returns the profile Email
	 */
	public function getProfileEmail() {
		return $this->profileEmail;
	}

	/**
	 * Sets the value of profileEmail
	 * @param $userInputEmail string that will be passed into $profileEmail if a user wants to change their password
	 * @throws Exception if $userInputEmail is not a String
	 */
	public function setProfileEmail($userInputEmail) {
		if(!is_string($userInputEmail))
		{
			throw new Exception("The value returned is not a String");
		}
		try {
			$userInputEmail = filter_var($userInputEmail, FILTER_SANITIZE_STRING);
			$userInputEmail = filter_var($userInputEmail, FILTER_VALIDATE_EMAIL);
			$this->profileEmail = $userInputEmail;
		} catch(Exception $e){
			$e->getMessage();
		}
	}

	/**
	 * Validates the value of profileTeam
	 * @param $userInputFlair string The user input that will validated for a proper Flair value for profileTeam
	 * @return bool The value returned after $userInput has been tested
	 * @throws Exception if userInputFlair is longer than 2 characters.
	 */
	public static function validateProfileTeam($userInputFlair) {
		//The Result that will be returned at the end of the function
		$result = false;
		//Array that stores valid NFL team codes.
		$nflTeams = array(
			'NE', //Patriots
			'DA', //Cowboys
			'PE', //Eagles
			'DB', //Broncos
			'PS', //Steelers
			'MV', //Vikings
			'NG', //Giants
			'SS', //Seahawks
			'OR', //Raiders
			'GB', //Packers
			'SF', //49ers
			'LA', //Rams
			'AZ', //Cardinals
			'CP', //Panthers
			'WR', //Redskins
			'CB', //Bears
			'NJ', //Jets
			'BR', //Ravens
			'SD', //Chargers
			'BB', //Bills
			'HT', //Texans
			'CL', //Browns
			'NO', //Saints
			'AL', //Falcons
			'DL', //Lions
			'IC', //Colts
			'TB', //Buccaneerss
			'BE', //Bengals
			'KC', //Chiefs
			'JJ', //Jaguars
			'MD', //Dolphins
			'TT', //Titans
		);

		if(strlen($userInputFlair) == 2) {
			//accepts string length
			for($i = 0; $i < 32; $i++) {

				if($userInputFlair == $nflTeams[$i]) {
					//Sets result to true, in order to return true if string matches with a valid team in nflTeams
					$result = true;
				} else {
					//Sets result to false, in order to return false if string is invalid but has the correct length
					$result = false;
				}
			}
		} else {
			//Sets result to false, in order to return false for invalid string length
			throw new Exception("The value of profileTeam is too long");
		}
		return $result;
	}
}