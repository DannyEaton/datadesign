<?php
/**
 * Created by PhpStorm.
 * User: Daniel Eaton
 * Date: 10/18/2016
 * Time: 10:44 PM
 */

//Includes the Profile.php file
require 'Profile.php';

class Comment extends Profile {

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



	private $profile;

	/**
	 * Comment constructor.
	 * @param $commentId int the parameter that will be passed into commentId
	 * @param $commentParentId int the parameter that will be passed into commentParentId
	 * @param $commentProfileId int the parameter that will be passed into commentProfileId
	 * @param $commentVoteScore int the parameter that will be passed into commentProfileId
	 * @param $commentTime int the parameter that will be passed into commentTime
	 * @param $commentText string the parameter that will be passed into commentText
	 */
	public function __construct($commentId, $commentParentId, $commentProfileId, $commentVoteScore, $commentTime, $commentText) {
		$this->commentId = $this->setCommentId($commentId);
		$this->commentParentId = $this->setCommentParentId($commentParentId);
		$this->commentProfileId = $this->setCommentProfileId($commentProfileId);
		$this->commentVoteScore = $this->setCommentVoteScore($commentVoteScore);
		$this->commentTime = $this->setCommentTime($commentTime);
		$this->commentText = $this->setCommentText($commentTime);
		$this->profile = clone $profile;

	}

	/**
	 * returns value of commentId
	 *
	 * @return int returns the comment identification number
	 */
	public function getCommentId() {
		return $this->commentId;
	}

	/**
	 * Sets value of CommmentId
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
		return $this->commentParentId;
	}

	/**
	 * Sets the value of commentParentId
	 * @param $commentParentInput int Theinput that will be sanitized and passed to commentParentId
	 * @throws Exception "This Value is Not an Integer" when input value is not an integer
	 */
	private function setCommentParentId($commentParentInput) {
		if(!is_int($commentParentInput))
			throw new Exception("This value is not an Integer");
		try {
			$this->commentParentId = filter_var($commentParentInput, FILTER_SANITIZE_NUMBER_INT);
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
		return $this->commentProfileId;
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
		return $this->commentVoteScore;
	}

	/**
	 * Sets the value of commentVoteScore
	 * @param $userVote int The input that will be passed into the commentVoteScore property. It will also be sanitized before it is passed.
	 * @throws Exception if $userVote is set to a value other than int
	 */
	public function setCommentVoteScore($userVote) {
		if(!is_int($userVote)) {
			throw new Exception("The value entered is not an integer");
		}
		try {
			$userVote = filter_var($userVote, FILTER_SANITIZE_NUMBER_INT);
			$this->commentVoteScore = $userVote;
		} catch(Exception $e) {
			$e->getMessage();
		}
	}

	/**
	 * Returns the value of commentTime()
	 * @return datetime returns the comment's time stamp in milliseconds from
	 */
	public function getCommentTime() {
		return $this->commentTime;
	}

	/**
	 * Sets the value of commentTime
	 * @param $userTimeInput
	 * @throws Exception of $userTimeInput is set to a value that is not DateTime
	 */
	public function setCommentTime($userTimeInput) {
		if(!is_a($userTimeInput, 'DateTime')) {
			throw new Exception("This value is not a DateTime");
		}

		try {
			$this->commentTime = $userTimeInput;
		} catch(Exception $e) {
			$e->getMessage();
		}

	}

	/**
	 * Returns the string value of commentText
	 * @return string returns the comment Text()
	 */
	public function getCommentText() {
		return $this->commentText;
	}

	/**
	 * Sets the input of commentText
	 * @param $textInput string The text that will be input to be validized ands anitized, then sent to the commentText property
	 * @throws Exception if the String Length of $textInput is too long
	 */
	public function setCommentText($textInput) {
		//
		if(strlen($textInput > 10000)) {
			$result = filter_var(FILTER_SANITIZE_STRING);
		} else {
			throw new Exception("Error: Comment is too long");
		}
		$this->commentText = $result;
	}

}