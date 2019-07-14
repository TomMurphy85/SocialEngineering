/*
This Document will re-create the current mySQL Database for the socialEngineering web application.
The Application uses a LAMP stack and relies on properly configured SQL backend.
This list was last updated on June 5th, 2019
- Tom Murphy
*/
/*Create Social Engineering Database*/
CREATE DATABASE `socialEngineering`

CREATE TABLE `createEvent` (
  `eventID` int(11) NOT NULL AUTO_INCREMENT,
  `eventCreator` varchar(45) NOT NULL,
  `eventName` varchar(45) NOT NULL,
  `eventDate` date NOT NULL,
  `eventTime` varchar(45) NOT NULL,
  `eventPassword` varchar(45) DEFAULT NULL,
  `Comments` longtext,
  `eventPhase` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`eventID`),
  UNIQUE KEY `eventID_UNIQUE` (`eventID`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

CREATE TABLE `eventHistory` (
  `eventID` int(11) NOT NULL AUTO_INCREMENT,
  `Location` varchar(45) NOT NULL,
  `eventCreator` varchar(45) NOT NULL,
  `dateVisited` date NOT NULL,
  `usersInvited` longtext NOT NULL,
  PRIMARY KEY (`eventID`),
  UNIQUE KEY `ID_UNIQUE` (`eventID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `Users` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `userEmail` varchar(45) NOT NULL,
  `userPassword` varchar(45) NOT NULL,
  PRIMARY KEY (`userID`),
  UNIQUE KEY `userID_UNIQUE` (`userID`),
  UNIQUE KEY `userEmail_UNIQUE` (`userEmail`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;



CREATE TABLE `voterInfo` (
  `voteID` int(11) NOT NULL AUTO_INCREMENT,
  `eventID` varchar(45) NOT NULL,
  `userVote` varchar(45) DEFAULT NULL,
  `voterEmail` varchar(45) NOT NULL,
  `userAttending` tinytext,
  `userComment` longtext,
  `userSubmission` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`voteID`),
  UNIQUE KEY `ID_UNIQUE` (`voteID`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;


