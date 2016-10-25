<?php
/**
 * Created by PhpStorm.
 * User: Daniel Eaton
 * Date: 10/18/2016
 * Time: 10:44 PM
 */

//Includes the Profile.php file
require 'Profile.php';

class Comment{

	/**
	 * @var int commentId The Comment Identification number used to identify it in the database
	 */
		private $commentId;
	/**
	 * @var int commentParentId The Comment Identification number this comment is replying to
	 */
		private $commentParentId;
	/**
	 * @var int commentProfileId The Profile Identification number of the User who made the comment
	 */
		private $commentProfileId;
	/**
	 * @var int commentVoteScore The Score of the comment measured by upvotes subtracted by downvotes
	 */
		private $commentVoteScore;

	/**
	 * @var datetime commentTime The Time the comment was made
	 */
		private $commentTime;

	/**
	 * @var string commentText The text and actual content of the comment itself
	 *
	 */
		private $commentText;

	/**
	 * Comment constructor.
	 * @param $commentParentId int the parameter that will be passed into commentParentId
	 * @param $commentProfileId int the parameter that will be passed into commentProfileId
	 * @param $commentVoteScore int the parameter that will be passed into commentProfileId
	 * @param $commentText string the parameter that will be passed into commentText
	 * @throws InvalidArgumentException if the user has tried to pass invalid arguements in the parameter
	 * @throws OutOfRangeException if the values passed to this function are out of Range
	 */
	public function __construct($commentParentId, $commentProfileId, $commentVoteScore, $commentText) {
		try {
			$this->commentParentId = $this->setCommentParentId($commentParentId);
			$this->commentProfileId = $this->setCommentProfileId($commentProfileId);
			$this->commentVoteScore = $this->setCommentVoteScore($commentVoteScore);
			$this->commentText = $this->setCommentText($commentText);
			$this->setCommentId($this->constructPDO($this->commentParentId, $this->commentProfileId, $this->commentVoteScore,$this->commentText));
		}catch(InvalidArgumentException $e){
			throw(new InvalidArgumentException($e->getMessage()));
		}catch(OutOfRangeException $e){
			throw(new OutOfRangeException($e->getMessage()));
		}catch(Exception $e){
			throw (new Exception($e->getMessage()));
		}
	}

	/**
	 * returns value of commentId
	 *
	 * @return int returns the comment identification number
	 */
	public function getCommentId() {
		return $this->pdoRetrieve('commentId');
	}

	/**
	 * Sets value of CommmentId. INTENDS TO NEVER BE USED. EVER
	 *
	 * @param $commentIdInput int Input that will be sanitized and passed through to the commentId property
	 * @throws Exception 'This number is not an integer' when user tries to enter in a value other than an int
	 */
	private function setCommentId($commentIdInput) {
		if(!is_int($commentIdInput)) {
			throw new Exception("This number is not an Integer");
		}
		try {
			$this->commentId = filter_var($commentIdInput, FILTER_SANITIZE_NUMBER_INT);
		} catch(Exception $e) {
			$e->getMessage();
		}
	}

	/**
	 * Returns value of commentParentId
	 * @return int returns the commentParent identification) number
	 */
	public function getCommentParentId() {
		return $this->pdoRetrieve('commentParentId');
	}

	/**
	 * Sets the value of commentParentId
	 * @param $commentParentInput int Theinput that will be sanitized and passed to commentParentId
	 * @throws InvalidArgumentException if the input value is not an integer
	 * @throws Exception if an otherwise unspecified error occurs
	 */
	private function setCommentParentId($commentParentInput) {
		if(!is_int($commentParentInput))
			throw new InvalidArgumentException("This value is not an Integer");
		try {
			$this->commentParentId = filter_var($commentParentInput, FILTER_SANITIZE_NUMBER_INT);
			if(!$this->commentId === null) {
				$this->pdoUpdate('commentParentId', $this->commentParentId);
			}
		} catch(Exception $e) {
			$e->getMessage();
		}

	}

