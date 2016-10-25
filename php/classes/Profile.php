<?php
/**
 * Created by PhpStorm.
 * User: Daniel Eaton
 * Date: 10/18/2016
 * Time: 10:44 PM
 * @version 1.0.2
 *
 *The Profile Class is made to hold all values needed to accurately produce reddit content while showing information about the users who make reddit comments.
 *
 */
class Profile {
	//Global Variables

	/**
	 * @var string $profileUsername reddit Username
	 */
	private $profileUsername;

	/**
	* @var string $profileTeam reddit User's Favorite NFL team
	 */
	private $profileTeam;

	/**
	 * @var string profileFirstName reddit User's First Name
	 */
	private $profileFirstName;

	/**
	 * @var string profileLastName reddit Users Last Name
	 */
	private $profileLastName;

	/**
	 * @var string profileEmail reddit User's Email Address
	 */
	private $profileEmail;

	/**
	* @var int profileId  reddit User's Profile Identification Number
	 *
	 */
	private $profileId;

	/**
	 * Profile constructor.
	 * Sets the values of using mutator methods of profileUsername, profileTeam, profileEmail, profileFirstName, and profileLastName
	 * The constructor then proceeds to set the value of profileId using its mutator method with the constructPDO method returns the profileID of the new User that it just inserted into the profile table.
	 *
	 * @param $profileUsername String to identify a user by his reddit Username
	 * @param $profileTeam String to get information of a user's favorite team for team flair
	 * @param $profileFirstName String User's first name
	 * @param $profileLastName String user's last name
	 * @param $profileEmail String user's email address
	 * @throws InvalidArgumentException If there is an invalid argument passed into a parameter
	 * @throws RangeException If there is a variable out of range passed into a parameter
	 * @throws TypeError If there is a variable of the wrong type passed into a parameter
	 * @throws Exception If there is an undected Exception when preforming construction of a profile instance
	 */
	public function __construct($profileUsername, $profileTeam, $profileFirstName, $profileLastName, $profileEmail) {
		try {
			$this->profileUsername = $this->setProfileUsername($profileUsername);
			$this->profileTeam = $this->setProfileTeam($profileTeam);
			$this->profileFirstName = $this->setProfileFirstName($profileFirstName);
			$this->profileLastName = $this->setProfileLastName($profileLastName);
			$this->profileEmail = $this->setProfileEmail($profileEmail);
			//Sends Aformentioned parameters after being sanitized and verified to PDO to be inserted into profile Table. Returns the ID of this new profile row into profileId
			$this->setprofileId($this->constructPDO($this->getProfileUsername(), $this->getProfileTeam(), $this->getProfileEmail(), $this->getProfileFirstName(), $this->getProfileLastName()));
		}
		//catches Invalid Argument Exception and Displays Message
		catch(\InvalidArgumentException $e){
			throw(new InvalidArgumentException($e->getMessage()));
		}
		//catches Range Exception and displays message
		catch(\RangeException $e){
			throw(new InvalidArgumentException($e->getMessage()));
		}
		//catches TypeError Exception and displays message
		catch(\TypeError $e){
			throw(new TypeError($e->getMessage()));
		}
		//catches generic Exception and displays message
		catch(\Exception $e) {
			throw(new Exception($e->getMessage()));
		}
	}

		/**Returns the Value of profileTeam
	 *
	 * @return String $profileTeam the users favorite team flair
	 */
	public function getProfileTeam() {
		return $this->pdoRetrieve('profileTeam');
	}

