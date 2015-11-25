# xkcd: Hoverboard (Comic 1608)
This repository holds the HTML necessary to render the full version of the xkcd 1608 comic scene. The scene will take 30+ seconds to load because of all the images it has to import.

## Statistics
Width
* 179 images
* 91,827 pixels

Height
* 43 images
* 22,059 pixels

## HTML File
Save the HTML locally on your computer and then load the file in your browser. Loads all the PNG files associated with the comic.

## PHP File
Requires a connection to a MySQL database. I did this to reduce the number of CURL requests I made while figuring out just how big the original XKCD image is.

### MySQL Schema
* id (INT 11)
* fileX (INT 11)
* fileY (INT 11)
* exist (INT 1)

### Output
An HTML table with bullets in the cells where CURL finds an image (.png) on XKCD. Some of these images are white boxes. All the images are 513 x 513 pixels. When CURL does not find an image, the exists flag goes to 0.
