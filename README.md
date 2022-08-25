# Darcy's Record Collection
A simple record collection webpage made with Bootstrap 5.1 & Custom PHP Scripts.<br>
__This isn't intended for other people to just drag and drop onto their own webserver, this is purely so I can track my changes - but of course, feel free to edit and adapt this if you please to do so: all I'm saying is that it might take a bit of fiddling around with to get working correctly.__

## **Hosted Site:**
https://records.darcyjprojects.xyz

## **Screenshots:**
Partial Screenshot:
![Demo Screenshot](https://records.darcyjprojects.xyz/assets/img/demoscreenshot_26082022_1.png)
Updated 25/08/2022

## **Album Database Format:**
It's not really a database, but lets just call it that...<br>
**Separators:**
```
":" separates fields
```
**Album Database Structure:**
```
Release 1 Title:Description:Description:Media Condition:Sleeve Condition:imagename:discogsID
Release 2 Title:Description:Media Condition:Sleeve Condition:imagename:discogsID
```
* The image should be stored in a folder in the same directory as the database txt file with the same name as the txt file (without the "database.txt")
<br>**EXAMPLE:**
<br>File = .\database\pm_album_database.txt
<br>Images are stored in .\database\pm_album
```
Red Rose Speedway:1973 Stereo Australian Gatefold Release:Apple Records = PCTC 251:VG+:VG+:redrosespeedway.jpg:5625229
Flaming Pie:2020 Stereo Half Speed Master 180 Gram 2x Record Box Set:MPL/Capitol Records/Universal Music Group - 00602508617720:NM+:NM+:flamingpie.jpg:15701948
```
**Album List Structure:**
```
Release 1 Title:Description:t/f
Release 2 Title:Description:t/f
```
*the third index entry of t/f is to indicate whether the item is in your collection (t = yes, f = no)
*you can add the entry "br:br" if you'd like to insert a break between items
<br>**EXAMPLE:**
<br>File = .\database\pm_album_list_database.txt
```
McCartney (1970):f
Red Rose Speedway (1973):t
br:br
Flaming Pie (1997):t
```