	/**
	 * Sets the value of profileTeam and validates it using the static method validateFlair().
	 * @param $userInput string Must be two characters in length, will be validated before input. The user input will be sent to $profileTeam
	 * @throws TypeError if a value with type other than string has been passed into this funciton
	 * @throws Exception if otherwise unspecified error occurs
	 */
	public function setProfileTeam($userInput) {
		if(!is_string($userInput)){
			throw(new TypeError());
		}
		try{
			$userInput = filter_var($userInput, FILTER_SANITIZE_STRING);
			if(Profile::validateProfileTeam($userInput)) {
				$this->profileTeam = $userInput;
				$this->pdoUpdate('profileTeam',$this->profileTeam);
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
		return $this->pdoRetrieve('profileUsername');
	}

	/**
	 *
	 * Sets the value of profileUsername()
	 * @param $inputUsername string  Is used to change the input of Profile Username, sanitized before passed.
	 * @throws TypeError if a type other than String has been passed into this function
	 * @throws Exception if an otherwise unspecified error has occured
	 */
	private function setProfileUsername($inputUsername){
		if(!is_string($inputUsername)){
			throw(new TypeError());
		}
		try {
			$this->profileUsername = filter_var($inputUsername, FILTER_SANITIZE_STRING);
			$this->pdoUpdate('profileUsername',$this->profileUsername);
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
		return $this->pdoRetrieve('profileId');
	}

	/**
	 * Sets the value of setProfileId INTENDS TO NEVER BE USED, EVER!!!!!!!!!!!!!!!!!
	 * @param $userProfileId int used to set profileId to a new number, sanitized before passing
	 * @throws TypeError if variable that is not an int is passed into this function
	 * @throws Exception if an otherwise unspecified error has occured
	 */
	private function setprofileId($userProfileId) {
		if(!is_int($userProfileId)) {
			throw(new TypeError());
		}
		try {
			$this->profileId = filter_var($userProfileId, FILTER_SANITIZE_NUMBER_INT);
		}
		catch(Exception $e){
			throw(new Exception($e->getMessage()));
		}
	}

	/**
	 * Returns the string value of firstName
	 *
	 * @return String returns The user's first name.
	 */
	public function getProfileFirstName(){
		return $this->pdoRetrieve('profileFirstName');
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
		$this->pdoUpdate('profileFirstName',$this->profileFirstName);
		}catch(Exception $e){
			$e->getMessage();
		}
	}

	/**
	 * Returns the value of profileLastName
	 * @return String returns the user's last name.
	 */
	public function getProfileLastName() {
		return $this->pdoRetrieve('profileLastName');
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
			$this->profileLastName = filter_var($inputLastName);
			$this->pdoUpdate('profileLastName',$this->profileLastName);
		}catch(Exception $e){
			$e->getMessage();
		}
	}


	/**
	 * Returns the value of profileEmail
	 * @return String returns the profile Email
	 */
	public function getProfileEmail() {
		return $this->pdoRetrieve('profileEmail');
	}

	/**
	 * Sets the value of profileEmail
	 * @param $userInputEmail string that will be passed into $profileEmail if a user wants to change their password
	 * @throws TypeError if $userInputEmail is a type other than string
	 * @throws Exception if an error has occurred
	 */
	public function setProfileEmail($userInputEmail) {
		if(!is_string($userInputEmail))
		{
			throw(new TypeError());
		}
		try {
			$userInputEmail = filter_var($userInputEmail, FILTER_SANITIZE_STRING);
			$userInputEmail = filter_var($userInputEmail, FILTER_VALIDATE_EMAIL);
			$this->pdoUpdate('profileEmail',$userInputEmail);
		}catch(Exception $e){
			throw(new Exception($e->getMessage()));
		}
	}

	/**
	 * Validates the value of profileTeam
	 * @param $userInputFlair string The user input that will validated for a proper Flair value for profileTeam
	 * @return bool The value returned after $userInput has been tested
	 * @throws OutOfRangeException if userInputFlair is longer than 2 characters.
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
			throw(new OutOfRangeException());
		}
		return $result;
	}

	/**
	 * @param $profileUsername string The profile's username that will be inserted into the profile table
	 * @param $profileTeam string The profile's team abbreviation that will be inserted into the profile table
	 * @param $profileEmail string The profile's email that will be inserted into the profile table
	 * @param $profileFirstName string The profile's first name that will be inserted into the profile table
	 * @param $profileLastName string The profile's last name that will be inserted into the profile table
	 * @return int The profileId of the profile that has just been inserted into the table
	 * @throws PDOException if an error regarding the Php Data Object occurs
	 * @throws InvalidArgumentException if an invalid argument has been passed as a parameter into this function
	 * @throws Exception if an Exception that hasn't been detected is thrown
	 */
	private function constructPDO($profileUsername, $profileTeam, $profileEmail, $profileFirstName, $profileLastName) {
		try {
			$pdo = new PDO('mysql: host=fakeServer; dbname= fakeDbName', 'fakeUsername', 'fakePassword');
			$statement = $pdo->prepare('INSERT profile (profileUsername, profileTeam, profileEmail, profileFirstName, profileLastName) VALUES (:profileUsername, :profileTeam, :profileEmail, :profileFirstName, :profileLastName)');
			$statement->bindParam(':profileUsername',$profileUsername);
			$statement->bindParam(':profileTeam', $profileTeam);
			$statement->bindParam(':profileEmail', $profileEmail);
			$statement->bindParam(':profileFirstName', $profileFirstName);
			$statement->bindParam(':profileLastName',$profileLastName);
			$statement->execute();

			//return last row's profileId
			return intval($pdo->lastInsertId());
		}
		catch(PDOException $e){
			throw(new PDOException($e->getMessage()));
		}
		catch(InvalidArgumentException $e){
			throw(new InvalidArgumentException($e->getMessage()));
		}
		catch(Exception $e){
			throw(new Exception($e->getMessage()));
		}
	}

	/**
	 * @param $updateSet string The profile row value that will be changed
	 * @param $newValue string The value that will be changed in the changed profile row value
	 * @throws PDOException if there is an error regarding the php data object
	 * @throws Exception if an otherwise unspecified error occurs
	 */
	private function pdoUpdate($updateSet,$newValue){
		//initialize php data object
		try {
			$pdo = new PDO('mysql:host=fakeServer; dbname= fakeProfile', 'fakeUsername', 'fakePassword;charset=utf-8');
			//Dont know why this is showing a warning, will have to ask Dylan Rochelle or Jordan
			$statement = $pdo->prepare('UPDATE profile SET :updateSet = :newValue where profileID = :profileId');
			$statement->bindParam(':updateValue', $updateSet);
			$statement->bindParam(':newValue', $newValue);
			$statement->bindParam(':profileId', $this->profileId);
			$statement->execute();
		} catch(PDOException $e){
			throw(new PDOException($e->getMessage()));
		} catch(Exception $e){
			throw(new PDOException($e->getMessage()));
		}
	}

	/**
	 * Retrieves a row value from the profile table. Used in get methods
	 *
	 * @param $retrieveValue string The value in the specified row that will be retrieved
	 * @return mixed The value that has been fetched from the query
	 */
	private function pdoRetrieve($retrieveValue){
		try{
			$pdo = new PDO('mysql:host=fakeServer; dbname= fakeProfile', 'fakeUsername', 'fakePassword;charset=utf-8');
			$statement = $pdo->prepare('SELECT :retrieveValue FROM profile WHERE profileId = :profileId');
			$statement->bindParam(':retrieveValue',$retrieveValue);
			$statement->bindParam(':profileId',$this->profileId);
			$row = $statement->execute();
			return $row[0];
		}catch(PDOException $e){
			throw(new PDOException($e->getMessage()));
		}catch(Exception $e){
			throw(new PDOException($e->getMessage()));
		}
	}
}