# Darcy's Record Collection
A simple record collection webpage made with Bootstrap 5.1 & Custom PHP Scripts.<br>
__This isn't intended for other people to just drag and drop onto their own webserver, this is purely so I can track my changes - but of course, feel free to edit and adapt this if you please to do so: all I'm saying is that it might take a bit of fiddling around with to get working correctly.__

## **Hosted Site:**
https://records.darcyjprojects.xyz

## **Screenshots:**
Partial screenshot as of 24/08/2022
![Demo Screenshot](https://records.darcyjprojects.xyz/assets/img/demoscreenshot.png)

## **Album Database Format:**
It's not really a database, but lets just call it that...<br>
**Separators:**
```
":" separates fields
"|" separates albums/releases for that database
```
**Database Structure:**
```
Title:Description:Description 2:Media Condition:Sleeve Condition:imagename:discogsID|repeat this again for the next release
```
* Ensure that the last item in the database doesn't end with the separator "|" - only use this inbetween releases.
* The image should be stored in a folder in the same directory as the database txt file with the same name as the txt file (without the "database.txt")
<br>**EXAMPLE:**
<br>File = .\database\pm_album_database
<br>Images are stored in .\database\pm_album
```
Red Rose Speedway:1973 Stereo Australian Gatefold Release:Apple Records = PCTC 251:VG+:VG+:redrosespeedway.jpg:5625229|Flaming Pie:2020 Stereo Half Speed Master 180 Gram 2x Record Box Set:MPL/Capitol Records/Universal Music Group - 00602508617720:NM+:NM+:flamingpie.jpg:15701948|Tug Of War:1982 Stereo Australian Release:Parlophone/MPL - PCTP 259:VG+:NM:tugofwar.jpg:15295699
```
