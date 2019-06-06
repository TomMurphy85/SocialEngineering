/*
This Document will re-create the current mySQL Database for the socialEngineering web application.
The Application uses a LAMP stack and relies on properly configured SQL backend.
This list was last updated on June 5th, 2019
- Tom Murphy
*/
/*Create Social Engineering Database*/
CREATE DATABASE `socialEngineering`

/*createEvent*/
DROP TABLE IF EXISTS `createEvent`;
CREATE TABLE `createEvent` (
  `eventID` int(11) NOT NULL,
  `eventCreator` varchar(45) NOT NULL,
  `eventName` varchar(45) NOT NULL,
  `eventDate` date NOT NULL,
  `eventTime` varchar(45) NOT NULL,
  `requiresPassword` tinyint(4) NOT NULL,
  `eventPassword` varchar(45) DEFAULT NULL,
  `Comments` longtext,
  PRIMARY KEY (`eventID`),
  UNIQUE KEY `eventID_UNIQUE` (`eventID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*eventDetails*/
DROP TABLE IF EXISTS `eventDetails`;
CREATE TABLE `eventDetails` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Date` date NOT NULL,
  `Time` varchar(45) NOT NULL,
  `Summary` longtext,
  `eventLogin` varchar(45) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Users*/
DROP TABLE IF EXISTS `Users`;
CREATE TABLE `Users` (
  `userID` int(11) NOT NULL,
  `userName` varchar(45) NOT NULL,
  `userEmail` varchar(45) DEFAULT NULL,
  `userPassword` varchar(45) NOT NULL,
  `userRoll` varchar(45) CHARACTER SET big5 NOT NULL,
  `userActive` varchar(45) NOT NULL,
  PRIMARY KEY (`userID`),
  UNIQUE KEY `userName_UNIQUE` (`userName`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*votingHistory*/
DROP TABLE IF EXISTS `votingHistory`;
CREATE TABLE `votingHistory` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Location` varchar(45) NOT NULL,
  `enteredBy` varchar(45) NOT NULL,
  `dateVisited` date NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID_UNIQUE` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*votingOptions*/
DROP TABLE IF EXISTS `votingOptions`;
CREATE TABLE `votingOptions` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Location` varchar(45) NOT NULL,
  `enteredBy` varchar(45) NOT NULL,
  `userAttending` tinytext NOT NULL,
  `userComment` longtext,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID_UNIQUE` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;


