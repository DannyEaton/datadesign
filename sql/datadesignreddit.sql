
-- Checks to see if Tables exists and deletes them if they do.
DROP TABLE IF EXISTS comment;
DROP TABLE IF EXISTS profile;

-- Creates the Profile Table
CREATE TABLE profile (
-- Username
	profileName VARCHAR(20) UNIQUE NOT NULL,
-- Flair
	profileTeam VARCHAR(2),
-- Profile Id, Primary Key that Auto Increments
	profileId SMALLINT unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY UNIQUE,
-- Email, First Name, Last Name
	profileEmail VARCHAR(254) NOT NULL,
	profileFirstName VARCHAR(35),
	profileLastName VARCHAR(35),
	INDEX(profileName)
);

-- Creates the Comment Table
CREATE TABLE comment (
-- commentId, primary key that auto increments
	commentId MEDIUMINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT UNIQUE ,
-- Comment that this comment is replying to, AKA the parent comment
	commentParentId MEDIUMINT UNSIGNED,
-- Profile that is making this comment
	commentProfileId SMALLINT UNSIGNED not NULL,
-- The score of the user, upvotes - downvotes = vote score
	commentVoteScore MEDIUMINT SIGNED NOT NULL,
-- Time comment was made, timestamp
	commentTime TIMESTAMP not NULL,
-- Textual Content of the Comment'
	commentText VARCHAR(10000) NOT NULL,

	-- Adds Foreign Keys to commentProfileId and commentParentId as well as indexes
	FOREIGN KEY(commentProfileId) REFERENCES profile(profileId),
	FOREIGN KEY(commentParentId) REFERENCES comment(commentId),
	INDEX(commentId),
	INDEX(commentparentId)
);

-- Test
INSERT INTO profile(profileName, profileFirstName, profileLastName, profileTeam, profileEmail)
VALUES ('Test','Test','Test', 'TT','test@test.com');

INSERT INTO comment(commentProfileId,commentVoteScore,commentParentId, commentText)
VALUES (1,15,NULL,'test test test test');