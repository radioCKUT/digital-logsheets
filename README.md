#digital-logsheets

A web-based application for tracking the playback of audio segments on a community radio station. Developed by Michael Dean and Evan Vassallo for CKUT 90.3FM in Montréal, Canada. Driven by PHP, MySQL and the Smarty templating system.

##Purpose

This application aims to serve the following CKUT 90.3FM stakeholders:

1. Programmers: More convenient reporting of program content as required by station policy
2. Station directors: Greater logsheet completeness, more timely logsheet submission, and quicker tracking and monitoring of airplay statistics
3. Listeners: Find out what content was played during a specific time on-air

It will also reduce paper waste created by the current paper system. In its first iteration, programmers should be able to complete all their logging via the application (i.e. they won't need to log any segments on a paper logsheet any more).

##Project goals

These goals are divided up by the stakeholders they would most affect. Separate interfaces would likely need to be created for each of these sections, but all features (if applicable) should read from and write to the same database.

###Programmers
Maximize use of webpage accessibility features while remaining compatible with the computer in the Master Control Room.

Allow programmers to enter the following data about their programs into an online form:

- Basic metadata (program, air date/time, pre-record date, notes)
- One line for the names of each programmer to be input free-form. Programmer names will not be associated with a given id for stats purposes at this stage.
- For each individual audio segment: start time, station-defined category, CanCon, New Rel, French Vocal. Request column on paper logsheet will not be replicated in the application as that column no longer relevant to log. Using the differences between segment start times to calculate segment durations is accpetable.

Each individual audio segment should also have the following information attached, depending on its station-defined category:

- (1 spoken word, 4 musical productions) whether an ID was given, optional few words of description
- (2 general music, 3 jazz, classical & traditional music) artist, album, song. Each of these fields can be entered free-form. Each of these fields is required, and the form should not submit if a category 2 or 3 segment does not have all of these fields filled.
- (5 ads, promos) station-defined ad number

Information input into a logsheet entry in progress should not be lost if something goes wrong (e.g. loss of connection, accidentally pressing back button, etc.)

Logsheet submission page will be username/password protected using the existing user database employed by the music library database and the reservation system. Will not be able to move on this requirement until new IT Adminstrator begins work.

It's okay for programmer digital-logsheet submissions to be final (i.e., they cannot edit them after submission).

###Station Directors

Ability to edit already submitted logsheets

Within 10 seconds, view the following statistics for each program over the course of any number of episodes or time period:

- Absolute and relative (as a percentage of total airtime) duration of Canadian Content by station-defined category (2 and 3)
- Number of IDs given per episode
- Frequency of ad play, as a total and by ad number

###Listeners

The listener-facing interface is currently outside the scope of this project. A future interface should be able to draw the following information from the digital-logsheets database:

- By program episode or by time range, a segment-by-segment listing of all spoken word and music segments (i.e., IDs, ads, and promos should not be visible to the listener). Each segment listing should show the segment start time and its (artist/album/song) info or description, depending on the segment type.
- WFMU's (station in New York) interface would be a good model.

###Future Requirements

- Quick way for programming directors to check for small human errors in a digital logsheet submission
- Save half-filled logsheet for programmer to fill out later
- Offer suggestions for artist/album/song fields to reduce chance of human error
- Ability for station directors to edit already-submitted logsheets
- Programmers are given an id in the database, so stats can also be generated by individual programmer

- Set up so programmers log their shows in real-time so CKUT website could show what is "now playing"

##Other Notes
- First draft of this application should be complete by late January, early February 2016
- Ad numbers and numbering system is kept on paper, so it will not be integrated into the digital-logsheets application.
- The "interview/theme" section of the logsheet is not used - usually programmers include this information in the segment description.
- Category 4 doesn't just apply to station IDs, also for musical jingles some programmers create
