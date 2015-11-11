#digital-logsheets

A web-based application for tracking the playback of audio segments on a community radio station. Developed by Michael Dean and Evan Vassallo for CKUT 90.3FM in Montréal, Canada. Driven by PHP, MySQL and the Smarty templating system.

##Assumptions

###Purpose

This application aims to serve the following CKUT 90.3FM stakeholders in the following ways:

1. Programmers: More convenient reporting of program content as required by station policy
2. Station directors: Quicker tracking and monitoring of airplay statistics
3. Listeners: Find out what content was played during a specific time on-air

This application will strive to be a complete replacement of the current paper logsheet system.

###Requirements

These requirements are divided up by the stakeholders they would most affect. Separate interfaces would likely need to be created for each of these sections, but all features (if applicable) should read from and write to the same database.

####Programmers
Achieve a balance of browser compatibility and accessibility in terms of ability to use the digital-logsheets tool.

Allow programmers to enter the following data about their programs into an online form:

- Basic metadata (program, air date/time, pre-record date, notes)
- For each individual audio segment: start time, station-defined category, CanCon, New Rel, French Vocal, Request

Each individual audio segment should also have the following information attached, depending on its station-defined category:

- (1 spoken word, 4 musical productions) whether an ID was given, optional few words of description
- (2 general music, 3 jazz, classical & traditional music) artist, album, song (all can be written free-form)
- (5 ads, promos) station-defined ad number

Information input into a logsheet entry in progress should not be lost if something goes wrong (e.g. loss of connection, accidentally pressing back button, etc.)

####Station Directors

Ability to edit already submitted logsheets

Within 10 seconds, view the following statistics for each program over the course of any number of episodes or time period:

- Absolute and relative (as a percentage of total airtime) duration of Canadian Content by station-defined category (2 and 3)
- Number of IDs given per episode
- Frequency of ad play, as a total and by ad number

####Listeners

The listener-facing interface is currently outside the scope of this project. A future interface should be able to draw the following information from the digital-logsheets database:

- By program episode or by time range, a segment-by-segment listing of all spoken word and music segments (i.e., IDs, ads, and promos should not be visible to the listener). Each segment listing should show the segment start time and its (artist/album/song) info or description, depending on the segment type.

####Future Requirements

- Quick way for programming directors to check for small human errors in a digital logsheet submission
- If ad ID numbers are stored in a database, link these to digital-logsheet submissions

##Questions

- Could theme/interview section on paper logsheet be replaced by the more general "episode notes" section?
- Is it safe to assume that all category 4 entries are ID?
- Safe to measure duration of each segment by the differences between segment start times?
- Should programmers be able to revise logsheets they have already submitted?
- How should logsheet submission be protected? For security purposes, logsheet form should not be totally accessible to the public, but per-user password login may make digital logsheet adoption more difficult.
- Is keeping statistics per programmer important? Should each individual programmer have their own ID to be used on each logsheet? Or can programmer entry be just a single line that won't need to be retrieved later?
- For music segments, is it imperative that all song description fields (i.e., artist, album, song) be filled? Some programmers do not fill in all three fields.
- Is the ability to see how many times a given song played over the course of all programs important? If so, (artist/album/song) fields likely shouldn't be entirely free-form (e.g., a 'suggestion list' similar to what a search engine might provide) to avoid miscalculating statistics