	/**
	 * Returns the value of commentProfileId
	 *
	 * Returns the value of commentProfileId
	 * @return int returns the comment profile identification number
	 */
	public function getCommentProfileId() {
		return $this->pdoRetrieve('commentProfileId');
	}

	/**
	 * Sets the value of commentProfileId
	 * @param $userInputId int the number that will be sanitized and passed through to the commentProfileId
	 * @throws Exception If user has antered a value that is not an integer
	 */
	private function setCommentProfileId($userInputId) {
		if(!is_int($userInputId)) {
			throw new Exception("The value entered is not an integer");
		}
		try {
			$this->commentProfileId = filter_var($userInputId, FILTER_SANITIZE_NUMBER_INT);
			if(!$this->commentId == null) {
				$this->pdoUpdate('commentProfileId', $this->commentProfileId);
			}
		} catch(Exception $e) {
			$e->getMessage();
		}
	}

	/**
	 * Returns the commentVoteScore
	 *
	 * @return int returns the comment vote score
	 */
	public function getCommentVoteScore() {
		return $this->pdoRetrieve('commentVoteScore');
	}

	/**
	 * Sets the value of commentVoteScore
	 * @param $userVote int The input that will be passed into the commentVoteScore property. It will also be sanitized before it is passed.
	 * @throws InvalidArgumentException if $userVote is set to a value other than int
	 */
	public function setCommentVoteScore($userVote) {
		if(!is_int($userVote)) {
			throw new InvalidArgumentException("The value entered is not an integer");
		}
		try {
			$userVote = filter_var($userVote, FILTER_SANITIZE_NUMBER_INT);
			$this->commentVoteScore = $userVote;
			if(!$this->commentId == null) {
				$this->pdoUpdate('commentVoteScore', $this->commentVoteScore);
			}
		} catch(Exception $e) {
			$e->getMessage();
		}
	}

	/**
	 * Returns the value of commentTime()
	 * @return DateTime returns the comment's time stamp in milliseconds from
	 */
	public function getCommentTime() {
		return $this->pdoRetrieve('commentTime');
	}

	/**
	 * TIMESTAMPED, INTENDS TO NEVER BE USED
	 *
	 * Sets the value of commentTime
	 * @param $userTimeInput
	 * @throws InvalidArgumentException of $userTimeInput is set to a value that is not DateTime
	 * @throws Exception if an uthor
	 */
	public function setCommentTime($userTimeInput) {
		if(!is_a($userTimeInput, 'DateTime')) {
			throw new InvalidArgumentException("This value is not a DateTime Or TimeStamp");
		}
		try {
			$this->commentTime = $userTimeInput;
			if(!$this->commentId==null) {
				$this->pdoUpdate('commentTime', $this->commentTime);
			}
		} catch(Exception $e) {
			throw(new Exception($e->getMessage()));
		}

	}

	/**
	 * Returns the string value of commentText
	 * @return string returns the comment Text()
	 */
	public function getCommentText() {
		return $this->pdoRetrieve('commentText');
	}

	/**
	 * Sets the input of commentText
	 * @param $textInput string The text that will be input to be validized ands anitized, then sent to the commentText property
	 * @throws Exception if the String Length of $textInput is too long
	 */
	public function setCommentText($textInput) {
		//
		try{
		if(strlen($textInput < 10000)) {
			$result = filter_var(FILTER_SANITIZE_STRING);
		} else {
			throw new OutofRangeException("Error: Comment is too long");
		}

			$this->commentText = $result;
			if(!$this->commentId == null) {
				$this->pdoUpdate('commentText', $this->commentText);
			}
		}catch(Exception $e){
			throw(new Exception($e->getMessage()));
		}
	}

	/**
	 * @param $commentParentId int The commentId of the comment this comment is replying too
	 * @param $commentProfileId int The profileId of the profile making this comment
	 * @param $commentVoteScore int The score of the comment measured in (Upvote-Downvote = commentVoteScore)
	 * @param $commentTime DateTime The time at which this comment was made (inserted into comment table
	 * @param $commentText string The actual text content of this comment
	 * @return int The profileId of the ocmment once it has been inserted
	 * @throws PDOException if there os a [rpb;e, regarding the php data object (connection, mysql statements etc.)
	 * @throws InvalidArgumentException if the user has entered in non-legitimate arguments
	 * @throws Exception if an otheriwse unspecified error has occured
	 */
	private function constructPDO($commentParentId, $commentProfileId, $commentVoteScore, $commentText){
		try{
			//Initialize php data object
			$pdo = new PDO('mysql:host=fakeServer; dbname= fakeComment', 'fakeUsername', 'fakePassword;charset=utf-8');
			$statement = $pdo->prepare('INSERT INTO comment (commentProfileId,commentVoteScore,commentParentId, commentText) VALUES (:commentProfileId, :commentVoteScore, :commentParentId, :commentText)');
			//apply input from user and then send to database
			$statement->bindParam(':commentProfileId', $commentProfileId);
			$statement->bindParam(':commentVoteScore', $commentVoteScore);
			$statement->bindParam(':commentParentId', $commentParentId);
			$statement->bindParam(':commentText', $commentText);
			$statement->execute();

			//return Id of inserted comment
			return intval($pdo->lastInsertId());
		}catch(PDOException $e){
			throw(new PDOException($e->getMessage()));
		}catch(InvalidArgumentException $e){
			throw(new InvalidArgumentException($e->getMessage()));
		}catch(Exception $e){
			throw(new Exception($e->getMessage()));
		}
	}

	/**
	 * The pdoUpdate() function will update values in the mysql database representing this object
	 *
	 * @param $setValue string|int|DateTime The kind value that will be changed in the comment table
	 * @param $newValue string|int|DateTime The new value that will be replacing the previous one in the comment Table
	 * @throws Exception PDOException if there is a problem regarding the php data object such as connection or mysql statements
	 * @throws InvalidArgumentException the arguments passsed into this function are illegitimate
	 * @throws Exception if an otherwise unspecified error has occured
	 *
	 */
	private function pdoUpdate($setValue, $newValue){
		try {
			//Initialize php data object
			$pdo = new PDO('mysql:host=fakeServer; dbname= fakeComment', 'fakeUsername', 'fakePassword;charset=utf-8');
			$statement = $pdo->prepare('UPDATE comment SET :setValue = :newValue WHERE commentId = :commentId');
			$statement->bindParam(':setValue', $setValue);
			$statement->bindParam(':newValue', $newValue);
			$statement->bindParam(':commentId', $this->commentId);
		}catch(PDOException $e){
			throw(new PDOException($e->getMessage()));
		}catch(InvalidArgumentException $e){
			throw(new InvalidArgumentException());
		}catch(Exception $e){
			throw(new Exception($e->getMessage()));
		}
	}

	/**
	 * @param $retrieveValue string The property  that will be retrieved
	 * @return mixed The value that was retrieved by the php data object determined by $retrieveValue
	 *@throws PDOException If there was a connectiono error or mysql error
	 *throws Exception if an otherwise unspecified error occured
	 */
	private function pdoRetrieve($retrieveValue){
		//Initialize php data object
		try{
		$pdo = new PDO('mysql:host=fakeServer; dbname= fakeComment', 'fakeUsername', 'fakePassword;charset=utf-8');
		$statement = $pdo->prepare('SELECT :retrieveValue FROM comment WHERE comment = :commentId');
		$statement->bindParam(':retrieveValue',$retrieveValue);
		$statement->bindParam(':profileId',$this->commentId);
		$row = $statement->execute();
		return $row[0];
		}catch(PDOException $e){
		throw(new PDOException($e->getMessage()));
		}catch(Exception $e){
		throw(new Exception($e->getMessage()));
		}
	}
}